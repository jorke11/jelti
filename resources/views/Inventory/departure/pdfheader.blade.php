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
    <br>

    <table align='left'  width='100%'>
        <tr>
            <td width="20%" rowspan="2">
                <img src="{{public_path()}}/images/logo2.png" width="18%">
            </td>
            <td><br><br><br><strong style="font-size: 22px">SUPERFUDS SAS</strong><br>NIT 900 703 907-7<br>Calle 67 # 5-20 Tel: 310 2516486<br>Bogotá Colombia<br>E-mail: info@superfuds.com.co</td>
        </tr>
        <tr>
                       <td class="font-title">Resolución DIAN 18762003299025 del 17/05/2017
                <br>Numeración Autorizada 3001 al 3999 por computador Actividad Economica 4631 Tarifa Ica 4.14 x 1000</td>
        </tr>
    </table>

    <table width='100%'>
        <tr>
            <td class="font-subtitle" width="60%">Factura a nombre de:</td>
            <td class="font-invoice" width="40%">Factura de venta: <?php echo $invoice ?></td>
        </tr>
    </table>
    <table>
        <tr>
            <td>
                <table border='0'>
                    <tr>
                        <td class="font-detail">Cuenta</td>
                        <td class="font-detail-cont" width="38%"><?php echo $client["business"]; ?></td>
                        <td class="font-detail">Emisión</td>
                        <td class="font-detail-cont"><?php echo $client["emition"]; ?></td>
                    </tr>
                    <tr>
                        <td class="font-detail">Razón Social</td>
                        <td class="font-detail-cont"><?php echo $client["business_name"]; ?></td>
                        <td class="font-detail">Vencimiento</td>
                        <td class="font-detail-cont"><?php echo $client["expiration"]; ?></td>
                    </tr>
                    <tr>
                        <td class="font-detail">Nit</td>
                        <td class="font-detail-cont"><?php echo $client["document"]; ?></td>
                        <td class="font-detail">Vendedor</td>
                        <td class="font-detail-cont"><?php echo $client["responsible"]; ?></td>
                    </tr>
                    @if($client["address_invoice"]!=null)
                    <tr>
                        <td class="font-detail">Dirección Facturación</td>
                        <td class="font-detail-cont"><?php echo $client["address_invoice"] . ", " . $client["city_inv"]; ?></td>
                    </tr>
                    @endif
                    @if($client["address_send"]!=null)
                    <tr>
                        <td class="font-detail">Dirección Envío</td>
                        <td class="font-detail-cont"><?php echo $client["address_send"] . ", " . $client["city_send"]; ?></td>
                    </tr>
                    @endif
                    <tr>
                        <td class="font-detail">Telefono</td>
                        <td class="font-detail-cont"><?php echo $client["phone"]; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <?php
//    echo "asd";exit;
    ?>

