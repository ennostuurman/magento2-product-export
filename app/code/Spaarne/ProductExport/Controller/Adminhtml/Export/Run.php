<?php
declare(strict_types=1);
/**
 * @copyright Copyright (c) Spaarne Webdesign, Haarlem, The Netherlands
 * @author Enno Stuurman <enno@spaarnewebdesign.nl>
 */

namespace Spaarne\ProductExport\Controller\Adminhtml\Export;

use Magento\Backend\App\Action as AdminAction;
use Magento\Backend\App\Action\Context as ActionContext;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Type;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem;
use Magento\Framework\View\LayoutFactory;
use Magento\InventoryCatalogApi\Api\DefaultStockProviderInterface;
use Magento\InventorySalesApi\Api\GetProductSalableQtyInterface;
use Psr\Log\LoggerInterface;

class Run extends AdminAction implements HttpPostActionInterface
{
    /**
     * @var Filesystem
     */
    private Filesystem $filesystem;

    /**
     * @var Filesystem
     */
    private $directory;

    /**
     * @var ProductCollectionFactory
     */
    private ProductCollectionFactory $productCollectionFactory;

    /**
     * @var GetProductSalableQtyInterface
     */
    private GetProductSalableQtyInterface $productSalableQty;

    /**
     * @var DefaultStockProviderInterface
     */
    private DefaultStockProviderInterface$defaultStockProviderInterface;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var JsonFactory
     */
    private JsonFactory $resultJsonFactory;
    /**
     * @var LayoutFactory
     */
    private LayoutFactory $layoutFactory;


    /**
     * CreateProductCsv constructor.
     * @param ActionContext $context
     * @param Filesystem $filesystem
     * @param ProductCollectionFactory $productCollectionFactory
     * @param GetProductSalableQtyInterface $productSalableQty
     * @param DefaultStockProviderInterface $defaultStockProviderInterface
     * @param LoggerInterface $logger
     * @param JsonFactory $resultJsonFactory
     * @param LayoutFactory $layoutFactory
     * @throws FileSystemException
     */
    public function __construct(
        ActionContext $context,
        Filesystem $filesystem,
        ProductCollectionFactory $productCollectionFactory,
        GetProductSalableQtyInterface $productSalableQty,
        DefaultStockProviderInterface $defaultStockProviderInterface,
        LoggerInterface $logger,
        JsonFactory $resultJsonFactory,
        LayoutFactory $layoutFactory

    ) {
        $this->filesystem = $filesystem;
        $this->directory = $filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
        $this->productCollectionFactory = $productCollectionFactory;
        $this->productSalableQty = $productSalableQty;
        $this->defaultStockProviderInterface = $defaultStockProviderInterface;
        $this->logger = $logger;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->layoutFactory = $layoutFactory;
        parent::__construct($context);
    }

    /**
     * Create product csv
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     * @throws FileSystemException
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        /** @var $block \Magento\Framework\View\Element\Messages */
        $block = $this->layoutFactory->create()->getMessagesBlock();
        $error = false;

        try {
            $filepath = 'export/spaarne-product-export.csv';
            $this->directory->create('export');
            $stream = $this->directory->openFile($filepath, 'w+');
            $stream->lock();
            $header = ['SKU', 'Name', 'Stock'];
            $stream->writeCsv($header);

            $collection = $this->productCollectionFactory->create();
            $collection->addAttributeToSelect(['sku','name']);
            $collection->addFieldToFilter('status', [
                'eq' => Product\Attribute\Source\Status::STATUS_ENABLED
            ]);
            $collection->addFieldToFilter('type_id', [
                'eq' => Type::TYPE_SIMPLE
            ]);

            /** @var Product $product */
            foreach ($collection as $product) {
                $sku = $product->getSku();
                $data = [];
                $data[] = $sku;
                $data[] = $product->getName();
                $data[] = $this->getSalableQty($sku);
                $stream->writeCsv($data);
            }

            $stream->unlock();
            $stream->close();

            $this->messageManager->addSuccessMessage(
                __('Products have been successfully exported')
            );
        } catch (\Exception $e) {
            $error = true;
            $this->messageManager->addErrorMessage(
                __('Couldn\'t export products to CSV. Please check the error logs')
            );
            $this->logger->error(
                $e->getMessage(), [
                $e->getTraceAsString()
                ]
            );
        }

        $block->setMessages($this->messageManager->getMessages(true));
        $resultJson = $this->resultJsonFactory->create();

        return $resultJson->setData([
            'messages' => $block->getGroupedHtml(),
            'error' => $error
        ]);
    }

    /**
     * Get salable stock qty
     *
     * @param string $sku
     * @return float|null
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getSalableQty(string $sku): ?float
    {
        return $this->productSalableQty->execute(
            $sku,
            $this->defaultStockProviderInterface->getId()
        );
    }
}
