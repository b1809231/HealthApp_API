<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lichtuvan extends Model
{
    use HasFactory;
    protected $table = "lichtuvan";
   // public $timestamps = false;
    protected $primaryKey = "L_ID";
    protected $fillable = ['NV_ID', 'ND_ID', 'L_NGAYDANGKY', 'L_GIODANGKY','L_GHICHU','L_TRANGTHAI'];
    public function laytennv(){
        return $this->belongsTo("App\\Models\\nhanvien","NV_ID","NV_ID");
    }
    public function laytennd(){
        return $this->belongsTo("App\\Models\\nguoidung","ND_ID","ND_ID");
    }
}