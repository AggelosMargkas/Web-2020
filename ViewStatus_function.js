

//ORIZOUME POU THA MPEI TO GRAPH
var ctx = document.getElementById('Erwtima1').getContext('2d');


//VARIABLE GIA TO COLORS POU MPOREI NA XREIASTOUN
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

window.myChart = new Chart();

//ENARJI TOU ACTION
function showData(str) {




    //elegxei an exei ginei epilogi 
    if (str == "") {
      document.getElementById("txtHint").innerHTML = "";
      return;
    } 

    //ftianxei ena XMLHttpRequest object
    else {
     // if (myChart) myChart.destroy();

      var xmlhttp = new XMLHttpRequest();

    
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("txtHint").innerHTML = this.responseText;
        }
      };

      //GIA KATHE UPOPERIPTWSI PERNOUME TO NOUME APO TO str
      //ANOIGOUME AJAX PAIRNOUME TA DEDOMENA ASUGXRONA APO THN VASI KAI NA PERNAME ME TON KATALILO TROPO GIA NA DIMIOURGITHEI TO GRAPH


        if(str == "1"){


          $.ajax({
            'async': true,
            'global': false,
            'type': "POST",
            'url': "ViewStatus_server1.php",
            'dataType': "json",
            'success': function(data) {

                        
          if(window.myChart!= null){
            window.myChart.destroy();
        }

            jsvar = data;

             window.myChart = new Chart(ctx, {
                type: 'horizontalBar',

                data: {
                  labels: ['Χρήστες'],
      
                  datasets: [{
                      label: 'Πλήθος χρηστών',
                      backgroundColor: 'rgb(255, 200, 132)',
                      borderColor: 'rgb(255, 99, 132)',
                      data: [jsvar]
                  }]
                },

                options: {
                  legend: {
                    display: false,
                  },
                  title: {
                    display: true,
                    text: 'Πλήθος Χρηστών'
                  },
                  scales: {
                      yAxes: [{
                          ticks: {
                              barPercentage: 0.4,
                              beginAtZero: true
                          }
                      }],
                      xAxes: [{
                        ticks: {
                            barPercentage: 0.4,
                            beginAtZero: true
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

          }});

      

          }

        else if(str == "2"){



  
          $.ajax({
            'async': true,
            'global': false,
            'type': "POST",
            'url': "ViewStatus_server2.php",
            'dataType': "json",
            'success': function(data) {
            


              if(window.myChart!= null){
                window.myChart.destroy();
            }

              jsvar = data;
              console.log(jsvar);



             window.myChart = new Chart(ctx, {
                type: 'bar',

                data: {
                  labels: ['GET', 'POST', 'HEAD', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'],
      
                  datasets: [{
                      label: 'Μέθοδοι Αίτησης',
                      data: [jsvar[0], jsvar[1], jsvar[2], jsvar[3], jsvar[4], jsvar[5], jsvar[6], jsvar[7]],
                      backgroundColor: [ 'rgb(51, 153, 255)',
                      'rgb(255, 159, 64)',
                      'rgb(255, 205, 86)',
                      'rgb(75, 192, 192)',
                      'rgb(54, 162, 235)',
                      'rgb(153, 102, 255)',
                      'rgb(231,233,237)',
                      'rgb(52, 15, 99)',
                      'rgb(229, 196, 14)'
                     ]
                    }]
                },

                options: {

                  legend: {
                    display: false
                  },
                  title: {
                    display: true,
                    text: 'Πλήθος εγγραφών ανά τύπο αίτησης'
                  },
                  scales: {
                      xAxes: [{
                          ticks: {
                              barPercentage: 0.4,
                              beginAtZero: true
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

          
        }); 

        
      }
        else if(str == "3"){

       


          $.ajax({
            'async': true,
            'global': false,
            'type': "POST",
            'url': "ViewStatus_server3.php",
            'dataType': "json",
            'success': function(data) {

              if(window.myChart!= null){
                window.myChart.destroy();
            }

              jsvar = data;
             // if (myChart) myChart.destroy();

              var status = [];
              var plithos = [];
              for(i = 0; i < jsvar.length; i++){


                status[i] = jsvar[i].status;
                plithos[i] = jsvar[i].plithosKwdikwn;
               }
          
               window.myChart = new Chart(ctx, {
          
               type: 'bar',

               data: {
               labels: status,
  
               datasets: [{
                  label: 'Κωδικοί Απόκρισης',

                  data: plithos,
                  
                  backgroundColor: [ 'rgb(51, 153, 255)',
                      'rgb(255, 159, 64)',
                      'rgb(255, 205, 86)',
                      'rgb(75, 192, 192)',
                      'rgb(54, 162, 235)',
                      'rgb(153, 102, 255)',
                      'rgb(231,233,237)',
                      'rgb(52, 15, 99)',
                      'rgb(229, 196, 14)'
                     ]
              }]
            },

            options: {
              legend: {
                display: false
              },
              title: {
                display: true,
                text: 'Κωδικοί Απόκρισης'
              },
              scales: {
                  xAxes: [{
                      ticks: {
                          barPercentage: 0.4,
                          beginAtZero: true
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
        



            
          }});
    }
        else if(str == "4"){
            
          
          $.ajax({
            'async': true,
            'global': false,
            'type': "POST",
            'url': "ViewStatus_server4.php",
            'dataType': "json",
            'success': function(data) {
              
              jsvar = data;
             console.log(jsvar);
  
              
             if(window.myChart!= null){
              window.myChart.destroy();
             }


              window.myChart = new Chart(ctx, {
               type: 'horizontalBar',

                data: {
                  labels: ['Url'],
      
                  datasets: [{
                      
                      data: [jsvar],
                      
                      backgroundColor: [ 'rgb(51, 153, 255)',
                      'rgb(255, 159, 64)',
                      'rgb(255, 205, 86)',
                      'rgb(75, 192, 192)',
                      'rgb(54, 162, 235)',
                      'rgb(153, 102, 255)',
                      'rgb(231,233,237)',
                      'rgb(52, 15, 99)',
                      'rgb(229, 196, 14)'
                     ]
                  }]
                },

                options: {
                  legend: {
                    display: false
                  },
                  title: {
                    display: true,
                    text: 'Πλήθος Μοναδικών Domain  '
                  },
                  scales: {
                      yAxes: [{
                          ticks: {
                              barPercentage: 0.4,
                              beginAtZero: true
                          }
                      }],
                      xAxes: [{
                        ticks: {
                            barPercentage: 0.4,
                            beginAtZero: true
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




          }});

        

        }
        else if(str == "5"){
          

          $.ajax({
            'async': true,
            'global': false,
            'type': "POST",
            'url': "ViewStatus_server5.php",
            'dataType': "json",
            'success': function(data) {

              jsvar =data;



              if(window.myChart!= null){
                window.myChart.destroy();
            }

            console.log(jsvar);
  
            window.myChart = new Chart(ctx, {
                type: 'horizontalBar',

                data: {
                  labels: ['ISP'],
      
                  datasets: [{
                      
                      data: [jsvar],
                      backgroundColor: [ 'rgb(51, 153, 255)',
                      'rgb(255, 159, 64)',
                      'rgb(255, 205, 86)',
                      'rgb(75, 192, 192)',
                      'rgb(54, 162, 235)',
                      'rgb(153, 102, 255)',
                      'rgb(231,233,237)',
                      'rgb(52, 15, 99)',
                      'rgb(229, 196, 14)'
                     ]
                  }]
                },

                options: {
                  legend: {
                    display: false,
                  },
                  title: {
                    display: true,
                    text: 'Πάροχοι μέσα στην βάση'
                  },
                  scales: {
                    
                      yAxes: [{
                          ticks: {
                              barPercentage: 0.4,
                              beginAtZero: true
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




          }});



            
        }



        else if(str == "6"){


          $.ajax({
            'async': true,
            'global': false,
            'type': "POST",
            'url': "ViewStatus_server6.php",
            'dataType': "json",
            'success': function(data) {

            jsvar = data;

            if(window.myChart!= null){
              window.myChart.destroy();
             }

            var content = [];
            var ilikia = [];
            for(i = 0; i < jsvar.length; i++){


            content[i] = jsvar[i].ISTOANTIKEIMENA;
            ilikia[i] = (jsvar[i].MESIILIKIA)/10000;
            }
            
            
            window.myChart = new Chart(ctx, {
            type: 'bar',

            data: {
              labels: content,
  
              datasets: [{
                  label: 'Κωδικοί Απόκρισης',

                  data: ilikia,
                  backgroundColor: [ 'rgb(51, 153, 255)',
                  'rgb(255, 159, 64)',
                  'rgb(255, 205, 86)',
                  'rgb(75, 192, 192)',
                  'rgb(54, 162, 235)',
                  'rgb(153, 102, 255)',
                  'rgb(231,233,237)',
                  'rgb(52, 15, 99)',
                  'rgb(229, 196, 14)'
                 ]
              }]
            },

            
            options: {
              legend: {
                display : false,
                labels: {
                    fontColor: "white",
                    fontSize: 18
                }
                
              },
              title: {
                display: true,
                text: 'Ανά Content Type'
              },
              scales: {
                  xAxes: [{
                  
                      ticks: {
                          barPercentage: 0.4,
                          beginAtZero: true
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
          }});

        }
        else if(str == "7"){


          $.ajax({
            'async': true,
            'global': false,
            'type': "POST",
            'url': "ViewStatus_server7.php",
            'dataType': "json",
            'success': function(data) {

            jsvar = data;

            if(window.myChart!= null){
              window.myChart.destroy();
            }


            var content = [];
            var ilikia = [];
            for(i = 0; i < jsvar.length; i++){


            content[i] = jsvar[i].ISTOANTIKEIMENA;
            ilikia[i] = (jsvar[i].MESIILIKIA)/10000;
            }
            
            
            window.myChart = new Chart(ctx, {
            type: 'bar',

            data: {
              labels: content,
  
              datasets: [{
                  label: 'Κωδικοί Απόκρισης',

                  data: ilikia,
                  backgroundColor: [ 'rgb(51, 153, 255)',
                  'rgb(255, 159, 64)',
                  'rgb(255, 205, 86)',
                  'rgb(75, 192, 192)',
                  'rgb(54, 162, 235)',
                  'rgb(153, 102, 255)',
                  'rgb(231,233,237)',
                  'rgb(52, 15, 99)',
                  'rgb(229, 196, 14)'
                 ]
              }]
            },

            
            options: {
              legend: {
                display : false,
                labels: {
                    fontColor: "white",
                    fontSize: 18
                }
                
              },
              title: {
                display: true,
                text: 'Ανά Content Type'
              },
              scales: {
                  xAxes: [{
                  
                      ticks: {
                          barPercentage: 0.4,
                          beginAtZero: true
                      }
                  }],
                  yAxes: [{
                    ticks: {
                        barPercentage: 0.4,
                        beginAtZero: true
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
          }});

        }
      
  }
  
}