<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chiso extends Model
{
    use HasFactory;
    protected $table = "chiso";
   // public $timestamps = false;
    protected $primaryKey = "CS_ID";
}