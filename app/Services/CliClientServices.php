<?php

namespace App\Services;

use App\Repositories\ClientRepository;
use CodeIgniter\HTTP\Response;

class CliClientServices
{
    protected $clientRepository;

    public function __construct()
    {
        $this->clientRepository = new ClientRepository;
    }

    public function insert(array $data, object $adress): array
    {
        $data['id'] = 'id';
        $data['firstName'] = filter_var($data['firstName'], FILTER_SANITIZE_STRING);
        $data['lastName'] = filter_var($data['lastName'], FILTER_SANITIZE_STRING);
        $data['cpf'] = formatCpf(filter_var($data['cpf'], FILTER_SANITIZE_STRING));

        $data['cep'] = filter_var($data['cep'], FILTER_SANITIZE_STRING);
        $data['street'] = filter_var($adress->logradouro, FILTER_SANITIZE_STRING);
        $data['district'] = filter_var($adress->bairro, FILTER_SANITIZE_STRING);
        $data['city'] = filter_var($adress->localidade, FILTER_SANITIZE_STRING);
        $data['uf'] = filter_var($adress->uf, FILTER_SANITIZE_STRING);

        $data['phone'] = filter_var($data['phone'], FILTER_SANITIZE_STRING);
        $data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);

        if ($this->clientRepository->findCpf($data['cpf'])) {
            return [
                'code'    => Response::HTTP_CONFLICT,
                'message' => 'Client is duplicate',
                'data'    => [],
            ];
        }

        $result = $this->clientRepository->insert($data);

        if ($result) {
            return [
                'code'    => Response::HTTP_CREATED,
                'message' => 'Created',
                'data'    => $this->clientRepository->getById($result)
            ];
        }

        return [
            'code'    => Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => 'Client not inserted, please try again',
            'data'    => [],
        ];
    }
}
