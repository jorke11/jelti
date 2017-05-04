function Summary() {
    var table;

    this.init = function () {
        $("#btnPrint").click(function () {
            obj.printGraph($("#quantity").val());
        });
    }

    this.printGraph = function (quantity = 10) {

        quantity = quantity || $("#quantity").val();
        var data = [];
        var ale = 0, ale2 = 0, pasos = 0, hip = 0, angulo;

        for (var i = 0; i < quantity; i++) {
            ale = Math.random() * (1 - 0) + 0;
            ale2 = Math.random() * (1 - 0) + 0;


            angulo = ((Math.atan((ale2 / ale))) * 100).toFixed(1);
            data.push({
                aleatorio: ale,
                disponibles: 0,
                aleatorio2: ale2,
            });
        }


        for (var j = 0; j < quantity; j++) {
            if (data[j].aleatorio >= 0 && data[j].aleatorio <= 0.1) {
                data[j].rentadospordia = 0;
            } else if (data[j].aleatorio > 0.1 && data[j].aleatorio <= 0.2) {
                data[j].rentadospordia = 1;
            } else if (data[j].aleatorio > 0.2 && data[j].aleatorio <= 0.45) {
                data[j].rentadospordia = 2;
            } else if (data[j].aleatorio > 0.45 && data[j].aleatorio <= 0.75) {
                data[j].rentadospordia = 3;
            } else {
                data[j].rentadospordia = 4;
            }
        }

        for (var j = 0; j < quantity; j++) {
            if (data[j].aleatorio >= 0 && data[j].aleatorio <= 0.4) {
                data[j].rentadosporauto = 1;
            } else if (data[j].aleatorio > 0.4 && data[j].aleatorio <= 0.75) {
                data[j].rentadosporauto = 2;
            } else if (data[j].aleatorio > 0.75 && data[j].aleatorio <= 0.9) {
                data[j].rentadosporauto = 3;
            } else {
                data[j].rentadosporauto = 4;
            }
        }

        console.log(data)


        var html = "";
        $("#data tbody").empty();

        for (i = 0; i < quantity; i++) {
            data[i].necesarios += data[i].rentadospordia;

            data[i].disponibles += data[i].rentadospordia;

            if (data[i].rentadospordia == 0) {
                data[i].rentadosporauto = 0;
            }

            if (i > 0) {




//                if (){
//
//                }
//                data[i].total

            }


            html += '<tr><td>' + i + '</td><td>' + data[i].aleatorio + '</td><td>' + data[i].rentadospordia + '</td><td>' + data[i].aleatorio2 + '</td><td>' + data[i].rentadosporauto + '</td>';
            html += '<td>' + data[i].disponibles + '</td><td>' + data[i].necesarios + '</td></tr>';
        }
        $("#data tbody").html(html);
    }
}

var obj = new Summary();
obj.init();


