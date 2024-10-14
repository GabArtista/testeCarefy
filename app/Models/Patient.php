<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'blood_type',
        'social_number'
    ];

    public function guides()
    {
        return $this->hasMany(Guide::class, 'patient_id'); // Relacionamento inverso
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
