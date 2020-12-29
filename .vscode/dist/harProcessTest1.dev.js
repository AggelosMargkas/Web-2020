"use strict";

var input = document.getElementById('HarFile');
var i;
var Method = [];
var startedDateTime = [];
var Status = [];
var statusText = [];
var serverIP = [];
var timings = [];
var DomainUrl = []; //ksekiname na diavazoyme to arxeio har

input.addEventListener('change', function (e) {
  console.log(input.files);
  var reader = new FileReader();

  reader.onload = function () {
    var primo = reader.result;
    var primoURL = reader.readAsDataURL();
  };

  reader.readAsText(input.files[0]);
}, false); // einai sinartisi gia na pernoume to domain

function extractHostname(url) {
  var hostname; //find & remove protocol (http, ftp, etc.) and get hostname

  if (url.indexOf("//") > -1) {
    hostname = url.split('/')[2];
  } else {
    hostname = url.split('/')[0];
  } //find & remove port number


  hostname = hostname.split(':')[0]; //find & remove "?"

  hostname = hostname.split('?')[0];
  return hostname;
}