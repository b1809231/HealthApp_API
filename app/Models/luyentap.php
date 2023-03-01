<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class luyentap extends Model
{
    use HasFactory;
    protected $table = "luyentap";
   // public $timestamps = false;
    protected $primaryKey = "LT_ID";
    
}
