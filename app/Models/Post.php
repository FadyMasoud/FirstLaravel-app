<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'Posts';
    protected $fillable = ['user_id', 'title', 'body','images'];
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
        return $this->belongsTo(User::class, 'user_id');

        // or // return $this->belongsTo(User::class, 'user_id', 'id');

    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
