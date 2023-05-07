<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Recipe;

class Recipe extends Model
{
    use HasFactory;

    protected $table = 'recipes';

    protected $fillable = ['user_id','title','recipe'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
