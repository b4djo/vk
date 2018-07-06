<?php

namespace b4djo\app\lib;

/**
 * Class VK
 * @package app\lib
 */
class VK
{
    /**
     * @var string
     */
    private $access_token;

    /**
     * @var string
     */
    private $url = "https://api.vk.com/method/";

    /**
     * VK constructor
     *
     * @param $access_token
     */
    public function __construct($access_token)
    {
        $this->access_token = $access_token;
    }

    /**
     * @param $method
     * @param null $params
     *
     * @return bool|mixed
     */
    public function method($method, $params = null)
    {
        $p = "";
        if ($params && is_array($params)) {
            foreach ($params as $key => $param) {
                $p .= ($p == "" ? "" : "&") . $key . "=" . urlencode($param);
            }
        }
        $response = file_get_contents($this->url . $method . "?" . ($p ? $p . "&" : "") . "access_token=" . $this->access_token);

        if ($response) {
            return json_decode($response);
        }

        return false;
    }
}