<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class khambenh extends Model
{
    use HasFactory;
    protected $table = "khambenh";
   // public $timestamps = false;
    protected $primaryKey = "KB_ID";
}