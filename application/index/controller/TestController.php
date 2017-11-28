<?php
/**
 * Created by PhpStorm.
 * User: 控哥
 * Date: 2017/11/25
 * Time: 14:19
 */

namespace app\index\controller;


use app\index\model\Test;
use think\Controller;
use think\Db;

class TestController extends Controller
{
    public function index(){

//        $user = Test::get(1);
//        echo $user->status;exit;
        $user=db('admin')->select();
//        $a=$user['status'];

//        var_dump($user);exit;
        return $this->fetch('index',compact('user'));
    }
    public function add(){

        if (request()->isPost()){
//            var_dump(request()->post());exit;
            $test=new Test($_POST);
            if($test->allowField(['status','password'])->save()){
                $this->success('添加成功','index');
            }else{
                $this->error('添加失败');
            }
        }
        return $this->fetch('add');
    }
    public function edit($id){

        $user=Db::table('admin')->find($id);
        if(request()->isPost()){
            $users=new Test();
            $result=$users->save([
                'username'=>request()->post('username'),
                'password'=>request()->post('password'),
                'status'=>request()->post('status'),
            ],['id'=>$id]);
            if($result===false){
                $this->error('修改失败');
            }else{
                $this->success('修改成功','index');
            }
        }
//    dump($user);exit;
        return $this->fetch('edit',compact('user'));
    }
    protected function api($result,$success = true, $errorMsg = "")
    {

        $result = [
            "success" => $success,
            "errorMsg" => $errorMsg,
            "result" => $result
        ];
        return json($result);
    }
}