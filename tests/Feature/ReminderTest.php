<?php

namespace Tests\Feature;

use App\Jobs\ReminderJob;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Reminder;
use App\Notifications\ReminderNotification;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ReminderTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $employee_read;
    private $employee_write;
    private $created_count = 3;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->index_route = route('reminders.index');
        $this->create_route = route('reminders.create');
        $this->store_route = route('reminders.store');
        $this->edit_route = route('reminders.edit', ['reminder' => 1]);
        $this->update_route = route('reminders.update', ['reminder' => 1]);
        $this->delete_route = route('reminders.destroy', ['reminder' => 1]);
        $this->sort_route = route('reminders.sort');

        Artisan::call('testlogs:clear');
        $this->admin = $this->createAdminEmployee();
        $this->employee_write = $this->createEmployeeWithPermission(Reminder::PERMISSION_NAME, 'write');
        $this->employee_read = $this->createEmployeeWithPermission(Reminder::PERMISSION_NAME, 'read');
    }

    /** @test */
    public function a_guest_is_redirected_to_login()
    {
        $this->get($this->index_route)->assertRedirect(route('login'));
    }

    /** @test */
    public function user_without_permission_cannot_See_reminders_page()
    {
        $this->actingAs($this->employee_write->user)->get($this->index_route)->assertForbidden();
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_see_reminders_page($auth)
    {
        $auth_user = $auth == 0 ? $this->admin->user : $this->employee_read->user;
        $auth_emp = $auth == 0 ? $this->admin : $this->employee_read;
        $should_return_count = 4;
        $reminders = factory(Reminder::class, 2)->create(['assigned_to_id' => $auth_emp->id, 'assigned_by_id' => $auth_emp->id]);
        $reminders = factory(Reminder::class, 2)->create(['assigned_to_id' => $this->employee_write->id, 'assigned_by_id' => $auth_emp->id]);
        $should_not_return_count = 2;
        $reminders = factory(Reminder::class, 2)->create(['assigned_to_id' => $this->employee_write->id, 'assigned_by_id' => $this->employee_write->id]);
        $response = $this->actingAs($auth_user)->get($this->index_route);

        $response->assertOk();
        $response->assertViewIs('reminders.index');

        $reminders_from_view = $this->getDataFromResponse($response, 'reminders');
        $this->assertNotNull($reminders_from_view);
        $this->assertCount($should_return_count, $reminders_from_view);
        foreach ($reminders_from_view as $reminder) {
            $this->assertContains($auth_emp->id, [$reminder->assigned_to_id, $reminder->assigned_by_id]);
        }
        $this->assertEquals($should_not_return_count + $should_return_count, Reminder::count());
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_search_reminders_by_title($auth)
    {
        $auth_user = $auth == 0 ? $this->admin->user : $this->employee_read->user;
        $auth_emp = $auth == 0 ? $this->admin : $this->employee_read;
        for ($i = 0; $i < 13; $i++) {
            $reminders = factory(Reminder::class, 20)->create(['assigned_by_id' => $auth_emp->id]);

            $rand_rem = $reminders->toArray()[rand(0, 9)];
            $rand_title = $rand_rem['title'];
            $rand_word = Arr::random(explode(' ', $rand_title));
            $url_query = '?filter_by=title&filter_q=' . $rand_word;

            $response = $this->actingAs($auth_user)->get($this->index_route . $url_query);

            $response->assertOk();
            $response->assertViewIs('reminders.index');

            $reminders_from_view = $this->getDataFromResponse($response, 'reminders');
            $this->assertNotNull($reminders);
            $this->assertGreaterThan(0, count($reminders_from_view));

            //assert searched name exists in the result
            foreach ($reminders_from_view as $reminder) {
                $this->assertStringContainsStringIgnoringCase($rand_word, $reminder->title);
            }
        }
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_paginate_reminders($auth)
    {
        $auth_user = $auth == 0 ? $this->admin->user : $this->employee_read->user;
        $auth_emp = $auth == 0 ? $this->admin : $this->employee_read;
        $all_count = 10;
        $per_page = 3;
        $reminders = factory(Reminder::class, $all_count)->create(['assigned_by_id' => $auth_emp->id]);
        $next_page = '';
        $remaining = $all_count;
        $ids = [];
        for ($i = 1; $i <= $all_count; $i += $per_page) {
            $url_query = 'per_page=' . $per_page;
            $url = $this->index_route;
            if ($next_page) {
                $url = $next_page;
                $url_query = '&' . $url_query;
            } else {
                $url_query = '?' . $url_query;
            }
            $url .= $url_query;
            $response = $this->actingAs($auth_user)->get($url);

            $response->assertOk();
            $response->assertViewIs('reminders.index');

            $reminders_from_view = $this->getDataFromResponse($response, 'reminders');

            //make sure that no raw is sent twice when paginating
            $diff = (array_diff($ids, $reminders_from_view->pluck('id')->toArray()));
            $this->assertEquals($diff, $ids);
            $ids = array_merge($ids, $reminders_from_view->pluck('id')->toArray());

            $this->assertNotNull($reminders_from_view);
            $next_page = $reminders_from_view->toArray()['next_page_url'];

            //assert that we got the expected number of raws
            $count_should_be = $remaining >= $per_page ? $per_page : $remaining;
            $remaining -= count($reminders_from_view);
            $this->assertCount($count_should_be, $reminders_from_view);
        }
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_sort_reminders_by_reminders_info($auth)
    {
        $auth_user = $auth == 0 ? $this->admin->user : $this->employee_read->user;
        $auth_emp = $auth == 0 ? $this->admin : $this->employee_read;
        for ($z = 0; $z < 10; $z++) {
            $all_count = 10;
            $reminders = factory(Reminder::class, $all_count)->create(['assigned_by_id' => $auth_emp->id]);

            $param = 'title';
            $url_query = '?order_by=' . $param;

            $response = $this->actingAs($auth_user)->get($this->index_route . $url_query);
            $response->assertOk();
            $response->assertViewIs('reminders.index');

            $reminders_from_view = $this->getDataFromResponse($response, 'reminders');
            $this->assertNotNull($reminders_from_view);
            $this->assertGreaterThan(0, count($reminders_from_view));

            $remindesr = $reminders_from_view->toArray()['data'];
            for ($i = 0; $i < count($remindesr); $i++) {
                if ($i > 0) {
                    $this->greaterThanOrEqual($remindesr[$i - 1][$param], $remindesr[$i][$param]);
                }
            }
        }
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_sort_reminders_by_assigned_to_name($auth)
    {
        $auth_user = $auth == 0 ? $this->admin->user : $this->employee_read->user;
        $auth_emp = $auth == 0 ? $this->admin : $this->employee_read;
        for ($z = 0; $z < 10; $z++) {
            $all_count = 10;
            $reminders = factory(Reminder::class, $all_count / 2)->create(['assigned_by_id' => $auth_emp->id, 'assigned_to_id' => $auth_emp->id]);
            $reminders = factory(Reminder::class, $all_count / 2)->create(['assigned_by_id' => $auth_emp->id, 'assigned_to_id' => $this->employee_write->id]);
            $reminders = factory(Reminder::class, $all_count / 2)->create(['assigned_by_id' => $this->employee_write->id, 'assigned_to_id' => $this->employee_write->id]);

            $param = 'name';
            $order_by_j_c = 'assigned_to';//join column
            $url_query = '?order_by_r=users.' . $param . '&order_by_j_c=' . $order_by_j_c;

            $response = $this->actingAs($auth_user)->get($this->sort_route . $url_query);
            $response->assertOk();
            $response->assertViewIs('reminders.index');

            $reminders_from_view = $this->getDataFromResponse($response, 'reminders');
            $this->assertNotNull($reminders_from_view);
            $this->assertGreaterThan(0, count($reminders_from_view));

            $reminders = $reminders_from_view->toArray()['data'];
            for ($i = 0; $i < count($reminders); $i++) {
                $this->assertContains($auth_emp->id, [$reminders[$i]['assigned_to_id'], $reminders[$i]['assigned_by_id']]);
                if ($i > 0) {
                    $this->greaterThanOrEqual($reminders[$i - 1][$order_by_j_c]['user'][$param], $reminders[$i][$order_by_j_c]['user'][$param]);
                }
            }
        }
    }

    /** @test */
    public function a_guest_cannot_see_add_page()
    {
        $this->get($this->create_route)->assertRedirect(route('login'));
    }

    /** @test */
    public function user_without_permission_cannot_see_add_page()
    {
        $this->actingAs($this->employee_read->user)->get($this->create_route)->assertForbidden();
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_see_add_page($auth)
    {
        $auth_user = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $auth_emp = $auth == 0 ? $this->admin : $this->employee_write;
        $response = $this->actingAs($auth_user)->get($this->create_route);

        $response->assertOk();
        $employees_from_view = $this->getDataFromResponse($response, 'employees');
        $this->assertNotNull($employees_from_view);
        $this->assertEquals($this->created_count, Employee::count());
        $response->assertViewIs('reminders.create');
    }

    /** @test */
    public function a_guest_cannot_add_reminder()
    {
        $this->post($this->store_route, $this->data())->assertRedirect(route('login'));
    }

    /** @test */
    public function user_without_permission_cannot_add_reminder()
    {
        $this->actingAs($this->employee_read->user)->post($this->store_route, $this->data())->assertForbidden();
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_add_reminder($auth)
    {
        $this->withoutExceptionHandling();
        $auth_user = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $auth_emp = $auth == 0 ? $this->admin : $this->employee_write;
        $data = array_merge($this->data(), ['assigned_to_id' => $auth_emp->id]);
        $response = $this->actingAs($auth_user)->post($this->store_route, $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect($this->index_route);
        $this->assertEquals(1, Reminder::count());
        $reminder = Reminder::find(1);
        $this->assertEquals(1, Queue::size());
        $this->assertReminderData($reminder, $data);
        $response->assertSessionHas('success');

        $this->assertJob($auth_user, $reminder);
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_cannot_add_reminder_with_invalid_title($auth)
    {
        $auth_user = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $auth_emp = $auth == 0 ? $this->admin : $this->employee_write;
        $data = array_merge($this->data(), ['assigned_to_id' => $auth_emp->id]);
        $data = array_merge($data, ['title' => '']);
        $response = $this->actingAs($auth_user)->post($this->store_route, $data);

        $response->assertSessionHasErrors('title');
        $this->assertEquals(0, Reminder::count());
        $this->assertOldInput(Arr::except($data, ['title']));
        $this->assertEquals(0, Queue::size());
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_cannot_add_reminder_with_invalid_desc($auth)
    {
        $auth_user = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $auth_emp = $auth == 0 ? $this->admin : $this->employee_write;
        $data = array_merge($this->data(), ['assigned_to_id' => $auth_emp->id]);
        $data = array_merge($data, ['desc' => '']);
        $response = $this->actingAs($auth_user)->post($this->store_route, $data);

        $response->assertSessionHasErrors('desc');
        $this->assertEquals(0, Reminder::count());
        $this->assertOldInput(Arr::except($data, ['desc']));
        $this->assertEquals(0, Queue::size());
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_cannot_add_reminder_with_invalid_assigned_to($auth)
    {
        $auth_user = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $auth_emp = $auth == 0 ? $this->admin : $this->employee_write;
        $data_sets = [];
        $data_sets[] = array_merge($this->data(), ['assigned_to_id' => '']);
        $data_sets[] = array_merge($this->data(), ['assigned_to_id' => 100]);
        foreach ($data_sets as $data_set) {
            $response = $this->actingAs($auth_user)->post($this->store_route, $data_set);

            $response->assertSessionHasErrors('assigned_to_id');
            $this->assertEquals(0, Reminder::count());
            $this->assertOldInput(Arr::except($data_set, ['assigned_to_id']));
            $this->assertEquals(0, Queue::size());
        }
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_cannot_add_reminder_with_invalid_status($auth)
    {
        $auth_user = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $auth_emp = $auth == 0 ? $this->admin : $this->employee_write;
        $data_sets = [];
        $data_sets[] = array_merge($this->data(), ['status' => '']);
        $data_sets[] = array_merge($this->data(), ['status' => 100]);
        foreach ($data_sets as $data_set) {
            $response = $this->actingAs($auth_user)->post($this->store_route, $data_set);

            $response->assertSessionHasErrors('status');
            $this->assertEquals(0, Reminder::count());
            $this->assertOldInput(Arr::except($data_set, ['status']));
            $this->assertEquals(0, Queue::size());
        }
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_cannot_add_reminder_with_invalid_send_at($auth)
    {
        $auth_user = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $auth_emp = $auth == 0 ? $this->admin : $this->employee_write;
        $data_sets = [];
        $data_sets[] = array_merge($this->data(), ['send_at' => 'ahmed']);
        $data_sets[] = array_merge($this->data(), ['send_at' => Carbon::now()->subDays(10)]);
        foreach ($data_sets as $data_set) {
            $response = $this->actingAs($auth_user)->post($this->store_route, $data_set);

            $response->assertSessionHasErrors('send_at');
            $this->assertEquals(0, Reminder::count());
            $this->assertOldInput(Arr::except($data_set, ['send_at']));
            $this->assertEquals(0, Queue::size());
        }
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_cannot_add_reminder_with_invalid_send_by($auth)
    {
        $auth_user = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $auth_emp = $auth == 0 ? $this->admin : $this->employee_write;
        $data_sets = [];
        $data_sets[] = array_merge($this->data(), ['send_by' => '']);
        $data_sets[] = array_merge($this->data(), ['send_by' => 'ahmed']);
        $data_sets[] = array_merge($this->data(), ['send_by' => []]);
        $data_sets[] = array_merge($this->data(), ['send_by' => ['ahmed']]);
        foreach ($data_sets as $data_set) {
            $response = $this->actingAs($auth_user)->post($this->store_route, $data_set);
            $expected_error = 'send_by';
            if (is_array($data_set['send_by']) && $data_set['send_by']) {
                $expected_error = 'send_by.*';
            }
            $response->assertSessionHasErrors($expected_error);
            $this->assertEquals(0, Reminder::count());
            $this->assertOldInput(Arr::except($data_set, ['send_by']));
            $this->assertEquals(0, Queue::size());
        }
    }

    /** @test */
    public function a_guest_cannot_see_edit_page()
    {
        $reminder = factory(Reminder::class)->create();
        $this->get($this->edit_route)->assertRedirect(route('login'));
    }

    /** @test */
    public function user_without_permission_cannot_see_edit_page()
    {
        $reminder = factory(Reminder::class)->create();
        $this->actingAs($this->employee_read->user)->get($this->edit_route)->assertForbidden();
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_see_edit_page($auth)
    {
        $auth_user = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $auth_emp = $auth == 0 ? $this->admin : $this->employee_write;
        $reminder = factory(Reminder::class)->create();
        $response = $this->actingAs($auth_user)->get($this->edit_route);

        $response->assertOk();
        $response->assertViewIs('reminders.edit');

        $reminder_from_view = $this->getDataFromResponse($response, 'reminder');
        $employees_from_view = $this->getDataFromResponse($response, 'employees');

        $this->assertNotNull($reminder_from_view);
        $this->assertEquals($reminder->id, $reminder_from_view->id);
        $this->assertNotNull($employees_from_view);
        $this->assertEquals($this->created_count, Employee::count());
    }

    /** @test */
    public function a_guest_cannot_edit_reminder()
    {
        $reminder = factory(Reminder::class)->create();
        $this->patch($this->update_route, $this->data())->assertRedirect(route('login'));
    }

    /** @test */
    public function user_without_permission_cannot_edit_reminder()
    {
        $reminder = factory(Reminder::class)->create();
        $this->actingAs($this->employee_read->user)->patch($this->update_route, $this->data())->assertForbidden();
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_edit_reminder($auth)
    {
        $auth_user = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $auth_emp = $auth == 0 ? $this->admin : $this->employee_write;
        $reminder = factory(Reminder::class)->create();

        $response = $this->actingAs($auth_user)->patch($this->update_route, $this->updateData());

        $response->assertSessionHasNoErrors();
        $response->assertRedirect($this->index_route);
        $this->assertEquals(1, Reminder::count());

        $this->assertReminderData($reminder->refresh(), $this->updateData());
        $response->assertSessionHas('success');
        $this->assertEquals(1, Queue::size());
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_cannot_edit_reminder_with_invalid_title($auth)
    {
        $auth_user = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $auth_emp = $auth == 0 ? $this->admin : $this->employee_write;
        $reminder = factory(Reminder::class)->create($this->data());
        $data = array_merge($this->updateData(), ['assigned_to_id' => $auth_emp->id]);
        $data = array_merge($data, ['title' => '']);
        $response = $this->actingAs($auth_user)->patch($this->update_route, $data);

        $response->assertSessionHasErrors('title');
        $this->assertEquals(1, Reminder::count());
        $this->assertOldInput(Arr::except($data, ['title']));
        $this->assertReminderData($reminder->refresh(), $this->data());
        $this->assertEquals(0, Queue::size());
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_cannot_edit_reminder_with_invalid_desc($auth)
    {
        $auth_user = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $auth_emp = $auth == 0 ? $this->admin : $this->employee_write;
        $reminder = factory(Reminder::class)->create($this->data());
        $data = array_merge($this->updateData(), ['assigned_to_id' => $auth_emp->id]);
        $data = array_merge($data, ['desc' => '']);
        $response = $this->actingAs($auth_user)->patch($this->update_route, $data);

        $response->assertSessionHasErrors('desc');
        $this->assertEquals(1, Reminder::count());
        $this->assertOldInput(Arr::except($data, ['desc']));
        $this->assertReminderData($reminder->refresh(), $this->data());
        $this->assertEquals(0, Queue::size());
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_cannot_edit_reminder_with_invalid_assigned_to($auth)
    {
        $auth_user = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $auth_emp = $auth == 0 ? $this->admin : $this->employee_write;
        $reminder = factory(Reminder::class)->create($this->data());
        $data_sets = [];
        $data_sets[] = array_merge($this->updateData(), ['assigned_to_id' => '']);
        $data_sets[] = array_merge($this->updateData(), ['assigned_to_id' => 100]);
        foreach ($data_sets as $data_set) {
            $response = $this->actingAs($auth_user)->patch($this->update_route, $data_set);

            $response->assertSessionHasErrors('assigned_to_id');
            $this->assertEquals(1, Reminder::count());
            $this->assertOldInput(Arr::except($data_set, ['assigned_to_id']));
            $this->assertReminderData($reminder->refresh(), $this->data());
            $this->assertEquals(0, Queue::size());
        }
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_cannot_edit_reminder_with_invalid_status($auth)
    {
        $auth_user = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $auth_emp = $auth == 0 ? $this->admin : $this->employee_write;
        $reminder = factory(Reminder::class)->create($this->data());
        $data_sets = [];
        $data_sets[] = array_merge($this->updateData(), ['status' => '']);
        $data_sets[] = array_merge($this->updateData(), ['status' => 100]);
        foreach ($data_sets as $data_set) {
            $response = $this->actingAs($auth_user)->patch($this->update_route, $data_set);

            $response->assertSessionHasErrors('status');
            $this->assertEquals(1, Reminder::count());
            $this->assertOldInput(Arr::except($data_set, ['status']));
            $this->assertReminderData($reminder->refresh(), $this->data());
            $this->assertEquals(0, Queue::size());
        }
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_cannot_edit_reminder_with_invalid_send_at($auth)
    {
        $auth_user = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $auth_emp = $auth == 0 ? $this->admin : $this->employee_write;
        $reminder = factory(Reminder::class)->create($this->data());
        $data_sets = [];
        $data_sets[] = array_merge($this->updateData(), ['send_at' => 'ahmed']);
        $data_sets[] = array_merge($this->updateData(), ['send_at' => Carbon::now()->subDays(10)]);
        foreach ($data_sets as $data_set) {
            $response = $this->actingAs($auth_user)->patch($this->update_route, $data_set);

            $response->assertSessionHasErrors('send_at');
            $this->assertEquals(1, Reminder::count());
            $this->assertOldInput(Arr::except($data_set, ['send_at']));
            $this->assertReminderData($reminder->refresh(), $this->data());
            $this->assertEquals(0, Queue::size());
        }
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_cannot_edit_reminder_with_invalid_send_by($auth)
    {
        $auth_user = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $auth_emp = $auth == 0 ? $this->admin : $this->employee_write;
        $reminder = factory(Reminder::class)->create($this->data());
        $data_sets = [];
        $data_sets[] = array_merge($this->updateData(), ['send_by' => '']);
        $data_sets[] = array_merge($this->updateData(), ['send_by' => 'ahmed']);
        $data_sets[] = array_merge($this->updateData(), ['send_by' => []]);
        $data_sets[] = array_merge($this->updateData(), ['send_by' => ['ahmed']]);
        foreach ($data_sets as $data_set) {
            $response = $this->actingAs($auth_user)->patch($this->update_route, $data_set);
            $expected_error = 'send_by';
            if (is_array($data_set['send_by']) && $data_set['send_by']) {
                $expected_error = 'send_by.*';
            }
            $response->assertSessionHasErrors($expected_error);
            $this->assertEquals(1, Reminder::count());
            $this->assertOldInput(Arr::except($data_set, ['send_by']));
            $this->assertReminderData($reminder->refresh(), $this->data());
            $this->assertEquals(0, Queue::size());
        }
    }

    /** @test */
    public function a_guest_cannot_delete_reminder()
    {
        $reminder = factory(Reminder::class)->create();
        $this->delete($this->delete_route)->assertRedirect(route('login'));
    }

    /** @test */
    public function user_without_permission_delete_reminder()
    {
        $reminder = factory(Reminder::class)->create();
        $this->actingAs($this->employee_read->user)->delete($this->delete_route)->assertForbidden();
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_delete_reminder($auth)
    {
        $auth_user = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $auth_emp = $auth == 0 ? $this->admin : $this->employee_write;
        //add reminder
        $data = array_merge($this->data(), ['assigned_to_id' => $auth_emp->id]);
        $response = $this->actingAs($auth_user)->post($this->store_route, $data);
        //delete reminder
        $response = $this->actingAs($auth_user)->delete($this->delete_route);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect($this->index_route);
        $this->assertEquals(0, Reminder::count());
        $this->assertEquals(0, DB::table('jobs')->count());
        $response->assertSessionHas('success');
    }




    private function data()
    {
        $data = [
            'title' => 'Reminder title',
            'desc' => 'Reminder desc',
            'assigned_to_id' => 1,
            'status' => 0,
            'send_at' => Carbon::now()->endOfWeek(),
            'send_by' => ['db', 'mail'],
        ];
        return $data;
    }

    private function updateData()
    {
        $data = [
            'title' => 'Reminder title updated',
            'desc' => 'Reminder desc updated',
            'assigned_to_id' => 2,
            'status' => 1,
            'send_at' => Carbon::now()->endOfMonth(),
            'send_by' => ['mail'],
        ];
        return $data;
    }

    private function assertReminderData($reminder, $data)
    {
        foreach ($data as $key => $value) {
            $this->assertEquals($value, $reminder->{$key});
        }
    }

    private function assertJob($auth_user, $reminder){
        $job = (new ReminderJob($reminder));
        ReminderJob::dispatchNow($reminder);
        if(in_array('db', $reminder->send_by)){
            $this->assertCount(1, $auth_user->unReadNotifications);
            $this->assertEquals(ReminderNotification::class, $auth_user->unReadNotifications()->first()->type);
        }
    }
}
