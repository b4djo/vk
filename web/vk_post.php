<?php

require_once('../app/lib/VK.php');

$params = include('../config/main-local.php'); // replace your config main.php

$vk = new VK($params['access_token']);

$params = array(
    "owner_id"      => $params['user_id'],
    "message"       => "Hello world!",
	'from_group'    => 1
);
$post = $vk->method("wall.post", $params);