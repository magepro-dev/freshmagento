<?php

declare(strict_types=1);

namespace Magepro\Test\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Page\Config;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Dispatcher for the `layout_render_before` event.
 * @property LoggerInterface $logger
 */
class AddBodyClassObserver implements ObserverInterface
{
    /**
     * @var StoreManagerInterface $storeManager
     */
    private StoreManagerInterface $storeManager;

    /**
     * @var Config
     */
    private Config $pageConfig;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @param StoreManagerInterface $storeManager
     * @param Config $pageConfig
     * @param LoggerInterface $logger
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        Config $pageConfig,
        LoggerInterface $logger
    ){
         $this->storeManager = $storeManager;
         $this->pageConfig = $pageConfig;
         $this->logger = $logger;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        try {
            if ($this->pageConfig->getElementAttribute(
                Config::ELEMENT_TYPE_BODY,
                Config::BODY_ATTRIBUTE_CLASS
            )) {
                foreach ($this->storeManager->getStores() as $store) {
                    if ($this->storeManager->getStore()->getCode() === $store->getCode()) {
                        $this->pageConfig->addBodyClass('store-' . $store->getCode());
                    }
                }
            }
        } catch (\Exception $exception) {
            $this->logger->critical($exception);
        }
    }
}
