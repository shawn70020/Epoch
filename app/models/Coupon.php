<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
class Coupon extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['code','discount', 'expiry_date', 'is_enabled'];
}
