<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'user']);
            return $next($request);
        });
    }
    public function index(Request $request)
    {
        if ($this->authorize('xem-thanh-vien')) {
            $status = $request->input('status');
            $list_act = [
                'delete' => 'Xóa tạm thời',
            ];
            if ($status == "trash") {
                $data = User::onlyTrashed()->paginate(3);

                $list_act = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => "Xóa vĩnh viễn"
                ];
            } else {
                $keyword = "";
                if ($request->input('keyword')) {

                    $keyword = $request->input('keyword');
                }
                $data = User::where('name', 'LIKE', "%{$keyword}%")->Paginate(5);
            }
            $count_user_active = User::count();
            $count_user_trash = User::onlyTrashed()->count();
//     return  $users;
            $count = [$count_user_active, $count_user_trash];
            return view('backend.user.index', compact('data', 'count', 'list_act'));
        }
    }
    function action(Request $request)
    {
        $list_check = $request->input('list_check');

        if ($list_check) {
            foreach ($list_check as $k => $id) {
                if (Auth::id() == $id) {
                    unset($list_check[$k]);
                }
            }
            if (!empty($list_check)) {
                $act = $request->input('act');
                if ($act == 'delete') {
                    User::destroy($list_check);
                    alert()->success('','Đã xóa thành công');
                    return redirect('admin/user');
                } elseif ($act == 'restore') {
                    User::withTrashed()->whereIn('id', $list_check)->restore();
                    alert()->success('','Bạn đã Khôi phục thành công');
                    return redirect('admin/user');
                } elseif ($act == 'forceDelete') {
                    User::withTrashed()->whereIn('id', $list_check)->forceDelete();
                    alert()->success('','Bạn đã xóa vĩnh viễn  thành công');
                    return redirect('admin/user');
                }
            }
            alert()->error('','Bạn không thể thao tác trên tài khoản của bạn');
            return redirect('admin/user');
        } else {
            alert()->error('','Bạn cần chọn trường  để thực thi');
            return redirect('admin/user');
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  if ($this->authorize('them-thanh-vien')) {
        $roles = Role::all();
        return view('backend.user.create', compact('roles'));
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
        # Xử lý validate Form
        $request->validate([
            'name' => 'required|max:255|',
            'email' => 'required|email|max:255:unique:users',
            'password' => 'required|max:255',
            'phone' => "required|min:1|max:10",
            'image'  => 'max:2048',
        ],
            [
                'min' => " :attribute có độ dài ít nhất :min ký tự",
                'max' => " :attribute có độ dài tối đa :max ký tự",
                'required' => "(*)  :attribute không đường để trống ",
                'unique'  =>  "(*)  :attribute không được trùng",
                'integer' => "(*)    :attribute chưa được chọn",
            ],
            [
                'name' => 'Tên Nhân viên',
                'email' => 'Email',
                'password' => 'Mật Khẩu',
                'phone' => 'Số điện thoại',
                'image'=>"Avatar"
            ]
        );


        //luu vào csdl
        $user = new User();
        $user->name = $request->input('name'); // họ tên
        $user->email = $request->input('email'); // email
        $user->password = bcrypt($request->input('password')); // mật khẩu
        $user->role_id = $request->input('role_id'); // phần quyền

        if ($request->hasFile('image')) {
            // get file
            $file = $request->file('image');
            // get ten
            $filename = time().'_'.$file->getClientOriginalName();
            // duong dan upload
            $path_upload = 'uploads/users/';
            // upload file
            $file->move($path_upload,$filename);

            $user->avatar = $path_upload.$filename;
        }

        $is_active = 0; // mặc đinh = 0 , không hiển thị
        if ($request->has('is_active')) { // kiem tra is_active co ton tai khong?
            $is_active = $request->input('is_active');
        }

        $user->is_active = $is_active;
        $user->save();
        alert()->success('Thêm thành  viên  thành công !','');
        // chuyen dieu huong trang
        return redirect()->route('admin.user.index');
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
        if ($this->authorize('sua-thanh-vien')) {
            $user = User::findorFail($id);
            $roles = Role::get();
            return view('backend.user.edit', compact('user', 'roles'));
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

        # Xử lý validate Form
        $request->validate([
            'name' => 'required|max:255|',
            'password' => 'required|max:255',

        ],
            [
                'min' => " :attribute có độ dài ít nhất :min ký tự",
                'max' => " :attribute có độ dài tối đa :max ký tự",
                'required' => "(*)  :attribute không đường để trống ",
                'unique'  =>  "(*)  :attribute không được trùng",
                'integer' => "(*)    :attribute chưa được chọn",
            ],
            [
                'name' => 'Tên Nhân viên',
                'email' => 'Email',
                'password' => 'Mật Khẩu',
                'image'=>"Avatar"
            ]
        );
        //luu vào csdl
        $user = User::findOrFail($id);
        $user->name = $request->input('name'); // họ tên
        // kiểm tra có nhập mật khẩu mới không
        if ($request->input('password')) {
            $user->password = bcrypt($request->input('password')); // mật khẩu mới
        }

        $user->role_id = $request->input('role_id'); // phần quyền

        if ($request->hasFile('image')) {
            // get file
            $file = $request->file('image');
            // get ten
            $filename = time().'_'.$file->getClientOriginalName();
            // duong dan upload
            $path_upload = 'uploads/users/';
            // upload file
            $file->move($path_upload,$filename);

            $user->avatar = $path_upload.$filename;
        }

        $is_active = 0; // mặc đinh = 0 , không hiển thị
        if ($request->has('is_active')) { // kiem tra is_active co ton tai khong?
            $is_active = $request->input('is_active');
        }

        $user->is_active = $is_active;
        $user->save();
        alert()->success('Cập nhật thành công !','');
        // chuyen dieu huong trang
        return redirect()->route('admin.user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function destroy($id)
//    {
//        User::destroy($id); // DELETE FROM brands WHERE id=15
//        alert()->success('Xóa  thành công !','');
//        // chuyển hướng đến trang
//        return redirect()->route('admin.user.index');
//    }
    function delete($id)
    {
        if ($this->authorize('xoa-thanh-vien')) {
            if (Auth::id() != $id) {
                $user = User::find($id)->delete();
                alert()->success('Xóa thành viên thành công', "");
                return redirect('admin/user');
            } else {
                alert()->error('', 'Bạn không thể tự xóa bản thân mình ra khỏi hệ thống');
                return redirect('admin/user');
            }
        }
    }

    // Select 2 Ajax





}
