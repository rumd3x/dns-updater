<?php
namespace DnsUpdater\Functions;

use DnsUpdater\Classes\IPv4Address;
use DnsUpdater\Providers\DnsProviderInterface;
use DnsUpdater\Exceptions\InvalidProviderException;

final class DnsUpdater
{
    /**
     * Providers Map
     */
    static $providerMap = [
        'cloudflare' => 'CloudFlare',
        'digitalocean' => 'DigitalOcean',
    ];

    /**
     * Update the DNS Record on the Provider
     */
    public function updateDnsRecord()
    {
        $currentIp = $this->getCurrentIp();
        $dnsProvider = $this->getProviderInstance();
        $record = $dnsProvider->getRecord();

        if ($record->getAddress()->equals($currentIp)) {
            return;
        }

        $record->setAddress($currentIp);
        $dnsProvider->updateRecord($record);
    }

    /**
     * Retrieve current IP Address
     *
     * @return IPv4Address
     */
    private function getCurrentIp(): IPv4Address
    {
        $currentIp = file_get_contents("http://ipecho.net/plain");
        return new IPv4Address($currentIp);
    }

    /**
     * Gets an instance of the configured provider
     *
     * @return DnsProviderInterface
     * @throws ExcepInvalidProviderExceptiontion
     */
    private function getProviderInstance(): DnsProviderInterface {
        $configuredProvider = strtolower(trim(getenv('PROVIDER')));
        if (!in_array($configuredProvider, static::$providerMap)) {
            throw new InvalidProviderException($configuredProvider);
        }
        return new static::$providerMap[$configuredProvider](getenv('KEY'));
    }
}
