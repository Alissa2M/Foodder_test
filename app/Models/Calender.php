<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Category;
use App\Models\Like;
use App\Models\Calender;

use Auth;

class Calender extends Model
{
    use HasFactory;

    protected $table = 'calenders';

    // アクセサ
    protected $appends = [
        'likes_count', 'liked_by_user',
    ];

    protected $fillable = [
        'title',
        'description',
        'start',
        'img_path',
        'user_id',
        'category_id',
        'shop_name',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }
    
    /**
     * アクセサ - likes_count
     * @return integer
     */
    public function getLikesCountAttribute()
    {
        return $this->likes->count();
    }
    /**
     * そのコメントにログインユーザー（プロフィール）がすでにいいねをおしているかチェック
     * アクセサ - liked_by_user
     * @return boolean
     */
    public function getLikedByUserAttribute()
    {
        if (Auth::guest()) {
            return false;
        }

        return $this->likes->contains(function ($user) {
            return $user->id === Auth::id();
        });
    }
}
