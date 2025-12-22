<!DOCTYPE html>
<html>
<head>
    <title>Debug Claims</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        h2 { margin-top: 30px; }
        table { border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Claims & Clients Debug</h1>
    
    <h2>Claims in Database ({{ count($claims) }} total)</h2>
    @if(count($claims) === 0)
        <p><strong>No claims found!</strong></p>
    @else
        <table>
            <tr>
                <th>ID</th>
                <th>Client Name</th>
                <th>Policy #</th>
                <th>Claim #</th>
                <th>LOA Amount</th>
            </tr>
            @foreach($claims as $claim)
                <tr>
                    <td>{{ $claim->id }}</td>
                    <td>{{ $claim->client_name }}</td>
                    <td>{{ $claim->policy_number }}</td>
                    <td>{{ $claim->claim_number }}</td>
                    <td>{{ $claim->loa_amount }}</td>
                </tr>
            @endforeach
        </table>
    @endif
    
    <h2>Clients in Database ({{ count($clients) }} shown of total)</h2>
    @if(count($clients) === 0)
        <p><strong>No clients found!</strong></p>
    @else
        <table>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
            </tr>
            @foreach($clients as $client)
                <tr>
                    <td>{{ $client->id }}</td>
                    <td>{{ $client->firstName }}</td>
                    <td>{{ $client->lastName }}</td>
                    <td>{{ $client->email }}</td>
                </tr>
            @endforeach
        </table>
    @endif
</body>
</html>
