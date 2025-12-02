<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Machine extends Model
{
    use HasFactory;

    protected $fillable = ['machine_id', 'location', 'status', 'availability', 'payment_status', 'branch_admin_id'];

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    public function branchAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'branch_admin_id');
    }
}
