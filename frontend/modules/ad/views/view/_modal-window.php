<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 18.02.2016
 * Time: 0:52
 */
/* @var $modalWindow bool */
/* @var $id integer */

use yii\bootstrap\Modal;
use yii\widgets\Pjax;

Pjax::begin([
    'id' => 'modal-block'
]);

if(isset($modalWindow)):

    $js=<<<JS
    $("#modal-block").on("pjax:complete", function() {
        $("#button-open-modal-$id").attr("tabindex",-1).focus();
     });
JS;
    $this->registerJS($js);

    $js=<<<JS
        $("#modal-element").modal("show");
JS;
$this->registerJS($js);
Modal::begin([
    'size' => 'modal-lg',
    'id' => 'modal-element',
    'header' => '<h2>Hello world</h2>',
    'toggleButton' => false,
]);

echo 'Say hello...';

Modal::end();


endif;
Pjax::end();

