@php
    $settings = App\Models\Settings::get()->keyBy('key');
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Receipt</title>
</head>

<body>
    <table>
        <tr>
            <td> <img
                    src="{{ public_path($settings['site_logo']->value ? 'storage/' . $settings['site_logo']->value : 'images/logo.png') }}"
                    alt="Logo" width="100"></td>
            <td>
                <h2 style="margin: 0">{{ $settings['site_name']->value }}</h2>
                <div>
                    <p style="margin: 0">Email: {{ $settings['site_email']->value }}</p>
                    <p style="margin: 0">Contact No:{{ $settings['site_contact']->value }}</p>
                </div>
            </td>
        </tr>
    </table>
    <table width="100%" style="margin-top:20px">
        <tr>
            <td style="background-color: #4B4AAC">
                <h4 style="text-align: center; color:white; margin: 10px 0">ACKNOWLEDGEMENT RECEIPT</h4>
            </td>
        </tr>
    </table>
    <div style="margin-top: 30px">
        <p>DATE PAID: <b><u>{{ date('F d, Y', strtotime($receipt->transaction_date)) }}</u></b>.
        </p>
    </div>
    @php
        $null = $receipt->tenant->name ?? 'null';
    @endphp

    @if ($null == 'null')
        <div style="margin-top: 30px">
            <p>Received from
                <b><u>{{ strtoupper($receipt->payment->rent->tenant->name) }}</u></b>
                the amount of <b><u>PHP
                        {{ number_format($receipt->amount, 2) }}</u></b> {{ $receipt->payment_method }} representing
                the payment due on <b><u>{{ date('F d, Y', strtotime($receipt->payment->due_date)) }}</u></b>
                for {{ $receipt->payment->rent->rent_type }}
                lease.
            </p>

        </div>

        <div style="margin-top: 30px">
            <p>This payment is for the lease of <b><u>{{ $receipt->payment->rent->property->property_name }}</u></b> at
                <b><u>{{ $receipt->payment->rent->property->location }}</u></b>.
            </p>

        </div>
    @else
        <div style="margin-top: 30px">
            <p>Received from
                <b><u>{{ strtoupper($receipt->tenant->name) }}</u></b>
                the amount of <b><u>PHP
                        {{ number_format($receipt->amount, 2) }}</u></b> {{ $receipt->payment_method }} representing
                the payment for acquiring the property <b><u>{{ $receipt->property->property_name }}</u></b>
                at
                <b><u>{{ $receipt->property->location }}</u></b>.
            </p>

        </div>
    @endif


    <table width="100%" style="margin-top: 40px;">
        <tr>
            <td>
                <small>Received By:</small>
            </td>
            <td>
            </td>
        </tr>
        <tr>
            <td>
                <p style="margin: 0; margin-top: 30px;"><u><b> _____________________</b></u>
                </p>
                <small>SIGNATURE OVER PRINTED NAME </small>
            </td>
            <td style="text-align: center">
            </td>
        </tr>
        <tr>
            <td>
                <p style="margin: 0; margin-top: 30px;"><u><b> _____________________</b></u>
                </p>
                <small>DATE RECEIVED </small>
            </td>
            <td style="text-align: center">
            </td>
        </tr>
    </table>
    <div style="margin-top: 40px">
        <small style="margin: 0; margin-top:50px">Date Generated: {{ date('F d, Y h:i:s A') }}</small><br>
        <small style="margin: 0">Generated Thru: {{ $settings['site_sys_name']->value }}</small>
    </div>
</body>

</html>
