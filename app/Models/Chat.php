<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Chat;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chats';

    protected $fillable = ['user_id','text','date','count'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
