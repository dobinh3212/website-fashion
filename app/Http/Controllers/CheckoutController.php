<?php

namespace App\Http\Controllers;

use App\Mail\Checkout;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\District;
use App\Models\Order;
use App\Models\Province;
use App\Models\Ward;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    //
    public  function __construct()
    {
        $this->categories = Category::where('is_active',1)->orderBy('id','asc')->orderBy('position','asc')->get();
        $brands =Brand::where('is_active',1)->get();
        view()->share([
            'categories'=>$this->categories,
            'brands'=>$brands
        ]);
    }

    public function checkout(){
        $data = Province::all();
        return view('frontend.checkout',compact('data'));
    }
    // Thanh toán giỏ hàng
    public function login_checkout(){
        return view('frontend.login_checkout');
    }

    public  function  add_customer(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ],
            [
                'required'=>"(*) :attribute không đường để trống ",
                'min'=>"(*) :attribute có độ dài ít nhất :min ký tự",
                'email'=>"(*) :attribute chưa đúng định dạng",
                'unique'=>"(*) Email đã tồn tại ",
                'max'=>"(*) :attribute có độ dài tối đa :max ký tự",
                'confirmed' =>"(*) Xác nhận mật khẩu không thành công"],
            [
                'name'=> "Họ và tên",
                'email'=>"Email",
                'password'=>'Mật khẩu',
                'password-confirm'=>"Xác nhận mật khẩu"
            ]
        );
        $params = $request->all(); // $_POST , $_GET
        $model =new  Customer();
        $model->name = $params['name'];
        $model->phone =$params['phone'];
        $model->email = $params['email'];
        $model->password= md5($params['password']);
        $model->save(); // Insert
        $request->session()->put('name',$model->name);
        $request->session()->put('id',$model->id);
        alert()->success('Thêm tài khoản  thành công !','');
        return redirect('thanh-toan');
    }
// Đăng nhập khi có tài khoản
    public function login_customer(Request $request)
    {
        $email=$request->input('email');
        $password =$request->input('password');
        $result = Customer::where([['password',md5($password)],[ 'email',$email]])->first();

        if ($result){

            $request->session()->put('name',$result->name);
            $request->session()->put('id',$result->id);
            alert()->success('Đăng Nhập  thành công !','');
            return redirect('thanh-toan');
        }
        else
        {
            return redirect('/login-checkout');
        }
    }
    public function logout_checkout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('checkoutLogin');
    }
#Xử lý select
    function  selectAjaxDistrict($id)
    {
        return json_encode(DB::table('districts')->where('province_id', $id)->get());
    }
    function  selectAjaxWard($id)
    {
        return json_encode(DB::table('wards')->where('district_id', $id)->get());
    }

    public function  order(Request $request)
    {
        if($request->input('btn-order')){
            if (Cart::count() > 0) {
                $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|email',
                    'phone' => 'required',
                    'provinces' => 'required',
                    'districts' => 'required',
                    'wards' => 'required',
                    'payment-method' => 'required',
                ],
                    [
                        'required' => '(*) :attribute không được để trống',
                        'min' => '(*) :attribute có độ dài ít nhất :min',
                        'max' => '(*) :attribute có độ dài lớn nhất :max',
                        'email' => '(*) :attribute phải có định dạng email',
                        'confirmed' => '(*) Xác nhận mật khẩu không thành công',
                        'unique' => '(*) :attribute đã tồn tại trong hệ thống!',
                        'integer' => '(*) :attribute chưa đúng định dạng số!',
                    ],
                    [
                        'name' => 'Họ tên',
                        'email' => 'Email',
                        'phone' => 'Số điện thoại',
                        'provinces' => 'Tỉnh/Thành phố',
                        'districts' => 'Quận/Huyện',
                        'wards' => 'Xã/Phường/Thị trấn',
                        'payment-method' => 'Phương thức thanh toán',
                    ]
                );
                $provinces=  Province::where('id',$request->input('provinces'))->select('name')->get();
                $province='';
                foreach ($provinces as $province )
                {
                    $province=$province->name;
                }
                $districts=  District::where('id',$request->input('districts'))->select('name')->get();
                $district='';
                foreach ($districts as $district )
                {
                    $district=$district->name;
                }
                $wards=  Ward::where('id',$request->input('wards'))->select('name')->get();
                $ward='';
                foreach ($wards as $ward )
                {
                    $ward=$ward->name;
                }
// Thêm vào bảng Order
                Order::create([
                    'code'=> 'FH'.time(),
                    'fullname' => $request->input('name'),
                    'phone' =>$request->input('phone'),
                    'email'=> $request->input('email'),
                    'address' =>$request->input('address').','.
                        $ward.','.$district.','.$province,
                    'note' => $request->input('notes'),
                    'product_qty' => Cart::count(),
                    'total' => Cart::total(0,0,''),
                    'payment' => $request->input('payment-method'),
                    'status'=> 'pending',
                    'customer_id'=>session('id'),
                ]);

                // Thêm vào bảng Order_product
                $order_id = Order::max('id');
                foreach(Cart::content() as $product){
                    DB::table('order_product')->insert([
                        'name'=>$product->name,
                        'order_id' => $order_id,
                        'product_id' => $product->id,
                        'qty'=>$product->qty,
                        'price'=>$product->price,
                    ]);
                    // Cập nhật lại số lượng còn Product
                }
                $order = Order::find($order_id);
                    $data = [
                        'code' => $order->code,
                        'name' => $request->input('name'),
                        'address' => $request->input('address'),
                        'phone' => $request->input('phone'),
                        'email' => $request->input('email')
                    ];

                Mail::to($request->input('email'))->send(new Checkout($data));
                return redirect()->route('checkout.complete');
                Cart::destroy();
            }
            else {
                alert()->error('', 'Chưa có sản phẩm nào trong giỏ hàng! Vui lòng chọn sản phẩm !');
                return back();
            }
        }
    }

    // Xử lý thanh toán thành công
    function orderComplete() {
        return view('frontend.checkout-complete');
    }

    // Theo dõi đơn hàng
    public  function checkorder(Request $request)
    {
        $code = $request->input('code');
        $qty = array();
        $products = [];
        $order = [];
        if(!empty($code)){
            $order = Order::where('code', $code)->first();
            $products = Order::find($order['id'])->products;
            $order_products = DB::table('order_product')->where('order_id', $order['id'])->get('qty');
            foreach ($order_products as $order_product) {
                $qty[] = $order_product->qty;
            }
        }
        return view('frontend.checkorder', compact('code', 'order','products', 'qty'));
    }



}
