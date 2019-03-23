<?php
namespace DnsUpdater\Providers;

use DnsUpdater\Classes\DnsRecord;
use DigitalOceanV2\DigitalOceanV2;
use DigitalOceanV2\Adapter\GuzzleHttpAdapter;
use DnsUpdater\Classes\IPv4Address;
use DnsUpdater\Classes\DigitalOceanDnsRecord;

/**
 * Digital Ocean DNS Updater
 */
final class DigitalOcean implements DnsProviderInterface
{
    /**
     * Instance of Connected DomainRecord DigitalOcean API
     *
     * @var DigitalOceanV2
     */
    private $api;

    public function __construct(string $apiKey)
    {
        $digitalOceanApi = new DigitalOceanV2(new GuzzleHttpAdapter($apiKey));
        $this->api = $digitalOceanApi->domainRecord();
    }

    public function getRecord(): DnsRecord
    {
        $domainRecords = $this->api->getAll(getenv('DOMAIN'));
        $recordsCollection = collect($domainRecords);
        $record = $recordsCollection->firstWhere('name', getenv('RECORD'));
        return new DigitalOceanDnsRecord($record->id, getenv('DOMAIN'), $record->name, new IPv4Address($record->data));
    }

    public function updateRecord(DnsRecord $record): bool
    {
        $result = $this->api->updateData($record->getDomain(), $record->getId(), $record->getAddress()->getString());
        return (empty($result) || $result->data !== $record->getAddress()->getString());
    }

}
