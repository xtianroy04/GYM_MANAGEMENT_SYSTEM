@extends(backpack_view('blank'))

@section('content')

<nav aria-label="breadcrumb" class="d-flex justify-content-end me-3 mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Admin</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cash')}}">Cash Flow</a></li>
        <li class="breadcrumb-item active" aria-current="page">List</li>
    </ol>
</nav>
<h1 class="text-capitalize ms-3" bp-section="page-heading">Cash Flow</h1>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="get">
                        <div class="row">
                            <div class="col-md-2 mt-2">
                                <label class="form-label">Total Income for:</label>
                                <select name="period" class="form-select">
                                    <option value="custom" {{ $selectedPeriod == 'custom' ? 'selected' : '' }}>Custom</option>
                                    <option value="week" {{ $selectedPeriod == 'week' ? 'selected' : '' }}>This Week</option>
                                    <option value="month" {{ $selectedPeriod == 'month' ? 'selected' : '' }}>This Month</option>
                                    <option value="quarter" {{ $selectedPeriod == 'quarter' ? 'selected' : '' }}>This Quarter</option>
                                    <option value="year" {{ $selectedPeriod == 'year' ? 'selected' : '' }}>This Year</option>
                                    <option value="Cash" {{ $selectedPeriod == 'Cash' ? 'selected' : '' }}>Cash Payments</option>
                                    <option value="GCash" {{ $selectedPeriod == 'GCash' ? 'selected' : '' }}>GCash Payments</option>
                                    <option value="Session" {{ $selectedPeriod == 'Session' ? 'selected' : '' }}>Session</option>
                                </select>
                            </div>
                            <div id="customFields" class="col-md-9 custom-fields" style="{{ $selectedPeriod == 'custom' ? '' : 'display:none;' }}">
                                <div class="row">
                                    <div class="col-md-4 mt-2">
                                        <label class="form-label">Start Month:</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" name="start_month" value="{{ $selectedStartMonth }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="form-label">End Month:</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" name="end_month" value="{{ $selectedEndMonth }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-2" id="yearField">
                                        <label class="form-label">Year:</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="year" value="{{ $selectedYear }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 mt-2 align-self-end">
                                <button type="submit" class="btn btn-primary mt-2">Filter</button>
                            </div>
                        </div>
                    </form>
                    @if(request()->query() && empty(request()->input('page')))
                        <div class="row mt-3 alert alert-info">
                            <div class="col-md-2 mt-3">
                                <h5>Filters:</h5>
                            </div>
                            <div class="col-md-4 mt-3">
                                <p>
                                    @if($selectedPeriod == 'custom')
                                        @if($selectedStartMonth && $selectedEndMonth)
                                            {{ date('F d, Y', strtotime($selectedStartMonth)) }} - {{ date('F d, Y', strtotime($selectedEndMonth)) }}
                                        @elseif($selectedYear)
                                            {{ $selectedYear }}
                                        @elseif($selectedStartMonth === null || $selectedEndMonth === null || $selectedYear === null)
                                            Please provide a valid date range or select a year!
                                        @endif
                                    @elseif($selectedPeriod == 'Session')
                                        @if($selectedStartMonth && $selectedEndMonth)
                                            Session: {{ date('F d, Y', strtotime($selectedStartMonth)) }} - {{ date('F d, Y', strtotime($selectedEndMonth)) }}
                                        @elseif($selectedYear)
                                            Session: {{ $selectedYear }}
                                        @else
                                            Session
                                        @endif
                                    @elseif($selectedPeriod == 'Cash')
                                        @if($selectedStartMonth && $selectedEndMonth)
                                            Cash: {{ date('F d, Y', strtotime($selectedStartMonth)) }} - {{ date('F d, Y', strtotime($selectedEndMonth)) }}
                                        @elseif($selectedYear)
                                            Cash: {{ $selectedYear }}
                                        @else
                                            Cash
                                        @endif
                                    @elseif($selectedPeriod == 'GCash')
                                        @if($selectedStartMonth && $selectedEndMonth)
                                            GCash: {{ date('F d, Y', strtotime($selectedStartMonth)) }} - {{ date('F d, Y', strtotime($selectedEndMonth)) }}
                                        @elseif($selectedYear)
                                            GCash: {{ $selectedYear }}
                                        @else
                                            GCash
                                        @endif
                                    @else
                                        {{ ucwords($selectedPeriod) }}
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end mt-3"> 
                                <div class="pt-0">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="clearFilters('{{ url()->current() }}')">Clear</button>
                                </div>
                            </div>
                        </div>
                    @endif
                        @if(!empty(request()->all()))
                            <div class="d-flex justify-content-center position-relative mt-4">
                                <div class="col-lg-12 col-6">
                                    <div class="small-box bg-light p-3 border rounded h-100 d-flex flex-column justify-content-between">
                                        <div class="inner">
                                            <h4 class="mb-0">Total Income</h4>
                                            <hr>
                                                <h2 class="font-weight-bold text-primary">₱ {{ number_format($totalAmount, 2) }}</h2>
                                        </div>
                                        <div class="ribbon-wrapper">
                                            <div class="ribbon ribbon-top-right d-flex bg-success">
                                                <i class="fa fa-user text-warning"></i> 
                                                <span>
                                                    @if($selectedPeriod == 'custom')
                                                        @if($selectedStartMonth && $selectedEndMonth)
                                                                {{ date('F d, Y', strtotime($selectedStartMonth)) }} - {{ date('F d, Y', strtotime($selectedEndMonth)) }}
                                                        @elseif($selectedYear)
                                                            {{ $selectedYear }}
                                                        @endif
                                                    @else
                                                        {{ ucwords($selectedPeriod) }}
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                      @endif
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-QsHKQzQmVYuExptnkZTFu2KyViH7EkIx8YzL+BJfdbCTCF0aVtAR8xMIlzV72AzOnMjNIuW9ECqE8Abbqc2yQ==" crossorigin="anonymity" referrerpolicy="no-referrer" />
<script src="{{ asset('assets/js/bladeScript.js')}}"></script>
@endsection

