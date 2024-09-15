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
        <p>DATE PAID: <b><u>{{ date('F d, Y', strtotime($receipt->date_paid)) }}</u></b>.
        </p>
    </div>
    <div style="margin-top: 30px">
        <p>Received from <b><u>{{ strtoupper($receipt->rent->tenant->name) }}</u></b> the amount of <b><u>PHP
                    {{ number_format($receipt->amount, 2) }}</u></b> {{ $receipt->rent->payment_method }} representing
            the payment due on <b><u>{{ date('F d, Y', strtotime($receipt->due_date)) }}</u></b>
            for {{ $receipt->rent->rent_type }}
            lease.
        </p>

    </div>

    <div style="margin-top: 30px">
        <p>This payment is for the lease of <b><u>{{ $receipt->rent->property->property_name }}</u></b> at
            <b><u>{{ $receipt->rent->property->location }}</u></b>.
        </p>

    </div>
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
    {{-- <div style="margin-top: 30px">
        <p style="margin: 0;"><b>II. THE PREMISES:</b> The Landlord/Owner agree to rent the following property to the
            Tenant/Renter
            for the Payment Terms in Section IV:
        </p>
        <p style="margin: 0;"><u>Property Name</u>: <u><b>{{ ucwords($rent->property->property_name) }}</b></u>.
        </p>
        <p style="margin: 0;"><u>Property Address</u>: <u><b>{{ ucwords($rent->property->location) }}</b></u>.
        </p>
    </div>
    <div style="margin-top: 30px">
        <p style="margin: 0;"><b>III. LEASE TYPE:</b> This Agreement shall be considered a:
        </p>
        <p style="margin: 0;"><u>{{ $rent->rent_type == 'monthly' ? 'Month-to-month' : 'Year-to-year' }} Lease</u>. The
            Tenant/Renter
            shall be allowed to occupy the Premises starting on a
            {{ $rent->rent_type == 'monthly' ? 'month-to-month' : 'year-to-year' }} arrangement starting on
            <u><b>{{ date('F d, Y', strtotime($rent->start_date)) }}</b></u>, and
            ending on <u><b>{{ date('F d, Y', strtotime($rent->end_date)) }}</b></u> ("{{ $rent->terms }} Lease
            Term"). At the
            end of
            the Lease Term, the Landlord/Owner and Tenant/Renter shall required to negotiate
            renewal options, or the Tenant/Renter will be forced to vacate the premises.
        </p>
        </p>
    </div>
    <div style="margin-top: 30px">
        <p style="margin: 0;"><b>IV. PAYMENT TERMS:</b> During the Lease Terms, the Tenant/Renter shall responsible for
            the following:
        </p>
        <p style="margin: 0;"><u>{{ ucwords($rent->rent_type) }} Rent</u>. PHP
            <u><b>
                    {{-- calculate the payment --}}
    {{-- @php
        $amount = $rent->discount > 0 ? $rent->terms * ($rent->amount - $rent->amount * ($rent->discount / 100)) : $rent->terms * $rent->amount;
    @endphp
    {{ number_format($amount, 2) }}</b></u> due on the
    <u><b>{{ $rent->rent_type == 'monthly' ? date('jS', strtotime($rent->start_date)) . ' of each month.' : date('F d', strtotime($rent->start_date)) . ' of year.' }}</b></u>
    </p>
    <p style="margin: 0;"><u>Security Deposit</u>. PHP
        <u><b> {{ number_format($rent->deposit, 2) }}</b></u> due at signing of this Agreement.
    </p>
    <p style="margin: 0;"><u>Other</u>. ________________________________________.</p>
    </div>
    <div style="margin-top: 30px">
        <p style="margin: 0;"><b>V. UTILITIES:</b> The Tenant/Renter shall be responsible for all utilities and services
            to the
            Premises except for: _____________________________________.
        </p>
    </div>
    <div style="margin-top: 30px">
        <p style="margin: 0;"><b>VI. ADDITIONAL TERMS:</b> ____________________________________________.
        </p>
    </div>
    <div style="margin-top: 30px">
        <p style="margin: 0;"><b>CONTRACT STATUS:</b> <u><b> {{ strtoupper($rent->status) }}</b></u>.
        </p>
    </div>
    <table width="100%">
        <tr>
            <td>
                <small>Landlord's/Owner's</small>
            </td>
            <td>
                <small>Tenant's/Renter's</small>
            </td>
        </tr>
        <tr>
            <td style="text-align: center">
                <p style="margin: 0; margin-top: 50px;"><u><b> {{ strtoupper($rent->property->owner->name) }}</b></u>
                </p>
                <small>SIGNATURE OVER PRINTED NAME </small>
            </td>
            <td style="text-align: center">
                <p style="margin: 0;margin-top: 50px;"><u><b>{{ strtoupper($rent->tenant->name) }}</b></u></p>
                <small>SIGNATURE OVER PRINTED NAME </small>
            </td>
        </tr>
    </table> --}}
    <div style="margin-top: 40px">
        <small style="margin: 0; margin-top:50px">Date Generated: {{ date('F d, Y h:i:s A') }}</small><br>
        <small style="margin: 0">Generated Thru: {{ $settings['site_sys_name']->value }}</small>
    </div>
</body>

</html>
