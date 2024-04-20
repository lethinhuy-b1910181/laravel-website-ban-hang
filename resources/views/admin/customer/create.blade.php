@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Khách Hàng</h1>
      
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.customer.index') }}">Khách Hàng</a></div>
        <div class="breadcrumb-item">Thêm</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-13 col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4>Thêm Khách Hàng Mới</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.customer.store') }}" method="POST" >
                    @csrf
                    <input type="hidden"  class="form-control" value="password" name="password">
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="">Tên Khách Hàng<span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group col-4">
                            <label for="">Email<span class="text-danger">(*)</span></label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="form-group col-4">
                            <label for="">Số điện thoại<span class="text-danger">(*)</span></label>
                            <input type="number" class="form-control" name="phone">
                        </div>
                       
                    </div>
                    <div class="row">
                        <div class="col-4 form-group">
                          
                            <label for="">Thành phố/Tỉnh<span class="text-danger">(*)</span></label>
                            <select class="form-control select2 city" name="city_id">
                                <option value="">Chọn Tỉnh/Thành phố</option>
                                @foreach ($cities as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                              @endforeach
                            </select>
                        
                        </div>
                        <div class="col-4 form-group">
                            <label for="">Quận / Huyện<span class="text-danger">(*)</span></label>
                            <select class="form-control select2 district" name="district_id">
                                <option>Chọn Xã/Phường/Thị Trấn</option>
                                
                              </select>
                        </div>
                        <div class="col-4 form-group">
                            <label for="">Xã, Phường, Thị Trấn<span class="text-danger">(*)</span></label>
                            <select class="form-control select2 ward" name="ward_id">
                                <option>Chọn Xã/Phường/Thị Trấn</option>
                                
                              </select>
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-6">
                            <label for="">Địa chỉ cụ thể<span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control" name="address">
                        </div>
                        <div class="form-group col-6">
                            <label for="">Trạng thái<span class="text-danger">(*)</span></label>
                            <select class="form-control select2 " name="status">
                                <option value="1">Kích hoạt</option>
                                <option value="2">VIP</option>
                                <option value="0">Chưa kích hoạt</option>
                                
                              </select>
                        </div>
                       
                       
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

@push('scripts')

<script>
    $(document).ready(function(){
        $('.city').change(function(){
            var city_id = $(this).val();
            console.log(city_id);
            $.ajax({
                url: "{{ route('user.get-district', '') }}/" + city_id,
                type: 'GET',
                success:function(response){
           
                    var options = '<option value="">Chọn Quận/Huyện</option>';
                    $.each(response, function(index, district){
                        options += '<option value="'+district.id+'">'+district.name+'</option>';
                    });
                    $('.district').html(options);
                }
            });
        });
  
        $('.district').change(function(){
          var district_id = $(this).val();
          $.ajax({
              url: "{{ route('user.get-ward', '') }}/" + district_id,
              type: 'GET',
              success:function(response){
                  var options = '<option value="">Chọn Xã/Phường/Thị Trấn</option>';
                  $.each(response, function(index, ward){
                      options += '<option value="'+ward.id+'">'+ward.name+'</option>';
                  });
                  $('.ward').html(options);
              }
          });
      });
  
    });
</script>
    
@endpush