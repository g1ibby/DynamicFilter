<?php
/**
 * Oggetto Web Question extension for Magento
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
 * the Oggetto Question module to newer versions in the future.
 * If you wish to customize the Oggetto Question module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Oggetto
 * @package   Oggetto_Question
 * @copyright Copyright (C) 2014, Oggetto Web (http://oggettoweb.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * block form send question
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @subpackage Block
 * @author     Sergei Waribrus <svaribrus@oggettoweb.com>
 */

class Oggetto_Question_Block_Form extends Mage_Core_Block_Template
{
    /**
     * Get send URL
     *
     * @return string
     */
    public function getSendUrl()
    {
        return Mage::getUrl('question/index/send');
    }

    /**
     * Return email current customer
     *
     * @return string
     */
    public function getCustomerEmail()
    {
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            return Mage::getSingleton('customer/session')->getCustomer()->getEmail();
        } else {
            return '';
        }
    }

    /**
     * Return name current customer
     *
     * @return string
     */
    public function getCustomerName()
    {
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            return Mage::getSingleton('customer/session')->getCustomer()->getName();
        } else {
            return '';
        }
    }
}