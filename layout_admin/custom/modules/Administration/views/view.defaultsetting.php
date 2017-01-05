<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/*********************************************************************************

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

class ViewDefaultSetting extends SugarView
{

    public $allowedModules = array(
        'Accounts',
        'Contacts',
        'Opportunities',
        'Calls',
        'Meetings',
        'Emails',
        'Tasks'
    );


    /**
     * @see SugarView::display()
     */
    public function display()
    {
        global $mod_strings, $moduleList;

        $fromSave = isset($_REQUEST['saved']) ?  : 0;
        $myModuleList = $this->getFormattedModuleList($moduleList);
        $this->ss->assign("MODULES", $myModuleList);
        $this->ss->assign("FROM_SAVE", $fromSave);
        $content = $this->ss->fetch('custom/modules/Administration/tpls/defaultsetting.tpl');

        $this->ss->assign("DEFAULT_SETTING_TITLE", $mod_strings['LBL_DEFAULT_SETTING_TITLE']);
        $this->ss->assign("CONTENT",$content);
        $this->ss->display('custom/modules/Administration/tpls/wrapper.tpl');
    }

    public function getFormattedModuleList($moduleList) {
        $formattedModuleList = array();
        sort($moduleList);

        foreach($moduleList as $module) {
            $temp = array(
                'module' => $module,
                'module_label' => translate($module),
                'columns' => 2,
                'changed_with_admin_tool' => 0
            );

            $file = "modules/$module/clients/base/views/record/record.php";
            if (SugarAutoLoader::fileExists("custom/$file")) {
                require "custom/$file";
            } else {
                if (SugarAutoLoader::fileExists($file)) {
                    require $file;
                }
            }

            if (!empty($viewdefs[$module]['base']['view']['record']['panels'])) {
                $panels = $viewdefs[$module]['base']['view']['record']['panels'];

                foreach($panels as $panel) {
                    if (isset($panel['columns']) && $panel['columns'] > $temp['columns']) {
                        $temp['columns'] = $panel['columns'];
                    }

                    if (isset($panel['changed_with_admin_tool'])) {
                        $temp['changed_with_admin_tool'] = $panel['changed_with_admin_tool'];
                    }
                }
            }

            $formattedModuleList[] = $temp;
        }

        return $formattedModuleList;
    }

}
