<table width='100%' bgcolor="#FAFAFA">
    <tr>
        <td width='20%' >Observaciones</td>
        <td width='30%'><?php echo $client["observations"]; ?></td>
        <td>
            <table>
                <tr>
                    <td width='240px' >Total Factura</td>
                    <td><?php echo $totalInvoice; ?></td>
                </tr>
<!--                <tr>
                    <td>Descuento</td>
                    <td>$ 0</td>
                </tr>-->
                <?php
                if ($shipping_cost > 0) {
                    ?>
                    <tr>
                        <td>Flete</td>
                        <td><?php echo "$ " . number_format((round($shipping_cost)), 0, ',', '.'); ?></td>
                    </tr>
                    <?php
                }
                ?>
                <?php
                if ($tax5 > 0) {
                    ?>
                    <tr>
                        <td>Iva 5%</td>
                        <td><?php echo "$ " . number_format((round($tax5)), 0, ',', '.');
                ; ?></td>
                    </tr>
                    <?php
                }
                ?>
                <?php
                if ($tax19 > 0) {
                    ?>
                    <tr>
                        <td>Iva 19%</td>
                        <td><?php echo "$ " . number_format((round($tax19)), 0, ',', '.'); ?></td>
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
                <?php
                if ($discount > 0) {
                    ?>
                    <tr>
                        <td>Descuento</td>
                        <td><?php echo "$ " . number_format((round($discount)), 0, ',', '.'); ?></td>
                    </tr>
                    <?php
                }
                ?>

                <tr>
                    <td>Exento</td>
                    <td><?php echo $exept; ?></td>
                </tr>
                <tr>
                    <td><b>Total a Pagar</b></td>
                    <td><b><?php echo $totalWithTax; ?></b></td>
                </tr>

            </table>
        </td>
    </tr>

</table>
<table>
    <tr>
        <td><?php echo $textTotal; ?></td>
    </tr>
</table>
