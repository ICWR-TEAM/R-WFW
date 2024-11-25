<?php

// POST

$route->Route(method: 'post', url: '/test', handler: "Test::post");
$route->Route(method: 'post', url: '/test/post', handler: "Test::post");
$route->Route(method: 'post', url: '/test/auth/login', handler: "AuthTest::login");
$route->Route(method: 'post', url: '/test/auth/check', handler: "AuthTest::check");
$route->Route(method: 'post', url: '/test/auth/check_header', handler: "AuthTest::checkHeader");
$route->Route(method: 'post', url: '/test/sign/create', handler: "Signature::create");
$route->Route(method: 'post', url: '/test/sign/check', handler: "Signature::check");
$route->Route(method: 'post', url: '/test/sign/specific/create', handler: "Signature::signSpecific");
$route->Route(method: 'post', url: '/test/sign/specific/check', handler: "Signature::signSpecificCheck");