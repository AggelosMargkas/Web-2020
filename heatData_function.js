
		let mymap = L.map("mapid");
		let osmUrl = "https://tile.openstreetmap.org/{z}/{x}/{y}.png";
		let osmAttrib ='Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
		let osm = new L.TileLayer(osmUrl, { attribution: osmAttrib });
		mymap.addLayer(osm);
		mymap.setView([38.246242, 21.7350847],5);







//**************************************** */



function parededomena(){

var xmlhttp = new XMLHttpRequest();



xmlhttp.open("GET","heatData.php",true);
xmlhttp.onload = function(){

    
	xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("txtHint").innerHTML = this.responseText;
        }
      };
	  console.log("asdvasdv");
	  
    var phpVar = this.response;
    jsvar = JSON.parse(phpVar);
    console.log(jsvar);

    xmlhttp.send();
	}



}













//*************************************************** */





		let testData2	 = {
		  max: 8,
		  data: [
					{lat: 38.246242, lng: 21.735085},
					{lat: 38.323343, lng: 21.865082},
					{lat: 38.34381, lng: 21.57074},
					{lat: 38.108628, lng: 21.502075},
					{lat: 38.123034, lng: 21.917725},
					{lat: 48.8582, lng: 2.3387},
					{lat: 48.8582, lng: 2.3387},
					{lat: 48.8582, lng: 2.3387},
					{lat: 48.8582, lng: 2.3387},
					{lat: 48.8582, lng: 2.3387},
					{lat: 48.8582, lng: 2.3387},
					{lat: 48.8582, lng: 2.3387},
					{lat: 48.8582, lng: 2.3387},
					{lat: 48.8582, lng: 2.3387},					
					{lat: 48.8582, lng: 2.3387}
					]};
		
/*
		$(document).ready(function() {
			$("heatmap").submit(function(){
				e.preventDefault();
				$.ajax({
                type: "GET",
                url: "heatData.php",
                dataType: 'JSON',
                data: {
                    datefilter: $("#datefilter").val()
                },
                success: function (data) {
                        drawheatmap(data[0]);
                        drawheatmap(data[1]);
                        //drawpiechart(data[1]);
                        //drawdaytable(data[2]);
                        //drawhourtable(data[3]);
                	}

            	})

			})
		})

		function drawheatmap(data) {
	        let myArray = [];
	        let cfg = {
	            // radius should be small ONLY if scaleRadius is true (or small radius is intended)
	            // if scaleRadius is false it will be the constant radius used in pixels
	            "radius": 40,
	            "maxOpacity": 0.8,
	            // scales the radius based on map zoom
	            "scaleRadius": false,
	            // if set to false the heatmap uses the global maximum for colorization
	            // if activated: uses the data maximum within the current map boundaries
	            //   (there will always be a red spot with useLocalExtrema true)
	            "useLocalExtrema": false,
	            // which field name in your data represents the latitude - default "lat"
	            latField: 'lat',
	            // which field name in your data represents the longitude - default "lng"
	            lngField: 'lng',
	            // which field name in your data represents the data value - default "value"
	        };

	        $.each(data, function (i, object) {
	            myArray.push({"lat": object.lat, "lng": object.lng })
	        });
	        var testData = {
	            max: 100,
	            data: myArray
	        };

	        let heatmapLayer = new HeatmapOverlay(cfg);

	        mymap.addLayer(heatmapLayer);
	        heatmapLayer.setData(testData);
    	}*/

        
		let cfg = {
			"radius": 40,
			"maxOpacity": 0.8,
			
			"scaleRadius": false,
			
			"useLocalExtrema": false,
		   
			latField: 'lat',
			
			lngField: 'lng',
		  };

	/*	let testData = (function () {
		let testData = null;
		$.ajax({
		    'async': true,
		    'global': false,
		    'url': 'heatData.php',
		    'dataType': "json",
		    'success': function (data) {
		        testData = data;
		        console.log(testData);

		    }
		});
		return testData;
		
		//console.log(testData);
		})();  
        
*/

		let heatmapLayer =  new HeatmapOverlay(cfg);

		mymap.addLayer(heatmapLayer);
		heatmapLayer.setData(testData2);
