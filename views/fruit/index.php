<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class=" py-5">
    <h2 class=" mb-4">Fruit List</h2>

    <form method="get" action="<?= Url::to(['fruit/index']) ?>" class="mb-4">
        <div class="d-flex justify-flex start">
            <div class="me-2">
                <label for="sort-by">Sort By:</label>
                <?= Html::dropDownList('sort', Yii::$app->request->get('sort', false), [
                    'name' => 'Name',
                    'rating' => 'Rating'
                ], [
                    'id' => 'sort-by',
                    'class' => 'form-select',
                    'onchange' => 'this.form.submit()'
                ]) ?>
            </div>

            <div class="me-2">
                <label for="sort-order">Order:</label>
                <?= Html::dropDownList('order', Yii::$app->request->get('order', false), [
                    'asc' => 'Ascending',
                    'desc' => 'Descending'
                ], [
                    'id' => 'sort-order',
                    'class' => 'form-select',
                    'onchange' => 'this.form.submit()'
                ]) ?>
            </div>

            <!-- <div class="align-self-end">
                <?= Html::submitButton('Apply', ['class' => 'btn btn-primary']) ?>
            </div> -->
        </div>
    </form>

    <ul class="list-group">
        <?php foreach ($fruits as $fruit) { ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong> <?= Html::a(Html::encode($fruit['name']), ['fruit/show', 'id' => $fruit['id']]) ?></strong>
                    <p class="mb-0 text-muted">Calories: <?= $fruit['nutritions']['calories'] ?> kcal per 100g</p>
                </div>
                <?php if ($fruit['rating'] !== 0) { ?>
                    <span class="badge bg-success rounded-pill">
                        <?= $fruit['rating'] . ' stars' ?>
                    </span>
                <?php } else { ?>
                    <span class="badge bg-secondary rounded-pill">
                        Not rated yet
                    </span>
                <?php } ?>
            </li>
        <?php } ?>
    </ul>
</div>