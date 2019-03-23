<?php
namespace DnsUpdater\Exceptions;

/**
 * Tried instanciating an invalid IPv4 Object Instance
 */
class InvalidIPException extends \Exception
{
    public function __construct(string $ip)
    {
        parent::__construct(sprintf("Invalid IP Address: %s", $ip));
    }
}
