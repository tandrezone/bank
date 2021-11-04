<?php

namespace App\Models;

use App\Services\Crypto;
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

    public static function zask() {
        $assets = self::orderBy('wallet_id')->orderBy('coin')->get();
        $table = [];
        $totalPrice = 0;
        $totalGain = 0;
        $totalBuy = 0;
        foreach ($assets as $asset) {
            if(in_array($asset->coin,crypto::KNOWN_SYMBOLS)) {
                $crypto = new Crypto();
                $coinPrice = $crypto->getRate($asset->coin . 'BTC', true);
                $assetPrice = $coinPrice * $asset->value;
                $totalPrice += $assetPrice;
                $gain = round($assetPrice - $asset->buy, 2);
                $totalGain += $gain;
                $gainPercentage = round(($assetPrice - $asset->buy) / ($asset->buy / 100), 1);
                $totalBuy += $asset->buy;
                $table[] = [$asset->wallet()->name, $asset->coin, $asset->value, round($assetPrice,2), $gain, $gainPercentage];

            }
            else {
                $totalPrice += $asset->value;
                $table[] = [$asset->wallet()->name, $asset->coin, $asset->value, "", "",""];
            }
        }
        return [$table, $totalPrice, $totalGain];
    }
}
