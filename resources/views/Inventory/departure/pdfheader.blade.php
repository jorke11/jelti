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

<table align='center'  width='100%' border='1'>
    <tr>
        <td class="space-title">
            <table>
                <tr>
                    <td width='100px'></td>
                    <td><img src="{{public_path()}}/assets/images/logo.png" width="10%"></td>
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
                    <td class="font-detail-cont"><?php echo $client["address_invoice"]."<br>".$client["city"]; ?></td>
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

