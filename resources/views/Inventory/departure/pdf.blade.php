<style>
    body{
        font-size: 11px;
    }
    .space-title{
        font-size: 10px;
        width: 350px;
    }
    .title-supplier{
        font-size: 8px;
        font-style: italic;
        color: #999999;
    }

    .font-subtitle{
        font-size: 11px;
        font-weight: bold;
        padding-bottom: 15px;
    }

    .resolution{
        font-size: 8px;
    }

    .font-invoice{
        font-size: 20px;
        font-weight: bold;
        padding-bottom: 15px;
    }
    .font-detail{
        font-size: 12px;
    }
    .font-detail-cont{
        font-size: 12px;
        font-weight: bold;
    }

    #detail {     font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
                  text-align: left;    border-collapse: collapse; }

    #detail th {     
        font-size: 13px;     font-weight: normal;     padding: 8px;     background: #00b065;
        border-top: 4px solid #00b065;    border-bottom: 1px solid #fff; color: #fff; 

    }

    #detail td {    padding: 3px;     background: #fff;     border-bottom: 1px solid #fff;
                    border-top: 1px solid transparent; }

    #detail tr:hover td { background: #d0dafd; color: #339; }
</style>

<?php
$rows = 12;
$rest = $rows - count($detail);
$count = round(count($detail) / $rows);
$init = 0;
$fin = $rows;
$cont = 0;

for ($i = 1; $i <= $count; $i++) {
    ?>

<html>
    <style>
        body{
            font-size: 11px;
        }
        .space-title{
            width: 350px;
            margin: 0 auto;
        }

        .font-subtitle{
            font-size: 11px;
            font-weight: bold;
            padding-bottom: 15px;
        }
        .font-invoice{
            font-size: 20px;
            font-weight: bold;
            padding-bottom: 15px;
        }
        .font-detail{
            font-size: 12px;
        }
        .font-detail-cont{
            font-size: 12px;
            font-weight: bold;
        }
    </style>

    <br>
    <br>

    <table align='center'  width='100%'>
        <tr>
            <td class="space-title">
                <table>
                    <tr>
                        <td width='100px'></td>
                        <td>
                            <!--<img src="{{public_path()}}/assets/images/logo.png" width="10%">-->
                        </td>
                    </tr>
                </table>
            </td>
            <td>SUPERFUDS SAS<br>NIT 900 703 907-7<br>BARRANQUILLA COLOMBIA<br>E-mail: info@superfuds.com.co</td>
        </tr>
    </table>
    <table align='center' >
        <tr>
            <td class="font-title">Resolución Dian 320001359848</td>
        </tr>
        <tr>
            <td class="font-title">del 29.02 de 2016</td>
        </tr>
        <tr>
            <td class="font-title">Numeración Autorizada</td>
        </tr>
    </table>
    <br>
    <br>
    <table width='100%'>
        <tr>
            <td class="font-subtitle" width='50%'>Factura a nombre de:</td>
            <td class="font-invoice" width='50%'>Factura de venta: <?php echo $invoice ?></td>
        </tr>
        <tr>
            <td>
                <table border='0'>
                    <tr>
                        <td class="font-detail">Cliente</td>
                        <td class="font-detail-cont"><?php echo $client["business_name"]; ?></td>
                    </tr>
                    <tr>
                        <td class="font-detail">Nit</td>
                        <td class="font-detail-cont"><?php echo $client["document"]; ?></td>
                    </tr>
                    <tr>
                        <td class="font-detail">Dirección</td>
                        <td class="font-detail-cont"><?php echo $client["address_invoice"] . "<br>" . $client["city"]; ?></td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td class="font-detail">Emisión</td>
                        <td class="font-detail-cont"><?php echo $client["emition"]; ?></td>
                    </tr>
                    <tr>
                        <td class="font-detail">Vencimiento</td>
                        <td class="font-detail-cont"><?php echo $client["expiration"]; ?></td>
                    </tr>
                    <tr>
                        <td class="font-detail">Vendedor</td>
                        <td class="font-detail-cont"><?php echo $client["responsible"]; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>


    <br>
    <br>
    <table width='100%' id="detail">
        <thead>
            <tr>
                <th width="10%">Cantidad</th>
                <th width="50%">Descripción</th>
                <th>% Iva</th>
                <th>Precio</th>
                <th>Total</th>
            </tr>
        </thead>  
        <?php
        if (isset($detail) && count($detail) > 0) {
            $cont = 0;
//            for ($j = 0; $j < count($detail); $j++) {

                for ($j = $init; $j < $fin; $j++) {
                    if (isset($detail[$j])) {
                        $cont++;
                        $desc = ($detail[$j]->product_id == '') ? $detail[$j]->description : $detail[$j]->product;
                        $total = number_format(($detail[$j]->valuetotal), 2, ',', '.');
                        $valueUnit = number_format(($detail[$j]->value), 2, ',', '.');
                        ?>
                        <tr>
                            <td align='center'><?php echo $detail[$j]->quantity; ?></td>
                            <td><?php echo $desc; ?><br><span class="title-supplier"><?php echo $detail[$j]->stakeholder; ?><span></td>
                                        <td align='center'><?php echo (int) $detail[$j]->tax; ?></td>
                                        <td align='right'><?php echo "$ " . $valueUnit; ?></td>
                                        <td align='right'><?php echo "$ " . ($total) ?></td>
                                        </tr>
                                        <?php
                                    }
                                }

//                            $init = 1 * $rows;
                                $init = $i * $rows;
                                $fin += $rows;
                                ?>
                                </table>
                                <br>
                                <br>
                                <br>
                              
                                <table>
                                    <tr>
                                        <td class="resolution">La presente factura de compra - venta se asimila en sus efectos a una letra de cambio, art. 774 numeral 6o. Del Código de Comercio. En caso de
                                            mora se causarán intereses a la tasa máxima legal estipulada por la ley, o en el respectivo contrato (conforme al art. 884 del Código de Comercio).</td>
                                    </tr>
                                    <tr>
                                        <td class="resolution">No somos grandes Contribuyentes, no somos Autorretenedores.</td>
                                    </tr>
                                    <tr>
                                        <td class="resolution">Favor hacer transferencia a:</td>
                                    </tr>
                                    <tr>
                                        <td class="resolution">Cuenta Bancaria:</td>
                                    </tr>
                                    <tr>
                                        <td class="resolution">Bancolombia # 72951229710</td>
                                    </tr>
                                    <tr>
                                        <td class="resolution">Corriente a nombre de SuperFuds S.A.S.</td>
                                    </tr>
                                    <tr>
                                        <td class="resolution">Nit: 900.703.907</td>
                                    </tr>
                                    <tr>
                                        <td class="resolution">Solo se aceptan transferencias bancarias, si el pago es por consignacion se debe agregar al valor final 11.000</td>
                                    </tr>


                                </table>
                                <?php
                            }
                        }
//                    }
                    ?>