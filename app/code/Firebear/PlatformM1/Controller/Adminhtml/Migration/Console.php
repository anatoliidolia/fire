<?php
/**
 * @copyright: Copyright © 2019 Firebear Studio. All rights reserved.
 * @author   : Firebear Studio <fbeardev@gmail.com>
 */

namespace Firebear\PlatformM1\Controller\Adminhtml\Migration;

use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Shell;

class Console extends Action
{
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;
    /**
     * @var Shell
     */
    protected $shell;
    /**
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param Shell $shell
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        Shell $shell
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->shell = $shell;
    }
    /**
     * Action
     */
    public function execute()
    {
        $errors = [];
        $data = [];
        $postData = $this->getRequest()->getPostValue();
        if (empty($postData['path'])) {
            $errors['path'] = 'Name is required.';
        }
        if (empty($postData['command'])) {
            $errors['command'] = 'command is required.';
        }
        if (!empty($errors)) {
            $data['success'] = false;
            $data['errors']  = $errors;
        } else {
            $data['success'] = true;
            $command = "php " . $postData['path'] . "/" . $postData['command'];
            $data['message'] = "<pre>" . $this->shell->execute($command) . "</pre>";
        }

        return $this->resultJsonFactory->create()->setData($data);
    }
}
