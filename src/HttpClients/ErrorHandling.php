<?php


namespace HRD\Alocom\HttpClients;


class ErrorHandling
{

    /**
     * @param int $statusCode
     * @param array $result
     *
     * @throws \Exception
     */
    public function fire(int $statusCode, array $result)
    {
        if (empty($result['message']) && empty($result['status'])) {
            throw new \Exception("i don't know! please connect to Pasargad gateway", $statusCode);
        }
        echo json_encode($result).PHP_EOL;
        throw new \Exception(json_encode($result), $result['status']);
    }
}
