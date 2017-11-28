<?php
/**
 * Created by PhpStorm.
 * User: 控哥
 * Date: 2017/11/27
 * Time: 15:13
 */

namespace app\index\controller;


use app\index\model\User;
use think\Db;

class ApiController extends TestController
{
    //用户登录
    public function login($username, $pwd)
    {
        $username = Db::name('admin')->where(['username' => $username])->find();
        if ($username) {
            if ($username['password'] == $pwd) {
                $result = [
                    "id" => $username['id'],
                    "userName" => $username['username'],
                    "userIcon" => '',
                    "waitPayCount" => 5,
                    "waitReceiveCount" => 2,
                    "userLevel" => 5
                ];
                return $this->api($result);
            } else {
                return $this->api(null, false, '密码错误');
            }
        } else {
            return $this->api(null, false, '用户名错误');
        }
    }

    //用户注册
    public function regist()
    {
        $a = request()->post();
//        echo $a['username'];
        if ($a['username'] && $a['pwd']) {
            $user = new User();
            $user->username = $a['username'];
            $user->password = $a['pwd'];
            if ($user->save()) {
                $result = [
                    "id" => $user->id
                ];
                return $this->api($result, true, '注册成功');
            } else {
                return $this->api(null, false, '注册失败');
            }
        } else {
            return $this->api(null, false, '用户名或密码不能为空');
        }
    }
    //用户密码重置
    public function reset()
    {
        $a = request()->post();
        $username = Db::name('admin')->where(['username' => $a['username']])->find();
        $username['password']='';
        $user = new User($username);
//        var_dump($user->username);
//        $user->password = null;
        if ($user->update($username)) {
            return $this->api(null);
        } else {
            return $this->api(null, false, '重置失败');
        }
    }

    //首页banner
    public function banner($adKind)
    {
        $goods=Db::name('goods')->select();
        foreach ($goods as $k=>$good) {
        $result = [[
            "id" => $goods[$k]['id'],
            "type" => $goods[$k]['status'],
            "adUrl" => $goods[$k]['logo'],
            "webUrl" => "如果是跳转网页类型，则返回网页地址",
            "adKind" => $adKind,
        ]];}
        return $this->api($result);
    }

    //秒杀商品
    public function seckill()
    {
        $goods=Db::name('goods')->select();
        foreach ($goods as $k=>$good) {
            $result = [
                "total" => $goods[$k]['stock'],
                "rows" => [
                    [
                        "allPrice" => $goods[$k]['market_price'],
                        "pointPrice" => $goods[$k]['store_price'],
                        "iconUrl" => $goods[$k]['logo'],
                        "timeLeft" => 3,
                        "type" => $goods[$k]['status'],
                        "productId" => $goods[$k]['id']
                    ]
                ]
            ];
        }
        return $this->api($result);
    }
    //猜你喜欢
    public function getYourFav()
    {
        $goods=Db::name('goods')->select();
        foreach ($goods as $k=>$good){
            $result = [
                "total" => $goods[$k]['stock'],
                "rows" => [
                    [
                        "price" => $goods[$k]['store_price'],
                        "name" => $goods[$k]['name'],
                        "iconUrl" => $goods[$k]['logo'],
                        "productId" => $goods[$k]['id']
                    ]
                ]
            ];
        }
        return $this->api($result);
    }
    //商品信息
    public function productInfo($id)
    {
        $good = Db::name('goods')->where(['id' => $id])->find();
        $result =[
        "id" => $good['id'],
        "imgUrls" => [
            $good['logo'],
            "商品图片路径"],
        "price" => $good['store_price'],
        "ifSaleOneself" =>  $good['status'],
        "name" =>  $good['name'],
        "recomProductId" => "推荐商品id",
        "stockCount" =>  $good['stock'],
        "commentCount" =>  $good['sn'],
        "typeList" => [
            "麦片巧克力",
            "商品版本"
        ],
        "favcomRate" => '好评率',
        "recomProduct" => "推荐商品标题"
    ];
        return $this->api($result);
    }
    //获取省份
    public function province(){
        $province=Db::name('address')->select();
        foreach ($province as $k=>$v){
            $result=[
                'name'=>$province[$k]['province']
            ];
        }
        return $this->api($result);
    }
    //获取城市
    public function city($province){
        $address=Db::name('address')->where(['province'=>$province])->find();
        $result=[
            'name'=>$address['city']
        ];
        return $this->api($result);
    }
    //获取地区
    public function area($city){
        $address=Db::name('address')->where(['city'=>$city])->find();
        $result=[
            'name'=>$address['county']
        ];
        return $this->api($result);
    }
    //获取订单详细
    public function getOrderDetail($userId,$id){
        $indents=Db::name('indent')->where(['member_id'=>$id])->select();
        $indent_intros=Db::name('indent_intro')->where(['indent_id'=>$userId])->select();
        //var_dump($indents);
        $result=[];
        foreach ($indents as $k=>$indent){
            $result["address"]=[
                "receiverAddress"=>$indents[$k]['province_name'].$indents[$k]['city_name'].$indents[$k]['county_name'],
                "isDefault"=>'',
                "receiverPhone"=>$indents[$k]['phone'],
                "receiverName"=>$indents[$k]['name'],
                "id"=>$indents[$k]['id']];
        }
        foreach ($indents as $k=>$indent) {
            $result['buyTime'] = [
                "buyTime"=>$indents[$k]['create_time'],
                "freight"=>$indents[$k]['delivery_price'],
            ];
        }
        foreach ($indent_intros as $k=>$indent_intro) {
            $result['items'] = [
                "amount"=>$indent_intros[$k]['price'],
                "buyCount"=>'购买数'.$indent_intros[$k]['amount'],
                "piconUrl"=>$indent_intros[$k]['logo'],
                "pid"=>'商品id'.$indent_intros[$k]['goods_id'],
                "pname"=>"商品名称".$indent_intros[$k]['goods_name'],
                "version"=>"商品版本"
            ];
        }
        foreach ($indents as $k=>$indent) {
            $result['items'] = [
                "oid"=>$indents[$k]['id'],
                "orderNum"=>$indents[$k]['trade_no'],
                "paid"=>$indents[$k]['status'],
                "payWay"=>$indents[$k]['pay_name'],
                "status"=>$indents[$k]['status'],
                "version"=>"商品版本",
                "tn"=>"订单令牌",
                "totalPrice"=>$indents[$k]['price'],
            ];
        }
        return $this->api($result);
    }

}