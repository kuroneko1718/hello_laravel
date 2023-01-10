<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * $table字段指定User模型对应的数据表users
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     * 只有指定字段才能正常的更新修改（自动过滤掉用户提交的字段）
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     * 指定字段（用户密码等其他密码信息）在用数组或者json格式传输时显示时隐藏
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 获取个人头像
     *
     * @param String $size
     * 
     * @return [type]
     * 
     */
    public function gravatar(String $size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    /**
     * 用户模型类完成初始化之后就自动加载boot方法
     *
     * @return [type]
     * 
     */
    public static function boot()
    {
        parent::boot();
        // 使用事件监听模型创建之前的动作creating ，生成用户邮箱验证token
        static::creating(function ($user) {
            $user->activation_token = str_random(30);
        });
    }

    /**
     * 关联status模型
     * 指明user模型对于status模型为一对多关系
     *
     * @return [type]
     * 
     */
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    /**
     * 首页微博动态拉取
     *
     * @return [type]
     * 
     */
    public function feed()
    {
        // 只拉取所有自己的动态展示
        // return $this->statuses()->orderBy('created_at', 'desc');
        // 获取所有关注的人和自己的user_id，从status表中查出所有所有属于这些user_ids的动态
        $user_ids = $this->followings->pluck('id')->toArray();
        // User::followings 返回的是Eloquent模型集合
        // User::followings() 返回的是数据库请求构造器
        // User::followings()->get();  /  User::followings()->paginate();
        array_push($user_ids, $this->id);
        return Status::whereIn('user_id', $user_ids)->with('user')->orderBy('created_at', 'desc');
    }

    /**
     * 设置用户和粉丝的关系联系(user_id, followers_id)
     *
     * @return [type]
     * 
     */
    public function followers()
    {
        // 因为在此案例中无论是被关注者还是粉丝都是user表中的用户
        // 设置两个表(user, user)之间的关系连接
        // laravel默认会把多对多的关系再定义一张由两张表命名的关系表中(user_user)
        // 用户也可以自定义关系表名、主表和从属表关联的字段
        // belongsToMany(Model ModelClass, 'relations_table_name', 'primary_table_foreign_key', 'secondary_table_local_key');
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    /**
     * 设置用户与关注人的关系联系(follower_id, user_id)
     *
     * @return [type]
     * 
     */
    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    /**
     * 关注用户
     * 生成用户于关注者之间联系
     *
     * @param mixed $user_ids
     * 
     * @return [type]
     * 
     */
    public function follow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        // $this->followings()->attach($user_ids);
        $this->followings()->sync($user_ids, false);
    }

    /**
     * 取消关注
     * 删除用户与关注者之间联系
     *
     * @param mixed $user_ids
     * 
     * @return [type]
     * 
     */
    public function unfollow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }

    /**
     * 判断用户是否已经关注
     *
     * @param mixed $user_id
     * 
     * @return [type]
     * 
     */
    public function isFollowing($user_id)
    {
        return $this->followings()->contains($user_id);
    }

    public function getFollowings()
    {
        return $this->followings()->allRelatedIds()->toArray();
    }
}
