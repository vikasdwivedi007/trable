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
    <title>View Work Order</title>


    <!-- STYLE -->
    <link id="darkTheme" rel="stylesheet" href="{{asset('assets/css/pages/view-work-order.css')}}">

</head>

<body>

<div class="main">

    <table class="t1">
        <tbody>
        <tr class="border-top">
            <td colspan="6" class="pt-50"></td>
        </tr>
        <tr>
            <td colspan="2"  class="logo-form">
                <img src="{{asset('assets/images/logo-dark.png')}}">
            </td>
            <td colspan="2" class="serial md-font text-center">
                {{sprintf("%03d", $workOrder->id)}}
            </td>
            <td colspan="2" class="logo-form">
                <img src="{{asset('assets/images/logo-dark.png')}}">
            </td>


        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="6" class="text-center bold prFont-20 p-50">
                أمر تشغيل مندوب
            </td>
        </tr>
        <tr>
            <td class="pr-100 pb-20">

                <p type="text" class="input1 md-font" readonly="">
                    أسم المندوب:
                </p>
            </td>
            <td colspan="5" class="pb-20">
                <input type="text" value="{{$workOrder->representative->user->name}}" class="input1 md-font" readonly="">
            </td>
        </tr>

        <tr>
            <td class="pr-100 pb-20">

                <p type="text" class="input1 md-font" readonly="">
                    أسم العميل:
                </p>
            </td>
            <td colspan="5" class="pb-20">
                <input type="text" value="{{$workOrder->job_file->client_name}}" class="input1 md-font" readonly="">
            </td>
        </tr>
        <tr>
            <td class="pr-100 pb-20">

                <p type="text" class="input1 md-font" readonly="">
                    عدد السياح:
                </p>
            </td>
            <td colspan="5" class="pb-20">
                <input type="text" value="{{$workOrder->job_file->adults_count + $workOrder->job_file->children_count}}" class="input1 md-font" readonly="">
            </td>
        </tr>

        <tr>
            <td class="pr-100 pb-20">

                <p type="text" class="input1 md-font" readonly="">
                    الجنسية:
                </p>
            </td>
            <td colspan="5" class="pb-20">
                <input type="text" value="{{$workOrder->job_file->country->name}}" class="input1 md-font" readonly="">
            </td>
        </tr>
        <tr>
            <td class="pr-100 pb-20">
                <p type="text" class="input1 md-font" readonly="">
                    رقم الرحلة:
                </p>
            </td>
            <td class="pb-20">
                <input type="text" value="{{$workOrder->job_file->arrival_flight}}" class="input1 md-font" readonly="">
            </td>
            <td class="pb-20">
                <p type="text" class="input1 md-font" readonly="">
                    قادمة من:
                </p>
            </td>
            <td class="pb-20">
                <p type="text" class="input1 md-font" readonly="">
                    <input type="text" value="{{$workOrder->job_file->country->name}}" class="input1 md-font" readonly="">
                </p>
            </td>
            <td class="pb-20">
                <p type="text" class="input1 md-font" readonly="">
                    متجهة إلي:
                </p>
            </td>
            <td class="pb-20">
                <p type="text" class="input1 md-font" readonly="">
                    <input type="text" value="{{$workOrder->job_file->airport_to_formatted['text']}}" class="input1 md-font" readonly="">
                </p>
            </td>
        </tr>

        <tr>
            <td class="pr-100 pb-20">

                <p type="text" class="input1 md-font" readonly="">
                    موعد الوصول / السفر:
                </p>
            </td>
            <td colspan="5" class="pb-20">
                <input type="text" value="{{$workOrder->job_file->arrival_date->format('d/m/Y H:i')}}" class="input1 md-font" readonly="">
            </td>
        </tr>
        <tr>
            <td class="pr-100 pb-20">

                <p type="text" class="input1 md-font" readonly="">
                    التشغيل:
                </p>
            </td>
            <td colspan="5" class="pb-20">
                <input type="text" value="" class="input1 md-font" readonly="">
            </td>
        </tr>
        <tr>
            <td class="pr-100 pb-20">

                <p type="text" class="input1 md-font" readonly="">
                    ملف رقم:
                </p>
            </td>
            <td colspan="5" class="pb-20">
                <input type="text" value="{{$workOrder->job_file->file_no}}" class="input1 md-font" readonly="">
            </td>
        </tr>
        <tr>
            <td class="pr-100 pb-20">

                <p type="text" class="input1 md-font" readonly="">
                    التاريخ:
                </p>
            </td>
            <td colspan="5" class="pb-20">
                <input type="text" value="{{$workOrder->date->format('d/m/Y')}}" class="input1 md-font" readonly="">
            </td>
        </tr>
        <tr>
            <td class="pr-100 pb-20">

                <p type="text" class="input1 md-font" readonly="">
                    رقم تليفون المندوب:
                </p>
            </td>
            <td colspan="5" class="pb-20">
                <input type="text" value="{{$workOrder->representative->user->phone}}" class="input1 md-font" readonly="">
            </td>
        </tr>
        <tr>
            <td colspan="4">
            </td>
            <td class="pb-20">
                <p type="text" class="input1 md-font" readonly="">
                    إدارة الحركة:
                </p>
            </td>
            <td class="pb-20">
                <input type="text" value="" class="input1 md-font" readonly="">
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
