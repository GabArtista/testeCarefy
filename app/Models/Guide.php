<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    use HasFactory;

    // Adicionando 'patient_id' ao array de campos que podem ser preenchidos em massa
    protected $fillable = ['patient_id', 'description', 'entry', 'exit']; // Adicione 'patient_id'

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
