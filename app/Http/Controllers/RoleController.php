<?php

namespace App\Http\Controllers;

use App\Models\GroupPermission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    //
    //
    public  function __construct() {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'role']);
            return $next($request);
        });
    }
    public  function  index(Request $request)
    {
        if ($this->authorize('xem-vai-tro')) {
            $keyword = "";
            if (!empty($request->keyword)) {
                $keyword = $request->keyword;
            }
            $roles = Role::where('name', 'like', "%{$keyword}%")->latest()->paginate(5);
            return view('backend.role.index', compact('roles'));
        }
    }



     public  function create()
     {
         if ($this->authorize('them-vai-tro')) {
             $groupPermission = GroupPermission::get();
             return view('backend.role.create', compact('groupPermission'));
         }
     }
     public  function store(Request $request) {
        $request->validate([
            'name' => 'required|unique:roles',
            'description' => 'required',
            'permission_id' => 'required',
        ], [
            'required' => '(*)  :attribute không được để trống',
            'unique' => '(*) :attribute đã bị trùng trong hệ thống'
        ], [
            'name' => 'Tên vai trò',
            'description' => 'Miêu tả',
            'permission_id' => 'Quyền không được để trống'
        ]);

        try {
            DB::beginTransaction();

            $dataRole = [
                'name' => $request->name,
                'description' => $request->description,
            ];

            $role = Role::create($dataRole);
            $role->permissions()->attach($request->permission_id);

            DB::commit();
            alert()->success('Thêm Vai Trò thành công','');
            return redirect()->route('admin.role.index');
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }
    function edit($id)
    {
        if ($this->authorize('sua-vai-tro')) {
            $groupPermissions = GroupPermission::get();
            $role = Role::find($id);
            $permissionsChecked = $role->permissions;
            return view('backend.role.edit', compact('role', 'permissionsChecked', 'groupPermissions'));
        }
    }
    function update($id, Request $request) {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id . ',id',
            'description' => 'required',
            'permission_id' => 'required',
        ], [
            'required' => '(*) :attribute không được để trống',
            'unique' => '(*)   :attribute đã bị trùng trong hệ thống'
        ], [
            'name' => 'Tên vai trò',
            'description' => 'Miêu tả',
            'permission_id' => 'Quyền không được để trống'
        ]);

        try {
            DB::beginTransaction();

            Role::find($id)->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);
            $role = Role::find($id);

            $role->permissions()->sync($request->permission_id);

            DB::commit();
            alert()->success('Cập nhật Vai Trò thành công','');
            return redirect()->route('admin.role.index');
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    function delete($id) {
        if ($this->authorize('xoa-vai-tro')) {
            Role::find($id)->delete();
            alert()->success('Xóa Vai Trò thành công','');
            return redirect()->route('admin.role.index');
        }
    }



}
