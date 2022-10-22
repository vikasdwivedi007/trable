<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Router;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Tests\TestCase;

class RouterTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $employee_read;
    private $employee_write;
    private $created_count = 0;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->index_route = route('routers.index');
        $this->services_index_route = route('services.index').'#pills-Routers-tab';
        $this->create_route = route('routers.create');
        $this->store_route = route('routers.store');
        $this->edit_route = route('routers.edit', ['router'=>1]);
        $this->update_route = route('routers.update', ['router'=>1]);

        Artisan::call('testlogs:clear');
        $this->admin = $this->createAdminEmployee();
        $this->employee_write = $this->createEmployeeWithPermission(Router::PERMISSION_NAME, 'write');
        $this->employee_read = $this->createEmployeeWithPermission(Router::PERMISSION_NAME, 'read');
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
    public function user_with_permission_can_see_routers_page($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_read->user;
        $count = 3;
        $routers = factory(Router::class, $count)->create();
        $response = $this->actingAs($auth)->get($this->index_route);

        $response->assertOk();

        $routers_from_view = $this->getDataFromDatatableResponse($response);
        $this->assertNotNull($routers_from_view);
        $this->assertCount($count, $routers_from_view);
        $this->assertCount($count, Router::all());
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_paginate_routers($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_read->user;
        $all_count = 10;
        $per_page = 3;
        $routers = factory(Router::class, $all_count)->create();

        $next_page = '';
        $remaining = $all_count;
        $ids = [];
        for ($i=0;$i<$all_count;$i+=$per_page){
            $url_query = '?length=' . $per_page . '&start=' . $i;
            $url = $this->index_route;
            $url .= $url_query;
            $response = $this->actingAs($auth)->get($url);

            $response->assertOk();
            $routers_from_view = $this->getDataFromDatatableResponse($response);

            //make sure that no raw is sent twice when paginating
            $diff = (array_diff($ids, $routers_from_view->pluck('id')->toArray()));
            $this->assertEquals($diff, $ids);
            $ids = array_merge($ids, $routers_from_view->pluck('id')->toArray());

            $this->assertNotNull($routers_from_view);
            //assert that we got the expected number of raws
            $count_should_be = $remaining >= $per_page ? $per_page : $remaining;
            $remaining -= count($routers_from_view);
            $this->assertCount($count_should_be, $routers_from_view);
        }
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_search_router($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_read->user;
        $loops = 13;
        $can_search_by = (new Router())->can_search_by;
        $can_search_by = array_map(function ($item) {
            return str_replace('routers.', '', $item);
        }, $can_search_by);
        for ($i=0;$i<$loops;$i++){
            $routers = factory(Router::class, 20)->create();

            $rand_router = $routers->toArray()[rand(0,9)];
            $attr = 'serial_no';
            $rand_word = $rand_router[$attr];
            $url_query = '?search[value]=' . $rand_word;

            $response = $this->actingAs($auth)->get($this->index_route.$url_query);

            $response->assertOk();
            $routers_from_view = $this->getDataFromDatatableResponse($response);
            $this->assertNotNull($routers_from_view);
            $this->assertGreaterThan(0, count($routers_from_view));

            //assert searched name exists in the result
            foreach($routers_from_view as $router){
                $found = 0;
                foreach ($can_search_by as $key) {
                    if (stripos($key, '.') !== false) {
                        $parts = explode('.', $key);
                        if (stripos($router->{$parts[0]}->{$parts[1]}, $rand_word) !== false) {
                            $found++;
                        }
                    } elseif (stripos($router->{$key}, $rand_word) !== false) {
                        $found++;
                    }
                }
                $this->assertGreaterThan(0, $found);
            }
        }
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_sort_routers($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_read->user;
        for ($z=0;$z<10;$z++){
            $all_count = 10;
            $routers = factory(Router::class, $all_count)->create();
            $param = 'number';
            $order = 'ASC';
            $url_query = '?order[0][dir]=asc&order[0][column]=0&columns[0][data]=' . $param;

            $response = $this->actingAs($auth)->get($this->index_route.$url_query);
            $response->assertOk();

            $routers_from_view = $this->getDataFromDatatableResponse($response);
            $this->assertNotNull($routers_from_view);
            $this->assertGreaterThan(0, count($routers_from_view));

            $routers = $routers_from_view;
            for ($i=0;$i<count($routers);$i++){
                if($i > 0){
                    if (stripos($param, '.') !== false) {
                        $parts = explode('.', $param);
                        $this->greaterThanOrEqual($routers->get($i - 1)->{$parts[0]}->{$parts[1]}, $routers->get($i)->{$parts[0]}->{$parts[1]});
                    } else {
                        $this->greaterThanOrEqual($routers->get($i - 1)->{$param}, $routers->get($i)->{$param});
                    }
                }
            }
        }
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_delete_router($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $data = $this->data();
        $response = $this->actingAs($auth)->post($this->store_route, $data);
        $router = Router::first();

        $response = $this->actingAs($auth)->delete($router->deletePath());
        $response->assertSessionHasNoErrors();
        $response->assertRedirect($this->services_index_route);
        $this->assertNull(Router::find($router->id));
        $response->assertSessionHas('success');
    }

    /** @test */
    public function a_guest_cannot_delete_router()
    {
        $router = factory(Router::class)->create();
        $this->delete($router->deletePath())->assertRedirect(route('login'));
        $this->assertNotNull(Router::find($router->id));
    }

    /** @test */
    public function user_without_permission_cannot_delete_router()
    {
        $router = factory(Router::class)->create();
        $this->actingAs($this->employee_read->user)->delete($router->deletePath())->assertForbidden();
        $this->assertNotNull(Router::find($router->id));
    }

    /** @test */
    public function a_guest_cannot_see_add_router_page()
    {
        $this->get($this->create_route)->assertRedirect(route('login'));
    }

    /** @test */
    public function user_without_permission_cannot_see_add_router_page()
    {
        $this->actingAs($this->employee_read->user)->get($this->create_route)->assertForbidden();
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_see_add_router_page($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $response = $this->actingAs($auth)->get($this->create_route);
        $response->assertSessionHasNoErrors();
        $response->assertViewIs('routers.create');
        $cities = $this->getDataFromResponse($response, 'cities');
        $this->assertNotNull($cities);
    }

    /** @test */
    public function a_guest_cannot_add_router()
    {
        $this->post($this->store_route)->assertRedirect(route('login'));
    }

    /** @test */
    public function user_without_permission_cannot_add_router()
    {
        $this->actingAs($this->employee_read->user)->post($this->store_route)->assertForbidden();
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_add_router($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $data = $this->data();
        $response = $this->actingAs($auth)->post($this->store_route, $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect($this->services_index_route);
        $response->assertSessionHas('success');
        $this->assertEquals($this->created_count+1, Router::count());
        $router = Router::first();
        $this->assertData($router, $data);
    }

    /** @test */
    public function a_guest_cannot_see_edit_router_page()
    {
        $router = factory(Router::class)->create();
        $this->get($router->editPath())->assertRedirect(route('login'));
    }

    /** @test */
    public function user_without_permission_cannot_see_edit_router_page()
    {
        $router = factory(Router::class)->create();
        $this->actingAs($this->employee_read->user)->get($router->editPath())->assertForbidden();
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_see_edit_router_page($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $router = factory(Router::class)->create();
        $response = $this->actingAs($auth)->get($router->editPath());
        $response->assertSessionHasNoErrors();
        $response->assertViewIs('routers.edit');
        $router_from_view = $this->getDataFromResponse($response, 'router');
        $cities = $this->getDataFromResponse($response, 'cities');
        $this->assertNotNull($cities);
        $this->assertNotNull($router_from_view);
        $this->assertEquals($router->id, $router_from_view->id);
    }

    /** @test */
    public function a_guest_cannot_edit_router()
    {
        $router = factory(Router::class)->create();
        $this->patch($this->update_route)->assertRedirect(route('login'));
    }

    /** @test */
    public function user_without_permission_cannot_edit_router()
    {
        $router = factory(Router::class)->create();
        $this->actingAs($this->employee_read->user)->patch($this->update_route)->assertForbidden();
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_edit_router($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $data = $this->data();
        $response = $this->actingAs($auth)->post($this->store_route, $data);
        $router = Router::first();

        $data = $this->update_data();
        $response = $this->actingAs($auth)->patch($this->update_route, $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect($this->services_index_route);
        $response->assertSessionHas('success');
        $this->assertCount($this->created_count+1, Router::all());

        $router->refresh();
        $this->assertData($router, $data);
    }




    private function data()
    {
        $data = factory(Router::class)->make()->toArray();
        $data['package_buy_price'] = 'EGP '.$data['package_buy_price'];
        $data['package_sell_price_vat_exc'] = 'EURO '.$data['package_sell_price_vat_exc'];
        return $data;
    }

    private function update_data()
    {
        return $this->data();
    }

    private function assertData($router, $data)
    {
        foreach ($data as $key => $value) {
            if(in_array($key, ['package_buy_price', 'package_sell_price_vat_exc'])){
                $value = trim((string)Str::of($value)->replace(['EGP ', 'EURO ', '%', ','], ''));
            }
            $this->assertEquals($value, $router->{$key});
        }
    }
}