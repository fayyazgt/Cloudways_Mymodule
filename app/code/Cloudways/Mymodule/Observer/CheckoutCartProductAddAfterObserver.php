<?php
/**
 * Copyright © 2016 MagePal. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Cloudways\Mymodule\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

/**
 * Google Analytics module observer
 *
 */
class CheckoutCartProductAddAfterObserver implements ObserverInterface
{
    /**
     * @var \Magento\Framework\View\LayoutInterface
     */
    protected $_layout;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;


    protected $_request;

    /**
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\View\LayoutInterface $layout
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\LayoutInterface $layout,
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->_layout = $layout;
        $this->_storeManager = $storeManager;
        $this->_request = $request;
    }

    /**
     * Add order information into GA block to render on checkout success pages
     *
     * @param EventObserver $observer
     * @return void
     */
    public function execute(EventObserver $observer)
    {
        /* @var Magento\Quote\Model\Quote\Item $item */
        $item = $observer->getQuoteItem();

        $additionalOptions = array();

        if ($additionalOption = $item->getOptionByCode('additional_options')){
            $additionalOptions = (array) unserialize($additionalOption->getValue());
        }

        $post = $this->_request->getParam('cloudways');

        if(is_array($post)){
            foreach($post as $key => $value){
                if($key == '' || $value == ''){
                    continue;
                }

                $additionalOptions[] = [
                    'label' => $key,
                    'value' => $value
                ];
            }
        }

        if(count($additionalOptions) > 0){
            $item->addOption(array(
                'code' => 'additional_options',
                'value' => serialize($additionalOptions)
            ));
        }


        /* To Do */

        // Edit Cart - May need to remove option and readd them
        // Pre-fill remarks on product edit pages
        // Check for comparability with custom option

    }
}
