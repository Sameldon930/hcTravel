<?php

namespace App\Http\Controllers\Admin;

use App\ArticleGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ArticleTypeController extends Controller
{
    /***
     * 文章类别列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $group = new ArticleGroup();
        $datas = $group->getArticleGroups();

        return view('admin.info.article_type.index',compact('datas'));
    }

    /***
     * 文章类别修改页面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $data = ArticleGroup::find($id);
        return view('admin.info.article_type.edit',compact('data'));
    }

    /**
     * 文章类别修改更新
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request,$id){

        $inputs = $request->all();
        $rules = [
            'name' => 'required|unique:article_groups,name',
        ];
        $message = [
            'name.required' => '文章类别名不能为空',   //自定义错误信息
            'name.unique' => '文章类别名已存在',   //自定义错误信息
        ];
        $validator = Validator::make($inputs, $rules, $message);
        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput($inputs);
        };
       $group = ArticleGroup::findOrFail($id);
       $group->name = $request->name;
       $result = $group->save();
        if($result){
            admin_action_logs($group, "修改文章分组（{$group->name}）");
            return redirect()->route('admin.article_type.index')->with('msg','文章分类修改成功');
        }else {
            return back()->withErrors('修改失败请联系管理员!');
        }



    }

    /***
     * 文章类别添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){
        $data = null;
        return view('admin.info.article_type.edit',compact('data'));
    }

    /***
     * 文章类别添加
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request){
        $inputs = $request->all();
        $rules = [
            'name' => 'required|unique:article_groups,name',
        ];
        $message = [
            'name.required' => '文章类别名不能为空',   //自定义错误信息
            'name.unique' => '文章类别名已存在',   //自定义错误信息
        ];
        $validator = Validator::make($inputs, $rules, $message);
        if (!$validator->passes()) {
            return back()->withErrors($validator)->withInput($inputs);
        };

        $result = ArticleGroup::create([
            'name'=>$request->name,
        ]);
        if($result){
            admin_action_logs($result, "修改文章分组（{$result->name}）");
            return redirect()->route('admin.article_type.index')->with('msg','添加文章类别成功');
        }else {
            return back()->withErrors('添加失败请联系管理员!');
        }


    }


    /**
     * 文章类别开关
     * @param $id
     */
    public function switchStatus($id){
        $group = ArticleGroup::findOrFail($id);
        if($group->status==1){
            $group->status = 2;
        }else{
            $group->status = 1;
        }
        $group->save();

        $action = intval($group->status) === 1 ? '开启' : '关闭';
        admin_action_logs($group, "{$action}文章分组（{$group->name}）");

        return [
            'status' => true,
            'code' => 200,
            'msg' => $action . '文章类别成功',
        ];
    }
}
