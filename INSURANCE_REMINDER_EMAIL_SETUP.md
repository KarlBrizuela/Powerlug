# Insurance Reminder Email Implementation

## Overview
This implementation allows users to send insurance renewal reminder emails directly from the Insurance Expiration Reminder modal in the dashboard.

## How It Works

### Frontend (JavaScript)
1. When a user clicks on a policy name in the Insurance Expiration Reminder table, the modal opens
2. The policy ID is stored in `currentPolicyId` variable
3. When the "Send Reminder" button is clicked, JavaScript:
   - Makes an AJAX POST request to `/api/send-insurance-reminder`
   - Passes the policy ID to the backend
   - Shows loading state while processing
   - Displays success/error message to the user

### Backend (Laravel)
1. **Route**: `/api/send-insurance-reminder` (POST) - Protected route in `routes/web.php`
2. **Controller Method**: `DashboardController@sendInsuranceReminder()`
   - Retrieves the policy and related data (client, insurance provider, vehicle)
   - Validates that the client has an email address
   - Sends the email using Laravel's Mail facade
   - Returns JSON response (success or error)

3. **Mail Class**: `App\Mail\InsuranceReminderMail`
   - Defines the email subject and view
   - Passes policy data to the email template
   - Uses Laravel Mailable pattern for clean code

4. **Email Template**: `resources/views/emails/insurance-reminder.blade.php`
   - Professional email layout using Bootstrap mail components
   - Displays policy details: number, due date, coverage amount, vehicle info
   - Includes call-to-action button to view the policy

## Files Created/Modified

### New Files:
- `app/Mail/InsuranceReminderMail.php` - Mail class for formatting emails
- `resources/views/emails/insurance-reminder.blade.php` - Email template

### Modified Files:
- `routes/web.php` - Added new route for sending reminders
- `app/Http/Controllers/DashboardController.php` - Added import and new method
- `resources/views/pages/dashboard.blade.php` - Updated JavaScript and button

## Requirements

Your Laravel application must have:
1. Mail configuration in `.env` file (MAIL_DRIVER, MAIL_FROM_ADDRESS, etc.)
2. A `Client` model with an `email` field
3. A `Policy` model with relations to `Client`, `InsuranceProvider`, and `Vehicle`

## Example Mail Configuration (.env)

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@powerlug.com"
MAIL_FROM_NAME="Powerlug"
```

Or for localhost testing, use Laravel's default `log` driver:
```
MAIL_MAILER=log
```

## Testing

1. Open the dashboard and click on a policy in the "Insurance Expiration Reminder" section
2. The modal will open with policy details
3. Click the "Send Reminder" button (green button with envelope icon)
4. You'll see a loading state, then a success or error message
5. Check the client's email inbox (or check logs if using `MAIL_MAILER=log`)

## Error Handling

The implementation includes proper error handling:
- If client has no email address: Shows error message
- If email sending fails: Shows error with exception message
- Invalid policy ID: Returns 404 error
- Server errors: Returns 500 error with message

## Future Enhancements

You could extend this by:
1. Adding email templates for other reminder types (payment reminders)
2. Implementing email history/logging
3. Sending batch emails to multiple clients
4. Adding email scheduling/queue processing
5. Customizing email templates per client or insurance provider
