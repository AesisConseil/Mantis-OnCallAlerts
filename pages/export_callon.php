<?php

$onCall = new OnCallAlertsOncall();


$technician = new OnCallAlertsTechnician();
$resTechnician = $technician->fetchall();

$startDate = gpc_get_string('startDateExport');
if(!empty(gpc_get_string('endDateExport'))) $endDate = gpc_get_string('endDateExport');
else $endDate = $startDate;

$format = 'd/m/Y';

$startDateTime = \DateTime::createFromFormat($format, $startDate);
$endDateTime = \DateTime::createFromFormat($format, $endDate);


$resOnCall = $onCall->getByDate($startDateTime->format("Y-m-d"),$endDateTime->format("Y-m-d"));

$aCsv = array();

$date= new \DateTime();

if ($resOnCall)
{
    foreach ($resOnCall as $p)
    {
       $t = $technician->getById($p->technician_id);
       
       $r = array($t->name,$t->phone);
       
       $psDate = new \Datetime($p->start_date);
       $peDate = new \Datetime($p->end_date);
       
       $p->start_date = $psDate->format('d/m/Y H:i');
       $p->end_date = $peDate->format('d/m/Y H:i');
       
       unset($p->id); unset($p->technician_id);
       foreach ($p as $pp) array_push ($r, utf8_decode ($pp));
       
       $aCsv[] = $r;       
    }
    
}
if(isset($_POST['print']))
{
   html_page_top1();
   html_page_top2a();
?>

<link rel="stylesheet" type="text/css" href="<?php echo plugin_file('management.css'); ?>" />

<div class="title_astreinte"><h1><?php echo plugin_lang_get('export_title'); ?></h1>
    <h1><?php echo sprintf(plugin_lang_get('export_h1'), $date->format('d/m/y')); ?></h1>
    <h2><?php echo sprintf(plugin_lang_get('export_h2'), $startDate, $endDate); ?> </h2>
</div>

<br />

<table class="width100" cellspacing="1" cellpadding="2px">
    <thead>
        <tr class="row-category-export">
            <td><?php echo plugin_lang_get('technician'); ?></td>
            <td><?php echo plugin_lang_get('phone'); ?></td>
            <td><?php echo plugin_lang_get('startDate'); ?></td>
            <td><?php echo plugin_lang_get('endDate'); ?></td>
            <td><?php echo plugin_lang_get('note'); ?></td>
        </tr>
    </thead>
    <tbody>
        <?php foreach($aCsv as $c): ?>
        <tr>
            <?php foreach($c as $r): ?>                
                <td><?php echo utf8_encode($r); ?></td>            
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>

    window.onafterprint = function(e){
        jQuery(window).off('mousemove', window.onafterprint);
        window.history.back();
    };

    window.print();

    setTimeout(function(){
        jQuery(window).one('mousemove', window.onafterprint);
    }, 1);

</script>
</body>
</html>
<?php
}
else
{
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=export_astreinte_'.$date->format('d-m-y_H-i').'.csv');

    // create a file pointer connected to the output stream
    $output = fopen('php://output', 'w');

    // output the column headings
    fputcsv($output, array( plugin_lang_get('technician'), 
                            plugin_lang_get('phone') , 
                            plugin_lang_get('startDate'), 
                            plugin_lang_get('endDate'), 
                            plugin_lang_get('note')));

    if($aCsv)
    {
        foreach($aCsv as $csvL)
        {
            fputcsv($output, $csvL);
        }
    }
}
