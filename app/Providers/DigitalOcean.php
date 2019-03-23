<?php
namespace DnsUpdater\Providers;

use DnsUpdater\Classes\DnsRecord;
use DigitalOceanV2\DigitalOceanV2;
use DigitalOceanV2\Adapter\GuzzleHttpAdapter;
use DnsUpdater\Classes\IPv4Address;

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

    /**
     * The DNS Record
     *
     * @var DigitalOceanV2\Entity\DomainRecord
     */
    private $record;

    public function __construct()
    {
        $digitalOceanApi = new DigitalOceanV2(new GuzzleHttpAdapter(getenv('KEY')));
        $this->api = $digitalOceanApi->domainRecord();

        $domainRecords = $this->api->getAll(getenv('DOMAIN'));
        $recordsCollection = collect($domainRecords);
        $this->record = $recordsCollection->firstWhere('name', getenv('RECORD'));
    }

    public function getRecord(): DnsRecord
    {
        return new DnsRecord($this->record->name, new IPv4Address($this->record->data));
    }

    public function updateRecord(IPv4Address $address): bool
    {
        $result = $this->api->updateData(getenv('DOMAIN'), $this->record->id, $address->getString());
        return (empty($result) || $result->data !== $this->record->getString());
    }
}
