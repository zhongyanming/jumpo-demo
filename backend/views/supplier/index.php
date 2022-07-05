<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SupplierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $statusOptions array 状态选项 */
/* @var $idRangeTags array id范围标识选项 */

$this->title = '供应商';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/js/supplier.js?time='.time(), [
    'depends' => [
        \yii\web\JqueryAsset::className()
    ]
]);
?>
<div class="supplier-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- 全选提示  -->
    <div id="select_all_notice" class="alert alert-info" style="display: none">
        <strong>注意!</strong>
    </div>

    <!-- 搜索栏 -->
    <?= $this->render('_search', ['model' => $searchModel, 'statusOptions' => $statusOptions, 'idRangeTags' => $idRangeTags]); ?>

    <div class="row" style="padding: 15px">
        <?= Html::a('添加', ['create'], ['class' => 'btn btn-success col-1', 'style' => 'margin-right:10px']) ?>
        <?= Html::button('导出', ['class' => 'btn btn-primary col-1', 'data-toggle' => 'modal', 'data-target' => "#exportModal"])?>
    </div>

    <?= GridView::widget([
        'id' => 'grid',
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => '\yii\grid\CheckboxColumn',
            ],
            'id',
            'name',
            'code',
            't_status'
        ]
    ]); ?>

    <!-- 是否选中所有过滤行  -->
    <input type="text" id="selected_all_page" value="0" disabled style="display: none">

    <!-- 当前页面容量 -->
    <input type="text" id="pageSize" value="<?=$dataProvider->pagination->pageSize?>" disabled style="display: none">
    <!-- 数据总量 -->
    <input type="text" id="total" value="<?=$dataProvider->pagination->totalCount?>" disabled style="display: none">

    <?= $this->render('_modal')?>
</div>
