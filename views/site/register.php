<?php

use yii\widgets\ActiveForm;
use yii\bootstrap5\Html;
?>

<h1>Register</h1>

<?php

$form = ActiveForm::begin([
    "action" => ["user/store"],
    "method" => "post",
    'id' => 'register-form',
]); ?>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <?= Html::input('text', 'User[name]', '', ['class' => 'form-control']) ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <?= Html::input('text', 'User[email]', '', ['class' => 'form-control']) ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <?= Html::input('password', 'User[password]', '', ['class' => 'form-control']) ?>
        </div>

        <div class="form-group">
            <div>
                <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>