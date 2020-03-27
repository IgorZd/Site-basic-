<?php

use yii\helpers\Html;
use yii\grid\GridView;
use phpnt\exportFile\ExportFile;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo ExportFile::widget([
        'model' => 'app\models\UserSearch',
        'title' => 'Users',
        'queryParams' => Yii::$app->request->queryParams,
        'getAll' => true,
        'csvCharset' => 'Windows-1251',
        'buttonClass' => 'btn btn-primary',
        'blockClass' => 'pull-left',
        'blockStyle' => 'padding: 5px',
        'xls' => true,
        'csv' => true,
        'word' => true,
        'html' => true,
        'pdf' => true,
        'xlsButtonName' => Yii::t('app', 'MS Excel'),
        'csvButtonName' => Yii::t('app', 'CSV'),
        'wordButtonName' => Yii::t('app', 'MS Word'),
        'htmlButtonName' => Yii::t('app', 'HTML'),
        'pdfButtonName' => Yii::t('app', 'PDF')
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'email:email',
            'password',
            'isAdmin',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
