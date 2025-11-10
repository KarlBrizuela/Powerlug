<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    protected $fillable = [
        'user_id', 'action', 'module', 'description', 
        'old_values', 'new_values', 'ip_address', 'user_agent'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getActionColor()
    {
        return match($this->action) {
            'created' => 'success',
            'updated' => 'primary',
            'deleted' => 'danger',
            'login', 'logout' => 'info',
            'viewed' => 'secondary',
            default => 'warning'
        };
    }
}