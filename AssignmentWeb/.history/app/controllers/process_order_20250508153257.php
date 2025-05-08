<?php
require_once __DIR__ . '/Auth.php';
require_once __DIR__ . '/../helper/session.php';

$auth = new Auth();
$auth->handleRequest();