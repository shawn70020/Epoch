<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Orderinfo extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['oid', 'name', 'phone','address','note','payment'];

    public function insertDetail($_iOid, $_aAddress)
    {
        ## 參數初始化
        $iOid = (int) $_iOid;
        $sName = $_aAddress['name'];
        $iPhone = $_aAddress['phone'];
        $sAddress = $_aAddress['address'];
        $sNote = $_aAddress['note'];
        $sPayment = $_aAddress['payment'];

        ## 新增訂單資訊
        $info = new Orderinfo;
        $info->oid = $iOid;
        $info->name = $sName;
        $info->phone = $iPhone;
        $info->address = $sAddress;
        $info->note = $sNote;
        $info->payment = $sPayment;
        $info->save();
    }
}
