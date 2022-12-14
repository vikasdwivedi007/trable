<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Language;
use App\Models\SLShow;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Tests\TestCase;

class SLShowTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $employee_read;
    private $employee_write;
    private $created_count = 0;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->services_index_route = route('services.index') . '#pills-Sound-Light-Show-tab';
        $this->index_route = route('slshows.index');
        $this->create_route = route('slshows.create');
        $this->store_route = route('slshows.store');
        $this->edit_route = route('slshows.edit', ['slshow' => 1]);
        $this->update_route = route('slshows.update', ['slshow' => 1]);

        Artisan::call('testlogs:clear');
        $this->admin = $this->createAdminEmployee();
        $this->employee_write = $this->createEmployeeWithPermission(SLShow::PERMISSION_NAME, 'write');
        $this->employee_read = $this->createEmployeeWithPermission(SLShow::PERMISSION_NAME, 'read');
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
    public function user_with_permission_can_see_slshows_page($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_read->user;
        $count = 3;
        $slshows = factory(SLShow::class, $count)->create();
        $response = $this->actingAs($auth)->get($this->index_route);

        $response->assertOk();

        $slshows_from_view = $this->getDataFromDatatableResponse($response);
        $this->assertNotNull($slshows_from_view);
        $this->assertCount($count, $slshows_from_view);
        $this->assertCount($count, SLShow::all());
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_paginate_slshows($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_read->user;
        $all_count = 10;
        $per_page = 3;
        $slshows = factory(SLShow::class, $all_count)->create();

        $next_page = '';
        $remaining = $all_count;
        $ids = [];
        for ($i = 0; $i < $all_count; $i += $per_page) {
            $url_query = '?length=' . $per_page . '&start=' . $i;
            $url = $this->index_route;
            $url .= $url_query;
            $response = $this->actingAs($auth)->get($url);

            $response->assertOk();

            $slshows_from_view = $this->getDataFromDatatableResponse($response);

            //make sure that no raw is sent twice when paginating
            $diff = (array_diff($ids, $slshows_from_view->pluck('id')->toArray()));
            $this->assertEquals($diff, $ids);
            $ids = array_merge($ids, $slshows_from_view->pluck('id')->toArray());

            $this->assertNotNull($slshows_from_view);

            //assert that we got the expected number of raws
            $count_should_be = $remaining >= $per_page ? $per_page : $remaining;
            $remaining -= count($slshows_from_view);
            $this->assertCount($count_should_be, $slshows_from_view);
        }
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_search_slshow($auth)
    {
        $this->withoutExceptionHandling();
        $auth = $auth == 0 ? $this->admin->user : $this->employee_read->user;
        $loops = 13;
        $can_search_by = (new SLShow())->can_search_by;
        $can_search_by = array_map(function ($item) {
            return str_replace('s_l_shows.', '', $item);
        }, $can_search_by);
        for ($i = 0; $i < $loops; $i++) {
            $slshows = factory(SLShow::class, 20)->create()->load('city');

            $rand_slshow = $slshows->toArray()[rand(0, 9)];
            $rand_word = $rand_slshow['city']['name'];
            $url_query = '?search[value]=' . $rand_word;

            $response = $this->actingAs($auth)->get($this->index_route . $url_query);

            $response->assertOk();
            $slshows_from_view = $this->getDataFromDatatableResponse($response);
            $this->assertNotNull($slshows_from_view);
            $this->assertGreaterThan(0, count($slshows_from_view));

            //assert searched name exists in the result
            foreach ($slshows_from_view as $slshow) {
                $found = 0;
                foreach ($can_search_by as $key) {
                    if (stripos($key, '.') !== false) {
                        $parts = explode('.', $key);
                        if (stripos($slshow->{$parts[0]}->{$parts[1]}, $rand_word) !== false) {
                            $found++;
                        }
                    } elseif (stripos($slshow->{$key}, $rand_word) !== false) {
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
    public function user_with_permission_can_sort_slshows($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_read->user;
        for ($z = 0; $z < 10; $z++) {
            $all_count = 10;
            $slshows = factory(SLShow::class, $all_count)->create();
            $param = 'date';
            $url_query = '?order[0][dir]=asc&order[0][column]=0&columns[0][data]=' . $param;

            $response = $this->actingAs($auth)->get($this->index_route . $url_query);
            $response->assertOk();

            $slshows_from_view = $this->getDataFromDatatableResponse($response);
            $this->assertNotNull($slshows_from_view);
            $this->assertGreaterThan(0, count($slshows_from_view));

            $slshows = $slshows_from_view;
            for ($i = 0; $i < count($slshows); $i++) {
                if ($i > 0) {
                    if (stripos($param, '.') !== false) {
                        $parts = explode('.', $param);
                        $this->greaterThanOrEqual($slshows->get($i - 1)->{$parts[0]}->{$parts[1]}, $slshows->get($i)->{$parts[0]}->{$parts[1]});
                    } else {
                        $this->greaterThanOrEqual($slshows->get($i - 1)->{$param}, $slshows->get($i)->{$param});
                    }
                }
            }
        }
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_delete_slshow($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $data = $this->data();
        $response = $this->actingAs($auth)->post($this->store_route, $data);
        $slshow = SLShow::first();

        $response = $this->actingAs($auth)->delete($slshow->deletePath());
        $response->assertSessionHasNoErrors();
        $response->assertRedirect($this->services_index_route);
        $this->assertNull(SLShow::find($slshow->id));
        $response->assertSessionHas('success');
    }

    /** @test */
    public function a_guest_cannot_delete_slshow()
    {
        $slshow = factory(SLShow::class)->create();
        $this->delete($slshow->deletePath())->assertRedirect(route('login'));
        $this->assertNotNull(SLShow::find($slshow->id));
    }

    /** @test */
    public function user_without_permission_cannot_delete_slshow()
    {
        $slshow = factory(SLShow::class)->create();
        $this->actingAs($this->employee_read->user)->delete($slshow->deletePath())->assertForbidden();
        $this->assertNotNull(SLShow::find($slshow->id));
    }

    /** @test */
    public function a_guest_cannot_see_add_slshow_page()
    {
        $this->get($this->create_route)->assertRedirect(route('login'));
    }

    /** @test */
    public function user_without_permission_cannot_see_add_slshow_page()
    {
        $this->actingAs($this->employee_read->user)->get($this->create_route)->assertForbidden();
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_see_add_slshow_page($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $response = $this->actingAs($auth)->get($this->create_route);
        $response->assertSessionHasNoErrors();
        $response->assertViewIs('slshows.create');
        $cities = $this->getDataFromResponse($response, 'cities');
        $languages = $this->getDataFromResponse($response, 'languages');
        $this->assertNotNull($cities);
        $this->assertNotNull($languages);
    }

    /** @test */
    public function a_guest_cannot_add_slshow()
    {
        $this->post($this->store_route)->assertRedirect(route('login'));
    }

    /** @test */
    public function user_without_permission_cannot_add_slshow()
    {
        $this->actingAs($this->employee_read->user)->post($this->store_route)->assertForbidden();
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_add_slshow($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $data = $this->data();
        $response = $this->actingAs($auth)->post($this->store_route, $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect($this->services_index_route);
        $response->assertSessionHas('success');
        $this->assertEquals($this->created_count + 1, SLShow::count());
        $slshow = SLShow::first();
        $this->assertData($slshow, $data);
    }

    /** @test */
    public function a_guest_cannot_see_edit_slshow_page()
    {
        $slshow = factory(SLShow::class)->create();
        $this->get($slshow->editPath())->assertRedirect(route('login'));
    }

    /** @test */
    public function user_without_permission_cannot_see_edit_slshow_page()
    {
        $slshow = factory(SLShow::class)->create();
        $this->actingAs($this->employee_read->user)->get($slshow->editPath())->assertForbidden();
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_see_edit_slshow_page($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $slshow = factory(SLShow::class)->create();
        $response = $this->actingAs($auth)->get($slshow->editPath());
        $response->assertSessionHasNoErrors();
        $response->assertViewIs('slshows.edit');
        $slshow_from_view = $this->getDataFromResponse($response, 'slshow');
        $cities = $this->getDataFromResponse($response, 'cities');
        $languages = $this->getDataFromResponse($response, 'languages');
        $this->assertNotNull($cities);
        $this->assertNotNull($languages);
        $this->assertNotNull($slshow_from_view);
        $this->assertEquals($slshow->id, $slshow_from_view->id);
    }

    /** @test */
    public function a_guest_cannot_edit_slshow()
    {
        $slshow = factory(SLShow::class)->create();
        $this->patch($this->update_route)->assertRedirect(route('login'));
    }

    /** @test */
    public function user_without_permission_cannot_edit_slshow()
    {
        $slshow = factory(SLShow::class)->create();
        $this->actingAs($this->employee_read->user)->patch($this->update_route)->assertForbidden();
    }

    /**
     * @test
     * @dataProvider authUserProvider
     */
    public function user_with_permission_can_edit_slshow($auth)
    {
        $auth = $auth == 0 ? $this->admin->user : $this->employee_write->user;
        $data = $this->data();
        $response = $this->actingAs($auth)->post($this->store_route, $data);
        $slshow = SLShow::first();

        $data = $this->update_data();
        $response = $this->actingAs($auth)->patch($this->update_route, $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect($this->services_index_route);
        $response->assertSessionHas('success');
        $this->assertCount($this->created_count + 1, SLShow::all());

        $slshow->refresh();
        $this->assertData($slshow, $data);
    }


    private function data()
    {
        $data = factory(SLShow::class)->make()->toArray();
        $data['time'] = Carbon::createFromFormat('Y-m-d H:i', $data['date'].' '.$data['time'])->format('H:i');
        $data['buy_price_adult'] = 'EGP ' . $data['buy_price_adult'];
        $data['sell_price_adult_vat_exc'] = 'EURO ' . $data['sell_price_adult_vat_exc'];
        $data['buy_price_child'] = 'EGP ' . $data['buy_price_child'];
        $data['sell_price_child_vat_exc'] = 'EURO ' . $data['sell_price_child_vat_exc'];
        return $data;
    }

    private function update_data()
    {
//        return [
//            'date' => Carbon::now()->addDay()->format('d-m-Y'),
//            'time' => "23:57",
//            'city_id' => factory(City::class)->create()->id,
//            'language_id' => factory(Language::class)->create()->id,
//            'buy_price_adult' => rand(100, 200),
//            'sell_price_adult_vat_exc' => rand(200, 300),
//            'buy_price_child' => rand(50, 100),
//            'sell_price_child_vat_exc' => rand(100, 200)
//        ];
        return $this->data();
    }

    private function assertData($slshow, $data)
    {
        foreach ($data as $key => $value) {
            if ($key == 'date') {
                $date = (new \DateTime($slshow->date))->format('Y-m-d');
                $this->assertEquals($value, $date);
            } elseif ($key == 'time') {
                $time = (new \DateTime($slshow->time))->format('H:i');
                $this->assertEquals($value, $time);
            } elseif (in_array($key, ['buy_price_adult', 'sell_price_adult_vat_exc', 'buy_price_child', 'sell_price_child_vat_exc'])) {
                $value = trim((string)Str::of($value)->replace(['EGP ', 'EURO ', '%', ','], ''));
                $this->assertEquals($value, $slshow->{$key});
            } else {
                $this->assertEquals($value, $slshow->{$key});
            }
        }
    }
}
