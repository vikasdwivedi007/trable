<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Airport extends Model
{
    use SoftDeletes, SerializeDate;

    public static function findAirport($search_by)
    {
        $search_by = explode(' ', $search_by);
        $airports = self::where(function ($query) use ($search_by) {
            foreach ($search_by as $word) {
                $query->where(function ($inner_query) use ($word) {
                    $inner_query->where('iata', 'like', '%' . $word . '%')
                        ->orWhere('name', 'like', '%' . $word . '%')
                        ->orWhere('name_ar', 'like', '%' . $word . '%')
                        ->orWhere('city', 'like', '%' . $word . '%')
                        ->orWhere('state', 'like', '%' . $word . '%')
                        ->orWhere('country', 'like', '%' . $word . '%');
                });
            }
        })->get();
        return $airports->map->format();
    }

    public function format()
    {
        $title = $this->iata ? $this->iata . " - " : "";
        $title .= $this->name ? $this->name . ' - ' : "";
        $city = $this->city == $this->state ? $this->city : $this->city . ' - ' . $this->state;
        $title .= $city . ' - ' . $this->country;

        return ['id' => $this->id, 'text' => trim(trim($title, '-')), 'text_ar' => $this->name_ar];
    }

    public static function fillEmptyColumns()
    {
        $airports = self::all();
        foreach ($airports as $airport) {
            if ($airport->state && !$airport->city) {
                $airport->city = $airport->state;
            } elseif (!$airport->state && $airport->city) {
                $airport->state = $airport->city;
            } elseif ($airport->name && !$airport->state && !$airport->city) {
                $airport->state = $airport->name;
                $airport->city = $airport->name;
            }
            $airport->save();
        }
    }

    public static function removeDashesFromEgyptianCities()
    {
        $country = 'EG';
        $airports = \App\Models\Airport::where('country', $country)->get();
        foreach ($airports as $airport) {
            if (stripos($airport->state, '-') !== false) {
                $airport->state = str_replace('-', ' ', $airport->state);
            }
            if (stripos($airport->city, '-') !== false) {
                $airport->city = str_replace('-', ' ', $airport->city);
            }
            $airport->save();
        }
    }

    public function getCity()
    {
        $country = Country::where('sortname', $this->country)->first();
        if ($country) {
            $city = City::where('country_id', $country->id)->where('name', $this->city)->first();
            if (!$city) {
                $city = City::where('country_id', $country->id)->where('name', $this->state)->first();
            }
            return $city;
        }
    }
}
