function trigerData_b(str){


  //ftianxei ena XMLHttpRequest object
  var xmlhttp = new XMLHttpRequest();
  
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("txtHint").innerHTML = this.responseText;
    }
  };
  
  var contentData = [];
  //console.log(str);
  $.ajax({
    async: true,
    global: false,
    type: "POST",
    //dataType:'json', // add json datatype to get json
    data: {name:str},
    url: "erwtima3b_getdata.php",
    success: function(data){
      


      contentData = JSON.parse(data);
      stale = contentData[1];
      fresh = contentData[2];
      //console.log(JSON.stringify(contentData[0]));
      //console.log(JSON.stringify(contentData[1]));
      //console.log(contentData[1].length);

      dataset = [];
      //console.log(contentData[0].length);
      for(var i = 0; i<contentData[0].length; i++){
        temp_array = new Array(2).fill(0);
        for(var j = 0; j<stale.length; j++){
          //console.log(contentData[0][i]["contentType"],contentData[1][j]["content_type"]);
          if(contentData[0][i]["contentType"] === stale[j]["content_type"]){
            temp_array[0] += parseFloat(stale[j]["Score"]);
          }
        }
        for(var j = 0; j<fresh.length; j++){
          //console.log(contentData[0][i]["contentType"],contentData[1][j]["content_type"]);
          if(contentData[0][i]["contentType"] === fresh[j]["content_type"]){
            temp_array[1] += parseFloat(fresh[j]["Score"]);
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

  var ctx = document.getElementById('Erwtima3b').getContext('2d');
  window.myChart = new Chart(ctx,{
    type: 'bar',
  
    data: {
      labels: ["max-stale","min-fresh"],
      datasets: dataList
    },
    options: {
      backgroundColor: chartColors,
      responsive: true,
      title: {
        display: true,
        text: 'Percentage of HTTP request directives'
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
            labelString: 'Directives'
          }
        }],
        yAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Percentage'
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
  /*myChart.data.labels.textalign = 'left';*/
}

/*telikh parenthesi*/ 
};