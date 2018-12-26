<?php
namespace App\Services\ApiServer\Response;

use Illuminate\Support\Facades\Storage;

class Common{

    public function save_img($number,$params_img,$prefix = null){


        if(is_array($params_img)){
            foreach ($params_img as $key=>$img){
               $img_path = $this->getPath($number,$img,$prefix);
               $path[$key] = $img_path;
            }
        }else{
            $path = $this->getPath($number,$params_img,$prefix);
        }
        return $path;
    }

    public function getPath($number,$img,$prefix = null ){

        $img = base64_decode(explode(',', $img)[1]);
        $str="QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
        $name=substr(str_shuffle($str),26,10);
        $img_name = $prefix.md5(time().$prefix.$name) . '.png';
        $file ="app/public/".$number;
        if (!file_exists(storage_path($file))) {
            mkdir(storage_path($file));
        }
        $path = '/'.$number.'/'.$img_name;
        Storage::disk('public')->put($path, $img);
        return $path;
    }
}