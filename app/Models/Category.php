<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Calender;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    public function calender()
    {
        return $this->hasMany(Calender::class);
    }
}
