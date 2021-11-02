//ΜΕ ΤΙΝ ΙΔΙΑ ΛΟΓΙΚΙ ΜΕ ΤΟ ΩΙΕςΣΤΑΤΘΣ ΓΙΑ ΚΑΤΗΕ ΕΠΙΛΟΓΙ ΑΝΟΙΓΟΘΜΕ ΕΝΑ ΑΞΑΧ ΠΕΡΝΟΘΜΕ ΤΑ ΔΕΔΟΜΕΝΑ ΚΑΙ ΤΑ ΕΠΕΞΕΡΓΑΖΟΜΑΣΤΕ
function trigerData(str) {

  var myChart;


  //elegxei an exei ginei epilogi 
  if (str == "") {
    document.getElementById("txtHint").innerHTML = "";
    return;
  } 

  //ftianxei ena XMLHttpRequest object
  else {
    var xmlhttp = new XMLHttpRequest();

  
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
    };


      if(str == "1"){

        
			  $.ajax({
				  'async': true,
		    	'global': false,
			  	'type': "POST",
				  'url': "ReturnTime_server1_2.php",
				  'dataType': "json",
				  'success': function(data) {


            if (myChart) myChart.destroy();

            //Pairnw tous xronous me tis wres gia kathe contentType
            contentData = data[0];
            console.log(contentData);

            //Pairnw ta contentType pou yparxoun gia na ftiaksw ta labels dynamika
            contentType = data[1];
            console.log(contentType);

            datasetCT = [];


            //Gia kathe content Type
            for(j=0; j < contentType.length; j++){

              //ftiaxtete ena keno array 24h gia kathe ena
              arxiko_array = new Array(24).fill(0);

               //elsegxoume opou uparxei kai an uparxei pernoume to mx kai thn wra
               for(var i = 0; i < contentData.length; i ++) {
                 if(contentData[i].content_type === contentType[j].content_type) {
                    console.log("Pianw " + contentType[j].content_type + " Stin thesi " +i);
                    arxiko_array[contentData[i].h] = contentData[i].MX;

                    
                }
              }
              
              console.log(arxiko_array);
              var temp_dataset=getDataset(contentType[j].content_type, arxiko_array, j);
              datasetCT.push(temp_dataset);

            }

            console.log(datasetCT);
            canvasDailyKw(datasetCT, 'ΑΝΑΛΥΣΗ ΧΡΟΝΩΝ ΜΕ CONTENT-TYPES', 'ΩΡΕΣ', 'Μ. ΧΡΟΝΟΙ') 
        }

        });


      

       
      }

      
      else if(str == "2"){


      
       
        $.ajax({
				  'async': true,
		    	'global': false,
			  	'type': "POST",
				  'url': "ReturnTime_server2.php",
				  'dataType': "json",
				  'success': function(data) { 

            dayData = data;
            console.log(dayData);
            Meres = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            datasetMeres = [];

            arxiko_array = new Array(24).fill(0);


            for(j=0; j < Meres.length; j++){

              arxiko_array = new Array(24).fill(0);

               for(var i = 0; i < dayData.length; i ++) {
                 if(dayData[i].d === Meres[j]) {
                    console.log("Pianw " +Meres[j] + " Stin thesi " +i);
                    arxiko_array[dayData[i].h] = dayData[i].MX;

                    }
              }
              
              console.log(arxiko_array);
              var temp_dataset=getDataset(Meres[j], arxiko_array, j);
              datasetMeres.push(temp_dataset);

            }

            console.log(datasetMeres);
            canvasDailyKw(datasetMeres, 'ΑΝΑΛΥΣΗ ΧΡΟΝΩΝ ΜΕ ΜΕΡΕΣ', 'ΩΡΕΣ', 'Μ. ΧΡΟΝΟΙ') 


          }
        });
      
      }

      else if(str == "3"){
       
        $.ajax({
				  'async': true,
		    	'global': false,
			  	'type': "POST",
				  'url': "ReturnTime_server3.php",
				  'dataType': "json",
				  'success': function(data) {

            dayData = data;
            console.log(dayData);
            Methods = ['GET', 'POST', 'HEAD', 'OPTIONS', 'PUT', 'DELETE', 'CONNECT', 'TRACE', 'PATCH'];
            datasetMeres = [];

            arxiko_array = new Array(24).fill(0);


            for(j=0; j < Methods.length; j++){

              arxiko_array = new Array(24).fill(0);

               for(var i = 0; i < dayData.length; i ++) {
                 if(dayData[i].meth === Methods[j]) {
                    console.log("Pianw " + Methods[j] + " Stin thesi " +i);
                    arxiko_array[dayData[i].h] = dayData[i].MX;

                }
              }
              
              console.log(arxiko_array);
              var temp_dataset=getDataset(Methods[j], arxiko_array, j);
              datasetMeres.push(temp_dataset);

            }

            console.log(datasetMeres);
            canvasDailyKw(datasetMeres, 'ΑΝΑΛΥΣΗ ΧΡΟΝΩΝ ΜΕ ΜΕΘΔΟΥΣ', 'ΩΡΕΣ', 'Μ. ΧΡΟΝΟΙ') 

            

          }

        });
      }

      else if(str == "4"){

        
			  $.ajax({
				  'async': true,
		    	'global': false,
			  	'type': "POST",
				  'url': "ReturnTime_server4.php",
				  'dataType': "json",
				  'success': function(data) {


            //Pairnw tous xronous me tis wres gia kathe contentType
            ispData = data[0];
            console.log(ispData);

            //Pairnw ta contentType pou yparxoun gia na ftiaksw ta labels dynamika
            ispType = data[1];
            console.log(ispType);

            datasetISP = [];



            for(j=0; j < ispType.length; j++){

              arxiko_array = new Array(24).fill(0);


               for(var i = 0; i < ispData.length; i ++) {
                 if(ispData[i].isp === ispType[j].isp) {
                    console.log("Pianw " + ispType[j].isp + " Stin thesi " +i);
                    arxiko_array[ispData[i].h] = ispData[i].MX;

                    
                }
              }
              
              console.log(arxiko_array);
              var temp_dataset=getDataset(ispType[j].isp, arxiko_array, j);
              datasetISP.push(temp_dataset);

            }

            console.log(datasetISP);
            canvasDailyKw(datasetISP, 'ΑΝΑΛΥΣΗ ΧΡΟΝΩΝ ΜΕ ΠΑΡΟΧΟΥΣ', 'ΩΡΕΣ', 'Μ. ΧΡΟΝΟΙ') 

        }

        });

      }


    }
  }



var myChart;

function getjustHoursOfDay() {

	var hours=[];

	for (var i = 0; i < 23; i++) {
	
	var _time;
	if (i<10) {
		_time="0"+i+":00";
	}else {
		_time=i+":00";
	}
		
		hours.push(_time);
	}

	var lastOfDay="23:59";

	hours.push(lastOfDay);
	return hours;
}



chartColors = {
  red: 'rgb(255, 99, 132)',
  orange: 'rgb(255, 159, 64)',
  yellow: 'rgb(255, 205, 86)',
  green: 'rgb(75, 192, 192)',
  blue: 'rgb(54, 162, 235)',
  purple: 'rgb(153, 102, 255)',
  grey: 'rgb(231,233,237)',
  Jagger: 'rgb(52, 15, 99)',
  gold: 'rgb(229, 196, 14)'

}

function getDataset(_name,_data,index) {
	var _dataset={};
	_dataset.label=_name;
	_dataset.fill=false;
    _dataset.data=_data;

	switch(index){
		case 0:
 		_dataset.backgroundColor=chartColors.red;
      	_dataset.borderColor=chartColors.red;
		break;
		case 1:
		_dataset.backgroundColor=chartColors.blue;
      	_dataset.borderColor=chartColors.blue;
		break;
		case 2:
		_dataset.backgroundColor=chartColors.orange;
      	_dataset.borderColor=chartColors.orange;
		break;
		case 3:
		_dataset.backgroundColor=chartColors.yellow;
      	_dataset.borderColor=chartColors.yellow;
		break;
		case 4:
		_dataset.backgroundColor=chartColors.purple;
      	_dataset.borderColor=chartColors.purple;
		break;
		case 5:
		_dataset.backgroundColor=chartColors.green;
      	_dataset.borderColor=chartColors.green;
		break;
		case 6:
		_dataset.backgroundColor=chartColors.grey;
      	_dataset.borderColor=chartColors.grey;
		break;
    case 7:
		_dataset.backgroundColor=chartColors.Jagger;
      	_dataset.borderColor=chartColors.Jagger;
		break;
    case 8:
		_dataset.backgroundColor=chartColors.gold;
      	_dataset.borderColor=chartColors.gold;
		break;

	}
return _dataset;

}






/******************************** **/
function canvasDailyKw(dataList, title, labelX, labelY) {
            

  var hourOfDay = getjustHoursOfDay();
  if (myChart) myChart.destroy();

  var ctx = document.getElementById('Erwtima2').getContext('2d');
  myChart = new Chart(ctx,{


    type: 'bar',
  
    data: {
      labels: hourOfDay,
      datasets: dataList
    },
    options: {
      backgroundColor: chartColors,
      responsive: true,
      title: {
        display: true,
        text: title
      },
      tooltips: {
        mode: 'label',
      },
      hover: {
        mode: 'nearest',
        intersect: true
      },
      scales: {
        xAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: labelX
          }
        }],
        yAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: labelY
          }
        }]
      }
    },
    plugins:{
      id: 'custom_canvas_background_color',
      beforeDraw: (myChart) => {
        const ctx = myChart.canvas.getContext('2d');
        ctx.save();
        ctx.globalCompositeOperation = 'destination-over';
        ctx.fillStyle = 'white';
        ctx.fillRect(0, 0, myChart.width, myChart.height);
        ctx.restore();
        }
    }
  });


    
  }