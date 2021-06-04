<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public $directory = "/edwin_laravel/myProject/public/images/";

    protected $fillable = ['title','content','user_id','ipath'];

    /** 
     * laravel course functions
     */
    public function user() {
        return $this->belongsTO('App\User');
    }

    // polymorphic relation
    public function photos(){
        return $this->morphMany('App\Photo','imageable');
    }

    public function tags(){
        return $this->morphToMany('App\Tag','taggable');
    }

    /**
     * query scope
     * convention [1st=>scope, 2nd=>methodname{cammelCase wise}]
     */
    public function scopeRecent($query){
        return $query->orderBy('id','asc')->get();
    }

    /**
     * post image path Accessor
     */
    public function getIpathAttribute($value) {
        return $this->directory. $value;
    }
}
