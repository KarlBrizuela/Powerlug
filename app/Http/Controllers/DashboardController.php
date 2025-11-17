<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Policy;
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

        return view('pages.dashboard', compact('totalClients', 'totalPolicies', 'expiringPolicies'));
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
}
