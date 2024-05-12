<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\BrandCategory;
use App\Models\Category;
use App\Models\Product;
use App\DataTables\BrandDataTable;
use Str;
use App\Traits\ImageUploadTrait;


class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use ImageUploadTrait;
   
    public function index(BrandDataTable $dataTable)
    {
        return $dataTable->render('admin.brand.index');

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::where('status' , 1)->get();
        return view('admin.brand.create', compact('category'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required','image', 'max:2000'],
            'name' => ['required', 'max:200', 'unique:brands,name']
        ]);
        $brand = new Brand();
        $brand->name = $request->name;
        $imagePath = $this->uploadImage($request, 'image', 'uploads');
        $brand->image = $imagePath;
        $brand->status = $request->status;
        $brand->slug = Str::slug($request->name);
        $brand->save();
        toastr('Dữ liệu đã được lưu!', 'success');
        return redirect()->route('admin.brand.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::findOrFail($id);
        $category = Category::where('status' , 1)->get();
        return view('admin.brand.edit', compact('brand', 'category'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
           
            'name' => ['required', 'max:200', 'unique:brands,name,'.$id]
            
        ]);
        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
        $imagePath = $this->updateImage($request, 'image', 'uploads', $brand->image);
        $brand->image = empty(!$imagePath) ? $imagePath : $brand->image;
        $brand->status = $request->status;
        $brand->slug = Str::slug($request->name);
        $brand->save();
        if($brand->save()){
            $items = $request->category_id;

            $currentCategories = BrandCategory::where('brand_id', $id)->get();

           
            $currentCategories->each(function ($category) use ($items) {
                if (!in_array($category->category_id, $items)) {
                    $category->delete();
                }
            });

            foreach ($items as $item) {
                $existingCategory = $currentCategories->where('category_id', $item)->first();
                if (!$existingCategory) {
                    $categoryItem = new BrandCategory();
                    $categoryItem->brand_id = $id;
                    $categoryItem->category_id = $item;
                    $categoryItem->status = 1;
                    $categoryItem->save();
                }
            }


        }
        toastr('Dữ liệu đã được lưu!', 'success');
        return redirect()->route('admin.brand.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        $products = Product::where('brand_id', $brand->id)->get();
        if($products->count() == 0){
            $this->deleteImage($brand->image);
            $brand->delete();
        return response(['status' => 'success' , 'message' => 'Xóa thành công!']);
        }else{
            return response(['status' => 'error' , 'message' => 'Còn tồn tại sản phẩm thuộc thương hiệu này!']);

        }

        

    }

    public function changeStatus(Request $request){
        $brand = Brand::findOrFail($request->id);
        $brand->status = $request->status ? 1 : 0;
     
        $brand->save();
        $products = Product::where('brand_id', $request->id)->get();
        foreach($products as $item){
            $product =  Product::where('id', $item->id)->first();
            $product->status =$request->status ? 1 : 0;
            $product->save();
        }

        return response(['message' => 'Cập nhật trạng thái thành công!']);
    }
    
}
