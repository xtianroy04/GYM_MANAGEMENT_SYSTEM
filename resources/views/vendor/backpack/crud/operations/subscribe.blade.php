@extends(backpack_view('blank'))

@section('content')
<nav aria-label="breadcrumb" class="d-flex justify-content-end me-3 mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Admin</a></li>
        <li class="breadcrumb-item"><a href="{{ route('report')}}">Payment</a></li>
        <li class="breadcrumb-item active" aria-current="page">Subscribe</li>
    </ol>
</nav>
<h2 class="text-capitalize ms-3" bp-section="page-heading">Annual Subscription
     @if ($crud->hasAccess('list'))
        <small>
            <a href="{{ url($crud->route) }}" class="d-print-none font-sm">
                <i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i>
                {{ trans('backpack::crud.back_to_all') }}
                <span>{{ $crud->entity_name_plural }}</span>
            </a>
        </small>
    @endif
</h2>
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if($membership === null || ($membership->status === null))
                    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </symbol>
                        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                          <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </symbol>
                        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                          <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </symbol>
                      </svg>
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                            <div>
                                Annual Fee payment required.
                            </div>
                        </div>
                @elseif($membership->status === 'Cancelled')
                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </symbol>
                    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                      <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </symbol>
                    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                      <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </symbol>
                  </svg>
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#info-fill"/></svg>
                        <div>
                            Renew your gym membership to keep enjoying our facilities.
                        </div>
                    </div>
                @elseif($membership->subscription_status === 'Expired')
                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </symbol>
                    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </symbol>
                    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </symbol>
                    </svg>
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#info-fill"/></svg>
                        <div>
                            Please renew your annual-fee.
                        </div>
                    </div>
                @endif
                <div class="card-body">
                        <h1>{{ $memberName->full_name }}</h1>
                    <form method="POST">
                        @csrf
                        <div class="mb-3 row">                      
                    
                        <div class="mb-3 row">
                            <label for="payment_for" class="col-sm-2 col-form-label">Payment Type</label>
                            <div class="col-sm-10">
                                <select name="payment_for" class="form-select">
                                    <option value="" selected disabled>-- Subscription Plan --</option>
                                    @if($membership && $membership->status === 'Active')
                                        @if($membership && $membership->subscription_status === 'Expired' || $membership->subscription_status === null)
                                            <option value="Session">Session</option>
                                        @endif
                                        <option value="Monthly">Monthly</option>
                                        <option value="Bi-Monthly">Bi-Monthly</option>
                                        <option value="6 Months">6 Months</option>
                                        <option value="1 Year">1 Year</option>
                                    @endif
                                    @if($membership == null || $membership->status !== 'Active')
                                      <option value="Annual-Fee">Annual-Fee</option>
                                    @endif
                                </select>
                                
                            </div>
                        </div>
                    
                        <div class="mb-3 row">
                            <label for="type" class="col-sm-2 col-form-label">Payment Method</label>
                            <div class="col-sm-10" id="type">
                                <select name="type" id="payment_type" class="form-select">
                                    <option value="" selected disabled>-- Select Payment Type --</option>
                                    <option value="Gcash">Gcash</option>
                                    <option value="Cash">Cash</option>
                                </select>
                            </div>
                        </div>
                    
                        <div class="mb-3 row" id="transaction_code_field">
                            <label for="transaction_code" class="col-sm-2 col-form-label">Transaction Code</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="transaction_code" name="transaction_code" placeholder="Enter transaction code">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount">
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <input type="hidden" name="_save_action" value="make_payment">
                            <button type="submit" class="btn btn-success"><i class="la la-save"></i> Make Payment</button>
                            <a href="{{ url($crud->route) }}" class="btn btn-default"><i class="la la-ban"></i>&nbsp;Cancel</a>
                        </div>
                    </form>
                    <div class="card mt-4">
                        <div class="card-header">
                            Payment History of &nbsp; <b>{{ $memberName->fullname }}</b>
                        </div>
                        <div class="card-body" style="padding: 0; padding-bottom: 10px;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Payment Type</th>
                                        <th>Payment Method</th>
                                        <th>Transaction Code</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paymentHistory as $payment)
                                    <tr>
                                        <td>{{ date('F j, Y g:i A', strtotime($payment->created_at)) }}</td>
                                        <td>{{ $payment->payment_for }}</td>
                                        <td>{{ $payment->type }}</td>
                                        <td>{{ $payment->transaction_code ?? 'N/A' }}</td>
                                        <td>₱ {{ number_format($payment->amount, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/bladeScript.js')}}"></script>
@endsection