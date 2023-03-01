<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class loaiduoc extends Model
{
    use HasFactory;
    protected $table = "loaiduoc";
   // public $timestamps = false;
    protected $primaryKey = "LD_ID";
}