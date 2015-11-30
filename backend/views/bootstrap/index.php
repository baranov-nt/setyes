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
<div id="my_elem" class="row">
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
        <h3>iGrowl</h3>
        <p>
            <button type="button" class="btn" onclick="
            $.iGrowl({
 title: 'Having issues?',
 message: 'Chat with a technician for support',
 icon: 'vicons-support'
});
            ">Run growl</button>
        </p>
        <p>
            <button type="button" class="btn" onclick="
            $.iGrowl({
 type: 'error',
 title: 'Uh oh - something went wrong!',
 icon: 'linecons-fire',
 placement : {
  x: 	'center',
  y: 	'bottom'
 }
})
            ">Run growl</button>
        </p>
        <p>
            <button type="button" class="btn" onclick="
            $.iGrowl({
 type: 'notice',
 delay: 5000,
 title: 'New friend request',
 message: 'Greg Jackson has sent you a friend invite!',
 image: {
  src: './images/user.jpg',
  class: 'example-image'
 }
})
            ">Run growl</button>
        </p>
        <p>
            <button type="button" class="btn" onclick="
            // entire alert is a link
$.iGrowl({
 icon : 'feather-image',
 message : 'Looking for a great image gallery?',
 link : 'http://imgur.com/',
 target : 'blank',
 delay : 6000
})

// link is contained in part of the message
$.iGrowl({
 icon : 'feather-image',
             message : 'Looking for a great image gallery? Click here',
            delay : 6000
            })
            ">Run growl</button>
        </p>
        <p>
            <button type="button" class="btn" onclick="
            $.iGrowl({
 type: 'notice',
 message: 'The item has been added to your cart',
 icon: 'vicons-cart',
 placement : {
  x: 	'center'
 },
 animShow: 'fadeInLeftBig',
 animHide: 'fadeOutDown',
 onHidden: function(){
  alert('alert is now hidden!')
 }
})
            ">Run growl</button>
        </p>
    </div>

    <div class="col-md-12">
        <h3>Chosen</h3>
        <select data-placeholder="Choose a Country..." class="chosen-select" style="width:350px;" tabindex="2">
            <option value=""></option>
            <option value="United States">United States</option>
            <option value="United Kingdom">United Kingdom</option>
            <option value="Afghanistan">Afghanistan</option>
            <option value="Aland Islands">Aland Islands</option>
            <option value="Albania">Albania</option>
            <option value="Algeria">Algeria</option>
            <option value="American Samoa">American Samoa</option>
            <option value="Andorra">Andorra</option>
            <option value="Angola">Angola</option>
            <option value="Anguilla">Anguilla</option>
            <option value="Antarctica">Antarctica</option>
            <option value="Antigua and Barbuda">Antigua and Barbuda</option>
            <option value="Argentina">Argentina</option>
        </select>
        <br><br>
        <select data-placeholder="Your Favorite Types of Bear" class="chosen-select" style="width:350px;" tabindex="17" id="single-label-example">
            <option value=""></option>
            <option selected>American Black Bear</option>
            <option>Asiatic Black Bear</option>
            <option>Brown Bear</option>
            <option>Giant Panda</option>
            <option>Sloth Bear</option>
            <option>Sun Bear</option>
            <option>Polar Bear</option>
            <option>Spectacled Bear</option>
        </select>
        <br><br>
        <select data-placeholder="Your Favorite Types of Bear" multiple class="chosen-select" style="width:350px;" tabindex="18" id="multiple-label-example">
            <option value=""></option>
            <option>American Black Bear</option>
            <option>Asiatic Black Bear</option>
            <option>Brown Bear</option>
            <option selected>Giant Panda</option>
            <option>Sloth Bear</option>
            <option>Sun Bear</option>
            <option>Polar Bear</option>
            <option>Spectacled Bear</option>
        </select>
    </div>

    <div class="col-md-12">
        <h3>Js Cookie</h3>
        <p>
            <button type="button" class="btn btn-success" onclick="Cookies.set('name1', 'value');">Установить в Cookie переменную name1 со значением value</button>
            <button type="button" class="btn btn-success" onclick="Cookies.set('name2', 'value', { expires: 7 });">Установить в Cookie переменную name2 со значением value на 7 дней</button>
            <button type="button" class="btn btn-success" onclick="Cookies.set('name3', 'value', { expires: 7, path: '' });">Установить в Cookie переменную name3 со значением value на 7 дней для текущей страницы</button>
            <button type="button" class="btn btn-primary" onclick="alert(Cookies.get('name1'));">Получить из Cookie переменную name1</button>
            <button type="button" class="btn btn-primary" onclick="console.info(Cookies.get());">Получить все Cookie (данные в консоли)</button>
            <button type="button" class="btn btn-danger" onclick="Cookies.remove('name2');">Удалить из Cookie переменную name2</button>
            <button type="button" class="btn btn-success" onclick="var Cookies2 = Cookies.noConflict(); Cookies2.set('name4', 'value');">Установить в Cookie переменную name1 с namespace Cookies2</button>
            <button type="button" class="btn btn-success" onclick="Cookies.set('name5', { foo: 'bar' });">Установить в Cookie json массив.</button>
            <button type="button" class="btn btn-primary" onclick="console.info(Cookies.getJSON('name5'));">Получить из Cookie json массив. (данные в консоли)</button>
            <button type="button" class="btn btn-success" onclick="Cookies.set('name8', 'value', { domain: 'admin.setyes.dev' });">Установить в Cookie для определенного домена admin.setyes.dev.</button>
            <button type="button" class="btn btn-success" onclick="Cookies.set('name6', 'value', { secure: true });">Установить в Cookie переменную name6 со значением value и зашифровать (требуется https)</button>
            <button type="button" class="btn btn-primary" onclick="alert(Cookies.get('name6'););">Получить из Cookie переменную name1 (требуется https)</button>
        </p>
    </div>

    <div class="col-md-12">
        <h3>Easing</h3>
        <div id="clickme">
            Click here
        </div>
        <div id="book" style="width: 100px; height: 100px; position: relative; left: 10px; background-color: #0000aa;"><div>
                <?php
                $js = <<<SCRIPT
      $( "#clickme" ).click(function() {
  $( "#book" ).animate({ top: '-=100px' }, 600, 'easeInOutElastic', function () {  })
});
SCRIPT;
                Yii::$app->view->registerJs($js, \yii\web\View::POS_READY);
                ?>
            </div>
        </div>

        <div id="clickme2">
            Click here 2
        </div>
        <div id="book2" style="width: 100px; height: 100px; position: relative; left: 10px; background-color: #006600;"><div>
                <?php
                $js = <<<SCRIPT
      $( "#clickme2" ).click(function() {
  $( "#book2" ).animate({ left: '+=100px' }, 600, 'easeInOutBounce', function () {  })
});
SCRIPT;

                Yii::$app->view->registerJs($js, \yii\web\View::POS_READY);
                ?>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <h3>Mouse Wheel</h3>
        <p>
            <?php
            $js = <<<SCRIPT
      /*$('#my_elem').on('mousewheel', function(event) {
    console.log(event.deltaX, event.deltaY, event.deltaFactor);
});

$('#my_elem').mousewheel(function(event) {
    console.log(event.deltaX, event.deltaY, event.deltaFactor);
});*/
SCRIPT;
            Yii::$app->view->registerJs($js, \yii\web\View::POS_READY);
            ?>
        </p>
    </div>

    <div class="col-md-12">
        <h3>Jquery Form</h3>
        <p>
            <?php
            $js = <<<SCRIPT
      /*$('#myForm').ajaxForm(function() {
                //alert("Thank you for your comment!");
            });*/
            $('#myForm').ajaxForm({
    target: '#myResultsDiv'
});
SCRIPT;
            Yii::$app->view->registerJs($js, \yii\web\View::POS_READY);
            ?>
        <div id="myResultsDiv"></div>
        <form id="myForm" action="form" method="post">
            Name: <input type="text" name="name" />
            <input type="submit" value="Submit Comment" />
        </form>
        </p>
    </div>

    <div class="col-md-12">
        <h3>Scroll To</h3>
        <p>
            <?php
            $js = <<<SCRIPT
      $('#myResultsDiv').scrollTo('#my_elem');
SCRIPT;
            Yii::$app->view->registerJs($js, \yii\web\View::POS_READY);
            ?>
        <div id="myResultsDiv" onclick="$('#my_elem').scrollTo(0, 800, {queue:true});">ddd</div>
        </p>
    </div>

    <div class="col-md-12">
        <h3>Scroll to top</h3>
        <p>
            <?php echo ScrollToTop::widget(); ?>
        </p>
    </div>

</div>





