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
        <td class="font-subtitle" width='50%'>Factura de venta: 000031</td>
    </tr>
    <tr>
        <td>
            <table border='0'>
                <tr>
                    <td class="font-detail">Cliente</td>
                    <td class="font-detail-cont"><?php echo $client["name"] . " " . $client["last_name"]; ?></td>
                </tr>
                <tr>
                    <td class="font-detail">Nit</td>
                    <td class="font-detail-cont"><?php echo $client["document"]; ?></td>
                </tr>
                <tr>
                    <td class="font-detail">Dirección</td>
                    <td class="font-detail-cont"><?php echo $client["address"]; ?></td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td class="font-detail">Emisión</td>
                    <td class="font-detail-cont">03 de Marzo de 2017</td>
                </tr>
                <tr>
                    <td class="font-detail">Vencimiento</td>
                    <td class="font-detail-cont">3 de Abril de 2017</td>
                </tr>
                <tr>
                    <td class="font-detail">Vendedor</td>
                    <td class="font-detail-cont">Vendedor de Prueba</td>
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
            <th>Cantidad</th>
            <th>Descripción</th>
            <th>% Iva</th>
            <th>Precio</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody> 
        <?php
        $totalSum = 0;
        $rest = 15 - count($detail);
        for ($i = 0; $i < count($detail); $i++) {
            $desc = ($detail[$i]->product_id == '') ? $detail[$i]->description : $detail[$i]->product;
            $total = number_format(($detail[$i]->valuetotal), 2, ',', '.');
            $valueUnit = number_format(($detail[$i]->value), 2, ',', '.');
            $totalSum += $detail[$i]->valuetotal;
            ?>
            <tr >
                <td align='center'><?php echo $detail[$i]->quantity; ?></td>
                <td><?php echo $desc; ?></td>
                <td align='center'><?php echo $detail[$i]->tax; ?></td>
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
        <td width='50%' >Notas</td>
        <td >
            <table>
                <tr>
                    <td width='240px' >Total Factura</td>
                    <td align='right'><?php echo "$ ".number_format(($totalSum), 2, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td>Descuento</td>
                    <td>$ 0</td>
                </tr>
                <tr>
                    <td>Flete</td>
                    <td>$ 0</td>
                </tr>
                <tr>
                    <td>Iva 5%</td>
                    <td>$ 200</td>
                </tr>
                <tr>
                    <td>Iva 16%</td>
                    <td>$ 24400</td>
                </tr>
                <tr>
                    <td>Exento</td>
                    <td>$ 111100</td>
                </tr>
                <tr>
                    <td>Monto</td>
                    <td>$ 111100</td>
                </tr>

            </table>
        </td>
    </tr>

</table>

<?php // echo $foo  ?>
<!--<img src="/images/product/default.jpg">-->

