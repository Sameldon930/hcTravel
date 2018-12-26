<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\ArticleGroup;
use App\Http\Requests\StoreArticleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /***
     * 文章列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        $groups = ArticleGroup::get();
        $groupsMap = [];
        foreach ($groups as $group){
            $groupsMap[$group->id] = $group->name;
        }

        $search_items = [
            'title' => [
                'type' => 'like',
                'form' => 'text',
                'label' => '标题',
            ],
            'group_id' => [
                'type' => 'custom',
                'form' => 'select',
                'label' => '分组',
                'options' => $groupsMap,
            ],
            'created_at' => [
                'type' => 'date',
            ],
        ];

        $datas = Article::latest()
            ->with('articleGroup')
            ->search($search_items)
            ->paginate(20)
        ;
        return _view('admin.info.article.index',compact('datas','group'));//
    }

    /***
     * 文章修改页面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $data = Article::find($id);
        return view('admin.info.article.edit',compact('data'));

    }

    /***
     * 文章修改更新
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(StoreArticleRequest $request,$id){
        $data = Article::findOrFail($id);
        $input = $request->all();

        if (isset($input['file']) && is_object($input['file'])) {
            $file_name = save_image_file($input['file'], 'article');
            if (!$file_name) {
                return back()->with('msg', '图片上传失败,请重试!');
            }
            $input['thumbnail'] = $file_name;
            $data->thumbnail = $input['thumbnail'];
        }

        $data->admin_id = Auth::user()->id;//admin_id = user表ID   $data->admin_id = Auth::user->id
        $data->title = $input['title'];
        $data->content = $input['content'];
        $data->ready = $input['ready'];
        $data->group_id = $input['group_id'];
        $data->now = $input['now'];
        $data->save();

        admin_action_logs($data, "修改文章（{$data->title}）");

        return redirect()->route('admin.article.index')->with('msg','文章修改成功');


    }

    /***
     * 文章添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){
        //get
        $data = null;
        return view('admin.info.article.edit',compact('data'));
    }

    /***
     * 文章添加
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(StoreArticleRequest $request){
        $input = $request->all();
        if (isset($input['file']) && is_object($input['file'])) {

            $file_name = save_image_file($input['file'], 'article');
            if (!$file_name) {
                return back()->with('msg', '图片上传失败,请重试!');
            }
            $input['thumbnail'] = $file_name;
            unset($input['_token']);
            unset($input['file']);
        }else{
            return back()->with('msg', '请上传图片');
        }
        $input['admin_id'] = 1;

        $result = Article::create($input);
        if($result){
            admin_action_logs($result, "添加文章（{$result->title}）");
            //return redirect()->route('')->with('msg','');
            return redirect()->route('admin.article.index')->with('msg','添加文章成功');
        }else {
            return back()->withErrors('添加失败请联系管理员!');
        }
    }


    /**
     * 文章开关
     * @param $id
     */
    public function switchStatus($id){

        $group = Article::findOrFail($id);
        if($group->status==1){
            $group->status = 2;
        }else{
            $group->status = 1;
        }
        $group->save();

        $action = intval($group->status) === 1 ? '开启' : '关闭';
        admin_action_logs($group, "{$action}文章（{$group->title}）");

        return [
            'status' => true,
            'code' => 200,
            'msg' => $action . '文章成功',
        ];
    }
}
