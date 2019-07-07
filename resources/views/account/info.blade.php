@extends('account.index')

@section('main')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <i class="fa fa-info mx-2"></i>
          {{session('success')}}
        </div>
    @endif

    @if (session('fail'))
      <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <i class="fa fa-info mx-2"></i>
        {{session('fail')}}
      </div>    
    @endif

	<div class="card mb-4">
        <div class="card-header">Thông tin</div>

        <div class="card-body">
            <form method="POST" action="{{ route('account.infoUpdate') }}">
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-md-3">{{ __('Họ tên') }}</label>

                    <div class="col-md-9">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{Auth::user()->name}}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-3">{{ __('E-Mail') }}</label>

                    <div class="col-md-9">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{Auth::user()->email}}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="phone_number" class="col-md-3">{{ __('SĐT') }}</label>

                    <div class="col-md-9">
                        <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{Auth::user()->phone_number}}" required>

                        @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="address" class="col-md-3">{{ __('Địa chỉ') }}</label>

                    <div class="col-md-9">
                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{Auth::user()->address}}" required>

                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary btn-sm" style="background-color: #5F1E6B; color: #ffffff">
                            Cập nhật thông tin
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">Quản lí</div>

        <div class="card-body">
            <ul class="nav">
                <li class="nav-item"><a class="text-danger" href="{{ route('account.index.deleteConfirm') }}" onclick="return confirm('Bạn có chắc muốn xóa tài khoản?')">Xóa tài khoản</a></li>
            </ul>
        </div>
    </div>
@endsection