<?php
/**
 * @copyright: Copyright © 2019 Firebear Studio. All rights reserved.
 * @author   : Firebear Studio <fbeardev@gmail.com>
 */

namespace Firebear\ImportExport\Model\Migration\Field\Job;

use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\Store;

/**
 * @inheritdoc
 */
class MapStoreId extends MapValue
{
    /**
     * @inheritdoc
     */
    public function job(
        $sourceField,
        $sourceValue,
        $destinationFiled,
        $destinationValue,
        $sourceDataRow
    ) {
        try {
            if ($sourceValue === null) {
                $sourceValue = Store::DEFAULT_STORE_ID;
            }
            return parent::job($sourceField, $sourceValue, $destinationFiled, $destinationValue, $sourceDataRow);
        } catch (LocalizedException $e) {
            throw new LocalizedException(__("Mapping not found for store id %1", $sourceValue));
        }
    }
}
