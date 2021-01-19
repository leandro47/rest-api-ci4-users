<?php

namespace App\Services;

use Unirest\Request;
use CodeIgniter\HTTP\Response;

class ViaCepServices
{
    protected $baseUrl = 'https://viacep.com.br/ws/';
    protected $format  = 'json';

    public function __construct()
    {
        $this->request = new Request;
    }

    /**
     * Get adress 
     *
     * Return avaiables:
     * 
     * response->code,
     * response->headers,
     * reponse->body,
     * reponse->raw_body,
     *
     * @param string $cep
     * @return array $response
     */
    public function getAdress(string $cep): array
    {
        $endPoint = $this->baseUrl . $cep . '/' . $this->format;
        $headers = array('Accept' => 'application/json');

        try {
            $response = $this->request->get($endPoint, $headers);
        } catch (Exception $e) {
            return  [
                'code'    => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
                'data'    => []
            ];
        }

        return $this->validate($response);
    }

    private static function validate($response): array
    {
        if (isset($response->body->erro)) {
            return  [
                'code'    => Response::HTTP_BAD_REQUEST,
                'message' => 'This CEP not is valid.',
                'data'    => []
            ];
        }
        return  [
            'code'    => Response::HTTP_OK,
            'message' => 'OK',
            'data'    => $response->body
        ];
    }
}
