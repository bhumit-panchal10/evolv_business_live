<p>Dear {{ $Data['business_to'] }},</p>

<p>Your business with ID {{ $businessId }} has been created successfully.</p>

<p>Details:</p>
<ul>
    <li>Type: {{ $Data['business_type'] }}</li>
    <li>From: {{ $Data['business_from'] }}</li>
    <li>Amount:{{ $Data['Business_amount'] }}</li>
    <li>Date: {{ $Data['business_Date'] }}</li>
</ul>

<p>Thank you for using our service!</p>