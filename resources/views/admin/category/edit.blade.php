@extends('admin.index')
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
          @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <i class="fa fa-info mx-2"></i>
            {{session('success')}}
          </div>    
          @endif

          <div class="main-content-container container-fluid px-4">
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
              <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">Chỉnh sửa</span>
                <h3 class="page-title">Danh mục</h3>
              </div>
            </div>
            <!-- End Page Header -->
            <div class="row">
              <div class="col-12">
                <div class="card mb-4">
                  <div class="card-body">
                    <div class="row">
                        <form class="col-md-6" action="{{route('admin.category.update', [$category->id])}}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên danh mục:</label>
                                <input type="text" class="form-control @error('name')is-invalid @enderror" id="name" name="name" value="{{$category->name}}">
                                @error('name')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="status">Danh mục chính:</label>
                                <select id="inputState" class="form-control" name="parent_id" @if (!$category->subCategories->isEmpty())disabled @endif>
                                    <option value=0{{empty($category->parent_id)? ' selected': ''}}>Không</option>
                                    @foreach ($categories as $maincategory)
                                    <option value={{$maincategory->id}}{{$category->parent_id == $maincategory->id? ' selected': ''}}>{{$maincategory->name}}</option>
                                    @endforeach
                                </select>
                                @if (!$category->subCategories->isEmpty())
                                <small>Không thể sửa do có danh mục con</small> 
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="form-control custom-control-input" id="active" name="active" value=1{{$category->active? ' checked': ''}}>
                                    <label class="custom-control-label" for="active">Active</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Chỉnh sửa</button>
                            </div>
                        </form>
                        <div class="form-group col-md-6">
                            <label>Danh mục con:</label>

                            @if (!$category->subCategories->isEmpty())
                            <ul class="list-group">
                                @foreach ($category->subCategories as $subCategory)
                                <li class="list-group-item m-0 p-0"><button type="button" class="btn btn-light mr-3" onclick="removeSubCategory('{{route('admin.category.update.removeSub', [$category->id, $subCategory->id])}}')"><i class="fas fa-times"></i></button>{{$subCategory->name}}</li>
                                @endforeach
                            </ul>
                            @else
                            Không
                            @endif
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <script>
              function removeSubCategory(dir) {
                if (confirm("Bạn có chắc chắn muốn xóa danh mục con này không?")) {
                    window.location.href = dir;
                }
              }
          </script>
@endsection