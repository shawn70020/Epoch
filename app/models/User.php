<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // protected $table = 'users';
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['email', 'passwd', 'name','birthday','sex'];
}
