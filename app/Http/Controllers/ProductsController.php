<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Product;

class ProductsController extends Controller
{
    /**
     * 取得男性商品資料
     * @return json
     */
    public function getMenProducts()
    {
        ## 取得前12筆商品資料
        $aTotal = Product::where('sex', 'M')->get();
        $aResult = Product::where('sex', 'M')->skip(0)->take(12)->get();

        return response()->json(['result' => true, 'data' => $aResult,'total' => count($aTotal)]);
    }

    /**
     * 取得女性商品資料
     * @return json
     */
    public function getWomenProducts()
    {
        ## 取得前12筆商品資料
        $aTotal = Product::where('sex', 'W')->get();
        $aResult = Product::where('sex', 'W')->skip(0)->take(12)->get();

        return response()->json(['result' => true, 'data' => $aResult,'total' => count($aTotal)]);
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
    * 取得當前頁數商品資料
    * @return json
    */
    public function changePage($sex, $num)
    {
        if ($sex === 'men') {
            $get ='M';
        } else {
            $get = 'W';
        }
        ##取得抓取筆數
        $nowNum = ($num- 1) * 12;
        ## 取得單一商品資料
        $aResult = Product::where('sex', $get)->skip($nowNum)->take(12)->get();

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
     * 新增商品
     * @return json
     */
    public function createProducts(Request $_oRequest)
    {
        ## 新增商品
        $aParam = [
            'name' => $_oRequest->input('title'),
            'sex' => $_oRequest->input('sex'),
            'class' => $_oRequest->input('category'),
            'price' => $_oRequest->input('price'),
            'content' => $_oRequest->input('content'),
            'detail' => $_oRequest->input('description'),
            'image'  => $_oRequest->input('image'),
            'enable'  => $_oRequest->input('is_enabled'),
        ];
        Product::create($aParam);
        return response()->json(['result' => true]);
    }
}
