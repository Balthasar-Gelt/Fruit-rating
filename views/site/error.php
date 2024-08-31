<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = 'Page Not Found';
?>

<div class="container py-5 text-center">
    <h1 class="display-4">Oops! Page Not Found</h1>
    <p class="lead">It seems like you're a bit lost. Unfortunately, the page you're looking for doesn't exist.</p>

    <!-- Fruit Image -->
    <div class="my-4">
        <img src="<?= Yii::getAlias('@web') ?>/images/dell-y.webp" alt="Fruit Image" class="img-fluid" style="max-width: 300px;">
    </div>

    <p>While you're here, how about enjoying some fruit? 🍎🍌🍇</p>

    <!-- Back to Home Button -->
    <a href="<?= Yii::$app->homeUrl ?>" class="btn btn-primary mt-3">Back to Home</a>
</div>