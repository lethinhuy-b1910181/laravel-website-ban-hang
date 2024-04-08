@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Nhân viên</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.staff.index') }}">Nhân viên</a></div>
        <div class="breadcrumb-item">Thêm</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-10 col-md-10 col-lg-10">
          <div class="card">
            <div class="card-header">
              <h4>Thêm Nhân Viên Mới</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.staff.store') }}" method="POST" >
                    @csrf
                    <input type="hidden"  class="form-control" value="password" name="password">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="">Tên Nhân Viên<span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group col-6">
                            <label for="">Email<span class="text-danger">(*)</span></label>
                            <input type="email" class="form-control" name="email">
                        </div>
                       
                    </div>

                    <div class="form-group">
                      <label for="">Quyền hạn<span class="text-danger">(*)</span></label>
                      <select class="form-control select2" multiple="" name='quyen_id[]'>
                        <option value="">----- Cấp Quyền----- </option>
                        @foreach ($quyens as $item)
                            <option value="{{ $item->id }}">{{ $item->description }}</option>
                        @endforeach
                    </select>
                  </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success"><b>THÊM</b></button>

                    </div>
                </form>
            </div>
            
          </div>
        </div>
      </div>
      
    </div>
  </section>
@endsection