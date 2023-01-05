<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    /**
     * 允许用户提交信息修改的status模型的字段
     *
     * @var array
     */
    protected $fillable = [
        'content'
    ];

    /**
     * 关联user模型
     * 指明status模型是user模型的从属
     *
     * @return [type]
     * 
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
