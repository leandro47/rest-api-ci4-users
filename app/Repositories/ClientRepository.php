<?php

namespace App\Repositories;

use App\Models\ClientModel;
use Exception;

class ClientRepository
{
    protected $client;

    public function __construct()
    {
        $this->client  = new ClientModel;
    }

    public function insert(array $data)
    {
        try {
            return $this->client->insert($data);
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return false;
        }
    }

    public function update(string $cpf, array $data)
    {
        $sql = "UPDATE client set firstName = :firstName:,
        lastName = :lastName:,
        cep = :cep:, 
        street = :street:, 
        district = :district:, 
        city = :city:, 
        uf = :uf:, 
        phone = :phone:, 
        email = :email: 
        where cpf = :cpf:";

        try {
            return $this->client->query($sql, [
                'firstName' => $data['firstName'],
                'lastName' => $data['lastName'],
                'cep'   => $data['cep'],
                'street'   => $data['street'],
                'district'   => $data['district'],
                'city'   => $data['city'],
                'uf'   => $data['uf'],
                'phone'   => $data['phone'],
                'email'   => $data['email'],
                'cpf' => $cpf
            ]);
        } catch (Exception $e) {
            log_message('error', 'Update client : ' . $e->getMessage());
            return false;
        }
    }

    public function delete(string $cpf)
    {
        try {
            return $this->client->where('cpf', $cpf)->delete();
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return false;
        }
    }

    public function getAll()
    {
        $sql = "SELECT CONCAT( firstName,' ', lastName )name,
        cpf, 
        cep,
        street,
        district, 
        city,
        uf, 
        phone, 
        email 
        FROM client order by name asc";

        return $this->client->query($sql)->getResult();
    }

    public function getByCpf(string $cpf)
    {
        return $this->client->where(['cpf' => $cpf])->get()->getRow();
    }

    public function getById(int $id)
    {
        return $this->client->where(['id' => $id])->get()->getRow();
    }

    public function findCpf(string $cpf)
    {
        $sql = "SELECT * from client where cpf = :cpf:";
        return $this->client->query($sql, ['cpf' => $cpf])->getRow();
    }
}
