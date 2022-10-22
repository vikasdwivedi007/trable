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
    <title>View Draft Invoice {{$draftInvoice->number}}</title>


    <!-- STYLE -->
    <link id="darkTheme" rel="stylesheet" href="{{asset('assets/css/pages/view-draft-invoice.css')}}">

</head>

<body>

<div class="main">
    <table class="T2">
        <tbody>
        <tr>
            <td class="bold prFont-14 ">
                Request on Month:
            </td>
            <td>
                <input type="text" value=" Sept 2022" class="To bold md-font" readonly="{{$draftInvoice->job_file->request_date->format("M Y")}}">
            </td>
            <td class="bold prFont-14">
                File Name:
            </td>
            <td>
                <input type="text" value="{{$draftInvoice->job_file->client_name}}" class="To bold md-font">
            </td>
            <td width="5%" class="bold prFont-14">
                Base:
            </td>
            <td width="10%">
                <input type="text" value="{{$draftInvoice->job_file->adults_count + $draftInvoice->job_file->children_count}}" class="To bold md-font">
            </td>
            <td class="bold">Pax</td>
        </tr>

        </tbody>
    </table>

    <table class="Table-60">
        <tbody>
        <tr height="40">
            <td class="bold border-bottom pl-1">Benefits</td>
        </tr>
        @foreach($draftInvoice->items as $item)
            <tr>
                <td width="10%" class="border-bottom">
                    <input type="text" class="To bold md-font height-50 pl-1" value="{{$item->details}}" readonly="">
                </td>

            </tr>
        @endforeach
{{--        <tr>--}}
{{--            <td width="10%" class="border-bottom">--}}
{{--                <input type="text" class="To bold md-font height-50" value="City" readonly="">--}}
{{--            </td>--}}

{{--        </tr>--}}

        <tr>
            <td width="10%" class="border-bottom bold height-50  pl-1">
                Total without VAT
            </td>
        </tr>
        <tr>
            <td width="10%" class="border-bottom bold height-50  pl-1">
                VAT   14 %
            </td>
        </tr>
        <tr>
            <td width="10%" class="border-bottom bold height-50  pl-1">
                Gross Total with VAT
            </td>
        </tr>




        </tbody>
    </table>
    <table class="Table-40">
        <tbody>
        <tr>
            <td colspan="2" class="text-center bold border-right border-bottom">Single</td>
            <td colspan="2" class="text-center bold border-right border-bottom">Double</td>
        </tr>
        <tr>

            <td width="15%" class="text-center border-bottom border-right prFont-14">Without VAT</td>
            <td width="15%" class="text-center ttd5a prFont-14">VAT 14%</td>
            <td width="15%" class="text-center border-bottom border-right prFont-14">Without VAT</td>
            <td width="15%" class="text-center ttd5a prFont-14">VAT 14%</td>

        </tr>

        @foreach($draftInvoice->items as $item)
        <tr>
            @if(stripos($item->details, '- Double -') === false && stripos($item->details, 'Double Cabin') === false )
            <td width="15%" class="text-center bold border-bottom border-right">
                <input type="text" class="To bold md-font text-center height-50" value="{{$item->price}} {{\App\Models\Currency::currencyName($item->currency, true)}}" readonly="">
            </td>
            <td width="15%" class="text-center bold ttd5a">
                <input type="text" class="To bold md-font text-center height-50" value="{{$item->price - $item->price_without_vat}} {{\App\Models\Currency::currencyName($item->currency, true)}}" readonly="">
            </td>
            <td width="15%" class="text-center bold border-bottom border-right">
                <input type="text" class="To bold md-font text-center height-50" value="" readonly="">
            </td>
            <td width="15%" class="text-center bold ttd5a">
                <input type="text" class="To bold md-font text-center height-50" value="" readonly="">
            </td>
            @else
            <td width="15%" class="text-center bold border-bottom border-right">
                <input type="text" class="To bold md-font text-center height-50" value="" readonly="">
            </td>
            <td width="15%" class="text-center bold ttd5a">
                <input type="text" class="To bold md-font text-center height-50" value="" readonly="">
            </td>
            <td width="15%" class="text-center bold border-bottom border-right">
                <input type="text" class="To bold md-font text-center height-50" value="{{$item->price}} {{\App\Models\Currency::currencyName($item->currency, true)}}" readonly="">
            </td>
            <td width="15%" class="text-center bold ttd5a">
                <input type="text" class="To bold md-font text-center height-50" value="{{$item->price - $item->price_without_vat}} {{\App\Models\Currency::currencyName($item->currency, true)}}" readonly="">
            </td>
            @endif
        </tr>
        @endforeach

        <tr>
            <td width="15%" class="text-center bold border-bottom border-right" colspan="4">
                <input type="text" class="To bold md-font text-center height-48" value="{{$draftInvoice->total_without_vat}} {{\App\Models\Currency::currencyName($draftInvoice->currency, true)}}" readonly="">
            </td>
        </tr>
        <tr>
            <td width="15%" class="text-center bold border-bottom border-right" colspan="4">
                <input type="text" class="To bold md-font text-center height-48" value="{{$draftInvoice->total - $draftInvoice->total_without_vat}} {{\App\Models\Currency::currencyName($draftInvoice->currency, true)}}" readonly="">
            </td>
        </tr>
        <tr>
            <td width="15%" class="text-center bold border-bottom border-right" colspan="4">
                <input type="text" class="To bold md-font text-center height-48" value="{{$draftInvoice->total}} {{\App\Models\Currency::currencyName($draftInvoice->currency, true)}}" readonly="">
            </td>
        </tr>


        </tbody>
    </table>



</div>


<!-- END BODY -->


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
