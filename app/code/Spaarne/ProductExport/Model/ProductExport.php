<?php
declare(strict_types=1);
/**
 * @copyright Copyright (c) Spaarne Webdesign, Haarlem, The Netherlands
 * @author Enno Stuurman <enno@spaarnewebdesign.nl>
 */

namespace Spaarne\ProductExport\Model;

use Magento\Framework\Model\AbstractModel;
use Spaarne\ProductExport\Api\Data\ProductExportInterface;
use Spaarne\ProductExport\Model\ResourceModel\ProductExport as ProductExportResource;

class ProductExport extends AbstractModel implements ProductExportInterface
{

    public function _construct()
    {
        $this->_init(ProductExportResource::class);
    }

    /**
     * @return int
     */
    public function getId() //: ?int
    {
        return $this->getData('id');
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->getData('product_id');
    }

    /**
     * @param $productId
     */
    public function setProductId($productId): void
    {
        $this->setData('product_id', $productId);
    }

    /**
     * @return \DateTime
     */
    public function getExportedAt(): \DateTime
    {
        return $this->getData('exported_at');
    }

    /**
     * @param $exportedAt
     */
    public function setExportedAt($exportedAt): void
    {
        $this->setData('exported_at', $exportedAt);
    }

    /**
     * @return bool
     */
    public function hasBeenExported(): bool
    {
        return (bool)$this->getData('exported_at');
    }
}
