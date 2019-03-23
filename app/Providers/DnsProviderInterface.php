<?php
namespace DnsUpdater\Providers;

use DnsUpdater\Classes\DnsRecord;
use DnsUpdater\Classes\IPv4Address;

interface DnsProviderInterface
{
    public function getRecord(): DnsRecord;
    public function updateRecord(IPv4Address $address): bool;
}
