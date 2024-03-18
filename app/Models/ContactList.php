<?php

namespace App\Models;

use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContactList extends Model
{
    use HasFactory, Searchable;

    public array $searchable = ['name'];

    protected $guarded = [];

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
}
