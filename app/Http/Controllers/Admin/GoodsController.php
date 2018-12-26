<?php

namespace App\Http\Controllers\Admin;

use App\Good;
use App\Http\Requests\StoreGoodPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
    /***
     * 二手商品列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        $search_items = [
            'title' => [
                'type' => 'like',
                'form' => 'text',
                'label' => '标题',
            ],
            'name' => [
                'type' => 'like',
                'form' => 'text',
                'label' => '商家',
            ],
            'created_at' => [
                'type' => 'date',
            ],
        ];


        $datas =Good::latest()
            ->search($search_items)
            ->paginate(20)
        ;


        return _view('admin.serve.goods.index',compact('datas'));
    }

    /***
     * 二手商品修改页面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $data = Good::find($id);
        return view('admin.serve.goods.edit',compact('data'));
    }

    /***
     * 二手商品修改更新
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(StoreGoodPost $request,$id){
        $data = Good::findOrFail($id);
        $input = $request->all();

        if (isset($input['file']) && is_object($input['file'])) {
            $file_name = save_image_file($input['file'], 'decoration');
            if (!$file_name) {
                return back()->with('msg', '图片上传失败,请重试!');
            }
            $input['thumbnail'] = $file_name;
            $data->thumbnail = $input['thumbnail'];
        }

        $data->title = $input['title'];
        $data->name = $input['name'];
        $data->mobile = $input['mobile'];
        $data->address = $input['address'];
        $data->price = $input['price'];
        $data->market_price = $input['market_price'];
        $data->url = $input['url'];
        $data->top = $input['top'];
        $data->content = $input['content'];
        $data->new_level = $input['new_level'];
        $data->type = $input['type'];
        $data->measure = $input['measure'];


        $data->save();

        admin_action_logs($data, "修改二手商品（{$data->title}）");

        return redirect()->route('admin.goods.index')->with('msg','二手商品修改成功');
    }

    /***
     * 二手商品添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){
        $data = null;
        return view('admin.serve.goods.edit',compact('data'));
    }

    /***
     * 二手商品添加
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(StoreGoodPost $request){
        $input = $request->all();

        if (isset($input['file']) && is_object($input['file'])) {

            $file_name = save_image_file($input['file'], 'good');
            if (!$file_name) {
                return back()->with('msg', '图片上传失败,请重试!');
            }
            $input['thumbnail'] = $file_name;
            unset($input['_token']);
            unset($input['file']);
        }else{
            return back()->with('msg', '请上传图片');
        }

//        $input['content'] = json_encode($input['content']);
        $result = Good::create($input);
        if($result){
            admin_action_logs($result, "添加二手商品（{$result->title}）");
            return redirect()->route('admin.goods.index')->with('msg','添加二手商品成功');
        }else {
            return back()->withErrors('添加失败请联系管理员!');
        }


    }


    /**
     * 二手商品开关
     * @param $id
     */
    public function switchStatus($id){
        $data = Good::findOrFail($id);
        if($data->status==1){
            $data->status = 2;
        }else{
            $data->status = 1;
        }
        $data->save();

        $action = intval($data->status) === 1 ? '开启' : '关闭';
        admin_action_logs($data, "{$action}二手商品（{$data->title}）");

        return [
            'status' => true,
            'code' => 200,
            'msg' => $action . '二手商品成功',
        ];

    }
}
