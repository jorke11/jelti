<table width='100%' bgcolor="#FAFAFA">
    <tr>
        <td width='20%' >Observaciones</td>
        <td width='30%'><?php echo $client["observations"]; ?></td>
        <td>
            <table>

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
                <tr>
                    <td width='240px' ><b>Total Factura</b></td>
                    <td><?php echo $totalInvoice; ?></td>
                </tr>
                <?php
                if ($tax5 > 0) {
                    ?>
                    <tr>
                        <td>Iva 5%</td>
                        <td><?php echo "$ " . number_format((round($tax5)), 0, ',', '.'); ?></td>
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

                <?php
                if ($exept > 0) {
                    ?>
                    <tr>
                        <td>Exento</td>
                        <td><?php echo "$ " . number_format((round($exept)), 0, ',', '.'); ?></td>
                    </tr>
                    <?php
                }
                ?>

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
        <td><?php echo $textTotal . ', Total artículos: ' . count($detail) . ' Total de Items: ' . $quantity; ?></td>
    </tr>
</table>
<table >
    <tr>
        <td class="resolution">La presente Factura se asemeja en todos sus efectos a un Título Valor Art. 1 Ley 1231 de 2008. En caso de
            mora se causarán intereses a la tasa máxima legal estipulada por la ley, o en el respectivo contrato (conforme al art. 884 del Código de Comercio).</td>
    </tr>
    <tr>
        <td class="resolution">No somos grandes Contribuyentes, no somos Autorretenedores.</td>
    </tr>
    <tr>
        <td class="resolution">Favor hacer transferencia a Cuenta Corriente Bancolombia # 72951229710 a nombre de SuperFuds S.A.S.</td>
    </tr>
    <tr>
        <td class="resolution"><b>Si el pago es por consignacion fuera de Bogota, favor agregar al valor al final $11.000 pesos.</b></td>
    </tr>
</table>
<table style="padding-bottom: 10%;">
    <tr>
        <td class="resolution"><b>Información Importante:</b></td>
    </tr>
    <tr>
        <td class="resolution"><i>Cualquier inconformidad con el pedido debe ser notificada en la guía de la transportadora al momento de recibir la mercancía / o a SuperFüds en los siguiente 3 días hábiles, de lo contrario SuperFüds no puede hacerse responsable debido a la naturaleza de los productos. En dado caso de encontrar inconsistencias favor NO recibir la mercancía
            Favor revisar Políticas de Devolución</i></td>
    </tr>
</table>
