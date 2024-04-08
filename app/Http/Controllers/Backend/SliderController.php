<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Traits\ImageUploadTrait;
use App\DataTables\SliderDataTable;

class SliderController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(SliderDataTable $dataTable)
    {
        return $dataTable->render('admin.slider.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required','image', 'max:2000'],
            'name' => ['required']
        ]);
        $slider = new Slider();
        $slider->name = $request->name;
        $imagePath = $this->uploadImage($request, 'image', 'uploads');
        $slider->image = $imagePath;
        $slider->save();
        toastr('Dữ liệu đã được lưu!', 'success');
        return redirect()->route('admin.slider.index');

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
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'image' => ['required','image', 'max:2000'],
            'name' => ['required']
        ]);
        $slider = Slider::findOrFail($id);

        $slider->name = $request->name;
        $imagePath = $this->updateImage($request, 'image', 'uploads', $slider->image);
        $slider->image = empty(!$imagePath) ? $imagePath : $slider->image;
        $slider->save();
        toastr('Cập nhật thành công!', 'success');
        return redirect()->route('admin.slider.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Slider::findOrFail($id);
        // dd($slider);
        $this->deleteImage($slider->image);
        $slider->delete();

        return response(['status' => 'success' , 'message' => 'Xóa thành công!']);
    }

    public function changeStatus(Request $request){
        $slider = Slider::findOrFail($request->id);
        $slider->status = $request->status ? 1 : 0;
        $slider->save();

        return response(['message' => 'Cập nhật trạng thái thành công!']);
    }
}
