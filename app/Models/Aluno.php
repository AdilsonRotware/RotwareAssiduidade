<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    /**
     * Os atributos que podem ser preenchidos em massa.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'cpf',
        'data_nascimento',
        'endereco',
        'telefone',
        'email',
        'qrcode', // Adicionando o campo QR Code
    ];

    /**
     * Os atributos que devem ser ocultos para arrays.
     *
     * @var array
     */
    protected $hidden = [
        // Campos que não devem ser expostos (opcional)
    ];

    /**
     * Os atributos que devem ser convertidos para tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'data_nascimento' => 'date', // Converte o campo para o tipo date
    ];
}