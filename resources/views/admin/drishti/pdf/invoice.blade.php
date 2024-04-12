<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        .text-red {
            color: red;
        }

        .h4 {
            font-size: large;
        }

        .h5 {
            font-size: 12px;
        }

        .fw-bold {
            font-weight: bold;
        }

        .mt-3 {
            margin-top: 30px;
        }

        th {
            font-size: 10px;
            font-weight: bold;
            padding: 5px;
        }

        td {
            font-size: 10px;
            padding: 5px;
        }

        .border th,
        .border td {
            border: 1px solid gray;
        }

        .text-end {
            text-align: right;
        }
    </style>
</head>

<body>
    <div>
        <table width="100%" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td width="50%">
                        <span class="h4 text-red">DRISHTI BIOTECH</span><br />
                        <span class="h5">SREEVARAHAM, SREENAGAR, TRIVANDRUM</span><br />
                        <span class="h5">9995273040</span>
                    </td>
                    <td width="50%">
                        <span class="h4">{{ $order->customer->name }}</span><br />
                        <span class="h5">{{ $order->customer->address }}</span><br />
                        <span class="h5">{{ $order->customer->contact_number }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        <center><span class="h5 fw-bold"></span>Tax Invoice / Credit</center>
    </div>
    <div class="mt-3">
        <table width="100%" cellspacing="0" cellpadding="0" class="border">
            <thead>
                <tr>
                    <th>SL No</th>
                    <th>Description of Goods</th>
                    <th>HSN</th>
                    <th>GST</th>
                    <th>Batch</th>
                    <th>Expiry</th>
                    <th>Qty</th>
                    <th>Free Qty</th>
                    <th>PTS</th>
                    <th>PTR</th>
                    <th>MRP</th>
                    <th>Total</th>
                    <th>Taxable Value</th>
                </tr>
            </thead>
            <tbody>
                @forelse($order->details as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->product->subcategory->hsn }}</td>
                    <td class="text-end">{{ $item->product->tax_percentage }}</td>
                    <td>{{ $item->batch_number }}</td>
                    <td>{{ $item->expiry_date ? $item->expiry_date->format('d.M.Y') : '' }}</td>
                    <td class="text-end">{{ $item->qty }}</td>
                    <td class="text-end">{{ $item->qty_free }}</td>
                    <td></td>
                    <td></td>
                    <td class="text-end">{{ $item->price }}</td>
                    <td class="text-end">{{ $item->total }}</td>
                    <td class="text-end">{{ $item->total }}</td>
                </tr>
                @empty
                @endforelse
                <tr>
                    <td colspan="13"><br /><br /><br /><br /><br /><br /></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-end" colspan="12">Total</th>
                    <th class="text-end">{{ $order->total }}</th>
                </tr>
                <tr>
                    <th class="text-end" colspan="12">Discount</th>
                    <th class="text-end">{{ $order->discount }}</th>
                </tr>
                <tr>
                    <th class="text-end" colspan="12">Amount Due</th>
                    <th class="text-end">{{ $order->total_after_discount }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>