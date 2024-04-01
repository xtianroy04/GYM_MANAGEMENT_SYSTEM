<?php

namespace App\Http\Controllers;
use PDF;
use Carbon\Carbon;
use App\Models\Member;
use App\Models\Checkin;
use App\Models\Payment;
use App\Models\Membership;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Admin\Operations\SubscribeOperation;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        $payments = Payment::selectRaw('MONTH(created_at) as month, SUM(amount) as total_amount')
                        ->whereYear('created_at', Carbon::now()->year)
                        ->groupBy('month')
                        ->get();

        $labels = $payments->map(function ($payment) {
            return Carbon::create(null, $payment->month)->format('F');
        })->toArray();

        $paymentData = $payments->pluck('total_amount')->toArray();

        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();

        $progressWidgets = [];
        $memberCount = Member::count();
        $expiredMembershipCount = Membership::where('status', 'Cancelled')
                                ->orWhere('subscription_status', 'Expired')
                                ->distinct('member_id')
                                ->count();

        $monthlyActiveCount = Checkin::whereBetween('checkin_time', [$currentMonthStart, $currentMonthEnd])
                            ->distinct('member_id')
                            ->count();

        Widget::add()
            ->to('before_content')
            ->type('div')
            ->class('row justify-content-center')
            ->content([
    
        Widget::make()
            ->type('progress')
            ->class('card mb-3')
            ->statusBorder('start') 
            ->accentColor('success') 
            ->ribbon(['top', 'la-users'])
            ->progressClass('progress-bar')
            ->value($memberCount)
            ->description('Gym Members'),

        Widget::make()
            ->type('progress')
            ->class('card mb-3')
            ->statusBorder('start')
            ->accentColor('warning') 
            ->ribbon(['top', 'la-user-check'])
            ->progressClass('progress-bar')
            ->value($monthlyActiveCount)
            ->description('Montly Active Members'),

        Widget::make()
            ->type('progress')
            ->class('card mb-3')
            ->statusBorder('start') 
            ->accentColor('danger') 
            ->ribbon(['top', 'la-exclamation-triangle']) 
            ->progressClass('progress-bar')
            ->value($expiredMembershipCount)
            ->description('Expired Membership'),
    ]);

        Widget::add()
            ->type('script')
            ->stack('after_scripts')
            ->content('https://code.jquery.com/ui/1.12.0/jquery-ui.min.js');
        Widget::add()
            ->type('style')
            ->stack('after_styles')
            ->content('https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.58/dist/themes/light.css');


        $data = [
            'labels'          => $labels,
            'paymentData'     => $paymentData,
            'progressWidgets' => $progressWidgets,
        ];

        return view('vendor/backpack/ui/dashboard', $data);
    }


    public function report(){
            $selectedPeriod = 'custom';
            $selectedStartMonth = '';
            $selectedEndMonth = '';
            $selectedYear = '';

            if(request()->has('period')) {
                $selectedPeriod = request('period');
                switch ($selectedPeriod) {
                    case 'week':
                        $startOfWeek = Carbon::now()->startOfWeek();
                        $endOfWeek = Carbon::now()->endOfWeek();
                        $selectedStartMonth = $startOfWeek->format('Y-m-d');
                        $selectedEndMonth = $endOfWeek->format('Y-m-d');
                        break;
                    case 'month':
                        $startOfMonth = Carbon::now()->startOfMonth();
                        $endOfMonth = Carbon::now()->endOfMonth();
                        $selectedStartMonth = $startOfMonth->format('Y-m-d');
                        $selectedEndMonth = $endOfMonth->format('Y-m-d');
                        break;
                    case 'quarter':
                        $currentQuarter = Carbon::now()->quarter;
                        $startOfQuarter = Carbon::now()->startOfQuarter();
                        $endOfQuarter = Carbon::now()->endOfQuarter();
                        $selectedStartMonth = $startOfQuarter->format('Y-m-d');
                        $selectedEndMonth = $endOfQuarter->format('Y-m-d');
                        break;
                    case 'year':
                        $selectedYear = request('year', date('Y'));
                        break;
                    default:
                        $selectedStartMonth = request('start_month');
                        $selectedEndMonth = request('end_month');
                        $selectedYear = request('year');
                        break;
                }
            }

            $checkin = Checkin::query();

            if ($selectedStartMonth && $selectedEndMonth) {
                $checkin->whereDate('checkin_time', '>=', $selectedStartMonth)
                            ->whereDate('checkin_time', '<=', $selectedEndMonth);
            } elseif ($selectedYear) {
                $checkin->whereYear('checkin_time', $selectedYear);
            }

            $reports = $checkin->orderBy('checkin_time', 'desc')->paginate(10);
        return view('vendor/backpack/ui/report', compact('reports', 'selectedPeriod', 'selectedStartMonth', 'selectedEndMonth', 'selectedYear'));
    }

    public function reportMembers(){
            $selectedPeriod = 'custom';
            $selectedStartMonth = '';
            $selectedEndMonth = '';
            $selectedYear = '';
        
            if(request()->has('period')) {
                $selectedPeriod = request('period');
                switch ($selectedPeriod) {
                    case 'week':
                        $startOfWeek = Carbon::now()->startOfWeek();
                        $endOfWeek = Carbon::now()->endOfWeek();
                        $selectedStartMonth = $startOfWeek->format('Y-m-d');
                        $selectedEndMonth = $endOfWeek->format('Y-m-d');
                        break;
                    case 'month':
                        $startOfMonth = Carbon::now()->startOfMonth();
                        $endOfMonth = Carbon::now()->endOfMonth();
                        $selectedStartMonth = $startOfMonth->format('Y-m-d');
                        $selectedEndMonth = $endOfMonth->format('Y-m-d');
                        break;
                    case 'quarter':
                        $currentQuarter = Carbon::now()->quarter;
                        $startOfQuarter = Carbon::now()->startOfQuarter();
                        $endOfQuarter = Carbon::now()->endOfQuarter();
                        $selectedStartMonth = $startOfQuarter->format('Y-m-d');
                        $selectedEndMonth = $endOfQuarter->format('Y-m-d');
                        break;
                    case 'year':
                        $selectedYear = request('year', date('Y'));
                        break;
                    default:
                        $selectedStartMonth = request('start_month');
                        $selectedEndMonth = request('end_month');
                        $selectedYear = request('year');
                        break;
                }
            }
        
            $members = Member::query();
        
            if ($selectedStartMonth && $selectedEndMonth) {
                $members->whereDate('created_at', '>=', $selectedStartMonth)
                        ->whereDate('created_at', '<=', $selectedEndMonth);
            } elseif ($selectedYear) {
                $members->whereYear('created_at', $selectedYear);
            }
        
            $reports = $members->orderBy('created_at', 'desc')->paginate(10);
    
        return view('vendor/backpack/ui/reportMembers', compact('reports', 'selectedPeriod', 'selectedStartMonth', 'selectedEndMonth', 'selectedYear'));
    }

    public function reportsPayment(){
            $selectedPeriod = 'custom';
            $selectedStartMonth = '';
            $selectedEndMonth = '';
            $selectedYear = '';

            if(request()->has('period')) {
                $selectedPeriod = request('period');
                switch ($selectedPeriod) {
                    case 'week':
                        $startOfWeek = Carbon::now()->startOfWeek();
                        $endOfWeek = Carbon::now()->endOfWeek();
                        $selectedStartMonth = $startOfWeek->format('Y-m-d');
                        $selectedEndMonth = $endOfWeek->format('Y-m-d');
                        break;
                    case 'month':
                        $startOfMonth = Carbon::now()->startOfMonth();
                        $endOfMonth = Carbon::now()->endOfMonth();
                        $selectedStartMonth = $startOfMonth->format('Y-m-d');
                        $selectedEndMonth = $endOfMonth->format('Y-m-d');
                        break;
                    case 'quarter':
                        $currentQuarter = Carbon::now()->quarter;
                        $startOfQuarter = Carbon::now()->startOfQuarter();
                        $endOfQuarter = Carbon::now()->endOfQuarter();
                        $selectedStartMonth = $startOfQuarter->format('Y-m-d');
                        $selectedEndMonth = $endOfQuarter->format('Y-m-d');
                        break;
                    case 'year':
                        $selectedYear = request('year', date('Y'));
                        break;
                    default:
                        $selectedStartMonth = request('start_month');
                        $selectedEndMonth = request('end_month');
                        $selectedYear = request('year');
                        break;
                }
            }

            $paymentsQuery = Payment::query();

            if ($selectedStartMonth && $selectedEndMonth) {
                $paymentsQuery->whereDate('created_at', '>=', $selectedStartMonth)
                            ->whereDate('created_at', '<=', $selectedEndMonth);
            } elseif ($selectedYear) {
                $paymentsQuery->whereYear('created_at', $selectedYear);
            }

            $payments = $paymentsQuery->orderBy('created_at', 'desc')->paginate(10);
        return view('vendor/backpack/ui/reportPayments', compact('payments', 'selectedPeriod', 'selectedStartMonth', 'selectedEndMonth', 'selectedYear'));
    }

    public function cash(){
        $selectedPeriod = 'custom';
        $selectedStartMonth = '';
        $selectedEndMonth = '';
        $selectedYear = '';

        if(request()->has('period')) {
            $selectedPeriod = request('period');
            switch ($selectedPeriod) {
                case 'week':
                    $startOfWeek = Carbon::now()->startOfWeek();
                    $endOfWeek = Carbon::now()->endOfWeek();
                    $selectedStartMonth = $startOfWeek->format('Y-m-d');
                    $selectedEndMonth = $endOfWeek->format('Y-m-d');
                    break;
                case 'month':
                    $startOfMonth = Carbon::now()->startOfMonth();
                    $endOfMonth = Carbon::now()->endOfMonth();
                    $selectedStartMonth = $startOfMonth->format('Y-m-d');
                    $selectedEndMonth = $endOfMonth->format('Y-m-d');
                    break;
                case 'quarter':
                    $currentQuarter = Carbon::now()->quarter;
                    $startOfQuarter = Carbon::now()->startOfQuarter();
                    $endOfQuarter = Carbon::now()->endOfQuarter();
                    $selectedStartMonth = $startOfQuarter->format('Y-m-d');
                    $selectedEndMonth = $endOfQuarter->format('Y-m-d');
                    break;
                case 'year':
                    $selectedYear = request('year', date('Y'));
                    break;
                default:
                    $selectedStartMonth = request('start_month');
                    $selectedEndMonth = request('end_month');
                    $selectedYear = request('year');
                    break;
            }
        }

        $paymentsQuery = Payment::query();

        if ($selectedStartMonth && $selectedEndMonth) {
            $paymentsQuery->whereDate('created_at', '>=', $selectedStartMonth)
                        ->whereDate('created_at', '<=', $selectedEndMonth);
        } elseif ($selectedYear) {
            $paymentsQuery->whereYear('created_at', $selectedYear);
        }

        $selectedsubscription = request('period');
        if ($selectedsubscription == 'Session' && $selectedStartMonth && $selectedEndMonth) {
            $paymentsQuery->where('payment_for', 'Session')
                         ->whereBetween('created_at', [$selectedStartMonth, $selectedEndMonth]);
        } elseif ($selectedsubscription && in_array($selectedsubscription, ['Session'])) {
            $paymentsQuery->whereDate('payment_for', $selectedsubscription);
        }

        $selectedPaymentType = request('period');
        if ($selectedPaymentType && in_array($selectedPaymentType, ['Cash', 'GCash']) && $selectedStartMonth && $selectedEndMonth) {
            $paymentsQuery->where('type', $selectedPaymentType)
                          ->whereBetween('created_at', [$selectedStartMonth, $selectedEndMonth]);
        } elseif ($selectedPaymentType && in_array($selectedPaymentType, ['Cash', 'GCash'])) {
            $paymentsQuery->whereDate('type', $selectedPaymentType);
        }
        
        $payments = $paymentsQuery->paginate(10);
        $totalAmount = $payments->sum('amount');

            
        return view('vendor/backpack/ui/cashFlow', compact('payments', 'totalAmount', 'selectedPeriod', 'selectedStartMonth', 'selectedEndMonth', 'selectedYear'));
    }

}