<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Category;

class Calender extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start',
        'img_path',
        'user_id',
        'category_id',
        'anonymous',
        'shop_name',
    ];

    protected $casts = [
        'anonymous' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
