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

//for ($i = 1; $i <= $count; $i++) {
    ?>
    @include('Inventory.departure.pdfheader')
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
        for ($j = 0; $j < count($detail); $j++) {
//            for ($j = $init; $j < $fin; $j++) {
                if (isset($detail[$j])) {
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

                            $init = 1 * $rows;
                            $init = $i * $rows;
                            $fin += $rows;
                            ?>
                            </table>
                            <br>
                            <br>
                            <br>
                            @include('Inventory.departure.pdffooter')
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
                                    <td class="resolution"></td>
                                </tr>
                            </table>
                            <?php
                        }
//                    }
                    ?>

