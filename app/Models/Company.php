<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'cnpj',
        'nome_fantasia',
        'razao_social',
    ];

    public function users()
    {
        return $this->hasMany(Users::class);
    }

    public function expense()
    {
        return $this->hasMany(Expense::class);
    }
}
