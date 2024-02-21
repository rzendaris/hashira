@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('content')
<div class="row">
  <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
    <div class="card">
      <div class="row row-bordered g-0">
        <div class="col-md-12">
          <h5 class="card-header m-0 me-2 pb-3">Number of Student</h5>
          <input type="hidden" value="{{ $data['x'] }}" name="x" id="x"/>
          <input type="hidden" value="{{ $data['y'] }}" name="y" id="y"/>
          <div id="totalRevenueChart" class="px-2"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <!-- Payments -->
  @if(isset($data['total_transaction']))
    <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between pb-0">
          <div class="card-title mb-0">
            <h5 class="m-0 me-2">Payments</h5>
            <small class="text-muted"></small>
          </div>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex flex-column align-items-center gap-1">
              <h4 class="mb-2">Rp. {{ number_format($data['total_transaction'], 0) }}</h4>
              <span>Total Transaction</span>
            </div>
            <div id="paymentStatisticsChart"></div>
          </div>
          <ul class="p-0 m-0">
            <li class="d-flex mb-4 pb-1">
              <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-primary"><i class='bx bx-mobile-alt'></i></span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-0">Paid</h6>
                  <!-- <small class="text-muted">Mobile, Earbuds, TV</small> -->
                </div>
                <div class="user-progress">
                  <small class="fw-semibold">Rp. {{ number_format($data['paid'], 0) }}</small>
                </div>
              </div>
            </li>
            <li class="d-flex mb-4 pb-1">
              <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-success"><i class='bx bx-closet'></i></span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-0">Not Paid</h6>
                  <!-- <small class="text-muted">T-shirt, Jeans, Shoes</small> -->
                </div>
                <div class="user-progress">
                  <small class="fw-semibold">Rp. {{ number_format($data['not_paid'], 0) }}</small>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  @endif
  <!--/ Payments -->

  <!-- Invoices -->
  @if(isset($data['invoices']))
    <div class="col-md-6 col-lg-4 order-2 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0 me-2">Payment Reminder</h5>
        </div>
        <div class="card-body">
          <ul class="p-0 m-0">
            @foreach($data['invoices'] as $invoice)
            <li class="d-flex mb-4 pb-1">
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <small class="text-muted d-block mb-1">Pembayaran ke-{{ $invoice->installment }} Periode {{ Carbon\Carbon::parse($invoice->start_date)->format('d F Y') }} - {{ Carbon\Carbon::parse($invoice->end_date)->format('d F Y') }}</small>
                  <h6 class="mb-0">{{ $invoice->transaction->student->name }} - {{ $invoice->transaction->student->location->name }}</h6>
                </div>
              </div>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  @endif
  <!--/ Events -->

  <!-- Expense Overview -->
  <!-- <div class="col-md-6 col-lg-4 order-1 mb-4">
    <div class="card h-100">
      <div class="card-header">
        <ul class="nav nav-pills" role="tablist">
          <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tabs-line-card-income" aria-controls="navs-tabs-line-card-income" aria-selected="true">Income</button>
          </li>
          <li class="nav-item">
            <button type="button" class="nav-link" role="tab">Expenses</button>
          </li>
          <li class="nav-item">
            <button type="button" class="nav-link" role="tab">Profit</button>
          </li>
        </ul>
      </div>
      <div class="card-body px-0">
        <div class="tab-content p-0">
          <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
            <div class="d-flex p-4 pt-3">
              <div class="avatar flex-shrink-0 me-3">
                <img src="{{asset('assets/img/icons/unicons/wallet.png')}}" alt="User">
              </div>
              <div>
                <small class="text-muted d-block">Total Balance</small>
                <div class="d-flex align-items-center">
                  <h6 class="mb-0 me-1">$459.10</h6>
                  <small class="text-success fw-semibold">
                    <i class='bx bx-chevron-up'></i>
                    42.9%
                  </small>
                </div>
              </div>
            </div>
            <div id="incomeChart"></div>
            <div class="d-flex justify-content-center pt-4 gap-2">
              <div class="flex-shrink-0">
                <div id="expensesOfWeek"></div>
              </div>
              <div>
                <p class="mb-n1 mt-1">Expenses This Week</p>
                <small class="text-muted">$39 less than last week</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> -->
  <!--/ Expense Overview -->

  <!-- Last Classes -->
  @if(isset($data['class']))
    <div class="col-md-6 col-lg-4 order-2 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0 me-2">Last Classes - {{ Carbon\Carbon::parse($data['class']->created_at)->format('d F Y') }}</h5>
        </div>
        <div class="card-body">
          <ul class="p-0 m-0">
            <li class="d-flex mb-4 pb-1">
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <small class="text-muted d-block mb-1">Material</small>
                  <h6 class="mb-0">{{ $data['class']->name }}</h6>
                </div>
              </div>
            </li>
            <li class="d-flex mb-4 pb-1">
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <small class="text-muted d-block mb-1">Task</small>
                  <h6 class="mb-0">{{ $data['class']->task }}</h6>
                </div>
              </div>
            </li>
            <li class="d-flex mb-4 pb-1">
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <small class="text-muted d-block mb-1">Note</small>
                  <h6 class="mb-0">{{ $data['class']->note }}</h6>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  @endif
  <!--/ Last Classes -->

  <!-- Events -->
  @if(isset($data['events']))
    <div class="col-md-6 col-lg-4 order-2 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0 me-2">Events</h5>
        </div>
        <div class="card-body">
          <ul class="p-0 m-0">
            @foreach($data['events'] as $event)
            <li class="d-flex mb-4 pb-1">
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <small class="text-muted d-block mb-1">{{ Carbon\Carbon::parse($event->start_date)->format('d F Y') }} - {{ Carbon\Carbon::parse($event->end_date)->format('d F Y') }}</small>
                  <h6 class="mb-0">{{ $event->name }}</h6>
                </div>
              </div>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  @endif
  <!--/ Events -->
</div>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
<script>
  let o, t, e, r;
  o = config.colors.white, t = config.colors.headingColor, e = config.colors.axisColor, r = config.colors.borderColor;
  const p = document.querySelector("#paymentStatisticsChart"),
    c = {
        chart: {
            height: 165,
            width: 130,
            type: "donut"
        },
        labels: ["Paid", "Not Paid"],
        series: [{{ $data['paid_pct'] }}, {{ $data['not_paid_pct'] }}],
        colors: [config.colors.primary, config.colors.secondary],
        stroke: {
            width: 5,
            colors: o
        },
        dataLabels: {
            enabled: !1,
            formatter: function(o, t) {
                return parseInt(o) + "%"
            }
        },
        legend: {
            show: !1
        },
        grid: {
            padding: {
                top: 0,
                bottom: 0,
                right: 15
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: "75%",
                    labels: {
                        show: !0,
                        value: {
                            fontSize: "1.5rem",
                            fontFamily: "Public Sans",
                            color: t,
                            offsetY: -15,
                            formatter: function(o) {
                                return parseInt(o) + "%"
                            }
                        },
                        name: {
                            offsetY: 20,
                            fontFamily: "Public Sans"
                        },
                        total: {
                            show: !0,
                            fontSize: "0.8125rem",
                            color: e,
                            label: "Paid",
                            formatter: function(o) {
                                return {{ $data['paid_pct'] }} + '%'
                            }
                        }
                    }
                }
            }
        }
    };
  if (void 0 !== typeof p && null !== p) {
      new ApexCharts(p, c).render()
  }
</script>
@endsection
