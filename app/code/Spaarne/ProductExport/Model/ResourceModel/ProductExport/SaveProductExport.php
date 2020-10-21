<?php
declare(strict_types=1);
/**
 * @copyright Copyright (c) Spaarne Webdesign, Haarlem, The Netherlands
 * @author Enno Stuurman <enno@spaarnewebdesign.nl>
 */

namespace Spaarne\ProductExport\Model\ResourceModel\ProductExport;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\CouldNotSaveException;

class SaveProductExport
{
    private const MAIN_TABLE = 'spaarne_product_export';
    private const PRODUCT_ID = 'product_id';
    private const EXPORTED_AT = 'exported_at';

   /**
     * @var ResourceConnection
     */
    private ResourceConnection $resourceConnection;

    /**
     * SaveProductExport constructor.
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
      ResourceConnection $resourceConnection
    ) {
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @param $productId
     * @param $exportedAt
     * @throws CouldNotSaveException
     */
    public function execute(int $productId, $exportedAt): void
    {
        try {
            $connection = $this->resourceConnection->getConnection();
            $table = $connection->getTableName(self::MAIN_TABLE);
            $data = [
                self::PRODUCT_ID => $productId,
                self::EXPORTED_AT => $exportedAt
            ];
            $connection->insertOnDuplicate($table, $data, [self::PRODUCT_ID, self::EXPORTED_AT]);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
    }
}
