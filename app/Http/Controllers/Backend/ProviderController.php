<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Provider;
use App\DataTables\ProviderDataTable;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProviderDataTable $dataTable)
    {
        return $dataTable->render('admin.provider.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.provider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:200', 'unique:colors,name'],
            
        ]);

        $provider = new Provider();
        $provider->name = $request->name;
        $provider->email = $request->email;
        $provider->phone = $request->phone;
        $provider->address = $request->address;
        
        $provider->save();

        toastr('Lưu dữ liệu thành công!', 'success');
        return redirect()->route('admin.provider.index');
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
        $provider = Provider::findOrFail($id);
        return view('admin.provider.edit', compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'max:200', 'unique:colors,name,'.$id],
            
        ]);

        $provider =  Provider::findOrFail($id);
        $provider->name = $request->name;
        $provider->email = $request->email;
        $provider->phone = $request->phone;
        $provider->address = $request->address;
        $provider->status = $request->status;
        
        $provider->save();

        toastr('Lưu dữ liệu thành công!', 'success');
        return redirect()->route('admin.provider.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $provider =  Provider::findOrFail($id);
        $provider->delete();

        return response(['status' => 'success' , 'message' => 'Xóa thành công!']);
    }
}
