<?php

namespace App\Http\Controllers\Admin;

use App\ActionLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActionLogController extends Controller
{
    /***
     * 订单列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        $search_items = [
            'admin_id' => [
                'type' => 'custom',
                'form' => 'text',
                'label' => '管理员',
            ],
            'created_at' => [
                'type' => 'date',
            ],
        ];

        $data = ActionLog::latest()
            ->search($search_items)
            ->with('admin')
            ->paginate()
        ;

        return view('admin.system.action_log.index', compact('data'));
    }
}
