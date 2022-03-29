(function($) {
	$(document).ready(function() {
        //set search value to null on load to prevent previously select item
        $('#parklocation').val('');
        //custom walker to add categories to jquery autocomplete, source from https://jqueryui.com/autocomplete/#categories
        $.widget( "custom.catcomplete", $.ui.autocomplete, {
            _create: function() {
              this._super();
              this.widget().menu( 'option', 'items', '> :not(.ui-autocomplete-category)' );
            },
            _renderMenu: function( ul, items ) {
                var that = this,
                currentCategory = "";
                $.each( items, function( index, item ) {
                    var li;
                    if ( item.category != currentCategory ) {
                    ul.append('<li class="ui-autocomplete-category">' + item.category + '</li>');
                        currentCategory = item.category;
                    }
                    li = that._renderItemData( ul, item );
                    if ( item.category ) {
                        li.attr( "aria-label", item.category + " : " + item.label );
                    }
                });
            }
        });
        //init custom jquery autocomplete
        $('#parklocation').catcomplete({
            source: $.parseJSON(site_js.available_locations),
            scroll: true,
            minLength: 0,
            search: function( event, ui ) {
                //console.log(ui);
            },
            select: function(event, ui) {
                //prevent default select action
                event.preventDefault();
                //set text for input
                $('#parklocation').val(ui.item.label);
                //set redirect to the desired location
                let url = site_js.siteurl + '/location/' + ui.item.value;
                window.location.href = url;
            }
        });
    });
})(jQuery); // Fully reference jQuery after this point.