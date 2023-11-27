<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hipotesis extends Model
{
    use HasFactory;
    protected $fillable =  ['user_id','hipotese_desc'];
}
