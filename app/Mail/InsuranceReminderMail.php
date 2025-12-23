<?php

namespace App\Mail;

use App\Models\Policy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InsuranceReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $policy;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Policy $policy)
    {
        $this->policy = $policy;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Insurance Policy Renewal Reminder - ' . $this->policy->policy_number)
                    ->view('emails.insurance-reminder')
                    ->with([
                        'client_name' => $this->policy->client->firstName . ' ' . $this->policy->client->lastName,
                        'policy_number' => $this->policy->policy_number,
                        'due_date' => $this->policy->end_date,
                        'insurance_provider' => $this->policy->insuranceProvider->name ?? 'N/A',
                        'coverage_amount' => $this->policy->coverage_amount,
                        'plate_number' => $this->policy->vehicle->plate_number ?? 'N/A',
                    ]);
    }
}
