<?php

//use yii\helpers\Html;
//use yii\widgets\ActiveForm;
// use kartik\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\widgets\Select2;
use kartik\helpers\Html;
use yii\helpers\Url;
use andahrm\datepicker\DatePicker;
use kartik\widgets\Typeahead;
use andahrm\development\models\DevelopmentProject;
use kartik\grid\GridView;
use andahrm\development\models\DevelopmentPerson;
use andahrm\development\models\DevelopmentActivityChar;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model andahrm\development\models\DevelopmentProject */
/* @var $form yii\widgets\ActiveForm */
$context = $this->context->action;
$action = Yii::$app->controller->action->id;

$id = $model->isNewRecord ? 'new' : $model->id;
?>

<div class="development-project-form">

    <?php
    $formOptions = [];
  //$formOptions['options'] = ['enctype' => 'multipart/form-data'];
  if($formAction !== null)  $formOptions['action'] = $formAction;
  ?>
    <?php $form = ActiveForm::begin($formOptions); ?>


    
    
    <?= $form->field($model, 'title')->textInput(); ?>
    
    <div class="row">
        <?= $form->field($model, 'start', [
            'options' => [
                'class' => 'form-group col-sm-6' 
            ]  
        ])->widget(DatePicker::className());
        ?>
        <?= $form->field($model, 'end', [
            'options' => [
                'class' => 'form-group col-sm-6' 
            ]  
        ])->widget(DatePicker::className());
        ?>
    </div>
    
    <?= $form->field($model, 'place')->textInput()->widget(Typeahead::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => ['highlight' => true],
        'dataset' => [
                [
                'local' => DevelopmentProject::getPlaceList(),
                'limit' => 10,
                'remote' => Url::to('index')
            ]
        ]
    ]); ?>
    
    <div class="row">
    <?= $form->field($model, 'responsible_agency', [
            'options' => [
                'class' => 'form-group col-sm-8' 
            ]  
        ])->textInput()->widget(Typeahead::classname(), [
        'options' => ['placeholder' => 'Filter as you type ...'],
        'pluginOptions' => ['highlight' => true],
        'dataset' => [
                [
                'local' => DevelopmentProject::getResponsibleAgencyList(),
                'limit' => 10,
                'remote' => Url::to('index')
            ]
        ]
    ]); ?>
    
    <?= $form->field($model, 'isin_agency', [
            'options' => [
                'class' => 'form-group col-sm-4' 
            ]  
        ])->inline()->radioList(DevelopmentProject::getItemIsinAgency()); ?>
    </div>
    
    
    <?= $form->field($model, 'budget_status')->inline()->radioList(DevelopmentProject::getItemBudgetStatus()); ?>
    
    <div class="row">
        <?= $form->field($model, 'budget', [
            'options' => [
                'class' => 'form-group col-sm-6' 
            ]  
        ])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'budget_revenue', [
            'options' => [
                'class' => 'form-group col-sm-6' 
            ]  
        ])->textInput(['maxlength' => true]) ?>
    </div>
    
   
    


    <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm', 'Create') : Yii::t('andahrm', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','name'=>'save','value'=>1]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
///Surakit
if($formAction !== null) {
  $eer = Yii::t('app','Select');
$js[] = <<< JS
$(document).on('submit', '#{$form->id}', function(e){
  e.preventDefault();
  var form = $(this);
  var formData = new FormData(form[0]);
  // alert(form.serialize());
  
  $.ajax({
    url: form.attr('action'),
    type : 'POST',
    data: formData,
    contentType:false,
    cache: false,
    processData:false,
    dataType: "json",
    success: function(data) {
      if(data.success){
        callbackProject(data.result,"#{$form->id}");
      }else{
        alert('Fail');
        console.log(data);
      }
    }
  });
});
JS;

$this->registerJs(implode("\n", $js));
}
?>
