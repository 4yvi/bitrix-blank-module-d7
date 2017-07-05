<?php

use \Bitrix\Main\Application;
use \Bitrix\Main\ModuleManager;
use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class blank_module extends CModule
{
    var $MODULE_ID = 'blank_module';
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_GROUP_RIGHTS = 'Y';

    public function __construct()
    {
        // Получаем версию и дату из файла version.php
        $arModuleVersion = [];
        $strPath = str_replace('\\', '/', __FILE__);
        $strPath = substr($strPath, 0, strlen($strPath) - strlen('/index.php'));

        include($strPath.'/version.php');

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_NAME = Loc::getMessage('BLANK_MODULE_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('BLANK_MODULE_MODULE_DESCRIPTION');
        $this->PARTNER_NAME = Loc::getMessage('BLANK_MODULE_PARTNER_NAME');
        $this->PARTNER_URI = "";
    }

    // Устанавливаем все, что связано с БД
    public function InstallDB()
    {
        // Сохранил путь к модулю
        Option::set($this->MODULE_ID, 'path', $this->getPath(true));

        return true;
    }

    // Удаляем все, что связано с БД
    public function UnInstallDB()
    {
        // Удаляем путь к модулю
        Option::delete($this->MODULE_ID, 'path');

        return true;
    }

    // Устанавливаем события
    public function InstallEvents()
    {
        return true;
    }

    // Удаляем события
    public function UnInstallEvents()
    {
        return true;
    }

    // Устанавливаем файлы
    public function InstallFiles()
    {
        return true;
    }

    // Удалаяем файлы
    public function UnInstallFiles()
    {
        return true;
    }

    public function DoInstall()
    {
        // Регистрируем модуль
        ModuleManager::registerModule($this->MODULE_ID);

        $this->InstallDB();
        $this->InstallEvents();
        $this->InstallFiles();
    }

    public function DoUninstall()
    {
        $this->UnInstallFiles();
        $this->UnInstallEvents();
        $this->UnInstallDB();

        // Удаляем регистрацию модуля
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    /**
     * Определяем место размещения модуля
     *
     * @param bool $notDocRoot - не показывать полный путь
     *
     * @return string - путь к модулю
     */
    public function getPath($notDocRoot = false)
    {
        if ($notDocRoot) {
            return str_ireplace(
                Application::getDocumentRoot(),
                '',
                dirname(__DIR__)
            );
        } else {
            return dirname(__DIR__);
        }
    }
}
