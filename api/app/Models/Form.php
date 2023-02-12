<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Get the fields for the forms.
     */
    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    public function getAllDateValues()
    {
        return $this->fields()->dateFields()->get('value')->pluck('value')->toArray();
    }
}
