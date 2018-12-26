<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ApiServer\Server;
use App\Services\ApiServer\ServerSaveImg;
use App\Services\ApiServer\Error;
use SebastianBergmann\GlobalState\Restorer;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Validator;
/**
 * 公共Api入口控制器
 * @author linkin 2017-06-06
 */
class ApiController extends Controller
{
    /**
     * API总入口
     * @return [type] [description]
     */
    public function index()
    {
        if(!empty($_FILES)){
            $server = new ServerSaveImg(new Error);
            return $server->run();
        }

        $server = new Server(new Error);
        return $server->run();
    }
    
}
