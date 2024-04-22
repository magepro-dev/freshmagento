<?php

declare(strict_types=1);

namespace Magepro\Test\Observer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Dispatcher for the `save_hobbies_attribute` event.
 */
class SaveHobbiesAttributeObserver implements ObserverInterface
{
    /**
     * @var CustomerRepositoryInterface
     */
    private CustomerRepositoryInterface $customerRepositoryInterface;

    public function __construct(
        CustomerRepositoryInterface $customerRepositoryInterface
    ) {
        $this->customerRepositoryInterface = $customerRepositoryInterface;
    }
    /**
     * Handle the `save_hobbies_attribute` event.
     *
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer): void
    {
//        $event = $observer->getEvent();
//        $customer = $event->getCustomer();
        $customer = $observer->getEvent()->getCustomer();
        $customerData = $customer->getData('hobbies');

        if (!$customerData) {
            $customer->setCustomAttribute('hobbies', $customerData);
            $this->customerRepositoryInterface->save($customer);
        }
    }
}
