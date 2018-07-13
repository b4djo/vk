<?php

namespace b4djo\vk\app\lib;

/**
 * Class VK
 * @package b4djo\vk\app\lib
 */
class VK
{
    const V_5_70 = '5.70';
    const V_5_80 = '5.80';

    /**
     * @var string
     */
    private $access_token;

    /**
     * @var string
     */
    private $url = "https://api.vk.com/method/";

    /**
     * @var string
     */
    private $v = self::V_5_80;

    /**
     * VK constructor
     *
     * @param string $access_token
     * @param string|null $v
     */
    public function __construct(string $access_token, string $v = null)
    {
        $this->access_token = $access_token;

        if ($v) {
            $this->validVersion($v);
            $this->v = $v;
        }
    }

    /**
     * @param string $method
     * @param array|null $params
     *
     * @return bool|mixed
     */
    public function method(string $method, $params = null)
    {
        $p = "";
        if ($params && is_array($params)) {
            foreach ($params as $key => $param) {
                $p .= ($p == "" ? "" : "&") . $key . "=" . urlencode($param);
            }
        }
        $response = file_get_contents($this->url . $method . "?" . ($p ? $p . "&" : "") . "access_token=" . $this->access_token . '&v' . $this->v);

        if ($response) {
            return json_decode($response);
        }

        return false;
    }

    /**
     * @param string $version
     */
    private function validVersion($version)
    {
        $validVersions = [
            static::V_5_70,
            static::V_5_80,
        ];

        if (!in_array($version, $validVersions)) {
            throw new \InvalidArgumentException(sprintf(
                    'Unknown version %s, Supported versions: %s.',
                    $version,
                    implode(', ', $validVersions)
                )
            );
        }
    }
}