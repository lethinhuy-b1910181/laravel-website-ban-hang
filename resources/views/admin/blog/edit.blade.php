@extends('admin.layouts.master')

@section('content')
      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Bài Viết</h1>

          </div>

          <div class="section-body">

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Cập Nhật Bài Viết</h4>
                  </div>
                  <div class="card-body">
                    <form action="{{route('admin.blog.update', $blog->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <img src="{{asset($blog->image)}}" width="200px" alt="">
                            <br>
                            <label>Hình ảnh</label>
                            <input type="file" class="form-control" name="image">
                        </div>

                        <div class="form-group">
                            <label>Tiêu đề</label>
                            <input type="text" class="form-control" name="title" value="{{$blog->title}}">
                        </div>


                        <div class="form-group">
                            <label for="inputState">Danh mục</label>
                            <select id="inputState" class="form-control main-category" name="category">
                                <option value="">Chọn danh mục</option>
                                @foreach ($categories as $category)
                                <option {{$category->id == $blog->category_id ? 'selected' : ''}} value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea name="description" class="form-control summernote">{!!$blog->description!!}</textarea>
                        </div>

                      

                        <div class="form-group">
                            <label for="inputState">Trang thái</label>
                            <select id="inputState" class="form-control" name="status">
                              <option {{$blog->status == 1 ? 'selected' : ''}} value="1">Hiển thị</option>
                              <option {{$blog->status == 0 ? 'selected' : ''}} value="0">Không hiển thị</option>
                            </select>
                        </div>
                        <button type="submmit" class="btn btn-primary">Cập nhật</button>
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

    </script>
@endpush
