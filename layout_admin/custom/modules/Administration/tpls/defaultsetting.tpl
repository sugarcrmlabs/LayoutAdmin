{*
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
*}
{literal}
    <style>
        .success-message{
            margin-bottom: 15px;
            font-weight: bold;
        }

        #my-table .row {
            clear: both;
            margin: 15px 0px;
        }

        #my-table .row  .my-column {
            display: inline-block;
            text-align: center;
            width: 20%;
        }

        #my-table .row  .my-column.left {
            text-align: left;
        }

        #my-table .row  .my-column.header {
            font-weight: bold;
            font-size: 18px;
        }

        #my-table .row  .my-column input {
            width: 50px;
            text-align: center;
        }
    </style>
{/literal}

<div class="hr"></div>

<script type="text/javascript">
    {literal}
    $(document).ready(function () {
        $('#CANCEL_HEADER, #CANCEL_FOOTER').click(function(){
            SUGAR.App.router.redirect('Administration')
        });
    });
    {/literal}
</script>

{if $FROM_SAVE}
<div class="success-message">
    Your settings were successfully saved!
</div>
{/if}

<div style="margin-bottom: 15px; text-align: left">
    <input title="" type="button" name="cancel" value="  Cancel  "
           onclick="document.location.href='index.php?module=Administration&amp;action=index'" class="button" >
</div>

<div id="my-table">
    <div class="row">
        <div class="my-column header">Module Name</div>
        <div class="my-column header">Number of columns</div>
        <div class="my-column header">Changed from Administration tool</div>
        <div class="my-column header"></div>
    </div>
{foreach from=$MODULES key=k item=v}
<form enctype="multipart/form-data" name="valuesstabs" method="POST" action="index.php" id="valuesstabs">
    <div class="row">
        {sugar_csrf_form_token}
        <input type="hidden" name="module" value="Administration">
        <input type="hidden" name="action" value="savevalues">
        <div class="my-column">
            <input type="hidden" name="col_module" value="{$v.module}"/>{$v.module_label}
        </div>
        <div class="my-column">
            <input type="text" name="col_layout" value="{$v.columns}"/>
        </div>
        <div class="my-column">
            {if $v.changed_with_admin_tool}Yes{else}No{/if}
        </div>
        <div class="my-column left">
            <input type="submit" id="mysubmit" value="  Save  " class="button primary"/>
        </div>
    </div>
</form>
{/foreach}
</div>
<div style="margin-top: 15px; text-align: left">
    <input title="" type="button" name="cancel" value="  Cancel  "
           onclick="document.location.href='index.php?module=Administration&amp;action=index'" class="button" >
</div>


