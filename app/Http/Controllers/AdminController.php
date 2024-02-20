<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AdminController extends Controller
{
    public function login()
    {
        return view('backend.login');
    }

    public function postLogin(Request $request)
    {

        // Check validate
        $request->validate([
            'email' =>'required|email',
            'password' => 'required|min:6'
        ],
            [
                'min' => "(*) :attribute có độ dài ít nhất :min ký tự",
                'max' => "(*) :attribute có độ dài tối đa :max ký tự",
                'required' =>"(*) :attribute không đường để trống ",
                'email' => "(*) :attribute không đúng định dạng",
            ],
            [
                'email' => 'Email',
                'password' => 'Mật khẩu'
            ]
        );
        $params = $request->all();
        $data = [
            'email' => $params['email'],
            'password' => $params['password']
        ];

        // SELECT * FROM user WHERE email = ? and password = ? => tìm thấy user thỏa điều kiện => login

        // check success
        if (Auth::attempt($data, $request->has('remember'))) {
            return redirect('/admin');
        }

        return redirect()->back()->with('msg','(*)  Email hoặc mật khẩu không chính xác');
    }

    public function logout()
    {
        // xử lý đăng xuất
        Auth::logout();

        // chuyển về trang đăng nhập
        return redirect()->route('admin.login');
    }

    public function index()
    {


        $orders = Order::orderBy('id', 'DESC')->paginate(5);
        $count_orders_process = Order::where('status', 'LIKE', 'delivery')->
        orwhere('status', 'LIKE', 'pending')->orwhere('status', 'LIKE', 'confirmed')->count();

        $count_orders_canceled = Order::where('status', 'LIKE', 'canceled')->count();
        $count_orders_success= Order::where('status', 'LIKE', 'complete')->count();

        $proceeds = Order::where('status', 'LIKE', 'complete')->sum('total');
        // return $proceeds;
        $count = [$count_orders_process, $count_orders_canceled, $count_orders_success];
        return view('backend.admin.index',compact('orders', 'count', 'proceeds'));
    }






}
