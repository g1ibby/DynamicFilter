<?php
/**
 * Oggetto Web extension for Magento
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
 * the Oggetto Module module to newer versions in the future.
 * If you wish to customize the module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_Module
 * @copyright  Copyright (C) 2014 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
/**
 * Enter some description...
 *
 * @category   Oggetto
 * @package    Oggetto_Module
 * @subpackage Model
 * @author     Sergei Waribrus <svaribrus@oggettoweb.com>
 */

class Oggetto_Pay_Model_Report
{
    const PAYMENT_ACCEPTED  = 1;
    const PAYMENT_CANCELLED = 2;

    private $request;
    private $order;

    /**
     * Method init data class
     *
     * @param $request
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
        $this->helper = Mage::helper('pay');
    }

    /**
     * Validation data request
     *
     * @throws Oggetto_Pay_Model_ValidException
     * @return void
     */
    public function validation()
    {
        if (!$this->request->isPost() || !$this->request->getPost('order_id')) {
            throw new Oggetto_Pay_Model_ValidException($this->helper->__('Not valid request'));
        }

        $this->order = Mage::getModel('sales/order')->load($this->request->getPost('order_id'));

        if (!$this->order->getId() ||
            $this->helper->formatTotal($this->order->getGrandTotal()) != $this->request->getPost('total') ||
            $this->helper->generateHash($this->helper->getParams($this->order)) != $this->request->getPost('hash')
        ) {
            throw new Oggetto_Pay_Model_ValidException($this->helper->__('Not valid data'));
        }
    }

    /**
     * Processing
     *
     * @return void
     */
    public function processing()
    {
        if ($this->request->getPost('status') == self::PAYMENT_ACCEPTED) {
            $this->order->setState(Mage_Sales_Model_Order::STATE_COMPLETE, true);
        } elseif ($this->request->getPost('status') == self::PAYMENT_CANCELLED) {
            $this->order->cancel()->setState(Mage_Sales_Model_Order::STATE_CANCELED, true);
        } else {
            throw new Oggetto_Pay_Model_ValidException($this->helper->__('Not valid status'));
        }

        $this->order->save();
    }
}