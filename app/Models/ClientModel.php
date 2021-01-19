<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    /**
     * -------------------------------------------
     * TABLE
     * -------------------------------------------
     */
    protected $table = 'client';

    /**
     * -------------------------------------------
     * ALLOWED FIELDS
     * -------------------------------------------
     */
    protected $allowedFields = [
        'id',
        'firstName',
        'lastName',
        'cpf',
        'cep',
        'street',
        'district', 
        'city',
        'uf',
        'phone',
        'email'
    ];

    /**
     * -------------------------------------------
     * RETURN TYPE DATAS
     * -------------------------------------------
     */
    protected $returnType = 'array';
}
