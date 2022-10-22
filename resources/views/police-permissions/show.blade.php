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
    <title>View Police Permission</title>


    <!-- STYLE -->
    <link id="darkTheme" rel="stylesheet" href="{{asset('assets/css/pages/view-police-permission.css')}}">

</head>

<body>

<div class="main">


    <table class="Table-35">
        <tbody>
        <tr>
            <td width="30%" class="bold">أسم الشركة:
            </td>

            <td><input type="text" value="{{$policePermission->travel_agent_ar}}" class="To bold md-font"></td>
        </tr>
        </tbody>
    </table>
    <table class="Table-30">
        <tbody>
        <tr>
            <td width="30%" class="bold">رقم الملف:
            </td>
            <td><input type="text" value="{{$policePermission->job_file->file_no}}" class="To bold md-font"></td>
        </tr>
        </tbody>
    </table>
    <table class="Table-35">
        <tbody>
        <tr>
            <td width="30%" class="bold">رقم السيارة:
            </td>
            <td><input type="text" value="{{$policePermission->car_no}}" class="To bold md-font"></td>
        </tr>
        </tbody>
    </table>
    <table class="Table-35" height="54">
        <tbody>
        <tr>
            <td width="30%" class="bold">أسم الفوج:
            </td>

            <td><input type="text" value="{{$policePermission->client_name_ar}}" class="To bold md-font"></td>
        </tr>
        </tbody>
    </table>
    <table class="Table-30" height="54">
        <tbody>
        <tr>
            <td width="30%" class="bold">الجنسية:
            </td>
            <td><input type="text" value="{{$policePermission->nationality_ar}}" class="To bold md-font"></td>
        </tr>
        </tbody>
    </table>
    <table class="Table-35">
        <tbody>
        <tr>
            <td width="30%" class="bold py-3">أسم السائق:
            </td>
            <td class="py-3"><input type="text" value="{{$policePermission->driver->driver_name_ar ?: $policePermission->driver->driver_name_ar}}" class="To bold md-font"></td>
        </tr>
        <tr>
            <td width="30%" class="bold py-3">رقم الهاتف:
            </td>
            <td class="py-3"><input type="text" value="{{$policePermission->driver->driver_phone}}" class="To bold md-font"></td>
        </tr>
        </tbody>
    </table>
    <table class="Table-35">
        <tbody>
        <tr>
            <td width="30%" class="bold">العدد:
            </td>

            <td><input type="text" value="{{$policePermission->job_file->children_count + $policePermission->job_file->adults_count}}" class="To bold md-font"></td>
        </tr>
        </tbody>
    </table>
    <table class="Table-30">
        <tbody>
        <tr>
            <td width="30%" class="bold">قادم من:
            </td>
            <td><input type="text" value="{{$policePermission->coming_from_ar}}" class="To bold md-font"></td>
        </tr>
        </tbody>
    </table>
    <table class="Table-35">
        <tbody>
        <tr>
            <td width="40%" class="bold">أسم شركة النقل:
            </td>
            <td><input type="text" value="{{$policePermission->transportation->name_ar ?: $policePermission->transportation->name}}" class="To bold md-font"></td>
        </tr>
        </tbody>
    </table>
    <table class="Table-35">
        <tbody>
        <tr>
            <td width="40%" class="bold">تاريخ الوصول:
            </td>

            <td><input type="text" value="{{$policePermission->job_file->arrival_date->format('d/m/Y H:i')}}" class="To bold md-font"></td>
        </tr>
        </tbody>
    </table>
    <table class="Table-30">
        <tbody>
        <tr>
            <td width="40%" class="bold">منفذ الوصول:
            </td>
            <td><input type="text" style="direction: rtl;" value="{{$policePermission->job_file->airport_to->format()['text_ar'] ?: $policePermission->job_file->airport_to->format()['text']}}" class="To bold md-font"></td>
        </tr>
        </tbody>
    </table>
    <table class="Table-35">
        <tbody>
        <tr>
            <td width="40%" class="bold">رقم رحلة الوصول:
            </td>
            <td><input type="text" value="{{$policePermission->job_file->arrival_flight}}" class="To bold md-font"></td>
        </tr>
        </tbody>
    </table>
    <table class="Table-35">
        <tbody>
        <tr>
            <td width="40%" class="bold">تاريخ المغادرة:
            </td>

            <td><input type="text" value="{{$policePermission->job_file->departure_date->format('d/m/Y H:i')}}" class="To bold md-font"></td>
        </tr>
        </tbody>
    </table>
    <table class="Table-30">
        <tbody>
        <tr>
            <td width="40%" class="bold">منفذ المغادرة:
            </td>
            <td><input type="text" style="direction: rtl;"  value="{{$policePermission->job_file->airport_from->format()['text_ar'] ?: $policePermission->job_file->airport_from->format()['text']}}" class="To bold md-font"></td>
        </tr>
        </tbody>
    </table>
    <table class="Table-35">
        <tbody>
        <tr>
            <td width="40%" class="bold">رقم رحلة المغادرة:
            </td>
            <td><input type="text" value="{{$policePermission->job_file->departure_flight}}" class="To bold md-font"></td>
        </tr>
        </tbody>
    </table>
    <table class="Table-half">
        <tbody>
        <tr>
            <td width="40%" class="bold">
                اسم المرشد السياحي:
            </td>
            <td>
                <input type="text" value="{{$policePermission->guide->name_ar ?: $policePermission->guide->name}}" class="To bold md-font">
            </td>

        </tr>
        <tr>
            <td width="40%" class="bold">
                رقم الهاتف:
            </td>
            <td><input type="text" value="{{$policePermission->guide->phone}}" class="To bold md-font"></td>

        </tr>

        </tbody>
    </table>
    <table class="Table-half">
        <tbody>
        <tr>
            <td width="40%" class="bold">
                اسم المندوب:
            </td>
            <td>
                <input type="text" value="{{$policePermission->representative->user->name_ar ?: $policePermission->representative->user->name}}" class="To bold md-font">
            </td>

        </tr>
        <tr>
            <td width="40%" class="bold">
                رقم الهاتف:
            </td>
            <td><input type="text" value="{{$policePermission->representative->user->phone}}" class="To bold md-font"></td>

        </tr>

        </tbody>
    </table>

    <table class="t1">
        <tbody>
        <tr>
            <td width="10%" class="text-center bold border-right border-bottom font-Arial">التاريخ</td>
            <td width="10%" class="text-center bold border-right border-bottom font-Arial">الساعة</td>
            <td width="70%" class="text-center bold border-right border-bottom font-Arial">خط السير</td>
            <td width="10%" class="text-center bold border-right border-bottom font-Arial">الاقامة</td>


        </tr>

        @foreach($policePermission->traffic_lines as $line)
        <tr>
            <td width="10%" class="text-center bold border-right">
                <input type="text" class="text-center input1" value="{{$line->date->format('d/m/Y')}}" readonly="">
            </td>
            <td width="10%" class="text-center bold border-right">
                <input type="text" class="text-center input1" value="{{$line->date->format('H:i')}}" readonly="">
            </td>
            <td width="70%" class="text-center bold border-right">
              <textarea rows="5" cols="148" value="" class="textarea" readonly="">{{$line->details}}</textarea>
            </td>
            <td width="10%" class="text-center bold border-right">

            </td>

        </tr>
        @endforeach

        @for($i=0;$i<(9-$policePermission->traffic_lines->count());$i++)
        <tr>
            <td width="10%" class="text-center bold border-right">
                <input type="text" class="text-center input1" value="" readonly="">
            </td>
            <td width="10%" class="text-center bold border-right">
                <input type="text" class="text-center input1" value="" readonly="">
            </td>
            <td width="70%" class="text-center bold border-right">
              <textarea rows="5" cols="148" value="" class="textarea" readonly=""></textarea>
            </td>
            <td width="10%" class="text-center bold border-right">

            </td>

        </tr>
        @endfor
        </tbody>

    </table>
    <table class="T0">
        <tbody>
        <tr>
            <td class="bold prFont-14 font-Times">روجع مدير الحركة</td>
            <td class="bold prFont-14 font-Times">
                روجع مسئول النقل
            </td>
            <td class="bold prFont-14 font-Times">
                إمضاء الموظف
            </td>
            <td class="bold prFont-14 font-Times">
                إمضاء مدير السياحة
            </td>
            <td class="bold prFont-14 font-Times">
                ختم الشركة
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
