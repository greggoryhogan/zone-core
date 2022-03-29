(function($) {
	$(document).ready(function() {
        $('#parklocation').val('');
        let availableLocations = $.parseJSON(site_js.available_locations);
        $('#parklocation').autocomplete({
            source: availableLocations,
            search: function( event, ui ) {
                //console.log(ui);
            },
            select: function(event, ui) {
                //console.log(ui.item);
                event.preventDefault();
                //set text for input
                $('#parklocation').val(ui.item.label);
                //set redirect 
                let url = site_js.siteurl + '/location/' + ui.item.value;
                window.location.href = url;
            }
        });
    });
})(jQuery); // Fully reference jQuery after this point.