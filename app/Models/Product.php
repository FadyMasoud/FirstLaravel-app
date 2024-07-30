<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'Products';
    protected $fillable = ['id_category','id_showroom','name','images','description','price','speed','type','cylinder','color',
    'brand','model', 'offer', 'stock'
    ];
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(Category::class);
        return $this->belongsTo(Category::class, 'id_category');
    }

    // public function showroom()
    // {
    //     return $this->belongsTo(Showroom::class, 'id_showroom');
    // }

}
