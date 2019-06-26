@extends('admin.index')
@section('content')
          <div class="main-content-container container-fluid px-4">
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
              <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">Chi tiết</span>
                <h3 class="page-title">Danh mục</h3>
              </div>
            </div>
            <!-- End Page Header -->
            <div class="row">
              <div class="col-12">
                <div class="card mb-4">
                  <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tên danh mục:</label>
                                <input type="text" class="form-control" value="{{$category->name}}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Danh mục chính:</label>
                                <input type="text" class="form-control" value="{{isset($category->parentCategory->name)? $category->parentCategory->name:'Không'}}" readonly>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="form-control custom-control-input" id="active" name="active" value=1{{$category->active? ' checked': ''}} disabled>
                                    <label class="custom-control-label" for="active">Active</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="btn-group">
                                    <a class="btn btn-warning btn-sm" href="{{route('admin.category.edit', [$category->id])}}"><i class="fas fa-pencil-alt"></i></a>
                                    @if ($category->subCategories->isEmpty())
                                        <button class="btn btn-danger btn-sm" type="button" onclick="destroy('{{route('admin.category.delete', [$category->id])}}')"><i class="fas fa-trash-alt"></i></button>
                                    @else
                                        <button class="btn btn-secondary btn-sm" type="button" title="Không thể xóa do có danh mục con" disabled><i class="fas fa-trash-alt"></i></button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Danh mục con:</label>
                            
                            @if (!$category->subCategories->isEmpty())
                            <ul class="list-group">
                                @foreach ($category->subCategories as $subCategory)
                                <li class="list-group-item m-0 p-0 disabled"><button type="button" class="btn btn-light disabled mr-3"><i class="fas fa-times"></i></button>{{$subCategory->name}}</li>
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
              function destroy(url) {
                if(!confirm("Bạn có chắc chắn xóa?")) {
                    return false;
                }

                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: {
                        "_token" : '{{csrf_token()}}', 
                        "_method" : "DELETE"
                    },
                    success : function(result) {
                        if(result.status == "success") {
                            alert("Xóa thành công");
                            window.location.href = "{{route('admin.category.index')}}";
                        }
                        else {
                            if (result.status == 'fail') {
                                alert("Xóa thất bại");
                            } else {
                                alert('Không thể xóa do có danh mục có danh mục con');
                            }
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
          </script>
@endsection