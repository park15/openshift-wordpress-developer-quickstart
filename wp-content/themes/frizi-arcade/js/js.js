jQuery.fn.clicktoggle = function(a, b) {
    return this.each(function() {
        var clicked = false;
        jQuery(this).bind("click", function() {
            if (clicked) {
                clicked = false;
                return b.apply(this, arguments);
            }
            clicked = true;
            return a.apply(this, arguments);
        });
    });
};


jQuery(document).ready(function ($)
{

    if ($(".play-wrap").length > 0) {
        $('body').attr('id', 'play');

    }
    $('html').click(function() {
        //Hide the menus if visible
        $('.select-box-header.active,.pages_menu.active').click();
      });    

    $('.select-box-header,.pages_menu').clicktoggle(function (event)
    {
        $('.select-drop').hide()
        $('.search-drop').hide()

        $(this).next().show()
        $(this).parent().find('.scroll-pane').jScrollPane();
        $('.select-box-header.active,.pages_menu.active').click();
        event.stopPropagation();
        $(this).toggleClass('active');
    }, function () {
        $(this).toggleClass('active');
        $(this).next().hide()
        $('.select-box-header.active,.pages_menu.active').click();
        event.stopPropagation();
    });



    $('.s-icon').toggle(function ()
    {
        $('.select-drop').hide()
        $('.search-over').hide()
        $(this).next().next().show()
        $(this).parent().find('.scroll-pane').jScrollPane();
    }, function ()
    {
        $(this).next().next().hide()
    });

    $('.s-icon3').toggle(function ()
    {
        $('.select-drop').hide()

        $('.search-over').show()
        $('.search-drop').hide()

    }, function ()
    {
        $('.search-over').hide()
        $('.search-drop').hide()
    });


    $(".wrap-x").height($(document).height());

    $('.cont-h').click(function () {
        $('#cont').fadeIn(500)
    });

    $('.report-but, .report-but2').click(function () {
        $('#report').fadeIn(500)
    });

    $('.close').click(function () {
        $('.wrap-x').fadeOut(500)
    });

    $('.in1').click(function () {
        $(this).parents('.search-over').find('.ajax-search').slideToggle()
    });

    $('.cheker').click(function () {
        $(this).toggleClass('active')
        $('.curtain-wrapper').toggleClass('on')
        $('body').toggleClass('curtain')
    });



    


    $(window).resize(function ()
    {
        if ($(window).width() > 980) {
            $('.big-thumb > .big-title, .thumb > .big-title').hide()
        } else {
            $('.big-thumb > .big-title, .thumb > .big-title').show();
        }
    })


    $(document).on({
            mouseenter: function () {
                if ($(window).width() > 980) {
                    $(this).find('.metathumb').stop(true, true).slideDown(300);
                }
            },
            mouseleave:function () {
                if ($(window).width() > 980) {
                    $(this).find('.metathumb').stop(true, true).slideUp(300);
                }
            }},'.thumb'
    );


    $(document).on({
            mouseenter:function () {
                if ($(window).width() > 980) {
                    $(this).find('.big-title').stop(true, true).slideDown(300);
                }
            },
            mouseleave:function () {
                if ($(window).width() > 980) {
                    $(this).find('.big-title').stop(true, true).slideUp(300);
                }
            }},'.big-thumb'
    );




//Thumbs placer
            baner4 = jQuery('#ban4').clone();     
            baner5 = jQuery('#ban5').clone();     
            jQuery('#ban4, #ban5').remove();


    function width_calc() {
        width = $(window).width()
        

        if (width > 1590) {
           
            $('#bt1').insertAfter(".thumbs .box:nth-child(4)");
            $('#ban1').insertBefore(".thumbs .box:nth-child(7)");
            $('#ban2').insertAfter(".thumbs .box:nth-child(13)");
            $('#bt2').insertAfter(".thumbs .box:nth-child(15)");
            $('#ban3').insertAfter(".thumbs .box:nth-child(22)");
            $('#bt3').insertAfter(".thumbs .box:nth-child(24)");
            $('#bt4').insertAfter(".thumbs .box:nth-child(25)");
            $('#bt5').insertAfter(".thumbs .box:nth-child(29)");
            $('.temp').empty()
            
            $('.game-banners').append(baner4).append(baner5);
            

        }

        if (width > 970 && width < 1589) {
            $('#ban1').insertAfter(".thumbs .box:nth-child(2)");
            $('#bt1').insertAfter(".thumbs .box:nth-child(3)");
            $('#ban2').insertBefore('.thumbs .box:nth-child(8)');
            $('#bt2').insertAfter(".thumbs .box:nth-child(12)");
            $('#ban3').insertAfter(".thumbs .box:nth-child(17)");
            $('#bt3').insertAfter(".thumbs .box:nth-child(19)");
            $('#bt4').insertAfter(".thumbs .box:nth-child(21)");
            $('#bt5').insertAfter(".thumbs .box:nth-child(29)");
            $('.temp').empty()
            
            $('.game-banners').append(baner4).append(baner5);

        }

        if (width > 660 && width < 969) {
            $('#ban1').insertBefore(".thumbs .box:nth-child(1)");
            $('#bt1').insertAfter(".thumbs .box:nth-child(4)");
            $('#ban2').insertAfter(".thumbs .box:nth-child(9)");
            $('#bt2').insertAfter(".thumbs .box:nth-child(13)");
            $('#ban3').insertAfter(".thumbs .box:nth-child(14)");
            $('#bt3').insertAfter(".thumbs .box:nth-child(19)");
            $('#bt4').insertAfter(".thumbs .box:nth-child(22)");
            $('#bt5').insertAfter(".thumbs .box:nth-child(29)");
            $('.temp').empty()
            $('.two-banner').append(baner4).append(baner5);
        }


        if (width > 0 && width < 659) {
            $('#ban1').insertBefore(".thumbs .box:nth-child(1)");
            $('#bt1').insertBefore(".thumbs .box:nth-child(3)");
            $('#ban2').insertAfter(".thumbs .box:nth-child(4)");
            $('#ban3').insertAfter(".thumbs .box:nth-child(6)");
            $('#bt2').insertAfter(".thumbs .box:nth-child(9)");
            $('#bt3').insertAfter(".thumbs .box:nth-child(13)");
            $('#bt4').insertAfter(".thumbs .box:nth-child(19)");
            $('#bt5').insertAfter(".thumbs .box:nth-child(25)");
            $('.temp').empty();
            $('.two-banner').append(baner4);
                    $('.hidden-banner').append(baner5);

        }

    }

    width_calc()




    var waitForFinalEvent = (function () {
        var timers = {};
        return function (callback, ms, uniqueId) {
            if (!uniqueId) {
                uniqueId = "Don't call this twice without a uniqueId";
            }
            if (timers[uniqueId]) {
                clearTimeout(timers[uniqueId]);
            }
            timers[uniqueId] = setTimeout(callback, ms);
        };
    })();

    $(window).resize(function () {
        waitForFinalEvent(function () {

            $('#bt1').appendTo('.temp')
            $('#bt2').appendTo('.temp')
            $('#bt3').appendTo('.temp')
            $('#bt4').appendTo('.temp')
            $('#bt5').appendTo('.temp')
            $('#ban1').appendTo('.temp')
            $('#ban2').appendTo('.temp')
            $('#ban3').appendTo('.temp')
            
            width_calc();
            

            //...
        }, 500, "some unique string");    
        
    });

    $("#ajaxsearchfield").autocomplete({
        appendTo: '.search-drop',
        source: function (req, response) {
            $.getJSON(gamesdata.ajaxurl + '?callback=?&action=game_autocompletesearch', req, response);
        },
        select: function (event, ui) {
            window.location.href = ui.item.link;
        },
        minLength: 4,
        delay: 500,
        open: function (event, ui) {
            $('.search-drop,.select-drop-arrow').show();
        },
        close: function (event, ui) {
            $('.search-drop,.select-drop-arrow').hide();
        }
    }).data("uiAutocomplete")._renderItem = function (ul, item) {
        return $("<li />")
                .data("item.autocomplete", item)
                .append('<a>' + item.value + item.image + '</a>')
                .appendTo(ul);
    };

    $("#ajaxsearchfield-mobile").autocomplete({
        appendTo: '.search-over',
        source: function (req, response) {
            $.getJSON(gamesdata.ajaxurl + '?callback=?&action=game_autocompletesearch', req, response);
        },
        select: function (event, ui) {
            window.location.href = ui.item.link;
        },
        minLength: 4,
        delay: 500,
        open: function (event, ui) {

        },
        close: function (event, ui) {

        },
        create: function (event, ui) {

        }
    }).data("uiAutocomplete")._renderItem = function (ul, item) {
        ul.addClass('ajax-search');

        return $("<li />")
                .data("item.autocomplete", item)
                .append('<a>' + item.value + '</a>')
                .appendTo(ul);
    };


    var scrolldata = $('.thumbs-wrap .thumbs');

    if (scrolldata.length > 0) {
        var count = 1;

        var total = 2;

        busy = false;
        if (jQuery('#inifiniteLoader').isOnScreen()) {
            busy = true;



            loadArticle(count);
            count++;
        }
        $(window).scroll(function () {
            if (jQuery('#inifiniteLoader').isOnScreen() && !busy) {
                busy = true;

                loadArticle(count);

                count++;
            }

        });


    }
    function loadArticle(pageNumber) {
        $('#inifiniteLoader').show('fast');
        var querystring = jQuery('.thumbs-wrap .thumbs').attr('data-query-string');
        $.ajax({
            url: gamesdata.ajaxurl,
            type: 'POST',
            data: {'action': 'infinite_scroll', 'page': count, 'querystring' : querystring },
            success: function (html) {
                $('#inifiniteLoader').hide('1000');
                $(html).appendTo('.thumbs-wrap .thumbs').hide().fadeIn(4000);    // This will be the div where our content will be loaded
                $('.thumbs-wrap .thumbs').attr('data-page',count );
                
                busy = false;
            }
        });
        return false;
    }
    
    $('.full-screen').on('click', function (event) {
            
            $('.play-wrap .gamewrapper').fullScreen(true);
            $('body').toggleClass('fullscreen');
            
            event.preventDefault();
        });
    $('#close-fullscreen ').on('click', function (event) {
            
            $('.play-wrap .gamewrapper').fullScreen(false);
            
            event.preventDefault();
        });
        
       
        
         $(document).bind("fullscreenchange", function() {
           
           if($(document).fullScreen()){
               $('.fullscreen-top, .fullscreen-bottom').show();
               var game_W = $('.gamewrapper').css('width');
                var game_H = $('.gamewrapper').outerHeight();

                var fullscreentop = $('.fullscreen-top');
                var fullscreenbottom = $('.fullscreen-bottom');
                var fullscreentopheight = fullscreentop.outerHeight();
                var fullscreenbottomheight = fullscreenbottom.outerHeight();


                var hghdiff = fullscreentopheight + fullscreenbottomheight;
               
                $('.gamewrapper').css({width: '100%', height: '100%'  });
                $('.gamewrapper embed').css({'border-width': '0'});
                $('.gamewrapper > iframe, .gamewrapper embed').css({width: '100%', height: '100%' }).css({ height: '-='+hghdiff });
              
           } else {
               $('.gamewrapper').css({width: '', height:''});
               $('.gamewrapper > iframe, .gamewrapper embed').css({width: '', height: '' });
                
            $('.fullscreen-top, .fullscreen-bottom').hide();
            $('body').toggleClass('fullscreen');
           }
           
            
        });
        $('.but1.how-to-play').click(function(event) {
            jQuery('#how-to-play').slideToggle(1000);
            event.preventDefault();
        });


        $('#smilar-games').css('height',$('.middle').outerHeight() - $('.middle h2').outerHeight() ).jScrollPane();

});

jQuery.fn.isOnScreen = function () {

    var win = jQuery(window);
    

    var viewport = {
        top: win.scrollTop(),
        left: win.scrollLeft()
    };
    
    viewport.right = viewport.left + win.width();
    viewport.bottom = viewport.top + win.height();
    
    
    
    var bounds = this.offset();
    if (this.length != 1){
        return false
    }
    
    bounds.right = bounds.left + this.outerWidth();
    bounds.bottom = bounds.top + this.outerHeight();

    return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));

};