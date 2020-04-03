<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\Orderdetail;
use App\models\Product;
use App\models\Cart;
use App\models\Coupon;
use Illuminate\Support\Carbon;

class Order extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['uid', 'total', 'delivery','status', 'addDate','shipDate','doneDate','closeDate'];

    public function addOrder($_iUid, $_aCart, $_iTotal, $_sDelivery, $_sCoupon)
    {
        if(!is_Null($_sCoupon)){
            $sCid = Coupon::select('id')->where('code', $_sCoupon)->get();
            $iCoupon = $sCid[0]['id'];
        } else {
            $iCoupon = null;
        }

        ## 取得當下時間
        $dNowDate = (string) Carbon::now('Asia/Taipei');

        $iOid = new Order;
        $iOid->uid = $_iUid;
        $iOid->total = $_iTotal;
        $iOid->delivery = $_sDelivery;
        $iOid->coupon = $iCoupon;
        $iOid->addDate = $dNowDate;
        $iOid->save();
        $aLastOid = Order::where('uid', $_iUid)->latest('addDate')->first();

        for ($i=0;$i < count($_aCart);$i++) {
            Orderdetail::create([
                'oid' => (int) $aLastOid['id'],
                'pid' => (int) $_aCart[$i]['pid'],
                'num' => (int) $_aCart[$i]['num']
            ]);
            $result  = Product::select('num')->where('id', $_aCart[$i]['pid'])->get();
            $updateNum = Product::find($_aCart[$i]['pid']);
            $updateNum->num = $result[0]['num']- $_aCart[$i]['num'];
            $updateNum->save();
        }
        Cart::where('uid', $_iUid)->delete();
        return (int) $aLastOid['id'];
    }
}
