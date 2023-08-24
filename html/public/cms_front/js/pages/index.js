//Project:	sInfiniO- Responsive Bootstrap 4 Template
//Primary use:	InfiniO - Responsive Bootstrap 4 Template

//======
function Jknob() {
    $('.knob').knob({
        draw: function() {           
        }
    });
}

$('#sparkline16').sparkline([155, 161, 170, 205, 198, 245, 279, 301, 423], {
    type: 'line',
    width: '100%',
    height: '390',
    chartRangeMax:100,
    resize: true,
    lineColor: '#84b3df',
    fillColor: '#d2e7fb',
    highlightLineColor: 'rgba(0,0,0,.1)',
    highlightSpotColor: 'rgba(0,0,0,.2)',
});

$('#sparkline16').sparkline([4, 5, 7, 5, 10, 12, 22, 32, 41, 32], {
    type: 'line',
    width: '100%',
    height: '290',
    chartRangeMax: 100,
    lineColor: '#8f8ff0',
    fillColor: '#b5b5ea',
    composite: true,
    resize: true,
    highlightLineColor: 'rgba(0,0,0,.1)',
    highlightSpotColor: 'rgba(0,0,0,.2)',
});

//======
$(window).on('scroll',function() {
    $('.card .sparkline').each(function() {
        var imagePos = $(this).offset().top;

        var topOfWindow = $(window).scrollTop();
        if (imagePos < topOfWindow + 400) {
            $(this).addClass("pullUp");
        }
    });
});
//======

/*VectorMap Init*/
$(function() {
	"use strict";
	var mapData = {
        "US": 298,
        "SA": 200,
        "AU": 760,
        "IN": 2000000,
        "GB": 120,
    };
	
	if( $('#world-map-markers').length > 0 ){
		$('#world-map-markers').vectorMap(
		{
			map: 'world_mill_en',
			backgroundColor: 'transparent',
			borderColor: '#fff',
			borderOpacity: 0.25,
			borderWidth: 0,
			color: '#e6e6e6',
			regionStyle : {
            initial : {
                    fill : '#f4f4f4'
                }
            },

			markerStyle: {
			    initial: {
                        r: 5,
                        'fill': '#fff',
                        'fill-opacity':1,
                        'stroke': '#000',
                        'stroke-width' : 1,
                        'stroke-opacity': 0.4
                    },
				},
		   
			markers : [{
				latLng : [21.00, 78.00],
				name : 'INDIA : 350'			  
			  },
			  {
				latLng : [-33.00, 151.00],
				name : 'Australia : 250'				
			  },
			  {
				latLng : [36.77, -119.41],
				name : 'USA : 250'			  
			  },
			  {
				latLng : [55.37, -3.41],
				name : 'UK   : 250'			  
			  },
			  {
				latLng : [25.20, 55.27],
				name : 'UAE : 250'			  
			  }],

			series: {
				regions: [{
					values: {
						"US": '#49c5b6',
						"SA": '#667add',
						"AU": '#50d38a',
						"IN": '#60bafd',
						"GB": '#ff758e',
					},
					attribute: 'fill'
				}]
			},
			hoverOpacity: null,
			normalizeFunction: 'linear',
			zoomOnScroll: false,
			scaleColors: ['#000000', '#000000'],
			selectedColor: '#000000',
			selectedRegions: [],
			enableZoom: false,
			hoverColor: '#fff',
		});
	}

	if( $('#india').length > 0 ){
	$('#india').vectorMap({
			map : 'in_mill',
			backgroundColor : 'transparent',
			regionStyle : {
				initial : {
					fill : '#f4f4f4'
				}
			}
		});
	}	

	if( $('#usa').length > 0 ){
		$('#usa').vectorMap({
			map : 'us_aea_en',
			backgroundColor : 'transparent',
			regionStyle : {
				initial : {
					fill : '#f4f4f4'
				}
			}
		});
	}        
		   
	if( $('#australia').length > 0 ){        
		$('#australia').vectorMap({
			map : 'au_mill',
			backgroundColor : 'transparent',
			regionStyle : {
				initial : {
					fill : '#f4f4f4'
				}
			}
		});
	}	
	 
	if( $('#uk').length > 0 ){ 
		$('#uk').vectorMap({
			map : 'uk_mill_en',
			backgroundColor : 'transparent',
			regionStyle : {
				initial : {
					fill : '#f4f4f4'
				}
			}
		});
	}	
});

