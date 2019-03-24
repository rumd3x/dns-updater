<?php
namespace DnsUpdater\Exceptions;

/**
 * Invalid Provider configured on the ENV
 */
class InvalidProviderException extends \Exception
{
    /**
     * @param string $provider
     */
    public function __construct(string $provider)
    {
        parent::__construct(sprintf("Invalid Provider: %s", $provider));
    }
}
