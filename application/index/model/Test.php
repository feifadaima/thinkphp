<?php
/**
 * Created by PhpStorm.
 * User: 控哥
 * Date: 2017/11/25
 * Time: 14:23
 */

namespace app\index\model;


use think\Model;

class Test extends Model
{
    //给模型设置真实的数据表
    protected $table='admin';
    //给数据库的时间设置自保存更新
    protected $autoWriteTimestamp=true;
    protected $createTime='created_at';
    protected $updateTime='updated_at';

    public function getStatusAttr($value){
        $status = [0=>'删除',1=>'禁用',2=>'正常',3=>'待审核'];
        return $status[$value];
    }
}