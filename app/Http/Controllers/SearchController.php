<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Checkin;
use App\Models\Membership;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $members = Member::where('code', 'like', '%' . $query . '%')->get();
        $successMessage = ''; 
        
        if ($members->isNotEmpty()) {
            $member = $members->first();
            if ($member->code === $query) {

                $current_subscription = Membership::where('member_id', $member->id)
                                         ->latest()
                                         ->first();
                if ($current_subscription  && $current_subscription->status === 'Active' && $current_subscription->subscription_status === 'Active') {
                    $checkin = new Checkin();
                    $checkin->member_id = $member->id;
                    $checkin->save();
                    
                    $successMessage =  '<tr>
                                          <td><strong>Full Name:</strong></td>
                                          <td>' . $member->first_name . ' ' . $member->last_name . '</td>
                                       </tr>' .
                                       '<tr>
                                          <td><strong>Code:</strong></td>
                                          <td>' . $member->code . '</td>
                                       </tr>' .
                                       '<tr>
                                          <td><strong>Check-in:</strong></td>
                                          <td>' . ($member->checkins->isNotEmpty() ? date('F j, Y g:i A', strtotime($member->checkins->last()->checkin_time)) : 'No Check-in Yet') . '</td>
                                       </tr>' .
                                       '<tr>' .
                                          '<td><strong>Subscription Status:</strong></td>
                                          <td>' . ($current_subscription ? $current_subscription->subscription_status : 'No subscription') . '</td>
                                       </tr>' .
                                       '<tr>
                                       <td><strong>Annual Subscription Status:</strong></td>
                                       <td>' . ($current_subscription ? $current_subscription->status : 'No subscription') . '</td>
                                      </tr>';
                } else if (!$current_subscription || $current_subscription->status === null && $current_subscription->subscription_status === null) {
                    $successMessage = '<tr>
                                          <td><strong>Full Name:</strong></td>
                                          <td>' . $member->first_name . ' ' . $member->last_name . '</td>
                                       </tr>' .
                                       '<tr>
                                          <td><strong>Code:</strong></td>
                                          <td>' . $member->code . '</td>
                                       </tr>' .
                                       '<tr>
                                          <td><strong>Subscription Status:</strong></td>
                                          <td><p>Please Pay your Subscription first!.</p></td>
                                       </tr>' .
                                       '<tr>
                                          <td><strong>Annual Subscription Status:</strong></td>
                                          <td><p>Please Pay your Annual Subscription first!.</p></td>
                                       </tr>';
                } else if (!$current_subscription || $current_subscription->status === null && $current_subscription->subscription_status === 'Active') {
                  $successMessage = '<tr>
                                        <td><strong>Full Name:</strong></td>
                                        <td>' . $member->first_name . ' ' . $member->last_name . '</td>
                                     </tr>' .
                                     '<tr>
                                        <td><strong>Code:</strong></td>
                                        <td>' . $member->code . '</td>
                                     </tr>' .
                                     '<tr>
                                        <td><strong>Subscription Status:</strong></td>
                                        <td><p>Please Pay your Subscription first!.</p></td>
                                     </tr>' .
                                     '<tr>
                                        <td><strong>Annual Subscription Status:</strong></td>
                                        <td><p>Active</p></td>
                                     </tr>';
                } else if (!$current_subscription || $current_subscription->status === 'Active' && $current_subscription->subscription_status === 'Inactive' ) {
                  $successMessage = '<tr>
                                        <td><strong>Full Name:</strong></td>
                                        <td>' . $member->first_name . ' ' . $member->last_name . '</td>
                                     </tr>' .
                                     '<tr>
                                        <td><strong>Code:</strong></td>
                                        <td>' . $member->code . '</td>
                                     </tr>' .
                                     '<tr>
                                        <td><strong>Subscription Status:</strong></td>
                                        <td><p>Please Pay your Subscription first!.</p></td>
                                     </tr>' .
                                     '<tr>
                                        <td><strong>Annual Subscription Status:</strong></td>
                                        <td><p>Active</p></td>
                                     </tr>';
                } else {
                    $successMessage = '<tr>
                                          <td><strong>Full Name:</strong></td>
                                          <td>' . $member->first_name . ' ' . $member->last_name . '</td>
                                       </tr>' .
                                       '<tr>
                                          <td><strong>Code:</strong></td>
                                          <td>' . $member->code . '</td>
                                       </tr>' .
                                       '<tr>
                                          <td><strong>Subscription Status:</strong></td>
                                          <td><p>'. ($current_subscription ? $current_subscription->subscription_status : 'No subscription') . '</p></td>
                                       </tr>' .
                                       '<tr>
                                          <td><strong>Annual Subscription Status:</strong></td>
                                          <td><p>'. ($current_subscription ? $current_subscription->status : 'No subscription') . '</p></td>
                                       </tr>';
                }
            }
        }

        return view('welcome', compact('members', 'successMessage'));
    }
}
