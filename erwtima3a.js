function trigerData_a(str){

  //ftianxei ena XMLHttpRequest object
  var xmlhttp = new XMLHttpRequest();
  
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("txtHint").innerHTML = this.responseText;
    }
  };
  
  var contentData = [];
  console.log(str);
  $.ajax({
    async: true,
    global: false,
    type: "POST",
    //dataType:'json', // add json datatype to get json
    data: {name:str},
    url: "erwtima3a_getdata.php",
    success: function(data){


      contentData = JSON.parse(data);
      //console.log(JSON.stringify(contentData[0]));
      //console.log(JSON.stringify(contentData[1]));
      //console.log(contentData[1].length);

      for(var i = 0; i < contentData[1].length; i ++){
        if(!contentData[1][i]['cacheControl'] || !contentData[1][i]['cacheControl'].includes('max-age')) {

          //console.log(contentData[1][i]['cacheControl']);
          console.log(date2sec(contentData[1][i]['expires']),date2sec(contentData[1][i]['lastModified']));
          contentData[1][i]['cacheControl'] = date2sec(contentData[1][i]['expires'])-date2sec(contentData[1][i]['lastModified']);
          if(contentData[1][i]['cacheControl'] < 0){
            contentData[1][i]['cacheControl'] = 0;
          }
        }
        else{

          a = (contentData[1][i]['cacheControl'].split(","));
          //console.log(a[0]);


          for(var j = 0; j < a.length; j ++){
            if (a[j].includes('max-age')) {
              contentData[1][i]['cacheControl'] = parseInt(a[j].substring(9, a[j].length));
              if(Number.isNaN(parseInt(a[j].substring(9, a[j].length)))){
                contentData[1][i]['cacheControl'] = 0;
              }          
              //console.log(a[j]);
              //break;
            }
          }
        }

        //console.log(JSON.stringify(contentData[1]));
      }

      min_value = 100000000000000000000;
      max_value = 0;
      for (var i =0; i<contentData[1].length; i++){
        if (contentData[1][i]["cacheControl"] < min_value) {
          min_value = contentData[1][i]["cacheControl"];
        }
        if (contentData[1][i]["cacheControl"] > max_value) {
          max_value = contentData[1][i]["cacheControl"];
        }
      }
      //console.log(contentData[1]);
      bucket_width = (max_value-min_value)/10;
      //console.log(min_value, max_value, bucket_width);
      dataset = [];
      //console.log(contentData[0].length);
      for(var i = 0; i<contentData[0].length; i++){
        temp_array = new Array(10).fill(0);
        for(var j = 0; j<contentData[1].length; j++){
          //console.log(contentData[0][i]["contentType"],contentData[1][j]["content_type"]);
          if(contentData[0][i]["contentType"] === contentData[1][j]["content_type"]){
            //console.log(contentData[1][j]["cacheControl"],val2bucket(contentData[1][j]["cacheControl"], bucket_width));
            //console.log(val2bucket(contentData[1][j]["cacheControl"],bucket_width));
            if(Number.isNaN(contentData[1][j]["cacheControl"])){
              //console.log(contentData[1][j]);
             }
            temp_array[val2bucket(contentData[1][j]["cacheControl"], bucket_width)]+=1;
          }

        }

        var temp_dataset=getDataset(contentData[0][i]["contentType"], temp_array, i);
        dataset.push(temp_dataset);
      }
      //console.log(temp_array);
      canvas(dataset);
    },
    error: function() {
      alert('Not Okay');
    } 
  });


function date2sec(gmt_date){
  //Sat, 02 Jan 2021 12:53:50 GMT
  //console.log(gmt_date);
  temp_date = gmt_date.split(",");
  temp_date = temp_date[1];
  temp_date = temp_date.substring(1, temp_date.length);
  temp_date = temp_date.split(" ");

  temp_day = parseInt(temp_date[0]);
  temp_month = "JanFebMarAprMayJunJulAugSepOctNovDec".indexOf(temp_date[1]) / 3 + 1 ;
  temp_year = parseInt(temp_date[2]);
  temp_hour = temp_date[3].split(":");
  temp_sec = parseInt(temp_hour[2]);
  temp_min = parseInt(temp_hour[1]);
  temp_hour = parseInt(temp_hour[0]);

  //console.log(temp_day,temp_month,temp_year,temp_sec,temp_min,temp_hour);


  seconds = temp_sec + 60*temp_min + 360*temp_hour + 31536000*temp_year + 24*360*temp_day + 30*24*360*(temp_month-1);
  //console.log(seconds);
  return seconds;

}

function val2bucket(x, width){

   var val =  Math.trunc(x/width);
   //console.log(x, width, val);
   if(val === 10){
    val = 9;
   }
   return val;
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


window.myChart = new Chart();


function canvas(dataList) {

  if(window.myChart!= null){
    window.myChart.destroy();
}
  var ctx = document.getElementById('Erwtima3a').getContext('2d'); 
  window.myChart = new Chart(ctx,{
    type: 'bar',
  
    data: {
      labels: [1*bucket_width,2*bucket_width,3*bucket_width,4*bucket_width,5*bucket_width,6*bucket_width,7*bucket_width,8*bucket_width,9*bucket_width,10*bucket_width],
      datasets: dataList
    },
    options: {
      backgroundColor: chartColors,
      responsive: true,
      title: {
        display: true,
        text: 'TTL'
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
          ticks: {
            beginAtZero: true},
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'max-age'
          }
        }],
        yAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Occurences'
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
  //myChart.data.labels.textalign = 'left';
}

/*telikh parenthesi*/ 
};