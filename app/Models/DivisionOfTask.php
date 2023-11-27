<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DivisionOfTask extends Model
{
    use HasFactory;
    protected $fillable =  ['user_id','group_name','student_name_1','jobdesc_1','student_name_2','jobdesc_2','student_name_3','jobdesc_3','student_name_4','jobdesc_4','student_name_5','jobdesc_5']; 
}
