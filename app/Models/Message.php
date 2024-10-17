<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        return static::where('created_at', '<=', now()->subYears(config('app.retention')));
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
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
