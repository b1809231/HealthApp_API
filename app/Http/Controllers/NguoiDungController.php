<?php

namespace App\Http\Controllers;

use App\Models\danhmuc;
use App\Models\nguoidung;
use App\Models\nhanvien;
use App\Models\lichtuvan;
use App\Models\chiso;
use App\Models\khambenh;
use App\Models\sotiem;
use App\Models\duoc;
use App\Models\benh;
use App\Models\luyentap;
use App\Models\bantin;
use App\Models\thongbao;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class NguoiDungController extends Controller
{
    // --------------------------------------get-------------------------------//
    //---------------------------get nguoi dung-----------------------//

    public function apinguoidung()
    {
        $nguoidung = DB::table('nguoidung')->get();
        return $res = [
            'nguoidung' => $nguoidung,
        ];
    }
    // ----------------------------get thong bao-------------------------//
    public function apithongbao()
    {
        $thongbao = DB::table('thongbao')->get();
        return $res = [
            'thongbao' => $thongbao,
        ];
    }

    // -----------------------------------------//
    public function apinhanvien()
    {
        $nhanvien = DB::table('nhanvien')->get();
        return $res = [
            'nhanvien' => $nhanvien,
        ];
    }
    public function topnv()
    {
        $top3 = DB::table('lichtuvan')->join('nhanvien', 'lichtuvan.NV_ID', 'nhanvien.NV_ID')
            ->select('nhanvien.NV_HINHANH', 'nhanvien.NV_HOTEN', 'nhanvien.NV_MAIL', 'nhanvien.NV_SDT', DB::raw('count(lichtuvan.L_ID) as tong'))
            ->groupBy('nhanvien.NV_HINHANH', 'nhanvien.NV_HOTEN', 'nhanvien.NV_MAIL', 'nhanvien.NV_SDT')->orderByDesc('tong')->limit(3)->get();
        return $res = [
            'top3' => $top3,
        ];
    }
    public function apilichtuvan()
    {
        $lichtuvan = DB::table('lichtuvan')->get();
        $lichtuvan = DB::table('lichtuvan')->join('nguoidung', 'lichtuvan.ND_ID', 'nguoidung.ND_ID')
            ->join('nhanvien', 'lichtuvan.NV_ID', 'nhanvien.NV_ID')
            ->get();
        return $res = [
            'lichtuvan' => $lichtuvan,
        ];
    }
    public function apiduoc()
    {
        $duoc = DB::table('duoc')->join('loaiduoc', 'duoc.LD_ID', 'loaiduoc.LD_ID')->select('duoc.*', 'loaiduoc.*')->get();
        return $res = [
            'duoc' => $duoc,

        ];
    }
    public function apiloaiduoc()
    {
        $loaiduoc = DB::table('loaiduoc')->get();
        return $res = [
            'loaiduoc' => $loaiduoc,
        ];
    }
    public function apibantin()
    {
        $bantin = DB::table('bantin')->get();
        return $res = [
            'bantin' => $bantin,
        ];
    }
    public function apidanhmuc()
    {
        $danhmuc = danhmuc::all();
        $nhanvien = DB::table('nhanvien')->where('NV_QUYENSD', 1)->get();
        return $res = [
            'danhmuc' => $danhmuc,
            'nhanvien' => $nhanvien
        ];
    }
    // --------------------------get kham benh---------------------------//
    public function apikhambenh($id)
    {
        $khambenh = khambenh::where('ND_ID', $id)
            ->select('KB_NGAYKHAM', 'KB_CHUANDOAN', 'KB_THUOCUONG', 'KB_NHACNHO', 'KB_ID')
            ->get();
        return $res = [
            'khambenh' => $khambenh,

        ];
    }
    // --------------------------get kham benh---------------------------//
    public function apiluyentap()
    {
        $luyentap = luyentap::all();
        return $res = [
            'luyentap' => $luyentap,

        ];
    }
    // ---------------------------get benh----------------------------//
    public function apibenh()
    {
        $benh = DB::table('benh')->join('chuyenkhoa', 'benh.CK_ID', 'chuyenkhoa.CK_ID')->select('benh.*', 'chuyenkhoa.*')->get();
        return $res = [
            'benh' => $benh,

        ];
    }
    // --------------------------get so tiem--------------------------//
    public function apisotiem($id)
    {
        $sotiem = sotiem::where('ND_ID', $id)
            ->select('ST_TENTHUOC', 'ST_TENMUI', 'ST_NGAYTIEM', 'ST_GHICHU', 'ST_ID')
            ->get();
        return $res = [
            'sotiem' => $sotiem,

        ];
    }
    // --------------------------get chi so--------------------------//
    public function apichiso($id)
    {
        $chiso = chiso::where('ND_ID', $id)
            ->select('CS_BMI', 'CS_DUONGHUYET', 'CS_HUYETAP', 'CS_CHOLESTEROL', 'CS_NHIPTIM', 'CS_CANNANG', 'CS_CHIEUCAO', 'CS_ID', 'created_at')
            ->get();
        return $res = [
            'chiso' => $chiso,

        ];
    }
    // ---------------------dang ky---------------------------------//
    public function register(Request $request)
    {
        $request->validate([
            'ND_HOVATEN' => 'required',
            'ND_EMAIL' => 'required',
            'ND_SODIENTHOAI' => 'required',
            'ND_MATKHAU' => 'required',
        ], [
            'required' => ':attribute kh??ng ???????c ????? tr???ng',
        ], [
            'ND_HOTEN' => 'H??? v?? t??n',
            'ND_EMAIL' => 'mail',
            'ND_SODIENTHOAI' => 's??? ??i???n tho???i',
            'ND_MATKHAU' => 'm???t kh???u',

        ]);

        $nguoidung = nguoidung::all();
        foreach ($nguoidung as $nd) {
            if ($nd->ND_SODIENTHOAI == $request->ND_SODIENTHOAI) {
                $check = 1;
            } else {
                $check = -1;
            }
        }
        if ($check < 0) {
            $nd = new nguoidung();
            $nd->ND_HOVATEN = $request->ND_HOVATEN;
            $nd->ND_GIOITINH = $request->ND_GIOITINH;
            $nd->ND_NS = $request->ND_NS;
            $nd->ND_DIACHI = $request->ND_DIACHI;
            $nd->ND_EMAIL = $request->ND_EMAIL;
            $nd->ND_SODIENTHOAI = $request->ND_SODIENTHOAI;
            $nd->ND_MATKHAU = md5($request->ND_MATKHAU);
            $nd->ND_TRANGTHAI = 1;
            //$nd->ND_SODIENTHOAI = 1;
            $nd->ND_ANH = '';
            $nd->save();
            return response()->json([
                'message' => '????ng k?? th??nh c??ng.',
            ]);
        } else {
            return response()->json([
                'message' => 'S??? ??i???n tho???i ???? c?? ng?????i s??? d???ng',
            ]);
        }
    }
    // --------------------doi pass NGUOIDUNG--------------------------///

    public function changepassnd(Request $request)
    {
        $request->validate([
            'ND_MATKHAU' => 'required|string|min:4',
            'MK_NEW' => 'required|string|min:4',
        ], [
            'required' => ':attribute kh??ng ???????c ????? tr???ng',
        ], [
            'ND_MATKHAU' => 'M???t kh???u hi???n t???i',
            'MK_NEW' => 'M???t kh???u m???i',
        ]);

        // ki???m tra email ???? t???n t???i ch??a, n???u t???n t???i = 1
        $check = nguoidung::where('ND_SODIENTHOAI', $request->ND_SODIENTHOAI)->count();
        if ($check > 0) {
            //get user
            $nd = nguoidung::where('ND_SODIENTHOAI', $request->ND_SODIENTHOAI)->first();
            if (md5($request->ND_MATKHAU) == $nd->ND_MATKHAU) {
                $nd->ND_MATKHAU = md5($request->MK_NEW);
                $nd->save();
                return $res = [
                    'success' => true,
                    'message' => 'Thay ?????i m???t kh???u th??nh c??ng',

                ];
            } else {
                return $res = [
                    'success' => false,
                    'message' => 'Sai m???t kh???u c??',
                ];
            }
        } else {
            return $res = [
                'success' => false,
                'message' => ' kh??ng t???n t???i.',
            ];
        }
    }


    // --------------------LOGIN NGUOIDUNG--------------------------///
    public function login(Request $request)
    {

        $request->validate([
            'ND_SODIENTHOAI' => 'required',
            'ND_MATKHAU' => 'required',
        ], [
            'required' => ':attribute kh??ng ???????c ????? tr???ng',
        ], [
            'ND_SODIENTHOAI' => 'S??? ??i???n tho???i',
            'ND_MATKHAU' => 'M???t kh???u',
        ]);


        // ki???m tra sdt ???? t???n t???i ch??a, n???u t???n t???i = 1
        $check = nguoidung::where('ND_SODIENTHOAI', $request->ND_SODIENTHOAI)->count();
        if ($check > 0) {

            $nd = nguoidung::where('ND_SODIENTHOAI', $request->ND_SODIENTHOAI)->first();

            if (md5($request->ND_MATKHAU) == $nd->ND_MATKHAU && $nd->ND_TRANGTHAI == 1) {
                return $res = [
                    'success' => true,
                    'message' => '????ng nh???p th??nh c??ng.',
                    'nguoidung' => $nd,
                ];
            }
            return $res = [
                'success' => false,
                'message' => '????ng nh???p th???t b???i.',

            ];
        } else {
            return response()->json([
                'success' => false,
                'message' => 'S??? ??i???n tho???i ho???c m???t kh???u kh??ng ch??nh x??c.',
            ],);
        }
    }
    // ------------------------------Edit nguoidung----------------------------//
    public function editnd(Request $request)
    {
        // $request->validate([
        //     'ND_HOVATEN' => 'required',
        //     'ND_GIOITINH' => 'required',
        //     'ND_NS' => 'required',
        //     'ND_DIACHI' => 'required',

        // ], [
        //     'required' => ':attribute kh??ng ???????c ????? tr???ng',
        // ], [
        //     'ND_HOVATEN' => 'H??? v?? t??n',
        //     'ND_DIACHI' => '?????a ch???',
        //     'ND_EMAIL' => 'EMAIL',

        // ]);
        $nd = nguoidung::where('ND_ID', $request->ND_ID)->first();
        $nd->ND_HOVATEN = $request->ND_HOVATEN;
        $nd->ND_GIOITINH = $request->ND_GIOITINH;
        $nd->ND_NS = $request->ND_NS;
        $nd->ND_DIACHI = $request->ND_DIACHI;
        $nd->ND_EMAIL = $request->ND_EMAIL;
        //$nv->NV_SDT = $request->NV_SDT;

        $nd->save();

        return response()->json([
            'success' => true,
            'message' => '???? s???a.',
            'nguoidung' => $nd
        ]);
    }

    public function lichtuvan(Request $request)
    {
        /* $request->validate([            
            'NV_ID ' => 'required',
            'ND_ID ' => 'required',
            'L_NGAYDANGKY' => 'required',            
            'L_GIODANGKY' => 'required',             
            'L_GHICHU' => 'required',   

        ], [
            'required' => ' ch???n :attribute ',
        ], [
            'NV_ID' => 'nh??n vi??n',            
            'ND_ID' => 'ng?????i d??ng',           
            'L_NGAYDANGKY' => 'ng??y ', 
            'L_GIODANGKY' => 'gi???',
            'L_GHICHU' => 'ghi ch??',      

        ]); */
        $lh = new lichtuvan();
        $lh->NV_ID = $request->NV_ID;
        $lh->ND_ID = $request->ND_ID;
        $lh->L_NGAYDANGKY = $request->L_NGAYDANGKY;
        $lh->L_GIODANGKY = $request->L_GIODANGKY;
        $lh->L_GHICHU = $request->L_GHICHU;
        $lh->L_TRANGTHAI = 0;
        //nv->NV_SDT = $request->NV_SDT;

        $lh->save();
        $tennv = DB::table('nhanvien')->where('NV_ID', $request->NV_ID)->first();

        $tb = new thongbao();
        $tb->L_ID = $lh->L_ID;
        $tb->TB_TIEUDE = $tennv->ND_HOVATEN . ' ???? x??c nh???n l???ch t?? v???n c???a b???n!';
        $tb->TB_TRANGTHAI = 0;

        $tb->save();

        return response()->json([
            'success' => true,
            'message' => '???? s???a.',
            'results' => $lh
        ]);
    }
    // -------------------------------xac nhan lichtuvan////
    public function xacnhanlich(Request $request)
    {      // ki???m tra email ???? t???n t???i ch??a, n???u t???n t???i = 1
        //id thb ttt thong update id thong bao 
        $update = DB::table('lichtuvan')->where('L_ID', $request->L_ID)->update(['L_TRANGTHAI' => $request->L_TRANGTHAI]);

        $themtb = new thongbao();
        $themtb->L_ID = $request->L_ID;
        if ($request->L_TRANGTHAI == 1) {
            $themtb->TB_TIEUDE = 'L???ch t?? v???n ???? ???????c x??c nh???n!';
        } else {
            $themtb->TB_TIEUDE = 'L???ch t?? v???n ???? h???y!';
        }
        $themtb->TB_TRANGTHAI = 0;
        $themtb->save();

        return response()->json([
            'success' => true,
            'message' => 'ok.',

        ]);

        //     $update2 = DB::table('thongbao')
        //         ->where('L_ID', $request->L_ID)
        //         ->update(['TB_TRANGTHAI' => $request->L_TRANGTHAI]);
    }
    // public function xacnhanlich(Request $request)
    // {      // ki???m tra email ???? t???n t???i ch??a, n???u t???n t???i = 1
    //     //id thb ttt thong update id thong bao 
    //     $update = DB::table('thongbao')->where('TB_ID', $request->TB_ID)->update(['TB_TRANGTHAI' => $request->TB_TRANGTHAI]);
    //     $update2 = DB::table('thongbao')
    //         ->join('lichtuvan', 'lichtuvan.L_ID', 'thongbao.L_ID')
    //         ->where('TB_ID', $request->TB_ID)
    //         ->update(['L_TRANGTHAI' => $request->TB_TRANGTHAI]);
    // }


    // -------------------------------------get tb lich hen nhan vien------------
    public function getlhcuanv($id)
    {
        $listlhnv = DB::table('lichtuvan')->join('nguoidung', 'lichtuvan.ND_ID', 'nguoidung.ND_ID')
            ->select('lichtuvan.*', 'nguoidung.*')->where('lichtuvan.NV_ID', $id)->get();
        return response()->json([
            'success' => true,
            'message' => 'C?? l???ch h???n',
            'listlhnv' => $listlhnv,
        ]);
    }
    // -------------------------------------get tb lich hen nguoidung------------
    public function getlhcuand($id)
    {
        $listlhnd = DB::table('lichtuvan')->join('nhanvien', 'lichtuvan.NV_ID', 'nhanvien.NV_ID')
            ->select('lichtuvan.*', 'nhanvien.*')->where('lichtuvan.ND_ID', $id)->get();

        return response()->json([
            'success' => true,
            'message' => 'C?? l???ch h???n',
            'listlhnd' => $listlhnd,
        ]);
    }
    // -------------------------------------get tb lich hen nguoidung------------
    public function gettbcuand($id)
    {
        $tbnd = DB::table('thongbao')
            ->join('lichtuvan', 'lichtuvan.L_ID', 'thongbao.TB_ID')
            ->where('lichtuvan.ND_ID', $id)
            ->get();

        return response()->json([
            'success' => true,
            //  'message' => '???? x??c nh???n l???ch h???n',
            'tbnd' => $tbnd,
        ]);
    }

    // --------------------------Them chi so---------------------------//
    public function chiso(Request $request)
    {
        // $request->validate([

        //     'CS_BMI' => 'required',
        //     'CS_DUONGHUYET' => 'required',
        //     'CS_HUYETAP' => 'required',
        //     'CS_CHOLESTEROL' => 'required',
        //     'CS_NHIPTIM' => 'required',
        //     'CS_NHIPTIM' => 'required',
        //     'CS_CANNANG' => 'required',

        // ], [
        //     'required' => 'Kh??ng ????u???c ????? tr???ng attribute. ',
        // ], [
        //     //'CS_BMI' => 'required',
        //     'CS_DUONGHUYET' => '???????ng huy???t',
        //     'CS_HUYETAP' => 'huy???t ??p',
        //     'CS_CHOLESTEROL' => 'cholesterol',
        //     'CS_NHIPTIM' => 'nh???p tim',
        //     'CS_CHIEUCAO' => 'chi???u cao',
        //     'CS_CANNANG' => 'c??n n???ng',

        // ]);
        $cs = new chiso();
        $cs->ND_ID = $request->ND_ID;
        $cs->CS_BMI = $request->CS_BMI;
        $cs->CS_DUONGHUYET = $request->CS_DUONGHUYET;
        $cs->CS_HUYETAP = $request->CS_HUYETAP;
        $cs->CS_CHOLESTEROL = $request->CS_CHOLESTEROL;
        $cs->CS_NHIPTIM = $request->CS_NHIPTIM;
        $cs->CS_CHIEUCAO = $request->CS_CHIEUCAO;
        $cs->CS_CANNANG = $request->CS_CANNANG;
        //$cs->NGAYNHAP = $request->CS_CANNANG;

        $cs->save();

        return response()->json([
            'success' => true,
            'message' => '???? th??m.',
            'chiso' => $cs
        ]);
    }

    // --------------------------Them lich su kham benh---------------------------//
    public function khambenh(Request $request)
    {
        $request->validate([
            'KB_CHUANDOAN' => 'required',
            'KB_THUOCUONG' => 'required',
            'KB_NHACNHO' => 'required',
            'KB_NGAYKHAM' => 'required',
        ], [
            'required' => 'Kh??ng ????u???c ????? tr???ng attribute. ',
        ], [
            'KB_CHUANDOAN' => 't??n b???nh',
            'KB_THUOCUONG' => 'thu???c u???ng',
            'KB_NHACNHO' => 'nh???c nh???',
            'KB_NGAYKHAM' => 'ng??y kh??m',

        ]);
        $kb = new khambenh();
        $kb->ND_ID = $request->ND_ID;
        $kb->KB_CHUANDOAN = $request->KB_CHUANDOAN;
        $kb->KB_THUOCUONG = $request->KB_THUOCUONG;
        $kb->KB_NHACNHO = $request->KB_NHACNHO;
        $kb->KB_NGAYKHAM = $request->KB_NGAYKHAM;
        $kb->save();

        return response()->json([
            'success' => true,
            'message' => '???? th??m.',
            'results' => $kb
        ]);
    }

    // --------------------------Them so tiem---------------------------//
    public function themsotiem(Request $request)
    {
        $request->validate([
            'ST_TENTHUOC' => 'required',
            'ST_TENMUI' => 'required',
            'ST_GHICHU' => 'required',
            'ST_NGAYTIEM' => 'required',
        ], [
            'required' => 'Kh??ng ????u???c ????? tr???ng attribute. ',
        ], [
            'ST_TENTHUOC' => 't??n thu???c',
            'ST_TENMUI' => 't??n m??i',
            //'ST_GHICHU' => 'ghi ch??',
            'ST_NGAYTIEM' => 'ng??y ti??m',

        ]);
        $st = new sotiem();
        $st->ND_ID = $request->ND_ID;
        $st->ST_TENTHUOC = $request->ST_TENTHUOC;
        $st->ST_TENMUI = $request->ST_TENMUI;
        $st->ST_GHICHU = $request->ST_GHICHU;
        $st->ST_NGAYTIEM = $request->ST_NGAYTIEM;
        $st->save();

        return response()->json([
            'success' => true,
            'message' => '???? th??m.',
            'results' => $st
        ]);
    }

    // --------------// --------------------LOGIN nhanvien--------------------------///-----------//
    public function loginad(Request $request)
    {

        $request->validate([
            'NV_SDT' => 'required',
            'NV_MATKHAU' => 'required',
        ], [
            'required' => ':attribute kh??ng ???????c ????? tr???ng',
        ], [
            'NV_SDT' => 'S??? ??i???n tho???i',
            'NV_MATKHAU' => 'M???t kh???u',
        ]);


        // ki???m tra sdt ???? t???n t???i ch??a, n???u t???n t???i = 1
        $check = nhanvien::where('NV_SDT', $request->NV_SDT)->count();
        if ($check > 0) {
            //get user
            // $user = nguoidung::where('KH_Email', $KH_Email)->first();
            $nv = nhanvien::where('NV_SDT', $request->NV_SDT)->first();

            if (md5($request->NV_MATKHAU) == $nv->NV_MATKHAU && $nv->NV_TRANGTHAI == 1 && $nv->NV_QUYENSD == 1) {
                return $res = [
                    'success' => true,
                    'message' => '????ng nh???p th??nh c??ng.',
                    'nhanvien' => $nv,
                ];
            }
            return $res = [
                'success' => false,
                'message' => '????ng nh???p th???t b???i.',

            ];
        } else {
            return response()->json([
                'success' => false,
                'message' => 'S??? ??i???n tho???i ho???c m???t kh???u kh??ng ch??nh x??c.',
            ],);
        }
    }
    // ----------------------------CHANGESPAASSSAD-------------------
    public function changepassad(Request $request)
    {
        $request->validate([
            'NV_MATKHAU' => 'required|string|min:4',
            'MK_NEW' => 'required|string|min:4',
        ], [
            'required' => ':attribute kh??ng ???????c ????? tr???ng',
        ], [
            'NV_MATKHAU' => 'M???t kh???u hi???n t???i',
            'MK_NEW' => 'M???t kh???u m???i',
        ]);

        // ki???m tra email ???? t???n t???i ch??a, n???u t???n t???i = 1
        $check = nhanvien::where('NV_SDT', $request->NV_SDT)->count();
        if ($check > 0) {
            //get user
            $nv = nhanvien::where('NV_SDT', $request->NV_SDT)->first();
            if (strcmp(md5($request->NV_MATKHAU), $nv->NV_MATKHAU) == 0) {
                $nv->NV_MATKHAU = md5($request->MK_NEW);
                $nv->save();
                return $res = [
                    'success' => true,
                    'message' => 'Thay ?????i m???t kh???u th??nh c??ng',

                ];
            } else {
                return $res = [
                    'success' => false,
                    'message' => 'M???t kh???u c?? kh??ng ch??nh x??c',
                ];
            }
        } else {
            return $res = [
                'success' => false,
                'message' => ' S??? ??i???n tho???i kh??ng t???n t???i',
            ];
        }
    }


    // ------------------------------Edit ad----------------------------//

    public function editad(Request $request)
    {
        $request->validate([
            'NV_HOTEN' => 'required',
            'NV_GIOITINH' => 'required',
            'NV_NGAYSINH' => 'required',
            'NV_DIACHI' => 'required',

        ], [
            'required' => ':attribute kh??ng ???????c ????? tr???ng',
        ], [
            'NV_HOTEN' => 'H??? v?? t??n',
            'NV_DIACHI' => '?????a ch???',
            'NV_MAIL' => 's??? ??i???n tho???i',

        ]);
        $nv = nhanvien::where('NV_ID', $request->NV_ID)->first();
        $nv->NV_HOTEN = $request->NV_HOTEN;
        $nv->NV_GIOITINH = $request->NV_GIOITINH;
        $nv->NV_NGAYSINH = $request->NV_NGAYSINH;
        $nv->NV_DIACHI = $request->NV_DIACHI;
        $nv->NV_MAIL = $request->NV_MAIL;
        //$nv->NV_SDT = $request->NV_SDT;

        $nv->save();

        return response()->json([
            'success' => true,
            'message' => '???? s???a.',
            'nhanvien' => $nv
        ]);
    }
    // -----------------------------------------//
    // ------------------------------Edit chi so----------------------------//

    public function editchiso(Request $request)
    {

        $chiso = chiso::where('CS_ID', $request->CS_ID)->first();
        $chiso->CS_BMI = $request->CS_BMI;
        $chiso->CS_DUONGHUYET = $request->CS_DUONGHUYET;
        $chiso->CS_HUYETAP = $request->CS_HUYETAP;
        $chiso->CS_CHOLESTEROL  = $request->CS_CHOLESTEROL;
        $chiso->CS_NHIPTIM = $request->CS_NHIPTIM;
        $chiso->CS_CANNANG = $request->CS_CANNANG;
        $chiso->CS_CHIEUCAO = $request->CS_CHIEUCAO;
        $chiso->save();
        return response()->json([
            'success' => true,
            'message' => '???? s???a.',
            'chiso' => $chiso
        ]);
    }
    // -----------------------------------------//
    public function editsotiem(Request $request)
    {
        $sotiem = sotiem::where('ST_ID', $request->ST_ID)->first();
        $sotiem->ST_TENTHUOC = $request->ST_TENTHUOC;
        $sotiem->ST_TENMUI = $request->ST_TENMUI;
        $sotiem->ST_GHICHU = $request->ST_GHICHU;
        $sotiem->ST_NGAYTIEM = $request->ST_NGAYTIEM;
        $sotiem->save();
        return response()->json([
            'success' => true,
            'message' => '???? s???a.',
            'sotiem' => $sotiem
        ]);
    }
    // -----------------------------------------//
    // -----------------------search thuoc------------------//
    public function timThuoc(Request $request)
    {
        $check = DB::table('duoc')
            ->join('loaiduoc', 'loaiduoc.LD_ID', 'duoc.LD_ID')
            ->where('D_THONGTINCHITIET', 'like', '%' . $request->keyword . '%')
            ->orWhere('D_TEN', 'like', '%' . $request->keyword . '%')
            ->count();
        if ($check == 0) {
            return $respone = [
                'success' => false,
                'message' => "Kh??ng c??",
            ];
        }
        $timthuoc = DB::table('duoc')
            ->join('loaiduoc', 'loaiduoc.LD_ID', 'duoc.LD_ID')
            ->where('D_THONGTINCHITIET', 'like', '%' . $request->keyword . '%')
            ->orWhere('D_TEN', 'like', '%' . $request->keyword . '%')
            ->get();
        return $respone = [
            'success' => true,
            'message' => "thanh cong",
            'timthuoc' => $timthuoc,
        ];
    }
    
}
