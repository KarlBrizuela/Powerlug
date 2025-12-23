@component('mail::message')
# Insurance Policy Renewal Reminder

Dear {{ $client_name }},

We hope this message finds you well. This is a friendly reminder that your insurance policy is due for renewal soon.

## Policy Details:
- **Policy Number:** {{ $policy_number }}
- **Insurance Provider:** {{ $insurance_provider }}
- **Renewal Due Date:** {{ $due_date }}
- **Coverage Amount:** ₱{{ number_format($coverage_amount, 2) }}
- **Vehicle Plate Number:** {{ $plate_number }}

Please ensure that your policy is renewed before the due date to avoid any coverage gaps. If you have any questions or need assistance with the renewal process, please don't hesitate to contact us.

@component('mail::button', ['url' => route('dashboard')])
View Your Policy
@endcomponent

Thank you for your business!

Best regards,  
**Powerlug Team**
@endcomponent
