<style>
    body{
        font-size: 11px;
    }
    .space-title{
        font-size: 10px;
        width: 350px;
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
        <td class="space-title"></td>
        <td>SUPERFUDS SAS</td>
    </tr>
    <tr>
        <td class="space-title"></td>
        <td>NIT 900 703 907-7</td>
    </tr>
    <tr>
        <td class="space-title"></td>
        <td>BARRANQUILLA COLOMBIA</td>
    </tr>
    <tr>
        <td class="space-title"></td>
        <td>E-mail: info@superfuds.com.co</td>
    </tr>
</table>
<br>
<br>
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
                    <td class="font-detail-cont"><?php echo $client["address_invoice"]; ?></td>
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
<table width='100%'>
    <thead>
        <tr border='1'>
            <th width="10%">Cantidad</th>
            <th width="50%">Descripción</th>
            <th>% Iva</th>
            <th>Precio</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody> 
        <?php
        $rest = 15 - count($detail);
        for ($i = 0; $i < count($detail); $i++) {
            $desc = ($detail[$i]->product_id == '') ? $detail[$i]->description : $detail[$i]->product;
            $total = number_format(($detail[$i]->valuetotal), 2, ',', '.');
            $valueUnit = number_format(($detail[$i]->value), 2, ',', '.');
            ?>
            <tr >
                <td align='center'><?php echo $detail[$i]->quantity; ?></td>
                <td><?php echo $desc; ?></td>
                <td align='center'><?php echo (int) $detail[$i]->tax; ?></td>
                <td align='right'><?php echo "$ " . $valueUnit; ?></td>
                <td align='right'><?php echo "$ " . ($total) ?></td>
            </tr>
            <?php
        }

        for ($i = 0; $i < $rest; $i++) {
            ?>
            <tr >
                <td><?php echo "&nbsp;"; ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php
        }
        ?>
    </tbody>

</table>
<br>
<table border='1' width='100%'>
    <tr>
        <td width='50%' >Observaciones</td>
        <td >
            <table>
                <tr>
                    <td width='240px' >Total Factura</td>
                    <td><?php echo $totalInvoice; ?></td>
                </tr>
<!--                <tr>
                    <td>Descuento</td>
                    <td>$ 0</td>
                </tr>-->
                <tr>
                    <td>Flete</td>
                    <td><?php echo $shipping; ?></td>
                </tr>
                <?php
                if ($tax5num > 0) {
                    ?>
                    <tr>
                        <td>Iva 5%</td>
                        <td><?php echo $tax5; ?></td>
                    </tr>
                    <?php
                }
                ?>
                <?php
                if ($tax19num > 0) {
                    ?>
                    <tr>
                        <td>Iva 19%</td>
                        <td><?php echo $tax19; ?></td>
                    </tr>
                    <?php
                }
                ?>

                <?php
                if ($rete > 0) {
                    ?>
                    <tr>
                        <td>Retefuente</td>
                        <td><?php echo $formatRete; ?></td>
                    </tr>
                    <?php
                }
                ?>

                <tr>
                    <td>Exento</td>
                    <td><?php echo $exept; ?></td>
                </tr>
                <tr>
                    <td><b>Monto</b></td>
                    <td><b><?php echo $totalWithTax; ?></b></td>
                </tr>

            </table>
        </td>
    </tr>

</table>

<?php // echo $foo   ?>
<!--<img src="/images/product/default.jpg">-->

