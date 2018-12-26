<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VersionsController extends Controller
{
    /***
     * 版本说明
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        return view('admin.operation.versions.index');
    }

    /***
     * 版本说明修改页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){

        return view('admin.operation.versions.edit');
    }

    /***
     * 版本说明修改更新
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update($id){

        return redirect()->route('admin.versions.index')->with('msg','版本说明修改成功');
    }

    /***
     * 版本说明添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){

        return view('admin.operation.versions.edit');
    }

    /***
     *版本说明添加
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(){

        return redirect()->route('admin.versions.index')->with('msg','版本说明添加成功');
    }


}
