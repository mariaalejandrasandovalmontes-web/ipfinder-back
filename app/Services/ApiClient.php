<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;

class ApiClient
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false,
            'timeout' => 30,
        ]);
    }

    public function get($url, $headers = [])
    {
        try {
            $response = $this->client->get($url, [
                'headers' => $headers
            ]);

            return [
                'success' => true,
                'data' => json_decode($response->getBody()->getContents(), true)
            ];
        } catch (ConnectException $e) {
            return [
                'success' => false,
                'error' => 'Error de conexión con el servidor API'
            ];
        } catch (RequestException $e) {
            return [
                'success' => false,
                'error' => 'Error en la solicitud: ' . $e->getMessage()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Error inesperado: ' . $e->getMessage()
            ];
        }
    }


    public function post($url, $data = [], $headers = [])
    {
        try {
            $response = $this->client->post($url, [
                'headers' => $headers,
                'form_params' => $data
            ]);

            return [
                'success' => true,
                'data' => json_decode($response->getBody()->getContents(), true)
            ];
        } catch (ConnectException $e) {
            return [
                'success' => false,
                'error' => 'Error de conexión con el servidor API'
            ];
        } catch (RequestException $e) {
            return [
                'success' => false,
                'error' => 'Error en la solicitud: ' . $e->getMessage()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Error inesperado: ' . $e->getMessage()
            ];
        }
    }
}
