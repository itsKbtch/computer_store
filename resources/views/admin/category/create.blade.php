@extends('admin.index')

@section('breadcrumb')
  <ol class="breadcrumb bg-white m-0">
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.home.index') }}">Trang chủ</a></li>
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.category.index') }}">Danh mục</a></li>
    <li class="breadcrumb-item active" aria-current="page">Thêm mới</li>
  </ol>
@endsection

@section('content')
          @if (session('fail'))
          <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <i class="fa fa-info mx-2"></i>
            {{session('fail')}}
          </div>    
          @endif
          
          <div class="main-content-container container-fluid px-4">
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
              <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">Thêm mới</span>
                <h3 class="page-title">Danh mục</h3>
              </div>
            </div>
            <!-- End Page Header -->
            <div class="row">
              <div class="col-12">
                <div class="card mb-4">
                  <div class="card-body">
                    <form action="{{route('admin.category.store')}}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                      @csrf
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label for="name">Tên danh mục:</label>
                          <input type="text" class="form-control @error('name')is-invalid @enderror" id="name" name="name">
                          @error('name')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>
                        <div class="form-group col-md-6">
                          <label for="status">Danh mục chính:</label>
                          <select id="inputState" class="form-control" name="parent_id">
                            <option value=0 selected>Không</option>
                            @foreach ($categories as $category)
                            <option value={{$category->id}}>{{$category->name}}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group col-12">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="form-control custom-control-input" id="active" name="active" value=1 checked>
                            <label class="custom-control-label" for="active">Active</label>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-12">
                          <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection