<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'value',
        'status',
        'approved',
        'date_approved',
        'justification_refused',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
