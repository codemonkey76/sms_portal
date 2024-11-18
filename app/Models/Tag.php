<?php

namespace App\Models;

use App\Enums\RetentionUnit;
use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;
    use Searchable;

    public array $searchable = ['name'];


    protected $casts = [
        'retention_unit' => RetentionUnit::class
    ];
    protected $fillable = ['name', 'retention_duration', 'retention_unit', 'customer_id'];
    public function retentionDate($createdDate)
    {
        return match($this->retention_unit) {
            RetentionUnit::Days => $createdDate->copy()->addDays($this->retention_duration),
            RetentionUnit::Weeks => $createdDate->copy()->addWeeks($this->retention_duration),
            RetentionUnit::Months => $createdDate->copy()->addMonths($this->retention_duration),
            RetentionUnit::Years => $createdDate->copy()->addYears($this->retention_duration),
        };
    }

    public function messages(): BelongsToMany
    {
        return $this->belongsToMany(Message::class);
    }

    public function templates(): BelongsToMany
    {
        return $this->belongsToMany(Template::class);
    }

    public function getRetentionPolicyAttribute(): string
    {
        return "{$this->retention_duration} " . Str::plural($this->retention_unit->value, $this->retention_duration);
    }
}
