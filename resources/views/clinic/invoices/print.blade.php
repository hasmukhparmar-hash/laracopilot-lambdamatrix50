<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->bill_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>@media print { .no-print { display:none; } body { print-color-adjust: exact; } }</style>
</head>
<body class="bg-white p-8 max-w-3xl mx-auto">
    <div class="flex justify-between items-start mb-8">
        <div>
            <div class="text-2xl font-bold text-blue-700">HealthCare Clinic</div>
            <div class="text-sm text-gray-500">123 Medical Street, City - 400001</div>
            <div class="text-sm text-gray-500">Tel: +91 98765 43210 | clinic@healthcare.com</div>
        </div>
        <div class="text-right">
            <div class="text-3xl font-bold text-gray-700">INVOICE</div>
            <div class="text-lg font-mono text-gray-600">{{ $invoice->bill_number }}</div>
            <div class="text-sm text-gray-500">Date: {{ $invoice->bill_date->format('d M Y') }}</div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6 mb-8">
        <div class="border border-gray-200 rounded-lg p-4">
            <div class="text-xs font-bold text-gray-400 uppercase mb-1">Bill To</div>
            <div class="font-bold">{{ $invoice->patient->name ?? 'N/A' }}</div>
            <div class="text-sm text-gray-600">ID: {{ $invoice->patient->patient_id ?? '' }}</div>
            <div class="text-sm text-gray-600">{{ $invoice->patient->phone ?? '' }}</div>
        </div>
        <div class="border border-gray-200 rounded-lg p-4">
            <div class="text-xs font-bold text-gray-400 uppercase mb-1">Attending Doctor</div>
            <div class="font-bold">{{ $invoice->doctor->name ?? 'N/A' }}</div>
            <div class="text-sm text-gray-600">{{ $invoice->doctor->specialization ?? '' }}</div>
        </div>
    </div>

    <table class="min-w-full border border-gray-200 mb-6">
        <thead><tr class="bg-blue-700 text-white">
            <th class="px-4 py-3 text-left text-sm">Description</th>
            <th class="px-4 py-3 text-center text-sm">Qty</th>
            <th class="px-4 py-3 text-right text-sm">Rate</th>
            <th class="px-4 py-3 text-right text-sm">Amount</th>
        </tr></thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr class="border-b border-gray-100"><td class="px-4 py-3 text-sm">{{ $item->description }}</td><td class="px-4 py-3 text-sm text-center">{{ $item->quantity }}</td><td class="px-4 py-3 text-sm text-right">₹{{ number_format($item->unit_price, 2) }}</td><td class="px-4 py-3 text-sm text-right font-medium">₹{{ number_format($item->total, 2) }}</td></tr>
            @endforeach
        </tbody>
    </table>

    <div class="flex justify-end mb-8">
        <div class="w-64">
            <div class="flex justify-between text-sm py-1"><span class="text-gray-500">Subtotal:</span><span>₹{{ number_format($invoice->subtotal, 2) }}</span></div>
            @if($invoice->discount > 0)<div class="flex justify-between text-sm py-1 text-green-600"><span>Discount:</span><span>-₹{{ number_format($invoice->discount, 2) }}</span></div>@endif
            <div class="flex justify-between text-lg font-bold border-t pt-2"><span>TOTAL:</span><span class="text-blue-700">₹{{ number_format($invoice->total_amount, 2) }}</span></div>
            <div class="mt-2 text-sm">Status: <span class="font-semibold {{ $invoice->payment_status === 'paid' ? 'text-green-600' : 'text-orange-600' }}">{{ strtoupper($invoice->payment_status) }}</span></div>
        </div>
    </div>

    <div class="border-t pt-6 grid grid-cols-2 gap-8">
        <div>
            <div class="text-sm text-gray-500 mb-1">Patient Signature</div>
            <div class="border-b border-gray-400 h-8"></div>
        </div>
        <div class="text-right">
            <div class="text-sm text-gray-500 mb-1">Authorized Signature</div>
            <div class="border-b border-gray-400 h-8"></div>
            <div class="text-xs text-gray-400 mt-1">HealthCare Clinic</div>
        </div>
    </div>

    <div class="no-print mt-6 text-center">
        <button onclick="window.print()" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 font-medium"><i class="fas fa-print mr-2"></i>Print</button>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</body>
</html>
