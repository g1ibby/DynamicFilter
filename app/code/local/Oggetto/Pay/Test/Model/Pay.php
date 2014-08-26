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
 * Test payment model
 *
 * @category   Oggetto
 * @package    Oggetto_Pay
 * @subpackage Test
 * @author     Sergei Waribrus <svaribrus@oggettoweb.com>
 */
class Oggetto_Pay_Test_Model_Pay extends EcomDev_PHPUnit_Test_Case_Controller
{
    /**
     * Order place redirect url test
     *
     * @return void
     */
    public function testCorrectReturnedRedirectUrl()
    {
        $pay = Mage::getModel('pay/pay');

        $this->assertEquals(Mage::getUrl('pay/index/send', array('_secure' => true)),
            $pay->getOrderPlaceRedirectUrl());
    }
}
