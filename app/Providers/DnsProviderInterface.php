<?php
namespace DnsUpdater\Providers;

use DnsUpdater\Classes\DnsRecord;

interface DnsProviderInterface
{
    public function __construct(string $apiKey);
    public function getRecord(): DnsRecord;
    public function updateRecord(DnsRecord $record): bool;
}
