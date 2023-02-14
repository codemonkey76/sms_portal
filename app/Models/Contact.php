<?php

namespace App\Models;

use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory, Searchable;

    public array $searchable = ['first_name', 'last_name', 'company_name', 'number'];

    protected $guarded = [];

    public function list(): BelongsTo
    {
        return $this->belongsTo(ContactList::class, 'contact_list_id');
    }
}
