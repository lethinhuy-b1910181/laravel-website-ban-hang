<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;
use App\DataTables\ColorDataTable;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ColorDataTable $dataTable)
    {
        return $dataTable->render('admin.color.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.color.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => ['required', 'max:200', 'unique:colors,name'],
            
        ]);

        $color = new Color();
        $color->name = $request->name;
        
        $color->save();

        toastr('Lưu dữ liệu thành công!', 'success');
        return redirect()->route('admin.product-color.index');
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
        $color = Color::findOrFail($id);
        return view('admin.color.edit', compact('color'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'max:200', 'unique:categories,name,'.$id],
            
        ]);

        $color =  Color::findOrFail($id);
        $color->name = $request->name;
       
        $color->save();

        toastr('Cập nhật liệu thành công!', 'success');
        return redirect()->route('admin.product-color.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $color =  Color::findOrFail($id);
        $color->delete();

        return response(['status' => 'success' , 'message' => 'Xóa thành công!']);
    }
}
