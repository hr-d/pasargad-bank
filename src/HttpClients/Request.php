<?php

namespace HRD\Pasargad\HttpClients;

class Request
{

    /**
     * @var GuzzleHttpClient
     */
    private $client;


    /**
     * Constructor.
     *
     * @param GuzzleHttpClient|null $client
     */
    public function __construct(GuzzleHttpClient $client = null)
    {
        $this->client = $client ?: new GuzzleHttpClient();
    }

    /**
     * @param string $path
     * @param string $method
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function make(string $path, string $method, array $params)
    {
        $Authorization = $this->get_auth();
        try {
            return $this->client->make($this->get_apiUrl($path), $method, $params, [
                'Authorization' => "Bearer " . $Authorization]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    /**
     * get_auth
     *
     * @return string
     * @throws \Exception
     */
    private function get_auth()
    {
        $username = env('PASARGAD_USERNAME');
        $password = env('PASARGAD_PASSWORD');
        try {
            $result = $this->client->make($this->get_apiUrl('token/getToken'), "post", [
                "username" => $username,
                "password" => $password,
            ]);
            return $result['token'];
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    /**
     * @param string $path
     * @return string
     */
    private function get_apiUrl(string $path)
    {
        return env('PASARGAD_BASE_API_URL', 'https://pep.shaparak.ir/dorsa1/api/') . $path;
    }
}
