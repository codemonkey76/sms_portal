<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'isAdmin',
        'isActive',
        'current_customer_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'isAdmin' => 'boolean',
        'isActive' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    //    public function customer(): BelongsTo
    //    {
    //        return $this->belongsTo(Customer::class);
    //    }

    public function allCustomers(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class);
    }

    public function currentCustomer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'current_customer_id');
    }

    public function isCurrentCustomer(?Customer $customer): bool
    {
        return $this->current_customer_id === $customer->id;
    }

    public function switchCustomer(Customer $customer): bool
    {
        if (! $this->belongsToCustomer($customer)) {
            return false;
        }

        $this->forceFill([
            'current_customer_id' => $customer->id,
        ])->save();

        $this->setRelation('currentCustomer', $customer);

        return true;
    }

    public function belongsToCustomer(Customer $customer)
    {
        return $this->allCustomers->contains(fn ($c) => $c->id === $customer->id);
    }

    public function selectedCustomer(Customer $customer): bool
    {
        return $this->current_customer_id === $customer->id;
    }

    public function attachCustomer($customer)
    {
        $this->allCustomers()->syncWithoutDetaching($customer);

        if (is_null($this->current_customer_id)) {
            $this->update(['current_customer_id' => $customer]);
        }
    }

    public function detachCustomer($customer)
    {
        $this->allCustomers()->detach($customer);

        $this->update(['current_customer_id' => optional($this->allCustomers()->first())->id]);
    }
}
