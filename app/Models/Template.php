<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Template extends Model
{
    use HasFactory;

    public $appends = ['excerpt'];

    protected $fillable = [
        'description',
        'content',
        'customer_id',
    ];

    public function getExcerptAttribute()
    {
        return Str::limit($this->content, 40, '...');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
