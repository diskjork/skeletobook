<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 
    'token' => $user->password_reset_token]);
?>

<h1 align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif;">Generación de contraseña <img src="https://d2jttyr2t7ddzk.cloudfront.net/password.png" alt="Vende tu auto" width="30%" height="160" style="display: block;" /></h1>

<p style="padding: 40px 0 30px 30px; font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 21px; font-weight: bold;">Hola:      <?= Html::encode($user->username) ?> , <?= Html::a('Click para generar contraseña', $resetLink) ?>    </p>