<?php
if (empty($_GET['service']))
	return;

$endpoint = 'http://duoshuo.com/login-callback/' . strtolower(trim($_GET['service'])) . '/';

unset($_GET['service']);

$callbackUrl = $endpoint . '?' . http_build_query($_GET);

header('Location: ' . $callbackUrl, true);
