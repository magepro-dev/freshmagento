<?php

declare(strict_types=1);

namespace Magepro\Test\Observer;

use Magento\Checkout\Model\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\Quote;
use Magento\Sales\Model\Order;

/**
 * Dispatcher for the `checkout_submit_all_after` event.
 */
class SavePurposeToOrderObserver implements ObserverInterface
{
    private $checkoutSession;

    /**
     * @param Session $checkoutSession
     */
    public function __construct(
        Session $checkoutSession
    ) {
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * @param Observer $observer
     * @return SavePurposeToOrderObserver
     */
    public function execute(Observer $observer): SavePurposeToOrderObserver
    {
        /** @var Order $order */
        $order = $observer->getEvent()->getOrder();

        /** @var Quote $quote */
        $quote = $observer->getEvent()->getQuote();

        $order->setData(
            'purpose',
            $quote->getData('purpose')
        );
        return $this;
    }
}
