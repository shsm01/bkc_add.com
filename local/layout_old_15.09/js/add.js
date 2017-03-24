(function($) {

    $(document).ready(function() {
		$(".window").on('load', function(){
			$(".window form").data("validator").settings.submitHandler = function(form){
				$.ajax({
					type: "POST",
					url: $(form).attr('action'),
					data: $(form).serialize(),
					dataType: 'html',
				}).done(function(html) {
					$('.window-content').html(html);
				});
			};
		})
        $(document).on("click",".test-next-wide a", function(){
          $.post( "/quiz/inc/question.getnext.php",  $("#cur_quest_form").serialize() )
                .done(function( data ) {
                  $("div.test").html(data);
                  $('form').each(function() {
                      initForm($(this));
                  });
                });
          return false;
        });

        $('body').on('click', '.course-price-link', function(e) {
            $.ajax({
                type: 'POST',
                url: $(this).attr('href'),
                dataType: 'html',
                cache: false
            }).done(function(html) {
                if ($('.window').length > 0) {
                    windowClose();
                }
                windowOpen(html);
            });
            e.preventDefault();
        });
        /*
		$('.top-menu-link').click(function(e) {
            $('.top-menu').toggleClass('open');
            e.preventDefault();
        });
		*/
	});
})(jQuery);



    function windowOpen2(contentWindow) {
        var windowWidth     = $(window).width();
        var windowHeight    = $(window).height();
        var curScrollTop    = $(window).scrollTop();
        var curScrollLeft   = $(window).scrollLeft();

        $('body').css({'height': windowHeight, 'overflow': 'hidden'});
        $(window).scrollTop(0);
        $(window).scrollLeft(0);
        $('body').css({'margin-top': -curScrollTop});
        $('body').data('scrollTop', curScrollTop);
        $('body').css({'margin-left': -curScrollLeft});
        $('body').data('scrollLeft', curScrollLeft);

        $('body').append('<div class="window"><div class="window-overlay"></div><div class="window-loading"></div><div class="window-container window-container-load"><div class="window-content">' + contentWindow + '</div></div><a href="#" class="window-close">Закрыть</a></div>')

        if ($('.window-container img').length > 0) {
            $('.window-container img').each(function() {
                $(this).attr('src', $(this).attr('src'));
            });
            $('.window-container').data('curImg', 0);
            $('.window-container img').on('load', function() {
                var curImg = $('.window-container').data('curImg');
                curImg++;
                $('.window-container').data('curImg', curImg);
                if ($('.window-container img').length == curImg) {
                    $('.window-loading').remove();
                    $('.window-container').removeClass('window-container-load');
                    windowPosition2();
                }
            });
        } else {
            $('.window-loading').remove();
            $('.window-container').removeClass('window-container-load');
            windowPosition2();
        }

        $('.window-close').click(function(e) {
            windowClose2();
            e.preventDefault();
        });

        $('body').bind('keyup', keyUpBody2);

        $('.window form').each(function() {
            initForm($(this));
			$(this).data("validator").settings.submitHandler = function(form){
				$.ajax({
					type: "POST",
					url: $(form).attr('action'),
					data: $(form).serialize(),
					dataType: 'html',
				}).done(function(html) {
					$('.window-content').html(html);
				});
			};
        });

    }

    function windowPosition2() {
        var windowWidth     = $(window).width();
        var windowHeight    = $(window).height();

        if ($('.window-container').width() > windowWidth - 40) {
            $('.window-container').css({'left': 20, 'margin-left': 0});
            $('.window-overlay').width($('.window-container').width() + 40);
        } else {
            $('.window-container').css({'left': '50%', 'margin-left': -$('.window-container').width() / 2});
            $('.window-overlay').width('100%');
        }

        if ($('.window-container').height() > windowHeight - 40) {
            $('.window-overlay').height($('.window-container').height() + 40);
            $('.window-container').css({'top': 20, 'margin-top': 0});
        } else {
            $('.window-container').css({'top': '50%', 'margin-top': -$('.window-container').height() / 2});
            $('.window-overlay').height('100%');
        }
    }

    function keyUpBody2(e) {
        if (e.keyCode == 27) {
            windowClose2();
        }
    }

    function windowClose2() {
        $('body').unbind('keyup', keyUpBody2);
        $('.window').remove();
        $('body').css({'height': 'auto', 'overflow': 'visible', 'margin': 0});
        $(window).scrollTop($('body').data('scrollTop'));
        $(window).scrollLeft($('body').data('scrollLeft'));
    }

    $(window).resize(function() {
        if ($('.window').length > 0) {
            var windowWidth     = $(window).width();
            var windowHeight    = $(window).height();
            var curScrollTop    = $(window).scrollTop();
            var curScrollLeft   = $(window).scrollLeft();

            $('body').css({'height': 'auto', 'overflow': 'visible', 'margin': 0});
            $('body').css({'height': windowHeight, 'overflow': 'hidden'});
            $(window).scrollTop(0);
            $(window).scrollLeft(0);
            $('body').data('scrollTop', 0);
            $('body').data('scrollLeft', 0);

            windowPosition2();
        }
    });
