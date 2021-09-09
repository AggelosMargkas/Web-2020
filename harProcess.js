//KSEKINAME ME TA CALLBACK GIA NA APROUME TA DEDOMENA TOU XRHSTH SXETIKA ME TIN IP TOU 
//XRISIMOPOIOUME TO IP-API

const successCallback = (position) =>{

    console.log(position);

};


const errorCallback = (error) =>{
    console.error(error);
};

navigator.geolocation.getCurrentPosition(successCallback, errorCallback);


//efarmozw to ip-api gia na parw ta network data mesw ths ip
fetch('http://ip-api.com/json/').then(function(response) {
  response.json().then(jsonData => {
      
    console.log(jsonData);
    userIsp = jsonData.isp;
    console.log(userIsp);
    userLat = jsonData.lat;
    console.log(userLat);
    userLon = jsonData.lon;
    console.log(userLon);
    userServer = jsonData.query;
    console.log(userServer);

    ipUserData = [userIsp, userServer, userLat, userLon];
    document.getElementById('myField2').value = JSON.stringify(ipUserData);

  });

})
.catch(function(error) {
  console.log(error)
});





//PERNOUME TO HAR POU EVALE O XRISTIS ASUGXRONA TO HAR FILE POU EVALE O XRHSTES
const input = document.getElementById('HarFile')


//ORIZOUME OLES TI METAVLITES POU THA XREIASTOUME
var i;
var Method = [];
var startedDateTime = []; 
var Status = [];
var statusText = [];
var serverIP = [];
var timings = [];
var DomainUrl = []; 
var serverIp_visited = [];
var serverLat_visited = [];
var serverLon_visited = [];
var Visited_servers_Data = [];
var inputFileName;


//MAS ENDIAFEROUN TA ENTRIES OPOTE STO TELOS THELOUME NA EXOUME ENA MAIN OBJECT POU NA EXEI MONO TA ENTRIES FILTRARISMENA
var MainObject = {

    entries : []

};


//KSEKINAEI H EPEJERGASIA TOU ARXEIOU
input.addEventListener('change', function(e) {

    


    inputFileName = input.files[0].name;
    console.log("Arxeio pou mpike " + inputFileName);
   
    //XRISIMOPOIOUME TON FILE READER KAI ME TH SUNARTHSH ONLOAD KANOUME OLI THN DOULEIA
    const reader = new FileReader()
    
    
    reader.onload = function(){

        //PAIRNOUME TO HAS KAI TO PARSAROUME
        var periexomeno = reader.result;
       
        var data = JSON.parse(periexomeno);          
        console.log(data);

        //KAI PERNOUME TA ENTRIES
        var harEntries = data.log.entries;
     
        

        //APO EDW KAI PERA EINAI O KATHARISMOS TWN DEDOMENWN OPOU APO TO KATHE ENTRIE KATHARIZOUME OTI DEN MAS EPITREPETE
        //KATHWS KAI PERNOUME OTI XREIAZETAI.
        for(i = 0; i< harEntries.length; i++){

            if(harEntries[i].startedDateTime){
               startedDateTime.push(harEntries[i].startedDateTime);
            }

            //GIA KATHE PEDIO PERNOUME OLA TA DEDOMENA POY EXEI
            Method.push(harEntries[i].request.method);
            Status.push(harEntries[i].response.status);
            statusText.push(harEntries[i].response.statusText);
            serverIP.push(harEntries[i].serverIPAddress);
            timings.push(harEntries[i].timings.wait);
            DomainUrl.push(extractHostname(harEntries[i].request.url));
            

            //GIA NA PAROUME TA DEDOMENA TON SERVER POU EPISKEFTIKE O XRISTIS KANOUME XRISH ENOS ALLOU API
            //TO FREEGEOIP APODIKTIKE TO KALITERO GIATI EPITREPEI TA PERISSOTERA REQUEST GIA DEDOMENA ANA WRA SE SXESI ME TA ALLA API
            fetch('https://freegeoip.app/json/' + serverIP[i])
                .then(function(response) {
                    response.json().then(jsonData => {
                    console.log(jsonData);
                    

                    Visited_servers_Data.push({
                        serverIp_visited : jsonData.ip,
                        serverLat_visited : jsonData.latitude,
                        serverLon_visited : jsonData.longitude
                    });

                    if(i = harEntries.length -1 ){
                        document.getElementById('myField3').value = JSON.stringify(Visited_servers_Data);
                    }
                });
                })
                .catch(function(error) {
                    console.log(error)
                });
          
 

        }
            

       
        //AFOU EXOUME PAREI OTI XREIAZOMASTE FTIAXNOUME MIA LOOPA GIA NA PERNAME ENA ENA TA ENTRIES
        //MESA STO MAIN OBJECT
        //SXIMATIZOUME MIA TOPIKI METAVLITI TYPOU JS 
        //KAI ME FOR GEMIZOUME SIGA SIGA TO MAIN OBJECT.

        for(var r=0; r<harEntries.length; r++){

            //magic
            var AnEntrie = {
                request :   {},
                response : {},
                Ip : {},
                timings : {},
                startedDateTime : {},
                Headers_request : [{}],
                Headers_response : [{}]
            };

            var temp_req = {};
            var temp_res = {};
            var counter_res = 0;
        

            AnEntrie.request.method = Method[r];
            AnEntrie.request.url = DomainUrl[r];
            AnEntrie.response.status = Status[r];
            AnEntrie.response.statusText = statusText[r];
            AnEntrie.Ip.serverIPAddress = serverIP[r];
            AnEntrie.timings.wait = timings[r];
            AnEntrie.startedDateTime.startedDateTime = startedDateTime[r];
                        

            //GIA TA HEADER XRIASTIKE H XRHSH REGEX
            for(var t=0; t< harEntries[r].request.headers.length;t++){
                   
                var typeOfHeader =  data.log.entries[r].request.headers[t].name.match(/^(Cache-Control|Pragma|Host|Content-Type|Last-Modified|Expires|Age|content-Type|pragma|expires|cache-control|host|content-type|last-modified|age|:method)$/);


                   if(typeOfHeader != null && typeOfHeader[0] != undefined){

                        temp_req.name = typeOfHeader[0];
                        temp_req.value = harEntries[r].request.headers[t].value;
                        //console.log(temp_req);
                        console.log(y +". STO " +temp_req.name + " einai toso ===>" +temp_req.value);


                        AnEntrie.Headers_request[counter_res] = temp_req;  
                        counter_res = counter_res + 1;

                    }
                                                
            }

            
            for(var y=0; y< harEntries[r].response.headers.length; y++){

                
                var typeOfHeader =  data.log.entries[r].response.headers[y].name.match(/^(Cache-Control|Pragma|Host|Content-Type|Last-Modified|Expires|Age|content-Type|pragma|expires|cache-control|host|content-type|last-modified|age|:method)$/);
   

                if(typeOfHeader != null){

                        //console.log(typeOfHeader);
                        temp_res.name = harEntries[r].response.headers[y].name;
                        temp_res.value = harEntries[r].response.headers[y].value;

                        AnEntrie.Headers_response[counter_res] = JSON.parse(JSON.stringify(temp_res)); 
                        counter_res = counter_res + 1;
                }
            }
            

            MainObject.entries[r] = AnEntrie;
        }



        //GIA TIN METAFORA TOU OBJECT TO KANOUME STRINGIFY WSTE NA MPOREI NA METAFERTHEI STO SAVETODB GIA NA GINEI EPEKSERGASIA ANEVASMATOS STHN VASI
        console.log(MainObject);
        el = JSON.stringify(MainObject);
        //console.log(el)
        document.getElementById('myField1').value = el;


    }


    reader.readAsText(input.files[0]);
  

}, false)






// ME AUTH THN SUNARTISI KATHARIZOUME TA URL GIA NA PERNOUME KATHARA TA DOMAIN OPOU UPARXOUN DEDOMENA
function extractHostname(url) {


    var hostname;

    if (url.indexOf("//") > -1) {
        hostname = url.split('/')[2];
    }
    else {
        hostname = url.split('/')[0];
    }

    
    hostname = hostname.split(':')[0];
    hostname = hostname.split('?')[0];

    return hostname;
}



//GIA TO ACTION TOU DOWNLOAD XREIAZETAI I METATROPI TOU ARXEIOY SE BLOB 
//GINETAI I XRISI TON DYO PARAKATV SUNARTISEWN 
//FTIAXNOUME TO BLOB STIN PRWTI KAI STHN DEUTERI GIA NA TO KATEVASI O XRISTI PREPEI NA GINEI STHN MORFI URL 
//TOU DINOUME ONOMA KAI PERIEXOMAI KAI ME TO CLICK GINETAI TO DOWNLOAD

function download(filename, dataShit){

    //create a blob
    const blob = new Blob([dataShit], {type: "text/har"});  

    downloadFile(blob, filename);
}



function downloadFile(blob, filename){

    const url = window.URL.createObjectURL(blob, filename);
   //https://phppot.com/php/mysql-blob-using-php/
    const  a = document.createElement("a");

      a.href = url;
      a.download = filename;

      a.click();

}

