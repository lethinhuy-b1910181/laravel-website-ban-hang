@extends('frontend.layouts.master')

@section('content')
<div class="container BtZOqO">
    @include('frontend.sidebar')
    <div class="fkIi86">
        <div class="CAysXD">
            <div class="" style="display: contents;">
                <div class="utB99K">
                    <div class="SFztPl">
                        <h1 class="BVrKV_">
                            Hồ Sơ Của Tôi
                        </h1>
                    </div>
                    <div class="RCnc9v">
                        <div class="HrBg9Q">
                            <form action="{{ route('user.profile.update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="avt">
                                    <div class="profile-avatar">
                                        <img id="showImage" src="{{ Auth::guard('customer')->user()->image ? asset( Auth::guard('customer')->user()->image) : asset('uploads/default.png') }}" >
                                        <div class="change-avatar">
                                            <input style="display: none" type="file" name="image" id="fileElem" multiple accept="image/*" onchange="handleFiles(this.files)">
                                            <label style="cursor: pointer;" for="fileElem"><i class="fa fa-camera"></i></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body ">
                                    <div class="form-group row mt-3">
                                        <label class="col-sm-3 col-form-label text-right label">Email</label>
                                        <div class="col-sm-9">
                                          <input type="text" name="name" disabled value="{{  Auth::guard('customer')->user()->email  }}" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <label class="col-sm-3 col-form-label text-right label">Họ và Tên</label>
                                        <div class="col-sm-9">
                                          <input type="text" name="name" value="{{ Auth::guard('customer')->user()->name }}" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <label class="col-sm-3 col-form-label text-right label">Số điện thoại</label>
                                        <div class="col-sm-9">
                                          <input type="text" name="phone" value="{{  Auth::guard('customer')->user()->phone }}" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mt-3">
                                        <button type="submit" class="btn btn-solid-primary btn--m btn--inline" aria-disabled="false">Lưu thay đổi</button>

                                    </div>
                                    
                                </div>
                             </form>
                        </div>
                        
                    </div>


                </div>
            </div>
                {{-- <div class="qtYn7m">
                    <h5>Hồ Sơ Của Tôi</h5>
                </div>
                <div class="KK80cT">
                     <form action="" method="post">
                        @csrf
                    <div class="avt">
                        <div class="profile-avatar">
                            <img id="showImage" src="" >
                            <div class="change-avatar">
                                <input type="file" name="photo" id="fileElem" multiple accept="image/*" onchange="handleFiles(this.files)">
                                <label style="cursor: pointer;" for="fileElem"><i class="fa fa-camera"></i></label>
                            </div>
                        </div>
                    </div>
                     </form>
                </div> --}}
            
        </div>
       
    </div>
</div>

@endsection