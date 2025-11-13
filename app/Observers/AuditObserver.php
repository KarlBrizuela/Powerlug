<?php

namespace App\Observers;

use App\Models\AuditTrail;
use Illuminate\Support\Str;

class AuditObserver
{
    protected function record($model, string $action)
    {
        try {
            $module = class_basename($model);
            $id = $model->getKey();

            // Human friendly identifier
            $label = null;
            if (isset($model->client_name)) {
                $label = $model->client_name;
            } elseif (isset($model->name)) {
                $label = $model->name;
            } elseif (isset($model->reference_number)) {
                $label = $model->reference_number;
            }

            $description = "{$module} #{$id}" . ($label ? " - {$label}" : '');

            $old = null;
            $new = null;
            if ($action === 'updated') {
                $old = json_encode($model->getOriginal());
                $new = json_encode($model->getChanges());
            } else {
                $new = json_encode($model->getAttributes());
            }

            AuditTrail::create([
                'user_id' => auth()->id() ?? null,
                'action' => $action,
                'module' => $module,
                'description' => $description,
                'old_values' => $old,
                'new_values' => $new,
                'ip_address' => request()?->ip() ?? null,
                'user_agent' => request()?->userAgent() ?? null,
            ]);
        } catch (\Throwable $e) {
            // swallow errors to avoid breaking the user action
            logger()->error('AuditObserver error: ' . $e->getMessage());
        }
    }

    public function created($model)
    {
        $this->record($model, 'created');
    }

    public function updated($model)
    {
        $this->record($model, 'updated');
    }

    public function deleted($model)
    {
        $this->record($model, 'deleted');
    }
}
