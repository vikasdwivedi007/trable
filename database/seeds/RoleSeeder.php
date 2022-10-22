<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['admin'];
        foreach($roles as $role){
            if(!\App\Models\Role::where('name', $role)->count()){
                $obj = new \App\Models\Role();
                $obj->name = $role;
                $obj->save();
            }
        }
    }
}
