<?php
/**
 * 2007-2019 Frédéric BENOIST
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 *  @author    Frédéric BENOIST
 *  @copyright 2013-2019 Frédéric BENOIST <https://www.fbenoist.com/>
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

if (!defined('_PS_VERSION_')) {
     exit;
}

use PrestaShop\PrestaShop\Adapter\SymfonyContainer;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FbSample_BoController extends Module
{
    public function __construct()
    {
        $this->name = 'fbsample_bocontroller';
        $this->version = '1.7.0';
        $this->author = 'Frederic BENOIST';
        $this->tab = 'others';
        $this->bootstrap = true;
        $this->ps_versions_compliancy = array(
            'min' => '1.7.5',
            'max' => _PS_VERSION_
        );
        parent::__construct();
        $this->displayName = $this->l('Sample Back Office Controller');
        $this->description = $this->l('PrestaShop 1.7 sample Back Office controller with Symfony and Twig');
    }

    public function install()
    {
        return parent::install()
            && $this->registerHook('displayAdminNavBarBeforeEnd')
            && $this->registerHook('displayBackOfficeHeader');
    }

    public function hookDisplayBackOfficeHeader()
    {
        // Use addCss : registerStylesheet is only for front controller.
        $this->context->controller->addCss(
            $this->_path.'views/css/fbsample_bocontroller.css'
        );
    }

    public function hookdisplayAdminNavBarBeforeEnd($params)
    {
        $sfContainer = SymfonyContainer::getInstance();
        return $sfContainer->get('twig')
            ->render('@PrestaShop/fbsample_bocontroller/menu.html.twig', [
                'in_symfony' => $this->isSymfonyContext(),
                'categ_title' => 'FbSample_BoController',
                'ctr_title' => 'Call IndexController',
                'ctr_url' => $sfContainer->get('router')->generate(
                    'fbsample_bocontroller_index',
                    array(),
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
            ]);
    }
}
