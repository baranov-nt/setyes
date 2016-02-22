/**
 * Created by phpNT on 03.03.2015.
 */
function afterAjaxListViewUpdate () {
    $('.grid').masonry({
        // options
        itemSelector: '.grid-item',
        percentPosition: true
        //columnWidth: 200
    });
    //alert("123");
}