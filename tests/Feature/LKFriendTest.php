<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\LKFriend;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Tests\TestCase;

class LKFriendTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $employee_read;
    private $employee_write;
    private $created_count = 0;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->index_route = route('lkfriends.index');
        $this->services_index_route = route('services.index').'#pills-Like-Friend-tab';
        $this->create_route = route('lkfriends.create');
        $this->store_route = route('lkfriends.store');
        $this->edit_route = route('lkfriends.edit', ['lkfriend'=>1]);
        $this->update_route = route('lkfriends.update', ['lkfriend'=>1]);

        Artisan::call('testlogs:clear');
        $this->admin = $this->createAdminEmployee();
        $this->employee_write = $this->createEmployeeWithPermission(LKFriend::PERMISSION_NAME, 'write');
        $this->employee_read = $this->createEmployeeWithPermission(LKFriend::PERMISSION_NAME, 'read');
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
    public function user_with_permission_can_see_lkfriends_page($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_read->user;
        $count = 3;
        $lkfriends = factory(LKFriend::class, $count)->create();
        $response = $this->actingAs($auth)->get($this->index_route);

        $response->assertOk();

        $lkfriends_from_view = $this->getDataFromDatatableResponse($response);
        $this->assertNotNull($lkfriends_from_view);
        $this->assertCount($count, $lkfriends_from_view);
        $this->assertCount($count, LKFriend::all());
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_paginate_lkfriends($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_read->user;
        $all_count = 10;
        $per_page = 3;
        $lkfriends = factory(LKFriend::class, $all_count)->create();

        $next_page = '';
        $remaining = $all_count;
        $ids = [];
        for ($i=0;$i<$all_count;$i+=$per_page){
            $url_query = '?length=' . $per_page . '&start=' . $i;
            $url = $this->index_route;
            $url .= $url_query;
            $response = $this->actingAs($auth)->get($url);

            $response->assertOk();

            $lkfriends_from_view = $this->getDataFromDatatableResponse($response);

            //make sure that no raw is sent twice when paginating
            $diff = (array_diff($ids, $lkfriends_from_view->pluck('id')->toArray()));
            $this->assertEquals($diff, $ids);
            $ids = array_merge($ids, $lkfriends_from_view->pluck('id')->toArray());

            $this->assertNotNull($lkfriends_from_view);

            //assert that we got the expected number of raws
            $count_should_be = $remaining >= $per_page ? $per_page : $remaining;
            $remaining -= count($lkfriends_from_view);
            $this->assertCount($count_should_be, $lkfriends_from_view);
        }
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_search_lkfriend($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_read->user;
        $loops = 13;
        $can_search_by = (new LKFriend())->can_search_by;
        $can_search_by = array_map(function ($item) {
            return str_replace('l_k_friends.', '', $item);
        }, $can_search_by);
        for ($i=0;$i<$loops;$i++){
            $lkfriends = factory(LKFriend::class, 20)->create();

            $rand_rest = $lkfriends->toArray()[rand(0,9)];
            $rand_name = $rand_rest['name'];
            $rand_word = Arr::random(explode(' ', $rand_name));
            $url_query = '?search[value]=' . $rand_word;

            $response = $this->actingAs($auth)->get($this->index_route.$url_query);

            $response->assertOk();
            $lkfriends_from_view = $this->getDataFromDatatableResponse($response);
            $this->assertNotNull($lkfriends_from_view);
            $this->assertGreaterThan(0, count($lkfriends_from_view));

            //assert searched name exists in the result
            foreach($lkfriends_from_view as $lkfriend){
                $found = 0;
                foreach ($can_search_by as $key) {
                    if (stripos($key, '.') !== false) {
                        $parts = explode('.', $key);
                        if (stripos($lkfriend->{$parts[0]}->{$parts[1]}, $rand_word) !== false) {
                            $found++;
                        }
                    } elseif (stripos($lkfriend->{$key}, $rand_word) !== false) {
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
    public function user_with_permission_can_sort_lkfriends($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_read->user;
        for ($z=0;$z<10;$z++){
            $all_count = 10;
            $lkfriends = factory(LKFriend::class, $all_count)->create();
            $param = 'name';
            $url_query = '?order[0][dir]=asc&order[0][column]=0&columns[0][data]=' . $param;

            $response = $this->actingAs($auth)->get($this->index_route.$url_query);
            $response->assertOk();

            $lkfriends_from_view = $this->getDataFromDatatableResponse($response);
            $this->assertNotNull($lkfriends_from_view);
            $this->assertGreaterThan(0, count($lkfriends_from_view));

            $lkfriends = $lkfriends_from_view;
            for ($i=0;$i<count($lkfriends);$i++){
                if($i > 0){
                    if (stripos($param, '.') !== false) {
                        $parts = explode('.', $param);
                        $this->greaterThanOrEqual($lkfriends->get($i - 1)->{$parts[0]}->{$parts[1]}, $lkfriends->get($i)->{$parts[0]}->{$parts[1]});
                    } else {
                        $this->greaterThanOrEqual($lkfriends->get($i - 1)->{$param}, $lkfriends->get($i)->{$param});
                    }
                }
            }
        }
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_delete_lkfriend($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $data = $this->data();
        $response = $this->actingAs($auth)->post($this->store_route, $data);
        $lkfriend = LKFriend::first();

        $response = $this->actingAs($auth)->delete($lkfriend->deletePath());
        $response->assertSessionHasNoErrors();
        $response->assertRedirect($this->services_index_route);
        $this->assertNull(LKFriend::find($lkfriend->id));
        $response->assertSessionHas('success');
    }

    /** @test */
    public function a_guest_cannot_delete_lkfriend()
    {
        $lkfriend = factory(LKFriend::class)->create();
        $this->delete($lkfriend->deletePath())->assertRedirect(route('login'));
        $this->assertNotNull(LKFriend::find($lkfriend->id));
    }

    /** @test */
    public function user_without_permission_cannot_delete_lkfriend()
    {
        $lkfriend = factory(LKFriend::class)->create();
        $this->actingAs($this->employee_read->user)->delete($lkfriend->deletePath())->assertForbidden();
        $this->assertNotNull(LKFriend::find($lkfriend->id));
    }

    /** @test */
    public function a_guest_cannot_see_add_lkfriend_page()
    {
        $this->get($this->create_route)->assertRedirect(route('login'));
    }

    /** @test */
    public function user_without_permission_cannot_see_add_lkfriend_page()
    {
        $this->actingAs($this->employee_read->user)->get($this->create_route)->assertForbidden();
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_see_add_lkfriend_page($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $response = $this->actingAs($auth)->get($this->create_route);
        $response->assertSessionHasNoErrors();
        $response->assertViewIs('lkfriends.create');
        $cities = $this->getDataFromResponse($response, 'cities');
        $languages = $this->getDataFromResponse($response, 'languages');
        $this->assertNotNull($cities);
        $this->assertNotNull($languages);
    }

    /** @test */
    public function a_guest_cannot_add_lkfriend()
    {
        $this->post($this->store_route)->assertRedirect(route('login'));
    }

    /** @test */
    public function user_without_permission_cannot_add_lkfriend()
    {
        $this->actingAs($this->employee_read->user)->post($this->store_route)->assertForbidden();
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_add_lkfriend($auth)
    {
        $this->withoutExceptionHandling();
        $auth = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $data = $this->data();
        $response = $this->actingAs($auth)->post($this->store_route, $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect($this->services_index_route);
        $response->assertSessionHas('success');
        $this->assertEquals($this->created_count+1, LKFriend::count());
        $lkfriend = LKFriend::first();
        $this->assertData($lkfriend, $data);
    }

    /** @test */
    public function a_guest_cannot_see_edit_lkfriend_page()
    {
        $lkfriend = factory(LKFriend::class)->create();
        $this->get($lkfriend->editPath())->assertRedirect(route('login'));
    }

    /** @test */
    public function user_without_permission_cannot_see_edit_lkfriend_page()
    {
        $lkfriend = factory(LKFriend::class)->create();
        $this->actingAs($this->employee_read->user)->get($lkfriend->editPath())->assertForbidden();
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_see_edit_lkfriend_page($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $lkfriend = factory(LKFriend::class)->create();
        $response = $this->actingAs($auth)->get($lkfriend->editPath());
        $response->assertSessionHasNoErrors();
        $response->assertViewIs('lkfriends.edit');
        $lkfriend_from_view = $this->getDataFromResponse($response, 'lkfriend');
        $cities = $this->getDataFromResponse($response, 'cities');
        $languages = $this->getDataFromResponse($response, 'languages');
        $this->assertNotNull($cities);
        $this->assertNotNull($languages);
        $this->assertNotNull($lkfriend_from_view);
        $this->assertEquals($lkfriend->id, $lkfriend_from_view->id);
    }

    /** @test */
    public function a_guest_cannot_edit_lkfriend()
    {
        $lkfriend = factory(LKFriend::class)->create();
        $this->patch($this->update_route)->assertRedirect(route('login'));
    }

    /** @test */
    public function user_without_permission_cannot_edit_lkfriend()
    {
        $lkfriend = factory(LKFriend::class)->create();
        $this->actingAs($this->employee_read->user)->patch($this->update_route)->assertForbidden();
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_edit_lkfriend($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $data = $this->data();
        $response = $this->actingAs($auth)->post($this->store_route, $data);
        $lkfriend = LKFriend::first();

        $data = $this->update_data();
        $response = $this->actingAs($auth)->patch($this->update_route, $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect($this->services_index_route);
        $response->assertSessionHas('success');
        $this->assertCount($this->created_count+1, LKFriend::all());

        $lkfriend->refresh();
        $this->assertData($lkfriend, $data);
    }




    private function data()
    {
        $data = factory(LKFriend::class)->make()->toArray();
        $data['rent_day'] = 'EGP '.$data['rent_day'];
        $data['sell_rent_day_vat_exc'] = 'EURO '.$data['sell_rent_day_vat_exc'];
        return $data;
    }

    private function update_data()
    {
        return $this->data();
    }

    private function assertData($lkfriend, $data)
    {
        foreach ($data as $key => $value) {
            if(in_array($key, ['rent_day', 'sell_rent_day_vat_exc'])){
                $value = trim((string)Str::of($value)->replace(['EGP ', 'EURO ', '%', ','], ''));
            }
            $this->assertEquals($value, $lkfriend->{$key});
        }
    }
}
