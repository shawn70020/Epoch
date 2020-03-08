<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\Orderdetail;
use App\models\Product;
use App\models\Cart;

class Order extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['uid'];

    public function addOrder($_iUid, $_aCart)
    {
        $iOid = new Order;
        $iOid->uid = $_iUid;
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
    }
}
