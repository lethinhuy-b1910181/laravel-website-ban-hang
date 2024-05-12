<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\DataTables\CategoryDataTable;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.category.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:200', 'unique:categories,name'],
            'image'=>['required'],
            'status'=>['required']
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->image = $request->image;
        $category->status = $request->status;
        $category->slug = Str::slug($request->name);
        $category->save();

        toastr('Lưu dữ liệu thành công!', 'success');
        return redirect()->route('admin.category.index');
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
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'max:200', 'unique:categories,name,'.$id],
            'image'=>['required'],
            'status'=>['required']
        ]);

        $category =  Category::findOrFail($id);
        $category->name = $request->name;
        $category->image = $request->image;
        $category->status = $request->status;
        $category->slug = Str::slug($request->name);
        $category->save();

        toastr('Cập nhật liệu thành công!', 'success');
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category =  Category::findOrFail($id);
        $products = Product::where('brand_id', $category->id)->get();
        if($products->count() == 0){
            $category->delete();
            return response(['status' => 'success' , 'message' => 'Xóa thành công!']);
        }else{
            return response(['status' => 'error' , 'message' => 'Còn tồn tại sản phẩm thuộc danh mục này!']);

        }
    }

    public function changeStatus(Request $request){
        // dd($request->all());
        $category = Category::findOrFail($request->id);
        $category->status = $request->status ? 1 : 0;
     
        $category->save();
        $products = Product::where('category_id', $request->id)->get();
        foreach($products as $item){
            $product =  Product::where('id', $item->id)->first();
            $product->status =$request->status ? 1 : 0;
            $product->save();
        }

        return response(['message' => 'Cập nhật trạng thái thành công!']);
    }
}
