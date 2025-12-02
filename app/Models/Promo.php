<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'discount_percentage', 'valid_until', 'branch_admin_id'];

    public function branchAdmin()
    {
        return $this->belongsTo(User::class, 'branch_admin_id');
    }
}
