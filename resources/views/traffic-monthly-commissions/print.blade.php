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
    <title>View Commission Monthly</title>


    <!-- STYLE -->
    <link id="darkTheme" rel="stylesheet" href="{{asset('assets/css/pages/view-commission-monthly.css')}}">

</head>

<body>

<div class="main">

    <table class="t1">
        <tbody>
        <tr>
            <td width="40%" class="bold md-font">
                السادة / قسم الحسابات
            </td>

        </tr>
        <tr class="text-center">
            <td width="50%" class="bold text-center md-font">
                ملفات شهر
            </td>
            <td><input type="text" value="{{\App\Helpers::arabicMonths($date->format('m'))}} {{$date->format('Y')}}" class="To bold md-font"></td>
        </tr>

        </tbody>
    </table>
    <table class="t1">
        <tbody>
        <tr>
            <td width="100%" class="bold text-center md-font">
                قسم الحركة
            </td>
        </tr>
        </tbody>
    </table>

    <table class="t1">
        <tbody>
        <tr>
            <td width="10%" class="text-center bold border-right border-left border-bottom border-top">المسلسل</td>
            <td width="30%" class="text-center bold border-right border-left border-bottom border-top">رقم الملف</td>
            <td width="60%" class="text-center bold border-right border-left border-bottom border-top">القيمة</td>


        </tr>

        @php $total = 0; @endphp
        @foreach($commissions as $commission)
            @php $total += $commission->amount; @endphp
            <tr>
                <td width="15%" class="text-center bold border-right border-left border-bottom">
                    <input type="text" class="text-center input1" value="{{$loop->index+1}}" readonly="">
                </td>
                <td width="15%" class="text-center bold border-right border-left border-bottom">
                    <input type="text" class="text-center input1" value="{{$commission->job_file->file_no}}" readonly="">
                </td>
                <td width="70%" class="text-center bold border-right border-left border-bottom">

                <textarea rows="3" cols="148" value="" class="textarea" readonly="">
                    &nbsp;{{$commission->amount}}
                </textarea>
                </td>

            </tr>
        @endforeach
        <tr>
            <td width="10%" class="text-center bold "></td>
            <td width="30%" class="text-left bold border-right border-bottom">مبلغ وقدره /</td>
            <td width="60%" class="text-right bold border-right border-bottom border-left">
                <input type="text" value="{{$total}}" class="To bold md-font">
            </td>
        </tr>
    </tbody>

    </table>
    <table class="T0">
        <tbody>
        <tr>
            <td width="50%" class="bold prFont-14"></td>
            <td width="30%" class="bold prFont-14 text-center">
                مقدمه لسيادتكم
            </td>
        </tr>
        <tr>
            <td width="50%" class="bold prFont-14"></td>
            <td width="30%" class="bold prFont-14">
                <input type="text" value="" class="To bold md-font  text-center">
            </td>
        </tr>
        </tbody>
    </table>
    <table class="T0">
        <tbody>
        <tr>
            <td class="bold prFont-14">
                تحريرا فى:
            </td>
            <td class="bold prFont-14">
                <input type="text" value="{{\Carbon\Carbon::now()->format('d-m-Y')}}" class="To bold md-font">
            </td>
            <td width="50%" class="bold prFont-14">

            </td>
        </tr>
        </tbody>
    </table>
    <table class="T0">
        <tbody>
        <tr>
            <td width="50%" class="bold prFont-14">
                إدارة الحسابات العامة
            </td>
            <td width="50%" class="bold prFont-14 text-center">
                اعتماد / المدير العام
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
