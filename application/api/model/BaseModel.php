<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/10/30
 * Time: 17:53
 */

namespace app\api\model;


use think\Model;

class BaseModel extends Model
{
    //    组织图片url绝对路径
    protected function prefixImgUrl($value){
        $finalUrl = config('setting.img_prefix').$value;
        return $finalUrl;
    }
    //    组织项目BP的url绝对路径
    protected function prefixBpUrl($value){
        $finalUrl = config('setting.bp_prefix').$value;
        return $finalUrl;
    }
    //    组织项目路演视频的url绝对路径
    protected function prefixVideoUrl($value){
        $finalUrl = config('setting.video_prefix').$value;
        return $finalUrl;
    }
    //    重命名并存储文件，返回新的文件名数组
    protected static function saveFiles($values,$set_path){
        $name_urls = array();
        foreach($values as $key => $value){
            $file_name = $value['name'];
            $exe_name  = self::getExeName($file_name);
            $data_path = date('Ymd');
            $new_file_name = uniqid().getRandChars(19).'.'.$exe_name;
            $end_path_name = $data_path.'/'.$new_file_name;
            // 判断是否为视频格式，以便获取视频第一帧图片作为封面图
            $ext_ary = config('setting.video_ext_ary');
            if(in_array($exe_name,$ext_ary)){
                $video_name = $new_file_name;
                // 生成视频对应的图片名
                $video_name_ary = explode('.',$video_name);
                array_pop($video_name_ary);
                $video_img_name = implode('.',$video_name_ary).'.jpg';
                $video_img_path_name = $data_path.'/'.$video_img_name;
                // 是视频格式，将视频和视频图片保存到一个数组中
                $name_urls[$key]['video'] = $end_path_name;
                $name_urls[$key]['img'] = $video_img_path_name;
            }else{
                $name_urls[$key] = $end_path_name;
            }
            // 图片文件夹+日期的目录绝对路径
            $absolute_path = $set_path.$data_path;
            if($value['tmp_name']){
                if(!is_dir($absolute_path)){
                    mkdir($absolute_path);
                }
                move_uploaded_file($value['tmp_name'],$set_path.$end_path_name);
                // 保存视频第一帧图片
                if(in_array($exe_name,$ext_ary)) {
                    $img_path = $set_path . $video_img_path_name;
                    $str = "ffmpeg -i " . $set_path.$end_path_name . " -y -f mjpeg -ss 0 -t 1 -s 740x500 " . $img_path;
                    exec($str);
                }
            }
        }
        return $name_urls;
    }
    //    获取文件扩展名
//    protected static function saveFiles($values,$set_path,$video_url){
//        $name_urls = array();
//        if(empty($video_url) && $set_path){
//            foreach($values as $key => $value){
//                if(is_array($value)){
//                    $name_urls = self::renameMoveFile($value,$key,$set_path);
//                }
//            }
//        }elseif(empty($set_path) && $video_url){
//            foreach($values as $key => $value){
//                if(is_array($value)){
//                    $name_urls = self::renameMoveFile2($value,$key,$video_url);
//                }
//            }
//        }
//        return $name_urls;
//    }
    //获取文件扩展名（后缀）
    protected static function getExeName($fileName){
        $pathinfo = pathinfo($fileName);
        return strtolower($pathinfo['extension']);
    }
    //执行文件重命名保存
//    protected static function renameMoveFile($file,$key,$set_path){
//        $file_name = $file['name'];
//        $exe_name = self::getExeName($file_name);
//        $data_path = date('Ymd');
//        $new_file_name = uniqid().getRandChars(19).'.'.$exe_name;
//        $end_path_name = $data_path.'/'.$new_file_name;
//        $name_urls[$key] = $end_path_name;
//        // 图片文件夹+日期的目录绝对路径
//        $absolute_path = $set_path.$data_path;
//        if($file['tmp_name']){
//            if(!is_dir($absolute_path)){
//                mkdir($absolute_path);
//            }
//            move_uploaded_file($file['tmp_name'],$set_path.'/'.$end_path_name);
//        }
//        return $name_urls;
//    }
//    protected static function renameMoveFile2($file,$key,$url){
//        $file_name = $file['name'];
//        $exe_name = self::getExeName($file_name);
//        $video_url_ary = explode('.',$url['item_video_url']);
//        array_pop($video_url_ary);
//        $video_img_url = implode('.',$video_url_ary).$exe_name;
//        $name_urls[$key] = $video_img_url;
//        if($file['tmp_name']){
//            move_uploaded_file($file['tmp_name'],$video_img_url);
//        }
//        return $name_urls;
//    }

}