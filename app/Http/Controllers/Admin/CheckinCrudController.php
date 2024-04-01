<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CheckinRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CheckinCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CheckinCrudController extends CrudController
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
    public function setup()
    {
        CRUD::setHeading('Daily Checkins');
        CRUD::setModel(\App\Models\Checkin::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/checkin');
        CRUD::setEntityNameStrings('checkin', 'checkins');
    }
    
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); 
        $this->crud->removeAllButtonsFromStack('line');
        $this->crud->denyAccess('create');

        CRUD::addColumn([
            'name' => 'member_id',
            'label' => 'code',
        ]);
        CRUD::addColumn([
            'name' => 'full_name',
            'label' => 'Name',
            'type' => 'select',
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
            'name' => 'checkin_time',
            'label' => 'Check-in Time',
        ]);
        
        
        CRUD::removeColumn(['actions']);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    // protected function setupCreateOperation()
    // {
    //     CRUD::setValidation(CheckinRequest::class);
    //     CRUD::setFromDb(); // set fields from db columns.

    //     CRUD::addField([
    //         'name' => 'member_id',
    //         'label' => 'Member',
    //         'type' => 'select',
    //         'entity' => 'member',
    //         'attribute' => 'full_name', 
    //     ]);
    //     CRUD::addField([
    //         'name' => 'checkin_time',
    //         'label' => 'Check-in Date',
    //         'type' => 'datetime',
    //     ]);
    // }

    // protected function setupUpdateOperation()
    // {
    //     $this->setupCreateOperation();
    // }

}