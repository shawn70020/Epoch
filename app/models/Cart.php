<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['uid', 'pid', 'num','addtime','delete_at'];
}
