<?php

/** @var yii\web\View $this */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Rate my fruit';
?>
<div class="site-index">
    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Rate Your Favorite Fruits</h1>
        <p class="lead">Discover, rate, and review the best fruits around the world.</p>

        <?php $form = ActiveForm::begin([
            'action' => ['fruit/search'],
            'method' => 'get',
            'options' => [
                'class' => 'mb-3 mx-auto',
                'style' => 'max-width: 600px;',
            ],
        ]); ?>

        <div class="input-group mb-3">
            <?= Html::textInput('query', '', [
                'class' => 'form-control',
                'placeholder' => 'Search for a fruit...',
                'required' => true
            ]) ?>
            <div class="input-group-append">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

        <a href="#top-rated" class="btn btn-outline-primary mt-3">Explore Top-Rated Fruits</a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h4 class="mb-3">Join the Community of Fruit Enthusiasts</h4>
            <p>Welcome to <strong><?= Yii::$app->name ?></strong> – your ultimate destination to explore a wide variety of fruits from around the world. Whether you're a fruit connoisseur or just looking to discover new flavors, our platform provides comprehensive information, authentic user reviews, and ratings to help you make informed choices.</p>
            <?= Html::a("Join Now and Start Rating!", ['site/register'], ['class' => 'btn btn-primary btn-lg mt-3 mb-3']) ?>
        </div>

        <div id="carouselExampleFade" class="carousel slide carousel-fade col-md-6" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="<?= Url::to('@web/images/blueberries.jpg') ?>" class="d-block w-100" alt="First-carousel">
                </div>
                <div class="carousel-item">
                    <img src="<?= Url::to('@web/images/raspberries.jpg') ?>" class="d-block w-100" alt="Fifth-carousel">
                </div>
                <div class="carousel-item">
                    <img src="<?= Url::to('@web/images/grapes.jpg') ?>" class="d-block w-100" alt="Third-carousel">
                </div>
                <div class="carousel-item">
                    <img src="<?= Url::to('@web/images/orange.jpg') ?>" class="d-block w-100" alt="Fourth-carousel">
                </div>
                <div class="carousel-item">
                    <img src="<?= Url::to('@web/images/currants.jpg') ?>" class="d-block w-100" alt="Second-carousel">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <div class="py-5" id="top-rated">
        <h2 class="text-center mb-4">Top-Rated Fruits</h2>
        <div class="row">
            <?php foreach ($topFruits as $topFruit) {
                echo "<div class='col-md-4'>
                        <div class='card mb-2'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$topFruit['name']}</h5>
                                <h6 class='card-subtitle mb-2 text-muted'>{$topFruit['rating']} stars</h6>
                                <p class='card-text'>{$topFruit['nutritions']['calories']} calories per 100g</p>" .
                    Html::a("View Details", ['fruit/show', 'id' => $topFruit['id']], ['class' => 'btn btn-primary'])
                    . "</div>
                        </div>
                    </div>";
            } ?>
        </div>
    </div>

    <div class="py-5">
        <h2 class="text-center mb-4">Latest Reviews</h2>
        <ul class="list-group">
            <?php foreach ($latestReviews as $review) { ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?= $review['user']['name'] ?> reviewed <?= $review['fruit']['name'] ?>
                    <span class="badge <?= $review['rating'] > 2 ? 'bg-success' : ($review['rating'] > 1 ? 'bg-warning' : 'bg-danger') ?> rounded-pill"><?= $review['rating'] ?>
                        stars
                    </span>
                </li>
            <?php } ?>
        </ul>
    </div>

    <div class="container-fluid bg-primary text-white text-center py-5">
        <h2>Join Our Community of Fruit Lovers</h2>
        <p class="lead">Rate your favorite fruits and share your reviews with the world!</p>
        <?= Html::a("Sign Up Now", ['site/register'], ['class' => 'btn btn-light btn-lg']) ?>
    </div>
</div>