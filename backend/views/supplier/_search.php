<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SupplierSearch */
/* @var $form yii\widgets\ActiveForm */
/* @var $statusOptions array 状态选项 */
/* @var $idRangeTags array id范围标识选项 */
?>

<div class="supplier-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'float-left w-100', 'style'=>'margin-top:10px;margin-bottom:20px']
    ]); ?>

    <div class="row">
        <div class="col">
            <label class="w-100">ID</label>
            <div class="input-group">
                <?=Html::dropDownList('SupplierSearch[id_range_tag]', $_GET['SupplierSearch']['id_range_tag'] ?? null, $idRangeTags, ['class' => 'form-control col-3'])?>
                <?=Html::input('text', 'SupplierSearch[id]', $_GET['SupplierSearch']['id'] ?? null, ['class' => 'form-control'])?>
            </div>
        </div>

        <?= $form->field($model, 'name', ['options' => ['class' => 'col']]) ?>

        <?= $form->field($model, 'code', ['options' => ['class' => 'col']]) ?>

        <?= $form->field($model, 't_status', ['options' => ['class' => 'col']])->dropDownList($statusOptions, ['prompt' => '全部']) ?>
    </div>

    <div class="row" style="padding: 15px 15px 0">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary col-1']) ?>
        <?= Html::a('重置', ['index'], ['class' => 'btn btn-outline-secondary col-1', 'style' => 'margin-left:10px']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
