<?php
namespace Concrete\Package\FegAddon;

defined('C5_EXECUTE') or die('Access Denied.');

use \Concrete\Core\Package\Package;
use \Concrete\Core\Page\Single as SinglePage;
use \Concrete\Core\Block\BlockType\BlockType;

class Controller extends Package
{
    protected $pkgHandle = 'feg_addon';
    protected $appVersionRequired = '5.7.5.0';
    protected $pkgVersion = '0.1';

    public function getPackageDescription()
    {
        return t('Addition Design Elements for FEG Effretikon and FEG Connect.');
    }

    public function getPackageName()
    {
        return t('FEG Effretikon / FEG Connect Design Addons');
    }

    public function install()
    {
        $pkg = parent::install();
        $this->installSinglePages($pkg);
        $this->installBlockTypes($pkg);
    }

    function installBlockTypes($pkg) {
    }

    function installSinglePages($pkg) {
    }
    public function uninstall() {
        $pkg = parent:: uninstall();
        try {
        } catch(\Exception $e) {

        }
    }
}