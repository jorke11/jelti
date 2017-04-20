function Summary() {
    var table;
    var canvas = document.getElementById("micanvas");
    var ctx = canvas.getContext("2d");

    this.init = function () {
        $("#btnPrint").click(function () {
            obj.printGraph($("#quantity").val());
        });
    }

    this.printGraph = function (quantity = 10) {

        quantity = quantity || $("#quantity").val();
        var data = [];
        var ale = 0, ale2 = 0, pasos = 0, hip = 0;

        for (var i = 0; i < quantity; i++) {
            ale = Math.random() * (1 - 0) + 0;
            ale2 = Math.random() * (1 - 0) + 0;
            hip = Math.sqrt(Math.pow(ale, 2) + Math.pow(ale2, 2));
            data.push({
                aleatorio: ale,
                x: ale * 500,
                y: ale2 * 500,
                hip: hip * 500,
                pasos: 0,
                aleatorio2: ale2,
                hipotenusa: hip,
                angulo: 0});
        }


        for (var j = 0; j < quantity; j++) {
            if (data[j].aleatorio >= 0 && data[j].aleatorio <= 0.25) {
                data[j].pasos = 1;
            } else if (data[j].aleatorio > 0.25 && data[j].aleatorio <= 0.50) {
                data[j].pasos = 2;
            } else if (data[j].aleatorio > 0.50 && data[j].aleatorio <= 0.75) {
                data[j].pasos = 3;
            } else {
                data[j].pasos = 4;
            }
        }

        ctx.moveTo(0, 500);

        for (i = 0; i < quantity; i++) {
            ctx.lineTo(data[i].x, 500 - data[i].y);
            ctx.fillText("(" + (data[i].aleatorio).toFixed(2) + " , " + data[i].aleatorio2.toFixed(2) + ")", (data[i].x + -1).toFixed(2), (500 - 1 - data[i].y).toFixed(2));
        }
        
        
        ctx.closePath();
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(0, 500);
        ctx.lineTo(data[quantity - 1].x, 500 - data[quantity - 1].y);
        data[quantity - 1].angulo = ((Math.atan((data[quantity - 1].aleatorio2/data[quantity - 1].aleatorio)))*100).toFixed(1);


        ctx.lineWidth = 5;
        ctx.strokeStyle = '#FF0000';
        ctx.stroke();

        var html = "";
        $("#data tbody").empty();
        for (i = 0; i < quantity; i++) {
            html += '<tr><td>' + data[i].aleatorio + '</td><td>' + data[i].pasos + '</td><td>' + data[i].aleatorio2 + '</td><td>'+ data[i].angulo +'</td>';
            html+='<td>'+ data[i].hipotenusa +'</td></tr>';
        }
        $("#data tbody").html(html);
    }

    this.printLine = function (x1, y1, x2, y2) {
        var canvas = document.getElementById("micanvas");
        var ctx = canvas.getContext("2d");
        ctx.moveTo(x1, y1);
        ctx.lineTo(x2, 500 - y2);
        ctx.stroke();
    }


}

var obj = new Summary();
obj.init();


