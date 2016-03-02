/**
 * Created by phpNT on 03.03.2015.
 */
function afterAjaxListViewUpdate () {
    //alert(1);
    $('.grid').masonry({
        // options
        itemSelector: '.grid-item',
        percentPosition: true
        /*isResizable: true,
        gutterWidth: 5*/
        //columnWidth: 200
    });

    //$('.grid').masonry('reload');
    //$("#infscr-loading").addClass( " grid-item" );
}
