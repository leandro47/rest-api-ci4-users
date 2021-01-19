<?php

namespace App\Services;

use CodeIgniter\HTTP\IncomingRequest;
use App\Repositories\ClientRepository;
use CodeIgniter\HTTP\Response;

class ApiClientServices
{
    protected $clientRepository;

    public function __construct()
    {
        $this->clientRepository = new ClientRepository;
    }

    public static function noContent()
    {
        return [
            'code'    => Response::HTTP_NO_CONTENT,
            'message' => 'No content',
            'data'    => []
        ];
    }

    public function getAll()
    {
        $result =  $this->clientRepository->getAll();

        if ($result) {
            return [
                'code'    => Response::HTTP_OK,
                'message' => 'OK',
                'data'    => $result
            ];
        } else {
            return [
                'code'    => Response::HTTP_NO_CONTENT,
                'message' => 'No content',
                'data'    => $result
            ];
        }
    }

    public function getByCpf(string $cpf)
    {
        $result =  $this->clientRepository->getByCpf($cpf);

        if ($result) {
            return [
                'code'    => Response::HTTP_OK,
                'message' => 'OK',
                'data'    => $result
            ];
        } else {
            return [
                'code'    => Response::HTTP_NO_CONTENT,
                'message' => 'No content',
                'data'    => $result
            ];
        }
    }

    public function insert(IncomingRequest $request, object $adress)
    {
        $data['id'] = 'id';
        $data['firstName'] = filter_var($request->getJSON()->firstName, FILTER_SANITIZE_STRING);
        $data['lastName'] = filter_var($request->getJSON()->lastName, FILTER_SANITIZE_STRING);
        $data['cpf'] = formatCpf(filter_var($request->getJSON()->cpf, FILTER_SANITIZE_STRING));

        $data['cep'] = filter_var($request->getJSON()->cep, FILTER_SANITIZE_STRING);
        $data['street'] = filter_var($adress->logradouro, FILTER_SANITIZE_STRING);
        $data['district'] = filter_var($adress->bairro, FILTER_SANITIZE_STRING);
        $data['city'] = filter_var($adress->localidade, FILTER_SANITIZE_STRING);
        $data['uf'] = filter_var($adress->uf, FILTER_SANITIZE_STRING);

        $data['phone'] = filter_var($request->getJSON()->phone, FILTER_SANITIZE_STRING);
        $data['email'] = filter_var($request->getJSON()->email, FILTER_SANITIZE_EMAIL);

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

    public function delete(string $cpf)
    {
        if (!$this->clientRepository->findCpf($cpf)) {
            return [
                'code'    => Response::HTTP_NOT_FOUND,
                'message' => 'CPF not found',
                'data'    => [],
            ];
        }

        $result = $this->clientRepository->delete($cpf);

        if ($result) {
            return [
                'code'    => Response::HTTP_OK,
                'message' => 'Client deleted',
                'data'    => []
            ];
        }

        return [
            'code'    => Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => 'Client not deleted, please try again',
            'data'    => [],
        ];
    }

    public function update(IncomingRequest $request, object $adress, string $cpf)
    {
        $data['firstName'] = filter_var($request->getJSON()->firstName, FILTER_SANITIZE_STRING);
        $data['lastName'] = filter_var($request->getJSON()->lastName, FILTER_SANITIZE_STRING);
        $cpf = formatCpf(filter_var($cpf, FILTER_SANITIZE_STRING));

        $data['cep'] = filter_var($request->getJSON()->cep, FILTER_SANITIZE_STRING);
        $data['street'] = filter_var($adress->logradouro, FILTER_SANITIZE_STRING);
        $data['district'] = filter_var($adress->bairro, FILTER_SANITIZE_STRING);
        $data['city'] = filter_var($adress->localidade, FILTER_SANITIZE_STRING);
        $data['uf'] = filter_var($adress->uf, FILTER_SANITIZE_STRING);

        $data['phone'] = filter_var($request->getJSON()->phone, FILTER_SANITIZE_STRING);
        $data['email'] = filter_var($request->getJSON()->email, FILTER_SANITIZE_EMAIL);

        if (!$this->clientRepository->findCpf($cpf)) {
            return [
                'code'    => Response::HTTP_NOT_FOUND,
                'message' => 'Client not found',
                'data'    => [],
            ];
        }

        $result = $this->clientRepository->update($cpf, $data);

        if ($result) {
            return [
                'code'    => Response::HTTP_OK,
                'message' => 'Client updated',
                'data'    => $this->clientRepository->findCpf($cpf)
            ];
        }

        return [
            'code'    => Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => 'Client not updated, please try again',
            'data'    => [],
        ];
    }
}
