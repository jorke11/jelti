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

<?php
$rest = 15 - count($detail);
$count = round(count($detail) / 15);
$init = 0;
$fin = 15;
$cont = 0;

//for ($i = 1; $i <= $count; $i++) {
    ?>
    @include('Inventory.departure.pdfheader')
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
        <?php
        for ($j = 0; $j < count($detail); $j++) {
            $desc = ($detail[$j]->product_id == '') ? $detail[$j]->description : $detail[$j]->product;
            $total = number_format(($detail[$j]->valuetotal), 2, ',', '.');
            $valueUnit = number_format(($detail[$j]->value), 2, ',', '.');
            ?>
            <tr >
                <td align='center'><?php echo $detail[$j]->quantity; ?></td>
                <td><?php echo $desc; ?></td>
                <td align='center'><?php echo (int) $detail[$j]->tax; ?></td>
                <td align='right'><?php echo "$ " . $valueUnit; ?></td>
                <td align='right'><?php echo "$ " . ($total) ?></td>
            </tr>
            <?php
        }

        $init = $i * 15;
        $fin += 15;
        ?>
    </table>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    @include('Inventory.departure.pdffooter')
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <?php
//}
?>

