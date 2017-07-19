<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
        	[
        		'name' => 'edit',
        		'display_name' => 'Edit',
        		'description' => 'Edit'
        	],
        	[
        		'name' => 'delete',
        		'display_name' => 'Delete',
        		'description' => 'Delete'
        	],
        	[
        		'name' => 'view',
        		'display_name' => 'View',
        		'description' => 'View'
        	],
        	[
        		'name' => 'create',
        		'display_name' => 'Create',
        		'description' => 'Create'
        	],
        	[
        		'name' => 'transfer',
        		'display_name' => 'Transfer',
        		'description' => 'Transfer'
        	],
        	[
        		'name' => 'role-list',
        		'display_name' => 'Display Role Listing',
        		'description' => 'See only Listing Of Role'
        	],
        	[
        		'name' => 'role-create',
        		'display_name' => 'Create Role',
        		'description' => 'Create New Role'
        	],
        	[
        		'name' => 'role-edit',
        		'display_name' => 'Edit Role',
        		'description' => 'Edit Role'
        	],
        	[
        		'name' => 'role-delete',
        		'display_name' => 'Delete Role',
        		'description' => 'Delete Role'
        	],

        ];

        foreach ($permission as $key => $value) {
        	Permission::create($value);
        }
    }
}