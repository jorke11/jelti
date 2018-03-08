function Payment() {
    this.init = function () {

        $("#btnPayU").click(this.payu);

        this.getDetail();
        this.getQuantity();


    }

    this.payu = function () {
        window.location.href = PATH + "/payment/" + $("#frm #order_id").val()

    }

    this.getQuantity = function () {
        var html = "";
        $.ajax({
            url: PATH + '/getCounter',
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {
                $("#quantityOrders").html(data.quantity);
            }
        })
    }

    this.getDetail = function () {
        var html = "", image = "";
        $.ajax({
            url: 'getDetail',
            method: 'GET',
            dataType: 'JSON',
            beforeSend: function () {
                $("#loading-super").removeClass("hidden");
            },
            success: function (data) {
                if (data.success == false) {
                    $("#btnPay").attr("disabled", true);
                    $("#btnPayU").attr("disabled", true);
                    
                    html=  html += `
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p style="color:red">No tienes productos en tu carrito de compras</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                    
                        `;
                    
                } else {

                    $.each(data.detail, function (i, val) {
//                    image = (val.image == null) ? "../assets/images/default.jpg" : val.image;
                        image = (val.thumbnail == null) ? "http://via.placeholder.com/200x150" : val.thumbnail;
                        html += `
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-header">
                                            <button type="button" class="close"  aria-label="Close" style="padding-right:1%" onclick=obj.deleteItem(${val.product_id},${val.order_id})><span aria-hidden="true">&times;</span></button>
                                        </div>
                        
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <img src="${image}">
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <h3>${val.product}</h3>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="muted">${val.supplier}</div>
                                                    </div>
                                                </div>
                        
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <h4>${val.total_formated}</h4>
                                                </div>
                                            </div>
                                                <div class="row">
                                            <div class="col-lg-4">
                                                <input type="number" id="quantity" name="quantity" class="form-control" min="1" value='${val.quantity}' onblur=obj.updateQuantity(${val.order_id},${val.product_id},this)>
                                            </div>
                                            </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                    
                        `;
                    })
                    html += '</div>';
                }

                $("#content-detail").html(html);
//                $("#tblReview").html('<tr><td colspan="4"><strong>Total</td><td>' + data.total + '</strong></td></tr>');
                $("#loading-super").addClass("hidden");
                $("#subtotalOrder").html("<h4>" + data.subtotal + "</h4>");
                $("#totalOrder").html("<h4>" + data.total + "</h4>");
                $("#frm #order_id").val(data.order);
            }, error: function () {


            }
        })
    }

    this.updateQuantity = function (order_id, product_id, input) {
        toastr.remove();
        var param = {};
        param.product_id = product_id;
        param.quantity = input.value;

        $.ajax({
            url: 'getDetailQuantity/' + order_id,
            method: 'PUT',
            data: param,
            dataType: 'JSON',
            success: function (data) {
                if (data.success == true) {
                    toastr.success("Cantidad editada");
                    obj.setQuantity();
                    obj.getDetail();
                }
            }
        })
    }

    this.setQuantity = function () {
        var html = "";
        $.ajax({
            url: PATH + '/getCounter',
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {

                $("#quantityOrders").html(data.quantity);
            }
        })

    }

    this.deleteItem = function (product_id, order_id) {
        var data = {};
        data.product_id = product_id;
        $.ajax({
            url: 'deleteDetail/' + order_id,
            method: 'DELETE',
            data: data,
            dataType: 'JSON',
            success: function (data) {
                obj.getDetail();
            }
        })
    }
}

var obj = new Payment();
obj.init();
