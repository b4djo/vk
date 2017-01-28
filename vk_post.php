<?php

include "vk.php";
$access_token = "";
$user_id = "";


$vk = new Vk($access_token);

$params = array(
    "owner_id" => $user_id,
    "message" => "Hello world!",
	'from_group' => 1
);
$post = $vk->method("wall.post", $params);