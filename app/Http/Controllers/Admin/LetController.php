<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LetController extends Controller
{
    /***
     * 招租列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        return _view('admin.info.let.index');
    }

    /***
     * 招租详情
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(){

        return view('admin.info.let.show');
    }

    /***
     * 招租修改页面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){

        return view('admin.info.let.edit');
    }

    /***
     * 招租修改更新
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update($id){

        return redirect()->route('admin.let.index')->with('msg','求职修改成功');
    }

    /***
     * 招租添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){

        return view('admin.info.let.edit');
    }

    /***
     * 招租添加
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(){

        return redirect()->route('admin.let.index')->with('msg','添加招租成功');
    }


    /**
     * 招租开关
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchStatus($id){

        return redirect()->route('admin.let.index')->with('msg','招租切换成功');
    }
}
