<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ประเภทสินค้า';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-type-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a('<i class="fa fa-plus"></i> เพิ่มประเภทสินค้า', ['create'], ['class' => 'btn btn-default']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'product_type',
            [
                'class' => 'kartik\grid\ActionColumn',
                'header' => 'ตัวเลือก',
                'viewOptions' => ['title' => 'ดูข้อมูล', 'data-toggle' => 'tooltip'],
                'updateOptions' => ['title' => 'แก้ไข', 'data-toggle' => 'tooltip'],
                'deleteOptions' => ['title' => 'ลบ', 'data-toggle' => 'tooltip'],
                'headerOptions' => ['class' => 'kartik-sheet-style'],
            ],
        ],
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'responsive' => true,
        'pjax' => true, // pjax is set to always true for this demo
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => "<i class='fa fa-building'></i> " . $this->title,
        ]
    ]);
    ?>

</div>
