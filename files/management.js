jQuery(document).ready(function () {

    jQuery("#tabsOnCallAlerts").tabs();

    jQuery( ".noteDialog" ).dialog({
      autoOpen: false
    });
    
    jQuery( ".noteDialogplaning" ).dialog({
      autoOpen: false
    });
    
    jQuery( ".tdNoteplaning" ).on( "click", function() {
        jQuery( ".noteDialogplaning" ).dialog("close");
        id = jQuery(this).attr('id'); 
        jQuery("#noteDialogplaning-"+id).dialog( "open" );
    });
    
    jQuery( ".tdNote" ).on( "click", function() {
        console.log('ici');
        jQuery( ".noteDialog" ).dialog("close");
        id = jQuery(this).attr('id'); 
        jQuery("#noteDialog-"+id).dialog( "open" );
    }); 

    jQuery('.logFile').click(function () {
        jQuery.ajax({
            type: "GET",
            url: "/plugins/OnCallAlerts/logs/" + jQuery(this).text(),
            error: function (msg) {
                // message en cas d'erreur : 
                jQuery('#logContent').text("Erreur: " + msg);
            },
            success: function (data) {
                // affiche le contenu du fichier dans le conteneur dédié :
                console.log(data);
                jQuery('#logContent').text(data);
            }
        });
    });

    var dateFormat = "dd/mm/yy",
            from = jQuery("#from")
            .datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                dateFormat: "dd/mm/yy"
            })
            .on("change", function () {
                to.datepicker("option", "minDate", getDate(this));
            }),
            to = jQuery("#to").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        dateFormat: "dd/mm/yy"
    })
            .on("change", function () {
                from.datepicker("option", "maxDate", getDate(this));
            });

    var dateFormat = "dd/mm/yy",
            from = jQuery("#fromExport")
            .datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                dateFormat: "dd/mm/yy"
            })
            .on("change", function () {
                to.datepicker("option", "minDate", getDate(this));
            }),
            to = jQuery("#toExport").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        dateFormat: "dd/mm/yy"
    })
            .on("change", function () {
                from.datepicker("option", "maxDate", getDate(this));
            });

    function getDate(element) {
        var date;
        try {
            date = jQuery.datepicker.parseDate(dateFormat, element.value);
        } catch (error) {
            date = null;
        }

        return date;
    }
    
    jQuery.fn.dataTable.moment( 'DD/MM/YYYY HH:mm' );

    jQuery('#oncallTable').DataTable({
         "order": [[ 2, "asc" ]]
    });
    
    jQuery('#planingTable').DataTable({
         "order": [[ 2, "asc" ]]
    });
});


