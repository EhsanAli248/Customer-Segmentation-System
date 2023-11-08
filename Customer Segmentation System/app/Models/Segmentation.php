<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Segmentation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'min_order_count',
        'min_amount_spent',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
