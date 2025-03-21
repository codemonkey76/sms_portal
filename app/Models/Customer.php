<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Jetstream\HasProfilePhoto;

class Customer extends Model
{
    use HasFactory;
    use HasProfilePhoto;

    protected $fillable = ['name', 'senderId'];

    protected $appends = ['profile_photo_url'];

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function lists(): HasMany
    {
        return $this->hasMany(ContactList::class);
    }

    public function templates(): HasMany
    {
        return $this->hasMany(Template::class);
    }
}
