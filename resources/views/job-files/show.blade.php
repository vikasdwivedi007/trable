<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <!-- ROBOTS -->
    <meta name="robots" content="noindex,nofollow">

    <!-- INTERNET EXPLORER COMPATIBILITY -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- MOBILE FIRST -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FAVICON -->
    <link rel="icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon">

    <!-- TITLE -->
    <title>View Job File {{$job_file->file_no}}</title>


    <!-- STYLE -->
    <link id="darkTheme" rel="stylesheet" href="{{asset('assets/css/pages/view-job-file.css')}}">

</head>

<body>

<div class="main">
    <table class="T2">
        <tbody>
        <tr>
            <td width="16%" class="bold small-font">
                File No. :
            </td>
            <td>
                <input type="text" class="To bold md-font" readonly="" value="{{$job_file->file_no}}">
            </td>
            <td width="16%" class="bold small-font">
                Travel Agent:
            </td>
            <td>
                <input type="text" value="{{$job_file->travel_agent->name}}" class="To bold md-font">
            </td>
        </tr>
        <tr>
            <td width="16%" class="bold small-font">Invoice No. :</td>
            <td><input type="text" value="" class="To bold md-font"></td>

            <td width="16%" class="bold small-font">Command No. :</td>
            <td><input type="text" value="{{$job_file->command_no}}" class="To bold md-font"></td>
        </tr>
        </tbody>
    </table>


    <table class="Table-half" height="238">
        <tbody>
        <tr>
            <td width="25%" class="bold small-font">
                Name:
            </td>
            <td width="25%"><input type="text" value="{{$job_file->client_name}}" class="To bold md-font"></td>
            <td width="20%">
            </td>
            <td width="20%"></td>
        </tr>

        <tr>
            <td width="20%" class="bold small-font">
                No. of Adult:
            </td>
            <td width="40%"><input type="text" value="{{$job_file->adults_count}}" class="To bold md-font" readonly=""></td>
            <td width="80%" class="bold folat-right small-font">
                No. of Child:
            </td>
            <td width="20%"><input type="text" value="{{$job_file->children_count}}" class="To bold md-font" readonly=""></td>
        </tr>
        <tr>
            <td width="20%" class="bold small-font">
                Arrival Date:
            </td>
            <td><input type="text" value="{{$job_file->arrival_date->format('d/m/Y')}}" class="To bold md-font" readonly=""></td>
            <td>
            </td>
            <td></td>
        </tr>
        <tr>
            <td width="20%" class="bold small-font">
                Arrival by:
            </td>
            <td><input type="text" value="{{$job_file->arrival_flight}} @ {{$job_file->arrival_date->format('H:i')}}" class="To bold md-font" readonly=""></td>
        </tr>
        <tr>
            <td width="20%" class="bold small-font">
                Departure Date:
            </td>
            <td><input type="text" value="{{$job_file->departure_date->format('d/m/Y')}}" class="To bold md-font" readonly=""></td>
            <td>
            </td>
            <td></td>
        </tr>
        <tr>
            <td width="20%" class="bold small-font">
                Departure by:
            </td>
            <td><input type="text" value="{{$job_file->departure_flight}} @ {{$job_file->departure_date->format('H:i')}}" class="To bold md-font" readonly=""></td>
        </tr>
        </tbody>
    </table>
    <table class="Table-half xHeight">
        <tbody>
        <tr>
            <td width="16%" class="bold small-font">Guide Name:
            </td>
            <td><input type="text" @if($job_file->guides->count())value="{{$job_file->guides->get(0)->guide->name}}"@endif class="To bold md-font"></td>
        </tr>
        <tr>
            <td width="16%" class="bold small-font">Tel No.:</td>
            <td><input type="text" @if($job_file->guides->count())value="{{$job_file->guides->get(0)->guide->phone}}"@endif class="To bold md-font" readonly=""></td>
        </tr>
        <tr>
            <td width="16%" class="bold small-font">Language:</td>
            <td>
                <input type="text" @if($job_file->guides->count())value="{{$job_file->guides->get(0)->guide->languages_str}}"@endif class="To bold md-font" readonly="">
            </td>
        </tr>
        <tr>
            <td width="16%" class="bold small-font">City</td>
            <td class="bold text-center small-font">
                Visits
            </td>
        </tr>
        @foreach($job_file->guides as $tour)
        <tr>
            <td width="16%">
                <input type="text" value="{{$tour->city->name}}" class="To bold md-font" readonly="">
            </td>
            <td>
                <input type="text" value="{{$tour->date->format('d/m')}} - {{$tour->sightseeing->name}}" class="To bold md-font" readonly="">
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <table class="Table-75 mx-h250">
        <tbody>
        <tr>
            <td class="bold small-font">
                Profiling
            </td>
        </tr>
        <tr>
            <td>
              <textarea rows="3" cols="148" value="" class="textarea" readonly="">{{$job_file->profiling}}</textarea>
            </td>
        </tr>
        <tr>
            <td class="bold small-font">
                Mobile No. :
            </td>


        </tr>
        <tr>
        <td><input type="text" value="{{$job_file->client_phone}}" class="To bold md-font" readonly=""></td>
        </tr>
        <tr>
            <td class="bold small-font">
                Remarks
            </td>
        </tr>
        <tr>
            <td>
              <textarea rows="5" cols="148" value="" class="textarea redcolor" readonly="">{{$job_file->remarks}}</textarea>
            </td>
        </tr>

        </tbody>
    </table>
    <table class="Table-25">
        <tbody>
        <tr>
            <td class="bold small-font">Notify Police</td>
        </tr>
        <tr>
            <td>
                <input type="text" class="text-center input1" value="@if($job_file->notify_police) ✔ @endif" readonly="">
            </td>
        </tr>
        <tr>
            <td class="bold small-font">Service Conciergerie</td>
        </tr>
        <tr>
            <td>
                <input type="text" class="text-center input1" value="@if($job_file->concierge_emp) {{$job_file->concierge_emp->user->name}} ✔ @endif" readonly="">
            </td>
        </tr>
        <tr>
            <td class="bold small-font">Router</td>
        </tr>
        <tr>
            <td>
                <input type="text" class="text-center input1" value="@if($job_file->router) {{$job_file->job_router->router->number}} ✔ @endif" readonly="">
            </td>
        </tr>
        <tr>
            <td class="bold small-font">Pro-forma</td>
        </tr>
        <tr>
            <td>
                <input type="text" class="text-center input1" value="@if($job_file->proforma) ✔ @endif" readonly="">
            </td>
        </tr>
        <tr>
            <td class="bold small-font">Visa</td>
        </tr>
        <tr>
            <td>
                <input type="text" class="text-center input1" value="@if($job_file->job_visa) {{$job_file->job_visa->visa->name}} ✔ @endif" readonly="">
            </td>
        </tr>
        <tr>
            <td class="bold small-font">Gifts</td>
        </tr>
        <tr>
            <td>
                <input type="text" class="text-center input1" value="@if($job_file->job_gifts->count())
                {{join('/', $job_file->job_gifts->map(function($job_gift){return $job_gift->gift->name;})->toArray())  }}
                @endif" readonly="">
            </td>
        </tr>

        </tbody>
    </table>
    <table class="w-100">
        <tbody>
        <tr>
            <td class="text-center bold prFont-14">Accommodations</td>
        </tr>
        </tbody>
    </table>
    <table class="Table-64">
        <tbody>
        <tr>
            <td width="10%" class="text-center bold border-right">City</td>
            <td width="20%" class="text-center bold border-right">Hotels</td>
            <td width="10%" class="text-center bold border-right">In</td>
            <td width="10%" class="text-center bold border-right">Out</td>
            <td colspan="2" class="text-center bold border-right">Room</td>
            <td width="10%" class="text-center bold border-right">St</td>
            <td width="10%" class="text-center bold border-right">Pay</td>
        </tr>

        <tr>
            <td width="10%" class="text-center bold ttd5a"></td>
            <td width="20%" class="text-center bold ttd5a"></td>
            <td width="10%" class="text-center bold ttd5a"></td>
            <td width="10%" class="text-center bold ttd5a"></td>
            <td width="15%" class="text-center bold border-bottom">Type</td>
            <td width="15%" class="text-center bold ttd5a">Category</td>
            <td width="10%" class="text-center bold ttd5a"></td>
            <td width="10%" class="text-center bold ttd5a"></td>
        </tr>

        @php $acc_rows_count = 0;@endphp
        @foreach($job_file->accommodations as $acc)
            @php $acc_rows_count++; @endphp
            @php
            $acc_data[$acc->check_in->format('U')] = [$acc->hotel->city->name, $acc->hotel->name, $acc->check_in->format('d/m'), $acc->check_out->format('d/m'), \App\Models\Room::room_types($acc->room_type), $acc->view, $acc->situation, $acc->payment];
            @endphp
        @endforeach

        @foreach($job_file->nile_cruises as $job_cruise)
            @foreach($job_cruise->cabins as $cabin)
                @php $acc_rows_count++; @endphp
                @php
                    $acc_data[$job_cruise->nile_cruise->date_from->format('U')] = [$job_cruise->nile_cruise->from_city->name, $job_cruise->nile_cruise->name, $job_cruise->nile_cruise->date_from->format('d/m'), $job_cruise->nile_cruise->date_to->format('d/m'), App\Models\NileCruise::room_types($job_cruise->room_type), "", "", ""];
                @endphp
            @endforeach
        @endforeach

        @php ksort($acc_data); @endphp
        @foreach($acc_data as $row)
            <tr>
                <td width="10%" class="text-center bold ttd5a">
                    <input type="text" class="text-center input1" value="{{$row[0]}}" readonly="">
                </td>
                <td width="20%" class="text-center bold ttd5a">
                    <input type="text" class="text-center input1" value="{{$row[1]}}" readonly="">
                </td>
                <td width="10%" class="text-center bold ttd5a">
                    <input type="text" class="text-center input1" value="{{$row[2]}}" readonly="">
                </td>
                <td width="10%" class="text-center bold ttd5a">
                    <input type="text" class="text-center input1" value="{{$row[3]}}" readonly="">
                </td>
                <td width="15%" class="text-center bold ttd5a">
                    <input type="text" class="text-center input1" value="{{$row[4]}}" readonly="">
                </td>
                <td width="15%" class="text-center bold ttd5a">
                    <input type="text" class="text-center input1" value="{{$row[5]}}" readonly="">
                </td>
                <td width="10%" class="text-center bold ttd5a">
                    <input type="text" class="text-center input1" value="{{$row[6]}}" readonly="">
                </td>
                <td width="10%" class="text-center bold ttd5a">
                    <input type="text" class="text-center input1" value="{{$row[7]}}" readonly="">
                </td>
            </tr>
        @endforeach

        @foreach($job_file->train_tickets as $job_train)
            @php $acc_rows_count++; @endphp
            <tr>
                <td width="10%" class="text-center bold ttd5a">
                    <input type="text" class="text-center input1" value="{{$job_train->train_ticket->from_station->name}}" readonly="">
                </td>
                <td width="20%" class="text-center bold ttd5a">
                    <input type="text" class="text-center input1" value="Train-{{$job_train->train_ticket->number}}" readonly="">
                </td>
                <td width="10%" class="text-center bold ttd5a">
                    <input type="text" class="text-center input1" value="{{$job_train->train_ticket->depart_at->format('d/m')}}" readonly="">
                </td>
                <td width="10%" class="text-center bold ttd5a">
                    <input type="text" class="text-center input1" value="{{$job_train->train_ticket->arrive_at->format('d/m')}}" readonly="">
                </td>
                <td width="15%" class="text-center bold ttd5a">
                    <input type="text" class="text-center input1" value="{{$job_train->train_ticket->wagon_no.'/'.$job_train->train_ticket->seat_no}}" readonly="">
                </td>
                <td width="15%" class="text-center bold ttd5a">
                    <input type="text" class="text-center input1" value="{{$job_train->train_ticket->class == 1 ? 'First Class' : 'Second Class'}}" readonly="">
                </td>
                <td width="10%" class="text-center bold ttd5a">
                    <input type="text" class="text-center input1" value="" readonly="">
                </td>
                <td width="10%" class="text-center bold ttd5a">
                    <input type="text" class="text-center input1" value="" readonly="">
                </td>
            </tr>
        @endforeach

        @for($i=0;$i<8-$acc_rows_count;$i++)
        <tr>
            <td width="10%" class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="" readonly="">
            </td>
            <td width="20%" class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="" readonly="">
            </td>
            <td width="10%" class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="" readonly="">
            </td>
            <td width="10%" class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="" readonly="">
            </td>
            <td width="15%" class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="" readonly="">
            </td>
            <td width="15%" class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="" readonly="">
            </td>
            <td width="10%" class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="" readonly="">
            </td>
            <td width="10%" class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="" readonly="">
            </td>
        </tr>
        @endfor
        </tbody>
    </table>
    <table class="Table-36" height="302">
        <tbody>
        <tr height="53">
            <td colspan="2" class="text-center bold border-bottom">Services request</td>
{{--            <td class="text-center bold border-bottom"></td>--}}
        </tr>
        @php $program = []; @endphp
        @foreach($job_file->programs as $prog)
            @foreach($prog->items as $item)
                @php $program[substr($prog->city->name, 0, 3)][] = ['date'=>$prog->day->format('d/m'), 'item'=>$item]; @endphp
            @endforeach
        @endforeach
        @foreach($program as $city => $items)
            <tr>
                <td width="10%" class="cities_chr">
                    <input type="text" class="To bold md-font" value="{{$city}}" readonly="">
                </td>
                <td></td>
            </tr>
            @foreach($items as $item)
            <tr>
                <td width="10%" class="">
                    <input type="text" class="To" value="{{$item['date']}}" readonly="">
                </td>
                <td class="">
                    <input type="text" class="To bold" value="{{$item['item']->name}}" readonly="">
                </td>
            </tr>
            @endforeach
        @endforeach



        </tbody>
    </table>
    <table class="w-100">
        <tbody>
        <tr>
            <td class="text-center bold prFont-14">Domestic Flight</td>
        </tr>
        </tbody>
    </table>
    <table class="T2">
        <tbody>
        <tr>
            <td width="15%" class="text-center bold border-right">Date</td>
            <td width="15%" class="text-center bold border-right">Flight No.</td>
            <td width="10%" colspan="2" class="text-center bold border-right">Sector</td>
            <td width="10%" colspan="2" class="text-center bold border-right">Sector</td>
            <td width="10%" class="text-center bold border-right">No of Seats</td>
            <td width="10%" class="text-center bold border-right">Situation</td>
            <td width="10%" class="text-center bold ">Reference</td>
        </tr>
        <tr>
            <td width="15%" class="text-center bold border-right "></td>
            <td width="15%" class="text-center bold border-right "></td>
            <td width="10%" class="text-center bold ">From</td>
            <td width="10%" class="text-center bold border-right ">Dep at</td>
            <td width="10%" class="text-center bold ">To</td>
            <td width="10%" class="text-center bold border-right ">Arr  at</td>
            <td width="10%" class="text-center bold border-right "></td>
            <td width="10%" class="text-center bold border-right "></td>
            <td width="10%" class="text-center bold"></td>
        </tr>
        @foreach($job_flights['domestic'] as $flight)

        <tr>
        <td width="20%" class="text-center bold border-right  border-top">
            <input type="text" class="text-center input1" value="{{$flight->flight->date->format('d/m')}}" readonly="">
        </td>
        <td width="10%" class="text-center bold border-right  border-top">
            <input type="text" class="text-center input1" value="{{$flight->flight->number}}" readonly="">
        </td>
        <td width="10%" class="text-center bold border-right  border-top">
            <input type="text" class="text-center input1" value="{{$flight->flight->airport_from->city}}" readonly="">
        </td>
        <td width="10%" class="text-center bold border-right  border-top">
            <input type="text" class="text-center input1" value="{{$flight->flight->toArray()['depart_at']}}" readonly="">
        </td>
        <td width="15%" class="text-center bold border-right  border-top">
            <input type="text" class="text-center input1" value="{{$flight->flight->airport_to->city}}" readonly="">
        </td>
        <td width="15%" class="text-center bold border-right  border-top">
            <input type="text" class="text-center input1" value="{{$flight->flight->toArray()['arrive_at']}}" readonly="">
        </td>
        <td width="10%" class="text-center bold border-right  border-top">
            <input type="text" class="text-center input1" value="{{$flight->flight->seats_count}}" readonly="">
        </td>
        <td width="10%" class="text-center bold border-right  border-top">
            <input type="text" class="text-center input1" value="{{\App\Models\Flight::availableStatus()[$flight->flight->status]}}" readonly="">
        </td>
        <td width="10%" class="text-center bold border-top">
            <input type="text" class="text-center input1" value="{{$flight->flight->reference}}" readonly="">
        </td>
    </tr>
    @endforeach
    @for($i=0;$i<3-count($job_flights['domestic']);$i++)
    <tr>
        <td width="20%" class="text-center bold border-right  border-top">
            <input type="text" class="text-center input1" value="" readonly="">
        </td>
        <td width="10%" class="text-center bold border-right  border-top">
            <input type="text" class="text-center input1" value="" readonly="">
        </td>
        <td width="10%" class="text-center bold border-right  border-top">
            <input type="text" class="text-center input1" value="" readonly="">
        </td>
        <td width="10%" class="text-center bold border-right  border-top">
            <input type="text" class="text-center input1" value="" readonly="">
        </td>
        <td width="15%" class="text-center bold border-right  border-top">
            <input type="text" class="text-center input1" value="" readonly="">
        </td>
        <td width="15%" class="text-center bold border-right  border-top">
            <input type="text" class="text-center input1" value="" readonly="">
        </td>
        <td width="10%" class="text-center bold border-right  border-top">
            <input type="text" class="text-center input1" value="" readonly="">
        </td>
        <td width="10%" class="text-center bold border-right  border-top">
            <input type="text" class="text-center input1" value="" readonly="">
        </td>
        <td width="10%" class="text-center bold border-top">
            <input type="text" class="text-center input1" value="" readonly="">
        </td>
    </tr>
    @endfor
        </tbody>
    </table>

    <table class="w-100 pt-10">
        <tbody>
        <tr>
            <td class="bold prFont-14">Operator in charge:</td>
            <td class="bold prFont-14">
                <input type="text" value="{{$job_file->operator()->user->name}}" class="To bold md-font prFont-14" readonly="">
            </td>
            <td class="bold prFont-14">Date Request:</td>
            <td class="bold">
                <input type="text" value="{{$job_file->request_date->format('d/m/Y')}}" class="To bold md-font prFont-14" readonly="">
            </td>
        </tr>
        <tr>
            <td class="bold prFont-14">Operator in charge abroad:</td>
            <td class="bold">
                <input type="text" value="@if($job_file->travel_agent && $job_file->travel_agent->contacts->count()){{$job_file->travel_agent->contacts->first()->name}}@endif" class="To bold md-font prFont-14" readonly="">
            </td>
            <td class="bold prFont-14">Reviewed by:</td>
            <td class="bold">
                <input type="text" value="@if($job_file->reviews->get(0)) {{$job_file->reviews->get(0)->reviewed_by_emp->user->name}} @endif" class="To bold md-font prFont-14" readonly="">
            </td>
        </tr>
        <tr>
            <td class="bold"></td>
            <td class="bold"></td>
            <td class="bold prFont-14">Reviewed by:</td>
            <td class="bold">
                <input type="text" value="@if($job_file->reviews->get(1)) {{$job_file->reviews->get(1)->reviewed_by_emp->user->name}} @endif" class="To bold md-font prFont-14" readonly="">
            </td>
        </tr>
        </tbody>
    </table>


</div>


<!-- END BODY -->
@if(request('print'))
<script src="{{asset('assets/js/vendor-all.min.js')}}"></script>
<script>
    $(document).ready(function () {
        window.print();
    });
</script>
@endif

<!-- END HTML DOCUMENT -->
</body>

</html>
