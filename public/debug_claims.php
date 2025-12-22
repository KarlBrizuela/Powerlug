<?php
require '../bootstrap/app.php';

$app = app();

// Get claims
echo "<h2>Claims in Database</h2>";
$claims = \App\Models\Claim::select('id', 'client_name', 'policy_number', 'claim_number', 'loa_amount')->get();

if ($claims->count() == 0) {
    echo "<p>No claims found in database</p>";
} else {
    echo "<table border='1' style='border-collapse: collapse; padding: 5px;'><tr><th style='padding: 5px; border: 1px solid black;'>ID</th><th style='padding: 5px; border: 1px solid black;'>Client Name</th><th style='padding: 5px; border: 1px solid black;'>Policy #</th><th style='padding: 5px; border: 1px solid black;'>Claim #</th><th style='padding: 5px; border: 1px solid black;'>LOA Amount</th></tr>";
    foreach ($claims as $claim) {
        echo "<tr>";
        echo "<td style='padding: 5px; border: 1px solid black;'>{$claim->id}</td>";
        echo "<td style='padding: 5px; border: 1px solid black;'>{$claim->client_name}</td>";
        echo "<td style='padding: 5px; border: 1px solid black;'>{$claim->policy_number}</td>";
        echo "<td style='padding: 5px; border: 1px solid black;'>{$claim->claim_number}</td>";
        echo "<td style='padding: 5px; border: 1px solid black;'>{$claim->loa_amount}</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Get clients
echo "<h2 style='margin-top: 20px;'>Clients in Database</h2>";
$clients = \App\Models\Client::select('id', 'firstName', 'lastName', 'email')->limit(20)->get();

if ($clients->count() == 0) {
    echo "<p>No clients found</p>";
} else {
    echo "<table border='1' style='border-collapse: collapse; padding: 5px;'><tr><th style='padding: 5px; border: 1px solid black;'>ID</th><th style='padding: 5px; border: 1px solid black;'>First Name</th><th style='padding: 5px; border: 1px solid black;'>Last Name</th><th style='padding: 5px; border: 1px solid black;'>Email</th></tr>";
    foreach ($clients as $client) {
        echo "<tr>";
        echo "<td style='padding: 5px; border: 1px solid black;'>{$client->id}</td>";
        echo "<td style='padding: 5px; border: 1px solid black;'>{$client->firstName}</td>";
        echo "<td style='padding: 5px; border: 1px solid black;'>{$client->lastName}</td>";
        echo "<td style='padding: 5px; border: 1px solid black;'>{$client->email}</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>
