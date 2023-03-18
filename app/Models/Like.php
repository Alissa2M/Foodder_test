<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Calender;
use App\Models\User;
use App\Models\Like;

class Like extends Model
{
    use HasFactory;

    protected $table = 'likes';

    protected $fillable = ['calender_id','user_id'];

    public function calender()
    {
    return $this->belongsTo(Calender::class);
    }

    public function user()
    {
    return $this->belongsTo(User::class);
    }
}
