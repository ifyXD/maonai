@include('MicrosoftOffice.PDF')

{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2>Invoice for: {{ $invoiceData['contact']->name }}</h2>
                <p>Email: {{ $invoiceData['contact']->email }}</p>
                <p>Department: {{ $invoiceData['contact']->department }}</p>
                <p>Default Date: {{ $invoiceData['defaultDate'] }}</p> <!-- Show default date -->

                <p>Content: {{ $invoiceData['contact']->content }}</p>
                <p>Number of Labors: {{ $invoiceData['numLabors'] }}</p>
                <p>Number of Materials: {{ $invoiceData['numMaterials'] }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h3>Labors Needed</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Hours</th>
                            <th>Rate</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoiceData['labors'] as $labor)
                        <tr>
                            <td>{{ $labor->name }}</td>
                            <td>{{ $labor->hours }}</td>
                            <td>{{ $labor->rate }}</td>
                            <td>{{ $labor->amount }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="3"><strong>Total Labor Amount:</strong></td>
                            <td>{{ $invoiceData['totalLaborAmount'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h3>Materials</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Unit Cost</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoiceData['materials'] as $material)
                        <tr>
                            <td>{{ $material->material }}</td>
                            <td>{{ $material->quantity }}</td>
                            <td>{{ $material->unit_cost }}</td>
                            <td>{{ $material->amount }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="3"><strong>Total Material Amount:</strong></td>
                            <td>{{ $invoiceData['totalMaterialAmount'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 border-start border-end py-4">
                <div class="text-center">
                    <p><strong>Total Amount:</strong> {{ $invoiceData['overallTotalAmount'] }}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html> --}}
