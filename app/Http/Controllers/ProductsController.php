<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Product;
use App\models\Coupon;

class ProductsController extends Controller
{
    /**
     * 取得全部商品資料
     * @return json
     */
    public function getAllProducts()
    {
        $aResult = Product::skip(0)->take(10)->get();

        return response()->json(['result' => true, 'data' => $aResult]);
    }

    public function changeAdminPage($num)
    {
        $aResult = Product::all();
        $iTotalPage =  floor(count($aResult)/10) + 1;

        ##取得抓取筆數
        $nowNum = ($num- 1) * 10;
        ## 取得單一商品資料
        $aResult = Product::skip($nowNum)->take(10)->get();

        return response()->json(['result' => true, 'data' => $aResult,'total' => $iTotalPage]);
    }

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
    * 跑馬燈商品取得
    * @return json
    */
    public function getCarouselItem()
    {
        $i = rand(1, 18);
        $aResult = Product::skip($i)->take(6)->get();
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
        ## 參數初始化
        $name = $_oRequest->input('name');
        $sex = $_oRequest->input('sex');
        $class = $_oRequest->input('class');
        $price = $_oRequest->input('price');
        $content = $_oRequest->input('content');
        $detail = $_oRequest->input('detail');
        $image = $_oRequest->input('image');
        $enable = $_oRequest->input('enable');

        ## 為空值返回
        if (is_null($name)||is_null($sex)||is_null($class)||is_null($price)||is_null($content)||is_null($detail)||is_null($image)||is_null($enable)) {
            return response()->json(['result' => false]);
        }
        ## 新增商品
        $aParam = [
            'name' => $name,
            'sex' => $sex,
            'class' => $class,
            'price' => $price,
            'content' => $content,
            'detail' => $detail,
            'image'  => $image,
            'enable'  => $enable,
        ];
        Product::create($aParam);
        return response()->json(['result' => true]);
    }

    /**
     * 更新商品
     * @return json
     */
    public function updateProducts(Request $_oRequest)
    {
        ## 參數初始化
        $iPid = $_oRequest->input('id');
        $sName = $_oRequest->input('name');
        $sSex = $_oRequest->input('sex');
        $sClass = $_oRequest->input('class');
        $iPrice = $_oRequest->input('price');
        $sContent = $_oRequest->input('content');
        $sDetail = $_oRequest->input('detail');
        $sImage = $_oRequest->input('image');
        $iEnable = $_oRequest->input('enable');

        ## 更新商品
        $product = Product::find($iPid);
        $product->name = $sName;
        $product->sex = $sSex;
        $product->class = $sClass;
        $product->price = $iPrice;
        $product->content = $sContent;
        $product->detail = $sDetail;
        $product->image = $sImage;
        $product->enable = $iEnable;
        $product->save();

        return response()->json(['result' => true]);
    }

    public function deleteProduct($_iPid)
    {
        $product = Product::find($_iPid);

        ## 查無此商品
        if (collect($product)->isEmpty()) {
            return response()->json(['result' => false]);
        };

        ## 刪除商品
        $product->delete();
        return response()->json(['result' => true]);
    }

    public function deleteCoupon($_iPid)
    {
        $coupon = Coupon::find($_iPid);

        ## 查無此優惠券
        if (collect($coupon)->isEmpty()) {
            return response()->json(['result' => false]);
        };

        ## 刪除優惠券
        $coupon->delete();
        return response()->json(['result' => true]);
    }

    public function checkProduct($_iPid)
    {
        $product = Product::find($_iPid);

        ## 查無此商品
        if (collect($product)->isEmpty()) {
            return response()->json(['result' => false]);
        };
    }
}
