
    /**
     * Get payment reminder attachments for a policy (API endpoint)
     */
    public function getPaymentReminderAttachments(Policy $policy)
    {
        try {
            $attachments = $policy->payment_reminder_attachments ?? [];
            
            return response()->json([
                'success' => true,
                'attachments' => $attachments
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching attachments: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'attachments' => []
            ], 500);
        }
    }
}
