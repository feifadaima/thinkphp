<?php

namespace app\index\model;

use think\Model;

class User extends Model
{
    protected $table = 'admin';
    protected $autoWriteTimestamp=true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';

}
