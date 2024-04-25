<?php

declare(strict_types=1);

namespace Magepro\Test\Observer;

use Magento\Framework\DataObject\Copy;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\Quote;
use Magento\Sales\Model\Order;

/**
 * Dispatcher for the `sales_model_service_quote_submit_before` event.
 */
class SalesModelServiceQuoteSubmitBeforeObserver implements ObserverInterface
{
    /**
     * @var Copy
     */
    private $objectCopyService;

    /**
     * @param Copy $objectCopyService
     */
    public function __construct(
        Copy $objectCopyService
    ) {
        $this->objectCopyService = $objectCopyService;
    }
    /**
     * Handle the `sales_model_service_quote_submit_before` event.
     *
     * @param Observer $observer
     *
     * @return SalesModelServiceQuoteSubmitBeforeObserver
     */
    public function execute(Observer $observer): SalesModelServiceQuoteSubmitBeforeObserver
    {
        $this->objectCopyService->copyFieldsetToTarget(
            'sales_convert_quote',
            'to_order',
            $observer->getEvent()->getQuote(),
            $observer->getEvent()->getOrder()
        );

        return $this;
    }
}
