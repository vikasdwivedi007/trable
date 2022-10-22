<!-- saved from url=(0073)http://vocher.voyageursdumonde-eg.com/admin/preview-service-note.php?id=2 -->
<html lang="en">
<!-- START HEAD -->

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
    <title>View Guide Voucher</title>
    <!-- STYLE -->
    <link id="darkTheme" rel="stylesheet" href="{{asset('assets/css/pages/view-guide-service-voucher.css')}}">


</head>
<!-- END HEAD -->

<!-- START BODY -->

<body>

<div class="main">
    <div class="logoarea">
        <div class="logo-form">
            <img src="{{asset('assets/images/logo-dark.png')}}">
        </div>
    </div>
    <table class="T1">
        <tbody>
        <tr>
            <td width="65%" class="service bold">GUIDE SERVICE NOTE
            </td>
            <td></td>
            <td style="border:red solid 1.5px;text-align: center;" width="30%">{{$voucher->serial_no}}
            </td>
        </tr>
        </tbody>
    </table>
    <table class="T2">
        <tbody>
        <tr>
            <td  class="font-12 w-25">NAME OF GUIDE</td>
            <td><input type="text" value="{{$voucher->guide->name}}" class="To bold md-font font-12" readonly=""></td>
            <td  class="font-12 w-25">LANGUAGE</td>
            <td><input type="text" value="{{$voucher->guide->languages_str}}" class="To bold md-font font-12"></td>
        </tr>
        <tr>
            <td  class="font-12 w-25">ADDRESS</td>
            <td><input type="text" value="{{$voucher->guide_address}}" class="To bold md-font font-12"></td>
            <td  class="font-12 w-25">TEL NO.</td>
            <td><input type="text" value="{{$voucher->guide->phone}}" class="To bold md-font font-12"></td>
        </tr>
        </tbody>
    </table>

    <table class="T3">
        <tbody>
        <tr>
            <td  class="font-12 w-25">NAME OF CLIENT</td>
            <td><input type="text" value="{{$voucher->job_file->client_name}}" class="To bold md-font font-12" readonly=""></td>
            <td  class="font-12 w-25">LANGUAGE</td>
            <td><input type="text" value="{{$voucher->job_file->language->language}}" class="To bold md-font font-12"></td>
        </tr>
        <tr>
            <td  class="font-12 w-25">STAYING AT HOTEL</td>
            <td><input type="text" value="{{$voucher->hotel->name}}" class="To bold md-font font-12"></td>
            <td  class="font-12 w-25">ROOM NO.</td>
            <td><input type="text" value="{{$voucher->room_no}}" class="To bold md-font font-12"></td>
        </tr>
        </tbody>
    </table>


    <table class="T4">
        <tbody>
        <tr>
            <td  class="font-12 w-25">TRANSPORTATION BY</td>
            <td><input type="text" value="{{$voucher->transport_by}}" class="To bold md-font font-12"></td>
            <td  class="font-12 w-25">NO. OF PAX</td>
            <td><input type="text" value="{{$voucher->pax_no}}" class="To bold md-font font-12"></td>
        </tr>
        <tr>
            <td  class="font-12 w-25">FILE NO.</td>
            <td><input type="text" value="{{$voucher->job_file->file_no}}" class="To bold md-font font-12" readonly=""></td>
            <td  class="font-12 w-25">TOUR OPERATOR</td>
            <td><input type="text" value="{{$voucher->tour_operator}}" class="To bold md-font font-12"></td>
        </tr>
        </tbody>
    </table>

    <table class="T5">
        <tbody>
        <tr>
            <td class="ttd5a">DATE</td>
            <td class="ttd5a">TIME</td>
            <td class="ttd5x">DESCRIPTION OF TOUR</td>
        </tr>
        @foreach($voucher->tours as $tour)
        <tr>
            <td class="ttd5b">
                <input type="text" value="{{$tour->date->format('d/m/Y')}}" class="texttable sm-font font-12" readonly="">
            </td>
            <td class="ttd5b">
                <input type="text" value="{{$tour->date->format('H:i')}}" class="texttable sm-font font-12" readonly="">
            </td>
            <td class="">
                <input type="text" value="{{$tour->desc}}" class="texttable sm-font font-12" readonly="">
            </td>
        </tr>
        @endforeach

        @for($i=$voucher->tours->count();$i<6;$i++)
        <tr>
            <td class="ttd5b"><input type="text" value="" class="texttable sm-font font-12" readonly=""></td>
            <td class="ttd5b"><input type="text" value="" class="texttable sm-font font-12" readonly=""></td>
            <td class=""><input type="text" value="" class="texttable sm-font font-12" readonly=""></td>
        </tr>
        @endfor

        </tbody>
    </table>
    <table class="T6">
        <tbody>
        <tr>
            <td class="font-12">UNDERSIGNED HAS ACCEPTED PROVIDING THE ABOVE MENTIONED SERVICE </td>
        </tr>
        </tbody>
    </table>
    <table class="T7">
        <tbody>
        <tr>
            <td width="10%" class="font-12">SIGNATURE</td>
            <td><input type="text" class="To" readonly=""></td>
        </tr>
        <tr>
            <td width="10%" class="font-12">DATE</td>
            <td><input type="text" value="{{$voucher->issue_date->format('d/m/Y')}}" class="To bold md-font" readonly=""></td>

        </tr>
        </tbody>
    </table>

    <table class="T8">
        <tbody>
        <tr>
        </tr>
        <tr>
            <td width="100%"><textarea rows="8" cols="5" class="textarea issuing-office"
                                       readonly="">{{$voucher->issued_by}}</textarea></td>
        </tr>
        <tr>
            <td style="text-align: left">ISSUING OFFICE / SIGNATURE STAMP</td>
        </tr>
        </tbody>
    </table>
</div>

<div class="cppy">
<div id="background">
    <p id="bg-text">COPY</p>
	</div>

    <div class="logoarea">
        <div class="logo-form">
            <img src="{{asset('assets/images/logo-dark.png')}}">
        </div>
    </div>
    <table class="T1">
        <tbody>
        <tr>
            <td width="65%" class="service bold">GUIDE SERVICE NOTE
            </td>
            <td></td>
            <td style="border:red solid 1.5px;text-align: center;" width="30%">{{$voucher->serial_no}}
            </td>
        </tr>
        </tbody>
    </table>
    <table class="T2">
        <tbody>
        <tr>
            <td  class="font-12 w-25">NAME OF GUIDE</td>
            <td><input type="text" value="{{$voucher->guide->name}}" class="To bold md-font font-12" readonly=""></td>
            <td  class="font-12 w-25">LANGUAGE</td>
            <td><input type="text" value="{{$voucher->guide->languages_str}}" class="To bold md-font font-12"></td>
        </tr>
        <tr>
            <td  class="font-12 w-25">ADDRESS</td>
            <td><input type="text" value="{{$voucher->guide_address}}" class="To bold md-font font-12"></td>
            <td  class="font-12 w-25">TEL NO.</td>
            <td><input type="text" value="{{$voucher->guide->phone}}" class="To bold md-font font-12"></td>
        </tr>
        </tbody>
    </table>

    <table class="T3">
        <tbody>
        <tr>
            <td  class="font-12 w-25">NAME OF CLIENT</td>
            <td><input type="text" value="{{$voucher->job_file->client_name}}" class="To bold md-font font-12" readonly=""></td>
            <td  class="font-12 w-25">LANGUAGE</td>
            <td><input type="text" value="{{$voucher->job_file->language->language}}" class="To bold md-font font-12"></td>
        </tr>
        <tr>
            <td  class="font-12 w-25">STAYING AT HOTEL</td>
            <td><input type="text" value="{{$voucher->hotel->name}}" class="To bold md-font font-12"></td>
            <td  class="font-12 w-25">ROOM NO.</td>
            <td><input type="text" value="{{$voucher->room_no}}" class="To bold md-font font-12"></td>
        </tr>
        </tbody>
    </table>


    <table class="T4">
        <tbody>
        <tr>
            <td  class="font-12 w-25">TRANSPORTATION BY</td>
            <td><input type="text" value="{{$voucher->transport_by}}" class="To bold md-font font-12"></td>
            <td  class="font-12 w-25">NO. OF PAX</td>
            <td><input type="text" value="{{$voucher->pax_no}}" class="To bold md-font font-12"></td>
        </tr>
        <tr>
            <td  class="font-12 w-25">FILE NO.</td>
            <td><input type="text" value="{{$voucher->job_file->file_no}}" class="To bold md-font font-12" readonly=""></td>
            <td  class="font-12 w-25">TOUR OPERATOR</td>
            <td><input type="text" value="{{$voucher->tour_operator}}" class="To bold md-font font-12"></td>
        </tr>
        </tbody>
    </table>

    <table class="T5">
        <tbody>
        <tr>
            <td class="ttd5a">DATE</td>
            <td class="ttd5a">TIME</td>
            <td class="ttd5x">DESCRIPTION OF TOUR</td>
        </tr>
        @foreach($voucher->tours as $tour)
        <tr>
            <td class="ttd5b">
                <input type="text" value="{{$tour->date->format('d/m/Y')}}" class="texttable sm-font font-12" readonly="">
            </td>
            <td class="ttd5b">
                <input type="text" value="{{$tour->date->format('h:i a')}}" class="texttable sm-font font-12" readonly="">
            </td>
            <td class="">
                <input type="text" value="{{$tour->desc}}" class="texttable sm-font font-12" readonly="">
            </td>
        </tr>
        @endforeach

        @for($i=$voucher->tours->count();$i<6;$i++)
        <tr>
            <td class="ttd5b"><input type="text" value="" class="texttable sm-font font-12" readonly=""></td>
            <td class="ttd5b"><input type="text" value="" class="texttable sm-font font-12" readonly=""></td>
            <td class=""><input type="text" value="" class="texttable sm-font font-12" readonly=""></td>
        </tr>
        @endfor

        </tbody>
    </table>
    <table class="T6">
        <tbody>
        <tr>
            <td class="font-12">UNDERSIGNED HAS ACCEPTED PROVIDING THE ABOVE MENTIONED SERVICE </td>
        </tr>
        </tbody>
    </table>
    <table class="T7">
        <tbody>
        <tr>
            <td width="10%" class="font-12">SIGNATURE</td>
            <td><input type="text" class="To" readonly=""></td>
        </tr>
        <tr>
            <td width="10%" class="font-12">DATE</td>
            <td><input type="text" value="{{$voucher->issue_date->format('d/m/Y')}}" class="To bold md-font" readonly=""></td>

        </tr>
        </tbody>
    </table>

    <table class="T8">
        <tbody>
        <tr>
        </tr>
        <tr>
            <td width="100%"><textarea rows="8" cols="5" class="textarea issuing-office"
                                       readonly="">{{$voucher->issued_by}}</textarea></td>
        </tr>
        <tr>
            <td style="text-align: left">ISSUING OFFICE / SIGNATURE STAMP</td>
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
