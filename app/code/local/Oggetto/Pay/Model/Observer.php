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
 * @package    Oggetto_Module
 * @copyright  Copyright (C) 2014 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
/**
 * Observer for payment method Oggetto_Pay
 *
 * @category   Oggetto
 * @package    Oggetto_Pay
 * @subpackage Model
 * @author     Sergei Waribrus <svaribrus@oggettoweb.com>
 */
class Oggetto_Pay_Model_Observer
{
    /**
     * Edit order status
     *
     * @param $event Event
     * @return $this
     */
    public function implementOrderStatus($event)
    {
        $order = $event->getOrder();

        if ($this->_getPaymentMethod($order) == 'pay') {
            if ($order->canInvoice()) {
                $this->_processOrderStatus($order);
            }
        }
        return $this;
    }

    /**
     * Return code current payment method
     *
     * @param $order Mage_Sales_Model_Order order
     * @return mixed
     */
    private function _getPaymentMethod($order)
    {
        return $order->getPayment()->getMethodInstance()->getCode();
    }

    /**
     * Edit order status
     *
     * @param $order Mage_Sales_Model_Order order order
     * @return bool
     */
    private function _processOrderStatus($order)
    {
        $invoice = $order->prepareInvoice();

        $invoice->register();
        Mage::getModel('core/resource_transaction')
            ->addObject($invoice)
            ->addObject($invoice->getOrder())
            ->save();

        $invoice->sendEmail(true, '');
        $this->_changeOrderStatus($order);
        return true;
    }

    /**
     * Set order status
     *
     * @param $order Mage_Sales_Model_Order order order
     * @return void
     */
    private function _changeOrderStatus($order)
    {
        $order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, true);
        $order->save();
    }
}