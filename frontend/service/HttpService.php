<?php

namespace frontend\service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7;
use yii;

class HttpService
{
    const URI = '';
    const LOG_FILE = '';

    protected $options = [];

    /**
     * @var Client
     */
    protected $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => static::URI, 'proxy' => Yii::getAlias('@proxy')]);
    }

    /**
     * @param array $bodyOptions
     * @param string $method
     * @return Response
     */
    protected function sendRequest($bodyOptions, $method = 'GET')
    {
        $contents = '';
        try {
            $options = $this->getQuerry($bodyOptions);
            $this->log(json_encode($options, JSON_PRETTY_PRINT));
            $response = $this->client->request($method, static::URI, $options);
            $contents = $response->getBody()->getContents();
            $this->log($contents);
        } catch (GuzzleException $e) {
            $message = Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                $message .= PHP_EOL . Psr7\str($e->getResponse());
            }
            $this->log($message);
        }

        return new Response($contents);
    }

    /**
     * @param array $options
     * @return array
     */
    protected function getQuerry($options)
    {
        return ['query' => $options];
    }

    /**
     * @param string $message
     */
    protected function log($message)
    {
        if (static::LOG_FILE) {
            file_put_contents(Yii::getAlias('@web') . static::LOG_FILE, $message . str_repeat(PHP_EOL, 2), FILE_APPEND);
        }
        return;
    }
}