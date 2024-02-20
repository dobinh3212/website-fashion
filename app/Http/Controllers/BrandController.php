<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Aler;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'brand']);
            return $next($request);
        });
    }
    public function index(Request $request)
    {
        //
        $status = $request->input('status');
        $list_act = [
            'delete' => 'Xóa tạm thời',
            'publish'=>'Hoạt Động',
            'pending'=>'Chờ duyệt',
        ];

        if ($status == "publish") {
            $data  = Brand::where('is_active',1)->Paginate(5);
            $list_act = [
                'pending'=>'Chờ duyệt',
                'delete' => 'Xóa tạm thời',
                'forceDelete' => "Xóa vĩnh viễn"
            ];
        }
        elseif ($status == "pending") {
            $data  = Brand::where('is_active',0)->Paginate(5);
            $list_act = [
                'publish'=>'Hoạt Động',
                'delete' => 'Xóa tạm thời',
                'forceDelete' => "Xóa vĩnh viễn"
            ];
        }
        elseif ($status == "trash") {
            $data = Brand::onlyTrashed()->paginate(5);
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => "Xóa vĩnh viễn"
            ];
        }
        else {
            $keyword = "";
            if ($request->input('keyword')) {

                $keyword = $request->input('keyword');
            }
            $data = Brand::where('name', 'LIKE', "%{$keyword}%")->Paginate(5);
        }
        $count_brand_all =Brand::all()->count();
        $count_brand_publish = Brand::where('is_active',1)->count();
        $count_brand_pending =Brand::where('is_active',0)->count();
        $count_brand_trash = Brand::onlyTrashed()->count();
        $count = [$count_brand_all,
            $count_brand_publish,
            $count_brand_pending,
            $count_brand_trash];
        return view('backend.brand.index', compact('data','count','list_act'));


    }
    public function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if ($list_check) {
            if (!empty($list_check)) {
                $act = $request->input('act');
                if($act == 'publish'){
                    Brand::whereIn('id',$list_check)->update(
                        ['is_active'=>1]
                    );
                    alert()->success('Cập nhật trạng thái thành công','');
                    return redirect()->route('admin.brand.index');
                }
                elseif ($act =='pending')
                {
                    Brand::whereIn('id',$list_check)->update(
                        ['is_active'=>0]
                    );
                    alert()->success('Cập nhật trạng thái thành công','');
                    return redirect()->route('admin.brand.index');
                }
                elseif ($act == 'delete') {
                    Brand::destroy($list_check);
                    alert()->success('Bạn đã xóa thành công','');
                    return redirect()->route('admin.brand.index');
                } elseif ($act == 'restore') {
                    Brand::withTrashed()->whereIn('id',$list_check)->restore();
                    alert()->success('Bạn đã Khôi phục  thành công','');
                    return redirect()->route('admin.brand.index');
                } elseif ($act == 'forceDelete') {
                    Brand::withTrashed()->whereIn('id',$list_check)->forceDelete();
                    alert()->success('Bạn đã xóa vĩnh viễn  thành công','');
                    return redirect()->route('admin.brand.index');
                }
                elseif ($act == 'Chọn' && $act== Null) {
                    return redirect()->route('admin.brand.index')->with('error', 'Bạn cần chọn trường  để thực thi');
                }
            }
        } else {
            return redirect()->route('admin.brand.index')->with('error', 'Bạn cần chọn trường  để thực thi');
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
        return  view('backend.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        # Xử lý validate Form
        $request->validate([
            'name' => 'required|max:255:unique:brands',
            'position' => "integer|unique:brands",
            'image'  => 'required|max:2048',
        ],
            [
                'min' => ":attribute có độ dài ít nhất :min ký tự",
                'max' => ":attribute có độ dài tối đa :max ký tự",
                'required' => "(*) :attribute không đường để trống ",
                'unique'  =>  "(*) :attribute không được trùng",
                'integer' => "(*) :attribute chưa được chọn",
            ],
            [
                'name' => 'Tên Nhà Cung Cấp',
                'position' => 'Vị trí',
                'is_active' => 'Trạng thái',
                'image' => 'Hình Ẩnh'
            ]
        );
        // Lấy  toàn bộ từ form
        $params=$request->all();
        // INSERT thêm vào CSDL
        $model =new Brand(); // model brand sử dụng cơ chế ORM=> tự động mappinmg với table brand
        $model->name=$params['name'];
        $model->slug=str_slug($params['name']);
        $model->position=$params['position'];
        $model->is_active=isset($params['is_active']) ? $params['is_active'] :0 ;
        if($request->hasFile('image'))// Kiểm tra xem file có gửi lên
        {
            // get file được gửi lên
            $file =$request->file('image');
            // đặt lại tên cho file
            $filename=$file->getClientOriginalName();
            // Đường dẫn file
            $path_upload='uploads/brands/';
            // Upload file
            $file->move($path_upload,$filename);
            $model->image = $path_upload.$filename;
        }

        $model->save();
// Xử lý thêm ảnh


        # Thêm mới kiểu static
//        Brand::create([
//            'name'=>$params['name'],
//            'slug'=>str_slug($params['name']),
//            'website'=>$params['website'],
//            'position'=>$params['position'],
//            'is_active'=>isset($params['is_active']) ? $params['is_active'] :0,
//
//            'image'=>$path_upload.$filename,
//        ]);
        alert()->success('Thêm mới thành công !','');
        return redirect('admin/brand');
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
        $data = Brand::find($id); // SELECT * FROM brands WHERE id  = 5

        return view('backend.brand.edit',compact('data'));
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
        # Xử lý validate Form
        $request->validate([
            'name' => 'required|max:255',
            'position' => "integer|",
            'image'  => 'max:2048',
        ],
            [
                'min' => ":attribute có độ dài ít nhất :min ký tự",
                'max' => ":attribute có độ dài tối đa :max ký tự",
                'required' => "(*) :attribute không đường để trống ",
                'unique'  =>  "(*) :attribute không được trùng",
                'integer' => "(*) :attribute chưa được chọn",
            ],
            [
                'name' => 'Tên Nhà Cung Cấp',
                'position' => 'Vị trí',
                'is_active' => 'Trạng thái',
                'image'=>"Hình ảnh"
            ]
        );
        $params = $request->all(); // $_POST , $_GET
        $model = Brand::find($id);
        $model->name = $params['name'];
        $model->slug = str_slug($params['name']); // đồng hồ =>  dong-ho
        $model->position = $params['position'];
        $model->is_active = isset($params['is_active']) ? $params['is_active'] : 0;
        if($request->hasFile('image'))// Kiểm tra xem file có gửi lên
        {
            // get file được gửi lên
            $file =$request->file('image');
            // đặt lại tên cho file
            $filename=$file->getClientOriginalName();
            // Đường dẫn file
            $path_upload='uploads/brands/';
            // Upload file
            $file->move($path_upload,$filename);
            // Lưu lại đường dẫn ảnh upload lên
            $model->image = $path_upload.$filename;
        }
        $model->save(); // insert mysql : UPDATE
        // chuyển hướng đến trang
        alert()->success('Sửa nhà cung cấp thành công !','');
        return redirect()->route('admin.brand.index');
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
        Brand::destroy($id);
        alert()->success('Xóa  thương hiệu thành công !','');
        return redirect()->route('admin.brand.index');
    }
    public function delete($id)
    {
        $brand = Brand::find($id)->delete();
        alert()->success('Xóa  thương hiệu thành công !','');
        return redirect()->route('admin.brand.index');
    }

}
