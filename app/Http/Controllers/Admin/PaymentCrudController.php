<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PaymentRequest;
use Backpack\CRUD\app\Library\Widget;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PaymentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PaymentCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Payment::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/payment');
        CRUD::setEntityNameStrings('payment', 'payments');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'full_name',
            'label' => 'Name',
            'entity' => 'member',
            'attribute' => 'full_name',
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('member', function ($query) use ($searchTerm) {
                    $query->Where('first_name', 'like', '%' . $searchTerm . '%')
                          ->orWhere('last_name', 'like', '%' . $searchTerm . '%');
                });
            },
        ]);

        CRUD::addColumn([
            'name' => 'amount',
            'label' => 'Amount',
        ]);
        
        CRUD::addColumn([
            'name' => 'type',
            'label' => 'Type',
        ]);

        CRUD::addColumn([
            'name' => 'transaction_code',
            'label' => 'Transaction Code',
            'type' => 'closure',
            'function' => function ($entry) {
                return $entry->transaction_code ?: 'N/A';
            }
        ]);
        

        CRUD::addColumn([
            'name' => 'payment_for',
            'label' => 'Payment For',
        ]);

        // CRUD::addColumn([
        //     'name' => 'annual_fee',
        //     'label' => 'Annual Fee',
        // ]);
        
        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {   
        CRUD::setValidation(PaymentRequest::class);
        CRUD::setFromDb(); // set fields from db columns.
        
        CRUD::addField([
            'name' => 'member_id',
            'label' => 'Member',
            'type' => 'select',
            'entity' => 'member',
            'attribute' => 'full_name', 
        ]);
        
        CRUD::addField([
            'name' => 'type',
            'label' => 'Type',
            'type' => 'enum',
            'options' => ['cash' => 'Cash', 'gcash' => 'Gcash'], 
        ]);

        CRUD::addField([
            'name' => 'transaction_code',
            'label' => 'Transaction Code',
            'type' => 'text',
        ]);

        CRUD::addField([
            'name' => 'payment_for',
            'label' => 'Subscription Plan',
            'type' => 'enum',
            'options' => ['monthly' => 'Monthly', 'Bi-Monthly' => 'Bi-Monthly',  '6 Months' => '6 Months', '1 Year' => '1 Year'], 
        ]);

        Widget::add()->type('script')->content(asset('assets/js/field.js'));
    }
    
    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->crud->addField([   // Created At
            'name' => 'created_at',
            'label' => 'Creation Date',
        ]);
        $this->setupCreateOperation();
    }
}
