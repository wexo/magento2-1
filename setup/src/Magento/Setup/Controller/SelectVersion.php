<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Setup\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Magento\Setup\Model\SystemPackage;
use Zend\View\Model\JsonModel;

/**
 * Controller for selecting version
 */
class SelectVersion extends AbstractActionController
{

    /**
     * @var SystemPackage
     */
    protected $systemPackage;

    /**
     * @param SystemPackage $systemPackage
     */
    public function __construct(SystemPackage $systemPackage)
    {
        $this->systemPackage = $systemPackage;
    }
    /**
     * @return ViewModel|\Zend\Http\Response
     */
    public function indexAction()
    {
        $view = new ViewModel;
        $view->setTerminal(true);
        $view->setTemplate('/magento/setup/select-version.phtml');
        return $view;
    }

    /**
     * Gets system package and versions
     *
     * @param string $type
     * @return array
     */
    public function systemPackageAction()
    {
        $data = [];

        try {
            $data['package'] = $this->systemPackage->getPackageVersions();
            $responseType = ResponseTypeInterface::RESPONSE_TYPE_SUCCESS;
        } catch (\Exception $e) {
            $responseType = ResponseTypeInterface::RESPONSE_TYPE_ERROR;
        }

        $data['responseType'] = $responseType;

        return new JsonModel($data);
    }
}
