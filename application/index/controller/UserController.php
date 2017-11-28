<?php
/**
 * Created by PhpStorm.
 * User: 控哥
 * Date: 2017/11/24
 * Time: 16:12
 */

namespace app\index\controller;


use app\index\model\Daily;
use app\index\model\User;
use think\Controller;
use think\Db;

class UserController extends Controller
{
        public $a='闭包函数';
        public function __construct()
        {
            \think\Hook::add('zzzz',function($a){
                $controller=request()->controller();
                $action=request()->action();
                $daiLy=new Daily();
                $daiLy->controller=$controller;
                $daiLy->action=$action;
                $daiLy->save();
            });
            \think\Hook::listen('zzzz',$a);
            //parent::__construct($request);
        }

    public function index(){
       // var_dump(request());exit;
        return view('index');
    }

    public function add(){
        $user=new User();
//        var_dump(request()->post('username'));exit;
        $user->username=request()->post('username');
        $user->password=request()->post('password');
        if($user->save()){
            //设置成功后跳转页面的地址，默认的返回页面是$_SERVER['HTTP_REFERER']
            $this->success('新增成功', 'User/all');
        } else {
            //错误页面的默认跳转页面是返回前一页，通常不需要设置
            $this->error('新增失败');
        }
        //return $this->fetch('add');
    }

    public function all(){

        $user=new User();
        $users=$user->select();
//        var_dump($users);exit;
        return view('all',compact('users'));
    }
    public function login(){
//        $user=Db::table('admin')->where('username',request()->post('password'))->find();

//
        if(request()->post()){
            //$user=request()->post('username');
//            var_dump($user);exit;
            $user=Db::table('admin')->where('username',request()->post('username'))->find();
            $users=User::get($user);
//            var_dump($users->username);exit;
            if($users->username==request()->post('username')){
                if($users->password==request()->post('password')){
                    return $this->redirect('all');
                }else{
                    $this->error('密码错误');
                }
            }else{
                $this->error('用户名错误');
            }
        }
        return view('login');
    }
    public function edit($id){
       // $user=Db::table('admin')->where('id',$id)->find();
        //根据id获取整条数据
        $user=User::get($id);
    //判断是否为post提交
    if(request()->isPost()){
    if($user->save(request()->post())){
        $this->success('修改成功','all');
    }else{
        $this->error('修改失败');
    }
}
        return view('edit',compact('user'));
    }
    public function del($id){

        if(User::get($id)->delete()){
            $this->success('删除成功','all');
        }
    }



}