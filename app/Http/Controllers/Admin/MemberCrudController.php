<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MemberRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class MemberCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \App\Http\Controllers\Admin\Operations\SubscribeOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Member::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/member');
        CRUD::setEntityNameStrings('member', 'members');
    }

    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'code',
            'label' => 'QR Code',
            'type' => 'qrcode',
        ]);
        
        CRUD::addColumn('full_name');

        
        CRUD::addColumn([
            'name' => 'status',
            'label' => 'Annual',
            'type' => 'select',
            'entity' => 'membership',
            'attribute' => 'status',
        ]); 
        
        CRUD::addColumn([
            'name' => 'subscription_status',
            'label' => 'Subscription Status',
            'type' => 'select',
            'entity' => 'membership',
            'attribute' => 'subscription_status',
        ]);
        
        CRUD::addColumn('email');
        CRUD::addColumn('contact_number');
        
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(MemberRequest::class);
        CRUD::field('image')
            ->type('upload')
            ->withFiles([
                'disk' => 'public_assets_images', 
                'path' => 'uploads',
        ]);
                
        
        CRUD::addField([
            'name' => 'first_name',
            'label' => 'First Name',
            'type' => 'text',
            'validation' => [
                'required',
            ],
        ]);
        
        CRUD::addField([
            'name' => 'last_name',
            'label' => 'Last Name',
            'type' => 'text',
            'validation' => [
                'required',
            ],
        ]);

        CRUD::addField([
            'name' => 'email',
            'label' => 'Email',
            'type' => 'email',
            'validation' => [
                'required',
            ],
        ]);

        CRUD::addField([
            'name' => 'contact_number',
            'label' => 'Contact Number',
            'type' => 'text',
            'attributes' => [
                'placeholder' => 'Enter 11-digit mobile number',
                'maxlength' => 11, 
            ],
            'validation' => [
                'required',
            ],
        ]);
        

        // CRUD::addField([
        //     'name' => 'birthdate',
        //     'label' => 'Birthdate',
        //     'type' => 'date',
        //     'validation' => [
        //         'required',
        //     ],
        // ]);

        // CRUD::addField([
        //     'name' => 'gender',
        //     'label' => 'Gender',
        //     'type' => 'enum',
        //     'options' => ['Male' => 'Male', 'Female' => 'Female'],
        //     'validation' => [
        //         'required',
        //     ],
        // ]);
        
        // CRUD::addField([
        //     'name' => 'status',
        //     'label' => 'Status',
        //     'type' => 'enum',
        //     'options' => ['Active' => 'Active', 'Expired' => 'Expired', 'Cancelled' => 'Cancelled'],
        //     'validation' => [
        //         'required',
        //     ],
        // ]);

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

}
