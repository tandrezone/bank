<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storic extends Model
{
    use HasFactory;
    protected $fillable = [
        'asset_id',
        'set',
        'gain_value',
        'gain_percentage'
    ];
    public function asset() {
        return $this->belongsTo(Asset::class)->first();
    }
}
