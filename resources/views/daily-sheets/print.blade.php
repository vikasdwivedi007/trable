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
    <title>View Daily Sheet</title>


    <!-- STYLE -->
    <link id="darkTheme" rel="stylesheet" href="{{asset('assets/css/pages/view-daily-sheet.css')}}">

</head>

<body>

<div class="main">


    <table class="w-100">
        <tbody>
        <tr>

            <td class="bold font-22">Voyageurs Du Monde</td>
            <td class="text-center bold">
                <input type="text" class="text-center input1" value="{{$dailySheet->city->name}}" readonly="">
            </td>
            <td class="bold prFont-14"></td>
            <td class="text-center bold">
              <div id="pageFooter"></div>   
            </td>
        </tr>
        <tr>
            <td class="bold prFont-14">Sheet Day</td>
            <td class="text-center bold">
                <input type="text" class="text-center input1" value="{{$dailySheet->date->format('l')}}" readonly="">
            </td>
            <td class="bold prFont-14">Date</td>
            <td class="text-center bold">
                <input type="text" class="text-center input1" value="{{$dailySheet->date->format('d/m/Y')}}" readonly="">
            </td>
        </tr>
        </tbody>
    </table>
    <table class="Table-64">
        <tbody>
        <tr>
            <td class="text-center bold border-right border-bottom" width="10%">File No.</td>
            <td class="text-center bold border-right border-bottom" width="10%">Travel Agent</td>
            <td class="text-center bold border-right border-bottom" width="5%">Pax No.</td>
            <td class="text-center bold border-right border-bottom" width="10%">Customer Name & Tel No.</td>
            <td class="text-center bold border-right border-bottom">Concierge Service</td>
            <td class="text-center bold border-right border-bottom">Number of Router</td>
            <td class="text-center bold border-right border-bottom">Flight No</td>
            <td class="text-center bold border-right border-bottom">Time</td>
            <td class="text-center bold border-right border-bottom">P.N.R</td>
            <td class="text-center bold border-right border-bottom">Hotel Name </td>
            <td class="text-center bold border-right border-bottom" width="20%">Itinerary</td>
            <td class="text-center bold border-right border-bottom" width="20%">Profile/Remark</td>
            <td class="text-center bold border-right border-bottom">Company of Transportation </td>
            <td class="text-center bold border-right border-bottom" width="10%">Driver Name & Tel No.</td>
            <td class="text-center bold border-right border-bottom" width="10%">Guide Name & Tel No. </td>
            <td class="text-center bold border-right border-bottom" width="10%">T. O Name  & Tel No.</td>
            <td class="text-center bold border-right border-bottom" width="10%">T. M Name & Tel No.</td>
        </tr>
        @foreach($dailySheet->job_files as $sheet_file)
        <tr>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$sheet_file->job_file->file_no}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$sheet_file->job_file->travel_agent->name}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$sheet_file->job_file->adults_count+$sheet_file->job_file->children_count}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$sheet_file->job_file->client_name}} {{$sheet_file->job_file->client_phone}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="@if($sheet_file->concierge) Yes @else No @endif" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$sheet_file->router_number}}" readonly="">
            </td>

            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$sheet_file->job_file->arrival_flight}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$sheet_file->job_file->arrival_date->format('H:i')}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$sheet_file->pnr}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{ $sheet_file->job_file->accommodations->count() ? $sheet_file->job_file->accommodations[0]->hotel->name : "" }}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$sheet_file->itinerary}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$sheet_file->remarks}}" readonly="">
            </td>

            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$sheet_file->transportation->name}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$sheet_file->driver_name}} {{$sheet_file->driver_phone}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$sheet_file->job_file->guides->count() ? $sheet_file->job_file->guides[0]->guide->name : ""}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$sheet_file->job_file->operator()->user->name}} {{$sheet_file->job_file->operator()->user->phone}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$sheet_file->representative->user->name}} {{$sheet_file->representative->user->phone}}" readonly="">
            </td>
        </tr>
        @endforeach


        </tbody>
    </table>



    <table class="Table-30 pt-10 mr-10">
        <tbody>
        <tr>
            <td class="bold prFont-14 border-right border-bottom">Traffic Manager</td>
            <td class="bold prFont-14 border-bottom">
                <input type="text" value="" class="To bold md-font prFont-14" readonly="">
            </td>
        </tr>
        <tr>
            <td class="bold prFont-14 border-right border-bottom">Date</td>
            <td class="bold border-bottom">
                <input type="text" value="{{\Carbon\Carbon::now()->format('d/m/Y')}}" class="To bold md-font prFont-14" readonly="">
            </td>

        </tr>
        <tr>
            <td class="bold prFont-14 border-right ">Timing</td>
            <td class="bold ">
                <input type="text" value="{{\Carbon\Carbon::now()->format('H:i')}}" class="To bold md-font prFont-14" readonly="">
            </td>

        </tr>
        </tbody>
    </table>

    <table class="Table-30 pt-10 mr-10">
        <tbody>
        <tr>
            <td class="bold prFont-14 border-right border-bottom">T.O</td>
            <td class="bold prFont-14 border-right border-bottom">
                <input type="text" value="" class="To bold md-font prFont-14" readonly="">
            </td>
            <td class="bold border-right border-bottom">
                <input type="text" value="" class="To bold md-font prFont-14" readonly="">
            </td>
        </tr>
        <tr>
            <td class="bold prFont-14 border-right border-bottom">T.O</td>
            <td class="bold border-right border-bottom">
                <input type="text" value="" class="To bold md-font prFont-14" readonly="">
            </td>
            <td class="bold border-right border-bottom">
                <input type="text" value="" class="To bold md-font prFont-14" readonly="">
            </td>

        </tr>
        <tr>
            <td class="bold prFont-14 border-right ">T.O</td>
            <td class="bold border-right">
                <input type="text" value="" class="To bold md-font prFont-14" readonly="">
            </td>
            <td class="bold">
                <input type="text" value="" class="To bold md-font prFont-14" readonly="">
            </td>

        </tr>
        </tbody>
    </table>

    <table class="Table-30 pt-10 ">
        <tbody>
        <tr>
            <td class="bold prFont-14 border-right border-bottom">Transferman</td>
            <td class="bold prFont-14 border-right border-bottom">
                <input type="text" value="" class="To bold md-font prFont-14" readonly="">
            </td>
            <td class="bold border-bottom">
                <input type="text" value="" class="To bold md-font prFont-14" readonly="">
            </td>
        </tr>
        <tr>
            <td class="bold prFont-14 border-right border-bottom">Transferman</td>
            <td class="bold border-right border-bottom">
                <input type="text" value="" class="To bold md-font prFont-14" readonly="">
            </td>
            <td class="bold border-right border-bottom">
                <input type="text" value="" class="To bold md-font prFont-14" readonly="">
            </td>

        </tr>
        <tr>
            <td class="bold prFont-14 border-right ">Transferman</td>
            <td class="bold border-right">
                <input type="text" value="" class="To bold md-font prFont-14" readonly="">
            </td>
            <td class="bold border-bottom">
                <input type="text" value="" class="To bold md-font prFont-14" readonly="">
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
