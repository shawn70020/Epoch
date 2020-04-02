<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\User;
use App\models\Cart;
use App\models\Order;
use App\models\Orderdetail;
use App\models\Orderinfo;
use App\models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    /**
    * 會員註冊
    * @return json
    */
    public function store(Request $_oRequest)
    {
        ## 檢查會員是否重複
        $aResult = User::select('email')->where('email', $_oRequest->input('email'))->get();
        if (!collect($aResult)->isEmpty()) {
            return response()->json(['result' => false,'msg' => '此會員已被註冊']);
        };

        ## 新增會員
        $aArray = [
            'email' => $_oRequest->input('email'),
            'passwd' =>  Hash::make($_oRequest->input('password')),
            'name' => $_oRequest->input('name'),
            'birthday' => $_oRequest->input('date'),
            'sex' =>  $_oRequest->input('sex'),
        ];

        User::create($aArray);
        return response()->json(['result' => true]);
    }

    /**
     * 登入驗證
     * @return json
     */
    public function checkLogin(Request $_oRequest)
    {
        $email = $_oRequest->input('email');
        $aResult = User::where('email', $email)->get();

        ## 查無此會員
        if (collect($aResult)->isEmpty()) {
            return response()->json(['result' => false]);
        };

        ## 會員密碼錯誤
        $sCheckPasswd  = $aResult[0]['passwd'];
        if ((!Hash::check($_oRequest->input('password'), $sCheckPasswd))) {
            return response()->json(['result' => false]);
        };

        ## 會員狀態禁止
        if ($aResult[0]['status'] === 1) {
            return response()->json(['result' => 'frozen']);
        }
        ## 給予Token並且設置在資料庫及更改上次登入時間
        $iUid  = $aResult[0]['id'];
        $sToken = $this->generateKey();
        $dNowDate = (string) Carbon::now('Asia/Taipei');
        $User = User::find($iUid);
        $User->token = "$sToken";
        $User->lastDate = $dNowDate;
        $User->save();

        ## 判斷身份導路由並給予使用者相關資訊
        $iLevel  = $aResult[0]['level'];
        $sSex = $aResult[0]['sex'];
        if ($iLevel === 0) {
            return response()->json(['result' => true, 'level' => 'member', 'sex' => $sSex, 'token' => $sToken ]);
        } else {
            return response()->json(['result' => true, 'level' => 'admin', 'token' => $sToken ]);
        }
    }

    /**
     * 產生隨機字串
     */
    protected function generateKey()
    {
        ## 產生隨機字串
        $iKeyLength = 12;
        $sStr = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789";
        $sToken = substr(str_shuffle($sStr), 0, $iKeyLength);
        return $sToken;
    }

    /**
     * 會員登出
     * @return json
     */
    public function userLogout(Request $_oRequest)
    {
        ## 判斷會員id是否為空
        $iUid =  $_oRequest->input('user');
        ## 登出解除cookie及資料庫token
        $aUser =  User::find($iUid);
        $aUser->token = null;
        $aUser->save();

        return response()->json(['result' => true]);
    }

    /**
     * 取得使用者基本資訊及購物車資料
     * @return json
     */
    public function getUserInfo($sToken)
    {
        $aResult = User::select('id', 'name')->where('token', $sToken)->firstorFail();
        $iUid = $aResult['id'];
        $aCart = Cart::select('pid', 'num')->where('uid', $iUid)->where('delete_at', null)->orWhere('delete_at', 2)->get();
        return response()->json(['result' => true, 'info'=> $aResult,'cart' => $aCart]);
    }

    /**
     * 取得使用者基本資訊
     * @return json
     */
    public function getUserData($_iUid)
    {
        $aResult = User::select('email', 'name', 'birthday', 'sex')->where('id', $_iUid)->get();
        return response()->json(['result' => true, 'data' => $aResult]);
    }

    /**
     * 修改個人資料
     * @return json
     */
    public function changeUserInfo($_iUid, Request $_oRequest)
    {
        ## 參數初始化
        $sEmail = $_oRequest->input('email');
        $sUserName = $_oRequest->input('name');
        $sBirth = $_oRequest->input('birthday');
        $sSex = $_oRequest->input('sex');

        ## 檢查會員是否存在及狀態
        if ($_iUid === '') {
            return response()->json(['result' => false,'msg' => '會員不存在']);
        }

        ##檢查信箱格式
        if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $sEmail)) {
            return response()->json(['result' => false,'msg' => '信箱格式錯誤']);
        }

        ## 更改會員資料
        $User = User::find($_iUid);
        $User->email = $sEmail;
        $User->name = $sUserName;
        $User->birthday = $sBirth;
        $User->sex = $sSex;
        $User->save();
        return response()->json(['result' => true]);
    }

    /**
     * 修改個人密碼
     * @return json
     */
    public function changeUserPassword($_iUid, Request $_oRequest)
    {
        ## 參數初始化
        $sOld = $_oRequest->input('oldpass');
        $sNew = $_oRequest->input('newpass');

        ## 檢查會員是否存在及狀態
        if ($_iUid === '') {
            return response()->json(['result' => false,'msg' => '會員不存在!']);
        }

        ## 舊密碼確認
        $aResult =User::select('passwd')->where('id', $_iUid)->get();
        $sPassWd = $aResult[0]['passwd'];
        if (!Hash::check($sOld, $sPassWd)) {
            return response()->json(['result' => false,'msg' => '舊密碼錯誤!']);
        }

        ## 密碼重複驗證
        if ($sOld === $sNew) {
            return response()->json(['result' => false,'msg' => '新舊密碼不能重複!']);
        }

        ## 更改密碼
        $User = User::find($_iUid);
        $User->passwd = Hash::make($sNew);
        $User->save();
        return response()->json(['result' => true]);
    }

    /**
     * 取得使用者保留商品資料
     * @return json
     */
    public function getUserSaved($_iUid)
    {
        ## 取得使用者保留商品資料
        $aResult = Cart::select('pid')->where('uid', $_iUid)->Where('delete_at', 1)->orWhere('delete_at', 2)->get();

        ## 為空回傳
        if (collect($aResult)->isEmpty()) {
            return response()->json(['result' => false]);
        }

        ## 不為空
        $arr = [];
        for ($i = 0;$i < count($aResult); $i++) {
            $aData = Product::find($aResult[$i]['pid']);
            array_push($arr, $aData);
        }
        return response()->json(['result' => true, 'data' => $arr]);
    }

    /**
    * 取得該頁會員資料
    * @return json
    */
    public function changeUserPage($num)
    {
        $aResult = User::all();
        $iTotalPage =  floor(count($aResult)/10) + 1;

        ##取得抓取筆數
        $nowNum = ($num- 1) * 10;

        ## 取得單一商品資料
        $aResult = User::skip($nowNum)->take(10)->get();

        return response()->json(['result' => true, 'data' => $aResult,'total' => $iTotalPage]);
    }

    /**
     * 取得該會員所需資料
     * @return json
     */
    public function getMemberDetails($uid)
    {
        ## 該會員基本資料
        $aResult = User::find($uid);

        ## 該會員訂單資料
        $aOrder = Order::select('id', 'status', 'addDate')->where('uid', $uid)->orderBy('addDate', 'DESC')->get();

        return response()->json(['result' => true, 'data' => $aResult,'order' => $aOrder]);
    }

    /**
     * 更改此會員狀態
     * @return json
     */
    public function changeUserStatus($uid, $status)
    {
        $User = User::find($uid);
        $User->status = $status;
        $User->save();
        return response()->json(['result' => true]);
    }

    /**
     * 取得該會員前兩筆訂單
     * @return json
     */
    public function getMyOrders($_iUid)
    {
        ## 取得該會員訂單總數
        $aResult = Order::where('uid', $_iUid)->get();
        $iTotal = count($aResult);

        ## 取得前兩筆訂單id
        $aResult = Order::select('id', 'shipDate')->where('uid', $_iUid)->orderBy('addDate', 'DESC')->take(2)->get();

        if (collect($aResult)->isEmpty()) {
            return response()->json(['result' => false]);
        }
        ## 取得訂單詳細明細
        $orderinfo = [];
        for ($i = 0;$i < count($aResult); $i++) {
            $aData = Orderdetail::select('pid')->where('oid', $aResult[$i]['id'])->get();
            array_push($orderinfo, $aData);
        }

        ## 取得訂單商品圖
        $aImage = [];
        for ($i = 0;$i < count($orderinfo); $i++) {
            $arr = [];
            for ($j =0;$j<count($orderinfo[$i]); $j++) {
                $aProduct = Product::select('id', 'image')->where('id', $orderinfo[$i][$j]['pid'])->get();
                array_push($arr, $aProduct[0]);
            }
            array_push($aImage, $arr);
        }

        return response()->json(['result' => true, 'data' => $aResult,'image'=>$aImage, 'total' => $iTotal]);
    }

    public function changeOrderPage($_iUid, $num)
    {
        ##取得抓取筆數
        $nowNum = ($num- 1) * 2;
        ## 取得前兩筆訂單id
        $aResult = Order::select('id', 'shipDate')->where('uid', $_iUid)->orderBy('addDate', 'DESC')->skip($nowNum)->take(2)->get();

        if (collect($aResult)->isEmpty()) {
            return response()->json(['result' => false]);
        }
        ## 取得訂單詳細明細
        $orderinfo = [];
        for ($i = 0;$i < count($aResult); $i++) {
            $aData = Orderdetail::select('pid')->where('oid', $aResult[$i]['id'])->get();
            array_push($orderinfo, $aData);
        }

        ## 取得訂單商品圖
        $aImage = [];
        for ($i = 0;$i < count($orderinfo); $i++) {
            $arr = [];
            for ($j =0;$j<count($orderinfo[$i]); $j++) {
                $aProduct = Product::select('id', 'image')->where('id', $orderinfo[$i][$j]['pid'])->get();
                array_push($arr, $aProduct[0]);
            }
            array_push($aImage, $arr);
        }

        return response()->json(['result' => true, 'data' => $aResult,'image'=>$aImage]);
    }

    /**
     * 取得該會員特定訂單資料
     * @return json
     */
    public function getMyOrderdetail($_iOid)
    {
        ## 取得該訂單基本資訊
        $aResult = Order::select('total', 'delivery', 'status', 'addDate', 'shipDate', 'doneDate')->where('id', $_iOid)->get();
        $aNum = Orderdetail::select('pid', 'num')->where('oid', $_iOid)->get();

        ## 取得訂單細項
        $arr = [];
        for ($i = 0;$i<count($aNum);$i++) {
            $aProduct = Product::select('name', 'image', 'price')->where('id', $aNum[$i]['pid'])->get();
            array_push($arr, $aProduct[0]);
        }

        ## 取得訂單收件人資訊
        $aInfo = Orderinfo::select('name', 'phone', 'address', 'note', 'payment')->where('oid', $_iOid)->get();

        return response()->json(['result' => true, 'data' => $aResult[0],'num'=>$aNum,'item'=>$arr,'info'=>$aInfo[0]]);
    }

    public function checkStatus($_sToken)
    {
        $aResult = User::select('level')->where('token', $_sToken)->get();
        if ($aResult[0]['level'] !== 1) {
            return response()->json(['result' => false]);
        }
    }

    public function checkAllMember($_iUid)
    {
        $aResult = User::where('id', $_iUid)->get();
        if (collect($aResult)->isEmpty()) {
            return response()->json(['result' => false]);
        };
    }
}
