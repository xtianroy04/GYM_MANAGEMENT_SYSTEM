<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Library\Widget;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
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
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');

        CRUD::field('name');
        CRUD::field('email');
        CRUD::field('contact_number');
        CRUD::field('password');
        CRUD::field('password_confirmation')->type('password');
     
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); 
        CRUD::addColumn([
            'label' => 'Name',
            'name' => 'name',
        ]);
        
        CRUD::addColumn([
            'label' => 'Email',
            'name' => 'email',
        ]);

        CRUD::addColumn([
            'label' => 'Contact Number',
            'name' => 'contact_number',
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation($checkStoredCapabilities = false)
    {
        CRUD::setValidation(UserRequest::class);
        CRUD::setFromDb(); 
        CRUD::addField([
            'label' => 'Capabilities',
            'name' => 'capabilities',
            'type' => 'text',
            'attributes' => [
                'readonly' => 'readonly',
                'style' => 'display: none;', // Initially hidden
            ],
        ]);
        $capabilities = [
            'Add New Users',
            'Accept Payments',
            'View Payments',
            'View Report - Checkin',
            'View Report - Members',
            'View Report - Payments',
            'View Report - Cash Flow',
        ];

        $checkboxesHTML = '';

        foreach ($capabilities as $capability) {
            $checkboxesHTML .= '<div class="form-check form-check-inline d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" name="checkbox[]" id="capability_' . $capability . '" value="' . $capability . '" onclick="updateHiddenField()">
                                    <label class="form-check-label" for="capability_' . $capability . '">' . $capability . '</label>
                                </div>';
        }

        CRUD::addField([
            'label' => 'Capabilities',
            'type' => 'custom_html',
            'name' => 'checkbox',
            'value' => $checkboxesHTML,
            'attributes' => [
                'class' => 'capability'
            ]

        ]);

    
        Widget::add()->type('script')->content(asset('assets/js/user.js'));
    }



        


    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation(true);
    }
}
