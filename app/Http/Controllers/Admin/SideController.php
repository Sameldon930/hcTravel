<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreSidePost;
use App\Side;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDecorationPost;


class SideController extends Controller
{
    /***
     * 幻灯片
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $datas = Side::paginate(20);
        return view('admin.operation.side.index',compact('datas'));
    }

    /***
     * 幻灯片修改页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $data = Side::find($id);
        return view('admin.operation.side.edit',compact('data'));
    }

    /***
     * 幻灯片修改更新
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(StoreSidePost $request,$id){
        $data = Side::findOrFail($id);
        $input = $request->all();

        if (isset($input['file']) && is_object($input['file'])) {
            $file_name = save_image_file($input['file'], 'side');
            if (!$file_name) {
                return back()->with('msg', '图片上传失败,请重试!');
            }
            $input['image'] = $file_name;
            $data->image = $input['image'];
        }

        $data->note = $input['note'];
        $data->url = $input['url'];
        $data->orderby = $input['orderby'];
        $data->save();


        return redirect()->route('admin.side.index')->with('msg','幻灯片修改成功');
    }

    /***
     * 幻灯片添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){
        $data = null;
        return view('admin.operation.side.edit',compact('data'));
    }

    /***
     * 幻灯片添加
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(StoreSidePost $request){
        $input = $request->all();

        if (isset($input['file']) && is_object($input['file'])) {

            $file_name = save_image_file($input['file'], 'decoration');
            if (!$file_name) {
                return back()->with('msg', '图片上传失败,请重试!');
            }
            $input['image'] = $file_name;
            unset($input['_token']);
            unset($input['file']);
        }else{
            return back()->with('msg', '请上传图片');
        }

        $input['url'] = $input['url'];
        $input['note'] = $input['note'];
        $input['orderby'] = $input['orderby'];
        $result = Side::create($input);
        if($result){
            return redirect()->route('admin.side.index')->with('msg','幻灯片添加成功');
        }else {
            return back()->withErrors('添加失败请联系管理员!');
        }
    }

    /***
     * 幻灯片开关
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function switchStatus($id){
        $data = Side::findOrFail($id);
        if($data->status==1){
            $data->status = 2;
        }else{
            $data->status = 1;
        }
        $data->save();

        return [
            'status' => true,
            'code' => 200,
            'msg' => intval($data->status) === 1 ? '幻灯片开启成功' :'幻灯片关闭成功',
        ];
    }
}
