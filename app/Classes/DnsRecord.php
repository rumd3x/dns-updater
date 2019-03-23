<?php
namespace DnsUpdater\Classes;

use Rumd3x\BaseObject\BaseObject;
use DnsUpdater\Classes\IPv4Address;

class DnsRecord extends BaseObject
{
    /**
     * IP Address
     *
     * @var IPv4Address
     */
    private $address;

    /**
     * Name of the DNS Record
     *
     * @var string
     */
    private $name;

    /**
     * Creates a new DNS Record Object
     *
     * @param string $name
     * @param IPv4Address $address
     */
    public function __construct(string $name, IPv4Address $address)
    {
        $this->name = trim($name);
        $this->address = $address;
    }

    /**
     * Retrieve the DNS Record Name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Retrieve the DNS Record Address
     *
     * @return IPv4Address
     */
    public function getAddress(): IPv4Address
    {
        return $this->address;
    }
}
