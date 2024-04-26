<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accepted Requests PDF</title>
    <style>
        /* Add your custom styles for the PDF here */
    </style>
</head>
<body>
    <h1>Accepted Requests</h1>
    <table>
        <thead>
            <tr>
                <th>Contact Name</th>
                <th>Contact Email</th>
                <th>Content</th>
                <th>Quantity</th>
                <th>Unit Cost</th>
                <th>Total Cost</th>
                <th>Labor Needed</th>
                <!-- Add other columns as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach ($acceptedRequests as $request)
                <tr>
                    <td>{{ $request->contact->name }}</td>
                    <td>{{ $request->contact->email }}</td>
                    <td>{{ $request->content }}</td>
                    <td>{{ $request->quantity }}</td>
                    <td>{{ $request->unit_cost }}</td>
                    <td>{{ $request->total_cost }}</td>
                    <td>{{ $request->labor_needed }}</td>
                    <!-- Add other columns as needed -->
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
