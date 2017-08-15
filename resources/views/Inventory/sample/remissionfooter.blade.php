<table width='100%' bgcolor="#FAFAFA">
    <tr>
        <td width='20%' >Observaciones</td>
        <td width='30%'><?php echo $client["observations"]; ?></td>
        <td>
            <table>
                <tr>
                    <td width='240px' >Total Remisión</td>
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
                    <td><b>Total Pedido</b></td>
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
</body>
</html>
