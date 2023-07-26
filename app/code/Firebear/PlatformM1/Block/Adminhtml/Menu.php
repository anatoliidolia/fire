<?php
/**
 * @copyright: Copyright © 2019 Firebear Studio. All rights reserved.
 * @author   : Firebear Studio <fbeardev@gmail.com>
 */

namespace Firebear\PlatformM1\Block\Adminhtml;

/**
 * Class Menu
 *
 * @package Firebear\PlatformM1\Block\Adminhtml
 */
class Menu extends \Magento\Backend\Block\Template
{
    /**
     * @var string
     */
    protected $_template = 'Firebear_PlatformM1::menu.phtml';

    /**
     * @var \Magento\Framework\Module\ResourceInterface
     */
    protected $moduleResource;

    /**
     * Menu constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Module\ResourceInterface $moduleResource,
        array $data = []
    ) {
        $this->moduleResource = $moduleResource;
        parent::__construct($context, $data);
    }

    public function getVersion()
    {
        return  $this->moduleResource->getDbVersion('Firebear_PlatformM1');
    }
}
