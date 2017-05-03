$(function(){
    /**
     * Funcitoning tabs, change status type
     */
    $('.status-types li a').click(function(){
        $('.status-types li a.active').removeClass('active');
        $(this).addClass('active');
        showStatTab($(this).attr('href'));
        $('#status-type').val($(this).attr('rel'));
    });
    function showStatTab(tabid) {
        $('.s-tab.open').removeClass('open');
        $(tabid).addClass('open');
        //$()
    }
    // end tabs
    
});