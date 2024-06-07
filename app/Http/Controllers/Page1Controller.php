<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Page1Controller extends Controller
{
    public function home1()
    {
        return view('home1');
    }

    public function about1()
    {
        // Xử lý logic và trả về trang giới thiệu
        return view('about1');
    }

    public function authors1()
    {
        // Xử lý logic và trả về trang tác giả
    }

    public function membership1()
    {
        // Xử lý logic và trả về trang thành viên
    }
}
