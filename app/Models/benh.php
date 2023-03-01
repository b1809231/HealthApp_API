<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class benh extends Model
{
    use HasFactory;
    protected $table = "benh";
   // public $timestamps = false;
    protected $primaryKey = "B_ID";
    public function layloaid(){
        return $this->belongsTo("App\\Models\\loaibenh","CK_ID","CK_ID");
    }
}