+ADw-?php
	//Including admin scripts
	add+AF8-action( 'admin+AF8-enqueue+AF8-scripts', 'sbvcgmap+AF8-admin+AF8-enqueue+AF8-scripts')+ADs-
	function sbvcgmap+AF8-admin+AF8-enqueue+AF8-scripts() +AHs-
		
		wp+AF8-enqueue+AF8-style('sbvcgmap-admin-style', SBVCGMAP+AF8-PLUGIN+AF8-DIR.'/assets/css/admin.css')+ADs-
		
		wp+AF8-enqueue+AF8-script('jquery')+ADs-
		
		wp+AF8-register+AF8-script('sbvcgmap-googlemapapi', (is+AF8-ssl() ? 'https://' :'http://').'maps.googleapis.com/maps/api/js?v+AD0-3.exp+ACY-sensor+AD0-false+ACY-libraries+AD0-places,weather,panoramio', array(), '', true)+ADs-
		wp+AF8-enqueue+AF8-script('sbvcgmap-googlemapapi')+ADs-
		
		wp+AF8-register+AF8-script('sbvcgmap-admin', SBVCGMAP+AF8-PLUGIN+AF8-DIR.'/assets/js/admin.js', array(), SBVCGMAP+AF8-PLUGIN+AF8-VERSION, true)+ADs-
		wp+AF8-enqueue+AF8-script('sbvcgmap-admin')+ADs-
	+AH0-
	
	
	if(+ACE-class+AF8-exists('sbvcgmap+AF8-google+AF8-map')) +AHs-
		class sbvcgmap+AF8-google+AF8-map +AHs-
			function +AF8AXw-construct() +AHs-
				add+AF8-action('admin+AF8-init',array(+ACQ-this,'sbvcgmap+AF8-init'))+ADs-
				//add+AF8-shortcode('sbvcgmap','sbvcgmap+AF8-shortcode')+ADs-
			+AH0-
			
			function sbvcgmap+AF8-init()+AHs-
		
				if(function+AF8-exists('vc+AF8-map'))+AHs-
	
					vc+AF8-map( array(		
						+ACI-name+ACI- 						+AD0APg- +AF8AXw-(SBVCGMAP+AF8-PLUGIN+AF8-NAME,'js+AF8-composer'),		
						+ACI-base+ACI- 						+AD0APg- 'sbvcgmap',		
						+ACI-icon+ACI- 						+AD0APg- 'smartowl+AF8-shortcode',
						+ACI-category+ACI- 					+AD0APg- +AF8AXw-('groffer','js+AF8-composer'),
						+ACI-content+AF8-element+ACI-			+AD0APg- true,
						+ACI-show+AF8-settings+AF8-on+AF8-create+ACI- 	+AD0APg- true,
						+ACI-as+AF8-parent+ACI- 				+AD0APg- array ('only' +AD0APg- 'sbvcgmap+AF8-marker'),
						+ACI-description+ACI- 				+AD0APg- +AF8AXw-( 'Add Google Map','js+AF8-composer' ),
						+ACI-js+AF8-view+ACI- 						+AD0APg- 'VcColumnView',
						+ACI-params+ACI- 					+AD0APg- array (
							array (
								'type'			+AD0APg- 'textfield',
								'heading' 		+AD0APg- +AF8AXw-( 'Title', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'sbvcgmap+AF8-title',
								'holder'		+AD0APg- 'div',
								'description' 	+AD0APg- +AF8AXw-( 'Enter map title. This is optional field.', 'js+AF8-composer' )
							),
							array (
								'type'			+AD0APg- 'textfield',
								'heading' 		+AD0APg- +AF8AXw-( 'API Key', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'sbvcgmap+AF8-apikey',
								'description' 	+AD0APg- +AF8AXw-( '+ADw-a target+AD0AIgBf-blank+ACI- href+AD0AIg-https://console.developers.google.com/flows/enableapi?apiid+AD0-maps+AF8-backend,geocoding+AF8-backend,directions+AF8-backend,distance+AF8-matrix+AF8-backend,elevation+AF8-backend+ACY-keyType+AD0-CLIENT+AF8-SIDE+ACY-reusekey+AD0-true+ACIAPg-Click here+ADw-/a+AD4- to generate API key. For more details +ADw-a target+AD0AIgBf-blank+ACI- href+AD0AIg-https://developers.google.com/maps/documentation/javascript/get-api-key+ACIAPg-click here+ADw-/a+AD4-.', 'js+AF8-composer' )
							),
							array(
								'type' 			+AD0APg- 'sbvcgmap+AF8-num',
								'heading' 		+AD0APg- +AF8AXw-( 'Width', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'map+AF8-width',
								'value' 		+AD0APg- 100,
								'min' 			+AD0APg- 0,
								'max' 			+AD0APg- '',
								'suffix' 		+AD0APg- '',
								'step' 			+AD0APg- 1,
								'description' 	+AD0APg- +AF8AXw-( 'Set map width.', 'js+AF8-composer' )
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Width Type', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'width+AF8-type',
								'description' 	+AD0APg- +AF8AXw-( 'Select map width type.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-get+AF8-size+AF8-types(),
								'std' 			+AD0APg- '+ACU-'
							),
							array(
								'type' 			+AD0APg- 'sbvcgmap+AF8-num',
								'heading' 		+AD0APg- +AF8AXw-( 'Height', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'map+AF8-height',
								'value' 		+AD0APg- 400,
								'min' 			+AD0APg- 0,
								'max' 			+AD0APg- '',
								'suffix' 		+AD0APg- '',
								'step' 			+AD0APg- 1,
								'description' 	+AD0APg- +AF8AXw-( 'Set map height.', 'js+AF8-composer' )
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Height Type', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'height+AF8-type',
								'description' 	+AD0APg- +AF8AXw-( 'Select map height type.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-get+AF8-size+AF8-types()
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Map Styles', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'mapstyles',
								'description' 	+AD0APg- +AF8AXw-( 'Select map style. +ADw-a href+AD0AIg-http://plugins.sbthemes.com/responsive-google-maps-vc-addon/map-styles/all-styles/+ACI- target+AD0AIgBf-blank+ACIAPg-Click Here+ADw-/a+AD4- to view all styles.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-get+AF8-map+AF8-styles()
							),
							array (
								'type' 			+AD0APg- 'sbvcgmap+AF8-autocomplete',
								'heading' 		+AD0APg- +AF8AXw-( 'Center of Map', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'centerpoint',
								'description' 	+AD0APg- +AF8AXw-( 'Optional+ACE- Address or (latitude, longitude). Leave blank to auto center.', 'js+AF8-composer' ),
								'group' 		+AD0APg- +AF8AXw-('Zoom', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Zoom Level', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'zoom',
								'description' 	+AD0APg- +AF8AXw-( 'Set zoom level. You can set any numerical value from +ADw-strong+AD4-1 to 21+ADw-/strong+AD4-.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-get+AF8-zoom+AF8-levels(),
								'std'			+AD0APg-	14,
								'group' 		+AD0APg- +AF8AXw-('Zoom', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Enable Zoom Control', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'zoomcontrol',
								'description' 	+AD0APg- +AF8AXw-( 'Displays a slider (for large maps) or small +ACIAIg- buttons', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-toggle+AF8-button(),
								'group' 		+AD0APg- +AF8AXw-('Zoom', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Zoom Control Position', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'zoomcontrol+AF8-position',
								'description' 	+AD0APg- +AF8AXw-( 'Select zoom control position.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-get+AF8-positions(),
								'std'			+AD0APg-	'TOP+AF8-LEFT',
								'group' 		+AD0APg- +AF8AXw-('Zoom', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Zoom Style', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'zoomcontrolstyle',
								'description' 	+AD0APg- +AF8AXw-( 'Select zoom control style.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-get+AF8-zoom+AF8-styles(),
								'std'			+AD0APg-	'DEFAULT',
								'group' 		+AD0APg- +AF8AXw-('Zoom', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Draggable', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'draggable',
								'description' 	+AD0APg- +AF8AXw-( 'If yes, map will be draggable by mouse.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-toggle+AF8-button(),
								'std'			+AD0APg-	'yes',
								'group' 		+AD0APg- +AF8AXw-('Zoom', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Scroll Wheel', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'scrollwheel',
								'description' 	+AD0APg- +AF8AXw-( 'If yes, zoom level will be changed by mouse scroll wheel.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-toggle+AF8-button(),
								'std'			+AD0APg-	'yes',
								'group' 		+AD0APg- +AF8AXw-('Zoom', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Pan Control', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'pancontrol',
								'description' 	+AD0APg- +AF8AXw-( 'Displays buttons for panning the map.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-toggle+AF8-button(),
								'std'			+AD0APg-	'yes',
								'group' 		+AD0APg- +AF8AXw-('Controls', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Pan Control Position', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'pancontrol+AF8-position',
								'description' 	+AD0APg- +AF8AXw-( 'Pan control buttons position.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-get+AF8-positions(),
								'std'			+AD0APg-	'TOP+AF8-LEFT',
								'group' 		+AD0APg- +AF8AXw-('Controls', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Scale Control', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'scalecontrol',
								'description' 	+AD0APg- +AF8AXw-( 'Displays a map scale element.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-toggle+AF8-button(),
								'std'			+AD0APg-	'yes',
								'group' 		+AD0APg- +AF8AXw-('Controls', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Street View Control', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'streetviewcontrol',
								'description' 	+AD0APg- +AF8AXw-( 'Displays a Pegman icon to enable street view.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-toggle+AF8-button(),
								'std'			+AD0APg-	'yes',
								'group' 		+AD0APg- +AF8AXw-('Controls', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Street View Control Position', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'streetviewcontrol+AF8-position',
								'description' 	+AD0APg- +AF8AXw-( 'Pegman icon (street view control) position.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-get+AF8-positions(),
								'std'			+AD0APg-	'TOP+AF8-LEFT',
								'group' 		+AD0APg- +AF8AXw-('Controls', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Map Type Control', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'maptypecontrol',
								'description' 	+AD0APg- +AF8AXw-( 'Displays a map type control.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-toggle+AF8-button(),
								'std'			+AD0APg-	'yes',
								'group' 		+AD0APg- +AF8AXw-('Controls', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Map Type Control Position', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'maptypecontrol+AF8-position',
								'description' 	+AD0APg- +AF8AXw-( 'Map type control position.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-get+AF8-positions(),
								'std'			+AD0APg-	'TOP+AF8-RIGHT',
								'group' 		+AD0APg- +AF8AXw-('Controls', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Map Type', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'maptype',
								'description' 	+AD0APg- +AF8AXw-( 'Toggle between map types. For +ADw-strong+AD4-STREETVIEW+ADw-/strong+AD4-, you must have to set +ADw-strong+AD4-Center of Map+ADw-/strong+AD4- field in Zoom Settings Tab.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-get+AF8-map+AF8-types(),
								'std'			+AD0APg-	'ROADMAP',
								'group' 		+AD0APg- +AF8AXw-('Controls', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Enable Street View Toggle Button', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'panoramatogglebutton',
								'description' 	+AD0APg- +AF8AXw-( 'Select yes to enable street view toggle button. To enable this feature, you must have to set +ADw-strong+AD4-Center of Map+ADw-/strong+AD4- field in Zoom Settings Tab.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-toggle+AF8-button(),
								'std'			+AD0APg-	'no',
								'group' 		+AD0APg- +AF8AXw-('Controls', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Map Type Control Style', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'maptypecontrolstyle',
								'description' 	+AD0APg- +AF8AXw-( 'Choose map type control style.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-get+AF8-map+AF8-type+AF8-styles(),
								'std'			+AD0APg-	'DEFAULT',
								'group' 		+AD0APg- +AF8AXw-('Controls', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Overview Map Control Visible', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'overviewmapcontrolvisible',
								'description' 	+AD0APg- +AF8AXw-( 'Displays a thumbnail overview map reflecting the current map viewport.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-toggle+AF8-button(),
								'std'			+AD0APg-	'no',
								'group' 		+AD0APg- +AF8AXw-('Controls', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Overview Map Control', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'overviewmapcontrol',
								'description' 	+AD0APg- +AF8AXw-( 'Displays a toggle button to show / hide overview map control (bottom right).', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-toggle+AF8-button(),
								'std'			+AD0APg-	'yes',
								'group' 		+AD0APg- +AF8AXw-('Controls', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Search Type', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'searchtype',
								'description' 	+AD0APg- +AF8AXw-( 'Nearest search query. Select Disabled to turn off this feature. +ADw-a target+AD0AIgBf-blank+ACI- href+AD0AIg-https://developers.google.com/places/supported+AF8-types+ACIAPg-Click Here+ADw-/a+AD4- to see supported search query.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-get+AF8-search+AF8-types(),
								'std'			+AD0APg-	'disabled',
								'group' 		+AD0APg- +AF8AXw-('Nearest Places', 'js+AF8-composer')
							),
							array(
								'type' 			+AD0APg- 'sbvcgmap+AF8-num',
								'heading' 		+AD0APg- +AF8AXw-( 'Search Radius', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'searchradius',
								'value' 		+AD0APg- 500,
								'min' 			+AD0APg- 0,
								'max' 			+AD0APg- 50000,
								'suffix' 		+AD0APg- '',
								'step' 			+AD0APg- 1,
								'description' 	+AD0APg- +AF8AXw-( 'Search area radius in meters. Radius calculates from center of map. Maximum allowed radius is 50000.', 'js+AF8-composer' ),
								'group' 		+AD0APg- +AF8AXw-('Nearest Places', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Icon Animation', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'searchiconanimation',
								'description' 	+AD0APg- +AF8AXw-( 'Seach result icon animation.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-get+AF8-marker+AF8-animations(),
								'std'			+AD0APg-	'NONE',
								'group' 		+AD0APg- +AF8AXw-('Nearest Places', 'js+AF8-composer')
							),
							array (
								'type'			+AD0APg- 'textfield',
								'heading' 		+AD0APg- +AF8AXw-( 'Text for Direction Link', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'searchdirectiontext',
								'description' 	+AD0APg- +AF8AXw-( 'Direction link text for search result marker. Leave blank to hide link.', 'js+AF8-composer' ),
								'value' 		+AD0APg- '',
								'group' 		+AD0APg- +AF8AXw-('Nearest Places', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Weather', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'weather',
								'description' 	+AD0APg- +AF8AXw-( 'Weather layer add weather forecasts to map.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-toggle+AF8-button(),
								'std'			+AD0APg-	'no',
								'group' 		+AD0APg- +AF8AXw-('Map Layers', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Traffic', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'traffic',
								'description' 	+AD0APg- +AF8AXw-( 'Traffic layer add real-time traffic information to map.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-toggle+AF8-button(),
								'std'			+AD0APg-	'no',
								'group' 		+AD0APg- +AF8AXw-('Map Layers', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Transit', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'transit',
								'description' 	+AD0APg- +AF8AXw-( 'Transit layer add public transit network of a city to map.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-toggle+AF8-button(),
								'std'			+AD0APg-	'no',
								'group' 		+AD0APg- +AF8AXw-('Map Layers', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Bicycle', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'bicycle',
								'description' 	+AD0APg- +AF8AXw-( 'Bicycle layer add bicycle information (bike routes) to map.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-toggle+AF8-button(),
								'std'			+AD0APg-	'no',
								'group' 		+AD0APg- +AF8AXw-('Map Layers', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Panoramio', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'panoramio',
								'description' 	+AD0APg- +AF8AXw-( 'Panoramio layer add community contributed photos to map.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-toggle+AF8-button(),
								'std'			+AD0APg-	'no',
								'group' 		+AD0APg- +AF8AXw-('Map Layers', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Reload on resize', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'reloadonresize',
								'description' 	+AD0APg- +AF8AXw-( 'If yes, map will be reload on screen resize.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-toggle+AF8-button(),
								'std'			+AD0APg-	'no',
								'group' 		+AD0APg- +AF8AXw-('Miscellaneous', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Language', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'language',
								'description' 	+AD0APg- +AF8AXw-( 'Localize your map.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-get+AF8-map+AF8-languages(),
								'std'			+AD0APg-	'en',
								'group' 		+AD0APg- +AF8AXw-('Miscellaneous', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Clustering', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'clustering',
								'description' 	+AD0APg- +AF8AXw-( 'Enable this if you have 100ths of markers. It will improve speed for too many markers.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-toggle+AF8-button(),
								'std'			+AD0APg-	'no',
								'group' 		+AD0APg- +AF8AXw-('Miscellaneous', 'js+AF8-composer')
							),
							array(
								'type' 			+AD0APg- 'checkbox',
								'value'			+AD0APg- array(+AF8AXw-( 'Enable Full Screen Button', 'js+AF8-composer' ) +AD0APg- 'yes'),
								'heading' 		+AD0APg- +AF8AXw-( '', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'fullscreenbutton',
								'description' 	+AD0APg- +AF8AXw-( 'Check this box to enable full screen toggle button in your map.', 'js+AF8-composer' ),
								'group' 		+AD0APg- +AF8AXw-('Miscellaneous', 'js+AF8-composer')
							),
							array(
								'type' 			+AD0APg- 'textfield',
								'heading' 		+AD0APg- +AF8AXw-( 'Expand Button Text', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'expandmaptext',
								'value'			+AD0APg- 'Expand Map',
								'description' 	+AD0APg- +AF8AXw-( 'Add text for expand button.', 'js+AF8-composer' ),
								'dependency'	+AD0APg- array('element' +AD0APg- 'fullscreenbutton', 'value' +AD0APg- 'yes'),
								'group' 		+AD0APg- +AF8AXw-('Miscellaneous', 'js+AF8-composer')
							),
							array(
								'type' 			+AD0APg- 'textfield',
								'heading' 		+AD0APg- +AF8AXw-( 'Collapse Button Text', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'collapsemaptext',
								'value'			+AD0APg- 'Collapse Map',
								'description' 	+AD0APg- +AF8AXw-( 'Add text for collapse button.', 'js+AF8-composer' ),
								'dependency'	+AD0APg- array('element' +AD0APg- 'fullscreenbutton', 'value' +AD0APg- 'yes'),
								'group' 		+AD0APg- +AF8AXw-('Miscellaneous', 'js+AF8-composer')
							)
							
						)
					) )+ADs-
					
					vc+AF8-map( array(		
						+ACI-name+ACI- 			+AD0APg- +AF8AXw-('Map Marker','js+AF8-composer'),		
						+ACI-base+ACI- 			+AD0APg- 'sbvcgmap+AF8-marker',		
						+ACI-icon+ACI- 			+AD0APg- SBVCGMAP+AF8-PLUGIN+AF8-DIR.'/assets/img/marker-icon.png',
						+ACI-category+ACI- 		+AD0APg- +AF8AXw-('Google Map','js+AF8-composer'),
						+ACI-as+AF8-child+ACI- 		+AD0APg- array('only' +AD0APg- 'sbvcgmap'),
						+ACI-description+ACI- 	+AD0APg- +AF8AXw-( 'Add New Marker','js+AF8-composer' ),
						+ACI-params+ACI- 		+AD0APg- array(
							array(
								'type' 			+AD0APg- 'sbvcgmap+AF8-autocomplete',
								'heading' 		+AD0APg- +AF8AXw-( 'Address or (Latitude, Longitude)', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'address',
								'holder'		+AD0APg- 'div',
								'description' 	+AD0APg- +AF8AXw-( 'Add location address or (Latitude, Longitude). For Latitude and Longitude use comma for separator.', 'js+AF8-composer' )
							),
							array(
								'type' 			+AD0APg- 'textfield',
								'heading' 		+AD0APg- +AF8AXw-( 'Text for Directions Link', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'textfordirectionslink',
								'value'			+AD0APg- '',
								'description' 	+AD0APg- +AF8AXw-( 'Text for Directions Link. Leave blank to remove direction link from info window.', 'js+AF8-composer' )
							),
							array(
								'type' 			+AD0APg- 'attach+AF8-image',
								'heading' 		+AD0APg- +AF8AXw-( 'Marker Icon', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'icon',
								'description' 	+AD0APg- +AF8AXw-( 'Upload marker pin icon. You can find stunning icons here: +ADw-a target+AD0AIgBf-blank+ACI- href+AD0AIg-http://medialoot.com/item/free-vector-map-location-pins+ACIAPg-Download Icons+ADw-/a+AD4-', 'js+AF8-composer' )
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Icon Animation', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'animation',
								'description' 	+AD0APg- +AF8AXw-( 'Select marker animation.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-get+AF8-marker+AF8-animations(),
								'std'			+AD0APg-	'NONE'
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Default Open Info Window', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'infowindow',
								'description' 	+AD0APg- +AF8AXw-( 'If yes, marker info window will be opened by default..', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-toggle+AF8-button(),
								'std'			+AD0APg-	'no'
							),
							array(
								'type' 			+AD0APg- 'textarea+AF8-html',
								'heading' 		+AD0APg- +AF8AXw-( 'Marker Content', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'content',
								'description' 	+AD0APg- +AF8AXw-( 'Use any Text or HTML for marker content. You can also use shortcodes. Some JS based shortcodes should not work.', 'js+AF8-composer' )
							),
							array(
								'type' 			+AD0APg- 'checkbox',
								'value'			+AD0APg- array(+AF8AXw-( 'Enable custom styles', 'js+AF8-composer' ) +AD0APg- 'yes'),
								'heading' 		+AD0APg- +AF8AXw-( '', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'customstyles',
								'description' 	+AD0APg- +AF8AXw-( 'Check this box to enable custom styles.', 'js+AF8-composer' ),
								'group' 		+AD0APg- +AF8AXw-('Custom Styles', 'js+AF8-composer')
							),
							array(
								'type' 			+AD0APg- 'colorpicker',
								'heading' 		+AD0APg- +AF8AXw-( 'Select Background Color', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'csbgcolor',
								'description' 	+AD0APg- +AF8AXw-( 'Background color for info window.', 'js+AF8-composer' ),
								'dependency'	+AD0APg- array('element' +AD0APg- 'customstyles', 'value' +AD0APg- 'yes'),
								'group' 		+AD0APg- +AF8AXw-('Custom Styles', 'js+AF8-composer')
							),
							array(
								'type' 			+AD0APg- 'attach+AF8-image',
								'heading' 		+AD0APg- +AF8AXw-( 'Select Background Image', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'csbgimage',
								'description' 	+AD0APg- +AF8AXw-( 'Background image for info window.', 'js+AF8-composer' ),
								'dependency'	+AD0APg- array('element' +AD0APg- 'customstyles', 'value' +AD0APg- 'yes'),
								'group' 		+AD0APg- +AF8AXw-('Custom Styles', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Background Image Repeat', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'csbgrepeat',
								'description' 	+AD0APg- +AF8AXw-( 'Set yes to repeat info window background image.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-toggle+AF8-button(),
								'std'			+AD0APg-	'no',
								'dependency'	+AD0APg- array('element' +AD0APg- 'customstyles', 'value' +AD0APg- 'yes'),
								'group' 		+AD0APg- +AF8AXw-('Custom Styles', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'sbvcgmap+AF8-num',
								'heading' 		+AD0APg- +AF8AXw-( 'Width', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'cswidth',
								'value' 		+AD0APg- 300,
								'min' 			+AD0APg- 0,
								'max' 			+AD0APg- '',
								'suffix' 		+AD0APg- '',
								'step' 			+AD0APg- 1,
								'description' 	+AD0APg- +AF8AXw-( 'Info window width in pixels.', 'js+AF8-composer' ),
								'dependency'	+AD0APg- array('element' +AD0APg- 'customstyles', 'value' +AD0APg- 'yes'),
								'group' 		+AD0APg- +AF8AXw-('Custom Styles', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'sbvcgmap+AF8-num',
								'heading' 		+AD0APg- +AF8AXw-( 'Padding', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'cspadding',
								'value' 		+AD0APg- 20,
								'min' 			+AD0APg- 0,
								'max' 			+AD0APg- '',
								'suffix' 		+AD0APg- '',
								'step' 			+AD0APg- 1,
								'description' 	+AD0APg- +AF8AXw-( 'Info window padding in pixels.', 'js+AF8-composer' ),
								'dependency'	+AD0APg- array('element' +AD0APg- 'customstyles', 'value' +AD0APg- 'yes'),
								'group' 		+AD0APg- +AF8AXw-('Custom Styles', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'sbvcgmap+AF8-num',
								'heading' 		+AD0APg- +AF8AXw-( 'Border Radius', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'csborderradius',
								'value' 		+AD0APg- 0,
								'min' 			+AD0APg- 0,
								'max' 			+AD0APg- '',
								'suffix' 		+AD0APg- '',
								'step' 			+AD0APg- 1,
								'description' 	+AD0APg- +AF8AXw-( 'Info window border radius in pixels.', 'js+AF8-composer' ),
								'dependency'	+AD0APg- array('element' +AD0APg- 'customstyles', 'value' +AD0APg- 'yes'),
								'group' 		+AD0APg- +AF8AXw-('Custom Styles', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'sbvcgmap+AF8-num',
								'heading' 		+AD0APg- +AF8AXw-( 'Border Width', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'csborderwidth',
								'value' 		+AD0APg- 0,
								'min' 			+AD0APg- 0,
								'max' 			+AD0APg- '',
								'suffix' 		+AD0APg- '',
								'step' 			+AD0APg- 1,
								'description' 	+AD0APg- +AF8AXw-( 'Info window border width in pixels.', 'js+AF8-composer' ),
								'dependency'	+AD0APg- array('element' +AD0APg- 'customstyles', 'value' +AD0APg- 'yes'),
								'group' 		+AD0APg- +AF8AXw-('Custom Styles', 'js+AF8-composer')
							),
							array (
								'type' 			+AD0APg- 'dropdown',
								'heading' 		+AD0APg- +AF8AXw-( 'Border Style', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'csborderstyle',
								'description' 	+AD0APg- +AF8AXw-( 'Select border style.', 'js+AF8-composer' ),
								'value' 		+AD0APg- sbvcgmap+AF8-get+AF8-border+AF8-types(),
								'std' 			+AD0APg- 'solid',
								'dependency'	+AD0APg- array('element' +AD0APg- 'customstyles', 'value' +AD0APg- 'yes'),
								'group' 		+AD0APg- +AF8AXw-('Custom Styles', 'js+AF8-composer')
							),
							array(
								'type' 			+AD0APg- 'colorpicker',
								'heading' 		+AD0APg- +AF8AXw-( 'Select Border Color', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'csbordercolor',
								'description' 	+AD0APg- +AF8AXw-( 'Info window border color.', 'js+AF8-composer' ),
								'dependency'	+AD0APg- array('element' +AD0APg- 'customstyles', 'value' +AD0APg- 'yes'),
								'group' 		+AD0APg- +AF8AXw-('Custom Styles', 'js+AF8-composer')
							),
							array(
								'type' 			+AD0APg- 'textfield',
								'heading' 		+AD0APg- +AF8AXw-( 'Box Shadow', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'csboxshadow',
								'value'			+AD0APg- '',
								'description' 	+AD0APg- +AF8AXw-( 'Use valid css box shadow property value here. +ADw-strong+AD4-Eg. 0 0 1px +ACM-000+ADw-/strong+AD4-', 'js+AF8-composer' ),
								'dependency'	+AD0APg- array('element' +AD0APg- 'customstyles', 'value' +AD0APg- 'yes'),
								'group' 		+AD0APg- +AF8AXw-('Custom Styles', 'js+AF8-composer')
							),
							array(
								'type' 			+AD0APg- 'attach+AF8-image',
								'heading' 		+AD0APg- +AF8AXw-( 'Select Close Image Icon', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'cscloseimage',
								'description' 	+AD0APg- +AF8AXw-( 'Custom close image icon for info window.', 'js+AF8-composer' ),
								'dependency'	+AD0APg- array('element' +AD0APg- 'customstyles', 'value' +AD0APg- 'yes'),
								'group' 		+AD0APg- +AF8AXw-('Custom Styles', 'js+AF8-composer')
							),
							array(
								'type' 			+AD0APg- 'sbvcgmap+AF8-num',
								'heading' 		+AD0APg- +AF8AXw-( 'Info Window Horizontal(X) Position (Advance Option)', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'csxposition',
								'value' 		+AD0APg- '',
								'min' 			+AD0APg- '',
								'max' 			+AD0APg- '',
								'suffix' 		+AD0APg- '',
								'step' 			+AD0APg- 1,
								'description' 	+AD0APg- +AF8AXw-( 'Leave empty for default. Info window horizontal(X) position in pixels. Use any positive or negative integer value.', 'js+AF8-composer' ),
								'dependency'	+AD0APg- array('element' +AD0APg- 'customstyles', 'value' +AD0APg- 'yes'),
								'group' 		+AD0APg- +AF8AXw-('Custom Styles', 'js+AF8-composer')
							),
							array(
								'type' 			+AD0APg- 'sbvcgmap+AF8-num',
								'heading' 		+AD0APg- +AF8AXw-( 'Info Window Vertical(Y) Position (Advance Option)', 'js+AF8-composer' ),
								'param+AF8-name' 	+AD0APg- 'csyposition',
								'value' 		+AD0APg- '',
								'min' 			+AD0APg- '',
								'max' 			+AD0APg- '',
								'suffix' 		+AD0APg- '',
								'step' 			+AD0APg- 1,
								'description' 	+AD0APg- +AF8AXw-( 'Leave empty for default. Info window vertical(Y) position in pixels. Use any positive or negative integer value.', 'js+AF8-composer' ),
								'dependency'	+AD0APg- array('element' +AD0APg- 'customstyles', 'value' +AD0APg- 'yes'),
								'group' 		+AD0APg- +AF8AXw-('Custom Styles', 'js+AF8-composer')
							)
						)
					))+ADs-
				+AH0-
			+AH0-
			
		+AH0-
		
		
		//instantiate the class
		+ACQ-sbvcgmap+AF8-google+AF8-map +AD0- new sbvcgmap+AF8-google+AF8-map+ADs-
	+AH0-
	
	add+AF8-action('admin+AF8-init','sbvcgmap+AF8-extends')+ADs-
	function sbvcgmap+AF8-extends()+AHs-
		if (class+AF8-exists('WPBakeryShortCodesContainer')) +AHs-
			class WPBakeryShortCode+AF8-Sbvcgmap extends WPBakeryShortCodesContainer +AHs-
			+AH0-
		+AH0-
	+AH0-