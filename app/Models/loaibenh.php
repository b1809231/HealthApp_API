<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class loaibenh extends Model
{
    use HasFactory;
    protected $table = "chuyenkhoa";
   // public $timestamps = false;
    protected $primaryKey = "KB_ID";
}