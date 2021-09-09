
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
                      'url': "headerProcess_ttl.php",
                      'dataType': "json",
                      'success': function(data) {
    
    
                if (myChart) myChart.destroy();
    
                //Pairnw tous xronous me tis wres gia kathe contentType
                dataTTL = data;
                console.log(dataTTL);
    

                
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
              // if (myChart) myChart.destroy();
    
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
                canvasDailyKw(datasetMeres);
    
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
              //  if (myChart) myChart.destroy();
    
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
                canvasDailyKw(datasetMeres);
    
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
    function canvasDailyKw(dataList) {
                
    
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
            text: 'Daily Kw Object'
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
                labelString: 'ΩΡΕΣ'
              }
            }],
            yAxes: [{
              display: true,
              scaleLabel: {
                display: true,
                labelString: 'MXA'
              }
            }]
          }
        }
      } );
    

      }