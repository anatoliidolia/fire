<?php

declare(strict_types=1);

namespace Firebear\ImportExport\Model\Migration\PostJob;

use Firebear\ImportExport\Model\Migration\Config;
use Firebear\ImportExport\Model\Migration\DbConnection;
use Firebear\ImportExport\Model\Migration\PostJobInterface;

class CleanupEmptySku implements PostJobInterface
{
    /**
     * @var DbConnection
     */
    private $connector;

    /**
     * @var Config
     */
    private $config;

    /**
     * @param DbConnection $connector
     * @param Config $config
     */
    public function __construct(
        DbConnection $connector,
        Config $config
    ) {
        $this->connector = $connector;
        $this->config = $config;
    }

    /**
     * Delete products with sku is null
     */
    public function job(): void
    {
        $destination = $this->connector->getDestinationChannel();

        $destination->delete(
            $this->config->getM2Prefix() . 'catalog_product_entity',
            "sku IS NULL"
        );
    }
}
