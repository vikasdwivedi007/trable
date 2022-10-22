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
    <link id="darkTheme" rel="stylesheet" href="{{asset('assets/css/pages/view-cash-form.css')}}">

</head>

<body>

<div class="main">

    <table class="t1">
        <tbody>
        <tr class="border-top">
            <td colspan="3" class="pt-50"></td>
        </tr>
        <tr>
            <td colspan="3">
                <p class="pr-100 prFont-20 bold">
                    شركة فويـاجير ديو موند للسياحة
                    <br>
                    إدارة الحسـابـات العـامة
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td colspan="3" class="text-center bold prFont-20 p-50">
                نموذج توريد مبلغ نقدي لخدمة إضافية
                <br>
                (شامل عمولة إدارة الحركة)
            </td>
        </tr>
        <tr>
            <td width="35%" class="pr-100 pb-20">

                <p type="text" class="input1 md-font" readonly="">
                    فيمة الخدمة الإضافية :-
                </p>
            </td>
            <td colspan="2" class="pb-20">
                <input type="text" value="{{$cashForm->additional_fees}}" class="input1 md-font" readonly="">
            </td>
        </tr>
        <tr>
            <td width="35%" class="pr-100 pb-20">

                <p type="text" class="input1 md-font" readonly="">
                    بيان الخدمة الإضافية :-
                </p>
            </td>
            <td colspan="2" class="pb-20">
                <input type="text" value="{{$cashForm->additional_desc}}" class="input1 md-font" readonly="">
            </td>
        </tr>
        <tr>
            <td width="35%" class="pr-100 pb-20">

                <p type="text" class="input1 md-font" readonly="">
                    رقم ملف :-
                </p>
            </td>
            <td colspan="2" class="pb-20">
                <input type="text" value="{{$cashForm->job_file->file_no}}" class="input1 md-font" readonly="">
            </td>
        </tr>
        <tr>
            <td width="35%" class="pr-100 pb-20">

                <p type="text" class="input1 md-font" readonly="">
                    أسم العميل:-
                </p>
            </td>
            <td colspan="2" class="pb-20">
                <input type="text" value="{{$cashForm->job_file->client_name}}" class="input1 md-font" readonly="">
            </td>
        </tr>

        <tr>
            <td width="35%" class="pr-100 pb-20">

                <p type="text" class="input1 md-font" readonly="">
                    التاريخ:-
                </p>
            </td>
            <td colspan="2" class="pb-20">
                <input type="text" value="{{$cashForm->date->format('d/m/Y')}}" class="input1 md-font" readonly="">
            </td>
        </tr>
        <tr>
            <td width="35%" class="pr-100 pb-20">

                <p type="text" class="input1 md-font" readonly="">
                    أسم المسئول عن الملف:-
                </p>
            </td>
            <td colspan="2" class="pb-20">
                <input type="text" value="{{$cashForm->job_file->operator()->user->name}}" class="input1 md-font" readonly="">
            </td>
        </tr>


        <tr>
            <td width="35%" class="pr-100 pb-20">

                <p type="text" class="input1 md-font" readonly="">
                    عدد الفعلى للعملاء:-
                </p>
            </td>
            <td colspan="2" class="pb-20">
                <input type="text" value="{{$cashForm->job_file->adults_count+$cashForm->job_file->children_count}}" class="input1 md-font" readonly="">
            </td>
        </tr>


        <tr>
            <td width="35%" class="pr-100 pb-20">
                <p type="text" class="input1 md-font" readonly="">
                    أسم المرشد / المرشدة:-
                </p>
            </td>
            <td colspan="2" class="pb-20">
                <input type="text" value="{{$cashForm->job_file->guides->count() ? $cashForm->job_file->guides[0]->guide->name : ""}}" class="input1 md-font" readonly="">
            </td>
        </tr>

        <tr>
            <td width="35%" class="pr-100 pb-20">

                <p type="text" class="input1 md-font" readonly="">
                    أسم المندوب وتوقعيه:-
                </p>
            </td>
            <td colspan="2" class="pb-20">
                <input type="text" value="{{$cashForm->representative->user->name}}" class="input1 md-font" readonly="">
            </td>
        </tr>
        <tr>
            <td colspan="3" class="pb-20 pr-100">
                <p type="text" class="input1 md-font bold" readonly="">
                    توقيع مدير الحركة
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="pb-20 pr-100">
                <input type="text" value="" class="input1 md-font" readonly="">
            </td>
        </tr>
        <tr>
            <td colspan="1">
            </td>
            <td colspan="2" class="pb-20">
                <p type="text" class="input1 md-font bold" readonly="">
                    توقيع المسئول عن الملف
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="1">

            </td>
            <td colspan="2" class="pb-20">
                <input type="text" value="" class="input1 md-font" readonly="">
            </td>
        </tr>
        <tr>
            <td width="70%" colspan="2">
            </td>
            <td colspan="1" class="pb-20">
                <p type="text" class="input1 md-font bold" readonly="">
                    توقيع الخزينة / الحسابات العامة
                </p>
            </td>
        </tr>
        <tr>
            <td width="70%" colspan="2">
            </td>
            <td colspan="1" class="pb-20">
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
