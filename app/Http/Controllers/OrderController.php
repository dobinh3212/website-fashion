<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Order_product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class OrderController extends Controller
{
    function  __construct()
    {
        $this->middleware(function ($request,$next){
            session(['module_active' =>'order']);
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($this->authorize('xem-don-hang')) {
            $status = $request->input('status');
            $list_act = [
                'pending'=>'Chờ duyệt',
                'complete'=>"Hoàn thành",
                'confirmed'=>"Đã xác nhận",
                'delivery'=>"Đang vận chuyển",
                'canceled'=>"Hủy",
            ];
            if ($status == 'complete') {
                $list_act = [
                    'pending'=>'Chờ duyệt',
                    'confirmed'=>"Đã xác nhận",
                    'delivery'=>"Đang vận chuyển",
                    'canceled'=>"Hủy",
                ];
                $data = Order::where('status', 'complete')->paginate(10);
            }
            elseif($status == 'confirmed') {
                $list_act = [
                    'pending'=>'Chờ duyệt',
                    'complete'=>"Hoàn thành",
                    'delivery'=>"Đang vận chuyển",
                    'canceled'=>"Hủy",
                ];
                $data = Order::where('status', 'confirmed')->paginate(10);
            }
            elseif($status == 'delivery') {
                $list_act = [
                    'pending'=>'Chờ duyệt',
                    'complete'=>"Hoàn thành",
                    'confirmed'=>"Đã xác nhận",
                    'canceled'=>"Hủy",
                ];
                $data = Order::where('status', 'delivery')->paginate(10);
            }
            elseif($status == 'canceled') {
                $list_act = [
                    'forceDelete' => "Xóa vĩnh viễn"
                ];
                $data = Order::where('status', 'canceled')->paginate(10);
            }
            else {
                $keyword ='';
                if ($request->input('keyword')) {
                    $keyword = $request->input('keyword');
                }
                $data = Order::where('fullname', 'LIKE', "%{$keyword}%")->orderBy('id', 'desc')->paginate(10);
            }
            $count_orders_all = Order::all()->count();
            $count_orders_complete = Order::where('status', 'complete')->count();
            $count_orders_confirmed = Order::where('status', 'confirmed')->count();
            $count_orders_pending = Order::where('status', 'pending')->count();
            $count_orders_delivery = Order::where('status', 'delivery')->count();
            $count_orders_canceled = Order::where('status', 'canceled')->count();
            $count = [$count_orders_all,
                $count_orders_complete,
                $count_orders_confirmed,
                $count_orders_pending,
                $count_orders_delivery,
                $count_orders_canceled
            ];
            return view('backend.order.index',compact('data', 'count', 'list_act'));

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // CHi tiết đơn hàng
        $order = Order::find($id);
        $products=Order::find($id) ->products;
        $order_products = DB::table('order_product')->where('order_id', $id)->get('qty');
        $qty = array();
        foreach($order_products as $order_product){
            $qty[] =$order_product->qty;
        }
        return view('backend.order.show',compact('order','products','qty'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        if ($this->authorize('cap-nhat-don-hang')) {
            $order = Order::find($id);
            $products = Order::find($id)->products;
            $order_products = DB::table('order_product')->where('order_id', $id)->get('qty');
            $qty = array();
            foreach ($order_products as $order_product) {
                $qty[] = $order_product->qty;
            }
            return view('backend.order.edit', compact('order', 'products', 'qty'));
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate(
            [
                'address' => 'required|string|max:255',
                'status'=> 'required',
            ],
            [
                'required'=>':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min',
                'max' => ':attribute có độ dài lớn nhất :max',
                'confirmed' => 'Xác nhận mật khẩu không thành công',
                'unique' => ':attribute đã tồn tại trong hệ thống!'
            ],
            [
                'address' => 'Địa chỉ',
                'status'=> 'Trạng thái',
            ]
        );
        Order::where('id', $id)->update([
            'address' => $request->input('address'),
            'status' => $request->input('status'),
        ]);
        alert()->success('','Đã cập nhật thành công!');
        return redirect()->route('admin.order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if ($this->authorize('xoa-don-hang')) {
            Order::destroy($id);
            alert()->success('Xóa  đơn hàng thành công !', '');
            return redirect()->route('admin.order.index');
        }
    }
    public function delete($id)
    {
        if ($this->authorize('xoa-don-hang')) {
              Order::find($id)->delete();
            alert()->success('Xóa  đơn hàng thành công !', '');
            return redirect()->route('admin.order.index');
        }
    }
    public function print_order($id)
    {
//        $data['order'] = Order::find($id);
//        $data['order_product'] = Order_product::where('order_id', $id)->get();

        return view('backend.order.print-order');
    }

}
