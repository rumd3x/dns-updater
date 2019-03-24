<?php
namespace DnsUpdater\Providers;

use DnsUpdater\Classes\DnsRecord;
use DnsUpdater\Classes\IPv4Address;

interface DnsProviderInterface
{
    /**
     * Retrieves the Record as a DnsRecord Object
     *
     * @return DnsRecord
     */
    public function getRecord(): DnsRecord;

    /**
     * Updates the DNS Record with the following ip address
     *
     * @param IPv4Address $address
     * @return boolean
     */
    public function updateRecord(IPv4Address $address): bool;
}
