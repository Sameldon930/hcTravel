<?php

namespace App\Http\Controllers\Admin;

use App\ApartmentRent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApartmentRentRequest;


class ApartmentRentController extends Controller
{
    /***
     * 招租列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        $search_items = [
            'title' => [
                'type' => 'like',
                'form' => 'text',
                'label' => '标题',
            ],
            'rent_way' => [
                'type' => 'equal',
                'form' => 'select',
                'label' => '租凭方式',
                'options' => ApartmentRent::RENT_WAYS,
            ],
            'created_at' => [
                'type' => 'date',
            ],
        ];
        $datas = ApartmentRent::latest()
            ->search($search_items)
            ->paginate(20);
        return _view('admin.info.apartment_rent.index',compact('datas'));
    }

    /***
     * 招租详情
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(){

        return view('admin.info.apartment_rent.show');
    }

    /***
     * 招租修改页面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $data = ApartmentRent::findOrFail($id);
        return view('admin.info.apartment_rent.edit',compact('data'));
    }

    /***
     * 招租修改更新
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(StoreApartmentRentRequest $request,$id){
        $data = ApartmentRent::findOrFail($id);
        $input = $request->all();

        if (isset($input['file']) && is_object($input['file'])) {
            $file_name = save_image_file($input['file'], 'apartment_rent');
            if (!$file_name) {
                return back()->with('msg', '图片上传失败,请重试!');
            }
            $input['thumbnail'] = $file_name;
            $data->thumbnail = $input['thumbnail'];
        }

        if (isset($input['image']) && is_object($input['image'])) {
            $file_name = save_image_file($input['image'], 'apartment_rent_image');
            if (!$file_name) {
                return back()->with('msg', '图片上传失败,请重试!');
            }
            $input['image'] = $file_name;
            $data->image = $input['image'];
        }

        $data->title = $input['title'];
        $data->rental = $input['rental'];
        $data->house_type = $input['house_type'];
        $data->rent_way = $input['rent_way'];
        $data->payment_mode = $input['payment_mode'];
        $data->region = $input['region'];
        $data->mobile = $input['mobile'];
        $data->content = $input['content'];

        $data->save();

        admin_action_logs($data, "修改招租信息（{$data->title}）");

        return redirect()->route('admin.apartment_rent.index')->with('msg','招租信息修改成功');
    }

    /***
     * 招租添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){
        $data = [];
        return view('admin.info.apartment_rent.edit',compact('data'));
    }

    /***
     * 招租添加
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(StoreApartmentRentRequest $request){
        $input = $request->all();

        if (isset($input['file']) && is_object($input['file'])) {

            $file_name = save_image_file($input['file'], 'apartment_rent');
            if (!$file_name) {
                return back()->with('msg', '图片上传失败,请重试!');
            }
            $input['thumbnail'] = $file_name;
            unset($input['_token']);
            unset($input['file']);
        }else{
            return back()->with('msg', '请上传图片');
        }

        if (isset($input['image']) && is_object($input['image'])) {

            $file_name = save_image_file($input['image'], 'apartment_rent_image');
            if (!$file_name) {
                return back()->with('msg', '图片上传失败,请重试!');
            }
            $input['image'] = $file_name;
            unset($input['_token']);
            unset($input['file']);
        }else{
            return back()->with('msg', '请上传图片');
        }

        $result = ApartmentRent::create($input);
        if($result){
            admin_action_logs($result, "添加招租信息（{$result->title}）");
            return redirect()->route('admin.apartment_rent.index')->with('msg','添加招租成功');
        }else {
            return back()->withErrors('添加失败请联系管理员!');
        }

    }


    /**
     * 招租开关
     * @param $id
     */
    public function switchStatus($id){
        $apartment = ApartmentRent::findOrFail($id);
        if($apartment->is_hidden=='F'){
            $apartment->is_hidden = 'T';
        }else{
            $apartment->is_hidden = 'F';
        }
        $apartment->save();

        $action = $apartment->is_hidden == 'F' ? '开启' : '关闭';
        admin_action_logs($apartment, "{$action}招租信息（{$apartment->title}）");

        return [
            'status' => true,
            'code' => 200,
            'msg' => $action . '招租信息成功',
        ];
    }
}
