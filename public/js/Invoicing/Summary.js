//function Kardex() {
//    var table;
//    
//    this.init = function () {
//        
//    }
//
//
//}
//
//var obj = new Kardex();
//obj.init();

var canvas = document.getElementById("micanvas");
var ctx = canvas.getContext("2d");

ctx.moveTo(10, 10);
ctx.lineTo(180, 180);

ctx.strokeStyle = "#f00";
ctx.stroke();

ctx.moveTo(0, 0);
ctx.lineTo(100, 600);

ctx.strokeStyle = "#000";
ctx.stroke();
