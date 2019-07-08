@extends('admin.index')

@section('breadcrumb')
  <ol class="breadcrumb bg-white m-0">
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.home.index') }}">Trang chủ</a></li>
    <li class="breadcrumb-item active" aria-current="page">Slideshow</li>
  </ol>
@endsection

@section('content')
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
                <span class="text-uppercase page-subtitle">Trang chính</span>
                <h3 class="page-title">Slideshow</h3>
              </div>
            </div>
            <!-- End Page Header -->
            <div class="row">
              <div class="col-xl-7 col-lg-8 col-md-12">
                <div class="btn-group mb-4">
                  <a class="btn btn-primary" href="{{ route('admin.slideshow.create') }}">
                    Thêm mới
                  </a>
                  <button class="btn btn-danger" onclick="destroyMany()">
                    Xóa
                  </button>
                </div>
              </div>
            </div>
            <div class="custom-control custom-checkbox mb-3">
              <input type="checkbox" class="custom-control-input" name="" value="" id="all"><label class="custom-control-label" for="all">Chọn tất cả</label>
            </div>
            <div class="row">
              <div class="col">
                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Slides</h6>
                  </div>
                  <div class="card-body p-0 pb-2">
                    <table class="table table-responsive-lg mb-0 table-hover">
                      <thead class="bg-secondary text-white">
                        <tr>
                          <th scope="col" class="border-0 align-middle"><i class="material-icons">check_box</i></th>
                          <th scope="col" class="border-0 align-middle">Ảnh</th>
                          <th scope="col" class="border-0 align-middle">Caption</th>
                          <th scope="col" class="border-0 align-middle">Link</th>
                          <th scope="col" class="border-0 align-middle">Ngày tạo</th>
                          <th scope="col" class="border-0 align-middle">active</th>
                          <th scope="col" class="border-0 align-middle">Hành động</th>
                        </tr>
                      </thead>
                      <tbody>
                      	@forelse ($slideshow as $slide)
                      	<tr class="item">
                          <td class="align-middle">
                            <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input multi-choice" name="id[]" value={{$slide->id}} id="sl{{$slide->id}}"><label class="custom-control-label" for="sl{{$slide->id}}"></label>
                            </div>
                          </td>
                          <td class="align-middle"><img src="{{asset('storage/slide/'.$slide->photo)}}" alt="{{$slide->photo}}" width="300px"></td>
                          <td class="align-middle">{{$slide->caption}}</td>
                          <td class="align-middle"><a href="{{$slide->link}}">{{$slide->link}}</a></td>
                          <td class="align-middle">{{$slide->created_at}}</td>
                          <td class="align-middle"><span class="text-{{($slide->active)? 'success':'secondary'}}">{{($slide->active)? 'active':'inactive'}}</span></td>
                          <td class="align-middle">
                            <div class="btn-group">
                              <a class="btn btn-warning btn-sm" href="{{ route('admin.slideshow.edit', [$slide->id]) }}" title="Chỉnh sửa"><i class="fas fa-pencil-alt"></i></a>
                              <button class="btn btn-danger btn-sm" onclick="destroy('{{ route('admin.slideshow.delete', [$slide->id]) }}')" title="Xóa"><i class="fas fa-trash-alt"></i></button>
                            </div>
                          </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan=7>Không có dữ liệu</td>
                        </tr>
                      	@endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <script>
            var checkedAll = false;

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
                success: function(result) {
                  if(result.status == "success") {
                    alert("Xóa thành công");
                    window.location.reload();
                  }
                  else {
                    alert("Xóa thất bại");
                  }
                },
                error: function(error) {
                  console.log(error);
                }
              });
            }

            function destroyMany() {
                if ($('.multi-choice:checked').length == 0) {
                  alert('Chưa có slide nào được chọn');
                  return false;
                }

                if(!confirm("Bạn có chắc chắn xóa?")) {
                  return false;
                }

                var data = new FormData();

                $('.multi-choice:checked').each(function() {
                  data.append('id[]', $(this).val());
                });

                $.ajax({
                  url: "{{route('admin.slideshow.deleteMany')}}",
                  method: "post",
                  processData: false,
                  contentType: false,
                  headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                  },
                  data: data,
                  success: function(result) {
                    if(result.status == "success") {
                      alert("Xóa thành công");
                      window.location.reload();
                    }
                    else {
                      if (result.status == 'fail') {
                        alert("Xóa thất bại");
                      } 
                    }
                  },
                  error: function(error) {
                    console.log(error);
                  }
                });
            }

            function selectCard(checkbox) {
              var card = checkbox.parents('.item');
              if (card.hasClass('bg-light')) {
                card.removeClass('bg-light');
              } else {
                card.addClass('bg-light');
              }
              if (checkedAll) {
                checkedAll = false;
                $("#all").prop("checked", false);
              }
            }

            function selectAll() {
              checkboxes = $('.multi-choice');

              if (checkedAll) {
                checkboxes.each(function() {
                  $(this).prop("checked", false);
                  var card = $(this).parents('.item');
                  card.removeClass('bg-light');
                });
                checkedAll = false;
              } else {
                checkboxes.each(function() {
                  $(this).prop("checked", true);
                  var card = $(this).parents('.item');
                  card.addClass('bg-light');
                });
                checkedAll = true;
              }
            }

            $(function() {
              $(".multi-choice").on("click", function() {
                selectCard($(this));
              });
              $("#all").on("click", function() {
                selectAll();
              });
            })
          </script>
@endsection