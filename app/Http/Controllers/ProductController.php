<?php

namespace App\Http\Controllers;

use App\Models\ProductAttribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product']);
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
        if ($this->authorize('xem-san-pham')) {
            $status = $request->input('status');
            $list_act = [
                'delete' => 'Xóa tạm thời',
                'publish' => 'Hoạt Động',
                'pending' => 'Chờ duyệt',
            ];

            if ($status == "publish") {
                $data = Product::where('is_active', 1)->Paginate(5);
                $list_act = [
                    'pending' => 'Chờ duyệt',
                    'delete' => 'Xóa tạm thời',
                    'forceDelete' => "Xóa vĩnh viễn"
                ];
            } elseif ($status == "pending") {
                $data = Product::where('is_active', 0)->Paginate(5);
                $list_act = [
                    'publish' => 'Hoạt Động',
                    'delete' => 'Xóa tạm thời',
                    'forceDelete' => "Xóa vĩnh viễn"
                ];
            } elseif ($status == "trash") {
                $data = Product::onlyTrashed()->paginate(5);
                $list_act = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => "Xóa vĩnh viễn"
                ];
            } else {
                $keyword = "";
                if ($request->input('keyword')) {

                    $keyword = $request->input('keyword');
                }
                $data = Product::where('name', 'LIKE', "%{$keyword}%")->Paginate(5);
            }
            $count_product_all = Product::all()->count();
            $count_product_publish = Product::where('is_active', 1)->count();
            $count_product_pending = Product::where('is_active', 0)->count();
            $count_product_trash = Product::onlyTrashed()->count();
            $count = [$count_product_all,
                $count_product_publish,
                $count_product_pending,
                $count_product_trash];
            return view('backend.product.index', compact('data', 'count', 'list_act'));
        }
    }
    public function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if ($list_check){
            if (!empty($list_check)) {
                $act = $request->input('act');
                if($act == 'publish'){
                    Product::whereIn('id',$list_check)->update(
                        ['is_active'=>1]
                    );
                    alert()->success('Cập nhật trạng thái thành công','');
                    return redirect()->route('admin.product.index');
                }
                elseif ($act =='pending')
                {
                    Product::whereIn('id',$list_check)->update(
                        ['is_active'=>0]
                    );
                    alert()->success('Cập nhật trạng thái thành công','');
                    return redirect()->route('admin.product.index');
                }
                elseif ($act =='delete') {
                    Product::destroy($list_check);
                    alert()->success('Bạn đã xóa thành công','');
                    return redirect()->route('admin.product.index');
                } elseif ($act == 'restore') {
                    Product::withTrashed()->whereIn('id',$list_check)->restore();
                    alert()->success('Khôi phục  thành công','');
                    return redirect()->route('admin.product.index');
                } elseif ($act == 'forceDelete') {
                    Product::withTrashed()->whereIn('id',$list_check)->forceDelete();
                    alert()->success('Xóa vĩnh viễn  thành công','');
                    return redirect()->route('admin.product.index');
                }
                elseif ($act == 'Chọn' && $act== Null) {
                    return redirect()->route('admin.product.index')->with('error', 'Bạn cần chọn trường  để thực thi');
                }
            }
        }
        else {
            return redirect()->route('admin.product.index')->with('error', 'Bạn cần chọn trường  để thực thi');
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($this->authorize('them-san-pham')) {
            $categories = Category::all(); // lấy toàn bộ danh mục => build option Danh Mục Cha
            $categories = data_tree($categories);
            $brands = Brand::all(); // lấy toàn bộ danh mục => build option Danh Mục Cha
            return view('backend.product.create', compact('categories', 'brands'));
        }
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
        $request->validate([
            'name' => 'required',
            'stock' => 'integer',
            'price' => 'required',
            'summary' => 'required',
            'sku' => 'required',
            'description' => 'required',
            'sale' => 'required|integer',
            'image'  => 'max:2048'
        ],
            [
                'min' => ":attribute có độ dài ít nhất :min ký tự",
                'max' => ":attribute có độ dài tối đa :max ký tự",
                'required' => "(*) :attribute không đường để trống ",
                'unique'  =>  "(*) :attribute không được trùng",
                'integer' => "(*) :attribute chưa được chọn",
            ],
            [
                'name' => 'Tên  sản phẩm',
                'sku' => 'Mã sản phẩm',
                'color' => 'Màu',
                'stock' => 'Số Lượng',
                'price' => 'Giá gốc',
                'sale' => 'Giá khuyến mại',
                'summary' => 'Mô tả sản phẩm',
                'description' => 'Chi tiết sản phẩm',
                'parent_id' => 'Danh mục ',
                'brand_id' => 'Nhà cung cấp',
                'is_active' => 'Trạng thái'
            ]
        );

        // lấy toàn bộ tham số gửi từ form
        $params = $request->all(); // $_POST , $_GET
        // INSERT thêm vào CSDL
        $model = new Product(); // model brand sử dụng cơ chế ORM => tự động mapping vs table brand
        $model->name = $params['name'];
        $model->sku = $params['sku'];
        $model->slug = str_slug($request->input('name'));
        $model->color = $params['color'];
        $model->summary = $params['summary'];
        $model->price = $params['price'];
        $model->sale = $params['sale'];
        $model->description = $params['description'];
        $model->stock = $params['stock'];
        $model->user_id  = Auth::user()->id;
        $model->brand_id = $params['brand_id'];
        $model->category_id = $params['category_id'];
        $model->is_active = isset($params['is_active']) ? $params['is_active'] : 0;
        $model->is_hot = isset($params['is_hot']) ? $params['is_hot'] : 0;
        // xử lý lưu ảnh
        if ($request->hasFile('image')) { // kiểm tra xem có file gửi lên không
            // get file được gửi lên
            $file = $request->file('image');
            // đặt lại tên cho file
            $filename = $file->getClientOriginalName();  // $file->getClientOriginalName() = lấy tên gốc của file
            // duong dan upload
            $path_upload = 'uploads/products/';
            // upload file
            $file->move($path_upload,$filename);

            $model->image = $path_upload.$filename;
        }

        $model->save(); // insert mysql : INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')
        alert()->success('Thêm sản phẩm thành công','');
        // chuyển hướng đến trang
        return redirect()->route('admin.product.index');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        if ($this->authorize('sua-san-pham')) {
            $categories = Category::all(); // lấy toàn bộ danh mục => build option Danh Mục Cha
            $categories = data_tree($categories);
            $brands = Brand::all(); // lấy toàn bộ danh mục => build option Danh Mục Cha
            $data = Product::find($id); // SELECT * FROM brands WHERE id  = 5

            return view('backend.product.edit', compact('data', 'categories', 'brands'));
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

        $request->validate([
            'name' => 'required|max:255',
            'stock' => 'integer',
            'sku'=> 'required|max:255',

            'price' => 'required|integer',
            'sale' => 'required|integer',
            'summary' => 'required',
            'description' => 'required',
        ],
            [
                'min' => ":attribute có độ dài ít nhất :min ký tự",
                'max' => ":attribute có độ dài tối đa :max ký tự",
                'required' => "(*) :attribute không đường để trống ",
                'unique'  =>  "(*) :attribute không được trùng",
                'integer' => "(*) :attribute chưa được chọn",
            ],
            [
                'name' => 'Tên sản phẩm ',
                'sku' => 'Mã sản phẩm',
                'color' => 'Màu sản phẩm',
                'stock' => 'Số Lượng',
                'price' => 'Giá',
                'summary' => 'Mô tả sản phẩm',
                'description' => 'Chi tiết sản phẩm',
                'parent_id' => 'Danh mục ',
                'brand_id' => 'Nhà cung cấp',
                'is_active' => 'Trạng thái'
            ]
        );

        // lấy toàn bộ tham số gửi từ form
        $params = $request->all(); // $_POST , $_GET
        $model =Product::find($id);
        $model->name = $params['name'];
        $model->sku = $params['sku'];
        $model->color = $params['color'];
        $model->slug = str_slug($request->input('name'));
        $model->summary = $params['summary'];
        $model->price = $params['price'];
        $model->sale = $params['sale'];
        $model->description = $params['description'];
        $model->stock = $params['stock'];
        $model->user_id  = Auth::user()->id;
        $model->brand_id = $params['brand_id'];
        $model->category_id = $params['category_id'];
        $model->is_active = isset($params['is_active']) ? $params['is_active'] : 0;
        $model->is_hot = isset($params['is_hot']) ? $params['is_hot'] : 0;
        // xử lý lưu ảnh
        if ($request->hasFile('image')) { // kiểm tra xem có file gửi lên không
            // get file được gửi lên
            $file = $request->file('image');
            // đặt lại tên cho file
            $filename = $file->getClientOriginalName();  // $file->getClientOriginalName() = lấy tên gốc của file
            // duong dan upload
            $path_upload = 'uploads/products/';
            // upload file
            $file->move($path_upload,$filename);

            $model->image = $path_upload.$filename;
        }

        $model->save(); // insert mysql : INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')
        alert()->success('Cập  nhật sản phẩm thành công','');
        // chuyển hướng đến trang
        return redirect()->route('admin.product.index');
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
        if ($this->authorize('xoa-san-pham')) {
//        Product::destroy($id);
            $product = Product::find($id)->delete();
            alert()->success('Xóa  sản phẩm thành công !', '');
            return redirect()->route('admin.product.index');
        }
    }

    public function delete($id)
    {
        if ($this->authorize('xoa-san-pham')) {
            $product = Product::find($id)->delete();
            alert()->success('Xóa  sản phẩm thành công !', '');
            return redirect()->route('admin.product.index');
        }
    }

    // Attribute
    public function createAttributes(Request $request,$id)
    {
        if ($this->authorize('sua-san-pham')) {
            $productDetail = Product::with('attributes')->find($id);
           $productDetail =json_decode(json_encode($productDetail),true);
            if ($request->isMethod('post'))
            {
                 $data=$request->all();

               foreach ($data['sku'] as $key =>$value)
               {
                   if(!empty($value))
                   {

                     // Xét Sku không được trùng
                       $attrCountSKU=ProductAttribute::where(['sku'=>$value])->count();
                       if($attrCountSKU >0)
                       {

                           return redirect()->back()->with('error','Mã đã tồn tại , vui lòng chọn mã khác');
                       }
                       $attrCountSize=ProductAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                       if($attrCountSize >0)
                       {
                           return redirect()->back()->with('error','Size đã tồn tại , vui lòng chọn mã khác');
                       }
                     // Xét số lượng
                       $attrCountStock=ProductAttribute::where(['product_id'=>$id,'stock'=>$data['stock'][$key]])->count();
                       if($attrCountStock > $productDetail['stock'])
                       {
                           return redirect()->back()->with('error','Số lượng không thể lớn hơn tổng số lượng sản phẩm ');
                       }

                       $attribute= new ProductAttribute();
                       $attribute->product_id=$id;
                       $attribute->sku=$value;
                       $attribute->size=$data['size'][$key];
                       $attribute->price=$data['price'][$key];
                       $attribute->stock=$data['stock'][$key];
                       $attribute->status=1;
                       $attribute->save();


                   }
               }
                alert()->success('Thêm thuộc tính thành công','');
                return redirect()->back();
            }
           return view('backend.product-attribute.create',compact('productDetail'));
        }
    }
    public  function editAttributes(Request $request,$id)
    {
         if($request ->isMethod('post'))
         {
             $data =$request->all();
             foreach ($data['attrId'] as $key =>$attr)
             {
                 if(!empty($attr))
                 {
                  ProductAttribute::where(['id'=>$data['attrId'][$key]])
                      ->update(['price'=>$data['price'][$key],'stock'=>$data['stock'][$key]]);
                 }
             }
             alert()->success('Cập nhật thuộc tính thành công','');
             return redirect()->back();

         }
    }
     public function  updateAttributeStatus(Request $request)
     {
         if($request ->ajax()){
              $data =$request->all();
              if ($data['status'] =="Hiển Thị")
              {
                  $status=0;
              }
              else{
                  $status =1;
              }
              ProductAttribute::where('id',$data['attribute_id'])->
                  update([
                    'status'=>$status
              ]);
              return response()->json(['status'=>$status,'attribute_id'=>$data['attribute_id']]);
         }
     }



     public function deleteAttribute($id)
     {
         ProductAttribute::where('id',$id)->delete();
         alert()->success('Xóa thuộc tính thành công','');
        return redirect()->back();
     }


}
