(function($) {

    $(document).ready(function() {

        $('form').each(function() {
            initForm($(this));
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
            if (curSlider.find('li').length > 12) {
                curSlider.find('.navigator-langs-next').css({'display': 'block'});
            }
        });

        $('.navigator-langs-next').click(function(e) {
            var curSlider = $(this).parents().filter('.navigator-langs');
            var curIndex = curSlider.data('curIndex');
            curIndex++;
            curSlider.find('.navigator-langs-prev').css({'display': 'block'});
            if (curIndex >= curSlider.find('li').length - 12) {
                curIndex = curSlider.find('li').length - 12;
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
                if ($('.window #order-language').length > 0) {
                    var newHTML = '';
                    $('.window .order-select-lang').each(function() {
                        newHTML += '<option value="' + $(this).data('value') + '">' + $(this).data('title') + '</option>';
                    });
                    $('.window #order-language').html(newHTML);

                    if ($('.window #order-course').length > 0) {
                        var newHTML = '';
                        $('.window .order-select-lang:first .order-select-lang-course').each(function() {
                            newHTML += '<option value="' + $(this).data('value') + '">' + $(this).data('title') + '</option>';
                        });
                        $('.window #order-course').html(newHTML);
                    }

                    $('.window .form-select select').trigger('chosen:updated');

                    $('.window #order-language').change(function() {
                        var curValue = $(this).val();
                        var newHTML = '';
                        $('.window .order-select-lang[data-value="' + curValue + '"] .order-select-lang-course').each(function() {
                            newHTML += '<option value="' + $(this).data('value') + '">' + $(this).data('title') + '</option>';
                        });
                        $('.window #order-course').html(newHTML);
                        $('.window #order-course').trigger('chosen:updated');
                    });
                }
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
            e.preventDefault();
        });

        $('.left-menu-mobile').click(function(e) {
            $('body').toggleClass('visible-left-menu');
            if ($('body').hasClass('visible-left-menu')) {
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

    });

    $(window).on('resize', function() {
        $('.form-select select').chosen('destroy');
        $('.form-select select').chosen({disable_search: true, placeholder_text_multiple: ' ', no_results_text: 'Нет результатов'});

        $('body').removeClass('visible-left-menu');
        var apiScroll = $('.left-menu-wrap').data('jsp');
        if (apiScroll) {
            apiScroll.destroy();
        }
    });

    function initForm(curForm) {
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

        curForm.validate({
            ignore: '',
            invalidHandler: function(form, validatorcalc) {
                validatorcalc.showErrors();
                checkErrors();
            }
        });
    }

    function checkErrors() {
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
    }

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
            $('.window-container img').load(function() {
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