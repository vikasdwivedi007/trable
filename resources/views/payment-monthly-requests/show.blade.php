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
    <title>View Payment Monthly Request</title>


    <!-- STYLE -->
    <link id="darkTheme" rel="stylesheet" href="{{asset('assets/css/pages/view-payment-monthly-request.css')}}">

</head>

<body>

<div class="main">

    <table class="t1">
        <tbody>
        <tr>
            <td width="55%" class="bold text-left md-font">
                طلب صرف بدل عن كل ملف سياحي شهر
            </td>
            <td><input type="text" value="{{\App\Helpers::arabicMonths($payment_request->date->format('m'))}} {{$payment_request->date->format('Y')}}" class="To bold md-font"></td>
        </tr>
        </tbody>
    </table>

    <table class="t1">
        <tbody>
        <tr>
            <td width="40%" class="bold md-font">
                السادة / إدارة الحسابات العامة
            </td>

        </tr>
        <tr>
            <td width="40%" class="bold md-font">
                تحية طيبه وبعد،
            </td>

        </tr>


        </tbody>
    </table>

    <table class="t0 p-30">
        <tbody>

        <tr class="text-center">
            <td width="65%" class="bold text-left md-font">
                برجاء التكرم بصرف قيمة البدل عن كل ملف سياحي عن شهر
            </td>
            <td><input type="text" value="{{\App\Helpers::arabicMonths($payment_request->date->format('m'))}} {{$payment_request->date->format('Y')}}" class="To bold md-font"></td>
        </tr>



        </tbody>
    </table>

    <table class="t0">
        <tbody>



        <tr class="text-center">
            <td class="bold text-left md-font">
                عدد
            </td>
            <td><input type="text" value="{{$payment_request->files_count}}" class="To bold md-font"></td>
            <td class="bold text-left md-font">
                ملف
            </td>
            <td class="bold text-left md-font">
                ×
            </td>
            <td><input type="text" value="{{$payment_request->amount}}" class="To bold md-font"></td>
            <td class="bold text-left md-font">
                =
            </td>
            <td class="bold text-left md-font">
                بمبلغ
            </td>
            <td><input type="text" value="{{$payment_request->total}}" class="To bold md-font"></td>
            <td class="bold text-left md-font">
                جنيها
            </td>


        </tr>



        </tbody>
    </table>





    <table class="T0 p-30">
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
                <input type="text" value="{{$payment_request->request_date->format('d-m-Y')}}" class="To bold md-font">
            </td>
            <td width="50%" class="bold prFont-14">

            </td>
        </tr>
        </tbody>
    </table>
    <table class="T0 p-30">
        <tbody>
        <tr>
            <td width="50%" class="bold prFont-14">
                روجع بواسطة
            </td>
            <td width="50%" class="bold prFont-14 text-center">
                اعتماد / المدير العام
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
