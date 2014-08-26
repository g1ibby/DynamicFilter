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
 * controller processing frontend
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @subpackage Controller
 * @author     Sergei Waribrus <svaribrus@oggettoweb.com>
 */

class Oggetto_Question_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * General report action
     *
     * @return void
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * List question answer
     *
     * @return void
     */
    public function listAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Processing question
     *
     * @return void
     */
    public function sendAction()
    {
        if ($this->getRequest()->isPost()) {

            try {
                $post = $this->getRequest()->getPost();
                $question = Mage::getModel('question/question');
                $question->setName($post['fname']);
                $question->setEmail($post['email']);
                $question->setText($post['message']);

                $question->save();

                Mage::getSingleton('core/session')->addSuccess($this->__('Your question has been added'));
            } catch(Mage_Catalog_Exception $e) {
                Mage::getSingleton('core/session')->addError($e);
            } catch(Exception $e) {
                Mage::logException($e->getMessage());
            }
        }

        $this->_redirectReferer();
    }

}
