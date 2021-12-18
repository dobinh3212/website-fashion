<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Aler;
class CategoryController extends Controller
{
    /**
     * Hiện thị danh sách
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'category']);
            return $next($request);
        });
    }


    public function index(Request $request)
    {
        if ($this->authorize('xem-danh-muc-san-pham')) {
            $status = $request->input('status');
            $list_act = [
                'delete' => 'Xóa tạm thời',
                'publish' => 'Hoạt Động',
                'pending' => 'Chờ duyệt',
            ];

            if ($status == "publish") {
                $data = Category::where('is_active', 1)->Paginate(5);
                $list_act = [
                    'pending' => 'Chờ duyệt',
                    'delete' => 'Xóa tạm thời',
                    'forceDelete' => "Xóa vĩnh viễn"
                ];
            } elseif ($status == "pending") {
                $data = Category::where('is_active', 0)->Paginate(5);
                $list_act = [
                    'publish' => 'Hoạt Động',
                    'delete' => 'Xóa tạm thời',
                    'forceDelete' => "Xóa vĩnh viễn"
                ];
            } elseif ($status == "trash") {
                $data = Category::onlyTrashed()->paginate(3);
                $list_act = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => "Xóa vĩnh viễn"
                ];
            } else {
                $keyword = "";
                if ($request->input('keyword')) {

                    $keyword = $request->input('keyword');
                }
                $data = Category::where('name', 'LIKE', "%{$keyword}%")->get();
                $data = data_tree($data);
//            $posts = DB::table('posts')->join('category_posts', 'posts.post_cat_id', '=', 'category_posts.post_cat_id')->where('post_title', 'LIKE', "%{$keyword}%")->Paginate(3);

            }
            $count_category_all = Category::all()->count();
            $count_category_publish = Category::where('is_active', 1)->count();
            $count_category_pending = Category::where('is_active', 0)->count();
            $count_category_trash = Category::onlyTrashed()->count();
            $count = [$count_category_all,
                $count_category_publish,
                $count_category_pending,
                $count_category_trash];
            return view('backend.category.index', compact('data', 'count', 'list_act'));
        }
    }
    public function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if ($list_check) {
            if (!empty($list_check)) {
                $act = $request->input('act');
                if($act == 'publish'){
                    Category::whereIn('id',$list_check)->update(
                        ['is_active'=>1]
                    );
                    alert()->success('','Cập nhật trạng thái thành công');
                    return redirect()->route('admin.category.index');
                }
                elseif ($act == 'pending')
                {
                    Category::whereIn('id',$list_check)->update(
                        ['is_active'=>0]
                    );
                    alert()->success('','Cập nhật trạng thái thành công');
                    return redirect()->route('admin.category.index');
                }
                elseif ($act == 'delete') {
                    Category::destroy($list_check);
                    alert()->success('','Bạn đã xóa thành công');
                    return redirect()->route('admin.category.index');
                } elseif ($act == 'restore') {
                    Category::withTrashed()->whereIn('id',$list_check)->restore();
                    alert()->success('Khôi phục  thành công','');
                    return redirect()->route('admin.category.index');
                } elseif ($act == 'forceDelete') {
                    Category::withTrashed()->whereIn('id',$list_check)->forceDelete();
                    alert()->success('Xóa vĩnh viễn  thành công','');
                    return redirect()->route('admin.category.index');
                }
                elseif ($act == 'Chọn' && $act== Null) {
                    return redirect()->route('admin.category.index')->with('error', 'Bạn cần chọn trường  để thực thi');
                }
            }
        } else {
            return redirect()->route('admin.category.index')->with('error', 'Bạn cần chọn trường  để thực thi');
        }
    }
    /**
     * Hiện thị form thêm dữ liệu
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Category::all(); // lấy toàn bộ danh mục => build option Danh Mục Cha
        $data=data_tree($data);
        return view('backend.category.create',compact('data'));
    }

    /**
     * Sau khi nhấn submit form tạo, xử lý lưu dữ liệu ở đây
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        # Xử lý validate Form
        $request->validate([
            'name' => 'required|max:255|unique:categories',
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
                'name' => 'Tên  danh mục',
                'parent_id' => 'Danh mục cha ',
                'position' => 'Vị trí',
                'is_active' => 'Trạng thái',
                'image'  => 'Hình ảnh',
            ]
        );

        // lấy toàn bộ tham số gửi từ form
        $params = $request->all(); // $_POST , $_GET

        // INSERT thêm vào CSDL
        $model = new Category(); // model brand sử dụng cơ chế ORM => tự động mapping vs table brand
        $model->name = $params['name'];
        $model->slug = str_slug($params['name']); // đồng hồ =>  dong-ho
        $model->parent_id = $params['parent_id'];
        $model->position = $params['position'];
        $model->is_active = isset($params['is_active']) ? $params['is_active'] : 0;

        // xử lý lưu ảnh
        if ($request->hasFile('image')) { // kiểm tra xem có file gửi lên không
            // get file được gửi lên
            $file = $request->file('image');
            // đặt lại tên cho file
            $filename = $file->getClientOriginalName();  // $file->getClientOriginalName() = lấy tên gốc của file
            // duong dan upload
            $path_upload = 'uploads/categories/';
            // upload file
            $file->move($path_upload,$filename);

            $model->image= $path_upload.$filename;
        }

        $model->save(); // insert mysql : INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')
        alert()->success('Thêm danh mục thành công !','');
        // chuyển hướng đến trang
        return redirect()->route('admin.category.index');
    }

    /**
     * hiển thị chi tiết 1 thông tin dữ liệu cho 1 bản ghi
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Hiển thị chi tết dữ liệu, nhưng dữ liệu được đặt trong 1 form
     * Để người dùng có thể chỉnh lại thông tin
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($this->authorize('sua-danh-muc-san-pham')) {
        // lấy chi tiết
        $data = Category::find($id); // SELECT * FROM category WHERE id  = 5
        $categories = Category::all(); // lấy toàn bộ danh mục => build option Danh Mục Cha
        $categories = data_tree($categories);
        return view('backend.category.edit', compact('data', 'categories'));
    }
    }

    /**
     * Sau khi nhấn submit form edit  , thì nhận dữ liệu và xử lý lưu lại từ form edit
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        # Xử lý validate Form
        $request->validate([
            'name' => 'required|max:255',
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
                'name' => 'Tên Danh Mục',
                'position' => 'Vị trí',
                'is_active' => 'Trạng thái',
                'image'=>"Hình ảnh"
            ]
        );
        $params = $request->all(); // $_POST , $_GET
        $model = Category::find($id);
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
            $path_upload='uploads/categories/';
            // Upload file
            $file->move($path_upload,$filename);
            // Lưu lại đường dẫn ảnh upload lên
            $model->image = $path_upload.$filename;
        }
        $model->save(); // insert mysql : UPDATE
        // chuyển hướng đến trang
        alert()->success('Sửa nhà cung cấp thành công !','');
        return redirect()->route('admin.category.index');
    }

    /**
     * xóa 1 bản ghi dữ liệu
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Category::destroy($id);
        // chuyển hướng đến trang
        alert()->success('Xóa danh mục  thành công !','');
        return redirect('admin/category');
    }
    public function delete($id)
    {
        if ($this->authorize('xoa-danh-muc-san-pham')) {
            $category = Category::find($id)->delete();
            alert()->success('Xóa  sản phẩm thành công !', '');
            return redirect()->route('admin.category.index');
        }
    }
}
