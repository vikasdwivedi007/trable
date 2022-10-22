<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\TrainTicket;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class TrainTicketTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $employee_read;
    private $employee_write;
    private $created_count = 0;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->index_route = route('train-tickets.index');
        $this->create_route = route('train-tickets.create');
        $this->store_route = route('train-tickets.store');
        $this->edit_route = route('train-tickets.edit', ['train_ticket'=>1]);
        $this->update_route = route('train-tickets.update', ['train_ticket'=>1]);

        Artisan::call('testlogs:clear');
        $this->admin = $this->createAdminEmployee();
        $this->employee_write = $this->createEmployeeWithPermission(TrainTicket::PERMISSION_NAME, 'write');
        $this->employee_read = $this->createEmployeeWithPermission(TrainTicket::PERMISSION_NAME, 'read');
    }

    /** @test */
    public function a_guest_is_redirected_to_login()
    {
        $this->get($this->index_route)->assertRedirect(route('login'));
    }

    /** @test */
    public function user_without_permission_is_forbidden()
    {
        $this->actingAs($this->employee_write->user)->get($this->index_route)->assertForbidden();
    }

    /**
     *
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_see_train_tickets_page($auth)
    {
        $this->withoutExceptionHandling();
        $auth = $auth == 0 ? $this->admin->user : $this->employee_read->user;
        $count = 3;
        $train_tickets = factory(TrainTicket::class, $count)->create();
        $response = $this->actingAs($auth)->get($this->index_route);

        $response->assertOk();
        $response->assertViewIs('train-tickets.index');

        $train_tickets_from_view = $this->getDataFromResponse($response, 'train_tickets');
        $this->assertNotNull($train_tickets_from_view);
        $this->assertCount($count, $train_tickets_from_view);
        $this->assertCount($count, TrainTicket::all());
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_paginate_train_tickets($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_read->user;
        $all_count = 10;
        $per_page = 3;
        $train_tickets = factory(TrainTicket::class, $all_count)->create();

        $next_page = '';
        $remaining = $all_count;
        $ids = [];
        for ($i=1;$i<=$all_count;$i+=$per_page){
            $url_query = 'per_page='.$per_page;
            $url = $this->index_route;
            if($next_page){
                $url = $next_page;
                $url_query = '&'.$url_query;
            }else{
                $url_query = '?'.$url_query;
            }
            $url .= $url_query;
            $response = $this->actingAs($auth)->get($url);

            $response->assertOk();
            $response->assertViewIs('train-tickets.index');

            $train_tickets_from_view = $this->getDataFromResponse($response, 'train_tickets');

            //make sure that no raw is sent twice when paginating
            $diff = (array_diff($ids, $train_tickets_from_view->pluck('id')->toArray()));
            $this->assertEquals($diff, $ids);
            $ids = array_merge($ids, $train_tickets_from_view->pluck('id')->toArray());

            $this->assertNotNull($train_tickets_from_view);
            $next_page = $train_tickets_from_view->toArray()['next_page_url'];

            //assert that we got the expected number of raws
            $count_should_be = $remaining >= $per_page ? $per_page : $remaining;
            $remaining -= count($train_tickets_from_view);
            $this->assertCount($count_should_be, $train_tickets_from_view);
        }
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_search_train_ticket_by_number($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_read->user;
        $loops = 13;
        for ($i=0;$i<$loops;$i++){
            $train_tickets = factory(TrainTicket::class, 20)->create();

            $rand_rest = $train_tickets->toArray()[rand(0,9)];
            $rand_name = $rand_rest['number'];
            $rand_word = $rand_name;
            $url_query = '?filter_by=number&filter_q='.$rand_word;

            $response = $this->actingAs($auth)->get($this->index_route.$url_query);

            $response->assertOk();
            $response->assertViewIs('train-tickets.index');

            $train_tickets_from_view = $this->getDataFromResponse($response, 'train_tickets');
            $this->assertNotNull($train_tickets_from_view);
            $this->assertGreaterThan(0, count($train_tickets_from_view));

            //assert searched name exists in the result
            foreach($train_tickets_from_view as $train_ticket){
                $this->assertStringContainsStringIgnoringCase($rand_word, $train_ticket->number);
            }
        }
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_sort_train_tickets($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_read->user;
        for ($z=0;$z<10;$z++){
            $all_count = 10;
            $train_tickets = factory(TrainTicket::class, $all_count)->create();
            $param = 'number';
            $order = 'ASC';
            $url_query = '?order_by='.$param.'&order='.$order;

            $response = $this->actingAs($auth)->get($this->index_route.$url_query);
            $response->assertOk();
            $response->assertViewIs('train-tickets.index');

            $train_tickets_from_view = $this->getDataFromResponse($response, 'train_tickets');
            $this->assertNotNull($train_tickets_from_view);
            $this->assertGreaterThan(0, count($train_tickets_from_view));

            $train_tickets = $train_tickets_from_view->toArray()['data'];
            for ($i=0;$i<count($train_tickets);$i++){
                if($i > 0){
                    if($order == 'ASC'){
                        $this->lessThanOrEqual($train_tickets[$i-1][$param], $train_tickets[$i][$param]);
                    }else{
                        $this->greaterThanOrEqual($train_tickets[$i-1][$param], $train_tickets[$i][$param]);
                    }
                }
            }
        }
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_sort_train_tickets_by_city($auth)
    {
        $this->withoutExceptionHandling();
        $auth = $auth == 0 ? $this->admin->user : $this->employee_read->user;
        for ($z = 0; $z < 10; $z++) {
            $all_count = 10;
            $train_ticket = factory(TrainTicket::class, $all_count)->create();
            $param = 'name';
            $url_query = '?order_by_r=from_cities.' . $param;

            $response = $this->actingAs($auth)->get(route('train-tickets.sort') . $url_query);
            $response->assertOk();
            $response->assertViewIs('train-tickets.index');

            $train_tickets_from_view = $this->getDataFromResponse($response, 'train_tickets');
            $this->assertNotNull($train_tickets_from_view);
            $this->assertGreaterThan(0, count($train_tickets_from_view));

            $emps = $train_tickets_from_view->toArray()['data'];
            for ($i = 0; $i < count($emps); $i++) {
                if ($i > 0) {
                    $this->greaterThanOrEqual($emps[$i - 1]['from_city'][$param], $emps[$i]['from_city'][$param]);
                }
            }
        }
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_delete_train_ticket($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $data = $this->data();
        $response = $this->actingAs($auth)->post($this->store_route, $data);
        $train_ticket = TrainTicket::first();

        $response = $this->actingAs($auth)->delete($train_ticket->deletePath());
        $response->assertSessionHasNoErrors();
        $response->assertRedirect($this->index_route);
        $this->assertNull(TrainTicket::find($train_ticket->id));
        $response->assertSessionHas('success');
    }

    /** @test */
    public function a_guest_cannot_delete_train_ticket()
    {
        $train_ticket = factory(TrainTicket::class)->create();
        $this->delete($train_ticket->deletePath())->assertRedirect(route('login'));
        $this->assertNotNull(TrainTicket::find($train_ticket->id));
    }

    /** @test */
    public function user_without_permission_cannot_delete_train_ticket()
    {
        $train_ticket = factory(TrainTicket::class)->create();
        $this->actingAs($this->employee_read->user)->delete($train_ticket->deletePath())->assertForbidden();
        $this->assertNotNull(TrainTicket::find($train_ticket->id));
    }

    /** @test */
    public function a_guest_cannot_see_add_train_ticket_page()
    {
        $this->get($this->create_route)->assertRedirect(route('login'));
    }

    /** @test */
    public function user_without_permission_cannot_see_add_train_ticket_page()
    {
        $this->actingAs($this->employee_read->user)->get($this->create_route)->assertForbidden();
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_see_add_train_ticket_page($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $response = $this->actingAs($auth)->get($this->create_route);
        $response->assertSessionHasNoErrors();
        $response->assertViewIs('train-tickets.create');
        $cities = $this->getDataFromResponse($response, 'cities');
        $this->assertNotNull($cities);
    }

    /** @test */
    public function a_guest_cannot_add_train_ticket()
    {
        $this->post($this->store_route)->assertRedirect(route('login'));
    }

    /** @test */
    public function user_without_permission_cannot_add_train_ticket()
    {
        $this->actingAs($this->employee_read->user)->post($this->store_route)->assertForbidden();
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_add_train_ticket($auth)
    {
        $this->withoutExceptionHandling();
        $auth = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $data = $this->data();
        $response = $this->actingAs($auth)->post($this->store_route, $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect($this->index_route);
        $response->assertSessionHas('success');
        $this->assertEquals($this->created_count+1, TrainTicket::count());
        $train_ticket = TrainTicket::first();
        $this->assertData($train_ticket, $data);
    }

    /** @test */
    public function a_guest_cannot_see_edit_train_ticket_page()
    {
        $train_ticket = factory(TrainTicket::class)->create();
        $this->get($train_ticket->editPath())->assertRedirect(route('login'));
    }

    /** @test */
    public function user_without_permission_cannot_see_edit_train_ticket_page()
    {
        $train_ticket = factory(TrainTicket::class)->create();
        $this->actingAs($this->employee_read->user)->get($train_ticket->editPath())->assertForbidden();
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_see_edit_train_ticket_page($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $train_ticket = factory(TrainTicket::class)->create();
        $response = $this->actingAs($auth)->get($train_ticket->editPath());
        $response->assertSessionHasNoErrors();
        $response->assertViewIs('train-tickets.edit');
        $train_ticket_from_view = $this->getDataFromResponse($response, 'train_ticket');
        $cities = $this->getDataFromResponse($response, 'cities');
        $this->assertNotNull($cities);
        $this->assertNotNull($train_ticket_from_view);
        $this->assertEquals($train_ticket->id, $train_ticket_from_view->id);
    }

    /** @test */
    public function a_guest_cannot_edit_train_ticket()
    {
        $train_ticket = factory(TrainTicket::class)->create();
        $this->patch($this->update_route)->assertRedirect(route('login'));
    }

    /** @test */
    public function user_without_permission_cannot_edit_train_ticket()
    {
        $train_ticket = factory(TrainTicket::class)->create();
        $this->actingAs($this->employee_read->user)->patch($this->update_route)->assertForbidden();
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_edit_train_ticket($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $data = $this->data();
        $response = $this->actingAs($auth)->post($this->store_route, $data);
        $train_ticket = TrainTicket::first();

        $data = $this->update_data();
        $response = $this->actingAs($auth)->patch($this->update_route, $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect($this->index_route);
        $response->assertSessionHas('success');
        $this->assertCount($this->created_count+1, TrainTicket::all());

        $train_ticket->refresh();
        $this->assertData($train_ticket, $data);
    }




    private function data()
    {
        $data = factory(TrainTicket::class)->make()->toArray();
        $data['depart_date'] = $data['depart_at']->format('d-m-Y');
        $data['depart_time'] = $data['depart_at']->format('H:i');
        $data['arrive_date'] = $data['arrive_at']->format('d-m-Y');
        $data['arrive_time'] = $data['arrive_at']->format('H:i');
        return $data;
    }

    private function update_data()
    {
        $data = factory(TrainTicket::class)->make()->toArray();
        $data['depart_date'] = $data['depart_at']->format('d-m-Y');
        $data['depart_time'] = $data['depart_at']->format('H:i');
        $data['arrive_date'] = $data['arrive_at']->format('d-m-Y');
        $data['arrive_time'] = $data['arrive_at']->format('H:i');
        return $data;
    }

    private function assertData($train_ticket, $data)
    {
        foreach ($data as $key => $value) {
            if($key == 'depart_date' || $key == 'depart_time'){
                $date = (new \DateTime($train_ticket->depart_at))->format('d-m-Y H:i');
                $this->assertEquals($data['depart_date'].' '.$data['depart_time'], $date);
            }elseif($key == 'arrive_date' || $key == 'arrive_time'){
                $date = (new \DateTime($train_ticket->arrive_at))->format('d-m-Y H:i');
                $this->assertEquals($data['arrive_date'].' '.$data['arrive_time'], $date);
            }else{
                $this->assertEquals($value, $train_ticket->{$key});
            }
        }
    }
}