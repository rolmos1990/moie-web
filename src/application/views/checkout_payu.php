<html>
    <head>
        <script type="text/javascript" src="/js/jquery.js"></script>
    </head>
    <body>
        <?php
        if($sandbox){
            $gateway = 'https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/';
            $api_key = '4Vj8eK4rloUd272L48hsrarnUA';
            $merchant_id = '508029';
            $account_id = '512321';
        }else{
            $gateway = 'https://checkout.payulatam.com/ppp-web-gateway-payu';
            /* Cuenta Ramiro */
            /*$api_key = '7p1VxWK2flmOCEjBc2QGWm5PG3';
            $merchant_id = '628725';
            $account_id = '631043';*/

            /* Cuenta Lucy */
            $api_key = 'ch3fD75b0M4WiytpFw6w1VaAL6';
            $merchant_id = '672991';
            $account_id = '675663';
        }
        
        $paymentMethods = "VISA,MASTERCARD,AMEX,DINERS,CODENSA";
        $referencia = $id_venta . '-' . time();
        $string_signature = $api_key . '~' . $merchant_id . '~' . $referencia . '~' . $monto . '~' . 'COP' . '~' . $paymentMethods;
        $signature = md5($string_signature);
        ?>
        <form id="checkout" method="post" action="<?=$gateway;?>">
            <input name="merchantId" type="hidden" value="<?=$merchant_id;?>" >
            <input name="accountId" type="hidden" value="<?=$account_id;?>" >
            <input name="description" type="hidden" value="Pedido Lucymodas <?=$id_venta;?>" >
            <input name="referenceCode" type="hidden" value="<?=$referencia;?>" >
            <input name="amount" type="hidden" value="<?=$monto;?>" >
            <input name="tax" type="hidden" value="0" >
            <input name="taxReturnBase" type="hidden" value="0" >
            <input name="currency" type="hidden" value="COP" >
            <input name="signature" type="hidden" value="<?=$signature;?>" >
            <input name="buyerFullName" type="hidden" value="<?=$nombre_cliente;?>" >
            <input name="buyerEmail" type="hidden" value="" >
            <input name="buyerDocument" type="hidden" value="<?=$ci_cliente;?>" >
            <input name="mobilePhone" type="hidden" value="<?=$telefono_cliente;?>" >
            <input name="kilogramWeight" type="hidden" value="2" >
            <input name="shipmentPackageHeightDimension" type="hidden" value="10" >
            <input name="shipmentPackageWidthDimension" type="hidden" value="25" >
            <input name="shipmentPackageLengthDimension" type="hidden" value="20" >
            <input name="shippingAddress" type="hidden" value="<?=$direccion;?>" >
            <input name="shippingAddress2" type="hidden" value="<?=$ciudad;?>" >
            <input name="responseUrl" type="hidden" value="<?= base_url() ?>/site/thanks" >
            <input name="confirmationUrl" type="hidden" value="<?= base_url() ?>/payu/confirmation.php" >
            <input name="paymentMethods" type="hidden" value="<?=$paymentMethods;?>" >

            <?php if($sandbox){ ?>
                <input name="test" type="hidden" value="1" >
            <?php } ?>
        </form>
    </body>

    <script type="text/javascript">
        $('#checkout').submit();
    </script>
</html>
