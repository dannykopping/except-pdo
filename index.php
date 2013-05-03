<?php
require_once "vendor/autoload.php";
use Except\Except;
use Except\Message;

Except::analyze(new PDOException("Unknown database 'testy'", Message::UNKNOWN_DATABASE));