<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Order;
use App\models\Orderinfo;
use App\models\Orderdetail;
use App\models\Coupon;
use App\models\Product;
use App\models\User;
use Illuminate\Support\Carbon;

class OrderController extends Controller
{
    /**
    * 取得該訂單所需資料
    * @return json
    */
    public function getOrderDetails($id)
    {
        ## 參數初始化
        $arr = [];

        ## 取得該訂單基本資訊
        $aResult = Order::select('uid', 'total', 'coupon', 'delivery', 'addDate')->where('id', $id)->get();

        ## 取得該訂單使用優惠券
        if ($aResult[0]['coupon'] !== null) {
            $aCoupon = Coupon::select('name', 'discount')->where('id', $aResult[0]['coupon'])->get();
        }
        ## 取得下單人信箱
        $aEmail = User::select('email')->where('id', $aResult[0]['uid'])->get();

        ## 取得該訂單商品資訊
        $aDetails = Orderdetail::select('pid', 'num', 'ship')->where('oid', $id)->get();

        for ($i = 0; $i < count($aDetails); $i ++) {
            $aProduct = Product::select('name', 'price')->where('id', $aDetails[$i]['pid'])->get();
            array_push($arr, $aProduct[0]);
        }

        ## 取得該訂單運送資訊
        $aData = Orderinfo::where('oid', $id)->get();

        ## 組合所需訂單詳細資訊
        if ($aResult[0]['coupon'] !== null) {
            $aParam =[
            'addDate' => $aResult[0]['addDate'],
            'total' => $aResult[0]['total'],
            'delivery'=> $aResult[0]['delivery'],
            'name' => $aData[0]['name'],
            'phone' => $aData[0]['phone'],
            'address' => $aData[0]['address'],
            'note' => $aData[0]['note'],
            'payment' => $aData[0]['payment'],
            'coupon' => $aCoupon[0]['name'],
            'discount' => $aCoupon[0]['discount'],
            'email' => $aEmail[0]['email']
        ];
        } else {
            $aParam =[
                'addDate' => $aResult[0]['addDate'],
                'total' => $aResult[0]['total'],
                'delivery'=> $aResult[0]['delivery'],
                'name' => $aData[0]['name'],
                'phone' => $aData[0]['phone'],
                'address' => $aData[0]['address'],
                'note' => $aData[0]['note'],
                'payment' => $aData[0]['payment'],
                'email' => $aEmail[0]['email']
            ];
        }

        return response()->json(['result' => true, 'data' => $aDetails,'item' => $arr,'info' => $aParam]);
    }

    /**
    * 檢查會員訂單
    * @return json
    */
    public function checkOrder($_iOid, $_iUid)
    {
        $aResult = Order::where('id', $_iOid)->where('uid', $_iUid)->get();
        if (collect($aResult)->isEmpty()) {
            return response()->json(['result' => false]);
        };
    }

    /**
    * 檢查全部訂單
    * @return json
    */
    public function checkAllOrder($_iOid)
    {
        $aResult = Order::where('id', $_iOid)->get();
        if (collect($aResult)->isEmpty()) {
            return response()->json(['result' => false]);
        };
    }
    /**
     * 取得當前頁面訂單
     * @return json
     */
    public function getTodayOrder()
    {
        ## 取得總筆數
        $aResult = Order::all();
        $iTotal =  count($aResult);

        ## 取得今日訂單資料
        $today = Carbon::today('Asia/Taipei');
        $tomorrow = Carbon::tomorrow('Asia/Taipei');
        $aResult = Order::whereBetween('addDate', [$today,$tomorrow])->get();

        return response()->json(['result' => true, 'data' => $aResult,'total' => $iTotal]);
    }
    /**
     * 取得當前頁面優惠券
     * @return json
     */
    public function changeCouponPage($num)
    {
        $aResult = Coupon::all();
        $iTotalPage =  floor(count($aResult)/10) + 1;

        ##取得抓取筆數
        $nowNum = ($num- 1) * 10;
        ## 取得單一商品資料
        $aResult = Coupon::skip($nowNum)->take(10)->get();

        return response()->json(['result' => true, 'data' => $aResult,'total' => $iTotalPage]);
    }
    /**
     * 新增優惠券
     * @return json
     */
    public function createCoupons(Request $_oRequest)
    {
        ## 新增優惠券
        $aParam = [
            'name' => $_oRequest->input('name'),
            'code' => $_oRequest->input('code'),
            'discount' => $_oRequest->input('discount'),
            'expiry_date' => $_oRequest->input('expiry_date'),
            'enable'  => $_oRequest->input('enable'),
        ];

        Coupon::create($aParam);
        return response()->json(['result' => true]);
    }

    /**
     * 更新優惠券
     * @return json
     */
    public function updateCoupons(Request $_oRequest)
    {
        ## 參數初始化
        $iCid = $_oRequest->input('id');
        $sName = $_oRequest->input('name');
        $sCode = $_oRequest->input('code');
        $iDiscount = $_oRequest->input('discount');
        $sDate = $_oRequest->input('expiry_date');
        $iEnable = $_oRequest->input('enable');

        ## 更新優惠券
        $coupon = Coupon::find($iCid);
        $coupon->name = $sName;
        $coupon->code = $sCode;
        $coupon->discount = $iDiscount;
        $coupon->expiry_date = $sDate;
        $coupon->enable = $iEnable;
        $coupon->save();

        return response()->json(['result' => true]);
    }

    /**
     * 更新訂單狀態
     * @return json
     */
    public function changeOrderStatus($oid, $status)
    {

        ## 取得當下時間
        $dNowDate = (string) Carbon::now('Asia/Taipei');
        if ($status === '1') {
            $order = Order::find($oid);
            $order->status = $status;
            $order->shipDate = $dNowDate;
            $order->save();
        } elseif ($status === '2') {
            $order = Order::find($oid);
            $order->status = $status;
            $order->doneDate = $dNowDate;
            $order->save();
        } elseif ($status === '3') {
            $order = Order::find($oid);
            $order->status = $status;
            $order->closeDate = $dNowDate;
            $order->save();
        }

        return response()->json(['result' => true]);
    }

    /**
     * 取得日期區間訂單
     * @return json
     */
    public function getDateOrder(Request $_oRequest)
    {
        $aDate = $_oRequest->input('date');
        $aResult = Order::whereBetween('addDate', [$aDate[0],$aDate[1]])->get();

        return response()->json(['result' => true,'data'=>$aResult]);
    }
}
