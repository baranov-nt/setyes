<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.11.2015
 * Time: 11:17
 */
use backend\assets\BootstrapAsset;
use yii\helpers\Html;
use common\widgets\ScrollToTop\ScrollToTop;

BootstrapAsset::register($this);
?>
<h1>Bootstrap дополнения</h1>
<div class="row">
    <div class="col-md-12">
        <h3>Font Awesome</h3>
        <p>
            <span class="fa fa-rotate-right gly-spin-right"></span>
            <span class="fa fa-rotate-left  gly-spin-left"></span>
        </p>
    </div>
    <div class="col-md-12">
        <h3>Bootstrap Confirmation</h3>
        <p>
            <?php
            // все свойства тут https://ethaizone.github.io/Bootstrap-Confirmation/#
            echo '<span class="btn-ajax-wrap">' . Html::a('<i class="glyphicon glyphicon-refresh"></i>', str_replace('delete', 'restore', 'confirm'), [
                    'class'                 => 'btn btn-xs btn-info ',
                    'action'                => 'translation-restore',
                    'data-toggle'           => 'confirmation',
                    'data-singleton'        => 'true',
                    'data-placement'        => 'right',
                    'data-btn-ok-lable'     => 'Yes',
                    'data-btn-ok-class'     => 'btn-xs btn-success',
                    'data-btn-cancel'       => 'No',
                    'data-btn-cancel-class' => 'btn-xs btn-warning',
                    'data-popout'           => 'true',
                    'before-send-title'     => 'Request sent',
                    'before-send-message'   => 'Please, wait...',
                    'success-title'         => 'Server Response',
                    'success-message'       => 'Message successfully restored.',
                ]) . '</span>';
            ?>
        </p>
    </div>
    <div class="col-md-12">
        <h3>Scroll to top</h3>
        <p>
            <?php echo ScrollToTop::widget(); ?>
        </p>
    </div>
</div>





