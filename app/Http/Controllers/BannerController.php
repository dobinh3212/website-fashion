<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'banner']);
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
        $status = $request->input('status');
        $list_act = [
            'delete' => 'Xóa tạm thời',
            'publish'=>'Hoạt Động',
            'pending'=>'Chờ duyệt',
        ];

        if ($status == "publish") {
            $data  = Banner::where('is_active',1)->Paginate(5);
            $list_act = [
                'pending'=>'Chờ duyệt',
                'delete' => 'Xóa tạm thời',
                'forceDelete' => "Xóa vĩnh viễn"
            ];
        }
        elseif ($status == "pending") {
            $data  = Banner::where('is_active',0)->Paginate(5);
            $list_act = [
                'publish'=>'Hoạt Động',
                'delete' => 'Xóa tạm thời',
                'forceDelete' => "Xóa vĩnh viễn"
            ];
        }
        elseif ($status == "trash") {
            $data = Banner::onlyTrashed()->paginate(5);
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
            $data = Banner::where('title', 'LIKE', "%{$keyword}%")->Paginate(5);
        }
        $count_banner_all =Banner::all()->count();
        $count_banner_publish = Banner::where('is_active',1)->count();
        $count_banner_pending =Banner::where('is_active',0)->count();
        $count_banner_trash = Banner::onlyTrashed()->count();
        $count = [$count_banner_all,
            $count_banner_publish,
            $count_banner_pending,
            $count_banner_trash];
        return view('backend.banner.index', compact('data','count','list_act'));

    }
    public function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if ($list_check) {
            if (!empty($list_check)) {
                $act = $request->input('act');
                if($act == 'publish'){
                    Banner::whereIn('id',$list_check)->update(
                        ['is_active'=>1]
                    );
                    alert()->success('Cập nhật trạng thái thành công','');
                    return redirect()->route('admin.banner.index');
                }
                elseif ($act =='pending')
                {
                    Banner::whereIn('id',$list_check)->update(
                        ['is_active'=>0]
                    );
                    alert()->success('Cập nhật trạng thái thành công','');
                    return redirect()->route('admin.banner.index');
                }
                elseif ($act == 'delete') {
                    Banner::destroy($list_check);
                    alert()->success('Bạn đã xóa thành công','');
                    return redirect()->route('admin.banner.index');
                } elseif ($act == 'restore') {
                    Banner::withTrashed()->whereIn('id',$list_check)->restore();
                    alert()->success('Bạn đã Khôi phục  thành công','');
                    return redirect()->route('admin.banner.index');
                } elseif ($act == 'forceDelete') {
                    Banner::withTrashed()->whereIn('id',$list_check)->forceDelete();
                    alert()->success('Xóa vĩnh viễn  thành công','');
                    return redirect()->route('admin.banner.index');
                }
                elseif ($act == 'Chọn' && $act== Null) {
                    return redirect()->route('admin.banner.index')->with('error', 'Bạn cần chọn trường  để thực thi');
                }
            }
        } else {
            return redirect()->route('admin.banner.index')->with('error', 'Bạn cần chọn trường  để thực thi');
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
        return view('backend.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Xử lý validate
        $request->validate([
            'title' => 'required|max:255',
            'position' => "integer",
            'image'  => 'max:2048',
        ],
            [
                'min' => ":attribute có độ dài ít nhất :min ký tự",
                'max' => ":attribute có độ dài tối đa :max ký tự",
                'required' => "(*) :attribute không đường để trống ",
                'unique'  =>  "(*) :attribute không được trùng",
                'integer' => "(*)  :attribute chưa được chọn",
            ],
            [
                'title' => 'Tiêu đề',
                'position' => 'Vị trí',
                'is_active' => 'Trạng thái',
                'image'=>"Hình ảnh",
                'description'  => 'Mô tả',
            ]
        );


        $banner = new Banner();
        $banner->title = $request->input('title');
        $banner->slug = str_slug($request->input('title')); // slug
        if ($request->hasFile('image')) { // dòng này Kiểm tra xem có image có được chọn
            // get file
            $file = $request->file('image');
            // đặt tên cho file image
            $filename = time().'_'.$file->getClientOriginalName();
            // Định nghĩa đường dẫn sẽ upload lên
            $path_upload = 'uploads/banners/';
            // Thực hiện upload file
            $file->move($path_upload,$filename);
            // lưu lại đường đẫn file ảnh
            $banner->image = $path_upload.$filename;
        }
        // Url
        $banner->url = $request->input('url');
        // Target
        $banner->target = $request->input('target');
        // Loại
        $banner->type = $request->input('type');
        // Trạng thái
        if ($request->has('is_active')){//kiem tra is_active co ton tai khong?
            $banner->is_active = $request->input('is_active');
        }
        // Vị trí
        $banner->position = $request->input('position');
        // Mô tả
        $banner->description = $request->input('description');
        // Lưu
        $banner->save();
        // Chuyển hướng trang về trang danh sách
        alert()->success('Thêm mới thành công !','');
        return redirect()->route('admin.banner.index');
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
        $banner = Banner::findorFail($id); // lấy chi tiết banner
        return view('backend.banner.edit',compact('banner'));
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
        //Xử lý validate
        $request->validate([
            'title' => 'required|max:255',
            'position' => "integer",
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
                'title' => 'Tiêu đề',
                'position' => 'Vị trí',
                'is_active' => 'Trạng thái',
                'image'=>"Hình ảnh",
                'description'  => 'Mô tả',
            ]
        );


        $banner = Banner::findorFail($id);
        $banner->title = $request->input('title');
        $banner->slug = str_slug($request->input('title')); // slug
        if ($request->hasFile('image')) { // dòng này Kiểm tra xem có image có được chọn
            // get file
            $file = $request->file('image');
            // đặt tên cho file image
            $filename = time().'_'.$file->getClientOriginalName();
            // Định nghĩa đường dẫn sẽ upload lên
            $path_upload = 'uploads/banners/';
            // Thực hiện upload file
            $file->move($path_upload,$filename);
            // lưu lại đường đẫn file ảnh
            $banner->image = $path_upload.$filename;
        }
        // Url
        $banner->url = $request->input('url');
        // Target
        $banner->target = $request->input('target');
        // Loại
        $banner->type = $request->input('type');
        // Trạng thái
        if ($request->has('is_active')){//kiem tra is_active co ton tai khong?
            $banner->is_active = $request->input('is_active');
        }
        // Vị trí
        $banner->position = $request->input('position');
        // Mô tả
        $banner->description = $request->input('description');
        // Lưu
        $banner->save();
        // Chuyển hướng trang về trang danh sách
        alert()->success('Cập Nhật thành công !','');
        return redirect()->route('admin.banner.index');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function destroy($id)
//    {
//        //
//        Banner::destroy($id); // DELETE FROM banner WHERE id=15
//        alert()->success('Xóa  thành công !','');
//        // chuyển hướng đến trang
//        return redirect()->route('admin.banner.index');
//    }

    public  function delete($id)
    {
        $banner= Banner::find($id)->delete();
        alert()->success('Xóa sản phẩm thành công','');
        return redirect('admin/banner');
    }
}
