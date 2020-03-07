<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Cart;
use App\models\Product;
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
        $dBeforeDate = (string) Carbon::parse($dNowDate)->subDays(1)->toDateTimeString();

        ## 砍掉超過1天的購物車
        Cart::where('addtime', '<=', $dBeforeDate)
             ->delete();
    }
    /**
     * 取得全部商品資料
     * @return json
     */
    public function getProducts()
    {
        ## 取得所有商品資料
        $aResult = Product::get();
        return response()->json(['result' => true, 'data' => $aResult]);
    }

    /**
     * 取得單一商品資料
     * @return json
     */
    public function getSingleProduct($id)
    {
        ## 取得單一商品資料
        $aResult = Product::find($id);
        return response()->json(['result' => true, 'data' => $aResult]);
    }
    /**
    * 圖片上傳確認
    * @return json
    */
    public function imageUpload(Request $_oRequest)
    {
        ## 接收檔案並確認是否存在及圖片檔
        $image = $_oRequest->hasFile("file-to-upload") ? $_oRequest->file("file-to-upload") : null;
        if (is_null($image) || substr($image->getMimeType(), 0, 5) !== 'image') {
            return response()->json(['result' => false]);
        }

        ## 圖片轉換為base64
        $imageConvert = $this->imageFormat($image);
        return response()->json(['result' => true, 'data' => $imageConvert]);
    }

    /**
     * 圖片格式轉換
     * @param object ## 圖片資訊
     * @return string
     */
    protected function imageFormat($_oImage)
    {
        ## 取得經過base64編碼圖片
        return chunk_split(base64_encode(fread(fopen($_oImage->path(), 'r'), $_oImage->getClientSize())));
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

    public function updateUserCart(Request $_oRequest)
    {
        $aResponse = $_oRequest->input('post');
        $aResult = Cart::where('uid', 11)->get();

        for ($i = 0;$i < count($aResponse); $i++) {
            $post = Cart::find($aResult[$i]['id']);
            $post->num = $aResponse[$i];
            $post->save();
        }
        $aCart = Cart::select('pid', 'num')->where('uid', 11)->get();
        return response()->json(['result' => true,'data' => $aCart]);
    }
}
