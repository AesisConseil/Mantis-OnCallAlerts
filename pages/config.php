<?php
auth_reauthenticate();
access_ensure_global_level(config_get('manage_plugin_threshold'));
html_page_top(plugin_lang_get('management_title'));
print_manage_menu();
?>
<br/>
<form action="<?php echo plugin_page('config_update') ?>" method="post">
    <?php echo form_security_field('plugin_OnCallAlerts_config_update') ?>

    <table align="center" class="width50" cellspacing="1">

        <tr>
            <td class="form-title" colspan="2">
                <?php echo plugin_lang_get('config_global_title'); ?>
            </td>
        </tr>

        <tr <?php echo helper_alternate_class() ?>>
            <td class="category">
                <?php echo plugin_lang_get('config_global_nbrLog'); ?>
            </td>
            <td class="center">
                <select name='nb_day_log'>
                    <option value='5' <?php if(plugin_config_get('nb_day_log') == 5)  echo 'selected="selected"';?> >5</option>
                    <option value='10' <?php if(plugin_config_get('nb_day_log') == 10) echo 'selected="selected"';?> >10</option>
                    <option value='15' <?php if(plugin_config_get('nb_day_log') == 15) echo 'selected="selected"';?> >15</option>
                    <option value='20' <?php if(plugin_config_get('nb_day_log') == 20) echo 'selected="selected"';?> >20</option>
                    <option value='25' <?php if(plugin_config_get('nb_day_log') == 25) echo 'selected="selected"';?> >25</option>
                    <option value='30' <?php if(plugin_config_get('nb_day_log') == 30) echo 'selected="selected"';?> >30</option>
                </select>
            </td>
        </tr>
        <tr <?php echo helper_alternate_class() ?>>
            <td class="category">
                <?php echo plugin_lang_get('config_global_url'); ?>
            </td>
            <td class="center">
                <input type='text' name='url_mantis_text' style='width:380px;' value='<?php echo plugin_config_get('url_mantis_text'); ?>' >
            </td>
        </tr>
        <tr <?php echo helper_alternate_class() ?>>
            <td class="category">
                <?php echo plugin_lang_get('config_global_textAlert'); ?> <br /><br /><br />
                <span style='font-size: 8px'>#CATEGORY , #IDBUG, #PROJECTNAME, #RAPPORTEUR, #DATE, #URL</span>
            </td>
            <td class="center">
                <textarea name='msg_text' cols="50" rows="6" maxlength="159"><?php echo plugin_config_get('msg_text'); ?></textarea>
            </td>
        </tr>
        <tr <?php echo helper_alternate_class() ?>>
            <td class="category">
                <?php echo plugin_lang_get('config_global_textRecall'); ?><br /><br /><br />
                <span style='font-size: 8px'>#STARTDATE , #ENDATE, #TECHNICIAN</span>
            </td>
            <td class="center">
                <textarea name='msg_text_rappel' cols="50" rows="6" maxlength="159"><?php echo plugin_config_get('msg_text_rappel'); ?></textarea>
            </td>
        </tr>
        <tr <?php echo helper_alternate_class() ?>>
            <td class="category">
                <?php echo plugin_lang_get('config_global_textTest'); ?> <br /><br /><br />
                <span style='font-size: 8px'>#TECHNICIAN</span>
            </td>
            <td class="center">
                <textarea name='msg_text_test' cols="50" rows="6" maxlength="159"><?php echo plugin_config_get('msg_text_test'); ?></textarea>
            </td>
        </tr>
        <tr>
            <td class="form-title" colspan="2">
                <?php echo plugin_lang_get('config_textServer_title'); ?>
            </td>
        </tr>
        <tr <?php echo helper_alternate_class() ?>>
            <td class="category">
                <?php echo plugin_lang_get('config_textServer_url'); ?>
            </td>
            <td class="center">
                <input type='text' name='url_server_text' style='width:380px;' value='<?php echo plugin_config_get('url_server_text'); ?>' >
            </td>
        </tr>
        <tr <?php echo helper_alternate_class() ?>>
            <td class="category">
                <?php echo plugin_lang_get('config_textServer_key'); ?>
            </td>
            <td class="center">
                <textarea name='publickey_server_text' cols="65" rows="12"><?php echo plugin_config_get('publickey_server_text'); ?></textarea>
            </td>
        </tr>
        <tr <?php echo helper_alternate_class() ?>>
            <td class="category">
                <?php echo plugin_lang_get('config_textServer_data'); ?>
            </td>
            <td class="center">
                <input type='text' name='data_server_text' style='width:380px;' value='<?php echo plugin_config_get('data_server_text'); ?>' >
            </td>
        </tr>
        <tr <?php echo helper_alternate_class() ?>>
            <td class="category">
                <?php echo plugin_lang_get('config_textServer_login'); ?>
            </td>
            <td class="center">
                <input type='text' name='login_server_text' style='width:380px;' value='<?php echo plugin_config_get('login_server_text'); ?>' >
            </td>
        </tr>
        <tr <?php echo helper_alternate_class() ?>>
            <td class="category">
                <?php echo plugin_lang_get('config_textServer_pwd'); ?>
            </td>
            <td class="center">
                <input type='password' name='pwd_server_text' style='width:380px;' value='<?php echo plugin_config_get('pwd_server_text'); ?>' >
            </td>
        </tr>
        <tr>
            <td class="center" colspan="3">
                <input type="submit" class="button" value="<?php echo plugin_lang_get('save'); ?>" />
            </td>
        </tr>

    </table>
    <form>
<?php
html_page_bottom();
        