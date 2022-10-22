
<!-- saved from url=(0068)http://vocher.voyageursdumonde-eg.com/admin/preview-voucher.php?id=2 -->
<html lang="en"><!-- START HEAD -->
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
    <title>View Hotel Voucher</title>
    <!-- STYLE -->
    <link id="darkTheme" rel="stylesheet" href="{{asset('assets/css/pages/view-hotel-voucher.css')}}">


</head>
<!-- END HEAD -->

<!-- START BODY -->
<body>

<div class="main">
    <div class="logoarea">
        <div class="logo-form">
            <img src="{{asset('assets/images/logo-dark.png')}}">
        </div>
        <div class="address font-12">
            <br>
            <strong>2 ABDELLATIF ELSOFANI STREET
                <br> (CORNER NO.11 - SHERIF STREET) CAIRO
                <br> TEL.:+20223962263 +20223962264
                <br> +20223962265 FAX.:+20223962261 </strong>
        </div>
    </div>
    <table class="t1">
        <tbody><tr>
            <td class="service md-font bold">VOUCHER</td>
            <td></td>
            <td class="serial">{{$voucher->serial_no}}</td>
        </tr>
        </tbody></table>
    <table class="t2">
        <tbody><tr>
            <td class="ttd2 font-12">TO HOTEL / CRUISE SHIP</td>
            <td width="80%" ;=""><input type="text" value="{{$voucher->hotel ? $voucher->hotel->name : $voucher->cruise->name}}" class="input1 font-12"> </td>
        </tr>
        </tbody></table>

    <table class="t3">
        <tbody><tr>
            <td class="ttd3 font-12">KINDLY PROVIDE THE HOLDER</td>
            <td width="50%" ;=""><input type="text" value="{{$voucher->job_file->client_name}}" class="input1 font-12"> </td>
            <td class="ttd3 font-12"><strong>NO. OF GUESTS</strong></td>
            <td width="14%" ;=""><input type="text" value="{{$voucher->job_file->adults_count+$voucher->job_file->children_count}}" class="input1 font-12"> </td>
        </tr>
        </tbody></table>

    <table class="t4">
        <tbody><tr>
            <td class="ttd4 font-edit font-12">ARRIVAL</td>
            <td><input type="text" value="{{$voucher->arrival_date->format('d-m-Y')}}" class="input1 font-12"></td>
            <td class="ttd4 font-edit font-12">DEPARTURE</td>
            <td><input type="text" value="{{$voucher->departure_date->format('d-m-Y')}}" class="input1 font-12"></td>
            <td class="ttd4 font-12"><strong>NO. OF NIGHTS</strong></td>
            <td width="11.5%"><input type="text" value="{{$voucher->arrival_date->diffInDays($voucher->departure_date)}} night(s)" class="input1 font-12"></td>
        </tr>


        </tbody></table>


    <table class="tg">
        <tbody><tr>
            <td class="tg-yw4l font-12">SINGLE</td>
            <td class="tg-yw4l"><input type="text" value="{{$voucher->single_rooms_count}}" class="texttable font-12"></td>
            <td class="tg-yw4l font-12">DATE
            </td><td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 1) {{$voucher->meals->get(0)->date->format('d-m-Y')}} @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 2) {{$voucher->meals->get(1)->date->format('d-m-Y')}} @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 3) {{$voucher->meals->get(2)->date->format('d-m-Y')}} @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 4) {{$voucher->meals->get(3)->date->format('d-m-Y')}} @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 5) {{$voucher->meals->get(4)->date->format('d-m-Y')}} @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 6) {{$voucher->meals->get(5)->date->format('d-m-Y')}} @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 7) {{$voucher->meals->get(6)->date->format('d-m-Y')}} @endif" class="texttable center-text"></td>
        </tr>
        <tr>
            <td class="tg-yw4l font-12">DOUBLES</td>
            <td class="tg-yw4l "><input type="text" value="{{$voucher->double_rooms_count}}" class="texttable font-12"></td>
            <td class="tg-yw4l font-12">AMERICAN BREAKFAST</td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 1 && $voucher->meals->get(0)->american_breakfast) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 2 && $voucher->meals->get(1)->american_breakfast) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 3 && $voucher->meals->get(2)->american_breakfast) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 4 && $voucher->meals->get(3)->american_breakfast) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 5 && $voucher->meals->get(4)->american_breakfast) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 6 && $voucher->meals->get(5)->american_breakfast) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 7 && $voucher->meals->get(6)->american_breakfast) ✔ @endif" class="texttable center-text"></td>
        </tr>
        <tr>
            <td class="tg-yw4l font-12">TRIPLES</td>
            <td class="tg-yw4l"><input type="text" value="{{$voucher->triple_rooms_count}}" class="texttable font-12"></td>
            <td class="tg-yw4l font-12">CONTINENTAL BREAKFAST</td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 1 && $voucher->meals->get(0)->continental_breakfast) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 2 && $voucher->meals->get(1)->continental_breakfast) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 3 && $voucher->meals->get(2)->continental_breakfast) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 4 && $voucher->meals->get(3)->continental_breakfast) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 5 && $voucher->meals->get(4)->continental_breakfast) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 6 && $voucher->meals->get(5)->continental_breakfast) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 7 && $voucher->meals->get(6)->continental_breakfast) ✔ @endif" class="texttable center-text"></td>
        </tr>
        <tr>
            <td class="tg-yw4l font-12">SUITES</td>
            <td class="tg-yw4l"><input type="text" value="{{$voucher->suite_rooms_count}}" class="texttable font-12"></td>
            <td class="tg-yw4l font-12">LUNCH</td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 1 && $voucher->meals->get(0)->lunch) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 2 && $voucher->meals->get(1)->lunch) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 3 && $voucher->meals->get(2)->lunch) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 4 && $voucher->meals->get(3)->lunch) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 5 && $voucher->meals->get(4)->lunch) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 6 && $voucher->meals->get(5)->lunch) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 7 && $voucher->meals->get(6)->lunch) ✔ @endif" class="texttable center-text"></td>
        </tr>
        <tr>
            <td class="tg-yw4l font-12">TOTAL ROOMS</td>
            <td class="tg-yw4l"><input type="text" value="{{$total_rooms}}" class="texttable font-12"></td>
            <td class="tg-yw4l font-12">DINNER</td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 1 && $voucher->meals->get(0)->dinner) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 2 && $voucher->meals->get(1)->dinner) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 3 && $voucher->meals->get(2)->dinner) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 4 && $voucher->meals->get(3)->dinner) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 5 && $voucher->meals->get(4)->dinner) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 6 && $voucher->meals->get(5)->dinner) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 7 && $voucher->meals->get(6)->dinner) ✔ @endif" class="texttable center-text"></td>
        </tr>
        </tbody></table>

    <table class="t5">
        <tbody><tr>
            <td class="ttd5">
                <span class="remarks-bold font-12">REMARKS</span> <br><br>
                <textarea rows="9" cols="51" class="rtextarea">{{$voucher->remarks}}</textarea></td>
        </tr>
        </tbody></table>
    <table class="t6">
        <tbody><tr>
            <td class="ttd6a font-12">ISSUING OFFICE <br><br>
                <input type="text" class="input3 issuing-office font-12" value="{{$voucher->issued_by}}">
            </td>
            <td class="ttd6a font-12"> HOTEL-CRUISE SHIP<br><br>
                <input type="text" value="" class="input3 font-12"><br><br>SIGNATURE / STAMP IN RECEIPT
            </td>
        </tr>
        <tr>
            <td class="ttd6b font-12" style="vertical-align:top;">
                THIS VOUCHER ENCLOSED WITH YOUR INVOICE WILL BE PAID<br>BY VOYAGEURS DU MONDE<br>EXCLUDING ALL EXTRAS
            </td>
            <td class="ttd6b center-text font-edit font-12">FILE NO.
                <input type="text" value="{{$voucher->job_file->file_no}}" class="input3 center-text bold font-12"></td>
        </tr>

        </tbody></table>
</div>
<div class="copy">
  
  <div id="background">
    <p id="bg-text">COPY</p>
	</div>

    <div class="logoarea">
        <div class="logo-form">
            <img src="{{asset('assets/images/logo-dark.png')}}">
        </div>
        <div class="address font-12">
            <br>
            <strong>2 ABDELLATIF ELSOFANI STREET
                <br> (CORNER NO.11 - SHERIF STREET) CAIRO
                <br> TEL.:+20223962263 +20223962264
                <br> +20223962265 FAX.:+20223962261 </strong>
        </div>
    </div>
    <table class="t1">
        <tbody><tr>
            <td class="service md-font bold">VOUCHER</td>
            <td></td>
            <td class="serial">{{$voucher->serial_no}}</td>
        </tr>
        </tbody></table>
    <table class="t2">
        <tbody><tr>
            <td class="ttd2 font-12">TO HOTEL / CRUISE SHIP</td>
            <td width="80%" ;=""><input type="text" value="{{$voucher->hotel ? $voucher->hotel->name : $voucher->cruise->name}}" class="input1 font-12"> </td>
        </tr>
        </tbody></table>

    <table class="t3">
        <tbody><tr>
            <td class="ttd3 font-12">KINDLY PROVIDE THE HOLDER</td>
            <td width="50%" ;=""><input type="text" value="{{$voucher->job_file->client_name}}" class="input1 font-12"> </td>
            <td class="ttd3 font-12"><strong>NO. OF GUESTS</strong></td>
            <td width="14%" ;=""><input type="text" value="{{$voucher->job_file->adults_count+$voucher->job_file->children_count}}" class="input1 font-12"> </td>
        </tr>
        </tbody></table>

    <table class="t4">
        <tbody><tr>
            <td class="ttd4 font-edit font-12">ARRIVAL</td>
            <td><input type="text" value="{{$voucher->arrival_date->format('d-m-Y')}}" class="input1 font-12"></td>
            <td class="ttd4 font-edit font-12">DEPARTURE</td>
            <td><input type="text" value="{{$voucher->departure_date->format('d-m-Y')}}" class="input1 font-12"></td>
            <td class="ttd4 font-12"><strong>NO. OF NIGHTS</strong></td>
            <td width="11.5%"><input type="text" value="{{$voucher->arrival_date->diffInDays($voucher->departure_date)}} night(s)" class="input1 font-12"></td>
        </tr>


        </tbody></table>


    <table class="tg">
        <tbody><tr>
            <td class="tg-yw4l font-12">SINGLE</td>
            <td class="tg-yw4l"><input type="text" value="{{$voucher->single_rooms_count}}" class="texttable font-12"></td>
            <td class="tg-yw4l font-12">DATE
            </td><td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 1) {{$voucher->meals->get(0)->date->format('d-m-Y')}} @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 2) {{$voucher->meals->get(1)->date->format('d-m-Y')}} @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 3) {{$voucher->meals->get(2)->date->format('d-m-Y')}} @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 4) {{$voucher->meals->get(3)->date->format('d-m-Y')}} @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 5) {{$voucher->meals->get(4)->date->format('d-m-Y')}} @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 6) {{$voucher->meals->get(5)->date->format('d-m-Y')}} @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 7) {{$voucher->meals->get(6)->date->format('d-m-Y')}} @endif" class="texttable center-text"></td>
        </tr>
        <tr>
            <td class="tg-yw4l font-12">DOUBLES</td>
            <td class="tg-yw4l "><input type="text" value="{{$voucher->double_rooms_count}}" class="texttable font-12"></td>
            <td class="tg-yw4l font-12">AMERICAN BREAKFAST</td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 1 && $voucher->meals->get(0)->american_breakfast) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 2 && $voucher->meals->get(1)->american_breakfast) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 3 && $voucher->meals->get(2)->american_breakfast) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 4 && $voucher->meals->get(3)->american_breakfast) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 5 && $voucher->meals->get(4)->american_breakfast) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 6 && $voucher->meals->get(5)->american_breakfast) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 7 && $voucher->meals->get(6)->american_breakfast) ✔ @endif" class="texttable center-text"></td>
        </tr>
        <tr>
            <td class="tg-yw4l font-12">TRIPLES</td>
            <td class="tg-yw4l"><input type="text" value="{{$voucher->triple_rooms_count}}" class="texttable font-12"></td>
            <td class="tg-yw4l font-12">CONTINENTAL BREAKFAST</td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 1 && $voucher->meals->get(0)->continental_breakfast) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 2 && $voucher->meals->get(1)->continental_breakfast) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 3 && $voucher->meals->get(2)->continental_breakfast) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 4 && $voucher->meals->get(3)->continental_breakfast) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 5 && $voucher->meals->get(4)->continental_breakfast) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 6 && $voucher->meals->get(5)->continental_breakfast) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 7 && $voucher->meals->get(6)->continental_breakfast) ✔ @endif" class="texttable center-text"></td>
        </tr>
        <tr>
            <td class="tg-yw4l font-12">SUITES</td>
            <td class="tg-yw4l"><input type="text" value="{{$voucher->suite_rooms_count}}" class="texttable font-12"></td>
            <td class="tg-yw4l font-12">LUNCH</td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 1 && $voucher->meals->get(0)->lunch) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 2 && $voucher->meals->get(1)->lunch) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 3 && $voucher->meals->get(2)->lunch) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 4 && $voucher->meals->get(3)->lunch) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 5 && $voucher->meals->get(4)->lunch) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 6 && $voucher->meals->get(5)->lunch) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 7 && $voucher->meals->get(6)->lunch) ✔ @endif" class="texttable center-text"></td>
        </tr>
        <tr>
            <td class="tg-yw4l font-12">TOTAL ROOMS</td>
            <td class="tg-yw4l"><input type="text" value="{{$total_rooms}}" class="texttable font-12"></td>
            <td class="tg-yw4l font-12">DINNER</td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 1 && $voucher->meals->get(0)->dinner) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 2 && $voucher->meals->get(1)->dinner) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 3 && $voucher->meals->get(2)->dinner) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 4 && $voucher->meals->get(3)->dinner) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 5 && $voucher->meals->get(4)->dinner) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 6 && $voucher->meals->get(5)->dinner) ✔ @endif" class="texttable center-text"></td>
            <td class="tg-yw4l"><input type="text" value="@if($voucher->meals->count() >= 7 && $voucher->meals->get(6)->dinner) ✔ @endif" class="texttable center-text"></td>
        </tr>
        </tbody></table>

    <table class="t5">
        <tbody><tr>
            <td class="ttd5">
                <span class="remarks-bold font-12">REMARKS</span> <br><br>
                <textarea rows="9" cols="51" class="rtextarea">{{$voucher->remarks}}</textarea></td>
        </tr>
        </tbody></table>
    <table class="t6">
        <tbody><tr>
            <td class="ttd6a font-12">ISSUING OFFICE <br><br>
                <input type="text" class="input3 issuing-office font-12" value="{{$voucher->issued_by}}">
            </td>
            <td class="ttd6a font-12"> HOTEL-CRUISE SHIP<br><br>
                <input type="text" value="" class="input3 font-12"><br><br>SIGNATURE / STAMP IN RECEIPT
            </td>
        </tr>
        <tr>
            <td class="ttd6b font-12" style="vertical-align:top;">
                THIS VOUCHER ENCLOSED WITH YOUR INVOICE WILL BE PAID<br>BY VOYAGEURS DU MONDE<br>EXCLUDING ALL EXTRAS
            </td>
            <td class="ttd6b center-text font-edit font-12">FILE NO.
                <input type="text" value="{{$voucher->job_file->file_no}}" class="input3 center-text bold font-12"></td>
        </tr>

        </tbody></table>
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


<!-- END HTML DOCUMENT --></body></html>
