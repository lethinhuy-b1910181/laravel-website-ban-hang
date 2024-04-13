<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ReceiptProduct;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use App\Models\ColorDetail;
use App\Traits\ImageUploadTrait;
use App\DataTables\ProductDataTable;
use Str;

class ProductController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'image' => ['required', 'image', 'max:3000'],
            'name' => ['required', 'max:200'],
            'category_id' =>['required'],
            'brand_id' =>['required'],
            'short_description' =>['required', 'max:600'],
            'long_description' =>['required'],

        ]);

        $imagePath = $this->uploadImage($request, 'image', 'uploads');

        $product = new Product();
        $product->name = $request->name;
        $product->image = $imagePath;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->short_description  = $request->short_description ;
        $product->long_description  = $request->long_description ;
        $product->video_link = $request->video_link;
        $product->status = $request->status;
        $product->offer_price = $request->offer_price;
        $product->product_type = $request->product_type;
        $product->slug = Str::slug($request->name);
        
      

        $product->save();
        if($product->save()){
            $files = $request->multi_img;
             
            if(!empty($files)){
                foreach($files as $file){
                    $imgName = 'media_'.uniqid().'_'.$file->getClientOriginalName();
                    
                    $file->move('uploads/',$imgName);
                    $subImage['multi_img'] = $imgName;
                    $subImage = new ProductImage();
                    $subImage->product_id = $product->id;
                    $subImage->multi_img = $imgName;
                    $subImage->save();
                }
            }
        }

        if($product->save()){
            $items = $request->color_id;
             
            if(!empty($items)){
                foreach($items as $item){
                    
                    $color = new ColorDetail();
                    $color->product_id = $product->id;
                    $color->color_id = $item;
                    $color->save();
                }
            }
        }

        toastr('Lưu dữ liệu thành công!', 'success');
        return redirect()->route('admin.product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        $category = Category::where('id', $product->category_id)->first();
        $brand = Brand::where('id', $product->brand_id)->first();
        $sale = ColorDetail::where('product_id', $id)->sum('sale');
        $sl = ColorDetail::where('product_id', $id)->sum('quantity') - $sale;

        $receiptProduct = ReceiptProduct::where('product_id', $id)->get();
        $productColor = ColorDetail::where('product_id', $id)->get();

        return view('admin.product.show', compact('product', 'category', 'brand','sl', 'receiptProduct', 'productColor', 'sale' ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $multiImgs = ProductImage::where('product_id', $id)->get();
        return view('admin.product.edit', compact('product', 'multiImgs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            
            'name' => ['required', 'max:200'],
            'category_id' =>['required'],
            'brand_id' =>['required'],
            'short_description' =>['required', 'max:600'],
            'long_description' =>['required'],

        ]);

        $imagePath = $this->uploadImage($request, 'image', 'uploads');

        $product =  Product::findOrFail($id);
        $product->name = $request->name;
        
        if(!empty($request->image)){
            $product->image = $imagePath;
        }else{
            $product->image = $product->image;
        }
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->short_description  = $request->short_description ;
        $product->long_description  = $request->long_description ;
        $product->video_link = $request->video_link;
        $product->status = $request->status;
        $product->offer_price = $request->offer_price;
        $product->product_type = $request->product_type;
        $product->slug = Str::slug($request->name);

        $product->save();

        if($product->save()){
            $files = $request->multi_img;
             
            if(!empty($files)){
                foreach($files as $file){
                    $imgName = 'media_'.uniqid().'_'.$file->getClientOriginalName();
                    
                    $file->move('uploads/',$imgName);
                    $subImage['multi_img'] = $imgName;
                    $subImage = new ProductImage();
                    $subImage->product_id = $product->id;
                    $subImage->multi_img = $imgName;
                    $subImage->save();
                }
            }
        }
        if($product->save()){
            $items = $request->color_id;

            // Lấy danh sách màu sắc hiện tại của sản phẩm
            $currentColors = ColorDetail::where('product_id', $id)->get();

            // Xóa các màu sắc không còn được chọn
            $currentColors->each(function ($color) use ($items) {
                if (!in_array($color->color_id, $items)) {
                    $color->delete();
                }
            });

            // Thêm các màu sắc mới
            foreach ($items as $item) {
                // Kiểm tra xem màu sắc đã tồn tại cho sản phẩm hay chưa
                $existingColor = $currentColors->where('color_id', $item)->first();
                if (!$existingColor) {
                    // Nếu màu sắc chưa tồn tại, thêm mới
                    $colorItem = new ColorDetail();
                    $colorItem->product_id = $id;
                    $colorItem->color_id = $item;
                    $colorItem->save();
                }
            }


        }

        

        toastr('Cập nhật dữ liệu thành công!', 'success');
        return redirect()->route('admin.product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $product = Product::findOrFail($id);
        $this->deleteImage($product->image);
        
        
        $subImage =ProductImage::where('product_id', $product->id)->get()->toArray();
        if(!empty($subImage)){
            foreach($subImage as $value){
                if(!empty($value)){
                    @unlink('uploads/'.$value['multi_img']);
                }
            }
        }
        ProductImage::where('product_id', $product->id)->delete();
        $product->delete();
        return response(['status' => 'success' , 'message' => 'Xóa thành công!']);
    }

    public function MultiImageDelete($id){
        
        $deleteData = ProductImage::where('id', $id)->first();
        if($deleteData){

            $imagePath = $deleteData->multi_img;

            // Check if the file exists before unlinking
            if(file_exists($imagePath)){
                unlink($imagePath);
                echo "Image Unlink Successfully";
            } else {
                echo "Image dose not exist";
            }

            //Delete the record form database
            ProductImage::where('id', $id)->delete();

        }

        $notification = array(
            'message' => 'Multi Image Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }//End Method
}
