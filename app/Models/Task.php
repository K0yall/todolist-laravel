<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    protected $fillable = [
        'title', 
        'description', 
        'completed', 
        'category_id', 
        'priority', 
        'due_date',
        'image'
    ];

    protected $casts = [
        'completed' => 'boolean',
        'due_date' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }

    public function scopePending($query)
    {
        return $query->where('completed', false);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function isOverdue()
    {
        return $this->due_date && $this->due_date->isPast() && !$this->completed;
    }

    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'alta' => '#e53935',
            'media' => '#ff9800',
            'baixa' => '#4caf50',
            default => '#757575'
        };
    }
}