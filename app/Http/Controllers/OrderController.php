<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Coupon;

class OrderController extends Controller
{
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
}
