<?php

namespace frontend\service;

class Response
{
    private $answer;

    private $result;

    private $error;

    public function __construct($json)
    {
        $this->answer = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error = json_last_error_msg();
            return;
        }
        if (isset($this->answer['response']['GeoObjectCollection'])) {
            $this->result = $this->answer['response']['GeoObjectCollection'];
        }
        if (isset($this->answer['error'])) {
            $this->error = $this->answer['error'];
        }
    }

    public function getResultData()
    {
        return $this->result['featureMember'] ?: [];
    }

    public function getResultMeta()
    {
        return $this->result['metaDataProperty'] ?: [];
    }

    public function hasError()
    {
        return !empty($this->error);
    }

    public function getError()
    {
        return $this->error;
    }

}
