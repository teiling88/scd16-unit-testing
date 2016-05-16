<?php

use Doctrine\Common\Collections\ArrayCollection;
use TEiling\Scd16\Commands\Scd16Command;

class Shopware_Plugins_Core_Scd16_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{
    public function install()
    {
        $minSwVersion = $this->getPluginJsonAsArray()['compatibility']['minimumVersion'];
        if (!$this->assertMinimumVersion($minSwVersion)) {
            throw new \RuntimeException('At least Shopware ' . $minSwVersion . ' is required');
        }

        $this->subscribeEvent(
            'Shopware_Console_Add_Command',
            'onAddConsoleCommand'
        );

        return true;
    }

    /**
     * Callback function of the console event subscriber. Register your console commands here.
     *
     * @param Enlight_Event_EventArgs $args
     *
     * @return ArrayCollection
     * @throws \LogicException
     */
    public function onAddConsoleCommand(Enlight_Event_EventArgs $args)
    {
        $this->registerMyComponents();

        return new ArrayCollection(
            [
                new Scd16Command()
            ]
        );
    }

    /**
     * registerMyComponents function to add auto loader
     */
    private function registerMyComponents()
    {
        require_once(__DIR__ . '/vendor/autoload.php');
    }

    /**
     * @return array
     * @throws Enlight_Config_Exception
     */
    private function getPluginJsonAsArray()
    {
        $json = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'plugin.json'), true);
        if ($json) {
            return $json;
        } else {
            throw new \Enlight_Config_Exception('The plugin has an invalid version file.');
        }
    }

    /**
     * @return mixed
     * @throws Enlight_Config_Exception
     */
    public function getVersion()
    {
        return $this->getPluginJsonAsArray()['currentVersion'];
    }

    /**
     * @return mixed
     * @throws Enlight_Config_Exception
     */
    public function getLabel()
    {
        return $this->getPluginJsonAsArray()['label']['de'];
    }

    /**
     * @return array with information
     * @throws \Enlight_Config_Exception
     * returns an array with information for Shopware Plugin Manager
     */
    public function getInfo()
    {
        return [
            'version' => $this->getVersion(),
            'label' => $this->getLabel(),
            'author' => $this->getPluginJsonAsArray()['author'],
            'link' => $this->getPluginJsonAsArray()['link'],
            'description' => $this->getPluginJsonAsArray()['description']
        ];
    }
}
