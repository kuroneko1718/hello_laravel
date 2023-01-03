<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
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
