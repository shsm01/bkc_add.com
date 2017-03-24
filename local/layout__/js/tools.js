(function($) {

    $(document).ready(function() {

        $('form').each(function() {
            initForm($(this));
        });

        $('.top-menu-link').click(function(e) {
            $('body').toggleClass('top-menu-open');
            e.preventDefault();
        });

        $(document).click(function(e) {
            if ($(e.target).parents().filter('.top-menu').length == 0 && !$(e.target).hasClass('top-menu') && !$(e.target).hasClass('top-menu-link')) {
                $('body').removeClass('top-menu-open');
            }
        });

        $('.header-phone').click(function(e) {
            $('header').toggleClass('header-callback-open');
            e.preventDefault();
        });

        $('.header-callback-close').click(function(e) {
            $('header').removeClass('header-callback-open');
            e.preventDefault();
        });

        $(document).click(function(e) {
            if ($(e.target).parents().filter('.header-callback').length == 0 && $(e.target).parents().filter('.header-phone').length == 0 && !$(e.target).hasClass('header-callback') && !$(e.target).hasClass('header-phone')) {
                $('header').removeClass('header-callback-open');
            }
        });

        $('body').bind('keyup', function(e) {
            if (e.keyCode == 27) {
                $('header').removeClass('header-callback-open');
            }
        });

        $('.footer-callback').click(function(e) {
            $('footer').toggleClass('footer-callback-open');
            e.preventDefault();
        });

        $('body').bind('keyup', function(e) {
            if (e.keyCode == 27) {
                $('footer').removeClass('footer-callback-open');
            }
        });

        $(document).click(function(e) {
            if ($(e.target).parents().filter('.footer-callback-window').length == 0 && $(e.target).parents().filter('.footer-callback').length == 0 && !$(e.target).hasClass('footer-callback-window') && !$(e.target).hasClass('footer-callback')) {
                $('footer').removeClass('footer-callback-open');
            }
        });

        $('.response-text-more a').click(function(e) {
            var curLink = $(this);
            var curText = curLink.html();
            curLink.html(curLink.data('alttext'));
            curLink.data('alttext', curText);

            curLink.parent().parent().toggleClass('open');

            e.preventDefault();
        });

        $('.gallery-item a').click(function(e) {
            var curGallery = $(this).parent().parent();

            var curIndex = curGallery.find('a').index($(this));

            var newHTML = '<ul>';
            curGallery.find('a').each(function() {
                var curLink = $(this);
                newHTML += '<li><a href="' + curLink.attr('href') + '"><img src="' + curLink.attr('rel') + '" alt="" /></a></li>';
            });
            newHTML += '</ul>';
            $('.item-gallery-list').html(newHTML);
            $('.item-gallery-list li').eq(curIndex).addClass('active');

            $('.item-gallery-list').each(function() {
                var curSlider = $(this);
                curSlider.data('curIndex', 0);
                curSlider.data('disableAnimation', true);

                $('.item-gallery-list-prev').css({'display': 'none'});
                if ($('.item-gallery-list').width() >= curSlider.find('ul').width()) {
                    $('.item-gallery-list-next').css({'display': 'none'});
                } else {
                    $('.item-gallery-list-next').css({'display': 'block'});
                }

                $('.item-gallery-prev').css({'display': 'none'});
                if ($('.item-gallery-list li').length > 1) {
                    $('.item-gallery-next').css({'display': 'block'});
                } else {
                    $('.item-gallery-next').css({'display': 'none'});
                }
            });

            var windowWidth     = $(window).width();
            var windowHeight    = $(window).height();
            var curScrollTop    = $(window).scrollTop();
            var curScrollLeft   = $(window).scrollLeft();

            var bodyWidth = $('body').width();
            $('body').css({'height': windowHeight, 'overflow': 'hidden'});
            $(window).scrollTop(0);
            $(window).scrollLeft(0);
            $('body').css({'margin-top': -curScrollTop});
            $('body').data('scrollTop', curScrollTop);
            $('body').css({'margin-left': -curScrollLeft});
            $('body').data('scrollLeft', curScrollLeft);

            $('.item-gallery-list ul li').eq(curIndex).find('a').click();
            $('.item-gallery').addClass('item-gallery-open');

            e.preventDefault();
        });

        $('.item-gallery-close').click(function(e) {
            itemGalleryClose();
            e.preventDefault();
        });

        $('body').keyup(function(e) {
            if (e.keyCode == 27) {
                itemGalleryClose();
            }
        });

        function itemGalleryClose() {
            if ($('.item-gallery-open').length > 0) {
                $('.item-gallery').removeClass('item-gallery-open');
                $('body').css({'height': 'auto', 'overflow': 'visible', 'margin': 0});
                $(window).scrollTop($('body').data('scrollTop'));
                $(window).scrollLeft($('body').data('scrollLeft'));
            }
        }

        $('.item-gallery').on('click', '.item-gallery-list ul li a', function(e) {
            $('.item-gallery-loading').show();
            var curLink = $(this);
            var curLi   = curLink.parent();

            var curIndex = $('.item-gallery-list ul li').index(curLi);
            $('.item-gallery-load img').attr('src', curLink.attr('href'));
            $('.item-gallery-load img').on('load', function() {
                $('.item-gallery-big img').attr('src', curLink.attr('href'));
                $('.item-gallery-big img').width('auto');
                $('.item-gallery-big img').height('auto');
                galleryPosition();

                $('.item-gallery-loading').hide();
            });
            $('.item-gallery-list ul li.active').removeClass('active');
            curLi.addClass('active');

            if (curIndex == 0) {
                $('.item-gallery-prev').css({'display': 'none'});
            } else {
                $('.item-gallery-prev').css({'display': 'block'});
            }
            if (curIndex == $('.item-gallery-list ul li').length - 1) {
                $('.item-gallery-next').css({'display': 'none'});
            } else {
                $('.item-gallery-next').css({'display': 'block'});
            }

            e.preventDefault();
        });

        function galleryPosition() {
            var curWidth = $('.item-gallery-big').width();
            var windowHeight = $(window).height();
            var curHeight = windowHeight - ($('.item-gallery-title').outerHeight() + $('.item-gallery-text').outerHeight() + $('.item-gallery-list').outerHeight()) - 40;

            var imgWidth = $('.item-gallery-big img').width();
            var imgHeight = $('.item-gallery-big img').height();

            var newWidth = curWidth;
            var newHeight = imgHeight * newWidth / imgWidth;

            if (newHeight > curHeight) {
                newHeight = curHeight;
                newWidth = imgWidth * newHeight / imgHeight;
            }

            $('.item-gallery-big img').width(newWidth);
            $('.item-gallery-big img').height(newHeight);

            if ($('.item-gallery-container').outerHeight() > windowHeight - 40) {
                $('.item-gallery-container').css({'top': 20, 'margin-top': 0});
            } else {
                $('.item-gallery-container').css({'top': '50%', 'margin-top': -$('.item-gallery-container').outerHeight() / 2});
            }
        }

        $('.item-gallery-next').click(function(e) {
            var curStep = 5;
            if ($(window).width() < 1200) {
                curStep = 2;
            }
            var curIndex = $('.item-gallery-list ul li').index($('.item-gallery-list ul li.active'));
            curIndex++;
            $('.item-gallery-prev').css({'display': 'block'});
            if (curIndex >= $('.item-gallery-list ul li').length - 1) {
                $('.item-gallery-next').css({'display': 'none'});
            }
            if (curIndex >= $('.item-gallery-list').data('curIndex') + curStep) {
                $('.item-gallery-list-next').click();
            }
            $('.item-gallery-list ul li').eq(curIndex).find('a').click();

            e.preventDefault();
        });

        $('.item-gallery-prev').click(function(e) {
            var curIndex = $('.item-gallery-list ul li').index($('.item-gallery-list ul li.active'));
            curIndex--;
            $('.item-gallery-next').css({'display': 'block'});
            if (curIndex <= 0) {
                $('.item-gallery-prev').css({'display': 'none'});
            }
            if (curIndex < $('.item-gallery-list').data('curIndex')) {
                $('.item-gallery-list-prev').click();
            }
            $('.item-gallery-list ul li').eq(curIndex).find('a').click();

            e.preventDefault();
        });

        $('.item-gallery-list-next').click(function(e) {
            var curStep = 5;
            if ($(window).width() < 1200) {
                curStep = 2;
            }
            var curSlider = $('.item-gallery-list');

            if (curSlider.data('disableAnimation')) {
                var curIndex = curSlider.data('curIndex');
                curIndex += curStep;
                $('.item-gallery-list-prev').css({'display': 'block'});
                if (curIndex >= curSlider.find('li').length - curStep) {
                    curIndex = curSlider.find('li').length - curStep;
                    $('.item-gallery-list-next').css({'display': 'none'});
                }

                curSlider.data('disableAnimation', false);
                curSlider.find('ul').animate({'left': -curIndex * curSlider.find('li:first').outerWidth()}, function() {
                    curSlider.data('curIndex', curIndex);
                    curSlider.data('disableAnimation', true);
                });
            }

            e.preventDefault();
        });

        $('.item-gallery-list-prev').click(function(e) {
            var curStep = 5;
            if ($(window).width() < 1200) {
                curStep = 2;
            }
            var curSlider = $('.item-gallery-list');

            if (curSlider.data('disableAnimation')) {
                var curIndex = curSlider.data('curIndex');
                curIndex -= curStep;
                $('.item-gallery-list-next').css({'display': 'block'});
                if (curIndex <= 0) {
                    curIndex = 0;
                    $('.item-gallery-list-prev').css({'display': 'none'});
                }

                curSlider.data('disableAnimation', false);
                curSlider.find('ul').animate({'left': -curIndex * curSlider.find('li:first').outerWidth()}, function() {
                    curSlider.data('curIndex', curIndex);
                    curSlider.data('disableAnimation', true);
                });
            }

            e.preventDefault();
        });

        $(window).resize(function() {
            if ($('.item-gallery-open').length > 0) {
                galleryPosition();
            }
        });

        $('.navigator-info-item-title a').click(function(e) {
            var curItem = $(this).parent().parent();
            if (curItem.hasClass('open')) {
                curItem.removeClass('open');
            } else {
                $('.navigator-info-item.open').removeClass('open');
                curItem.addClass('open');
            }
            e.preventDefault();
        });

        $('.navigator-info-item-detail-close').click(function(e) {
            var curItem = $(this).parent().parent();
            curItem.removeClass('open');
            e.preventDefault();
        });

        $('.navigator-langs').each(function() {
            var curSlider = $(this);
            curSlider.data('curIndex', 0);
            if (curSlider.find('.navigator-langs-list ul').width() > curSlider.find('.navigator-langs-list').width()) {
                curSlider.find('.navigator-langs-next').css({'display': 'block'});
            }
        });

        $('.navigator-langs-next').click(function(e) {
            var curSlider = $(this).parents().filter('.navigator-langs');
            var curIndex = curSlider.data('curIndex');
            curIndex++;
            curSlider.find('.navigator-langs-prev').css({'display': 'block'});
            if (curSlider.find('.navigator-langs-list ul').width() + (curSlider.find('.navigator-langs-list ul').offset().left - curSlider.find('.navigator-langs-list').offset().left - curSlider.find('li:first').width()) <= curSlider.find('.navigator-langs-list').width()) {
                curSlider.find('.navigator-langs-next').css({'display': 'none'});
            }
            curSlider.data('curIndex', curIndex);
            curSlider.find('ul').stop(true, true).animate({'left': -curIndex * curSlider.find('li:first').width()});
            e.preventDefault();
        });

        $('.navigator-langs-prev').click(function(e) {
            var curSlider = $(this).parents().filter('.navigator-langs');
            var curIndex = curSlider.data('curIndex');
            curIndex--;
            curSlider.find('.navigator-langs-next').css({'display': 'block'});
            if (curIndex <= 0) {
                curIndex = 0;
                curSlider.find('.navigator-langs-prev').css({'display': 'none'});
            }
            curSlider.data('curIndex', curIndex);
            curSlider.find('ul').stop(true, true).animate({'left': -curIndex * curSlider.find('li:first').width()});
            e.preventDefault();
        });

        $('.navigator-langs li a').click(function(e) {
            var curItem = $(this).parent();
            if (!curItem.hasClass('active')) {
                var curNavigator = curItem.parents().filter('.navigator');
                var curIndex = curNavigator.find('.navigator-langs li').index(curItem);
                curNavigator.find('.navigator-langs li.active').removeClass('active');
                curItem.addClass('active');

                curNavigator.find('.navigator-tab.active').removeClass('active');
                curNavigator.find('.navigator-tab').eq(curIndex).addClass('active');
            }

            e.preventDefault();
        });

        $('.navigator-sections li a').click(function(e) {
            var curItem = $(this).parent();
            if (!curItem.hasClass('active')) {
                var curTab = curItem.parents().filter('.navigator-tab');
                var curIndex = curTab.find('.navigator-sections li').index(curItem);
                curTab.find('.navigator-sections li.active').removeClass('active');
                curItem.addClass('active');

                curTab.find('.navigator-sections-tab.active').removeClass('active');
                curTab.find('.navigator-sections-tab').eq(curIndex).addClass('active');
            }
            var curMenu = curItem.parents().filter('.navigator-sections');
            curMenu.removeClass('open');
            curMenu.find('.navigator-sections-current').html($(this).html());

            e.preventDefault();
        });

        $('body').on('click', '.window-link', function(e) {
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

        $('body').on('click', '.order-full-link a', function(e) {
            var curLink = $(this);
            curLink.parent().parent().find('.order-full').toggleClass('open');
            curLink.parent().toggleClass('open');
            var curText = curLink.find('span').html();
            curLink.find('span').html(curLink.data('alttext'));
            curLink.data('alttext', curText);
            windowPosition();
            $('.window .form-select select').chosen('destroy');
            $('.window .form-select select').chosen({disable_search: true, placeholder_text_multiple: ' ', no_results_text: 'Нет результатов'});
            e.preventDefault();
        });

        $('.left-menu-mobile').click(function(e) {
            $('html').removeClass('visible-mobile-navigator');
            var apiScroll = $('.mobile-navigator-langs-list').data('jsp');
            if (apiScroll) {
                apiScroll.destroy();
            }
            var apiScroll = $('.mobile-navigator-info').data('jsp');
            if (apiScroll) {
                apiScroll.destroy();
            }

            $('html').toggleClass('visible-left-menu');
            if ($('html').hasClass('visible-left-menu')) {
                $('.left-menu-wrap').jScrollPane({showArrows: true, autoReinitialise: true});
            } else {
                var apiScroll = $('.left-menu-wrap').data('jsp');
                if (apiScroll) {
                    apiScroll.destroy();
                }
            }
            e.preventDefault();
        });

        $('.submenu-langs').each(function() {
            var curSlider = $(this);
            curSlider.data('curIndex', 0);
            if (curSlider.find('li').length > 10) {
                curSlider.find('.submenu-langs-next').removeClass('disabled');
            }
        });

        $('.submenu-langs-next').click(function(e) {
            var curSlider = $(this).parents().filter('.submenu-langs');
            var curIndex = curSlider.data('curIndex');
            curIndex++;
            curSlider.find('.submenu-langs-prev').removeClass('disabled');
            if (curIndex >= curSlider.find('li').length - 10) {
                curIndex = curSlider.find('li').length - 10;
                curSlider.find('.submenu-langs-next').addClass('disabled');
            }
            curSlider.data('curIndex', curIndex);
            curSlider.find('ul').stop(true, true).animate({'left': -curIndex * curSlider.find('li:first').width()});
            e.preventDefault();
        });

        $('.submenu-langs-prev').click(function(e) {
            var curSlider = $(this).parents().filter('.submenu-langs');
            var curIndex = curSlider.data('curIndex');
            curIndex--;
            curSlider.find('.submenu-langs-next').removeClass('disabled');
            if (curIndex <= 0) {
                curIndex = 0;
                curSlider.find('.submenu-langs-prev').addClass('disabled');
            }
            curSlider.data('curIndex', curIndex);
            curSlider.find('ul').stop(true, true).animate({'left': -curIndex * curSlider.find('li:first').width()});
            e.preventDefault();
        });

        $('.submenu-langs li a').click(function(e) {
            var curItem = $(this).parent();
            if (!curItem.hasClass('active')) {
                var curNavigator = curItem.parents().filter('.submenu');
                var curIndex = curNavigator.find('.submenu-langs li').index(curItem);
                curNavigator.find('.submenu-langs li.active').removeClass('active');
                curItem.addClass('active');

                curNavigator.find('.submenu-tab.active').removeClass('active');
                curNavigator.find('.submenu-tab').eq(curIndex).addClass('active');
            }

            e.preventDefault();
        });

        $('.mobile-navigator-link').click(function(e) {
            $('html').removeClass('visible-left-menu');
            var apiScroll = $('.left-menu-wrap').data('jsp');
            if (apiScroll) {
                apiScroll.destroy();
            }

            $('html').toggleClass('visible-mobile-navigator');
            if ($('html').hasClass('visible-mobile-navigator')) {
                $('.mobile-navigator-langs-list').jScrollPane({showArrows: true, autoReinitialise: true, verticalGutter: 0});
                $('.mobile-navigator-info').jScrollPane({showArrows: true, autoReinitialise: true, verticalGutter: 0});
            } else {
                var apiScroll = $('.mobile-navigator-langs-list').data('jsp');
                if (apiScroll) {
                    apiScroll.destroy();
                }
                var apiScroll = $('.mobile-navigator-info').data('jsp');
                if (apiScroll) {
                    apiScroll.destroy();
                }
            }
            e.preventDefault();
        });

        $('.mobile-navigator-langs li a').click(function(e) {
            var curItem = $(this).parent();
            if (!curItem.hasClass('active')) {
                var curNavigator = curItem.parents().filter('.mobile-navigator');
                var curIndex = curNavigator.find('.mobile-navigator-langs li').index(curItem);
                curNavigator.find('.mobile-navigator-langs li.active').removeClass('active');
                curItem.addClass('active');

                curNavigator.find('.mobile-navigator-info-tab.active').removeClass('active');
                curNavigator.find('.mobile-navigator-info-tab').eq(curIndex).addClass('active');
            }

            e.preventDefault();
        });

        $('.main-advertising').on('click', '.main-advertising-ctrl a', function(e) {
            var curLink = $(this);
            var curBlock = curLink.parents().filter('.main-advertising');
            var curWidth = curBlock.width();

            var curIndex = curBlock.find('.main-advertising-ctrl a').index(curLink);

            curBlock.find('.main-advertising-col:first').stop(true, true).animate({'margin-left': -curIndex * curWidth});

            curBlock.find('.main-advertising-ctrl a.active').removeClass('active');
            curLink.addClass('active');
            e.preventDefault();
        });

        $('.main-news').on('click', '.main-news-ctrl a', function(e) {
            var curLink = $(this);
            var curBlock = curLink.parents().filter('.main-news');
            var curWidth = curBlock.width();

            var curIndex = curBlock.find('.main-news-ctrl a').index(curLink);

            curBlock.find('.main-news-col:first').stop(true, true).animate({'margin-left': -curIndex * curWidth});

            curBlock.find('.main-news-ctrl a.active').removeClass('active');
            curLink.addClass('active');
            e.preventDefault();
        });

        $('.navigator-info').on('click', '.navigator-info-cols-ctrl a', function(e) {
            var curLink = $(this);
            var curBlock = curLink.parents().filter('.navigator-info');
            var curWidth = curBlock.width();

            var curIndex = curBlock.find('.navigator-info-cols-ctrl a').index(curLink);

            curBlock.find('.navigator-info-col:first').stop(true, true).animate({'margin-left': -curIndex * curWidth});

            curBlock.find('.navigator-info-cols-ctrl a.active').removeClass('active');
            curLink.addClass('active');
            e.preventDefault();
        });

        $('.navigator-sections-current').click(function() {
            $(this).parent().toggleClass('open');
        });

        $('.vacancies-wrap h2').click(function() {
            $(this).parent().toggleClass('open');
        });

        $('.filter-view a').click(function(e) {
            var curLink = $(this);

            curLink.parents().filter('.filter').toggleClass('closed');

            var curText = curLink.html();
            curLink.html(curLink.data('alttext'));
            curLink.data('alttext', curText);

            e.preventDefault();
        });

        $('.school-link-map a').click(function(e) {
            if ($('.detail-map').length > 0) {
                $.scrollTo($('.detail-map'), 500);
                e.preventDefault();
            }
        });

        $('.video-item a').click(function(e) {
            var newHTML = '<div class="window-video"><div class="window-video-inner"><iframe src="' + $(this).attr('href') + '" frameborder="0" allowfullscreen></iframe></div></div>';

            windowOpen(newHTML);

            e.preventDefault();
        });

        $('.diplomas-item a').click(function(e) {
            var newHTML = '<div class="window-diplomas"><img src="' + $(this).attr('href') + '" alt="" /></div>';

            windowOpen(newHTML);

            e.preventDefault();
        });

        $('.schools-view li a').click(function(e) {
            var curLi = $(this).parent();
            if (!curLi.hasClass('active')) {
                $('.schools-view li.active').removeClass('active');
                curLi.addClass('active');

                var curIndex = $('.schools-view li').index(curLi);
                $('.schools-tab.active').removeClass('active');
                $('.schools-tab').eq(curIndex).addClass('active');
            }
            e.preventDefault();
        });

        $('.school-list, .timetable-list table').DataTable({
            'paging':       false,
            'info':         false,
            'searching':    false
        });

        $('.metro-item-icon').click(function(e) {
            var curItem = $(this).parent();
            $.ajax({
                type: 'POST',
                url: $(this).attr('href'),
                dataType: 'html',
                cache: false
            }).done(function(html) {
                $('.metro-item .popup').remove();
                curItem.append(html);
            });
            e.preventDefault();
        });

        $(document).click(function(e) {
            if ($(e.target).parents().filter('.metro-item').length == 0) {
                $('.metro-item .popup').remove();
            }
        });

        $('.timetable-title-link').click(function(e) {
            $(this).parent().parent().toggleClass('open');
            e.preventDefault();
        });

        $('.timetable-group-title-link').click(function(e) {
            $(this).parent().parent().toggleClass('open');
            e.preventDefault();
        });

        $('.school-tabs li a').click(function(e) {
            var curLi = $(this).parent();
            if (!curLi.hasClass('active')) {
                $('.school-tabs li.active').removeClass('active');
                curLi.addClass('active');

                var curIndex = $('.school-tabs li').index(curLi);
                $('.school-tabs-content.active').removeClass('active');
                $('.school-tabs-content').eq(curIndex).addClass('active');
            }
            e.preventDefault();
        });

        $('.course-menu-parent-link').click(function(e) {
            $(this).parent().toggleClass('open');
            e.preventDefault();
        });

        $('body').bind('keyup', function(e) {
            if (e.keyCode == 27) {
                $('.course-menu-parent').removeClass('open');
            }
        });

        $(document).click(function(e) {
            if ($(e.target).parents().filter('.course-menu-parent').length == 0) {
                $('.course-menu-parent').removeClass('open');
            }
        });

        $('.search-link').click(function(e) {
            $('body').toggleClass('search-open');
            e.preventDefault();
        });

        $('.test-select-lang').click(function() {
            var curItem = $(this);
            if (!curItem.hasClass('active')) {
                $('.test-select-lang').removeClass('active');
                curItem.addClass('active');

                var curIndex = $('.test-select-lang').index(curItem);
                $('.test-select-sub-item').removeClass('active');
                $('.test-select-sub-item').eq(curIndex).addClass('active');
                $('.test-select-sub-item').eq(curIndex).find('.test-select-sub-list-item:first').click();
            }
        });

        $('.test-select-sub-list-item input:checked').parent().addClass('checked');
        $('.test-select-sub-list-item').click(function() {
            $('.test-select-sub-list-item').removeClass('checked');
            $(this).addClass('checked');
            $(this).find('input').prop('checked', true).trigger('change');
        });

        var navMenuTimer = null;
        $('.nav-menu > li').mouseover(function() {
            var curMenu = $(this);
            window.clearTimeout(navMenuTimer);
            navMenuTimer = null;

            navMenuTimer = window.setTimeout(function() {
                $('.nav-menu > li.hover').removeClass('hover');
                curMenu.addClass('hover');
            }, 300);
        });

        $('.nav-menu > li').mouseout(function() {
            window.clearTimeout(navMenuTimer);
            navMenuTimer = null;

            navMenuTimer = window.setTimeout(function() {
                $('.nav-menu > li.hover').removeClass('hover');
            }, 300);
        });

        $('.test').each(function() {
            var curTest = $(this);
            var curMinutes = curTest.data('time');
            curTest.data('curMinutes', curMinutes);
            curTest.data('curSeconds', 0);

            initTestTimer(curMinutes, 0);

        });

        $('.test').on('click', '.test-next .btn', function(e) {
            $.ajax({
                type: 'POST',
                url: $('.test form').attr('action'),
                data: $('.test form').serialize(),
                dataType: 'html',
                cache: false
            }).done(function(html) {
                $('.test').html(html);

                var curTest = $('.test');
                var curMinutes = curTest.data('curMinutes');
                var curSeconds = curTest.data('curSeconds');
                $('.test-timer .minutes').html(curMinutes);
                $('.test-timer .seconds').html(curSeconds);

                initForm($('.test form'));
            });
            e.preventDefault();
        });

    });

    $(window).on('resize', function() {
        $('.form-select select').chosen('destroy');
        $('.form-select select').chosen({disable_search: true, placeholder_text_multiple: ' ', no_results_text: 'Нет результатов'});

        $('html').removeClass('visible-left-menu');
        var apiScroll = $('.left-menu-wrap').data('jsp');
        if (apiScroll) {
            apiScroll.destroy();
        }

        $('html').removeClass('visible-mobile-navigator');
        var apiScroll = $('.mobile-navigator-langs-list').data('jsp');
        if (apiScroll) {
            apiScroll.destroy();
        }
        var apiScroll = $('.mobile-navigator-info').data('jsp');
        if (apiScroll) {
            apiScroll.destroy();
        }
    });

    $(window).on('load resize', function() {

        $('.partners').each(function() {
            var curList = $(this);
            curList.find('.partner-logo').css({'min-height': '0px', 'line-height': '0px'});

            curList.find('.partner-logo').each(function() {
                var curBlock = $(this);
                var curHeight = curBlock.height();
                var curTop = curBlock.offset().top;

                curList.find('.partner-logo').each(function() {
                    var otherBlock = $(this);
                    if (otherBlock.offset().top == curTop) {
                        var newHeight = otherBlock.height();
                        if (newHeight > curHeight) {
                            curBlock.css({'min-height': newHeight + 'px', 'line-height': newHeight + 'px'});
                        } else {
                            otherBlock.css({'min-height': curHeight + 'px', 'line-height': newHeight + 'px'});
                        }
                    }
                });
            });
        });

        $('.response-text').each(function() {
            var curBlock = $(this);
            var curLink = curBlock.find('.response-text-more a');
            curLink.parent().hide();

            if (curBlock.hasClass('open')) {
                curBlock.removeClass('open');

                var curText = curLink.html();
                curLink.html(curLink.data('alttext'));
                curLink.data('alttext', curText);
            }
            if (curBlock.find('.response-text-inner').height() > curBlock.find('.response-text-wrap').height()) {
                curLink.parent().show();
            }
        });

        $('.main-advertising').each(function() {
            var curBlock = $(this);
            var curWidth = $(window).width();
            if (curWidth < 1200) {
                var curPages = curBlock.find('.main-advertising-col').length;
            }
            var curHTML = '';
            for (var i = 0; i < curPages; i++) {
                curHTML += '<a href="#"></a>';
            }
            curBlock.find('.main-advertising-ctrl').html(curHTML);
            curBlock.find('.main-advertising-ctrl a:first').addClass('active');
            curBlock.find('.main-advertising-col:first').css({'margin-left': 0});
        });

        $('.main-news').each(function() {
            var curBlock = $(this);
            var curWidth = $(window).width();
            if (curWidth < 1200) {
                var curPages = curBlock.find('.main-news-col').length;
            }
            var curHTML = '';
            for (var i = 0; i < curPages; i++) {
                curHTML += '<a href="#"></a>';
            }
            curBlock.find('.main-news-ctrl').html(curHTML);
            curBlock.find('.main-news-ctrl a:first').addClass('active');
            curBlock.find('.main-news-col:first').css({'margin-left': 0});
        });

        $('.navigator-langs').each(function() {
            var curSlider = $(this);
            curSlider.data('curIndex', 0);
            curSlider.find('.navigator-langs-prev, .navigator-langs-next').css({'display': 'none'});
            if (curSlider.find('.navigator-langs-list ul').width() > curSlider.find('.navigator-langs-list').width()) {
                curSlider.find('.navigator-langs-next').css({'display': 'block'});
            }
            curSlider.find('.navigator-langs-list ul').stop(true, true).css({'left': 0});
        });

        $('.navigator-info').each(function() {
            var curBlock = $(this);
            var curWidth = $(window).width();
            if (curWidth < 1200) {
                var curPages = curBlock.find('.navigator-info-col').length;
            }
            var curHTML = '';
            for (var i = 0; i < curPages; i++) {
                curHTML += '<a href="#"></a>';
            }
            curBlock.find('.navigator-info-cols-ctrl').html(curHTML);
            curBlock.find('.navigator-info-cols-ctrl a:first').addClass('active');
            curBlock.find('.navigator-info-col:first').css({'margin-left': 0});
        });

        $('.categories').each(function() {
            var curList = $(this);
            curList.find('.category').css({'min-height': '0px'});

            curList.find('.category').each(function() {
                var curBlock = $(this);
                var curHeight = curBlock.height();
                var curTop = curBlock.offset().top;

                curList.find('.category').each(function() {
                    if ($(this).height() > curHeight) {
                        curHeight = $(this).height();
                    }
                });
                curList.find('.category').css({'min-height': curHeight + 'px'});
            });
        });

    });

    function windowOpen(contentWindow) {
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
                    windowPosition();
                }
            });
        } else {
            $('.window-loading').remove();
            $('.window-container').removeClass('window-container-load');
            windowPosition();
        }

        $('.window-close').click(function(e) {
            windowClose();
            e.preventDefault();
        });

        $('body').bind('keyup', keyUpBody);

        $('.window form').each(function() {
            initForm($(this));
			$(this).data("validator").settings.submitHandler = 
			function(form){
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

    function windowPosition() {
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

    function keyUpBody(e) {
        if (e.keyCode == 27) {
            windowClose();
        }
    }

    function windowClose() {
        $('body').unbind('keyup', keyUpBody);
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

            windowPosition();
        }
    });

})(jQuery);

function initForm(curForm) {
    (function($) {
        curForm.find('input.maskPhone').mask('+7 (999) 999-99-99');

        curForm.find('.form-select select').chosen({disable_search: true, no_results_text: 'Нет результатов'});

        curForm.find('.form-checkbox span input:checked').parent().parent().addClass('checked');
        curForm.find('.form-checkbox').click(function() {
            $(this).toggleClass('checked');
            $(this).find('input').prop('checked', $(this).hasClass('checked')).trigger('change');
        });

        curForm.find('.form-radio span input:checked').parent().parent().addClass('checked');
        curForm.find('.form-radio').click(function() {
            var curName = $(this).find('input').attr('name');
            curForm.find('.form-radio input[name="' + curName + '"]').parent().parent().removeClass('checked');
            $(this).addClass('checked');
            $(this).find('input').prop('checked', true).trigger('change');
        });

        curForm.find('.form-file input').change(function() {
            var curInput = $(this);
            var curField = curInput.parent().parent();
            curField.find('.form-file-name').html(curInput.val().replace(/.*(\/|\\)/, ''));
            curField.find('label.error').remove();
            curField.removeClass('error');
        });

        curForm.find('.form-reset input').click(function(e) {
            var curForm = $(this).parents().filter('form');
            window.setTimeout(function() {
                curForm.find('.form-checkbox').removeClass('checked');
                curForm.find('.form-checkbox input:checked').parent().parent().addClass('checked');

                curForm.find('.form-radio').removeClass('checked');
                curForm.find('.form-radio input:checked').parent().parent().addClass('checked');

                curForm.find('.form-select select').trigger('chosen:updated');
            }, 100);
        });

        if (curForm.find('.order-language').length > 0) {
            var newHTML = '';
            curForm.find('.order-select-lang').each(function() {
                newHTML += '<option value="' + $(this).data('value') + '">' + $(this).data('title') + '</option>';
            });
            curForm.find('.order-language').html(newHTML);

            if (curForm.find('.order-course').length > 0) {
                var newHTML = '';
                curForm.find('.order-select-lang:first .order-select-lang-course').each(function() {
                    newHTML += '<option value="' + $(this).data('value') + '">' + $(this).data('title') + '</option>';
                });
                curForm.find('.order-course').html(newHTML);
            }

            curForm.find('.form-select select').trigger('chosen:updated');

            curForm.find('.order-language').change(function() {
                var curValue = $(this).val();
                var newHTML = '';
                curForm.find('.order-select-lang[data-value="' + curValue + '"] .order-select-lang-course').each(function() {
                    newHTML += '<option value="' + $(this).data('value') + '">' + $(this).data('title') + '</option>';
                });
                curForm.find('.order-course').html(newHTML);
                curForm.find('.order-course').trigger('chosen:updated');
            });
        }

		
		//curForm.parents('.window').length 
        curForm.validate({
            ignore: '',
            invalidHandler: function(form, validatorcalc) {
                validatorcalc.showErrors();
                checkErrors();
            }
        });
    })(jQuery);
}

function checkErrors() {
    (function($) {
        $('.form-checkbox').each(function() {
            var curField = $(this);
            if (curField.find('input.error').length > 0) {
                curField.addClass('error');
            } else {
                curField.removeClass('error');
            }
        });

        $('.form-file').each(function() {
            var curField = $(this);
            if (curField.find('input.error').length > 0) {
                curField.addClass('error');
            } else {
                curField.removeClass('error');
            }
        });
    })(jQuery);
}

var testTimer = null;

function initTestTimer(newMinutes, newSeconds) {
    (function($) {
        var curTest = $('.test');
        curTest.data('curMinutes', newMinutes);
        curTest.data('curSeconds', newSeconds);

        $('.test-timer .minutes').html(newMinutes);
        $('.test-timer .seconds').html(newSeconds);

        window.clearInterval(testTimer);
        testTimer = null;

        testTimer = window.setInterval(function() {
            var curTest = $('.test');
            var curMinutes = curTest.data('curMinutes');
            var curSeconds = curTest.data('curSeconds');
            curSeconds--;
            if (curSeconds < 0) {
                curSeconds = 59;
                curMinutes--;
                if (curMinutes < 0) {
                    curMinutes = 0;
                    curSeconds = 0;
                    $('.test-timer').html($('.test-timer').data('textend'));
                }
            }
            curTest.data('curMinutes', curMinutes);
            curTest.data('curSeconds', curSeconds);

            $('.test-timer .minutes').html(curMinutes);
            $('.test-timer .seconds').html(curSeconds);

        }, 1000);
    })(jQuery);
}