<?php
namespace DnsUpdater\Classes;

use Rumd3x\BaseObject\BaseObject;
use DnsUpdater\Exceptions\InvalidIPException;

/**
 * IPv4 Address Object Representation
 */
final class IPv4Address extends BaseObject
{
    /**
     * IPv4 Address String Representation
     *
     * @var string
     */
    private $address;

    /**
     * @param string $address
     * @throws InvalidIPException
     */
    public function __construct(string $address)
    {
        $address = trim($address);

        if (!filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE)) {
            throw new InvalidIPException($address);
        }

        $this->address = $address;
    }

    /**
     * Retrieve the IPv4 address string
     *
     * @return string
     */
    public function getString(): string
    {
        return $this->address;
    }

    /**
     * Compares two IP Addresses
     *
     * @param IPv4Address $otherAddress
     * @return boolean
     */
    public function equals(IPv4Address $otherAddress): bool
    {
        return $this->address === $otherAddress->getString();
    }
}
