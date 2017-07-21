<?php
access_ensure_global_level(config_get('manage_plugin_threshold'));
html_page_top(plugin_lang_get('management_title'));
print_manage_menu();

$dirLog = __DIR__ . '/../logs';
$listeLog = array_slice(scandir($dirLog), 2, 20);
rsort($listeLog);

$onCall = new OnCallAlertsOncall();
$planing = new OnCallAlertsPlaning();
$technician = new OnCallAlertsTechnician();
$resTechnician = $technician->fetchall();
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="<?php echo plugin_file('jquery-dataTables-1-10-15-min.js'); ?>" ></script>
<script type="text/javascript" src="<?php echo plugin_file('management.js'); ?>" ></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js" ></script>
<script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.15/sorting/datetime-moment.js" ></script>

<link rel="stylesheet" type="text/css" href="<?php echo plugin_file('jquery-dataTables-1-10-15-min.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo plugin_file('management.css'); ?>" />

<div id="tabsOnCallAlerts">
    <ul>
        <li><a href="#tabs-1"><font color="#000000">[ </font><?php echo plugin_lang_get('management_tabsConfiguration_title'); ?><font color="#000000"> ]</font></a></li>
        <li><a href="#tabs-2"><font color="#000000">[ </font><?php echo plugin_lang_get('management_tabsTechnician_title'); ?><font color="#000000"> ]</font></a></li>
        <li><a href="#tabs-3"><font color="#000000">[ </font><?php echo plugin_lang_get('management_tabsOnCall_title'); ?><font color="#000000"> ]</font></a></li>
        <li><a href="#tabs-4"><font color="#000000">[ </font><?php echo plugin_lang_get('management_tabsPlaning_title'); ?><font color="#000000"> ]</font></a></li>
        <li><a href="#tabs-5"><font color="#000000">[ </font><?php echo plugin_lang_get('management_tabsLogs_title'); ?><font color="#000000"> ]</font></a></li>
    </ul>
    <div id="tabs-1">
        <form action="<?php echo plugin_page('config_sms_update') ?>" method="post">
            <?php echo form_security_field('plugin_OnCallAlerts_config_sms_update') ?> 
            <table align="center" class="width50" cellspacing="1">
                <tr>
                    <td class="form-title" colspan="2">
                        <?php echo plugin_lang_get('management_config_project_title'); ?>
                    </td>
                </tr>
                <tr <?php echo helper_alternate_class() ?>>
                    <td class="category">
                       <?php echo plugin_lang_get('management_config_projectMonitoring'); ?>
                    </td>
                    <td class="center">
                        <select style='height:150px;' name="select_project[]" multiple>
                            <?php print_project_option_list(plugin_config_get('select_project')) ?>;
                        </select> 
                    </td> 
                </tr>
                <tr>
                    <td class="form-title" colspan="2"> 
                       <?php echo plugin_lang_get('management_config_send_title'); ?>
                    </td>
                </tr>

                <tr <?php echo helper_alternate_class() ?>>
                    <td class="category">
                       <?php echo plugin_lang_get('management_config_newBug'); ?>
                    </td>
                    <td class="center">
                        <input type='checkbox' name='newBug' value='true' <?php if (plugin_config_get('newBug') == true) echo 'checked'; ?>> <?php echo plugin_lang_get('management_config_impact'); ?>
                        <select name="select_newbug[]" multiple style='height:125px;'>
                            <?php print_enum_string_option_list('severity', plugin_config_get('select_newbug')) ?>;
                        </select> 
                    </td>
                </tr>
                <tr <?php echo helper_alternate_class() ?>>
                    <td class="category">
                       <?php echo plugin_lang_get('management_config_updateBug'); ?>
                    </td>
                    <td class="center">
                        <input type='checkbox' name='updateBug' value='true' <?php if (plugin_config_get('updateBug') == true) echo 'checked'; ?>> <?php echo plugin_lang_get('management_config_impact'); ?>
                        <select name="select_updateBug[]" multiple style='height:125px;'>
                            <?php print_enum_string_option_list('severity', plugin_config_get('select_updateBug')) ?>;
                        </select> 
                    </td>
                </tr>
                <tr <?php echo helper_alternate_class() ?>>
                    <td class="category">
                       <?php echo plugin_lang_get('management_config_addNote'); ?>
                    </td>
                    <td class="center">
                        <input type='checkbox' name='addNote' value='true' <?php if (plugin_config_get('addNote') == true) echo 'checked'; ?>> <?php echo plugin_lang_get('management_config_impact'); ?>
                        <select name="select_addNote[]" multiple style='height:125px;'>
                            <?php print_enum_string_option_list('severity', plugin_config_get('select_addNote')) ?>;
                        </select> 
                    </td>
                </tr>
                <tr>
                    <td class="center" colspan="3">
                        <input type="submit" class="ui-button button" value="<?php echo plugin_lang_get('save'); ?>" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div id="tabs-2">
        <div class='error' style='color:red;'>
            <?php if (isset($_GET['error']))  echo  plugin_lang_get('management_errorForm'); ?>
            <?php if (isset($_GET['errorText'])) echo plugin_lang_get('management_errorSendText'); ?>
        </div>
        <form class="form-tech" action="<?php echo plugin_page('technician_update') ?>" method="post">
            <?php echo form_security_field('plugin_OnCallAlerts_technician_update') ?> 
            <label class="label"><?php echo plugin_lang_get('name'); ?> <br/><input class="input" name="technician_name" value=""/></label>
            <br/>
            <label class="label"><?php echo plugin_lang_get('longPhone'); ?> <br/><input class="input" name="technician_phone" value=""/></label>
            <br/>
            <input class="ui-button button" type="submit" value='<?php echo plugin_lang_get('add'); ?>'>
        </form>
        <table align="center" class="width50" cellspacing="1">
            <tr>
                <td class="form-title">
                    <?php echo plugin_lang_get('technician'); ?>
                </td>
                <td class="form-title">
                    <?php echo plugin_lang_get('phone'); ?>
                </td>
                <td class="form-title">
                    <?php echo plugin_lang_get('action'); ?>
                </td>
            </tr>
            <?php
            
            if ($resTechnician):
                foreach ($resTechnician as $t):
                    ?>
                    <tr <?php echo helper_alternate_class() ?> cellspacing="1" >
                        <td class="category">
                            <?php echo $t->name; ?>
                        </td>
                        <td class="center">
                            <form action='<?php echo plugin_page('technician_phone_update') ?>' method="post">
                            <?php echo form_security_field('plugin_OnCallAlerts_technician_phone_update') ?> 
                            <input type='text' name='phoneUpdate' class='input'size='13' 
                                   value="<?php echo $t->phone; ?>" name='phoneEdit' />  
                            <input type="hidden" name="name" value="<?php echo $t->name; ?>" />
                            <input type="hidden" name="id" value="<?php echo $t->id; ?>" />
                            <input type="image" src="/images/ok.gif" alt="Submit Form" />
                            </form>
                        </td>
                        <td class="center">
                            <a href='<?php echo plugin_page('technician_delete') . "&id=" . $t->id ?>'><img src='/images/delete.png'></a>
                            <a href='<?php echo plugin_page('sendText_test') . "&id=" . $t->id ?>'><img title='<?php echo plugin_lang_get('management_textsend'); ?>' src='<?php echo plugin_file('sms.png'); ?>'></a>
                        </td>
                    </tr>
    <?php endforeach;
endif; ?>
        </table>
    </div>
    <div id="tabs-3">
        <div class='error' style='color:red;'>
            <?php if (isset($_GET['error'])) echo  plugin_lang_get('management_errorForm'); ?>
        </div>
        <h3><?php echo plugin_lang_get('management_oncall_title'); ?></h3>
        <form class="form-astreinte" action="<?php echo plugin_page('callon_update') ?>" method="post">
            <?php echo form_security_field('plugin_OnCallAlerts_callon_update') ?> 
            <label class="label" for="from"><?php echo plugin_lang_get('from'); ?></label>
            <input class="input" type="text" id="from" name="startDate" >
            <label class="label" for="to"><?php echo plugin_lang_get('to'); ?></label>
            <input class="input" type="text" id="to" name="endDate">
            <br>
            <label class="label" for="start"><?php echo plugin_lang_get('fromH'); ?></label>
            <input class="input" id='start' type="time" name="startTime" placeholder="00:00">
            <label class="label" for="end"><?php echo plugin_lang_get('toH'); ?></label>
            <input class="input" id='end' type="time" name="endTime" placeholder="00:00">
            <br>
            <label class="label"><?php echo plugin_lang_get('for'); ?></label>
            <select class="ui-selectmenu-button ui-selectmenu-button-closed" style="width:100px;" name='technicianID'>
                <?php
                if (!empty($resTechnician)):
                    foreach ($resTechnician as $t):
                        ?>
                        <option value='<?php echo $t->id; ?>'><?php echo $t->name; ?></option>
                <?php endforeach;
                endif; ?>
            </select>
            <br>
            <label class="label-note" from='note'><?php echo plugin_lang_get('note_colon'); ?></label>
            <textarea name='note' cols="60" rows="5"></textarea>
            <input class="btn-ajout ui-button button" type="submit" value='Ajouter'>
        </form>
        <div class="export" style='float: right;'>
        <img src='/plugins/OnCallAlerts/files/csv.png'>
        <h3><?php echo plugin_lang_get('management_oncall_exportCsv'); ?> </h3>
        <form action="<?php echo plugin_page('export_callon') ?>" method="post">
            <label class="label" for="from"><?php echo plugin_lang_get('from'); ?></label>
            <?php $d = new \DateTime(); ?>
            <input class="input" type="text" id="fromExport" name="startDateExport" value='<?php echo $d->format('d/m/Y'); ?>'>
            <label class="label" for="to"><?php echo plugin_lang_get('to'); ?></label>
            <input class="input" type="text" id="toExport" name="endDateExport"  value='<?php echo $d->format('d/m/Y'); ?>'>
            <br>
            <input class="ui-button button" type='submit' name='export' value="<?php echo plugin_lang_get('export'); ?>" />
            <input class="ui-button button" type='submit' name='print' value="<?php echo plugin_lang_get('print'); ?>" />
        </form>
        </div>

        <table  id='oncallTable' cellspacing="1" style='width:100%;'>
            <thead>
                <tr class="category">
                    <td class="form-title">
                        <?php echo plugin_lang_get('technician'); ?>
                    </td>
                    <td class="form-title">
                        <?php echo plugin_lang_get('phone'); ?>
                    </td>
                    <td class="form-title">
                        <?php echo plugin_lang_get('startDate'); ?>
                    </td>
                    <td class="form-title">
                        <?php echo plugin_lang_get('endDate'); ?>
                    </td>
                    <td class="form-title">
                        <?php echo plugin_lang_get('note'); ?>
                    </td>
                    <td class="form-title">
                        <?php echo plugin_lang_get('action'); ?>
                    </td>
                </tr>
            </thead>
            <tbody>
                <?php
                $resOnCall = $onCall->fetchall();
                if ($resOnCall):
                    foreach ($resOnCall as $oc):
                        $dStart = new \DateTime($oc->start_date);
                        $dEnd = new \DateTime($oc->end_date);
                        $t = $technician->getById($oc->technician_id);
                        
                        if ($dEnd < new \DateTime())
                        {
                            $color = 'style="background-color:#eaeaea !important;"';
                            $colorNote = 'style="background-color:#eaeaea !important; cursor: pointer;"';
                        }
                        else
                        {
                            $color = '';
                            $colorNote = 'style="cursor: pointer;"';
                        }
                        ?>
                        <tr cellspacing="1" >
                            <td class="category">
                                <?php echo $t->name; ?>
                            </td>
                            <td>
                                <?php echo $t->phone; ?>
                            </td>
                            <td>
                                <?php echo $dStart->format('d/m/Y H:i'); ?> 
                            </td>
                            <td>
                                <?php if ($oc->start_date != $oc->end_date):
                                    ?>
                                    <?php echo $dEnd->format('d/m/Y H:i'); ?>
                                <?php endif; ?>
                            </td>
                            <td class='tdNote' id='<?php echo $oc->id;?>'>
                                <?php
                                $noteBR = nl2br($oc->note);
                                if (strlen(nl2br($oc->note)) < 30 || !stripos($noteBR, '<br />')) echo $noteBR;
                                else {
                                    $note = explode('<br />',$noteBR);
                                    echo substr($note[0],0,30) . '...';
                                }
                                ?> 
                                <div class='noteDialog' id='noteDialog-<?php echo $oc->id;?>' title='Note :'>
                                    <?php echo $noteBR; ?>
                                </div>
                            </td>
                            <td>
                                <a title='Supprimer' href='<?php echo plugin_page('callon_delete') . "&id=" . $oc->id; ?>'><img src='/images/delete.png'></a>
                                <a href='<?php echo plugin_page('sendText_oncall') . "&idoncall=" . $oc->id ."&idTech=". $t->id ?>'><img title="<?php echo plugin_lang_get('management_textsendRecall'); ?>" src='/plugins/OnCallAlerts/files/sms.png'></a>
                            </td>
                        </tr>
                    <?php endforeach;
                endif;
                ?>
            </tbody>
        </table>
    </div>
    <div id="tabs-4">
        <div class='error' style='color:red;'>
            <?php if (isset($_GET['error'])) echo  plugin_lang_get('management_errorForm');  ?>
        </div>
        <h3><?php echo plugin_lang_get('management_planning_title'); ?></h3>
        <form class="form_planning" action="<?php echo plugin_page('planing_update') ?>" method="post">
            <?php echo form_security_field('plugin_OnCallAlerts_planing_update') ?>             
            <h3 class="title"><?php echo plugin_lang_get('management_planning_dayList'); ?></h3>
            <label class="label" for='monday'><?php echo plugin_lang_get('monday'); ?></label><input class="input" type="checkbox" id="monday" name="monday">
            <label class="label" for='tuesday'><?php echo plugin_lang_get('tuesday'); ?></label><input class="input" type="checkbox" id="tuesday" name="tuesday">
            <label class="label" for='wednesday'><?php echo plugin_lang_get('wednesday'); ?></label><input class="input" type="checkbox" id="wednesday" name="wednesday">
            <label class="label" for='thursday'><?php echo plugin_lang_get('thursday'); ?></label><input class="input" type="checkbox" id="thursday" name="thursday">
            <label class="label" for='friday'><?php echo plugin_lang_get('friday'); ?></label><input class="input" type="checkbox" id="friday" name="friday">
            <label class="label" for='saturday'><?php echo plugin_lang_get('saturday'); ?></label><input class="input" type="checkbox" id="saturday" name="saturday">
            <label class="label" for='sunday'><?php echo plugin_lang_get('sunday'); ?></label><input class="input" type="checkbox" id="sunday" name="sunday">
            <br>
            <label class="label" for="start"><?php echo plugin_lang_get('fromH'); ?> </label>
            <input id='start' type="time" name="startTime" placeholder="00:00">
            <label class="label" for="end"><?php echo plugin_lang_get('toH'); ?> </label>
            <input  id='end' type="time" name="endTime" placeholder="00:00">
            <br>
            <label class="label"><?php echo plugin_lang_get('for'); ?></label>
            <select class="ui-selectmenu-button ui-selectmenu-button-closed" style="width:100px;" name='technicianID'>
               <?php
                if (!empty($resTechnician)):
                    foreach ($resTechnician as $t):
                        ?>
                        <option value='<?php echo $t->id; ?>'><?php echo $t->name; ?></option>
                <?php endforeach;
                endif; ?>
            </select>
            <br>
            <label class="label-note" from='note'><?php echo plugin_lang_get('note_colon'); ?></label>
            <textarea name='note' cols="60" rows="5"></textarea>
            <input class="btn-ajout ui-button button" type="submit" value='Ajouter'>
        </form>
        <div class="export_csv" style='float: right;'>
        <a href='<?php echo plugin_page('export_planing');?>'><?php echo plugin_lang_get('management_oncall_exportCsv'); ?> <img src='/plugins/OnCallAlerts/files/csv.png'></a>
        </div>
        
        <table  id='planingTable' cellspacing="1" style='width:100%'>
            <thead>
                <tr class="row-category">
                    <td>
                        <?php echo plugin_lang_get('technician'); ?>
                    </td>
                    <td>
                        <?php echo plugin_lang_get('phone'); ?>
                    </td>
                    <td>
                        <?php echo plugin_lang_get('monday'); ?>
                    </td>
                    <td>
                        <?php echo plugin_lang_get('tuesday'); ?>
                    </td>
                    <td>
                        <?php echo plugin_lang_get('wednesday'); ?>
                    </td>
                    <td>
                        <?php echo plugin_lang_get('thursday'); ?>
                    </td>
                    <td>
                        <?php echo plugin_lang_get('friday'); ?>
                    </td>
                    <td>
                        <?php echo plugin_lang_get('saturday'); ?>
                    </td>
                    <td>
                        <?php echo plugin_lang_get('sunday'); ?>
                    </td>
                    <td>
                        <?php echo plugin_lang_get('startTime'); ?>
                    </td>
                    <td>
                        <?php echo plugin_lang_get('endTime'); ?>
                    </td>
                    <td>
                        <?php echo plugin_lang_get('note'); ?>
                    </td>
                    <td>
                        <?php echo plugin_lang_get('action'); ?>
                    </td>
                </tr>
            </thead>
            <tbody>
                <?php
                $resPlaning = $planing->fetchall();
                if ($resPlaning):
                    foreach ($resPlaning as $p):
                         $t = $technician->getById($p->technician_id);
                        ?>
                        <tr cellspacing="1" >
                            <td class="category">
                                <?php echo $t->name; ?>
                            </td>
                            <td>
                                <?php echo $t->phone; ?>
                            </td>
                            <td <?php if($p->monday):?>style="background-color:#d0f6b5;color:#d0f6b5;"<?php else: ?>style="background-color:#ffbfbf;color:#ffbfbf;"<?php endif;?>>
                                <?php echo $p->monday;?>
                            </td>
                            <td <?php if($p->tuesday):?>style="background-color:#d0f6b5;color:#d0f6b5;"<?php else: ?>style="background-color:#ffbfbf;color:#ffbfbf;"<?php endif;?>>
                                <?php echo $p->tuesday;?>
                            </td>
                            <td <?php if($p->wednesday):?>style="background-color:#d0f6b5;color:#d0f6b5;"<?php else: ?>style="background-color:#ffbfbf;color:#ffbfbf;"<?php endif;?>>
                                <?php echo $p->wednesday;?>
                            </td>
                            <td <?php if($p->thursday):?>style="background-color:#d0f6b5;color:#d0f6b5;"<?php else: ?>style="background-color:#ffbfbf;color:#ffbfbf;"<?php endif;?>>
                                <?php echo $p->thursday;?>
                            </td>
                            <td <?php if($p->friday):?>style="background-color:#d0f6b5;color:#d0f6b5;"<?php else: ?>style="background-color:#ffbfbf;color:#ffbfbf;"<?php endif;?>>
                                <?php echo $p->friday;?>
                            </td>
                            <td <?php if($p->saturday):?>style="background-color:#d0f6b5;color:#d0f6b5;"<?php else: ?>style="background-color:#ffbfbf;color:#ffbfbf;"<?php endif;?>>
                                <?php echo $p->saturday;?>
                            </td>
                            <td <?php if($p->sunday):?>style="background-color:#d0f6b5;color:#d0f6b5;"<?php else: ?>style="background-color:#ffbfbf;color:#ffbfbf;"<?php endif;?>>
                                <?php echo $p->sunday;?>
                            </td>
                            <td>
                                <?php echo substr($p->start_time,0,5); ?> 
                            </td>
                            <td>
                                <?php echo substr($p->end_time,0,5); ?> 
                            </td>
                            <td style="cursor: pointer;" class='tdNoteplaning' id='<?php echo $p->id;?>'>
                                <?php
                                $noteBR = nl2br($p->note);
                                if (strlen(nl2br($p->note)) < 30 || !stripos($noteBR, '<br />')) echo $noteBR;
                                else {
                                    $note = explode('<br />',$noteBR);
                                    echo substr($note[0],0,30) . '...';
                                }
                                ?> 
                                <div class='noteDialogplaning' id='noteDialogplaning-<?php echo $p->id;?>' title='Note :'>
                                    <?php echo $noteBR; ?>
                                </div>
                            </td>
                            <td >
                                <a title='Supprimer' href='<?php echo plugin_page('planing_delete') . "&id=" . $p->id; ?>'><img src='/images/delete.png'></a>
                            </td>
                        </tr>
                    <?php endforeach;
                endif;
                ?>
            </tbody>
        </table>
    </div>
    <div id="tabs-5"> 
        <xmp id='logContent' class='announcement'>
<?php echo plugin_lang_get('management_instructionLog'); ?>
        </xmp>
        <div id='listLog' style='width:430px;'>
            <ul>
<?php foreach ($listeLog as $l): ?>
                <li style='cursor: pointer;'><span class='logFile'><?php echo $l; ?></span>
                    <a href="<?php echo plugin_page('downloadLog') . "&log=" . $l; ?>">(<img src="/plugins/OnCallAlerts/files/drive-download.png"> <?php echo plugin_lang_get('download'); ?> )</a>
                </li>
<?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<?php
html_page_bottom();
