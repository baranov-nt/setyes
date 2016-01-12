<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 05.11.2015
 * Time: 8:35
 */

/* @var $modelUserProfile \common\models\UserProfile */
?>
<div class="row">
    <div class="col-md-3">
        <?php
        foreach($modelUserProfile->imagesOfObjects as $one):
            ?>
            <img src="<?= Yii::$app->urlManager->createAbsoluteUrl('').'images/'.$one->image->path_small_image ?>" class="col-md-12"/>
            <?php
        endforeach;
        ?>
    </div>
    <div class="col-md-9">
        <div class="col-md-12"><?= $modelUserProfile->first_name ?></div>
        <div class="col-md-12"><?= $modelUserProfile->second_name ?></div>
        <div class="col-md-12"><?= $modelUserProfile->middle_name ?></div>
    </div>
</div>

