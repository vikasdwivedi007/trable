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
    <title>View Invoice {{$invoice->number}}</title>


    <!-- STYLE -->
    <link id="darkTheme" rel="stylesheet" href="{{asset('assets/css/pages/view-invoice.css')}}">

</head>

<body>

<div class="main">
    <table class="T0">
        <tbody>
        <tr>
            <td class="text-center bold prFont-20">
                Facture No
                <input type="text" value="{{$invoice->number}}" class="ToA bold md-font">
            </td>
            <!-- <td></td> -->
        </tr>

        </tbody>
    </table>
    <table class="Table-half">
        <tbody>
        <tr>
            <td>
                <p class="fw-700"> <span class="fw-900">EXPEDITEUR:</span> VOYAGEURS DU MONDE- EGYPT<br />
                    <span style="margin-left:109px;">2 ABD EL LATIF EL SOFANI STREET</span>
                </p>
            </td>

        </tr>

        </tbody>
    </table>
    <table class="Table-half xHeight">
        <tbody>
        <tr>
            <td width="16%" class="bold">O/REF:
            </td>
            <td><input type="text" value="{{$invoice->draft_invoice->job_file->file_no}}" class="To bold prFont-14"></td>
        </tr>
        </tbody>
    </table>
    <table class="Table-half">
        <tbody>
        <tr>
            <td>
                <p class="fw-900">DESTINATAIRE: </p>
            </td>
            <td>
                <input type="text" value="{{$invoice->draft_invoice->job_file->travel_agent->name}}" class="To bold prFont-14">
            </td>

        </tr>
        <tr>
            <td width="10%"></td>
            <td><input type="text" value="{{$invoice->draft_invoice->job_file->travel_agent->address}}" class="To bold prFont-14"></td>

        </tr>

        </tbody>
    </table>
    <table class="Table-half xHeight-62">
        <tbody>
        <tr>
            <td width="16%" class="bold">NOM:
            </td>
            <td><input type="text" value="{{$invoice->draft_invoice->job_file->client_name}}" class="To bold prFont-14"></td>
        </tr>
        <tr>
            <td width="16%" class="bold">CMD:
            </td>
            <td><input type="text" value="{{$invoice->draft_invoice->job_file->command_no}}" class="To bold prFont-14"></td>
        </tr>
        </tbody>
    </table>
    <table class="Table-half">
        <tbody>
        <tr>
            <td width="40%">
                <p class="fw-900">DATE FACTURE: </p>
            </td>
            <td>
                <input type="text" value="{{$invoice->date->format('d F Y')}}" class="To bold prFont-14">
            </td>

        </tr>

        </tbody>
    </table>
    <table class="Table-half">
        <tbody>
        <tr>
            <td width="16%" class="bold">ARR:</td>
            <td><input type="text" value="{{$invoice->draft_invoice->job_file->arrival_date->format('d-m-Y')}}" class="To bold prFont-14"></td>
            <td width="16%" class="bold">DEP:</td>
            <td><input type="text" value="{{$invoice->draft_invoice->job_file->departure_date->format('d-m-Y')}}" class="To bold prFont-14"></td>
        </tr>
        </tbody>
    </table>
    <table class="t1">
        <tbody>
        <tr>
            <td width="70%" class="text-center bold border-right border-bottom">Descriptions</td>
            <td width="10%" class="text-center bold border-right border-bottom">Prix</td>
            <td width="10%" class="text-center bold border-right border-bottom">TVA 14%</td>
            <td width="10%" class="text-center bold border-right border-bottom">Total</td>
        </tr>
        @foreach($invoice->items as $item)
        <tr>
            <td width="70%" class="text-center bold border-right">
                        <textarea rows="3" cols="148" value="" class="textarea" readonly="">{{$item->details}}</textarea>
            </td>
            <td width="10%" class="text-center bold border-right">
                <input type="text" class="text-center input1" value="{{$item->price_without_vat}} {{\App\Models\Currency::currencyName($item->currency, true)}}" readonly="">
            </td>
            <td width="10%" class="text-center bold border-right">
                <input type="text" class="text-center input1" value="{{$item->price - $item->price_without_vat}} {{\App\Models\Currency::currencyName($item->currency, true)}}" readonly="">
            </td>
            <td width="10%" class="text-center bold border-right">
                <input type="text" class="text-center input1" value="{{$item->price}} {{\App\Models\Currency::currencyName($item->currency, true)}}" readonly="">
            </td>
        </tr>
        @endforeach
        <tr height="50">
            <td width="70%" class="bold border-top border-right">
                <!-- <input type="text" class="text-center input1" value="" readonly=""> -->
                Total :
            </td>
            <td width="10%" class="text-center bold border-top border-right">
                <input type="text" class="text-center input1" value="{{$invoice->total_without_vat}} {{\App\Models\Currency::currencyName($invoice->currency, true)}}" readonly="">
            </td>
            <td width="10%" class="text-center bold ttd5a">
            </td>
            <td width="10%" class="text-center bold ">
            </td>
        </tr>
        <tr height="50">
            <td width="70%" class="bold border-top">
                <!-- <input type="text" class="text-center input1" value="" readonly=""> -->
                14% TVA :
            </td>
            <td width="10%" class="text-center bold border-top border-right">
            </td>
            <td width="10%" class="text-center bold border-top border-right">
                <input type="text" class="text-center input1" value="{{$invoice->total - $invoice->total_without_vat}} {{\App\Models\Currency::currencyName($invoice->currency, true)}}" readonly="">
            </td>
            <td width="10%" class="text-center bold">
            </td>
        </tr>
        <tr height="50">
            <td width="70%" class="bold border-top">
                <!-- <input type="text" class="text-center input1" value="" readonly=""> -->
                Total Montant :
            </td>
            <td width="10%" class="text-center bold border-top">
            </td>
            <td width="10%" class="text-center bold border-top border-right">
            </td>
            <td width="10%" class="text-center bold  border-top">
                <input type="text" class="text-center input1" value="{{$invoice->total}} {{\App\Models\Currency::currencyName($invoice->currency, true)}}" readonly="">
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
