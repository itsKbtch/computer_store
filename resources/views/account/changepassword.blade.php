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

	<div class="card">
        <div class="card-header">Đổi mật khẩu</div>

        <div class="card-body">
            <form method="POST" action="{{ route('account.changePassword') }}">
                @csrf

                <div class="form-group row">
                    <label for="new_password" class="col-md-3">{{ __('Mật khẩu mới') }}</label>

                    <div class="col-md-9">
                        <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required autofocus>

                        @error('new_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="confirm_new_password" class="col-md-3">{{ __('Xác nhận mật khẩu') }}</label>

                    <div class="col-md-9">
                        <input id="confirm_new_password" type="password" class="form-control @error('confirm_new_password') is-invalid @enderror" name="confirm_new_password" required>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="current_password" class="col-md-3">{{ __('Mật khẩu hiện tại') }}</label>

                    <div class="col-md-9">
                        <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required>

                        @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary" style="background-color: #5F1E6B; color: #ffffff">
                            Cập nhật mật khẩu
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection