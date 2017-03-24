(function($) {

    $(document).ready(function() {
        $('.top-menu-link').click(function(e) {
            $('.top-menu').toggleClass('open');
            e.preventDefault();
        });
    });
})(jQuery);