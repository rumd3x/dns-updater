<?php
namespace DnsUpdater\Functions;

use DnsUpdater\Classes\IPv4Address;
use DnsUpdater\Providers\DnsProviderInterface;
use DnsUpdater\Exceptions\InvalidProviderException;
use Monolog\Logger;
use Monolog\Handler\ErrorLogHandler;

final class DnsUpdater
{
    /**
     * Providers Map
     */
    public static $providerMap = [
        'cloudflare' => 'DnsUpdater\Providers\CloudFlare',
        'digitalocean' => 'DnsUpdater\Providers\DigitalOcean',
    ];

    /**
     * Update the DNS Record on the Provider
     */
    public function updateDnsRecord()
    {
        $logger = new Logger("DNS-Updater");
        $logger->pushHandler(new ErrorLogHandler());

        $logger->info("Getting current IP...");
        $currentIp = $this->getCurrentIp();
        $logger->info(sprintf("Current IP: %s", $currentIp));

        $logger->info(sprintf("Trying connect to \"%s\"...", getenv('PROVIDER')));
        $dnsProvider = $this->getProviderInstance();
        $logger->info(sprintf("Connected successfully using implementation: ", get_class($dnsProvider)));

        $logger->info("Getting DNS Record from provider...");
        $record = $dnsProvider->getRecord();
        $logger->info(sprintf("Current IP on Provider: %s", $record->getAddress()->getString()));

        if ($record->getAddress()->equals($currentIp)) {
            $logger->info("No change needed. Terminating.");
            return;
        }

        $logger->info(sprintf("Trying to update Record on Provider: %s -> %s", $record->getAddress()->getString(), $currentIp));
        $success = $dnsProvider->updateRecord($currentIp);

        if (!$success) {
            $logger->error("Failed to update DNS Record on provider!");
            return;
        }

        $logger->info("DNS Record updated successfully!");
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
    private function getProviderInstance(): DnsProviderInterface
    {
        $configuredProvider = strtolower(trim(getenv('PROVIDER')));
        if (!in_array($configuredProvider, array_keys(static::$providerMap))) {
            throw new InvalidProviderException($configuredProvider);
        }
        return new static::$providerMap[$configuredProvider];
    }
}
