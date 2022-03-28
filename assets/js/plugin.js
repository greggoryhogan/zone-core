(function($) {
	$(document).ready(function() {
        let availableLocations = $.parseJSON(site_js.available_locations);
        $('#parklocation').autocomplete({
            source: availableLocations,
            search: function( event, ui ) {
                //console.log(ui);
            },
            select: function(event, ui) {
                //console.log(ui.item);
                event.preventDefault();
                $('#parklocation').val(ui.item.label);
            }
        });
    });
})(jQuery); // Fully reference jQuery after this point.