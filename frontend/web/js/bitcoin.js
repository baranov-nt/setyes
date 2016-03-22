/**
 * Created by phpNT on 22.03.2016.
 */
var deposite = parseFloat(0.00001830),          // депозит старта
    riskPercentage = 0.20,                      // риск в процентах
    maxWait = 1000;                             // таймаут в милисекундах

/* вычисляем ставку и округляем до 8 знака после нуля */
var startValue = parseFloat((deposite / 1000)).toFixed(8);      // ставка

/* Кнопки */
var $loButton = $('#double_your_btc_bet_lo_button'),
    $hiButton = $('#double_your_btc_bet_hi_button');

/* Проверка, что достаточно средств */
function iHaveEnoughMoni(){
    var balance = parseFloat($('#balance').text());          // баланс
    var current = parseFloat($('#double_your_btc_stake').val());         // текущая ставка
    /* закрываем при прибыли */
    var profit = parseFloat((deposite + (deposite * riskPercentage)).toFixed(8));
    if(balance >= profit) {
        console.info('Закрываемся с прибылью в ' + (riskPercentage * 100) + '%. Равной ' + parseFloat((balance - deposite)).toFixed(8) + ' BTC.');
        stopGame();
    }
    /* закрываем при пройгрыше */
    var loss = parseFloat((deposite - (deposite * riskPercentage)).toFixed(8));
    if(balance <= loss) {
        console.info('Закрываемся с потерей в ' + (riskPercentage * 100) + '%. Равной ' + parseFloat((balance - deposite)).toFixed(8) + ' BTC.');
        stopGame();
    }
    return true;
}

function stopGame(){
    stopGame();
}

/* Умножение до 8 знака после запятой */
function multiply(){
    var current = $('#double_your_btc_stake').val();
    var multiply = (current * 2).toFixed(8);
    $('#double_your_btc_stake').val(multiply);
}

function getRandomWait(){
    var wait = Math.floor(Math.random() * maxWait ) + 100;
    //console.info('Ждем ' + wait + ' милисекунд до следующей ставки.');
    return wait ;
}

function reset(){
    $('#double_your_btc_stake').val(startValue);
}
// Unbind old shit
$('#double_your_btc_bet_lose').unbind();
$('#double_your_btc_bet_win').unbind();
/* Если проигрыш */
$('#double_your_btc_bet_lose').bind("DOMSubtreeModified",function(event){
    if( $(event.currentTarget).is(':contains("lose")') )
    {
        console.info('Проигрыш. Ставка равна ' + parseFloat($('#double_your_btc_stake').val()).toFixed(8) + '.');
        multiply();
        if(iHaveEnoughMoni()) {
            setTimeout(function () {
                $loButton.trigger('click');
            }, getRandomWait());
        }
    }
});
/* Если выйгрыш */
$('#double_your_btc_bet_win').bind("DOMSubtreeModified",function(event){
    if( $(event.currentTarget).is(':contains("win")') )
    {
        if(iHaveEnoughMoni()) {
            console.info('Выигрыш!');
            reset();
        }
        setTimeout(function(){
            $loButton.trigger('click');
        }, getRandomWait());
    }
});
var balance = parseFloat($('#balance').text());          // баланс
var profit = parseFloat((deposite + (deposite * riskPercentage)).toFixed(8));
var loss = parseFloat((deposite - (deposite * riskPercentage)).toFixed(8));
console.info('Закрываемся если цена больше ' + parseFloat((profit)).toFixed(8) + ' BTC, или меньше ' + parseFloat((loss)).toFixed(8) + ' BTC. Минимальная ставка: ' + (deposite / 1000).toFixed(8));
$loButton.trigger('click');