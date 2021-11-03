<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description'
    ];

    public function assets() {
        return $this->hasMany(Asset::class);
    }
}
