<?php
/**
 * Oggetto Web extension pay for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the Oggetto Pay module to newer versions in the future.
 * If you wish to customize the module Pay for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_Pay
 * @copyright  Copyright (C) 2014 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Data helper
 *
 * @category   Oggetto
 * @package    Oggetto_Pay
 * @subpackage Helper
 * @author     Sergei Waribrus <svaribrus@oggettoweb.com>
 */
class Oggetto_Pay_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Formatting total
     *
     * @param string $total Total
     * @return string
     */
    public function formatTotal($total)
    {
        return number_format($total, 2, ',', '');
    }

    /**
     * Get from config api key
     *
     * @return string
     */
    public function getApiKey()
    {
        return Mage::getStoreConfig('payment/pay/api_key');
    }

    /**
     * Get from config url for request
     *
     * @return string
     */
    public function getGatewayUrl()
    {
        return Mage::getStoreConfig('payment/pay/gateway_url');
    }

    /**
     * Returned params on basis data order
     *
     * @param Mage_Sales_Model_Order $order Order
     * @return array
     */
    public function getParams($order)
    {
        $productNames = [];
        foreach ($order->getAllVisibleItems() as $item) {
            $productNames[] = $item->getName();
        }
        $stringProducts = implode(",", $productNames);

        return array(
            'error_url'          => 'http://brazen-badger-6869.vagrantshare.com/checkout/onepage/failure',
            'items'              => $stringProducts,
            'order_id'           => $order->getEntityId(),
            'payment_report_url' => 'http://brazen-badger-6869.vagrantshare.com/pay/index/report',
            'success_url'        => 'http://brazen-badger-6869.vagrantshare.com/checkout/onepage/success',
            'total'              => $this->formatTotal($order->getGrandTotal()),
        );
    }

    /**
     * Generate hash on basis params request
     *
     * @param array $items Params request
     * @return string
     */
    public function generateHash($items)
    {
        $params = '';
        foreach ($items as $key => $value) {
            $params .= $key . ':' . $value . '|';
        }

        return md5($params . $this->getApiKey());
    }


    /**
     * Returned array params finish for enter in template
     *
     * @return array
     */
    public function getRenderParams()
    {
        $params = $this->getParams($this->getOrder());
        $params['hash'] = $this->generateHash($params);
        return $params;
    }

    /**
     * Return object order
     *
     * @return mixed
     */
    public function getOrder()
    {
        $orderId = Mage::getSingleton('checkout/session')->getLastRealOrderId();
        return Mage::getModel('sales/order')->loadByIncrementId($orderId);
    }
}
