<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;

class ShopController extends Controller
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

    public function index()
    {
        $productSupper =Product::where(['is_active'=>1],['is_hot='=>1])->orderBy('id','desc')->orderBy('stock','desc')->limit(1)->get();
        $productHosts =Product::where(['is_active'=>1],['is_hot='=>1])->limit(3)->get();
        $banners = Banner::where('is_active',1)->orderBy('id','desc')->orderBy('position','asc')->take(3)->get();
         // 2 . Lấy tên danh mục cha và sản phẩm theo danh mục (Gồm cả sản phẩm thuộc danh mục cha con)
     $data =[];
     foreach ($this->categories as $category)
     {
         if($category->parent_id == 0)
         {
             $categoryIds=[];  // Biến chứa id của cha con
             $categoryIds[] =$category->id;
             foreach ($this->categories as $categoryChild1)
             {
                 if($categoryChild1->parent_id ==$category->id) {
                     $categoryIds[] = $categoryChild1->id;
                     foreach ($this->categories as $categoryChild2) {
                         if ($categoryChild2->parent_id == $categoryChild1->id) {
                             $categoryIds[] = $categoryChild2->id;
                         }
                     }
                 }

                 }

             $products =Product::where(['is_active'=>1])->whereIn('category_id',$categoryIds)->limit(10)->orderBy('id','asc')->get();

             // Lấy ra danh mục cha
             $data[] =[
                 'name'=>$category->name,
                  'slug'=>$category->slug,
                 'products'=>$products
             ];
         }
     }
        return view('frontend.index',compact('banners','data','productHosts','productSupper'));
    }
    // danh mục sản phẩm
    public function category(Request $request,$slug)
    {
        $cate =  Category::where(['slug' => $slug])->first();
        //2 . chứa tên danh mục cha và sản phẩm theo danh mục (gồm cả SP thuộc cha và con)
        $data = [];
        foreach ($this->categories as $category) {
            if ($category->id == $cate->id ) { // lấy danh mục cha
                $categoryIds = []; // biến chưa id của danh mục , cha / con
                $categoryIds[] = $category->id;
                foreach ($this->categories as $categoryChild1) {
                    if ($categoryChild1->parent_id == $category->id) {
                        $categoryIds[] = $categoryChild1->id;

                        foreach ($this->categories as $categoryChild2) {
                            if ($categoryChild2->parent_id == $categoryChild1->id) {
                                $categoryIds[] = $categoryChild2->id;
                            }
                        }
                    }
                }
                $query=[];
                $price = $request->get('r-price');
                if ($price ==0) {
                    $query[] = ['sale','>',0];
                }elseif($price == 1){
                    $query[] = ['sale','<', 100000];
                }elseif($price == 2){
                    $query[] = ['sale','>=',100000];
                    $query[] = ['sale','<',300000];
                }elseif($price == 3){
                    $query[] = ['sale','>=',300000];
                    $query[] = ['sale','<',500000];
                }elseif($price == 4){
                    $query[] = ['sale','>=',500000];
                    $query[] = ['sale','<',800000];
                }elseif($price == 5){
                    $query[] = ['sale','>=',800000];
                }

                $brand = $request->get('r-brand');
                if($brand !='all' && $brand !=null ){
                    $query[] = ['brand_id',$brand];
                }


                //Order by arrange
                    if ($request->orderBy == 1) {
                        $products = Product::whereIn('category_id', $categoryIds)->where([[$query],['is_active', 1]])->orderBy('name', 'ASC')->paginate(6);

                    } elseif ($request->orderBy == 2) {
                        $products = Product::whereIn('category_id', $categoryIds)->where([[$query], ['is_active', 1]])->orderBy('name', 'DESC')->paginate(6);

                    } elseif ($request->orderBy == 3) {
                        $products = Product::whereIn('category_id', $categoryIds)->where([[$query], ['is_active', 1]])->orderBy('sale', 'DESC')->paginate(6);

                    } elseif ($request->orderBy == 4) {
                        $products = Product::whereIn('category_id', $categoryIds)->where([[$query], ['is_active', 1]])->orderBy('sale', 'ASC')->paginate(6);

                    }

                else {
                    $products = Product::where($query)
                        ->whereIn('category_id', $categoryIds)
                        ->limit(10)
                        ->orderBy('id', 'desc')
                        ->orderBy('position', 'asc')
                        ->paginate(6);
                }
                    $data = [
                        'name' => $category->name,
                        'products' => $products,// toàn bộ sản phẩm gồm cả cha / con
                    ];

            }
        }
        return view('frontend.category',compact('data'));
    }

  public  function  productAll(Request $request)
  {

      $products = Product::Where('is_active',1)->Paginate(9);
      return view('frontend.productAll',compact('products'));
  }


    // chi tiết sản phẩm
    public function product($slug)
    {
        $product = Product::where(['slug' => $slug])->with('attributes')->first();

        $productImgs =$product->images;

        // bước 1  : lưu lại thông tin sản phảm đã xem vào cookie
        // lưu id sẩn phẩm đã xem lần đầu vào cookie
        if (isset($_COOKIE['list_product_viewed'])) {
            // xử lý lưu thêm vào danh sách tiếp theo
            $list_products_viewed = $_COOKIE['list_product_viewed']; // list id sản phẩm , nhưng đag là 1 chuỗi
            $list_products_viewed = json_decode($list_products_viewed); // chuyển chuỗi list id=> mảng
            $list_products_viewed[] = $product->id;

            // danh sách bị thay đổi => nạp lại giá trị cho key
            $string_list_id = json_encode($list_products_viewed);
            setcookie('list_product_viewed', $string_list_id , time() + (7*86400));

        } else {
            $arr_viewed_product = [$product->id];
            $arr_viewed_product = json_encode($arr_viewed_product); // { "ten" : "gia tri"  }
            setcookie('list_product_viewed', $arr_viewed_product , time() + (30*86400));
        }
        $viewedProducts = [];
        // bước 2:  lấy ra chi tiết thông tin những sản phẩm đã xem ,từ cookie
        if (!empty($_COOKIE['list_product_viewed'])) {
            $products_viewed =  $_COOKIE['list_product_viewed'];
            $array_products_viewed = json_decode($products_viewed); // [48,48,56,46,89,10,12]

            $array_products_viewed = array_unique($array_products_viewed); // [48,56,46,89,10,12]

            $array_products_viewed = array_slice($array_products_viewed, -5, 5);


            // lấy ra danh sách sách sản phẩm đã xem từ mảng : $list_products_viewed
            $viewedProducts = Product::where([
                ['is_active' , '=', 1],
                ['id' ,'<>' , $product->id]
            ])->whereIn('id' ,$array_products_viewed)
                ->limit(4)->get();

        }
        return view('frontend.product',compact('product','viewedProducts','productImgs'));
    }
  public  function  getProductPrice(Request $request)
  {
           if($request->ajax())
           {
               $data =$request->all();
               if($data['size'] != null) {
                   $getProductSize =ProductAttribute::where(['product_id'=>$data['product_id'] ,'size'=>$data['size']  ] )->first();
               }
                else if($data['size'] == null){
                    $getProductSize = Product::where(['id' => $data['product_id'] ])->first();
                }
               return  number_format($getProductSize->price,0,",",".") ;
           }
  }



    // Trang liên hệ
//    public function contact()
//    {
//        return view('frontend.contact');
//    }
    public function postcontact(Request $request)
    {
          $request->validate([
             'name'=>"required|max:255",
              'email'=>"required|email",
              'phone'=>"required",
              'content'=>"required",
          ],
              [
                  'min' => ":attribute có độ dài ít nhất :min ký tự",
                  'max' => ":attribute có độ dài tối đa :max ký tự",
                  'required' => "(*) :attribute không đường để trống ",
                  'email'  =>  "(*) :attribute phải là email",

              ],
              [
                  'name' => 'Họ tên',
                  'email' => 'Email',
                  'phone' => 'Số điện thoại',
                  'content'=>"Ghi chú",
              ]);
        $contact = new Contact();
        $contact->name = $request->input('name');
        $contact->phone = $request->input('phone');
        $contact->email = $request->input('email');
        $contact->content = $request->input('content');
        alert()->success("Cảm ơn bạn đã quan tâm Shop!Shop sẽ liên hệ sớm nhất  đến bạn !",'');
        $contact->save();
        // chuyển về trang chủ
        return back();
    }



    // Danh sách trang tin tức
    public function articles()
    {
        $data =Article::where(['is_active'=>1])->Paginate(3);
        return view('frontend.article',compact('data'));
    }
    // Chi tiết trang tin tức
    public function detailArticle($slug)
    {
        $article = Article::Where(['slug'=> $slug]) -> first();

        return view('frontend.detail-article',compact('article'));
    }
//    public function page($slug)
//    {
//        $page=Article::Where(['slug'=> $slug]) -> first();
//        return view('frontend.page',compact('page'));
//    }

    public function aboutUs()
    {
        $article = Article::Where('slug','gioi-thieu') -> first();

        return view('frontend.about-us',compact('article'));
    }


// Tìm kiếm sản phẩm
    public function search(Request $request)
    {
        $key = $request->input('tu-khoa');
        if ($key != null) {
            $productSearchs = Product::where(
                [['name', 'like', "%{$key}%"], ['is_active', '=', 1]])->Paginate(20);
            return view('frontend.search', compact('productSearchs'));
        }
        else{
                alert()->error('', "Bạn phải nhập tham số tìm kiếm");
                return back();
            }
        }

}
