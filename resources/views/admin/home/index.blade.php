@extends('admin.index')

@section('breadcrumb')
  <ol class="breadcrumb bg-white m-0">
    <li class="breadcrumb-item active" aria-current="page">Trang chủ</li>
  </ol>
@endsection

@section('content')
          <div class="main-content-container container-fluid px-4">
	          <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
              <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">Trang chủ</span>
                <h3 class="page-title">Overview</h3>
              </div>
            </div>
            <!-- End Page Header -->
            <!-- Small Stats Blocks -->
            <div class="row">
              <div class="col-lg-4 col-md-12 col-sm-12 mb-4">
                <div class="card card-small h-100">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Sản phẩm bán chạy</h6>
                  </div>
                  <div class="card-body">
                    @forelse ($bestSellers as $bestSeller)
                      <div class="row justify-content-between mb-4">
                        <div class="image col-6">
                          @if (!$bestSeller->photos->isEmpty())
                            <img class="img-fluid" src="{{asset('storage/product/'.$bestSeller->photos[0]->name)}}" alt="{{$bestSeller->name}}">
                          @else
                            <img src="{{asset('img/product/best-product-2.png')}}" alt="product">
                          @endif
                        </div>
                        <div class="detail col-6">
                          <div class="font-weight-normal">{{$bestSeller->name}}</div>
                          <div class="font-weight-normal"><b>Doanh số: </b> {{$bestSeller->sales}}</div>
                        </div>
                      </div>
                    @empty
                      Chưa có dữ liệu
                    @endforelse
                  </div>
                </div>
              </div>   
              <div class="col-lg col-md-6 col-sm-6 mb-4">
                <div class="stats-small stats-small--1 card card-small">
                  <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto">
                      <div class="stats-small__data text-center">
                        <span class="stats-small__label text-uppercase">Đơn hàng mới 7 ngày gần nhất</span>
                        <h6 class="stats-small__value count my-3">{{number_format($invoiceData['total'])}}</h6>
                      </div>
                    </div>
                    <canvas height="120" class="blog-overview-stats-small-1"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-lg col-md-6 col-sm-6 mb-4">
                <div class="stats-small stats-small--1 card card-small">
                  <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto">
                      <div class="stats-small__data text-center">
                        <span class="stats-small__label text-uppercase">Người dùng mới trong 7 ngày gần nhất</span>
                        <h6 class="stats-small__value count my-3">{{number_format($userData['total'])}}</h6>
                      </div>
                    </div>
                    <canvas height="120" class="blog-overview-stats-small-2"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Small Stats Blocks -->
          </div>
          {{-- <script src="{{asset('admin_assets/scripts/app/app-blog-overview.1.1.0.js')}}"></script> --}}
          <script>
            $(function() {
              var boSmallStatsDatasets = [
                {
                  backgroundColor: 'rgba(0, 184, 216, 0.1)',
                  borderColor: 'rgb(0, 184, 216)',
                  data: [{{implode(',',$invoiceData['daily'])}}],
                },
                {
                  backgroundColor: 'rgba(23,198,113,0.1)',
                  borderColor: 'rgb(23,198,113)',
                  data: [{{implode(',',$userData['daily'])}}]
                }
              ];

              // Options
              function boSmallStatsOptions(max) {
                return {
                  maintainAspectRatio: true,
                  responsive: true,
                  // Uncomment the following line in order to disable the animations.
                  // animation: false,
                  legend: {
                    display: false
                  },
                  tooltips: {
                    enabled: false,
                    custom: false
                  },
                  elements: {
                    point: {
                      radius: 0
                    },
                    line: {
                      tension: 0.3
                    }
                  },
                  scales: {
                    xAxes: [{
                      gridLines: false,
                      scaleLabel: false,
                      ticks: {
                        display: false
                      }
                    }],
                    yAxes: [{
                      gridLines: false,
                      scaleLabel: false,
                      ticks: {
                        display: false,
                        // Avoid getting the graph line cut of at the top of the canvas.
                        // Chart.js bug link: https://github.com/chartjs/Chart.js/issues/4790
                        suggestedMax: max
                      }
                    }],
                  },
                };
              }

              // Generate the small charts
              boSmallStatsDatasets.map(function (el, index) {
                var chartOptions = boSmallStatsOptions(Math.max.apply(Math, el.data) + 1);
                var ctx = document.getElementsByClassName('blog-overview-stats-small-' + (index + 1));
                new Chart(ctx, {
                  type: 'line',
                  data: {
                    labels: ["Label 1", "Label 2", "Label 3", "Label 4", "Label 5", "Label 6", "Label 7"],
                    datasets: [{
                      label: 'Today',
                      fill: 'start',
                      data: el.data,
                      backgroundColor: el.backgroundColor,
                      borderColor: el.borderColor,
                      borderWidth: 1.5,
                    }]
                  },
                  options: chartOptions
                });
              });
            });
          </script>
@endsection