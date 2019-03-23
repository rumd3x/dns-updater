<?php
namespace DnsUpdater\Providers;

use DnsUpdater\Classes\DnsRecord;

interface DnsProviderInterface
{
    public function getRecord(): DnsRecord;
    public function updateRecord(DnsRecord $record): bool;
}
