const successCallback = (position) =>{

    console.log(position);
};


const errorCallback = (error) =>{
    console.error(error);
};

navigator.geolocation.getCurrentPosition(successCallback, errorCallback);

fetch('http://ip-api.com/json/')
.then(function(response) {
  response.json().then(jsonData => {
    console.log(jsonData);
  });
})
.catch(function(error) {
  console.log(error)
});

const input = document.getElementById('HarFile')
var i;

var Method = [];
var startedDateTime = []; 
var Status = [];
var statusText = [];
var serverIP = [];
var timings = [];
var DomainUrl = []; 

function download(filename, dataShit){

    //create a blob
    const blob = new Blob([dataShit], {type: "text/har"});  

    downloadFile(blob, filename);
}

function downloadFile(blob, filename){

    const url = window.URL.createObjectURL(blob, filename);

    const  a = document.createElement("a");

    a.href = url;
    a.download = filename;

    a.click();
}

var MainObject = {
    entries : []
};
var inputFileName;

//ksekiname na diavazoyme to arxeio har
input.addEventListener('change', function(e) {

    inputFileName = input.files[0].name;
    console.log("Arxeio pou mpike " + inputFileName);
   
    const reader = new FileReader()
    
    
    reader.onload = function(){

        var periexomeno = reader.result;
        //console.log(periexomeno);  
       
        var data = JSON.parse(periexomeno);          
        console.log(data);

        
        var harEntries = data.log.entries;
     
        
        for(i = 0; i< harEntries.length; i++){
            if(harEntries[i].startedDateTime){
               startedDateTime.push(harEntries[i].startedDateTime);
            }
            Method.push(harEntries[i].request.method);
            Status.push(harEntries[i].response.status);
            statusText.push(harEntries[i].response.statusText);
            serverIP.push(harEntries[i].serverIPAddress);
            timings.push(harEntries[i].timings.wait);
            DomainUrl.push(extractHostname(harEntries[i].request.url));
            
            fetch('http://ip-api.com/json/' + serverIP[i])
                .then(function(response) {
                    response.json().then(jsonData => {
                    console.log(jsonData);
                    });
                })
                .catch(function(error) {
                    console.log(error)
                });
          
            //console.log(harEntries[i].request.method, harEntries[i].request.url);
           // console.log(harEntries[i].response.status, harEntries[i].response.statusText, harEntries[i].serverIPAddress, harEntries[i].timings.wait);
            //console.log(Method[i]);
            //sessionStorage.setItem("Method", harEntries[i].request.method);

        }


       

        for(var r=0; r<harEntries.length; r++){

            //magic
            var AnEntrie = {
                request :   {},
                response : {},
                Ip : {},
                timings : {},
                startedDateTime : {},
                Headers : [{}]
            };

            var temp_req = {};
            var temp_res = {};
            var counter_res = 0;
        

            AnEntrie.request.method = Method[r];
            //console.log(AnEntrie.request.method);
            AnEntrie.request.url = DomainUrl[r];
            AnEntrie.response.status = Status[r];
            AnEntrie.response.statusText = statusText[r];
            //console.log(AnEntrie.response.statusText);
            AnEntrie.Ip.serverIPAddress = serverIP[r];
           // console.log(AnEntrie.Ip.serverIPAddress);
            AnEntrie.timings.wait = timings[r];
           // console.log(AnEntrie.timings.wait);
            AnEntrie.startedDateTime.startedDateTime = startedDateTime[r];
                        
            //console.log(AnEntrie);
            
           // console.log("Headers pou uparxoun sto request : " +harEntries[r].request.headers.length);
            //console.log("Headers poy yparxoun sto respons : "+harEntries[r].response.headers.length);

            for(var t=0; t< harEntries[r].request.headers.length;t++){
                   
                   var typeOfHeader =  data.log.entries[r].request.headers[t].name.match(/^(Cache-Control|Pragma|Host|Content-Type|Last-Modified|Expires|Age)$/);



                   //console.log(typeOfHeader);
                   if(typeOfHeader != null && typeOfHeader[0] != undefined){
                     
                       //console.log("Vrika sto " +r, ": " + typeOfHeader, "me timi :" +harEntries[r].request.headers[t].value);
                        
                        //temp_req.name = typeOfHeader;

                        //console.log("To typeOf Header sto request phre timi:  " +typeOfHeader);


                        temp_req.name = typeOfHeader[0];//harEntries[r].request.headers[t].name;
                        temp_req.value = harEntries[r].request.headers[t].value;
                        //AnEntrie.Headers[t].name = harEntries[r].request.headers[t].name;
                        //AnEntrie.Headers[t].value = harEntries[r].request.headers[t].value;
                        //console.log("Temporary object of request header sto " +r,"einai : " +temp_req.value);
                        console.log(temp_req);
                        console.log(+r,". Pairnw apo to request "+t," ->" +temp_req.name, "kai exei value : " +temp_req.value);


                         AnEntrie.Headers[counter_res] = temp_req;  
                         counter_res = counter_res + 1;
                   }
                                                
            }

            console.log("eeeeeeeeeeeeeeeeeeeeeeeeeeeee : " + counter_res);
            
            for(var y=0; y< harEntries[r].response.headers.length; y++){

                
                var typeOfHeader =  data.log.entries[r].response.headers[y].name.match(/^(Cache-Control|Pragma|Host|Content-Type|Last-Modified|Expires|Age|content-Type|pragma|expires|cache-control|host|content-type|last-modified|age)$/);
   

                if(typeOfHeader != null){

                       //console.log(typeOfHeader[0]);


                       // console.log("Vrika sto " +r, ": " + typeOfHeader, "me timi :" +harEntries[r].response.headers[y].value);
                        temp_res.name = harEntries[r].response.headers[y].name;
                        temp_res.value = harEntries[r].response.headers[y].value;
                        //console.log(+r, ". Pairnw apo to response " +temp_res.name, "kai exei value : " +temp_res.value);
                        console.log(temp_res);
                        AnEntrie.Headers[counter_res] = JSON.parse(JSON.stringify(temp_res)); 
                        counter_res = counter_res + 1;

                        //console.log("To typeOf Header sto response phre timi:  " +typeOfHeader);
                        //console.log("Temporary object of request header sto " +r,"einai : " +temp_res.name, " " +temp_res.value);
                       //AnEntrie.Headers[t].name = harEntries[r].response.headers[t].name;
                       // AnEntrie.Headers[t].value = harEntries[r].response.headers[t].value;

                      

                }
                                          
            }
            

            MainObject.entries[r] = AnEntrie;
           // console.log(MainObject.entries[r]);
        }

       
       // console.log(MainObject);




       //apothikeuw sto session storage topika tis plirofories pou thelw
        sessionStorage.setItem("allMethods", Method);
        sessionStorage.setItem("startesDateTime", startedDateTime);
        sessionStorage.setItem("status", Status);
        sessionStorage.setItem("StatusText", statusText);
        sessionStorage.setItem("ServerIP", serverIP);
        sessionStorage.setItem("Timings", timings);
        sessionStorage.setItem("Domain", DomainUrl);

        
        

    }
  

    reader.readAsText(input.files[0]);
    console.log(MainObject);
  

}, false)






// einai sinartisi gia na pernoume to domain
function extractHostname(url) {
    var hostname;
    //find & remove protocol (http, ftp, etc.) and get hostname

    if (url.indexOf("//") > -1) {
        hostname = url.split('/')[2];
    }
    else {
        hostname = url.split('/')[0];
    }

    //find & remove port number
    hostname = hostname.split(':')[0];
    //find & remove "?"
    hostname = hostname.split('?')[0];

    return hostname;
}


