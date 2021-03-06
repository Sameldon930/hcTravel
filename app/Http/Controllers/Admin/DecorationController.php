<?php

namespace App\Http\Controllers\Admin;

use App\Decoration;
use App\Http\Requests\StoreDecorationPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DecorationController extends Controller
{
    /***
     * 装修服务列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $search_items = [
            'title' => [
                'type' => 'like',
                'form' => 'text',
                'label' => '标题',
            ],
            'type' => [
                'type' => 'equal',
                'form' => 'select',
                'label' => '类型',
                'options' => Decoration::TYPE_ARRAY,
            ],
            'created_at' => [
                'type' => 'date',
            ],
        ];

        $datas = Decoration::latest()
            ->search($search_items)
            ->paginate(20)
        ;
        return _view('admin.serve.decoration.index', compact('datas'));
    }

    /***
     * 装修服务修改页面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $data = Decoration::find($id);
        return view('admin.serve.decoration.edit', compact('data'));
    }

    /***
     * 装修服务修改更新
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(StoreDecorationPost $request, $id)
    {
        $data = Decoration::findOrFail($id);
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
        $data->type = $input['type'];
        $data->name = $input['name'];
        $data->mobile = $input['mobile'];
        $data->address = $input['address'];
        $data->title = $input['title'];
        $data->url = $input['url'];
        $data->top = $input['top'];
        $data->content = $input['content'];
        $data->save();

        admin_action_logs($data, "修改装修服务（{$data->title}）");

        return redirect()->route('admin.decoration.index')->with('msg', '装修服务修改成功');
    }

    /***
     * 装修服务添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        $data = null;
        return view('admin.serve.decoration.edit', compact('data'));
    }

    /***
     * 装修服务添加
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(StoreDecorationPost $request)
    {
        $input = $request->all();

        if (isset($input['file']) && is_object($input['file'])) {

            $file_name = save_image_file($input['file'], 'decoration');
            if (!$file_name) {
                return back()->with('msg', '图片上传失败,请重试!');
            }
            $input['thumbnail'] = $file_name;
            unset($input['_token']);
            unset($input['file']);
        } else {
            return back()->with('msg', '请上传图片');
        }
        $result = Decoration::create($input);
        if ($result) {
            admin_action_logs($result, "添加装修服务（{$result->title}）");
            return redirect()->route('admin.decoration.index')->with('msg', '添加装修服务成功');
        } else {
            return back()->withErrors('添加失败请联系管理员!');
        }

    }


    /**
     * 装修服务开关
     * @param $id
     */
    public function switchStatus($id)
    {
        $data = Decoration::findOrFail($id);
        if ($data->status == 1) {
            $data->status = 2;
        } else {
            $data->status = 1;
        }
        $data->save();

        $action = intval($data->status) === 1 ? '开启' : '关闭';
        admin_action_logs($data, "{$action}装修服务（{$data->title}）");

        return [
            'status' => true,
            'code' => 200,
            'msg' => $action . '装修服务成功',
        ];

    }
}
