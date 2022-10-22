<?php

use Illuminate\Database\Seeder;

class JobTitlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobs = [
            ['title' => 'المدير العام', 'can_be_assigned' => 0],
            ['title' => 'نائب المدير العام', 'can_be_assigned' => 1],
            ['title' => 'سكرتير تنفيذي', 'can_be_assigned' => 1],
            ['title' => 'المدير المسئول', 'can_be_assigned' => 1],
            ['title' => 'محامي', 'can_be_assigned' => 1],
            ['title' => 'موظف علاقات عامة', 'can_be_assigned' => 1],
            ['title' => 'مدير', 'can_be_assigned' => 1],
            ['title' => 'نائب مدير', 'can_be_assigned' => 1],
            ['title' => 'منظم برامج سياحية', 'can_be_assigned' => 1],
            ['title' => 'محاسب', 'can_be_assigned' => 1],
            ['title' => 'مرافق مجموعات سياحية', 'can_be_assigned' => 1],
            ['title' => 'سائق', 'can_be_assigned' => 1],
            ['title' => 'أمين خزينه', 'can_be_assigned' => 1],
            ['title' => 'موظف', 'can_be_assigned' => 1],
            ['title' => 'مندوب', 'can_be_assigned' => 1],
            ['title' => 'موظف نقل', 'can_be_assigned' => 1],
            ['title' => 'Supplier-Guide', 'can_be_assigned' => 0],
        ];
        foreach ($jobs as $job) {
            if(!\App\Models\JobTitle::where('title', $job['title'])->count()){
                $obj = new \App\Models\JobTitle();
                $obj->title = $job['title'];
                $obj->can_be_assigned = $job['can_be_assigned'];
                $obj->save();
            }
        }
    }
}
