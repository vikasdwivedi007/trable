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
    <title>View Operating Statement</title>


    <!-- STYLE -->
    <link id="darkTheme" rel="stylesheet" href="{{asset('assets/css/pages/view-operating-statement.css')}}">

</head>

<body>

<div class="main">

    <table class="t1">
        <tbody>
        <tr>
            <td width="50%" class="bold md-font text-left">
                بيان بتوزيع التشغيلات بين مندوبي المطار لشهر
            </td>
            <td>
                <input type="text" value="{{\App\Helpers::arabicMonths($date->format('m'))}} {{$date->format('Y')}}" class="To bold md-font">
            </td>
        </tr>
        </tbody>
    </table>
    <table class="t2">
        <tbody>
        <tr>
            <td width="8.26%" height="20px" class="text-center bold border-left border-bottom">
                Date
            </td>
            @foreach($data as $day => $day_data)
                @if(!$loop->first)
                    @break
                @endif
                @foreach($day_data as $emp_id => $emp_data)
                <td width="8.26%" class="text-center bold border-left border-bottom">
                    <input type="text" class="text-center input3" value="{{$emp_data['name']}}" readonly="">
                </td>
                @endforeach
                @for($i=0;$i<10-count($day_data);$i++)
                    <td width="8.26%" class="text-center bold border-left border-bottom">
                        <input type="text" class="text-center input3" value="" readonly="">
                    </td>
                @endfor
            @endforeach
        </tr>

        @foreach($data as $day => $day_data)
        <tr>
            <td width="8.26%" height="20px" class="text-center bold border-left border-bottom">
                <input type="text" class="text-center input3" value="{{$day}}" readonly="">
            </td>
            @foreach($day_data as $emp_id => $emp_data)
            <td width="8.26%" class="text-center bold border-left border-bottom">
                <input type="text" class="text-center input3" value="{{$emp_data['file_no']}}" readonly="">
            </td>
            @endforeach
            @for($i=0;$i<10-count($day_data);$i++)
            <td width="8.26%" class="text-center bold border-left border-bottom">
                <input type="text" class="text-center input3" value="" readonly="">
            </td>
            @endfor
        </tr>
        @endforeach

        </tbody>

    </table>

    <table class="T0 text-center">
        <tbody>
        <tr class="">
            <td width="30%" class="bold prFont-14">
            </td>
            <td  width="20%" class="bold prFont-14 text-left">
                التوقيع:
            </td>
            <td width="20%" class="bold prFont-14">
                <input type="text" value="" class="To bold input1">
            </td>
            <td width="30%" class="bold prFont-14">
            </td>
        </tr>
        <tr class="">
            <td width="30%" class="bold prFont-14">
            </td>
            <td width="20%" class="bold prFont-14 text-left">
                التاريخ:
            </td>
            <td width="20%" class="bold prFont-14">
                <input type="text" value="{{\Carbon\Carbon::now()->format('d-m-Y')}}" class="To bold input1">
            </td>
            <td width="30%" class="bold prFont-14">
            </td>
        </tr>
        <tr class="">
            <td width="30%" class="bold prFont-14">
            </td>
            <td  width="20%" class="bold prFont-14 text-left">
                الوقت:
            </td>
            <td width="20%" class="bold prFont-14">
                <input type="text" value="{{\Carbon\Carbon::now()->format('H:i')}}" class="To bold input1">
            </td>
            <td width="30%" class="bold prFont-14">
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
