<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserCapabilities
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth('backpack')->user();

        if ($user && $this->hasCapability($user, $request)) {
            return $next($request);
        }

        // abort(403, 'Unauthorized action.');
        return redirect()->route('dashboard');
    }

    protected function hasCapability($user, $request)
    {
        $capabilities = explode(',', $user->capabilities);
        $routeName = $request->route()->getName();
        
        if ($request->route()->getName() === 'dashboard') {
            return true;
        }

        switch ($routeName) {
            case 'user.index':
            case 'user.create':
            case 'user.store':
            case 'user.show':
            case 'user.edit':
            case 'user.update':
            case 'user.destroy':
            case 'user.search': 
                return in_array('1', $capabilities); // Add New User
            case 'payment.index':
            case 'payment.create':
            case 'payment.store':
            case 'payment.show':
            case 'payment.edit':
            case 'payment.update':
            case 'payment.destroy':
            case 'payment.search': 
                 return in_array('2', $capabilities); // View Payment
            case 'member.subscribe': 
            case 'member.subscribe-add': 
                  return in_array('3', $capabilities); // Accept Payments
            case 'report':
                return in_array('4', $capabilities); // View Reports
            case 'reportMembers':
                return in_array('5', $capabilities); // View Report Members
            case 'member.index':
            case 'member.create':
            case 'member.store':
            case 'member.show':
            case 'member.edit':
            case 'member.update':
            case 'member.destroy':
            case 'member.search': 
                    return in_array('3', $capabilities); // View Members
            case 'reportsPayments':
                return in_array('6', $capabilities); // View Report Payments
            case 'cash':
                return in_array('7', $capabilities); // View Report Cash Flow
            default:
                return false; // Default Route
        }
    }
}
