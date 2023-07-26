<?php
/**
 * @copyright: Copyright © 2019 Firebear Studio. All rights reserved.
 * @author   : Firebear Studio <fbeardev@gmail.com>
 */

declare(strict_types=1);

namespace Firebear\ImportExport\Model\Export\FilterProcessor;

use Magento\Framework\Data\Collection;

/**
 * @api
 */
interface FilterProcessorInterface
{
    /**
     * Filter Processor Interface is used as an Extension Point for each Attribute Data Type (Backend Type)
     * to process filtering applied from Export
     * to all attributes of Entity being exported
     *
     * @param Collection $collection
     * @param string $columnName
     * @param array|string $value
     * @return void
     */
    public function process(Collection $collection, string $columnName, $value);
}
