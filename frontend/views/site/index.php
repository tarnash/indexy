<?php
/* @var $dataProvider yii\data\ArrayDataProvider */
/* @var $form SearchForm */


use common\models\forms\SearchForm;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;


$this->title = 'Search';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $activeForm = ActiveForm::begin([
                'action' => ['site/index'],
                'validateOnSubmit' => true,
                'validateOnChange' => true,
                'validateOnBlur' => false,
                'validateOnType' => false,
                'id' => 'search-form',
                'options' => [
                    'method' => 'POST',
                    'class' => '',
                ],
                'fieldConfig' => [
                    'options' => ['class' => 'mb-3'],
                    'inputOptions' => ['class' => 'form-control'],
                    'errorOptions' => ['class' => 'invalid-feedback d-block'],
                ],
            ]); ?>
            <div class="mb-3">
                <?= $activeForm->field($form, 'query')->textInput([
                    'autofocus' => true,
                ])->label(false); ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>

<?=GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => '_id',
            'label' => 'ID',
        ],
        [
            'attribute' => 'title',
            'label' => 'Заголовок',
            'format' => 'text',
        ],
        [
            'attribute' => 'content',
            'label' => 'Содержимое',
            'format' => 'text',
        ],
        [
            'attribute' => 'created_at',
            'label' => 'Создано',
            'format' => ['date', 'php:d.m.Y H:i'],
        ],
    ],
]);?>

