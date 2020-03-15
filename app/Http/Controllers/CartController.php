<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Cart;
use App\models\User;
use App\models\Order;
use App\models\Product;
use App\models\Coupon;
use Illuminate\Support\Carbon;

class CartController extends Controller
{
    /**
     * 刪除時間超過1天的購物車
     */
    public function __construct()
    {
        ## 取得當下時間
        $dNowDate = (string) Carbon::now('Asia/Taipei');

        ## 往前推1天
        $dBeforeDate = (string) Carbon::parse($dNowDate)->subHours(1)->toDateTimeString();

        ## 砍掉超過1天的購物車
        Cart::where('addtime', '<=', $dBeforeDate)
             ->update(['delete_at' => 1]);
    }

    /**
     * 加入購物車
     * @return json
     */
    public function addCart(Request $_oRequest)
    {
        ## 參數初始化
        $iUid = (int)$_oRequest->input('uid');
        $iPid = (int)$_oRequest->input('pid');
        $aResult = Cart::where('uid', $iUid)->where('pid', $iPid)->get();

        ## 購物車不存在該商品即新增
        if ($aResult->isEmpty()) {
            $aArray = [
                'uid' => $iUid,
                'pid' =>  $iPid,
                'num' => 1,
            ];
            Cart::create($aArray);
        } else {
            $iNum = $aResult[0]['num'];
            $iId = $aResult[0]['id'];
            $post = Cart::find($iId);
            $post->num = $iNum +1;
            $post->save();
        }
        return response()->json(['result' => true]);
    }
    /**
    * 刪除購物車商品
    * @return json
    */
    public function deleteCart($_iUid, $_iPid)
    {
        ## 檢查會員是否存在及狀態
        if ($_iUid === '') {
            return response()->json(['result' => false]);
        }

        ## 檢查商品存在
        $iPid = (int) $_iPid;
        $aResult = Product::where('id', $_iPid)->get();
        if ($iPid === '' || $aResult->isEmpty()) {
            return response()->json(['result' => false]);
        }

        ## 刪除購物車商品
        Cart::where('uid', $_iUid)->where('pid', $_iPid)->delete();
        return response()->json(['result' => true]);
    }
    /**
     * 取得會員購物車
     * @return json
     */
    public function getUserCart(Request $_oRequest)
    {
        $arr = [];
        $aResponse = $_oRequest->input('post');

        for ($i = 0;$i < count($aResponse); $i++) {
            $aResult = Product::find($aResponse[$i]);
            array_push($arr, $aResult);
        }

        return response()->json(['result' => true, 'data'=>$arr]);
    }

    /**
     * 更新會員購物車
     * @return json
     */
    public function updateUserCart(Request $_oRequest)
    {
        $aResponse = $_oRequest->input('post');
        $aResult = Cart::where('uid', 11)->get();

        for ($i = 0;$i < count($aResponse); $i++) {
            $post = Cart::find($aResult[$i]['id']);
            $post->num = $aResponse[$i];
            $post->save();
        }
        $aCart = Cart::select('pid', 'num')->where('uid', 11)->where('delete_at', null)->get();
        return response()->json(['result' => true,'data' => $aCart]);
    }

    /**
    * 更新會員購物車
    * @return json
    */
    public function moveToBag($_iUid, $_iPid)
    {
        ## 取得當下時間
        $dNowDate = (string) Carbon::now('Asia/Taipei');

        ## 更新購物車
        Cart::where('uid', $_iUid)->where('pid', $_iPid)->update(['addtime' => $dNowDate,'delete_at' => null]);

        return response()->json(['result' => true]);
    }

    /**
    * 使用優惠券
    * @return json
    */
    public function useCoupon(Request $_oRequest)
    {
        $sCoupon = $_oRequest->input('coupon');
        $aResult = Coupon::where('code', $sCoupon)->get();

        ## 優惠碼不存在
        if ($aResult->isEmpty()) {
            return response()->json(['result' => false,'msg' => 'code_error']);
        }

        ## 檢查使用期限
        $dExpireDate = $aResult[0]['expiry_date'];
        $dNowDate = (string) Carbon::now('Asia/Taipei')->toDateTimeString();

        if ($dExpireDate < $dNowDate) {
            return response()->json(['result' => false,'msg' => 'expire_date']);
        }

        ## 回傳折扣數值
        return response()->json(['result' => true,'data' => $aResult[0]['discount']]);
    }

    /**
     * 新增訂單
     * @return json
     */
    public function addOrder(Request $_oRequest)
    {
        ## 參數初始化
        $aCart = $_oRequest->input('cart');
        $aUser = $_oRequest->input('user');
        $iTotal = $_oRequest->input('total');
        $cartNum = count($aCart);

        ## 檢查會員是否存在
        $iUid = (int) $aUser['id'];
        $aResult = User::find($iUid);

        if ($aResult === null) {
            return response()->json(['result' => false, 'msg' => '會員不存在']);
        }

        ## 檢查購物車是否已被結帳
        $aData = Cart::where('uid', $iUid)->get();
        if ($aData->isEmpty()) {
            return response()->json(['result' => false, 'msg' => '購物車已被結帳']);
        }
        ## 檢查購物車是否為空及數量一致
        if ($cartNum === 0) {
            return response()->json(['result' => false, 'msg' => '購物車為空']);
        }

        $aCartResult = Cart::select('pid', 'num')->where('uid', $iUid)->where('delete_at', null)->get()->toArray();
        for ($i = 0;$i < $cartNum; $i++) {
            if ($aCart[$i]['pid'] !== $aCartResult[$i]['pid'] || $aCart[$i]['num'] !== $aCartResult[$i]['num']) {
                return response()->json(['result' => false, 'msg' => '購物車數量不符']);
                break;
            }
        }

        ## 檢查商品庫存
        $aProductNum = [];
        for ($i = 0; $i < $cartNum; $i++) {
            $result  = Product::select('num')->where('id', $aCart[$i]['pid'])->get();
            $aProductNum[$i] = $result[0]['num'];
            if ($aProductNum[$i] < $aCart[$i]['num']) {
                return response()->json(['result' => false, 'msg' => '商品數量不足']);
                break;
            }
        }

        ## 結帳
        $post = new Order();
        $post->addOrder($iUid, $aCart, $iTotal);
        return response()->json(['result' => true]);
    }
}
