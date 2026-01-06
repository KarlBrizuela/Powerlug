<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insurance Policy Renewal Reminder</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #f5f5f5;
            line-height: 1.6;
            color: #333;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .content {
            padding: 40px;
        }
        
        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
            color: #333;
        }
        
        .policy-details {
            background-color: #f9f9f9;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        
        .policy-details h3 {
            color: #667eea;
            font-size: 16px;
            margin-bottom: 15px;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: #555;
            width: 45%;
        }
        
        .detail-value {
            color: #333;
            text-align: right;
            width: 55%;
        }
        
        .custom-message {
            margin: 25px 0;
            padding: 20px;
            background-color: #fff9e6;
            border-radius: 4px;
            border-left: 4px solid #ffc107;
            line-height: 1.8;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 14px 40px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: 600;
            transition: opacity 0.3s;
        }
        
        .cta-button:hover {
            opacity: 0.9;
        }
        
        .footer {
            background-color: #f5f5f5;
            padding: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #e0e0e0;
        }
        
        .footer p {
            margin: 8px 0;
        }
        
        .footer-logo {
            font-weight: bold;
            color: #667eea;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Insurance Policy Renewal Reminder</h1>
            <p>Important notification regarding your policy</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Hello {{ $client_name }},
            </div>
            
            <p>We hope this message finds you well. This is a friendly reminder that your insurance policy is due for renewal soon.</p>
            
            @if($custom_body)
            <div class="custom-message">{{ $custom_body }}</div>
            @else
            <!-- Default Policy Details -->
            <div class="policy-details">
                <h3>📋 Your Policy Details</h3>
                <div class="detail-row">
                    <span class="detail-label">Policy Number</span>
                    <span class="detail-value">{{ $policy_number }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Insurance Provider</span>
                    <span class="detail-value">{{ $insurance_provider }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Renewal Due Date</span>
                    <span class="detail-value">{{ $due_date }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Coverage Amount</span>
                    <span class="detail-value">₱{{ number_format($coverage_amount, 2) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Vehicle Plate Number</span>
                    <span class="detail-value">{{ $plate_number }}</span>
                </div>
            </div>
            
            <p>Please ensure that your policy is renewed before the due date to avoid any coverage gaps. If you have any questions or need assistance with the renewal process, please don't hesitate to contact us.</p>
            @endif
            
            <p style="margin-top: 25px;">Thank you for your business!</p>
            
            <p style="margin-top: 15px;">
                Best regards,<br>
                <strong>Powerlug Team</strong>
            </p>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="footer-logo">🚗 Powerlug</div>
            <p>Powerlug Insurance & Services</p>
            <p>Email: noreply@powerlug.intra-code.com</p>
            <p style="margin-top: 15px; font-size: 11px; color: #999;">
                This is an automated message. Please do not reply to this email.
            </p>
        </div>
    </div>
</body>
</html>
