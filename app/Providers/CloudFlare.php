<?php
namespace DnsUpdater\Providers;

use Cloudflare\API\Auth\APIKey;
use Cloudflare\API\Endpoints\DNS;
use DnsUpdater\Classes\DnsRecord;
use Cloudflare\API\Endpoints\Zones;
use DnsUpdater\Classes\IPv4Address;
use DnsUpdater\Adapters\CloudFlareAdapter;

/**
 * CloudFlare DNS Updater
 */
final class CloudFlare implements DnsProviderInterface
{
    /**
     * Cloudflare configured DNS api
     *
     * @var DNS
     */
    private $api;

    /**
     * Cloudflare Record
     *
     * @var \StdClass
     */
    private $record;

    public function __construct()
    {
        [$email, $key] = explode(';', getenv('KEY'));
        $adapter = new CloudFlareAdapter(new APIKey($email, $key));

        $this->api = new DNS($adapter);

        $recordsCollection = collect($this->api->listRecords((new Zones($adapter))->getZoneID(getenv('DOMAIN')))->result);
        $this->record = $recordsCollection->firstWhere('name', sprintf('%s.%s', getenv('RECORD'), getenv('DOMAIN')));
    }

    /**
     * @inheritDoc
     */
    public function getRecord(): DnsRecord
    {
        return new DnsRecord(getenv('RECORD'), new IPv4Address($this->record->content));
    }

    /**
     * @inheritDoc
     */
    public function updateRecord(IPv4Address $address): bool
    {
        $this->record->content = $address->getString();
        $result = $this->api->updateRecordDetails($this->record->zone_id, $this->record->id, (array) $this->record);
        return ($result->success);
    }
}
