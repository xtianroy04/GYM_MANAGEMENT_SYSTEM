<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MembershipRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MembershipCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MembershipCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setupShowOperation()
    {
        // using the array syntax
        CRUD::addColumn([
            'name' => 'full_name',
            'label' => 'Name',
            'type' => 'select',
            'entity' => 'member',
            'attribute' => 'full_name',
        ]);
        
        CRUD::addColumn([
            'name' => 'date_started',
            'label' => 'Date Started',
        ]);

        CRUD::addColumn([
            'name' => 'date_end',
            'label' => 'Date End',
        ]);

        CRUD::addColumn([
            'name' => 'status',
            'label' => 'Status',
        ]);

    }

    public function setup()
    {
        CRUD::setModel(\App\Models\Membership::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/membership');
        CRUD::setEntityNameStrings('membership', 'memberships');
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
            'name' => 'date_started',
            'label' => 'Date Started',
        ]);

        CRUD::addColumn([
            'name' => 'date_end',
            'label' => 'Date End',
        ]);

        CRUD::addColumn([
            'name' => 'annual_date_started',
            'label' => 'Annual Date Started',
        ]);

        CRUD::addColumn([
            'name' => 'annual_date_end',
            'label' => 'Annual Date End',
        ]);

        CRUD::addColumn([
            'name' => 'status',
            'label' => 'Status',
        ]);

        CRUD::addColumn([
            'name' => 'subscription_status',
            'label' => 'Subscription Status',
        ]);
        

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
        CRUD::setValidation(MembershipRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        CRUD::addField([
            'name' => 'member_id',
            'label' => 'Member',
            'type' => 'select',
            'entity' => 'member',
            'attribute' => 'full_name', 
        ]);

          CRUD::addField([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'enum',
            'options' => ['Active' => 'Active', 'Expired' => 'Expired'],
            'validation' => [
                'required',
            ],
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
