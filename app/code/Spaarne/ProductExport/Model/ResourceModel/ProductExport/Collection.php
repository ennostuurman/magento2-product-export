<?php
declare(strict_types=1);
/**
 * @copyright Copyright (c) Spaarne Webdesign, Haarlem, The Netherlands
 * @author Enno Stuurman <enno@spaarnewebdesign.nl>
 */

namespace Spaarne\ProductExport\Model\ResourceModel\ProductExport;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Spaarne\ProductExport\Model\ProductExport as ProductExportModel;
use Spaarne\ProductExport\Model\ResourceModel\ProductExport as ProductExportResource;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(
            ProductExportModel::class,
            ProductExportResource::class
        );
    }
}
