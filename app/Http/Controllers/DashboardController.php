<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Policy;
use App\Models\Service;
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
        $twoMonthsFromNow = Carbon::now()->addMonths(2);

        // Get policies expiring within the next 2 months OR already overdue
        // Include policies where expiration_status is not 'availed'
        $policies = Policy::with(['client', 'insuranceProvider'])
            ->where(function($query) use ($today, $twoMonthsFromNow) {
                // Get upcoming policies (within 2 months)
                $query->whereBetween('end_date', [$today, $twoMonthsFromNow])
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
        // Get policies with outstanding payments and service payment dues
        $policies = Policy::with(['client'])
            ->where(function($query) {
                // Get policies with outstanding balance OR policies with service payment dues
                $query->whereRaw('(amount_due - COALESCE(paid_amount, 0)) > 0')
                      ->orWhereNotNull('services');
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Format data for view
        $paymentData = [];
        foreach ($policies as $policy) {
            $balance = ($policy->amount_due ?? 0) - ($policy->paid_amount ?? 0);
            
            // Get client initials
            $firstName = $policy->client->firstName ?? '';
            $lastName = $policy->client->lastName ?? '';
            $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));

            // Check if policy has services with payment dues
            $services = is_array($policy->services) ? $policy->services : [];
            $paymentDues = is_array($policy->service_payment_dues) ? $policy->service_payment_dues : [];
            $paidServices = is_array($policy->paid_services) ? $policy->paid_services : [];
            
            if (count($services) > 0) {
                // Add an entry for each service with a payment due date
                foreach ($services as $index => $serviceName) {
                    $dueDate = $paymentDues[$index] ?? null;
                    
                    if ($dueDate) {
                        // Skip if this service has already been marked as paid
                        if (in_array($serviceName, $paidServices)) {
                            continue;
                        }
                        
                        // Check if payment is due within 10 days (for dashboard display)
                        $dueDateObj = Carbon::parse($dueDate);
                        $daysUntilDue = Carbon::now()->diffInDays($dueDateObj, false);
                        
                        // Only include items due within 10 days for dashboard
                        if ($daysUntilDue <= 10) {
                            // Get the service price from the Service model
                            $serviceModel = Service::where('name', $serviceName)->first();
                            $servicePrice = $serviceModel ? ($serviceModel->price ?? 0) : 0;
                            
                            $paymentData[] = [
                                'id' => $policy->id,
                                'client_name' => $policy->client->firstName . ' ' . $policy->client->lastName,
                                'client_email' => $policy->client->email ?? 'N/A',
                                'client_phone' => $policy->client->phone ?? 'N/A',
                                'client_address' => $policy->client->address ?? 'N/A',
                                'initials' => $initials,
                                'service_name' => $serviceName,
                                'due_date' => $dueDateObj->format('M d, Y'),
                                'due_date_raw' => $dueDate,
                                'amount' => '₱' . number_format($servicePrice, 2),
                                'amount_raw' => $servicePrice,
                                'badge_class' => $this->getPaymentDueBadgeClass($dueDate),
                                'avatar_class' => 'bg-primary bg-opacity-10',
                                'avatar_text_class' => 'text-primary',
                                // Policy details for modal
                                'policy_number' => $policy->policy_number ?? 'N/A',
                                'plate_number' => $policy->plate_number ?? 'N/A',
                                'model_year' => $policy->model_year ?? 'N/A',
                                'color' => $policy->color ?? 'N/A',
                                'service_amount' => '₱' . number_format($servicePrice, 2),
                                'amount_due' => '₱' . number_format($policy->amount_due ?? 0, 2),
                                'paid_amount' => '₱' . number_format($policy->paid_amount ?? 0, 2),
                                'balance' => '₱' . number_format($balance, 2),
                                'status' => $policy->billing_status ?? 'N/A',
                                // Check if this service has been marked as paid
                                'paid_services' => $paidServices,
                                'is_service_paid' => false,
                            ];
                        }
                    }
                }
            } elseif ($balance > 0) {
                // If no services, but has outstanding balance
                $paymentData[] = [
                    'id' => $policy->id,
                    'client_name' => $policy->client->firstName . ' ' . $policy->client->lastName,
                    'client_email' => $policy->client->email ?? 'N/A',
                    'client_phone' => $policy->client->phone ?? 'N/A',
                    'client_address' => $policy->client->address ?? 'N/A',
                    'initials' => $initials,
                    'service_name' => 'Policy Balance',
                    'due_date' => 'N/A',
                    'due_date_raw' => null,
                    'amount' => '₱' . number_format($balance, 2),
                    'amount_raw' => $balance,
                    'badge_class' => 'bg-warning bg-opacity-10 text-warning border border-warning',
                    'avatar_class' => 'bg-warning bg-opacity-10',
                    'avatar_text_class' => 'text-warning',
                    // Policy details for modal
                    'policy_number' => $policy->policy_number ?? 'N/A',
                    'plate_number' => $policy->plate_number ?? 'N/A',
                    'model_year' => $policy->model_year ?? 'N/A',
                    'color' => $policy->color ?? 'N/A',
                    'amount_due' => '₱' . number_format($policy->amount_due ?? 0, 2),
                    'paid_amount' => '₱' . number_format($policy->paid_amount ?? 0, 2),
                    'balance' => '₱' . number_format($balance, 2),
                    'status' => $policy->billing_status ?? 'N/A',
                ];
            }
        }

        // Return only the first 5 entries
        return array_slice($paymentData, 0, 5);
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
        // Get all payment reminders (not limited to 5)
        $paymentReminders = $this->getPaymentReminders();
        
        // Convert to include contact details for full view
        $allPaymentReminders = [];
        
        // Get policies with outstanding payments and service payment dues
        $policies = Policy::with(['client'])
            ->where(function($query) {
                $query->whereRaw('(amount_due - COALESCE(paid_amount, 0)) > 0')
                      ->orWhereNotNull('services');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Format data for view
        foreach ($policies as $policy) {
            $balance = ($policy->amount_due ?? 0) - ($policy->paid_amount ?? 0);
            
            // Get client initials
            $firstName = $policy->client->firstName ?? '';
            $lastName = $policy->client->lastName ?? '';
            $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));

            // Check if policy has services with payment dues
            $services = is_array($policy->services) ? $policy->services : [];
            $paymentDues = is_array($policy->service_payment_dues) ? $policy->service_payment_dues : [];
            
            if (count($services) > 0) {
                // Add an entry for each service with a payment due date
                foreach ($services as $index => $serviceName) {
                    $dueDate = $paymentDues[$index] ?? null;
                    
                    if ($dueDate) {
                        // Get the service price from the Service model
                        $serviceModel = Service::where('name', $serviceName)->first();
                        $servicePrice = $serviceModel ? ($serviceModel->price ?? 0) : 0;
                        
                        $dueDateObj = Carbon::parse($dueDate);
                        $daysUntilDue = Carbon::now()->diffInDays($dueDateObj, false);
                        
                        // Determine status
                        if ($daysUntilDue < 0) {
                            $statusText = 'Overdue';
                            $statusClass = 'bg-danger';
                            $daysText = 'Overdue by ' . abs($daysUntilDue) . ' day' . (abs($daysUntilDue) !== 1 ? 's' : '');
                        } elseif ($daysUntilDue === 0) {
                            $statusText = 'Due Today';
                            $statusClass = 'bg-danger';
                            $daysText = 'Due Today';
                        } elseif ($daysUntilDue <= 7) {
                            $statusText = 'Urgent';
                            $statusClass = 'bg-danger';
                            $daysText = $daysUntilDue . ' day' . ($daysUntilDue !== 1 ? 's' : '') . ' remaining';
                        } elseif ($daysUntilDue <= 14) {
                            $statusText = 'Due Soon';
                            $statusClass = 'bg-warning';
                            $daysText = $daysUntilDue . ' day' . ($daysUntilDue !== 1 ? 's' : '') . ' remaining';
                        } else {
                            $statusText = 'Upcoming';
                            $statusClass = 'bg-info';
                            $daysText = $daysUntilDue . ' day' . ($daysUntilDue !== 1 ? 's' : '') . ' remaining';
                        }
                        
                        // Check if this service has been marked as paid
                        $paidServices = is_array($policy->paid_services) ? $policy->paid_services : [];
                        $isPaid = in_array($serviceName, $paidServices);
                        
                        $allPaymentReminders[] = [
                            'id' => $policy->id,
                            'client_name' => $policy->client->firstName . ' ' . $policy->client->lastName,
                            'client_email' => $policy->client->email ?? 'N/A',
                            'client_phone' => $policy->client->phone ?? 'N/A',
                            'service_name' => $serviceName,
                            'due_date' => $dueDateObj->format('M d, Y'),
                            'amount' => '₱' . number_format($servicePrice, 2),
                            'status' => $statusText,
                            'status_class' => $statusClass,
                            'days_text' => $daysText,
                            'days_until_due' => $daysUntilDue,
                            'policy_number' => $policy->policy_number ?? 'N/A',
                            'paid_status' => $isPaid ? 'paid' : 'unpaid',
                            'service_index' => $index,
                        ];
                    }
                }
            } elseif ($balance > 0) {
                // If no services, but has outstanding balance
                $statusText = 'Due';
                $statusClass = 'bg-warning';
                
                // Check if policy balance has been marked as paid
                $paidServices = is_array($policy->paid_services) ? $policy->paid_services : [];
                $isPaid = in_array('Policy Balance', $paidServices);
                
                $allPaymentReminders[] = [
                    'id' => $policy->id,
                    'client_name' => $policy->client->firstName . ' ' . $policy->client->lastName,
                    'client_email' => $policy->client->email ?? 'N/A',
                    'client_phone' => $policy->client->phone ?? 'N/A',
                    'service_name' => 'Policy Balance',
                    'due_date' => 'N/A',
                    'amount' => '₱' . number_format($balance, 2),
                    'status' => $statusText,
                    'status_class' => $statusClass,
                    'policy_number' => $policy->policy_number ?? 'N/A',
                    'paid_status' => $isPaid ? 'paid' : 'unpaid',
                    'service_index' => null,
                ];
            }
        }
        
        // Sort by due date (most recent first)
        usort($allPaymentReminders, function ($a, $b) {
            if ($a['due_date'] === 'N/A') return 1;
            if ($b['due_date'] === 'N/A') return -1;
            return strtotime($b['due_date']) - strtotime($a['due_date']);
        });

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
}
