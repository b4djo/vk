# vk
Work for vk api

Usage:

`$vk = new b4djo\app\lib\VK($params['access_token']);`

`$params = array(
    "owner_id"      => $params['user_id'],
    "message"       => "Hello world!",
	'from_group'    => 1
);`
`$post = $vk->method("wall.post", $params);`