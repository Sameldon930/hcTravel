<?php

namespace App\Http\Controllers\Admin;

use App\Feedback;
use App\Merchant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    /***
     * 意见反馈
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){

        if ($request->isMethod('post')) {
            $input = $request->all();
            $id = trim($input['id']);
            $replay = trim($input['replay']);
            $list_data = Feedback::find($id);
            $list_data->is_read = 0;
            if ($list_data->feedback == null) {
                $new_replay = '<div class="feedback">'.$replay.'</div>';
            } else {
//                $new_replay = $list_data->feedback . '<div style = "border-top:1px dashed gray;">追加回复：' . $replay . "</div>";
                $new_replay = $list_data->feedback . '<div class = "feedback"><div class="feedback-item">追加回复：</div><div class="feedback-reply">' . $replay . "</div></div>";
            }

            // 添加操作日志
            $user_name = Merchant::find($list_data->merchant_id)->name ?? "未知商户";
            $action_name = $list_data->updated_at == null ? "追加回复" : "回复";
            $note = "{$action_name}（{$user_name}）";
            $arr = $list_data;
            admin_action_logs($arr, $note);

            $list_data->feedback = $new_replay;
            $list_data->save();

            return redirect()->route('admin.feedback.index')->with('msg', "回复成功");

        }
        //判断选项回复
        $reply_status = isset($request->reply_status) ? $request->reply_status : 1;
        $data = DB::table('feedback as fb')
            ->join('merchants as m', 'fb.merchant_id', '=', 'm.id')
            ->select('fb.*', 'm.mobile', 'm.name')
            ->orderBy('fb.id', 'desc');
        if ($reply_status == 3) {
            $list_data = $data->where('fb.updated_at', null)//未回复
                ->paginate(20);
        } else if ($reply_status == 2) {
            $list_data = $data->where('fb.updated_at', '!=', null)//已回复
                ->paginate(20);
        } else {
            $list_data = $data->paginate(20);//全部
        }
        return view('admin.operation.feedback.index', compact('list_data', 'single_data', 'reply_status'));
    }


}
