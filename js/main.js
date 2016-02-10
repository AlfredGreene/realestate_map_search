/**
 * Created by Juan Camilo on 01/02/2016.
 */
$( document ).ready(function() {

    var map = new google.maps.Map(document.getElementById("map"), {
       // center: new google.maps.LatLng(47.6145, -122.3418),
        zoom: 13,
        mapTypeId: 'roadmap'
    });

    window.gmarkers = [];

    window.ready=false;
    var map_timeout = window.setTimeout(function(){  window.ready=true; }, 2000);

    map.addListener('dragend', function()
    {
        getproperties(map);
    });

    map.addListener('zoom_changed', function()
    {
        getproperties(map);
    });


    var markers =  JSON.parse(decodeURIComponent($('#property-data').val()));
    //console.log(markers);
    paintMarkers(map,markers,true);

    var geocoder = new google.maps.Geocoder();
    $('form#search-form').submit(function(event){
        event.preventDefault();
        var address=$('input#search-input').val();
        geocodeAddress(address,geocoder, map);
    });

    window.addEventListener("popstate", function(e) {
        location.reload();
    });

    //sort list
    $('#sort-list a').click(function(event){
        event.preventDefault();
        var selText = $(this).text();
        $(this).parents('.dropdown').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
        $('input#sort').val($(this).data('rel'));
        getproperties(map);
    });

    //filter list
    $('.filter-dropdown a').click(function(event){
        event.preventDefault();
        var selText = $(this).text();
        var filter=$(this).parents('ul.filter-dropdown').data('rel');

        if(filter=='price')
        {
            $('input#price_min').val('');
            $('input#price_max').val('');
            $('#price-min,#price-max').val('');
        }

        $(this).parents('.btn-group').find('.dropdown-toggle').html(selText+' '+filter.capitalizeFirst()+' <span class="caret"></span>');
        $('input#'+filter).val($(this).data('rel'));


        getproperties(map);
    });

    //price dropdown

    $('#price-min,#price-max').change(function()
    {
        checkBigger();

        var min = $('.filter-dropdown #price-min').val();
        var max = $('.filter-dropdown #price-max').val();

        if(min=='' && max =='')
        {
            var text ='Any Price'
            $('input#price_min').val('');
            $('input#price_max').val('');
        }
        else
        {


            if(min!='')
            {
                $('input#price_min').val(min);
                var min_text='$'+Number(min).format(0);
            }
            else
            {
                $('input#price_min').val(min);
                var min_text='Any';
            }



            if(max!='')
            {
                $('input#price_max').val(max);
                var max_text='$'+Number(max).format(0);
            }
            else
            {
                $('input#price_min').val(min);
                var max_text='Any';
            }

            var text =min_text + ' - ' + max_text
        }


        $(this).parents('.btn-group').find('.dropdown-toggle').html( text + ' <span class="caret"></span>');

        getproperties(map);


    });
   /* $('.filter-dropdown #price-max').change(function(){$(this).trigger('keyup') });*/

    setDropdowns();


});

function checkBigger()
{


    if($('#price-max').val()!='' && $('#price-min').val()!='' && Number($('#price-max').val()) < Number($('#price-min').val()))
    {
        //console.log( 'swap');
        var max=$('#price-max').val();
        $('#price-max').val($('#price-min').val());
        $('#price-min').val(max);
    }
}

function geocodeAddress(address,geocoder, map) {

    geocoder.geocode({'address': address}, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });
            getproperties(map);
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}

function getproperties(map)
{
//call is in progress
    if(typeof  window.searchCAll != 'undefined')
    {
        window.searchCAll.abort();
    }

    if(window.ready)
    {
        var query_string=buildUQueryString(map);

        history.pushState('','',query_string);
        //make ajax call
        var bounds=map.getBounds();
        var nw=bounds.getNorthEast().toUrlValue();
        var se=bounds.getSouthWest().toUrlValue();
        var sort=$('#sort').val();
        var beds=$('#beds').val();
        var baths=$('#baths').val();
        var type=$('#type').val();
        var price_max=$('#price_max').val();
        var price_min=$('#price_min').val();

        window.searchCAll=$.post( "library/ajax.php", {action:'getProperties', nw: nw, se: se, sort:sort,beds:beds,baths:baths,type:type,price_max:price_max, price_min:price_min},null,'json')
            .done(function( data ) {

                $('#properties-results').html(data.html);
                $('.property-count').text(data.count);

                  paintMarkers(map,data.markers,false);

            },'json');
    }

    window.ready=false;
    window.clearTimeout(map_timeout);
    var map_timeout = window.setTimeout(function(){  window.ready=true; }, 2000);
}

function setDropdowns()
{
    $('div.filter-inputs input').each(function( index ) {

        var name=$(this).attr('id');
        var val=$(this).val();
        if(val&&val!='')
        {
            //console.log($('ul[data-rel="'+name+'"] a[data-rel="'+val+'"]'));
            $('ul[data-rel="'+name+'"] a[data-rel="'+val+'"]').trigger('click');
        }

    });

    //specific for prices
    if($('input#price_min').val!='')
    {
        $('#price-min').val($('input#price_min').val());
    }


    if($('input#price_max').val!='')
    {
        $('#price-max').val($('input#price_max').val());
    }

    $('#price-max').trigger('change');
}

//build URL based on map bounds and filters
function buildUQueryString(map)
{
    //console.log();
    var bounds=map.getBounds();
    var nw=bounds.getNorthEast().toUrlValue();
    var se=bounds.getSouthWest().toUrlValue();

    var sort=$('#sort').val();
    var beds=$('#beds').val();
    var baths=$('#baths').val();
    var type=$('#type').val();
    var price_max=$('#price_max').val();
    var price_min=$('#price_min').val();

    var params = {  nw: nw, se: se, sort:sort,beds:beds,baths:baths,type:type,price_max:price_max, price_min:price_min };

    //clean object
    for(var k in params)
    { if(!params[k]) delete params[k];}

    var qs = '?'+jQuery.param( params );

    //
   // var qs = '?nw='+nw+'&se='+se+'&sort' ;

    return qs;
}

function paintMarkers(map,markers,fitbounds)
{
    if(typeof  fitbounds == 'undefined')
    {
        fitbounds=true;
    }

    clearMarkers();

    var infoWindow = new google.maps.InfoWindow;
    var latlngbounds = new google.maps.LatLngBounds( );
    $.each(markers, function(i, item)
    {
        var name = item.name.replace( /\+/g, ' ' );
        var address = item.address.replace( /\+/g, ' ' );
        var price = Number(item.price.replace( /\+/g, ' ')).format(2);

        var type = item.type;
        var point = new google.maps.LatLng(
            parseFloat(item.lat),
            parseFloat(item.lng));
        var html = '<span class="property_info"><b>' + name + "</b> <br/>" + address+"</span>"
                    +"<br><span>$"+price+"</span>";
        //var icon = customIcons[type] || {};
        var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png'
        });

        gmarkers[item.id] = marker;

        bindInfoWindow(marker, map, infoWindow, html);

            latlngbounds.extend( point );

    });

    //add hover functionality to new markers
    $('.row.property-result-row').hover(function()
    {
        var index=$(this).data('rel');
        // console.log(markers[index]);
        google.maps.event.trigger(gmarkers[index], 'click');
    });

    //console.log(gmarkers);
    if(fitbounds)
    {
        map.fitBounds( latlngbounds );

    }
}

function clearMarkers()
{
   // console.log(gmarkers);
    $.each(gmarkers, function(i, item){
       if(typeof item != 'undefined')
       {
           item.setMap(null);
       }

    });

    gmarkers={};
}

function bindInfoWindow(marker, map, infoWindow, html) {
    google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
    });
}

Number.prototype.format = function(n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};

String.prototype.capitalizeFirst = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}