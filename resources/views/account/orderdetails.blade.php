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
	           <div class="row">
              <div class="col-lg-4">
                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    Thông tin đơn hàng
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">Mã đơn hàng: </div>
                      <div class="font-weight-normal text-right">{{$invoice->id}}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">Tổng: </div>
                      <div class="font-weight-normal">{{number_format($invoice->total)}} VNĐ</div>
                    </div>
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">Chiết khấu: </div>
                      <div class="font-weight-normal text-right">{{!empty($invoice->discount_percent)? '- '.$invoice->discount_percent.'%':(!empty($invoice->discount_cash)? '- '.number_format($invoice->discount_cash).' VNĐ':'')}}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">Thành tiền: </div>
                      <div class="font-weight-normal text-right">{{number_format($invoice->total_with_discount)}} VNĐ</div>
                    </div>
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">Tình trạng: </div>
                      <div class="font-weight-normal text-right">
                        @switch($invoice->status)
                          @case(0)
                              <span class="text-primary">Đang chờ</span>
                              @break
                  
                          @case(1)
                              <span class="text-success">Thành công</span>
                              @break
                  
                          @case(2)
                              <span class="text-black-50">Hủy</span>
                              @break

                          @case(3)
                              <span class="text-warning">Xác nhận</span>
                              @break
                      
                          @default
                              <span class="text-primary">Đang chờ</span>
                        @endswitch
                      </div>
                    </div>
                  </div>
                </div>

                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    Thông tin khách hàng
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">Tên: </div>
                      <div class="font-weight-normal text-right">{{$invoice->name}}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">SĐT: </div>
                      <div class="font-weight-normal text-right">{{$invoice->phone_number}}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">Địa chỉ: </div>
                      <div class="font-weight-normal text-right">{{$invoice->address}}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">Email: </div>
                      <div class="font-weight-normal text-right">{{$invoice->email}}</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-8 mb-4">
                <div class="card card-small">
                  <div class="card-header border-bottom">
                    Sản phẩm
                  </div>
                  <div class="card-body p-0 pb-2">
                    <table class="table table-responsive mb-0 table-hover">
                      <thead class="bg-dark text-white">
                        <tr class="text-center">
                          <th scope="col" class="border-0 align-middle text-center">Mã</th>
                          <th scope="col" class="border-0 align-middle text-center">Ảnh</th>
                          <th scope="col" class="border-0 align-middle text-center">Tên</th>
                          <th scope="col" class="border-0 align-middle text-center">Số lượng</th>
                          <th scope="col" class="border-0 align-middle text-center">Đơn giá</th>
                          <th scope="col" class="border-0 align-middle text-center">Thành tiền</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ($invoice->items as $item)
                          @php
                            $price = $item->price;
                          @endphp
                          <tr class="text-center">
                            <td class="align-middle">{{$item->id}}</td>
                            <td class="align-middle">
                              <img src="{{!$item->photos->isEmpty()? asset('storage/product/'.$item->photos[0]->name):''}}" alt="{{$item->name}}" width="200px">
                            </td>
                            <td class="align-middle"><a href="{{ route('details', [str_slug($item->name)."-".$item->id]) }}">{{$item->name}}</a></td>
                            <td class="align-middle">{{$item->pivot->quantity}}</td>
                            <td class="align-middle">
                              <span style="{{!empty($item->pivot->discount_percent) || !empty($item->pivot->discount_cash)?'text-decoration: line-through':''}}">{{number_format($item->price)}} VNĐ</span>

                                @if (!empty($item->pivot->discount_percent))
                                  @php
                                    $price = $item->price - $item->price*$item->pivot->discount_percent/100;
                                  @endphp
                                  <br>
                                  <span>
                                    <span class="badge badge-pill badge-primary">giảm {{$item->pivot->discount_percent}}%</span><br>
                                    {{number_format($price)}} VNĐ
                                  </span>
                                @endif
                                @if (!empty($item->pivot->discount_cash))
                                  @php
                                    $price = $item->price - $item->pivot->discount_cash;
                                  @endphp
                                  <br>
                                  <span>
                                    <span class="badge badge-pill badge-primary">giảm {{$item->pivot->discount_cash}} VNĐ</span><br> 
                                    {{number_format($price)}} VNĐ
                                  </span>
                                @endif
                            </td>
                            <td class="align-middle">{{number_format($price*$item->pivot->quantity)}} VNĐ</td>
                          </tr>
                        @empty
                          <tr>
                            <td colspan=5>Không có dữ liệu</td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              @if ($invoice->status == 0)
              <div class="col-12 mb-4 text-center">
                <div class="btn-group">
                  <button class="btn btn-danger btn-sm" onclick="if (confirm('Bạn có chắc muốn hủy đơn hàng này?')) {document.getElementById('cancelOrder').submit();}" title="Hủy">Hủy</button>
                  <form action="{{ route('account.orders.cancel', [$invoice->id]) }}" method="post" id="cancelOrder" style="display: none">
                    @csrf
                  </form>
                </div>
              </div>
              @endif
              
            </div>
@endsection