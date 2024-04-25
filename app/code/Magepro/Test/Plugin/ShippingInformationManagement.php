<?php

namespace Magepro\Test\Plugin;

use Magento\Quote\Api\CartRepositoryInterface;

class ShippingInformationManagement
{
    /**
     * @var CartRepositoryInterface
     */
    private $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository) {
        $this->cartRepository = $cartRepository;
    }


    public function beforeSaveAddressInformation($subject, $cartId, $addressInformation) {
        $quote = $this->cartRepository->getActive($cartId);
        $purpose = $addressInformation->getShippingAddress()->getExtensionAttributes()->getPurpose();
        $quote->setPurpose($purpose);
        $this->cartRepository->save($quote);
        return [$cartId, $addressInformation];
    }
}
