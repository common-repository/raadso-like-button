// ------------------
// Copyright 2013 Raadso, OmarTeacher
// info@raadso.so, www.raadso.so
// ------------------

var rdObjectValidationObjects = new Array("div", "span", "p", "ul", "li");

rdObjectValidationObjects.reverse(); function findrdML(string, rdmlcomm) { var i = (string).indexOf(rdmlcomm); return i === -1 ? false : true; } var x = 0; while (x < rdObjectValidationObjects.length) { var rdVObjectNode = document.getElementsByTagName(rdObjectValidationObjects[x]); var l = new Array(); for(var i=0, ll=rdVObjectNode.length; i!=ll; l.push(rdVObjectNode[i++])); l.reverse(); var rdVObject = l; var i = 0; while (i < rdVObject.length) { var rdRObject = rdVObject[i].innerHTML;
if(findrdML(rdRObject, '<!-- rdML ') != false) { var rdRObject = rdRObject.replace(/<!-- rdML /g, ""); var rdRObject = rdRObject.replace(/ rdML -->/g, ""); rdVObject[i].innerHTML = rdRObject;} i++; } x++; }