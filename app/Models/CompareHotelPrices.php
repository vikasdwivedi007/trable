<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CompareHotelPrices extends Model
{
    const URL_HOTEL_PATTERN = '/Hotel_Review-(\w+-\w+)/';

    public static function getIDFromURL($url)
    {
        preg_match(self::URL_HOTEL_PATTERN, $url, $result);
        if ($result && isset($result[1])) {
            return $result[1];
        }
        return false;
    }

    public static function getHotelID($hotel_name, $hotel_id = null)
    {
        $file_location = self::searchForHotel($hotel_name);
        $data = self::readDataFromSavedFile($file_location);
        unlink($file_location);
        if (!$data) {
            return false;
        }

        $hotel_url = "https://www.tripadvisor.com" . $data;
        if ($hotel_id) {
            Hotel::find($hotel_id)->update(['tripadvisor_url' => $hotel_url]);
        }

        logger($hotel_url);
        $id = self::getIDFromURL($data);
        logger($id);
        return $id;
    }

    public static function searchForHotel($hotel_name)
    {
        $location = storage_path() . '/' . time() . Str::random(10);
        $command = 'wget -d --output-document=' . $location . ' \
  --method POST \
  --header \'content-type: application/json\' \
  --header \'cache-control: no-cache\' \
  --body-data \'[{"query":"query TypeaheadQuery($request: Typeahead_RequestInput!) {\n  Typeahead_autocomplete(request: $request) {\n    resultsId\n    partial\n    results {\n      __typename\n      ...TypeAhead_LocationItemFields\n      ...TypeAhead_UserProfileFields\n      ...TypeAhead_QuerySuggestionFields\n      ...TypeAhead_RescueResultFields\n      ...TypeAhead_ListResultFields\n    }\n  }\n}\n\nfragment TypeAhead_LocationItemFields on Typeahead_LocationItem {\n  documentId\n  locationId\n  details {\n    ...TypeAheadLocationInformationFields\n  }\n  highlightingInfo {\n    length\n    offset\n  }\n}\n\nfragment TypeAhead_UserProfileFields on Typeahead_UserProfileItem {\n  documentId\n  userId\n  details {\n    ...TypeAheadUserProfileFields\n  }\n}\n\nfragment TypeAheadLocationInformationFields on LocationInformation {\n  localizedName\n  localizedAdditionalNames {\n    longOnlyHierarchy\n  }\n  streetAddress {\n    street1\n  }\n  locationV2 {\n    placeType\n    names {\n      longOnlyHierarchyTypeaheadV2\n    }\n    vacationRentalsRoute {\n      url\n    }\n  }\n  url\n  HOTELS_URL: hotelsUrl\n  ATTRACTIONS_URL: attractionOverviewURL\n  RESTAURANTS_URL: restaurantOverviewURL\n  placeType\n  latitude\n  longitude\n  isGeo\n  thumbnail {\n    photoSizeDynamic {\n      maxWidth\n      maxHeight\n      urlTemplate\n    }\n  }\n}\n\nfragment TypeAheadUserProfileFields on MemberProfile {\n  username\n  displayName\n  followerCount\n  isVerified\n  isFollowing\n  avatar {\n    photoSizeDynamic {\n      maxWidth\n      maxHeight\n      urlTemplate\n    }\n  }\n  route {\n    url\n  }\n}\n\nfragment TypeAhead_QuerySuggestionFields on Typeahead_QuerySuggestionItem {\n  documentId\n  text\n  route {\n    url\n  }\n  buCategory\n  parentGeoDetails {\n    names {\n      longOnlyHierarchyTypeaheadV2\n    }\n  }\n  highlightingInfo {\n    length\n    offset\n  }\n}\n\nfragment TypeAhead_RescueResultFields on Typeahead_RescueResultItem {\n  documentId\n  text\n}\n\nfragment TypeAhead_ListResultFields on Typeahead_ListResultItem {\n  documentId\n  locationId\n  listResultType\n  FORUMListURL {\n    url\n  }\n  details {\n    localizedName\n    localizedAdditionalNames {\n      longOnlyHierarchy\n    }\n    locationV2 {\n      placeType\n      names {\n        longOnlyHierarchyTypeaheadV2\n      }\n      vacationRentalsRoute {\n        url\n      }\n    }\n    HOTELListURL: hotelsUrl\n    RESTAURANTListURL: restaurantOverviewURL\n    ATTRACTIONListURL: attractionOverviewURL\n    thumbnail {\n      photoSizeDynamic {\n        maxWidth\n        maxHeight\n        urlTemplate\n      }\n    }\n  }\n}\n","variables":{"request":{"query":"' . $hotel_name . '","limit":10,"scope":"IN_GEO_EXTEND_WORLDWIDE","locale":"en-US","scopeGeoId":294204,"searchCenter":null,"types":["LOCATION","QUERY_SUGGESTION","USER_PROFILE","RESCUE_RESULT","LIST_RESULT"],"locationTypes":["GEO","AIRPORT","ACCOMMODATION","ATTRACTION","ATTRACTION_PRODUCT","EATERY","NEIGHBORHOOD","AIRLINE","SHOPPING","UNIVERSITY","GENERAL_HOSPITAL","PORT","FERRY","CORPORATION","VACATION_RENTAL","SHIP","CRUISE_LINE","CAR_RENTAL_OFFICE"],"userId":null,"context":{"listResultType":"HOTEL","searchSessionId":"85A55AEBAB0F7029D34D0DF3DE54C5151637926199810ssid","typeaheadId":"1637926223113","uiOrigin":"SINGLE_SEARCH_NAV","routeUid":"08050089-2de5-416b-98ae-039231c20114"},"articleCategories":["default","love_your_local","insurance_lander"],"enabledFeatures":["typeahead-q"]}}}]\r\n\' \
  - https://www.tripadvisor.com/data/graphql/batched';

        exec($command);
        return $location;
    }

    public static function readDataFromSavedFile($file_location)
    {
        try {
            $str = file_get_contents($file_location);
            $data = json_decode($str, true);
            $results = [];
            if (isset($data[0]['data']['Typeahead_autocomplete']['results'])) {
                $results = $data[0]['data']['Typeahead_autocomplete']['results'];
            }
            foreach ($results as $item) {
                if (
                    isset($item['__typename']) && isset($item['details']) && isset($item['details']['placeType'])
                    &&
                    $item['__typename'] == 'Typeahead_LocationItem'
                    &&
                    $item['details']['placeType'] == 'ACCOMMODATION'
                    &&
                    isset($item['details']['url'])
                ) {
                    return $item['details']['url'];
                }
            }
            return false;
        } catch (\Throwable $t) {
            return false;
        }
    }

    public static function getHotelPrices($search_data)
    {
//        $hotel_id = 'g297549-d299729';//aqua
//        $hotel_id = 'g294204-d299631';//sofitel
        //$hotel_id = 'g938947-d796249';//Stella Di Mare Sea Club Hotel
        $default_currency = 'USD';
        $hotel_id = $search_data['hotel_id'];
        $check_in = Carbon::createFromFormat('l d F Y', $search_data['check_in'])->format('Y-m-d');
        $check_out = Carbon::createFromFormat('l d F Y', $search_data['check_out'])->format('Y-m-d');
        $rooms = '1';
        if (in_array($search_data['room_type'], [1, 2, 3])) {
            $adults = $search_data['room_type'];
        } else {
            $adults = '2';
        }
        $url = 'https://data.xotelo.com/api/rates?hotel_key=' . $hotel_id . '&chk_in=' . $check_in . '&chk_out=' . $check_out . '&rooms=' . $rooms . '&adults=' . $adults;
        logger($url);
        if (Cache::get($url)) {
            $response_body = Cache::get($url);
        } else {
            $response = Http::get($url);
            $response_body = $response->body();
        }
        logger($response_body);
        try {
            $results = json_decode($response_body, true);
            $result = $results['result']['rates'];
        } catch (\Throwable $t) {
            logger($t->getMessage());
            $result = [];
        }

        $no_data_text = 'Not available';
        $data = ['expedia' => $no_data_text, 'booking.com' => $no_data_text, 'hotels.com' => $no_data_text, 'agoda.com' => $no_data_text];
        foreach ($result as $hotel) {
            $hotel_name = strtolower($hotel['name']);
            if (in_array($hotel_name, array_keys($data))) {
                $data[$hotel_name] = $hotel['rate'];
                if ($default_currency != $search_data['currency']) {
                    $data[$hotel_name] = round(Currency::convertCurrency($default_currency, $search_data['currency'], $hotel['rate']), 2);
                }
            }
        }
        if (count(array_keys($data, $no_data_text)) != 4) {
            Cache::put($url, $response_body, now()->addMinutes(30));
        }
        return $data;
    }
}
