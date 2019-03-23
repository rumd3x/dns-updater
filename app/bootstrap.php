<?php
require __DIR__.'/../vendor/autoload.php';
use DnsUpdater\Functions\DnsUpdater;
(new DnsUpdater)->updateDnsRecord();
