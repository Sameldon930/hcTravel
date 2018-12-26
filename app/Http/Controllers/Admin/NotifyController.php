<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNotifyRequest;
use App\Notify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_items = [
            'title' => [
                'type' => 'like',
                'form' => 'text',
                'label' => '标题',
            ],
            'created_at' => [
                'type' => 'date',
            ],
        ];

        $datas = Notify::latest()
            ->search($search_items)
            ->paginate(20)
        ;
        return _view('admin.operation.notify.index',compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotifyRequest $request)
    {
        $input = $request->all();

        $result = Notify::create($input);
        if($result){
            return redirect()->route('admin.notify.index')->with('msg','添加公告成功');
        }else {
            return back()->withErrors('添加失败请联系管理员!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notify  $notify
     * @return \Illuminate\Http\Response
     */
    public function show(Notify $notify)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notify  $notify
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Notify::find($id);
        return view('admin.operation.notify.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notify  $notify
     * @return \Illuminate\Http\Response
     */
    public function update(StoreNotifyRequest $request, $id)
    {
        $data = Notify::findOrFail($id);
        $input = $request->all();

        $data->admin_id = Auth::user()->id;
        $data->title = $input['title'];
        $data->content = $input['content'];
//        $data->status = $input['status'];
//        $data->type = $input['type'];
        $data->save();

        return redirect()->route('admin.notify.index')->with('msg','公告通知修改成功');


    }

    public function add()
    {
        $data = null;
        return view('admin.operation.notify.edit',compact('data'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notify  $notify
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notify $notify)
    {
        //
    }

    public function switchStatus($id){

        $group = Notify::findOrFail($id);
        if($group->status==1){
            $group->status = 2;
        }else{
            $group->status = 1;
        }
        $group->save();

        $action = intval($group->status) === 1 ? '开启' : '关闭';

        return [
            'status' => true,
            'code' => 200,
            'msg' => $action . '公告通知成功',
        ];
    }
}
