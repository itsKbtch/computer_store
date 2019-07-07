@extends('account.index')

@section('main')
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
        <div class="card-header">Xóa tài khoản</div>

        <div class="card-body">
            <form method="POST" action="{{ route('account.delete') }}" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?')">
                @csrf

                <div class="form-group row">
                    <label for="password" class="col-md-3">{{ __('Mật khẩu hiện tại') }}</label>

                    <div class="col-md-9">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-danger">
                            Xóa tài khoản
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection