<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\User;
use App\models\Cart;
use App\Http\Resources\Article as ArticleResources;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;

class UserController extends Controller
{
    /**
    * 會員註冊
    * @return json
    */
    public function store(Request $_oRequest)
    {
        echo $_oRequest->input('date');
        exit;
        ## 檢查會員是否重複
        $aResult = User::select('email')->where('email', $_oRequest->input('email'))->get();
        if (!collect($aResult)->isEmpty()) {
            return response()->json(['result' => false]);
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

        ## 給予Token並且設置在資料庫
        $iUid  = $aResult[0]['id'];
        $sToken = $this->generateKey();
        $setToken = User::find($iUid);
        $setToken->token = "$sToken";
        $setToken->save();

        ## 判斷身份導路由並給予使用者相關資訊
        $iLevel  = $aResult[0]['level'];
        if ($iLevel === 0) {
            return response()->json(['result' => true, 'level' => 'member', 'token' => $sToken ]);
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
        $aUser->token = '';
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
        $aCart = Cart::select('pid', 'num')->where('uid', $iUid)->get();
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
            return response()->json(['result' => false]);
        }

        ## 檢查會員是否有特殊符號
        if (!preg_match("/^[A-Za-z0-9]+$/", $sUserName)) {
            return response()->json(['result' => false]);
        }

        ##檢查信箱格式
        if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $sEmail)) {
            return response()->json(['result' => false]);
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

    public function changeUserPassword($_iUid, Request $_oRequest)
    {
        ## 參數初始化
        $sOld = $_oRequest->input('oldpass');
        $sNew = $_oRequest->input('newpass');

        ## 檢查會員是否存在及狀態
        if ($_iUid === '') {
            return response()->json(['result' => false]);
        }

        ## 舊密碼確認
        $aResult =User::select('passwd')->where('id', $_iUid)->get();
        $sPassWd = $aResult[0]['passwd'];
        if (!Hash::check($sOld, $sPassWd)) {
            return response()->json(['result' => false]);
        }

        ## 密碼重複驗證
        if ($sOld === $sNew) {
            return response()->json(['result' => false]);
        }

        ## 更改密碼
        $User = User::find($_iUid);
        $User->passwd = Hash::make($sNew);
        $User->save();
        return response()->json(['result' => true]);
    }
}
