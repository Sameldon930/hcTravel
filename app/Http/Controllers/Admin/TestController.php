<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
//测试控制器
class TestController extends Controller
{

    public function laravel_log(Request $request)
    {
        $name = $request->get('name', '');

        if ($name) {
            $file = config('filesystems.disks.logs')['root'] . '/' . $name;
            return response()->download($file);

            //echo(Storage::disk('logs')->get($name));exit;
        }

        $storage = Storage::disk("logs");
        $logs = $storage->files();


        foreach ($logs as $log) {
            if ($log !== '.gitignore') {
                $href = $request->url() . "?name={$log}";
                echo "<a href='{$href}'>{$log}</a>" . "<br>";
            }
        }
    }

}
