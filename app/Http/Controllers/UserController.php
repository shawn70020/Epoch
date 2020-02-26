<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\User;
use App\Http\Resources\Article as ArticleResources;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Cookie;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $article = Article::paginate(5);
        return ArticleResources::collection($article)->additional(['meta' => [
            'version' => '1.0.0',
            'API_base_url' => url('/')
        ]]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

     /**
     * 會員註冊
     * @return json
     */
    public function store(Request $_oRequest)
    {
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
