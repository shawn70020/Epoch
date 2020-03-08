<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\Product;

class Orderdetail extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['oid', 'pid', 'num'];
}
