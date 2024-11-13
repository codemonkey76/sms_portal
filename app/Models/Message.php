<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Message extends Model
{
    use HasFactory;
    use Prunable;

    public $timestamps = false;

    protected $appends = ['excerpt'];

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'dateCreated' => 'datetime',
            'dateUpdated' => 'datetime',
            'is_archived' => 'boolean',
        ];
    }

    public function prunable()
    {
        $defaultRetentionDate = now()->subYears(config('app.retention'));

        return static::where(fn($query) =>
            $query->whereDoesntHave('tags')
                ->where('dateCreated', '<=', $defaultRetentionDate)
        )->orWhereHas('tags', fn($q) =>
            $q->where(fn($q) =>
                $q->where(fn($q) =>
                    $q->where('tags.retention_unit', 'days')
                        ->whereRaw('DATE_ADD(messages.dateCreated, INTERVAL tags.retention_duration DAY) <=?', [now()])
                )->orWhere(fn($q) =>
                        $q->where('tags.retention_unit', 'weeks')
                            ->whereRaw('DATE_ADD(messages.dateCreated, INTERVAL tags.retention_duration WEEK) <=?', [now()])
                )->orWhere(fn($q) =>
                    $q->where('tags.retention_unit', 'months')
                        ->whereRaw('DATE_ADD(messages.dateCreated, INTERVAL tags.retention_duration MONTH) <=?', [now()])
                )->orWhere(fn($q) =>
                    $q->where('tags.retention_unit', 'years')
                        ->whereRaw('DATE_ADD(messages.dateCreated, INTERVAL tags.retention_duration YEAR) <=?', [now()])
                )
            )
        );
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getExcerptAttribute(): string
    {
        return Str::limit($this->body, 40, '...');
    }

    public function archive()
    {
        $this->update(['is_archived' => true]);
    }

    public function unarchive()
    {
        $this->update(['is_archived' => false]);
    }
}
