<?php
/**
 * Created by PhpStorm.
 * User: 控哥
 * Date: 2017/11/27
 * Time: 21:46
 */

namespace app\index\model;


use think\Model;

class Daily extends Model
{
    //给模型设置真实的数据表
    protected $table='daily';
    //给数据库的时间设置自保存更新
    protected $autoWriteTimestamp=true;
    protected $updateTime = false;
}