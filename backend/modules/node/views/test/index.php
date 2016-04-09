<?php
/* @var $this yii\web\View */
use backend\modules\node\assets\NodeAsset;

NodeAsset::register($this);

Yii::$app->assetManager->forceCopy = true;
?>
<h1>test/index</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
