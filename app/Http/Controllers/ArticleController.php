<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Aler;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'article']);
            return $next($request);
        });
    }
    public function index(Request $request)
    {
        //
        if ($this->authorize('xem-bai-viet')) {
            $status = $request->input('status');
            $list_act = [
                'delete' => 'Xóa tạm thời',
                'publish' => 'Hoạt Động',
                'pending' => 'Chờ duyệt',
            ];

            if ($status == "publish") {
                $data = Article::where('is_active', '1')->Paginate(5);
                $list_act = [
                    'pending' => 'Chờ duyệt',
                    'delete' => 'Xóa tạm thời',
                    'forceDelete' => "Xóa vĩnh viễn"
                ];
            } elseif ($status == "pending") {
                $data = Article::where('is_active', '0')->Paginate(5);
                $list_act = [
                    'publish' => 'Hoạt Động',
                    'delete' => 'Xóa tạm thời',
                    'forceDelete' => "Xóa vĩnh viễn"
                ];
            } elseif ($status == "trash") {
                $data = Article::onlyTrashed()->paginate(5);
                $list_act = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => "Xóa vĩnh viễn"
                ];
            } else {
                $keyword = "";
                if ($request->input('keyword')) {

                    $keyword = $request->input('keyword');
                }
                $data = Article::where('title', 'LIKE', "%{$keyword}%")->Paginate(5);
            }
            $count_article_all = Article::all()->count();
            $count_article_publish = Article::where('is_active', 1)->count();
            $count_article_pending = Article::where('is_active', 0)->count();
            $count_article_trash = Article::onlyTrashed()->count();
            $count = [$count_article_all,
                $count_article_publish,
                $count_article_pending,
                $count_article_trash];
            return view('backend.article.index', compact('data', 'count', 'list_act'));
        }
    }
    public function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if ($list_check) {
            if (!empty($list_check)) {
                $act = $request->input('act');
                if($act == 'publish'){
                    Article::whereIn('id',$list_check)->update(
                        ['is_active'=>'1']
                    );
                    alert()->success('Cập nhật trạng thái thành công','');
                    return redirect('admin/article');
                }
                elseif ($act == 'pending')
                {
                    Article::whereIn('id',$list_check)->update(
                        ['is_active'=>'0']
                    );
                    alert()->success('Cập nhật trạng thái thành công','');
                    return redirect('admin/article');
                }
                elseif ($act == 'delete') {
                    Article::destroy($list_check);
                    alert()->success('Bạn đã xóa thành công','');
                    return redirect('admin/article');
                } elseif ($act == 'restore') {
                    Article::withTrashed()->whereIn('id',$list_check)->restore();
                    alert()->success('Bạn đã Khôi phục  thành công','');
                    return redirect('admin/article');
                } elseif ($act == 'forceDelete') {
                    Article::withTrashed()->whereIn('id',$list_check)->forceDelete();
                    alert()->success('Bạn đã xóa vĩnh viễn  thành công','');
                    return redirect('admin/article');
                }
                elseif ($act == 'Chọn' && $act== Null) {
                    return redirect()->route('admin.article.index')->with('error', 'Bạn cần chọn trường  để thực thi');
                }
            }
        }
        else {
            return redirect('admin/article')->with('error', 'Bạn cần chọn trường  để thực thi');
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
        if ($this->authorize('them-bai-viet')) {
            return view('backend.article.create');
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
        // xử lý phần form
        $request->validate([
            'title' => 'required',
            'position' => 'integer|unique:articles',
            'summary' => 'required',
            'description' => 'required',
            'image'=>"max:2048"
        ],
            [
                'min' => ":attribute có độ dài ít nhất :min ký tự",
                'max' => ":attribute có độ dài tối đa :max ký tự",
                'required' => "(*) :attribute không đường để trống ",
                'unique'  =>  "(*) :attribute không được trùng",
                'integer' => "(*) :attribute chưa được chọn",
            ],
            [
                'title' => 'Tên bài viết',
                'position' => 'Vị trí',
                'description' => 'Chi tiết bài viết',
                'summary' => 'Mô tả bài viết',
                'is_active' => 'Trạng thái'
            ]
        );

        // lấy toàn bộ tham số gửi từ form
        $params = $request->all(); // $_POST , $_GET
        // INSERT thêm vào CSDL
        $model = new Article(); // model brand sử dụng cơ chế ORM => tự động mapping vs table brand
        $model->title = $params['title'];
        $model->slug=str_slug($params['title']);
        $model->position = $params['position'];
        $model->summary = $params['summary'];
        $model->description = $params['description'];
        $model->is_active = isset($params['is_active']) ? $params['is_active'] : 0;
        // xử lý lưu ảnh
        if ($request->hasFile('image')) { // kiểm tra xem có file gửi lên không
            // get file được gửi lên
            $file = $request->file('image');
            // đặt lại tên cho file
            $filename = $file->getClientOriginalName();  // $file->getClientOriginalName() = lấy tên gốc của file
            // duong dan upload
            $path_upload = 'uploads/articles/';
            // upload file
            $file->move($path_upload,$filename);
            $model->image = $path_upload.$filename;
        }
        $model->save(); // insert mysql : INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')
        alert()->success('Thêm bài viết thành công !','');
        // chuyển hướng đến trang
        return redirect()->route('admin.article.index');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //\
        if ($this->authorize('sua-bai-viet')) {
            $data = Article::find($id); // SELECT * FROM brands WHERE id  = 5

            return view('backend.article.edit', compact('data'));
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
            'title' => 'required',
            'position' => 'integer',
            'summary' => 'required',
            'description' => 'required',
            'image'=>"max:2048"
        ],
            [
                'min' => ":attribute có độ dài ít nhất :min ký tự",
                'max' => ":attribute có độ dài tối đa :max ký tự",
                'required' => "(*) :attribute không đường để trống ",
                'unique'  =>  "(*) :attribute không được trùng",
                'integer' => "(*) :attribute chưa được chọn",
            ],
            [
                'title' => 'Tên bài viết',
                'position' => 'Vị trí',
                'description' => 'Chi tiết bài viết',
                'summary' => 'Mô tả bài viết',
                'is_active' => 'Trạng thái'
            ]
        );

        // lấy toàn bộ tham số gửi từ form
        $params = $request->all(); // $_POST , $_GET
        // INSERT thêm vào CSDL
        $model = Article::find($id); // model brand sử dụng cơ chế ORM => tự động mapping vs table brand
        $model->title = $params['title'];
        $model->slug=str_slug($params['title']);
        $model->position = $params['position'];
        $model->summary = $params['summary'];
        $model->description = $params['description'];
        $model->is_active = isset($params['is_active']) ? $params['is_active'] : 0;
        // xử lý lưu ảnh
        if ($request->hasFile('image')) { // kiểm tra xem có file gửi lên không
            // get file được gửi lên
            $file = $request->file('image');
            // đặt lại tên cho file
            $filename = $file->getClientOriginalName();  // $file->getClientOriginalName() = lấy tên gốc của file
            // duong dan upload
            $path_upload = 'uploads/articles/';
            // upload file
            $file->move($path_upload,$filename);
            $model->image = $path_upload.$filename;
        }
        $model->save(); // insert mysql : INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')
        alert()->success('Cập nhật bài viết thành công !','');
        // chuyển hướng đến trang
        return redirect()->route('admin.article.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // Xóa tạm thời
    public  function delete($id)
    {
        if ($this->authorize('xoa-bai-viet')) {
            //    DB::table('articles')->where('id', $id)->delete();
            $article = Article::find($id)->delete();
            alert()->success('Xóa bài viết thành công','');
            return redirect('admin/article');
        }
    }


}
