<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Orderdetail;

class OrderdetailsController extends Controller
{
    public function shipItem($_iOid, Request $_oRequest)
    {
        ## 參數初始化
        $iOid = (int)$_iOid;
        $aGroup = $_oRequest->input('group');

        $aResult = Orderdetail::where('oid', $iOid)->get();

        for ($i = 0; $i<count($aResult);$i++) {
            for ($j=0; $j<count($aGroup);$j++) {
                $status = Orderdetail::find($aResult[$i]['id']);
                if ($status['pid'] === $aGroup[$j]) {
                    $status->ship = 1;
                    $status->save();
                }
            }
        }
    }
}
