<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Ticket</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background: #fff;
            background-image: none;
            font-size: 12px;
        }
        address{
            margin-top:15px;
        }
        h2 {
            font-size:28px;
            color:#cccccc;
        }
        .container {
            padding-top:30px;
        }
        .ticket-head td {
            padding: 0 8px;
        }
        .ticket-body{
            background-color:transparent;
        }
        .logo {
            padding-bottom: 10px;
        }
        .table th {
            vertical-align: bottom;
            font-weight: bold;
            padding: 8px;
            line-height: 20px;
            text-align: left;
        }
        .table td {
            padding: 8px;
            line-height: 20px;
            text-align: left;
            vertical-align: top;
            border-top: 1px solid #dddddd;
        }
        .well {
            margin-top: 15px;
        }
    </style>
</head>

<body>
<div class="container">
    <table style="margin-left: auto; margin-right: auto" width="550">
        <tr>
            <td width="160">
                &nbsp;
            </td>

            <!-- Organization Name / Image -->
            <td align="right">
                <strong>{{ $header ?? $vendor }}</strong>
            </td>
        </tr>
        <tr valign="top">
            <td style="font-size:28px;color:#cccccc;">
                    Receipt
            </td>

            <!-- Organization Name / Date -->
            <td>
                <br><br>
                <strong>To:</strong> {{ $owner->email ?: $owner->name }}
                <br>
                <strong>Date:</strong> {{ $ticket->date()->toFormattedDateString() }}
            </td>
        </tr>
        <tr valign="top">
            <!-- Organization Details -->
            <td style="font-size:9px;">
                {{ $vendor }}<br>
                @if (isset($street))
                    {{ $street }}<br>
                @endif
                @if (isset($location))
                    {{ $location }}<br>
                @endif
                @if (isset($phone))
                    <strong>T</strong> {{ $phone }}<br>
                @endif
                @if (isset($vendorVat))
                    {{ $vendorVat }}<br>
                @endif
                @if (isset($url))
                    <a href="{{ $url }}">{{ $url }}</a>
                @endif
            </td>
            <td>
                <!-- Ticket Info -->
                <p>
                    <strong>Product:</strong> {{ $product }}<br>
                    <strong>Ticket Number:</strong> {{ $id ?? $ticket->id }}<br>
                </p>

                <!-- Extra / VAT Information -->
                @if (isset($vat))
                    <p>
                        {{ $vat }}
                    </p>
                @endif

                <br><br>

                <!-- Ticket Table -->
                <table width="100%" class="table" border="0">
                    <tr>
                        <th align="left">Description</th>
                        <th align="right">Date</th>
                        <th align="right">Amount</th>
                    </tr>

                    <!-- Existing Balance -->
                    <tr>
                        <td>Starting Balance</td>
                        <td>&nbsp;</td>
                        <td>{{ $ticket->startingBalance() }}</td>
                    </tr>

                    <!-- Display The Ticket Items -->
                    @foreach ($ticket->ticketItems() as $item)
                        <tr>
                            <td colspan="2">{{ $item->description }}</td>
                            <td>{{ $item->total() }}</td>
                        </tr>
                    @endforeach

                    <!-- Display The Subscriptions -->
                    @foreach ($ticket->subscriptions() as $subscription)
                        <tr>
                            <td>Subscription ({{ $subscription->quantity }})</td>
                            <td>
                                {{ $subscription->startDateAsCarbon()->formatLocalized('%B %e, %Y') }} -
                                {{ $subscription->endDateAsCarbon()->formatLocalized('%B %e, %Y') }}
                            </td>
                            <td>{{ $subscription->total() }}</td>
                        </tr>
                    @endforeach

                    <!-- Display The Discount -->
                    @if ($ticket->hasDiscount())
                        <tr>
                            @if ($ticket->discountIsPercentage())
                                <td>{{ $ticket->coupon() }} ({{ $ticket->percentOff() }}% Off)</td>
                            @else
                                <td>{{ $ticket->coupon() }} ({{ $ticket->amountOff() }} Off)</td>
                            @endif
                            <td>&nbsp;</td>
                            <td>-{{ $ticket->discount() }}</td>
                        </tr>
                    @endif

                    <!-- Display The Tax Amount -->
                    @if ($ticket->tax_percent)
                        <tr>
                            <td>Tax ({{ $ticket->tax_percent }}%)</td>
                            <td>&nbsp;</td>
                            <td>{{ Laravel\Cashier\Cashier::formatAmount($ticket->tax) }}</td>
                        </tr>
                    @endif

                    <!-- Display The Final Total -->
                    <tr style="border-top:2px solid #000;">
                        <td>&nbsp;</td>
                        <td style="text-align: right;"><strong>Total</strong></td>
                        <td><strong>{{ $ticket->total() }}</strong></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
