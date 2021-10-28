<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    public function wallet() {
        return $this->belongsTo(Wallet::class)->first();
    }

    public function storic() {
        return $this->hasMany(Storic::class);
    }
}
