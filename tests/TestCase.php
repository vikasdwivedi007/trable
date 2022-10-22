<?php

namespace Tests;

use App\Models\Employee;
use App\Models\JobTitle;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function getDataFromResponse($response, $key)
    {
        $content = $response->getOriginalContent();
        $content = $content->getData();
        if (isset($content[$key])) {
            return $content[$key];
        } else {
            return null;
        }
    }

    protected function getDataFromDatatableResponse($response)
    {
        return (new Collection(json_decode($response->getContent())->data));
    }

    protected function logger(...$logs)
    {
        foreach ($logs as $log) {
            Log::channel('tests')->info($log);
        }
    }

    protected function createAdminEmployee()
    {
        $admin_role = factory(Role::class)->create();
        $admin_job = factory(JobTitle::class)->create();
        $admin_emp = factory(Employee::class)->create(['job_id' => $admin_job->id]);
        $admin_emp->user->roles()->attach($admin_role->id);
        return $admin_emp;
    }

    protected function createEmployeeWithPermission($permission, $type)
    {
        $permission = factory(Permission::class)->create(['name' => $permission]);
        $job = factory(JobTitle::class)->create();
        $emp = factory(Employee::class)->create(['job_id' => $job->id]);
        $emp->user->addPermission($permission->name, $type);
        return $emp;
    }

    protected function consoleLog($log)
    {
        fwrite(STDERR, print_r($log, TRUE));
    }

    public function authUserProvider()
    {
        return [
            [0],
            [1]
        ];
    }

    protected function assertOldInput($data)
    {
        foreach ($data as $key => $value) {
            $this->assertTrue(session()->hasOldInput($key));
        }
    }
}
