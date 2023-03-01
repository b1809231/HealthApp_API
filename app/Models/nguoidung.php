<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nguoidung extends Model
{
    use HasFactory;
    protected $table = "nguoidung";
   // public $timestamps = false;
    protected $primaryKey = "ND_ID";
}