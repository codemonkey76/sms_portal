<?php

namespace App\Models;

use App\Scopes\NotArchivedScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Message extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $casts = [
        'dateCreated' => 'datetime',
        'dateUpdated' => 'datetime',
        'is_archived' => 'boolean'
    ];

    protected $appends = ['excerpt'];

    protected $guarded = [];

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
