<?php
declare(strict_types=1);
/**
 * @copyright Copyright (c) Spaarne Webdesign, Haarlem, The Netherlands
 * @author Enno Stuurman <enno@spaarnewebdesign.nl>
 */

namespace Spaarne\ProductExport\Api\Data;

interface ProductExportInterface
{
    /**
     * @return int
     */
    public function getId(); //: ?int;

    /**
     * @return int
     */
    public function getProductId(): int;

    /**
     * @param $productId
     */
    public function setProductId($productId): void;

    /**
     * @return \DateTime
     */
    public function getExportedAt(): \DateTime;

    /**
     * @param $exportedAt
     */
    public function setExportedAt($exportedAt): void;

    /**
     * @return bool
     */
    public function hasBeenExported(): bool;
}


