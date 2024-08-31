<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

?>

<div class="mt-4">
    <div class="d-flex justify-flex-start align-items-start">
        <h1 class="mb-4 me-2"><?= $fruit['name'] ?>
        </h1><span class="badge bg-success rounded-pill"><?= $fruit['rating'] ?> stars</span>
    </div>
    <div class="row"></div>
    <ul class="list-group col-md-6">
        <li class="list-group-item d-flex justify-flex-start align-items-center is-hoverable-light-blue">
            <span class="fw-500 me-2">Family:</span> <?= $fruit['family'] ?>
        </li>
        <li class="list-group-item d-flex justify-flex-start align-items-center is-hoverable-light-blue">
            <span class="fw-500 me-2">Order:</span> <?= $fruit['order'] ?>
        </li>
        <li class="list-group-item d-flex justify-flex-start align-items-center is-hoverable-light-blue">
            <span class="fw-500 me-2">Genus:</span> <?= $fruit['genus'] ?>
        </li>

        <li class="list-group-item fw-500 is-bg-light-grey">
            Nutritions per 100g
        </li>

        <?php
        foreach ($fruit['nutritions'] as $nutrition => $value) {
            echo "<li class='list-group-item d-flex justify-content-start align-items-center ps-5 is-hoverable-light-green'>
                <span class='fw-500 me-1'>-</span> $nutrition: $value
            </li>";
        }
        ?>
    </ul>
</div>

<!-- Comment Section -->
<div class="mt-5 row">
    <h3 class="mb-4">Comments</h3>
    <?php if (!Yii::$app->user->isGuest) { ?>
        <div class="comment-form">
            <?php $form = ActiveForm::begin([
                "action" => ["comment/store"],
                "method" => "post",
                'id' => 'comment-form',
            ]); ?>

            <input type="hidden" name="api_fruit_id" value="<?= $fruit['id'] ?>">
            <input type="hidden" name="user_id" value="<?= Yii::$app->user->id ?>">

            <div class="mb-3">
                <textarea class="form-control" id="text" name="text" rows="3" placeholder="Write your comment here..." required></textarea>
            </div>
            <div class="mb-3 col-md-2">
                <label for="rating" class="form-label">Your Rating</label>
                <input type="range" class="form-range" id="rating" name="rating" min="1" max="5" step="1" value="3" oninput="this.nextElementSibling.value = this.value">
                <output>3</output>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Submit Comment', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    <?php } else { ?>
        <p>To comment, you need to be logged in. <a href="<?= \yii\helpers\Url::to(['site/login']) ?>">Log in here</a>.</p>
    <?php } ?>

    <!-- Display Comments -->
    <ul class="list-group">
        <?php if (empty($fruit['comments'])) { ?>
            <div class="alert alert-secondary">
                <h4 class="alert-heading">No comments yet</h4>
                <p>Be the first to comment on this fruit!</p>
            </div>
        <?php } else { ?>
            <?php foreach ($fruit['comments'] as $comment) { ?>
                <li class="list-group-item">
                    <strong><?= Html::encode($comment['user']['name'], ENT_QUOTES, 'UTF-8') ?>:</strong>
                    <?= Html::encode($comment['text'], ENT_QUOTES, 'UTF-8') ?>
                    <div class="mt-2">
                        <span class="text-warning">
                            <?= str_repeat('★', $comment['rating']) ?>
                            <?= str_repeat('☆', 5 - $comment['rating']) ?>
                        </span>
                    </div>
                </li>
            <?php } ?>
        <?php } ?>

    </ul>
</div>