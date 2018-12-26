<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WithdrawalAuditController extends Controller
{
    /***
     * 提现审核
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        return view('admin.account_change.withdrawal_audit.index');
    }
}
