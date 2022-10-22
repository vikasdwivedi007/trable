<!-- saved from url=(0082)http://vocher.voyageursdumonde-eg.com/admin/preview-restaurant-voucher.php?id=1386 -->
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
    <link rel="icon" href="{{asset('assets/images/favicon.ico" type="image/x-icon')}}">

    <!-- TITLE -->
    <title>View Restaurant Voucher</title>
    <!-- STYLE -->
    <link id="darkTheme" rel="stylesheet" href="{{asset('assets/css/pages/view-restaurant-voucher.css')}}">



</head>
<!-- END HEAD -->

<!-- START BODY -->

<body>

<div class="main">
    <table class="table-25 logoarea">
        <tbody>
        <tr class="logo-form">
            <td>
                <img src="{{asset('assets/images/logo-dark.png')}}">
            </td>
        </tr>
        <tr class="address font-12">
            <td>
                <strong>2 ABDELLATIF ELSOFANI STREET
                    <br> (CORNER NO.11 -SHERIF STREET)CAIRO
                    <br> TEL.:+20223962263 +20223962264
                    <br> +20223962265 FAX.:+20223962261
                </strong>
            </td>
        </tr>
        </tbody>
    </table>
    <table class="t1">
        <tbody>
        <tr>
            <td class="service md-font bold">RESTAURANT VOUCHER</td>
            <td width="2%"></td>
            <td class="serial md-font">
                <input type="text" value="{{$voucher->serial_no}}" class="input1 md-font center-text red-color" readonly="">
            </td>
        </tr>
        </tbody>
    </table>

    <table class="t2">
        <tbody>
        <tr>
            <td class="ttd2" width="4%">TO</td>
            <td>
                <p type="text" class="input1 md-font" readonly="">{{$voucher->to}}</p>
            </td>
        </tr>
        </tbody>
    </table>


    <table class="t3">
        <tbody>
        <tr>
            <td class="ttd3" width="21%">NAME OF GUEST</td>
            <td>
                <input type="text" value="{{$voucher->job_file->client_name}}" class="input1 md-font" readonly="">
            </td>
        </tr>
        </tbody>
    </table>
    <table class="T5">
        <tbody>
        <tr>
            <td>KINDLY PROVIDE THE HOLDER WITH THE SERVICE LISTED BELOW : </td>
        </tr>
        <tr>
            <td id="ovrflwVsble">
                <textarea rows="18" cols="140" value="" class="textarea" readonly="">{{$voucher->details}}</textarea>
            </td>
        </tr>
        <tr>
            <td class="ttd5 font-12">THIS VOUCHER ENCLOSED WITH YOUR INVOICE WILL BE PAID BY VOYAGEURS DU MONDE
                <br>EXCLUDING ALL EXTRAS
            </td>
        </tr>

        </tbody>
    </table>
    <table class="T6">
        <tbody>
        <tr>
            <td class="ttd6a">ISSUING OFFICE</td>
        </tr>
        <tr>
            <td>
                <input type="text" class="input2 issuing-office" value="{{$voucher->issued_by}}" readonly="">
            </td>
        </tr>
        <tr>
            <td class="ttd6b">STAMP</td>
        </tr>
        <tr>
            <td class="ttd6c">SIGNATURE</td>
        </tr>
        <tr>
            <td>
                <input type="text" class="input2" readonly="">
            </td>
        </tr>

        <tr>
            <td class="ttd6d"></td>
        </tr>
        <tr>
            <td class="ttd6e">FILE NO.</td>
        </tr>
        <tr>
            <td>
                <p type="text" class="input2 center-text" readonly="">{{$voucher->job_file->file_no}}</p>
            </td>

        </tr>

        </tbody>
    </table>
</div>

<div class="copy">
  
<div id="background">
    <p id="bg-text">COPY</p>
	</div>

    <table class="table-25 logoarea">
        <tbody>
        <tr class="logo-form">
            <td>
                <img src="{{asset('assets/images/logo-dark.png')}}">
            </td>
        </tr>
        <tr class="address font-12">
            <td>
                <strong>2 ABDELLATIF ELSOFANI STREET
                    <br> (CORNER NO.11 -SHERIF STREET)CAIRO
                    <br> TEL.:+20223962263 +20223962264
                    <br> +20223962265 FAX.:+20223962261
                </strong>
            </td>
        </tr>
        </tbody>
    </table>
    <table class="t1">
        <tbody>
        <tr>
            <td class="service md-font bold">RESTAURANT VOUCHER</td>
            <td width="2%"></td>
            <td class="serial md-font">
                <input type="text" value="{{$voucher->serial_no}}" class="input1 md-font center-text red-color" readonly="">
            </td>
        </tr>
        </tbody>
    </table>

    <table class="t2">
        <tbody>
        <tr>
            <td class="ttd2" width="4%">TO</td>
            <td>
                <p type="text" class="input1 md-font" readonly="">{{$voucher->to}}</p>
            </td>
        </tr>
        </tbody>
    </table>


    <table class="t3">
        <tbody>
        <tr>
            <td class="ttd3" width="21%">NAME OF GUEST</td>
            <td>
                <input type="text" value="{{$voucher->job_file->client_name}}" class="input1 md-font" readonly="">
            </td>
        </tr>
        </tbody>
    </table>
    <table class="T5">
        <tbody>
        <tr>
            <td>KINDLY PROVIDE THE HOLDER WITH THE SERVICE LISTED BELOW : </td>
        </tr>
        <tr>
            <td id="ovrflwVsble">
                <textarea rows="18" cols="140" value="" class="textarea" readonly="">{{$voucher->details}}</textarea>
            </td>
        </tr>
        <tr>
            <td class="ttd5 font-12">THIS VOUCHER ENCLOSED WITH YOUR INVOICE WILL BE PAID BY VOYAGEURS DU MONDE
                <br>EXCLUDING ALL EXTRAS
            </td>
        </tr>

        </tbody>
    </table>
    <table class="T6">
        <tbody>
        <tr>
            <td class="ttd6a">ISSUING OFFICE</td>
        </tr>
        <tr>
            <td>
                <input type="text" class="input2 issuing-office" value="{{$voucher->issued_by}}" readonly="">
            </td>
        </tr>
        <tr>
            <td class="ttd6b">STAMP</td>
        </tr>
        <tr>
            <td class="ttd6c">SIGNATURE</td>
        </tr>
        <tr>
            <td>
                <input type="text" class="input2" readonly="">
            </td>
        </tr>

        <tr>
            <td class="ttd6d"></td>
        </tr>
        <tr>
            <td class="ttd6e">FILE NO.</td>
        </tr>
        <tr>
            <td>
                <p type="text" class="input2 center-text" readonly="">{{$voucher->job_file->file_no}}</p>
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
