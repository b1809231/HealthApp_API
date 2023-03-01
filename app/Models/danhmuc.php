<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class danhmuc extends Model
{
    use HasFactory;
    protected $table = "chuyenkhoa";
   // public $timestamps = false;
    protected $primaryKey = "CK_ID";
}