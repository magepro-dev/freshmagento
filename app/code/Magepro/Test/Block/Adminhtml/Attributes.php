<?php

namespace Magepro\Test\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Framework\Json\Helper\Data as JsonHelper;
use Magento\Sales\Api\OrderRepositoryInterface;

class Attributes extends Template
{
    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    public function __construct(
        Template\Context $context,
        OrderRepositoryInterface $orderRepository,
        array            $data = [],
        ?JsonHelper      $jsonHelper = null,
        ?DirectoryHelper $directoryHelper = null
    ) {
        $this->orderRepository = $orderRepository;
        parent::__construct($context, $data, $jsonHelper, $directoryHelper);
    }

    public function getOrder()
    {
        try {
            $orderId = $this->getRequest()->getParam('order_id');
            return $this->orderRepository->get($orderId);
        } catch (\Exception $e) {
            return false;
        }
    }
}
