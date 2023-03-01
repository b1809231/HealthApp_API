<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sotiem extends Model
{
    use HasFactory;
    protected $table = "sotiem";
   // public $timestamps = false;
    protected $primaryKey = "ST_ID";
}