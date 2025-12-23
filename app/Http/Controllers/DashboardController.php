<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Policy;
use App\Models\Service;
use App\Models\Installment;
use App\Models\WalkIn;
use App\Models\AuditTrail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total clients count
        $totalClients = Client::count();

        // Get total policies count
        $totalPolicies = Policy::count();

        // Get insurance expiration reminders (policies expiring within 2 months)
        $expiringPolicies = $this->getExpiringPolicies();

        // Get payment reminders (policies with outstanding payments and service payment dues)
        $paymentReminders = $this->getPaymentReminders();

        return view('pages.dashboard', compact('totalClients', 'totalPolicies', 'expiringPolicies', 'paymentReminders'));
    }

    private function getExpiringPolicies()
    {
        $today = Carbon::now();
        $oneMonthFromNow = Carbon::now()->addMonths(1);

        // Get policies expiring within the next 1 month (reminder appears 1 month before expiration)
        // Include policies where expiration_status is not 'availed'
        $policies = Policy::with(['client', 'insuranceProvider'])
            ->where(function($query) use ($today, $oneMonthFromNow) {
                // Get upcoming policies (within 1 month from today)
                $query->whereBetween('end_date', [$today, $oneMonthFromNow])
                      // OR get overdue policies (past due date)
                      ->orWhere('end_date', '<', $today);
            })
            ->where(function($query) {
                // Exclude policies marked as 'availed'
                $query->whereNull('expiration_status')
                      ->orWhere('expiration_status', '!=', 'availed');
            })
            ->orderBy('end_date', 'asc')
            ->limit(5)
            ->get();

        // Add color coding and format data
        $policies = $policies->map(function ($policy) use ($today) {
            $endDate = Carbon::parse($policy->end_date);
            $daysUntilExpiry = $today->diffInDays($endDate, false);

            // Check if manually marked as 'availed'
            if ($policy->expiration_status === 'availed') {
                $statusText = 'Availed';
                $badgeColor = 'info';
                $badgeClass = 'bg-info bg-opacity-10 text-info border border-info';
                $avatarClass = 'bg-info bg-opacity-10';
                $avatarTextClass = 'text-info';
            }
            // Check if overdue (automatic)
            elseif ($daysUntilExpiry < 0 || $policy->expiration_status === 'overdue') {
                $statusText = 'Overdue';
                $badgeColor = 'danger';
                $badgeClass = 'bg-danger text-white';
                $avatarClass = 'bg-danger-subtle';
                $avatarTextClass = 'text-danger';
                
                // Auto-set expiration_status to 'overdue' if not already set
                if ($policy->expiration_status !== 'overdue') {
                    $policy->expiration_status = 'overdue';
                    $policy->save();
                }
            }
            // Determine badge color based on days until expiry
            elseif ($daysUntilExpiry <= 10) {
                $statusText = 'Critical';
                $badgeColor = 'danger'; // Red - 10 days or less
                $badgeClass = 'bg-danger text-white';
                $avatarClass = 'bg-danger-subtle';
                $avatarTextClass = 'text-danger';
            } elseif ($daysUntilExpiry <= 30) {
                $statusText = 'Upcoming';
                $badgeColor = 'warning'; // Yellow - 30 days or less (1 month)
                $badgeClass = 'bg-warning text-dark';
                $avatarClass = 'bg-warning-subtle';
                $avatarTextClass = 'text-warning';
            } else {
                $statusText = 'Upcoming';
                $badgeColor = 'success'; // Green - 2 months before
                $badgeClass = 'bg-success text-white';
                $avatarClass = 'bg-success-subtle';
                $avatarTextClass = 'text-success';
            }

            // Get client initials
            $firstName = $policy->client->firstName ?? '';
            $lastName = $policy->client->lastName ?? '';
            $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));

            return [
                'id' => $policy->id,
                'client_name' => $policy->client->firstName . ' ' . $policy->client->lastName,
                'client_phone' => $policy->client->phone ?? 'N/A',
                'client_email' => $policy->client->email ?? 'N/A',
                'client_address' => $policy->client->address . ', ' . $policy->client->city . ', ' . $policy->client->province,
                'due_date' => $endDate->format('M d, Y'),
                'due_date_raw' => $endDate->format('Y-m-d'),
                'days_until_expiry' => $daysUntilExpiry,
                'badge_color' => $badgeColor,
                'badge_class' => $badgeClass,
                'avatar_class' => $avatarClass,
                'avatar_text_class' => $avatarTextClass,
                'initials' => $initials,
                'status' => $statusText,
                'expiration_status' => $policy->expiration_status,
                // Policy details for modal
                'policy_number' => $policy->policy_number ?? 'N/A',
                'insurance_provider' => $policy->insuranceProvider->name ?? 'N/A',
                'date_start' => Carbon::parse($policy->start_date)->format('Y-m-d'),
                'date_end' => $endDate->format('Y-m-d'),
                'plate_number' => $policy->plate_number ?? 'N/A',
                'model_year' => $policy->model_year ?? 'N/A',
                'color' => $policy->color ?? 'N/A',
                'amount_due' => '₱' . number_format($policy->amount_due ?? 0, 2),
                'coverage_amount' => '₱' . number_format($policy->coverage_amount ?? 0, 2),
                'freebie' => $policy->freebie->name ?? 'None',
            ];
        });

        return $policies;
    }

    private function getPaymentReminders()
    {
        $today = Carbon::now();
        
        // Get all policies with installments
        $policies = Policy::with(['client', 'installments'])
            ->whereHas('installments')
            ->orderBy('created_at', 'desc')
            ->get();

        $paymentData = [];
        
        foreach ($policies as $policy) {
            $balance = ($policy->amount_due ?? 0) - ($policy->paid_amount ?? 0);
            
            // Get client initials
            $firstName = $policy->client->firstName ?? '';
            $lastName = $policy->client->lastName ?? '';
            $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
            
            // Check each installment (reminder appears 7 days before due date)
            foreach ($policy->installments as $installment) {
                $paymentDate = Carbon::parse($installment->payment_date);
                $reminderDate = $paymentDate->copy()->subDays(7); // 7 days before
                $daysUntilReminder = $today->diffInDays($reminderDate, false);
                
                // Show reminder from 7 days before to 1 day after the due date
                if ($daysUntilReminder >= -1 && $daysUntilReminder <= 7) {
                    $paymentData[] = [
                        'id' => $policy->id,
                        'client_name' => $policy->client->firstName . ' ' . $policy->client->lastName,
                        'client_email' => $policy->client->email ?? 'N/A',
                        'client_phone' => $policy->client->phone ?? 'N/A',
                        'client_address' => $policy->client->address ?? 'N/A',
                        'initials' => $initials,
                        'service_name' => 'Policy Payment',
                        'due_date' => $paymentDate->format('M d, Y'),
                        'due_date_raw' => $paymentDate->toDateString(),
                        'amount' => '₱' . number_format($installment->amount ?? 0, 2),
                        'amount_raw' => $installment->amount ?? 0,
                        'badge_class' => $this->getPaymentDueBadgeClass($paymentDate->toDateString()),
                        'avatar_class' => 'bg-primary bg-opacity-10',
                        'avatar_text_class' => 'text-primary',
                        // Policy details for modal
                        'policy_number' => $policy->policy_number ?? 'N/A',
                        'plate_number' => $policy->plate_number ?? 'N/A',
                        'model_year' => $policy->model_year ?? 'N/A',
                        'color' => $policy->color ?? 'N/A',
                        'service_amount' => '₱' . number_format($installment->amount ?? 0, 2),
                        'amount_due' => '₱' . number_format($policy->amount_due ?? 0, 2),
                        'paid_amount' => '₱' . number_format($policy->paid_amount ?? 0, 2),
                        'balance' => '₱' . number_format($balance, 2),
                        'status' => $policy->billing_status ?? 'N/A',
                        'is_service_paid' => false,
                    ];
                }
            }
        }

        return $paymentData;
    }

    private function getPaymentDueBadgeClass($dueDate)
    {
        if (!$dueDate) {
            return 'bg-secondary bg-opacity-10 text-secondary border border-secondary';
        }

        $today = Carbon::now();
        $due = Carbon::parse($dueDate);
        $daysUntilDue = $today->diffInDays($due, false);

        if ($daysUntilDue < 0) {
            // Overdue
            return 'bg-danger bg-opacity-10 text-danger border border-danger';
        } elseif ($daysUntilDue <= 7) {
            // Due within 7 days
            return 'bg-danger bg-opacity-10 text-danger border border-danger';
        } elseif ($daysUntilDue <= 14) {
            // Due within 14 days
            return 'bg-warning bg-opacity-10 text-warning border border-warning';
        } else {
            // Due further in future
            return 'bg-info bg-opacity-10 text-info border border-info';
        }
    }

    public function paymentReminders()
    {
        $today = Carbon::now();
        $paymentData = [];
        
        // Get all policies with installments (without 7-day filter)
        $policies = Policy::with(['client', 'installments'])
            ->whereHas('installments')
            ->orderBy('created_at', 'desc')
            ->get();
        
        foreach ($policies as $policy) {
            $balance = ($policy->amount_due ?? 0) - ($policy->paid_amount ?? 0);
            $firstName = $policy->client->firstName ?? '';
            $lastName = $policy->client->lastName ?? '';
            $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
            
            foreach ($policy->installments as $installment) {
                $paymentDate = Carbon::parse($installment->payment_date);
                
                // Show all installments that are not yet paid
                if ($paymentDate->isFuture() || $paymentDate->isToday()) {
                    $paymentData[] = [
                        'id' => $policy->id,
                        'type' => 'Policy',
                        'client_name' => $policy->client->firstName . ' ' . $policy->client->lastName,
                        'client_email' => $policy->client->email ?? 'N/A',
                        'client_phone' => $policy->client->phone ?? 'N/A',
                        'client_address' => $policy->client->address ?? 'N/A',
                        'initials' => $initials,
                        'service_name' => 'Policy Payment',
                        'due_date' => $paymentDate->format('M d, Y'),
                        'due_date_raw' => $paymentDate->toDateString(),
                        'amount' => '₱' . number_format($installment->amount ?? 0, 2),
                        'amount_raw' => $installment->amount ?? 0,
                        'badge_class' => $this->getPaymentDueBadgeClass($paymentDate->toDateString()),
                    ];
                }
            }
        }
        
        // Get all walk-in installments (without 7-day filter)
        $walkIns = WalkIn::with('installments')
            ->whereHas('installments')
            ->orderBy('created_at', 'desc')
            ->get();
        
        foreach ($walkIns as $walkIn) {
            $initials = strtoupper(substr($walkIn->insured_name, 0, 1)) . strtoupper(substr(explode(' ', $walkIn->insured_name)[1] ?? '', 0, 1));
            
            foreach ($walkIn->installments as $installment) {
                $paymentDate = Carbon::parse($installment->payment_date);
                
                // Show all installments that are not yet paid
                if ($paymentDate->isFuture() || $paymentDate->isToday()) {
                    $paymentData[] = [
                        'id' => $walkIn->id,
                        'type' => 'Walk-in',
                        'client_name' => $walkIn->insured_name,
                        'client_email' => $walkIn->email ?? 'N/A',
                        'client_phone' => $walkIn->contact_number ?? 'N/A',
                        'client_address' => $walkIn->address ?? 'N/A',
                        'initials' => $initials,
                        'service_name' => 'Walk-in Payment (' . $walkIn->walkin_number . ')',
                        'due_date' => $paymentDate->format('M d, Y'),
                        'due_date_raw' => $paymentDate->toDateString(),
                        'amount' => '₱' . number_format($installment->amount ?? 0, 2),
                        'amount_raw' => $installment->amount ?? 0,
                        'badge_class' => $this->getPaymentDueBadgeClass($paymentDate->toDateString()),
                    ];
                }
            }
        }
        
        // Sort by due date
        usort($paymentData, function($a, $b) {
            return strtotime($a['due_date_raw']) - strtotime($b['due_date_raw']);
        });
        
        $allPaymentReminders = $paymentData;
        return view('pages.policies.payment-reminders', compact('allPaymentReminders'));
    }

    public function expirationReminders()
    {
        $today = Carbon::now();

        // Get all policies that are expiring or overdue (including 'availed')
        $policies = Policy::with(['client', 'insuranceProvider'])
            ->where(function($query) use ($today) {
                // Get upcoming policies (within 2 months) OR overdue policies
                $query->where('end_date', '>=', $today->copy()->subMonths(6)) // Show policies from last 6 months
                      ->where('end_date', '<=', $today->copy()->addMonths(2));
            })
            ->orderBy('end_date', 'asc')
            ->get();

        // Format data for view
        $policies = $policies->map(function ($policy) use ($today) {
            $endDate = Carbon::parse($policy->end_date);
            $daysUntilExpiry = $today->diffInDays($endDate, false);

            // Determine status
            if ($policy->expiration_status === 'availed') {
                $statusText = 'Availed';
                $statusClass = 'bg-success';
            } elseif ($daysUntilExpiry < 0 || $policy->expiration_status === 'overdue') {
                $statusText = 'Overdue';
                $statusClass = 'bg-danger';
                
                // Auto-set to overdue if not already
                if ($policy->expiration_status !== 'overdue') {
                    $policy->expiration_status = 'overdue';
                    $policy->save();
                }
            } else {
                $statusText = 'Upcoming';
                $statusClass = 'bg-success';
            }

            return [
                'id' => $policy->id,
                'client_name' => $policy->client->firstName . ' ' . $policy->client->lastName,
                'due_date' => $endDate->format('M d, Y'),
                'contact_number' => $policy->client->phone ?? 'N/A',
                'email' => $policy->client->email ?? 'N/A',
                'status' => $statusText,
                'status_class' => $statusClass,
                'expiration_status' => $policy->expiration_status,
            ];
        });

        return view('pages.policies.expiration-reminders', compact('policies'));
    }

    public function markPaymentPaid(Request $request)
    {
        try {
            $policyId = $request->input('policy_id');
            $serviceName = $request->input('service_name');
            $action = $request->input('action', 'mark-paid');
            $serviceIndex = $request->input('service_index');

            $policy = Policy::findOrFail($policyId);
            
            // Initialize paid_services array if it doesn't exist
            $paidServices = is_array($policy->paid_services) ? $policy->paid_services : [];
            
            if ($action === 'mark-paid') {
                // Add service to paid_services array
                if (!in_array($serviceName, $paidServices)) {
                    $paidServices[] = $serviceName;
                    
                    // Get the service price and deduct from amount_due
                    if ($serviceName !== 'Policy Balance') {
                        $serviceModel = Service::where('name', $serviceName)->first();
                        $servicePrice = $serviceModel ? ($serviceModel->price ?? 0) : 0;
                        
                        // Deduct from amount_due
                        $policy->amount_due = max(0, ($policy->amount_due ?? 0) - $servicePrice);
                        
                        // Add to paid_amount
                        $policy->paid_amount = ($policy->paid_amount ?? 0) + $servicePrice;
                    } else {
                        // If marking policy balance as paid, set amount_due to 0
                        $policy->amount_due = 0;
                        $policy->paid_amount = $policy->amount_due;
                    }
                }
                $policy->paid_services = $paidServices;
                $message = $serviceName . ' has been marked as paid.';
            } else {
                // Mark as unpaid - add back to amount_due
                if (in_array($serviceName, $paidServices)) {
                    $paidServices = array_filter($paidServices, function($service) use ($serviceName) {
                        return $service !== $serviceName;
                    });
                    $policy->paid_services = array_values($paidServices);
                    
                    // Get the service price and add back to amount_due
                    if ($serviceName !== 'Policy Balance') {
                        $serviceModel = Service::where('name', $serviceName)->first();
                        $servicePrice = $serviceModel ? ($serviceModel->price ?? 0) : 0;
                        
                        // Add back to amount_due
                        $policy->amount_due = ($policy->amount_due ?? 0) + $servicePrice;
                        
                        // Deduct from paid_amount
                        $policy->paid_amount = max(0, ($policy->paid_amount ?? 0) - $servicePrice);
                    } else {
                        // If marking policy balance as unpaid, restore amount_due
                        // This would need the original amount stored separately
                        // For now, we'll just set paid_amount to 0
                        $policy->paid_amount = 0;
                    }
                }
                
                $message = $serviceName . ' has been marked as unpaid.';
            }

            $policy->save();

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send insurance renewal reminder email to client (writes to log file for development)
     */
    public function sendInsuranceReminder(Request $request)
    {
        try {
            $policyId = $request->input('policy_id');
            $customSubject = $request->input('subject');
            $customBody = $request->input('body');

            // Find the policy
            $policy = Policy::with(['client', 'insuranceProvider'])->findOrFail($policyId);

            // Check if client has an email
            if (!$policy->client->email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Client does not have an email address on file.'
                ], 400);
            }

            // Get client name
            $clientName = $policy->client->firstName . ' ' . $policy->client->lastName;
            $clientEmail = $policy->client->email;

            // Use custom content if provided, otherwise use default
            $subject = $customSubject ?: 'Insurance Policy Renewal Reminder - ' . $policy->policy_number;
            $body = $customBody ?: "Dear " . $clientName . ",\n\n" .
                "This is a friendly reminder that your insurance policy is due for renewal soon.\n\n" .
                "Policy Number: " . $policy->policy_number . "\n" .
                "Due Date: " . $policy->end_date . "\n\n" .
                "Please renew your policy before the due date.\n\n" .
                "Best regards,\nPowerlug Team";

            // Log the email to file
            $logContent = "
================================================================================
EMAIL SENT REMINDER - " . date('Y-m-d H:i:s') . "
================================================================================
TO: " . $clientEmail . "
SUBJECT: " . $subject . "
CLIENT NAME: " . $clientName . "

EMAIL BODY:
" . $body . "

================================================================================
";

            // Write to log file
            $logFile = storage_path('logs/email_reminders_' . date('Y-m-d') . '.log');
            file_put_contents($logFile, $logContent, FILE_APPEND);

            // Log to audit trail
            AuditTrail::create([
                'user_id' => auth()->id() ?? null,
                'action' => 'reminder_sent',
                'module' => 'Policy',
                'record_id' => $policy->id,
                'description' => "Renewal reminder email sent to {$clientEmail} for Policy #{$policy->policy_number}",
                'old_values' => null,
                'new_values' => json_encode([
                    'email_to' => $clientEmail,
                    'subject' => $subject,
                    'body_preview' => substr($body, 0, 200) . '...'
                ]),
                'ip_address' => request()->ip() ?? null,
                'user_agent' => request()->userAgent() ?? null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Reminder email queued successfully for ' . $clientEmail . ' (check logs for details)'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
