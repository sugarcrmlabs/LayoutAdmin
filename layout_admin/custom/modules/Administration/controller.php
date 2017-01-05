<?php

require_once("modules/Administration/controller.php");

class CustomAdministrationController extends AdministrationController{

    public function action_defaultsetting(){
        $this->view = "defaultsetting";
    }

    public function action_savevalues(){
        $postElements = $_POST;

        $module = $postElements['col_module'];
        $colNumber = $postElements['col_layout'];

        if ($module && $colNumber) {
            $file = "modules/$module/clients/base/views/record/record.php";
            if (SugarAutoLoader::fileExists("custom/$file")) {
                require "custom/$file";
            } else {
                if (SugarAutoLoader::fileExists($file)) {
                    require $file;
                }
            }

            if (!empty($viewdefs[$module]['base']['view']['record']['panels'])) {
                $tempPanels = $viewdefs[$module]['base']['view']['record']['panels'];
                foreach($tempPanels as $key=>$panel) {
                    $tempPanels[$key]['columns'] = $colNumber;
                    $tempPanels[$key]['changed_with_admin_tool'] = 1;
                }

                $viewdefs[$module]['base']['view']['record']['panels'] = $tempPanels;

                $parser = ParserFactory::getParser(
                    'recordview',
                    $module,
                    null,
                    null,
                    'base',
                    array()
                );

                $parser->_viewdefs['panels'] = $parser->convertFromCanonicalForm($viewdefs[$module]['base']['view']['record']['panels']);

                $parser->handleSave(false);
            }
        }

        header("Location: index.php?module=Administration&action=DefaultSetting&saved=true");
    }
}