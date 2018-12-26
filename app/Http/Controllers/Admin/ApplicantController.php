<?php

namespace App\Http\Controllers\Admin;

use App\Applicant;
use App\Http\Requests\StoreApplicantRequest;
use App\Http\Controllers\Controller;

class ApplicantController extends Controller
{
    public function index(){
        $search_items = [
            'sex' => [
                'type' => 'like',
                'form' => 'select',
                'label' => '性别',
                'options' => Applicant::SEX,
            ],
            'education' => [
                'type' => 'like',
                'form' => 'select',
                'label' => '学历',
                'options' => Applicant::EDUCATIONS,
            ],
            'created_at' => [
                'type' => 'date',
            ],
        ];

        $datas = Applicant::latest()
            ->search($search_items)
            ->paginate(20)
        ;
        return _view('admin.info.applicant.index',compact('datas'));
    }

    /***
     * 求职详情
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(){

        return view('admin.info.recruitment.show');
    }

    /***
     * 求职修改页面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $data = Applicant::findOrfail($id);
        return view('admin.info.applicant.edit',compact('data'));
    }

    /***
     * 求职修改更新
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(StoreApplicantRequest $request,$id){
        $input = $request->all();
        $applicant = Applicant::findOrfail($id);
        $applicant->update([
            'name' => $input['name'],
            'age' => $input['age'],
            'sex' => $input['sex'],
            'apply_position' => $input['apply_position'],
            'work_experience' => $input['work_experience'],
            'education' => $input['education'],
            'evaluate' => $input['evaluate'],
            'mobile' => $input['mobile']
        ]);

        admin_action_logs($applicant, "修改求职信息（{$applicant->name}）");

        return redirect()->route('admin.applicant.index')->with('msg','求职修改成功');
    }

    /***
     * 求职添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){
        $data = [];
        return view('admin.info.applicant.edit',compact('data'));
    }

    /***
     * 求职添加
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(StoreApplicantRequest $request)
    {
        $input = $request->all();
        $input['current_position'] = $input['apply_position'];
        $applicant = Applicant::create($input);
        if ($applicant) {
            admin_action_logs($applicant, "添加求职信息（{$applicant->name}）");
            return redirect()->route('admin.applicant.index')->with('msg','添加求职成功');
        }
        return back()->withErrors('添加求职信息失败');
    }


    /**
     * 求职开关
     * @param $id
     */
    public function switchStatus($id){
        $applicant = Applicant::findOrFail($id);
        if($applicant->is_hidden=='F'){
            $applicant->is_hidden = 'T';
        }else{
            $applicant->is_hidden = 'F';
        }
        $applicant->save();

        $action = $applicant->is_hidden == 'F' ? '开启' : '关闭';
        admin_action_logs($applicant, "{$action}求职信息（{$applicant->name}）");

        return [
            'status' => true,
            'code' => 200,
            'msg' => $action . '求职信息成功',
        ];
    }
}
