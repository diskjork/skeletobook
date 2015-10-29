<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/activate-account', 
    'token' => $user->account_activation_token]);
?>

<h1 align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif;">Confirmación de cuenta <img src="https://www.iconexperience.com/_img/v_collection_png/512x512/shadow/mail_ok.png" alt="Vende tu auto" width="30%" height="140" style="display: block;" /></h1>

	<p style="padding: 40px 0 30px 30px; font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 21px; font-weight: bold;">Hola:      <?= Html::encode($user->username) ?> , <?= Html::a('Click para activar la cuenta', $resetLink) ?>    </p>
				
