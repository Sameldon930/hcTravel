<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    /***
     * 联系我们
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        return view('admin.operation.contact.index');
    }

    /***
     * 客服修改页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){

        return view('admin.operation.contact.edit');
    }

    /***
     * 客服修改更新
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update($id){

        return redirect()->route('admin.contact.index')->with('msg','客服修改成功');
    }

    /***
     * 客服添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){

        return view('admin.operation.contact.edit');
    }

    /***
     * 客服添加
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(){

        return redirect()->route('admin.contact.index')->with('msg','客服添加成功');
    }

    /***
     * 公告开关
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function switchStatus($id){

        return redirect()->route('admin.contact.index')->with('msg','客服状态修改成功');
    }
}
