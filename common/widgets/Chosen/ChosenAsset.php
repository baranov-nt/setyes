<?php
/**
 * AssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace common\widgets\Chosen;

use Yii;
/**
 * Class AssetBundle
 * @package rmrevin\yii\fontawesome
 */
class ChosenAsset extends \yii\web\AssetBundle
{
    /**
     * @inherit
     */
    public $sourcePath = '@bower/chosen';

    /**
     * @inherit
     */
    public $css = [
        'chosen.css',
    ];

    /**
     * @inherit
     */
    public $js = [
        'chosen.jquery.js',
    ];

    public function init()
    {
        $this->registerJs();
        parent::init();
    }

    protected function registerJs()
    {
        $js = <<<SCRIPT
        /*$(".chosen-select").chosen();*/
        $(".chosen-select").chosen({disable_search_threshold: 10});
SCRIPT;
        Yii::$app->view->registerJs($js, \yii\web\View::POS_READY);
        return $this;
    }
}