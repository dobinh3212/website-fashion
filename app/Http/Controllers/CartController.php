<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected  $categories;  // thuộc tính : Lưu trữ toàn bộ danh mục


    public  function __construct()
    {
        $this->categories = Category::where('is_active',1)->orderBy('id','asc')->orderBy('position','asc')->get();
        $brands =Brand::where('is_active',1)->get();
        view()->share([
            'categories'=>$this->categories,
            'brands'=>$brands
        ]);
    }


    // trang đặt hàng
    public function order()
    {
        return view('frontend.order');
    }
    // Thêm sản phẩm vào giỏ hàng
    public  function  add(Request $request,$id)
    {
        if ($request->input('productSize'))
        {
            $product=Product::with('attributes')->find($id);
            $productImgs =$product->images;
            foreach ($productImgs as $img)
            {
                $image= $img->image;
            }
            foreach ($product['attributes'] as $item)
            {
                $productStock=$item->stock;
                $productSize =$item->size;
            }
            if($request->input('num-order')){
                $qty = $request->input('num-order');
            } else{
                $qty = 1;
            }
            if($productStock >= $qty && (int)$qty>0 )
            {
                Cart::add([
                        'id' => $product->id,
                        'name' => $product->name,
                        'qty' => $qty,
                        'price' =>str_replace('.', '',$request->input('getPrice')),
                        'weight'=>'1',
                        'options'=>[
                            'color' => $product->color,
                            'size'  =>$productSize,
                            'slug' => $product->slug,
                            'image'=>$image,

                        ]
                    ]
                );

                 return redirect('/dat-hang');
            }
        }
      else{

          return back()->with('error','Vui lòng chọn Size');
      }
    }
     public  function  update(Request $request,$rowId)
    {
        $num_order =  $request->input("num_order");
        $row_total = $num_order * $request->input("subtotal");
        Cart::update($rowId, $num_order);
        $result = [
            'rowId' => $rowId,
            'cart_total' => Cart::total(),
            'row_total' =>number_format( $row_total,0,'','.')
        ];
        echo json_encode($result);

    }


  // Xóa Giỏ hàng
    function remove($rowId){
        Cart::remove($rowId);
        return redirect('/dat-hang');
    }
    public function destroy(){
        Cart::destroy();
        alert()->success("Xóa giỏ hàng thành công ");
        return redirect('/dat-hang');

    }





}
