<?php

use Zencart\PluginSupport\ScriptedInstaller as ScriptedInstallBase;

class ScriptedInstaller extends ScriptedInstallBase {

    protected function executeInstall() {
        $sql = "SELECT @products_options_types_id := pot.products_options_types_id+1
                FROM " . TABLE_PRODUCTS_OPTIONS_TYPES . " pot
                ORDER BY pot.products_options_types_id DESC LIMIT 1;" .
                "INSERT INTO " . TABLE_PRODUCTS_OPTIONS_TYPES . " (products_options_types_id, products_options_types_name)
                 VALUES (@products_options_types_id, 'Link');" .
                "INSERT INTO " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function, set_function)
                 VALUES ('Link product option type', 'PRODUCTS_OPTIONS_TYPE_LINK', @products_options_types_id, 'Numeric value of the link product option type', 6, 0, now(), NULL, NULL);";
        $this->executeInstallerSql($sql);
    }

    protected function executeUninstall() {

        $this->deleteConfigurationKeys(['PRODUCTS_OPTIONS_TYPE_LINK']);
    }
}
