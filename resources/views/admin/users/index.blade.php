@extends('admin.index')

@section('breadcrumb')
  <ol class="breadcrumb bg-white m-0">
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.home.index') }}">Trang chủ</a></li>
    <li class="breadcrumb-item active" aria-current="page">Thành viên</li>
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
                <h3 class="page-title">Thành viên</h3>
              </div>
            </div>
            <!-- End Page Header -->
            <div class="row">
              <div class="input-group mb-3 col-xl-5 col-lg-4 col-md-12">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" id="keyword" class="form-control" placeholder="search" aria-label="search" value="{{isset($_GET['keyword'])? $_GET['keyword']:''}}"> 
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Thành viên</h6>
                  </div>
                  <div class="card-body p-0 pb-2">
                    <table class="table table-responsive-lg mb-0 table-hover">
                      <thead class="bg-secondary text-white">
                        <tr>
                          <th scope="col" class="border-0 align-middle">ID</th>
                          <th scope="col" class="border-0 align-middle">Họ tên</th>
                          <th scope="col" class="border-0 align-middle">Email</th>
                          <th scope="col" class="border-0 align-middle">SĐT</th>
                          <th scope="col" class="border-0 align-middle">Ngày tạo</th>
                          <th scope="col" class="border-0 align-middle">Hành động</th>
                        </tr>
                      </thead>
                      <tbody>
                      	@forelse ($users as $user)
                      	<tr class="item">
                          <td class="align-middle">{{$user->id}}</td>
                          <td class="align-middle">{{$user->name}}</td>
                          <td class="align-middle">{{$user->email}}</td>
                          <td class="align-middle">{{$user->phone_number}}</td>
                          <td class="align-middle">{{$user->created_at}}</td>
                          <td class="align-middle">
                            <div class="btn-group">
                              <a class="btn btn-info btn-sm" href="{{ route('admin.users.details', [$user->id]) }}" title="Chi tiết"><i class="fas fa-info-circle"></i></a>
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
            function filter() {
              var url = "?";

              url = url + "keyword=" + keyword;
              
              window.location.href = url;
            }

            $(function() {
              $("#keyword").on('keyup', function(event) {
                  if (event.keyCode == 13) {
                      keyword = $('#keyword').val();
                      filter();
                  }
              });
            })
          </script>
@endsection