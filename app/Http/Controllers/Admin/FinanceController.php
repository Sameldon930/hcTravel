<?php

namespace App\Http\Controllers\Admin;

use App\Finance;
use App\Http\Requests\StoreFinancePost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FinanceController extends Controller
{
    /***
     * 金融服务列表
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
                'label' => '公司名',
            ],
            'created_at' => [
                'type' => 'date',
            ],
        ];


        $datas =Finance::latest()
            ->search($search_items)
            ->paginate(20)
        ;

        return _view('admin.serve.finance.index',compact('datas'));
    }

    /***
     * 金融服务修改页面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $data = Finance::find($id);
        return view('admin.serve.finance.edit',compact('data'));
    }

    /***
     * 金融服务修改更新
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(StoreFinancePost $request,$id){
        $data = Finance::findOrFail($id);
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
        $data->url = $input['url'];
        $data->top = $input['top'];
        $data->content = $input['content'];

        $data->save();

        admin_action_logs($data, "修改金融服务（{$data->title}）");

        return redirect()->route('admin.finance.index')->with('msg','金融服务修改成功');
    }

    /***
     * 金融服务添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){
        $data = null;
        return view('admin.serve.finance.edit',compact('data'));
    }

    /***
     * 金融服务添加
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(StoreFinancePost $request){
        $input = $request->all();

        if (isset($input['file']) && is_object($input['file'])) {

            $file_name = save_image_file($input['file'], 'finance');
            if (!$file_name) {
                return back()->with('msg', '图片上传失败,请重试!');
            }
            $input['thumbnail'] = $file_name;
            unset($input['_token']);
            unset($input['file']);
        }else{
            return back()->with('msg', '请上传图片');
        }

        $result = Finance::create($input);
        if($result){
            admin_action_logs($result, "添加金融服务（{$result->title}）");
            return redirect()->route('admin.finance.index')->with('msg','添加金融服务成功');
        }else {
            return back()->withErrors('添加失败请联系管理员!');
        }

    }


    /**
     * 金融服务开关
     * @param $id
     */
    public function switchStatus($id){
        $data = Finance::findOrFail($id);
        if($data->status==1){
            $data->status = 2;
        }else{
            $data->status = 1;
        }
        $data->save();

        $action = intval($data->status) === 1 ? '开启' : '关闭';
        admin_action_logs($data, "{$action}金融服务（{$data->title}）");

        return [
            'status' => true,
            'code' => 200,
            'msg' => $action . '金融服务成功',
        ];

    }
}
