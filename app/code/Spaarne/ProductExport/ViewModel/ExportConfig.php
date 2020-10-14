<?php
declare(strict_types=1);
/**
 * @copyright Copyright (c) Spaarne Webdesign, Haarlem, The Netherlands
 * @author Enno Stuurman <enno@spaarnewebdesign.nl>
 */

namespace Spaarne\ProductExport\ViewModel;

use Magento\Framework\AuthorizationInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class ExportConfig implements ArgumentInterface
{
    const ADMIN_RESOURCE = 'Spaarne_ProductExport::ProductExport';

    /**
     * @var AuthorizationInterface
     */
    private AuthorizationInterface $authorization;

    /**
     * ExportConfig constructor.
     * @param AuthorizationInterface $authorization
     */
    public function __construct(
        AuthorizationInterface $authorization
    ) {
        $this->authorization = $authorization;
    }

    /**
     * @return bool
     */
    public function isAuthorized(): bool
    {
        return $this->authorization->isAllowed(static::ADMIN_RESOURCE);
    }
}
