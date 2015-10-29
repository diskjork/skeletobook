<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\helpers\Url;



/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */

AppAsset::register($this);

?>
<?php $this->beginPage() ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
   
    <?php $this->head() ?>
</head>
<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
        <tr>
            <td style="padding: 10px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                    <tr>
                        <td align="lefth" bgcolor="#70bbd9" width="300" height="5%" style="padding: 40px 0 30px 30px; color: #fff; font-size: 20px; line-height: 5px ; font-weight: bold; font-family: Open Sans, Helvetica, Arial, sans-serif;">
                            <b>AutoBooK</b>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 30px 30px 30px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="padding: 20px 0 30px 0; color: #153643; font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                         <?php $this->beginBody() ?>
                                        <?= $content ?>
                                        <?php $this->endBody() ?>
                              
                                    </td>
                                </tr>
                                <tr>
                                    <td align="lefth" style="color: #153643; font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 18px;">
                                        <b>Gracias por registrarte en nuestro sitio, por favor haz click en el link de arriba! </b>
                                    </td>
                                    
                                </tr>

                                <tr>

                                    <td>
 <hr style="border: 2px solid #999999; border-radius: 300px/10px; height: 1px; text-align: center;" />
                                        <table border="0" cellpadding="10px" cellspacing="0" width="100%">
                                            <tr>
                                                <td width="260" valign="top">

                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <a href="<?=Yii::$app->urlManager->createAbsoluteUrl('aviso/index')?>" style="color: #ffffff;">
                                                                <img src="http://media.telemundo47.com/images/tlmd_vendetucarroonline.jpg" alt="Vende tu auto" width="100%" height="140" style="display: block;" />
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" style="padding: 10px 0 0 0; color: #153643; font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 18px; line-height: 20px;">
                                                               <a href="<?=Yii::$app->urlManager->createAbsoluteUrl('aviso/index')?>" style="color:#153643;"><font color="#153643">Publica tu auto </font></a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style="font-size: 0; line-height: 0;" width="20">
                                                    &nbsp;
                                                </td>
                                                <td width="260" valign="top">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <a href="<?=Yii::$app->urlManager->createAbsoluteUrl('aviso/index')?>" style="color: #ffffff;">
                                                                <img src="http://autologia.com.mx/wp-content/uploads/2014/11/Compra-de-auto.jpg" alt="Encontrá y comprá tu auyo ya!" width="100%" height="140" style="display: block;" />
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" style="padding: 5px 0 0 0; color: #153643; font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 18px; line-height: 20px;">
                                                                
                                                                <a href="<?=Yii::$app->urlManager->createAbsoluteUrl('aviso/index')?>" style="color:#153643;"><font color="#153643">Compra tu auto </font></a> 
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#999999" style="padding: 30px 30px 30px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #ffffff; font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px;" width="75%">
                                        &reg; It San Rafael, Interprise 2015<br/>
                                        <a href="#" style="color: #ffffff;"><font color="#ffffff">Suscribete</font></a> 
                                    </td>
                                    <td align="right" width="25%">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                                    <a href="http://www.twitter.com/" style="color: #ffffff;">
                                                        <img src="http://cdn1.blocksassets.com/assets/aopen/aopen/v6eLGoU8zSEnWrA/web.Twitter-50x50.png" alt="Twitter" width="38" height="38" style="display: block;" border="0" />
                                                    </a>
                                                </td>
                                                <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                                <td style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                                    <a href="https://www.facebook.com/" style="color: #ffffff;">
                                                        <img src="http://1.bp.blogspot.com/-KGviaJsnPoQ/UgW5AADtUGI/AAAAAAAAAGw/OzXo4d-jEuk/s210/icon-facebook-50x50.png" alt="Facebook" width="38" height="38" style="display: block;" border="0" />
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>


    
</body>
</html>
<?php $this->endPage() ?>