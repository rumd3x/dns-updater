<?php
require __DIR__.'/../vendor/autoload.php';
use Dotenv\Dotenv;
use DnsUpdater\Functions\DnsUpdater;

$dotenv = new Dotenv(__DIR__ . '/..');
$dotenv->load();
$dotenv->required('PROVIDER')->notEmpty();
$dotenv->required('KEY')->notEmpty();
$dotenv->required('RECORD')->notEmpty();
$dotenv->required('DOMAIN')->notEmpty();

(new DnsUpdater)->updateDnsRecord();
