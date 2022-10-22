<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = \App\Models\Permission::getAllPermissions();
        foreach($permissions as $permission){
            if(!\App\Models\Permission::where('name', $permission)->count()){
                $obj = new \App\Models\Permission();
                $obj->name = $permission;
                $obj->save();
            }
        }
    }
}
