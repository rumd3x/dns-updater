<?php
namespace DnsUpdater\Classes;

class DigitalOceanDnsRecord extends DnsRecord
{
    /**
     * ID of the DNS Record inside DigitalOcean
     *
     * @var string
     */
    private $digitalOceanId;

    /**
     * Creates a new Digital Ocean DNS Record Object
     *
     * @param string $id
     * @param string $domain
     * @param string $name
     * @param IPv4Address $address
     */
    public function __construct(string $digitalOceanId, string $domain, string $name, IPv4Address $address)
    {
        $this->digitalOceanId = $digitalOceanId;
        parent::__construct($domain, $name, $address);
    }

    /**
     * Get the ID of the DNS Record inside DigitalOcean
     *
     * @return string
     */
    public function getId(): string {
        return $this->digitalOceanId;
    }
}
