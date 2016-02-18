/**
 * Google Map manager - renders map and put markers
 * Address priority - House Number, Street Direction, Street Name, Street Suffix, City, State, Zip, Country
 */
yii.googleMapManager = (function ($) {
    var pub = {
        init: function () {
        },
        // Init function
        initModule: function (options) {
            initOptions(options).done(function () {
                google.maps.event.addDomListener(window, 'load', initializeMap());
            });
        },
        /**
         * Get address and place it on map
         */
        getAddress: function (location, htmlContent, loadMap) {
            var search = location.address;
            pub.geocoder.geocode({'address': search}, function (results, status) {
                var place = results[0];
                pub.drawMarker(place, htmlContent);
                //pub.delay = 300;
                loadMap();
            });
        }
        ,
        updatePosition: function (position) {
            var coordinates = [position];

            coordinates.push(position);

            var path = new google.maps.Polyline({
                path: coordinates,
                geodesic: true,
                strokeColor: '#00AAFF',
                strokeOpacity: 1.0,
                strokeWeight: 0.4
            });
            path.setMap(pub.map);

            return position;
        },

        drawMarker: function (place, htmlContent) {
            var position = pub.updatePosition(place.geometry.location);
            pub.bounds.extend(position);
            var marker = new google.maps.Marker({
                map: pub.map,
                position: position,
            });
            bindInfoWindow(marker, pub.map, pub.infoWindow, htmlContent);
            pub.markerClusterer.addMarker(marker);
            pub.markers.push(marker);
            if (pub.nextAddress == pub.geocodeData.length) {
                pub.map.fitBounds(pub.bounds);
                if (pub.map.getZoom() > 17) {
                    pub.map.setZoom(17);
                }
            }
        }
        ,
    };


    /**
     * Setup googleMapManager properties
     */
    function initOptions(options) {
        var deferred = $.Deferred();
        pub.bounds = new google.maps.LatLngBounds();
        pub.geocoder = new google.maps.Geocoder();
        pub.infoWindow = new google.maps.InfoWindow(pub.infoWindowOptions);
        pub.map = null;
        pub.markerClusterer = null;
        pub.geocodeData = [];
        pub.nextAddress = 0;
        pub.zeroResult = 0;
        pub.markers = [];
        $.extend(true, pub, options);
        deferred.resolve();
        return deferred;
    }


    /**
     * Register listeners
     */
    function registerListeners() {
        for (listener in pub.listeners) {
            if (pub.listeners.hasOwnProperty(listener)) {
                var object = pub.listeners[listener].object;
                var event = pub.listeners[listener].event;
                var handler = pub.listeners[listener].handler;
                google.maps.event.addListener(pub[object], event, handler);
            }
        }
    }

    /**
     * Binds a map marker and infoWindow together on click
     * @param marker
     * @param map
     * @param infoWindow
     * @param html
     */
    function bindInfoWindow(marker, map, infoWindow, html) {
        google.maps.event.addListener(marker, 'click', function () {
            infoWindow.setContent(html);
            infoWindow.open(map, marker);
        });
    }

    function initializeMap() {
        // Create an array of styles.
        var styles = [
            {
                "elementType": "geometry",
                "stylers": [
                    {
                        "hue": "#ff4400"
                    },
                    {
                        "saturation": -68
                    },
                    {
                        "lightness": -4
                    },
                    {
                        "gamma": 0.72
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels.icon"
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry",
                "stylers": [
                    {
                        "hue": "#0077ff"
                    },
                    {
                        "gamma": 3.1
                    }
                ]
            },
            {
                "featureType": "water",
                "stylers": [
                    {
                        "hue": "#00ccff"
                    },
                    {
                        "gamma": 0.44
                    },
                    {
                        "saturation": -33
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "stylers": [
                    {
                        "hue": "#44ff00"
                    },
                    {
                        "saturation": -23
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "hue": "#007fff"
                    },
                    {
                        "gamma": 0.77
                    },
                    {
                        "saturation": 65
                    },
                    {
                        "lightness": 99
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "gamma": 0.11
                    },
                    {
                        "weight": 5.6
                    },
                    {
                        "saturation": 99
                    },
                    {
                        "hue": "#0091ff"
                    },
                    {
                        "lightness": -86
                    }
                ]
            },
            {
                "featureType": "transit.line",
                "elementType": "geometry",
                "stylers": [
                    {
                        "lightness": -48
                    },
                    {
                        "hue": "#ff5e00"
                    },
                    {
                        "gamma": 1.2
                    },
                    {
                        "saturation": -23
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "saturation": -64
                    },
                    {
                        "hue": "#ff9100"
                    },
                    {
                        "lightness": 16
                    },
                    {
                        "gamma": 0.47
                    },
                    {
                        "weight": 2.7
                    }
                ]
            }
        ];

        // Create a new StyledMapType object, passing it the array of styles,
        // as well as the name to be displayed on the map type control.
        var styledMap = new google.maps.StyledMapType(styles,
            {name: "Styled Map"});

        //console.log(styledMap);

        var container = document.getElementById(pub.containerId);
        container.style.width = '100%';
        container.style.height = '100%';
        //container.zoom = 5;

        pub.map = new google.maps.Map(container,
            pub.mapOptions);

        //Associate the styled map with the MapTypeId and set it to display.
        pub.map.mapTypes.set('map_style', styledMap);
        pub.map.setMapTypeId('map_style');

        /*var container = document.getElementById(pub.containerId);
        container.style.width = '100%';
        container.style.height = '100%';

        pub.map = new google.maps.Map(container, pub.mapOptions);*/

        setTimeout(function () {
            pub.markerClusterer = new MarkerClusterer(pub.map, [], {/*gridSize: 50, maxZoom: 1*/});
            registerListeners();
            loadMap();
        }, 1000);
    }

    /**
     * Dynamic call fetchPlaces function with delay
     */
    function loadMap() {
        setTimeout(function () {
            if (pub.nextAddress < pub.geocodeData.length) {
                var location = {
                    country: pub.geocodeData[pub.nextAddress].country,
                    address: pub.geocodeData[pub.nextAddress].address
                };
                var htmlContent = pub.geocodeData[pub.nextAddress].htmlContent;
                pub.getAddress(location, htmlContent, loadMap);
                pub.nextAddress++;
            }
        }, pub.delay);
    }

    return pub;
})
(jQuery);
