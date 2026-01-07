<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Collection;
use App\Models\Client;
use App\Models\Claim;
use Illuminate\Support\Facades\DB;

class BackfillCollectionClaimNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'collections:backfill-claim-numbers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backfill claim numbers and policy numbers for existing collections based on their client';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to backfill collection claim numbers...');

        $collections = Collection::all();
        $updated = 0;

        foreach ($collections as $collection) {
            try {
                // Get the client
                $client = Client::find($collection->client_id);
                
                if (!$client) {
                    $this->warn("Client not found for collection {$collection->id}");
                    continue;
                }

                // Find all policies for this client
                $policyIds = DB::table('policies')
                    ->where('client_id', $client->id)
                    ->pluck('id')
                    ->toArray();

                if (empty($policyIds)) {
                    $this->warn("No policies found for client {$client->id} (collection {$collection->id})");
                    continue;
                }

                // Find the latest claim for any of the client's policies
                $claim = Claim::whereIn('policy_id', $policyIds)
                    ->latest()
                    ->first();

                if ($claim) {
                    // Update the collection with the claim number and policy number
                    $collection->update([
                        'claim_number' => $claim->claim_number,
                        'policy_number' => $claim->policy_number ?? $collection->policy_number
                    ]);
                    $updated++;
                    $this->line("Updated collection {$collection->id} with claim number: {$claim->claim_number}");
                } else {
                    $this->warn("No claim found for collection {$collection->id}");
                }
            } catch (\Exception $e) {
                $this->error("Error processing collection {$collection->id}: {$e->getMessage()}");
            }
        }

        $this->info("Backfill completed! Updated {$updated} collections.");
    }
}
