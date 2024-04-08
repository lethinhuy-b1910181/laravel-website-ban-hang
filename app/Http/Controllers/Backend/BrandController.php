<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
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
        return view('admin.brand.create');
        
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
        return view('admin.brand.edit', compact('brand'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'image' => ['required','image', 'max:2000'],
            'name' => ['required', 'max:200', 'unique:brands,name,'.$id]
            
        ]);
        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
        $imagePath = $this->updateImage($request, 'image', 'uploads', $brand->image);
        $brand->image = empty(!$imagePath) ? $imagePath : $brand->image;
        $brand->status = $request->status;
        $brand->slug = Str::slug($request->name);
        $brand->save();
        toastr('Dữ liệu đã được lưu!', 'success');
        return redirect()->route('admin.brand.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        $this->deleteImage($brand->image);
        $brand->delete();

        return response(['status' => 'success' , 'message' => 'Xóa thành công!']);
    }

    public function changeStatus(Request $request){
        $brand = Brand::findOrFail($request->id);
        $brand->status = $request->status ? 1 : 0;
     
        $brand->save();

        return response(['message' => 'Cập nhật trạng thái thành công!']);
    }
    
}
