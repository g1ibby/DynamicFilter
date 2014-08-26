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
 * Test helper data
 *
 * @category   Oggetto
 * @package    Oggetto_Pay
 * @subpackage Test
 * @author     Sergei Waribrus <svaribrus@oggettoweb.com>
 */

class Oggetto_Pay_Test_Helper_Data extends EcomDev_PHPUnit_Test_Case_Controller
{
    /**
     * Test correct returned params
     *
     * @return void
     */
    public function testReturnedParams()
    {
        $helper = Mage::helper('pay/data');

        $order = $this->getModelMock('sales/order', array('getAllItems', 'getGrandTotal', 'getEntityId'));
        $order->expects($this->any())
            ->method('getAllItems')
            ->will($this->returnValue(array(
                new Varien_Object(array(
                    'name' => 'Samsung'
                )),
            )));

        $order->expects($this->any())
            ->method('getGrandTotal')
            ->will($this->returnValue(111.22));

        $order->expects($this->any())
            ->method('getEntityId')
            ->will($this->returnValue(888));

        $this->assertEquals(
            array(
                'error_url'          => 'http://brazen-badger-6869.vagrantshare.com/checkout/onepage/failure',
                'items'              => 'Samsung',
                'order_id'           => 888,
                'payment_report_url' => 'http://brazen-badger-6869.vagrantshare.com/pay/index/report',
                'success_url'        => 'http://brazen-badger-6869.vagrantshare.com/checkout/onepage/success',
                'total'              => '111,22',
            ), $helper->getParams($order)
        );
    }

    /**
     * Test generate hash key
     *
     * @return void
     */
    public function testGenerateHaskKey()
    {
        $helper = Mage::helper('pay/data');
        $this->assertEquals($helper->generateHash(array(
            'error_url'          => 'http://brazen-badger-6869.vagrantshare.com/checkout/onepage/failure',
            'items'              => 'Samsung',
            'order_id'           => 888,
            'payment_report_url' => 'http://brazen-badger-6869.vagrantshare.com/pay/index/report',
            'success_url'        => 'http://brazen-badger-6869.vagrantshare.com/checkout/onepage/success',
            'total'              => '111,22',
        )), 'fc8e6540c1f3104f531446b92c457bb2');
    }

    /**
     * Test return render params
     *
     * @return void
     */
    public function testGetRenderParams()
    {
        $helper = Mage::helper('pay/data');

        $order = $this->getModelMock('sales/order', array('getAllItems', 'getGrandTotal', 'getEntityId'));
        $order->expects($this->any())
            ->method('getAllItems')
            ->will($this->returnValue(array(
                new Varien_Object(array(
                    'name' => 'Samsung'
                )),
            )));

        $order->expects($this->any())
            ->method('getGrandTotal')
            ->will($this->returnValue(111.22));

        $order->expects($this->any())
            ->method('getEntityId')
            ->will($this->returnValue(888));
        $this->replaceByMock('model', 'sales/order', $order);

        $this->assertEquals(
            array(
                'error_url'          => 'http://brazen-badger-6869.vagrantshare.com/checkout/onepage/failure',
                'items'              => 'Samsung',
                'order_id'           => 888,
                'payment_report_url' => 'http://brazen-badger-6869.vagrantshare.com/pay/index/report',
                'success_url'        => 'http://brazen-badger-6869.vagrantshare.com/checkout/onepage/success',
                'total'              => '111,22',
                'hash'               => 'fc8e6540c1f3104f531446b92c457bb2'
            ), $helper->getRenderParams()
        );

    }
}