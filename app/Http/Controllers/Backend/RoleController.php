<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\RoleDataTable;
use App\Models\Quyen;
use App\Models\ChiTietQuyen;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RoleDataTable $dataTable)
    {
        return $dataTable->render('admin.role.index');
    }

    public function changeRole(Request $request){
        $admin_id = $request->id;
        $quyen_id = $request->quyen_id;

        $chitietquyen = ChiTietQuyen::where('admin_id', $admin_id)->where('quyen_id', $quyen_id)->first();

        if ($chitietquyen) {
            // Nếu đã tồn tại dữ liệu, đảo ngược giá trị của coquyen
            $chitietquyen->coquyen = !$chitietquyen->coquyen;
            $chitietquyen->save();
        } else {
            // Nếu không tồn tại dữ liệu, tạo mới bản ghi
            $chitietquyen = new ChiTietQuyen();
            $chitietquyen->admin_id = $admin_id;
            $chitietquyen->quyen_id = $quyen_id;
            $chitietquyen->coquyen = 1; // hoặc giá trị mặc định khác tùy thuộc vào yêu cầu của bạn
            $chitietquyen->save();
        }
        return response(['status'=>'success','message' => 'Cấp quyền thành công!']);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
