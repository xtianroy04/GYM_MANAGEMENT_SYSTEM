@extends(backpack_view('blank'))

@section('content')
<script src="{{ asset('assets/js/bladeScript.js')}}"></script>
<nav aria-label="breadcrumb" class="d-flex justify-content-end me-3 mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Admin</a></li>
        <li class="breadcrumb-item"><a href="{{ route('report')}}">Daily Checkins</a></li>
        <li class="breadcrumb-item active" aria-current="page">List</li>
    </ol>
</nav>
<h1 class="text-capitalize ms-3" bp-section="page-heading">Daily Checkins</h1>
{{-- Table checkin record --}}
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="get" action="{{ url()->current() }}">
                        <div class="row">
                            <div class="col-md-2 mt-2">
                                <label class="form-label">Period:</label>
                                <select name="period" class="form-select">
                                    <option value="custom" {{ $selectedPeriod == 'custom' ? 'selected' : '' }}>Custom</option>
                                    <option value="week" {{ $selectedPeriod == 'week' ? 'selected' : '' }}>This Week</option>
                                    <option value="month" {{ $selectedPeriod == 'month' ? 'selected' : '' }}>This Month</option>
                                    <option value="quarter" {{ $selectedPeriod == 'quarter' ? 'selected' : '' }}>This Quarter</option>
                                    <option value="year" {{ $selectedPeriod == 'year' ? 'selected' : '' }}>This Year</option>
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
                
                    <div class="table-responsive mt-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">First Name</th>
                                    <th scope="col">Last Name</th>
                                    <th scope="col">Date Checkin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reports as $i)
                                    <tr>
                                        <td>{{ $i->id }}</td>
                                        <td>{{ $i->member->code}}</td>
                                        <td>{{ $i->member->first_name }}</td>
                                        <td>{{ $i->member->last_name }}</td>
                                        <td>{{ date('F j, Y g:i A', strtotime($i->checkin_time)) }}</td>   
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center alert alert-danger">No data found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-4 mb-3">
                            {{ $reports->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection