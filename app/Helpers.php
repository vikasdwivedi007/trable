<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Str;

class Helpers
{
    public static function FormatForDatatable($collection, $count)
    {
//        $collection = $collection->toArray();
        return [
            'draw' => request('draw'),
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $collection->toArray()
        ];
    }

    public static function removeCurrencyFromNumericFields($rules)
    {
        foreach ($rules as $key => $value) {
            if (request($key) && !is_array($value) && (stripos($value, 'numeric') !== false || stripos($value, 'digits') !== false)) {
                $input = (string)Str::of(request($key))->replace(['EGP ', 'EURO '], '');
                request()->request->set($key, trim($input));
            }
        }
        self::removeSignsFromNumbers($rules);
    }

    public static function removeSignsFromNumbers($rules)
    {
        foreach ($rules as $key => $value) {
            if (request($key) && !is_array($value) && (stripos($value, 'numeric') !== false || stripos($value, 'digits') !== false)) {
                $input = (string)Str::of(request($key))->replace([',', '%', '-', '_'], '');
                request()->request->set($key, trim($input));
            }
        }
    }

    public static function formatTransportationRequestParams()
    {
        if (request('phone')) {
            $phone = (string)Str::of(request('phone'))->replace([',', '%', '-', '_'], '');
            request()->request->set('phone', trim($phone));
        }
        if (request('contacts')) {
            $contacts = [];
            foreach (request('contacts') as $key => $value) {
                $value['phone'] = trim((string)Str::of($value['phone'])->replace([',', '%', '-', '_'], ''));
                $contacts[$key] = $value;
            }
            request()->request->set('contacts', $contacts);
        }
        if (request('cars')) {
            $cars = [];
            foreach (request('cars') as $key => $value) {
                if (isset($value['driver_phone']) && $value['driver_phone']) {
                    $value['driver_phone'] = trim((string)Str::of($value['driver_phone'])->replace([',', '%', '-', '_'], ''));
                }
                if (isset($value['buy_price']) && $value['buy_price']) {
                    $value['buy_price'] = trim((string)Str::of($value['buy_price'])->replace([',', '%', '-', '_'], ''));
                    $value['buy_price'] = trim((string)Str::of($value['buy_price'])->replace(['EGP ', 'EURO '], ''));
                }
                if (isset($value['sell_price_vat_exc']) && $value['sell_price_vat_exc']) {
                    $value['sell_price_vat_exc'] = trim((string)Str::of($value['sell_price_vat_exc'])->replace([',', '%', '-', '_'], ''));
                    $value['sell_price_vat_exc'] = trim((string)Str::of($value['sell_price_vat_exc'])->replace(['EGP ', 'EURO '], ''));
                }
                $car_no = '';
                if (isset($value['car_no_seg'])) {
                    foreach ($value['car_no_seg'] as $segment) {
                        $car_no .= $segment . ' ';
                    }
                }
                $value['car_no'] = trim($car_no);
                $cars[$key] = $value;
            }
            request()->request->set('cars', $cars);
        }
    }

    public static function formatRestaurantRequestParams()
    {
        if (request('phone')) {
            $phone = (string)Str::of(request('phone'))->replace([',', '%', '-', '_'], '');
            request()->request->set('phone', trim($phone));
        }
        if (request('contacts')) {
            $contacts = [];
            foreach (request('contacts') as $key => $value) {
                $value['phone'] = trim((string)Str::of($value['phone'])->replace([',', '%', '-', '_'], ''));
                $contacts[$key] = $value;
            }
            request()->request->set('contacts', $contacts);
        }
        if (request('menus')) {
            $menus = [];
            foreach (request('menus') as $key => $value) {
                if (isset($value['buy_price']) && $value['buy_price']) {
                    $value['buy_price'] = trim((string)Str::of($value['buy_price'])->replace([',', '%', '-', '_'], ''));
                    $value['buy_price'] = trim((string)Str::of($value['buy_price'])->replace(['EGP ', 'EURO '], ''));
                }
                if (isset($value['sell_price_vat_exc']) && $value['sell_price_vat_exc']) {
                    $value['sell_price_vat_exc'] = trim((string)Str::of($value['sell_price_vat_exc'])->replace([',', '%', '-', '_'], ''));
                    $value['sell_price_vat_exc'] = trim((string)Str::of($value['sell_price_vat_exc'])->replace(['EGP ', 'EURO '], ''));
                }
                $menus[$key] = $value;
            }
            request()->request->set('menus', $menus);
        }
    }

    public static function formatTravelAgentRequestParams()
    {
        if (request('phone')) {
            $phone = (string)Str::of(request('phone'))->replace([',', '%', '-', '_'], '');
            request()->request->set('phone', trim($phone));
        }
        if (request('contacts')) {
            $contacts = [];
            foreach (request('contacts') as $key => $value) {
                $value['phone'] = trim((string)Str::of($value['phone'])->replace([',', '%', '-', '_'], ''));
                $contacts[$key] = $value;
            }
            request()->request->set('contacts', $contacts);
        }
    }

    public static function formatHotelRequestParams()
    {
        if (request('phone')) {
            $phone = (string)Str::of(request('phone'))->replace([',', '%', '-', '_'], '');
            request()->request->set('phone', trim($phone));
        }
        if (request('contacts')) {
            $contacts = [];
            foreach (request('contacts') as $key => $value) {
                $value['phone'] = trim((string)Str::of($value['phone'])->replace([',', '%', '-', '_'], ''));
                $contacts[$key] = $value;
            }
            request()->request->set('contacts', $contacts);
        }
    }

    public static function formatRoomRequestParams()
    {
        if (request('discount_type') && request('discount_type') == 2 && request('discount_value_amount')) {
            $discount_value_amount = (string)Str::of(request('discount_value_amount'))->replace(['EGP', ',', '%', '-', '_'], '');
            request()->request->set('discount_value', trim($discount_value_amount));
            request()->request->set('discount_value_amount', trim($discount_value_amount));
        } elseif (request('discount_type') && request('discount_type') == 1 && request('discount_value_perc')) {
            $discount_value_perc = (string)Str::of(request('discount_value_perc'))->replace(['EGP', ',', '%', '-', '_'], '');
            request()->request->set('discount_value', trim($discount_value_perc));
            request()->request->set('discount_value_perc', trim($discount_value_perc));
        } else {
            request()->request->set('discount_type', '');
            request()->request->set('discount_value', '');
        }

        if (request('view') == '-1' && request('view_new')) {
            request()->request->set('view', trim(request('view_new')));
        }

        $cancels = [];
        if (request('cancels') && is_array(request('cancels'))) {
            foreach (request('cancels') as $key => $value) {
                if ($value['type'] && $value['type'] == 2 && $value['cancel_value_amount']) {
                    $cancel_value_amount = (string)Str::of($value['cancel_value_amount'])->replace(['EGP', ',', '%', '-', '_'], '');
                    $value['value'] = trim($cancel_value_amount);
                    $value['cancel_value_amount'] = trim($cancel_value_amount);
                } elseif ($value['type'] && $value['type'] == 1 && $value['cancel_value_perc']) {
                    $cancel_value_perc = (string)Str::of($value['cancel_value_perc'])->replace(['EGP', ',', '%', '-', '_'], '');
                    $value['value'] = trim($cancel_value_perc);
                    $value['cancel_value_perc'] = trim($cancel_value_perc);
                } else {
                    $value['type'] = '';
                    $value['value'] = '';
                    $value['cancel_value_perc'] = '';
                    $value['cancel_value_amount'] = '';
                }
                $cancels[$key] = $value;
            }
        }
        request()->request->set('cancels', $cancels);
    }

    public static function formatEmployeeRequestParams()
    {
        if (request('job_id') == '-1' && request('job_title')) {
            request()->request->remove('job_id');
        }
    }

    public static function formatReminderRequestParams()
    {
        if (request('send_at') && request('time')) {
            request()->request->set('send_at_date', request('send_at'));
            request()->request->set('send_at', trim(request('send_at') . ' ' . request('time')));
        }
    }

    public static function readableDate($date)
    {
        $diff_readable = '';
        if ($date) {
            $diff_readable = (new Carbon($date))->diffForHumans();
        }
        return $diff_readable;
    }

    public static function getNameInitials($name)
    {
        $words = preg_split("/[\s,_-]+/", $name);
        $acronym = "";
        foreach ($words as $w) {
            $acronym .= $w[0].'.';
        }
        return $acronym;
    }

    public static function arabicMonths($month=null)
    {
        $months = array(
            "01" => "يناير",
            "02" => "فبراير",
            "03" => "مارس",
            "04" => "أبريل",
            "05" => "مايو",
            "06" => "يونيو",
            "07" => "يوليو",
            "08" => "أغسطس",
            "09" => "سبتمبر",
            "10" => "أكتوبر",
            "11" => "نوفمبر",
            "12" => "ديسمبر"
        );
        if($month && isset($months[$month])){
            return $months[$month];
        }
        return $months;
    }
}
