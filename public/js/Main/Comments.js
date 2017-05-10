function Comments() {
    this.init = function () {
        this.comments();

        $("#product_id").change(function () {
            obj.comments($(this).val());
        });
        $("#btnFind").click(this.find);
    }

    this.find = function () {
        obj.comments($("#product_id").val());
    }

    this.comments = function (id) {
        var html = "";
        id = id | 0;
        var obj = {};
        obj.finit = $("#finit").val();
        obj.fend = $("#fend").val();
        $.ajax({
            url: '/comments/list/' + id,
            method: "get",
            data: obj,
            dataType: 'json',
            success: function (data) {
                $.each(data, function (i, val) {
                    html += "<tr>";
                    html += "<td>" + val.product + "</td>";
                    html += "<td>" + val.description + "</td>";
                    html += "<td>" + val.stakeholder + "</td>";
                    html += "<td>" + val.created_at + "</td>";
                    html += '<td id="answer_' + val.id + '"><a href="#" onclick=obj.answer(' + val.id + ')>Answer</a></td>';
                    html += "</tr>";
                });

                $("#tbl tbody").html(html);
            }
        })
    }

    this.answer = function (id) {
        $("#answer_" + id).html('<textarea class="form-control" ></textarea>');
        console.log(id)
    }
}

var obj = new Comments();

obj.init();

