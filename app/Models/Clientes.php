<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table = 'clientes';

    protected $fillable = ['nome', 'telefone', 'cpf', 'placa_carro'];

}
