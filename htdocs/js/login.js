$(document).ready(function () {

    var pane = 'login';

    $('.subnav').on('click', function () {

        var tab = $(this).attr('href');

        $(this).parent().addClass('uk-active').siblings().removeClass('uk-active');

        $('.uk-form').addClass('uk-hidden');
        $(tab).removeClass('uk-hidden');

        return false;
    });


});
