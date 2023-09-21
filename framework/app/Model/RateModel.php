<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RateModel extends Model
{
    protected $table = 'rate';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'category',
        'wdwa_1_2',
        'wdwa_3_6',
        'wdwa_7_15',
        'wdwa_16_30',
        'wdwa_1_2_sd',
        'wdwa_3_6_sd',
        'wdwa_7_15_sd',
        'wdwa_16_30_sd',
        'wdoa_1_2',
        'wdoa_3_6',
        'wdoa_7_15',
        'wdoa_16_30',
        'wdoa_1_2_sd',
        'wdoa_3_6_sd',
        'wdoa_7_15_sd',
        'wdoa_16_30_sd',
        'wdwa_da',
        'wdwa_fuel',
        'wdwa_dka',
        'wdwa_dkr',
        'wdoa_da',
        'wdoa_dra',
        'wdoa_km',
        'wdoa_dka',
        'wdoa_dkr',
        'hourly',
        'hourly_2',
        'hourly_3',
        'hourly_4',
        'hourly_sd',
        'hourly_da',
        'ins_1_2',
        'ins_3_6',
        'ins_7_15',
        'ins_16_30',
        'deleted',
    ];
}