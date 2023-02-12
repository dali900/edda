<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    /**
     * Available field types
     * ['date', 'amount', 'text']
     */
    const TYPES = ['date', 'amount', 'text'];

    protected $fillable = ['title', 'type', 'value'];

    /**
     * Get the form that owns the field.
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function scopeDateFields($query)
    {
        $query->where('type', 'date');
    }
}
