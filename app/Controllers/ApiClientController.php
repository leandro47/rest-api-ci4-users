<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Validation\ApiClientValidation;
use App\Services\ApiClientServices;
use App\Services\ViaCepServices;
use CodeIgniter\HTTP\Response;

// ==================================================
// API
// ==================================================

class ApiClientController extends ResourceController
{
	protected $format = 'json';
	protected $clientServices;
	protected $apiClientValidation;
	protected $viaCepServices;

	public function __construct()
	{
		helper('Utils');
		$this->clientServices = new ApiClientServices;
		$this->clientValidation = new ApiClientValidation;
		$this->viaCepServices = new ViaCepServices;
	}

	public function index()
	{
		return $this->respond(ApiClientServices::noContent());
	}

	// ==================================================

	public function getAll()
	{
		$result = $this->clientServices->getAll();
		return $this->respond($result);
	}

	// ==================================================

	public function getByCpf(string $cpf)
	{
		$result = $this->clientServices->getByCpf($cpf);
		return $this->respond($result);
	}

	// ==================================================

	public function insert()
	{
		$validateFields = $this->clientValidation->validateInsert($this->request);

		if ($validateFields)
			return $this->respond($validateFields);

		$validateCep = $this->viaCepServices->getAdress($this->request->getJSON()->cep);

		if ($validateCep['code'] !== Response::HTTP_OK)
			return $this->respond($validateCep);

		$insertClient = $this->clientServices->insert($this->request, $validateCep['data']);
		return $this->respond($insertClient);
	}

	// ==================================================


	public function delete($cpf = null)
	{
		$validateCpf =  $this->clientValidation->validateDelete($cpf);

		if ($validateCpf) {
			return $this->respond($validateCpf);
		}

		$deleteClient = $this->clientServices->delete($cpf);

		return $this->respond($deleteClient);
	}

	// ==================================================

	public function update($cpf = null)
	{
		$validateFields = $this->clientValidation->validateUpdate($this->request, $cpf);

		if ($validateFields)
			return $this->respond($validateFields);

		$validateCep = $this->viaCepServices->getAdress($this->request->getJSON()->cep);

		if ($validateCep['code'] !== Response::HTTP_OK)
			return $this->respond($validateCep);

		$updateClient = $this->clientServices->update($this->request, $validateCep['data'], $cpf);
		return $this->respond($updateClient);
	}
}
