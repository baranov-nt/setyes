<?php
/**
 * AssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace common\widgets\BootstrapConfirmation;

use Yii;
/**
 * Class AssetBundle
 * @package rmrevin\yii\fontawesome
 */
class AssetBundle extends \yii\web\AssetBundle
{
    /**
     * @inherit
     */
    public $sourcePath = '@bower';

    /**
     * @inherit
     */
    public $js = [
        'bootstrap/js/tooltip.js',
        'bootstrap/js/popover.js',
        'bootstrap-confirmation2/bootstrap-confirmation.js',
    ];

    /**
     * Initializes the bundle.
     * If you override this method, make sure you call the parent implementation in the last.
     */
    public function init()
    {
        $this->registerJs()
        ;
        parent::init();
    }

    /**
     * @return BootstrapConfirmationAsset
     */
    protected function registerJs()
    {
        $js = <<<SCRIPT
jQuery('[data-toggle="confirmation"]').confirmation();
SCRIPT;
        Yii::$app->view->registerJs($js, \yii\web\View::POS_READY);
        return $this;
    }
}