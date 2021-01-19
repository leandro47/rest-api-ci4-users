<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\CLI\CLI;
use App\Services\CliClientServices;
use App\Services\ViaCepServices;
use App\Validation\CliClientValidation;
use CodeIgniter\HTTP\Response;

// ==================================================
// API
// ==================================================

class CliClientController extends Controller
{
    public function __construct()
    {
        helper('Utils');
        $this->clientValidation = new CliClientValidation;
        $this->clientServices = new CliClientServices;
        $this->viaCepServices = new ViaCepServices;
    }

    // ==================================================

    public function insert()
    {
        // ==================================================
        // REQUEST DATAS
        // ==================================================
        $data = [];

        // CPF
        $data['cpf'] = CLI::prompt('What is your CPF?', null, 'required|string');
        $validCpf = $this->clientValidation->cpf($data['cpf']);

        while ($validCpf) {
            $data['cpf'] = CLI::prompt($validCpf . ' What is your CPF?', null, 'required|string');
            $validCpf = $this->clientValidation->cpf($data['cpf']);
        }

        // First name
        $data['firstName'] = CLI::prompt('What is your first name?', null, 'required|string');

        // Last name
        $data['lastName'] = CLI::prompt('What is your last name?', null, 'required|string');

        // CEP
        $data['cep'] = CLI::prompt('What is your CEP?', null, 'required|is_natural');
        $validCep = $this->clientValidation->cep($data['cep']);

        while ($validCep) {
            $data['cep'] = CLI::prompt($validCep . ' What is your CEP?', null, 'required|string');
            $validCep = $this->clientValidation->cep($data['cep']);
        }

        $validCep = $this->viaCepServices->getAdress($data['cep']);

        while ($validCep['code'] !== Response::HTTP_OK) {
            $data['cep'] = CLI::prompt($validCep['message'] . ' What is your CEP?', null, 'required|string');
            $validCep = $this->viaCepServices->getAdress($data['cep']);
        }

        // Phone
        $data['phone'] = CLI::prompt('What is your phone number?', null, 'required|string');

        // Email
        $data['email'] = CLI::prompt('What is your email?', null, 'required|valid_email');

        // ==================================================
        // INSERT DATAS
        // ==================================================
        $result  = $this->clientServices->insert($data, $validCep['data']);

        if ($result['code'] !== Response::HTTP_CREATED) {
            CLI::clearScreen();

            CLI::error('Code : ' . $result['code']);
            CLI::error('Message : ' . $result['message']);
        } else {
            CLI::clearScreen();

            CLI::write('Code : ' . $result['code'], 'green');
            CLI::write('Message : ' . $result['message'], 'green');
            CLI::newLine();

            $c = $result['data'];
            $thead = ['ID', 'First Name', 'Last Name', 'CPF', 'CEP', 'Street', 'District', 'City', 'UF', 'Phone', 'Email'];
            $tbody = [
                [$c->id, $c->firstName, $c->lastName, $c->cpf, $c->cep, $c->street, $c->district, $c->city, $c->uf, $c->phone, $c->email],
            ];

            CLI::table($tbody, $thead);
        }
    }
}
