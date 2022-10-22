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
    <title>View Operator Operaval</title>


    <!-- STYLE -->
    <link id="darkTheme" rel="stylesheet" href="{{asset('assets/css/pages/view-operator-approval.css')}}">

</head>

<body>

<div class="main">


    <table class="w-100">
        <tbody>
        <tr>
            <td class="bold font-22 text-center">
                نموذج موافقة موظف منظم برامج سياحية
                لتنفيذ تشغيلة لقسم الحركة
            </td>
        </tr>
        </tbody>
    </table>
    <table class="Table-100 pt-10">
        <tbody>
        <tr>
            <td class="text-center bold" width="7%"></td>
            <td class="text-center bold border-right border-top border-left" width="14.5%">
                <input type="text" class="text-center input1" value="{{$data[0]->operator->user->name}}" readonly="">
            </td>

            <!-- <td class="text-center bold" width="10%"></td>
            <td class="text-center bold" width="5%"></td> -->
            <td class="text-center bold"></td>
            <td class="text-center bold"></td>
            <td class="text-center bold"></td>
            <td class="text-center bold"></td>
            <td class="text-center bold"></td>
            <td class="text-center bold"></td>
            <td class="text-center bold" width="20%"></td>
            <td class="text-center bold" width="20%"></td>
            <td class="text-center bold"></td>
            <td class="text-center bold" width="10%"></td>
            <td class="text-center bold" width="10%"></td>
            <td class="text-center bold" width="10%"></td>
            <td class="text-center bold" width="10%"></td>
            <td class="text-center bold" width="10%"></td>
            <td class="text-center bold" width="10%"></td>
        </tr>
        </tbody>
    </table>
    <table class="Table-64">
        <tbody>

        <tr>
            <td class="text-center bold border-right border-bottom" width="15%">Date</td>
            <td class="text-center bold border-right border-bottom" width="10%">File No.</td>
            <td class="text-center bold border-right border-bottom" width="10%">Travel Agent</td>
            <td class="text-center bold border-right border-bottom" width="5%">Pax No.</td>
            <td class="text-center bold border-right border-bottom" width="10%">Customer Name & Tel No.</td>
            <td class="text-center bold border-right border-bottom">Concierge Service</td>
            <td class="text-center bold border-right border-bottom">Number of Router</td>
            <td class="text-center bold border-right border-bottom">Flight No</td>
            <td class="text-center bold border-right border-bottom">Time</td>
            <td class="text-center bold border-right border-bottom">P.N.R</td>
            <td class="text-center bold border-right border-bottom" width="20%">Itinerary</td>
            <td class="text-center bold border-right border-bottom" width="20%">Profile/Remark</td>
            <td class="text-center bold border-right border-bottom">Company of Transportation </td>
            <td class="text-center bold border-right border-bottom" width="10%">Driver Name & Tel No.</td>
            <td class="text-center bold border-right border-bottom" width="10%">Guide Name & Tel No. </td>
            <td class="text-center bold border-right border-bottom" width="10%">T. O Name  & Tel No.</td>
            <td class="text-center bold border-right border-bottom" width="10%">T. M Name & Tel No.</td>
            <td class="text-center bold border-right border-bottom">Yes</td>
            <td class="text-center bold border-right border-bottom">No</td>
        </tr>
        @foreach($data as $assignment)
        <tr>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$assignment->date->format('d/m/Y')}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$assignment->job_file->file_no}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$assignment->job_file->travel_agent->name}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$assignment->job_file->adults_count + $assignment->job_file->children_count}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$assignment->job_file->client_name}} {{$assignment->job_file->client_phone}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" @if($assignment->daily_sheet)value="{{$assignment->daily_sheet->concierge ? 'Yes' : "No"}}" @endif readonly="">
            </td>

            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$assignment->router_number}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$assignment->job_file->arrival_flight}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$assignment->job_file->arrival_date->format('H:i')}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$assignment->daily_sheet ? $assignment->daily_sheet->pnr : ""}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$assignment->itinerary}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$assignment->remarks}}" readonly="">
            </td>

            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$assignment->daily_sheet ? $assignment->daily_sheet->transportation->name : ""}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$assignment->daily_sheet ? $assignment->daily_sheet->driver_name .' '.$assignment->daily_sheet->driver_phone : ""}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$assignment->job_file->guides->count() ? $assignment->job_file->guides[0]->guide->name.' '.$assignment->job_file->guides[0]->guide->phone : ""}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$assignment->operator->user->name}} {{$assignment->operator->user->phone}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="{{$assignment->daily_sheet ? $assignment->daily_sheet->representative->user->name.' '.$assignment->daily_sheet->representative->user->phone : ""}}" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="@if($assignment->status == \App\Models\OperatorAssignment::STATUS_APPROVED) ✔ @endif" readonly="">
            </td>
            <td class="text-center bold ttd5a">
                <input type="text" class="text-center input1" value="@if($assignment->status == \App\Models\OperatorAssignment::STATUS_DENIED) ✔ @endif" readonly="">
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
                <input type="text" value="" class="To bold md-font prFont-14" readonly="">
            </td>

        </tr>
        <tr>
            <td class="bold prFont-14 border-right ">Timing</td>
            <td class="bold ">
                <input type="text" value="" class="To bold md-font prFont-14" readonly="">
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
<script src="{{asset('assets/js/vendor-all.min.js')}}"></script>
<script>
    $(document).ready(function () {
        window.print();
    });
</script>
<!-- END HTML DOCUMENT -->
</body>

</html>
