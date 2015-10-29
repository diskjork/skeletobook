<style type="text/css">
    #encabezado{
        width: 100%;
        height: 180px;
    }
    #logo{
        width: 160px;
        height: 150px;
        margin: 10px;
    }
    #datosSocio{
        width: 550px;
        height: 150px;
        margin-top: -150px;
        margin-left: 200px;
    }
    #cuponAnual {
        position:absolute;
        text-align:center;
        width:100%;
        height:15px;
        z-index:4;
        top: 220px;
    }
    #cupones{
        width: 100%;
        height: 200px;
        color: black;
        border-top-style: solid;
        border-bottom-style: solid;
        border-width: thin;
    }
    #textoMedioPago{
        width: 100%;
        height: 30px;
        border-bottom-style: solid;
        border-width: thin;
    }
    #logoInferior{
        width: 100%;
        height: 120px;
        margin-left: 120px;
    }
    #medioDePago{
        width: 100%;
        height: 200px;
    }
    #apDiv1 {
        position: absolute;
        margin-top:50px;
        margin-left:100px;
        width: 206mm;
        height: 150mm;
        z-index: 5;
        color: black;
        border-style: solid;
        border-width: medium;

    }
</style>
<div id="apDiv1">
    <div id="encabezado">
        <div id="logo"><img src=<?php echo Yii::$app->request->baseUrl."/images/logo_v1.png"?> alt='logo' width='156' height='149'/></div>
        <div id="datosSocio">
            <h2 style="text-align:center;">CUPON DE PAGO MUNDO MOTOR</h2>
            Titulo publicacion: <?= $model->aviso->titulo;?><br>
            <?php
            $fecha = new \DateTime($model->expira);
            $model->expira=$fecha->format('d/m/Y');
            ?>
            Vencimiento de pago: <?=  $model->expira?><br>
            Importe: <?= "$ ".$model->precio;?><br>
            Duración: <?= $model->publicacion->duracion.' dias.' ?><br>
            Codigo de pago: <?= $model->codigodepago ?>

        </div>
    </div>
    <div id="cupones">
        <div id="cuponAnual">
            <img src="https://www.cuentadigital.com/barras.php?codigo=<?php echo $model->codigodepago;?>" height="70px" width="400px">
        </div>
    </div>
    <div id="medioDePago">
        <div id="textoMedioPago">
            <p style="text-align:center;"><strong>Los medios de pago habilitados son Rapipago y Pago Facil</strong></p>
        </div>
        <div id="logoInferior"><img src=<?php echo Yii::$app->request->baseUrl."/images/mediospago.png"?> alt='logo'/></div>
    </div>
</div>
