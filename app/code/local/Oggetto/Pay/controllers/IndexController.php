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
 * Controller for to process requests from the server
 *
 * @category   Oggetto
 * @package    Oggetto_Pay
 * @subpackage Controller
 * @author     Sergei Waribrus <svaribrus@oggettoweb.com>
 */

class Oggetto_Pay_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Hide form for send data
     *
     * @return void
     */
    public function sendAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Processing report payment gateway
     *
     * @return void;
     */
    public function reportAction()
    {
        try {
            $request = $this->getRequest();
            $report = Mage::getModel('report', $request);

            $report->validation();
            $report->processing();

            $this->getResponse()->setHttpResponseCode(200);
            return;
        } catch (Mage_Core_Exception $e) {
            Mage::logException($e);
            $this->getResponse()->setHttpResponseCode(500);
            return;
        } catch (Oggetto_Pay_Model_ValidException $e) {
            $this->getResponse()->setHttpResponseCode(400);
            return;
        }
    }
}
