<?php

namespace App\Http\Controllers;

use App\Models\GroupPermission;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class GroupPermissionController extends Controller
{
    //
    public  function  index()
    {
        if ($this->authorize('xem-nhom-quyen')) {
            $groupPermissions = GroupPermission::latest()->paginate(5);
            return view('backend.group-permission.index', compact('groupPermissions'));
        }
    }
    function store(Request $request) {
        $request->validate(
            [
                'name' => 'required|min:5|unique:group_permissions',
                'description' => 'required|min:5'
            ],
            [
                'required' => '(*) :attribute không được để trống',
                'min' => '(*) :attribute phải chứa ít nhất :min ký tự',
                'unique' => '(*) :attribute đã tồn tại trong hệ thống'
            ],
            [
                'name' => 'Tên nhóm quyền',
                'description' => 'Mô tả'
            ]
        );

        $dataInsert = [
            'name' => $request->name,
            'description' => $request->description,
        ];
        GroupPermission::create($dataInsert);
        alert()->success('Thêm nhóm quyền thành công','');
        return back();
    }

    function delete($id) {
        GroupPermission::find($id)->delete();
        alert()->success('Xoá nhóm quyền thành công','');
        return back();
    }

}
