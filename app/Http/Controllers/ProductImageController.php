<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    //
    public function  index($id,Request $request)
    {
        $status = $request->status;
        $list_act = array(
            'delete' => 'Xóa tạm thời',
        );
        if ($status == "trash") {
            $list_act = [
                'active' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
            $productImages = ProductImage::onlyTrashed()->where('product_id', $id)->paginate(5);
        } else if ($status == "public") {
            $list_act = [
                'pending' => 'Chờ duyệt',
                'delete' => 'Xóa tạm thời',

            ];
            $productImages = ProductImage::where([
                ['is_active','=', 1],
                ['product_id', '=', $id]
            ])->paginate(5);
        } else if ($status == 'pending') {
            $list_act = [
                'public' => 'Công khai',
                'delete' => 'Xóa tạm thời',
            ];
            $productImages = ProductImage::where([
                ['is_active', '=', 0],
                ['product_id', '=', $id]
            ])->paginate(5);
        } else {
            $productImages = ProductImage::where('product_id', $id)->paginate(5);
        }

        $count['all'] = ProductImage::where('product_id', $id)->count();
        $count['public'] = ProductImage::where([
            ['is_active', '=', 1],
            ['product_id', '=', $id]
        ])->count();
        $count['pending'] = ProductImage::where([
            ['is_active', '=', 0],
            ['product_id', '=', $id]
        ])->count();
        $count['trash'] = ProductImage::onlyTrashed()->where('product_id', $id)->count();
        $product_id = $id;
        return view('backend.product-image.index', compact('productImages', 'count', 'list_act', 'product_id'));
    }
  public function create($id, Request $request)
  {
      $request->validate([
          'image' => 'required|image',
      ], [
          'required' => 'Ảnh về sản phẩm không được bỏ trống',
          'image' => 'Bạn vui lòng chọn ảnh!!!'
      ],
          [
              'image'  => 'Hình ảnh',
          ]
      );
      $params = $request->all(); // $_POST , $_GET

      // INSERT thêm vào CSDL
      $model = new ProductImage();
      $model->product_id = $id;
      $model->position = $params['position'];
      $model->is_active = isset($params['is_active']) ? $params['is_active'] : 0;
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

          $model->image= $path_upload.$filename;
      }
      $model->save(); // insert mysql : INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')
      alert()->success('Thêm ảnh  thành công !','');
      // chuyển hướng đến trang
      return back();

  }
    function action(Request $request) {
        $list_check = $request->list_check;
        $action = $request->act;
        if (!empty($list_check)) {
            if (!empty($action)) {
                if ($action == 'delete') {
                    ProductImage::destroy($list_check);
                    return back()->with('status', 'Bạn đã xóa tạm bản ghi thành công');
                } else if ($action == 'active') {
                    ProductImage::onlyTrashed()->whereIn('id', $list_check)->restore();
                    alert()->success('Khôi phục bản ghi thành công','');
                    return back();
                } else if ($action == 'forceDelete') {
                    ProductImage::onlyTrashed()->whereIn('id', $list_check)->forceDelete();
                    alert()->success('Xoá vĩnh viễn bản ghi thành công','');
                    return back();
                } else if ($action == 'public') {
                    ProductImage::whereIn('id', $list_check)->update([
                        'is_active' => 1
                    ]);
                    alert()->success('Cập nhật bản ghi thành công khai','');
                    return back();
                } else {
                    ProductImage::whereIn('id', $list_check)->update([
                        'is_active' => 0
                    ]);
                    alert()->success('Cập nhật bản ghi thành công khai','');
                    return back();
                }
            } else {
                return back()->with('error', 'Bạn vui lòng chọn thao tác thực hiện bản ghi');
            }
        } else {
            return back()->with('error', 'Bạn vui lòng chọn bản ghi để thực hiện');
        }
    }
    function delete($id) {
        ProductImage::find($id)->delete();
        alert()->success('Xóa ảnh  thành công !','');
        return back();
    }


}
