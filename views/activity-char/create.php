<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\development\models\DevelopmentActivityChar */

$this->title = Yii::t('app', 'เพิ่มลักษณะกิจกรรม');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ลักษณะกิจกรรม'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

  <div class="development-activity-char-create">


      <?=
      $this->render('_form', [
          'model' => $model,
      ])
      ?>

  </div>
