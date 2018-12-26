<?php

namespace App\Http\Controllers\Admin;

use App\HomestayInfo;
use App\Merchant;
use App\MerchantInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){


        return _view('admin.dashboard');
    }

    public function changeStatus(){
       /* $items = Merchant::get();

        foreach ($items as $item){
            $item->status = json_encode(['merchant'=>1]);
            $item->save();
        }
        return back()->with('修改状态成功');*/
       return back();
    }
}
