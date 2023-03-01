<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class duoc extends Model
{
    use HasFactory;
    protected $table = "duoc";
   // public $timestamps = false;
    protected $primaryKey = "D_ID";

    public function layloaid(){
        return $this->belongsTo("App\\Models\\loaiduoc","LD_ID","LD_ID");
    }
}
