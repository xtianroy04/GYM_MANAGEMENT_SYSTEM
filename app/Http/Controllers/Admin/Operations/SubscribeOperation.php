<?php

namespace App\Http\Controllers\Admin\Operations;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Membership;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Http\Request; // Import Request class
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

trait SubscribeOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupSubscribeRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{id}/subscribe', [
            'as'        => $routeName.'.subscribe',
            'uses'      => $controller.'@subscribe',
            'operation' => 'subscribe',
        ]);

        Route::post($segment.'/{id}/subscribe', [
            'as'        => $routeName.'.subscribe-add',
            'uses'      => $controller.'@postSubscribeForm',
            'operation' => 'subscribe',
        ]);
    }

    public function postSubscribeForm(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'type' => 'required|string',
            'payment_for' => 'required|string|in:Session,Monthly,Bi-Monthly,6 Months,1 Year,Annual-Fee',
            'transaction_code' => $request->type === 'Cash' ? 'nullable' : 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $entry = new Payment();
            $entry->amount = $request->input('amount');
            $entry->type = $request->input('type');
            $entry->transaction_code = $request->input('transaction_code');
            $entry->payment_for = $request->input('payment_for');
            $entry->member_id = $id; 

            $entry->save();

            return redirect()->back()->with('success', 'Subscription added successfully!');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }



    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupSubscribeDefaults()
    {
        CRUD::allowAccess('subscribe');

        CRUD::operation('subscribe', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            CRUD::addButton('top', 'subscribe', 'view', 'crud::buttons.subscribe');
            CRUD::addButton('line', 'subscribe', 'view', 'crud::buttons.subscribe');

            $this->crud->addButton('line', 'subscribe', 'view', 'crud::buttons.subscribe');
            
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function subscribe()
    {

        CRUD::hasAccessOrFail('subscribe');


        $memberId = request()->route('id');
        $membership = Membership::where('member_id', $memberId)->first();
        $paymentHistory = Payment::where('member_id', $memberId)->orderBy('created_at', 'desc')->get();
        $memberName = Member::find($memberId);


        $data = [
            'crud' => $this->crud,
            'title' => CRUD::getTitle() ?? 'Subscribe ' . $this->crud->entity_name,
            'membership' => $membership,
            'paymentHistory' => $paymentHistory,
            'memberName' => $memberName,
        ];

        // Load the view with data
        return view('crud::operations.subscribe', $data);
    }

}