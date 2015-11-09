// DECLARE MODAL ANIMATION
var md_animation = true;
$(document).ready(function () {
    // STICKY BUTTONS
    // fade sticky buttons panel
    $('.stickyBtn').css({
        opacity: 0.3
    });

    $('.stickyBtn').mouseenter(function () {
        $('.stickyBtn').fadeTo('slow', 1.0);
    });

    $('.stickyBtn').mouseleave(function () {
        if ($('.stickyWindow').is(':visible')) {
            $('.stickyBtn').fadeTo('slow', 1.0);
        } else {
            $('.stickyBtn').fadeTo('slow', 0.3);
        }
    });

    // user accounts btn
    $('.stickyBtn .users').click(function () {
        $('.stickyWindow').show('fast');
        $('.accountsDiv').slideDown('slow');

        $('.premiumDiv').hide();
        $('.feedbackDiv').hide();
        $('.otherDiv').hide();
    });

    // premium membership btn
    $('.stickyBtn .premium').click(function () {
        $('.stickyWindow').show('fast');
        $('.premiumDiv').slideDown('slow');

        $('.accountsDiv').hide();
        $('.feedbackDiv').hide();
        $('.otherDiv').hide();

    });

    // feedback btn
    $('.stickyBtn .feedback').click(function () {
        $('.stickyWindow').show('fast');
        $('.feedbackDiv').slideDown('slow');

        $('.premiumDiv').hide();
        $('.accountsDiv').hide();
        $('.otherDiv').hide();
    });

    // other btn
    $('.stickyBtn .other').click(function () {
        $('.stickyWindow').show('fast');
        $('.otherDiv').slideDown('slow');

        $('.premiumDiv').hide();
        $('.accountsDiv').hide();
        $('.feedbackDiv').hide();
    });

    // close sticky bar
    $('.stickyBtn .close').click(function () {
        if ($('.stickyWindow').is(':visible')) {
            $('.stickyWindow').hide('fast');
        }
    });

    // SCROLL TO TOP BUTTON
    // hide button first
    $(".toTop").hide();

    // fade in
    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('.toTop').fadeIn();
            } else {
                $('.toTop').fadeOut();
            }
        });

        // scroll body to 0px on click
        $('.toTop').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });

    // TOGGLE HEADER
    // check cookie
    var headerStatus = $.cookie('showHideHeader');
    if (headerStatus === 'show') {
        $('#Header').show();
    } else if (headerStatus === 'hide') {
        $('#Header').hide();
        $('#Header').attr('style', 'display:none;');
    } else {
        $('#Header').show();
    }
    // on click
    $('#btnToggleHeader').click(function () {
        if ($('#Header').is(':visible')) {
            $('#Header').slideToggle('fast');
            $.cookie('showHideHeader', 'hide', {
                expires: 1
            });
        } else {
            $('#Header').slideToggle('fast');
            $.cookie('showHideHeader', 'show', {
                expires: 1
            });
        }
    });

    // TOGGLE MENU
    // check cookie
    var menuStatus = $.cookie('showHideMenu');
    if (menuStatus === 'show') {
        $('#Menu').show();
    } else if (menuStatus === 'hide') {
        $('#Menu').hide();
        $('#Menu').attr('style', 'display:none;');
    } else {
        $('#Menu').show();
    }
    // on click
    $('#btnToggleMenu').click(function () {
        if ($('#Menu').is(':visible')) {
            $('#Menu').slideToggle('fast');
            $.cookie('showHideMenu', 'hide', {
                expires: 1
            });
        } else {
            $('#Menu').slideToggle('fast');
            $.cookie('showHideMenu', 'show', {
                expires: 1
            });
        }
    });

    // TOGGLE GRIDVIEW BUTTONS
    // check cookie
    var gvBtnStatus = $.cookie('showHideGvBtn');
    if (gvBtnStatus === 'show') {
        $('.gvActionsWrap').show();
    } else if (gvBtnStatus === 'hide') {
        $('.gvActionsWrap').hide();
    } else {
        $('.gvActionsWrap').show();
    }

    // on click
    $('#btnToggleGvBtns').click(function () {
        if ($('.gvActionsWrap').is(':visible')) {
            $('.gvActionsWrap').slideToggle('fast');
            $.cookie('showHideGvBtn', 'hide', {
                expires: 1
            });
        } else {
            $('.gvActionsWrap').slideToggle('fast');
            $.cookie('showHideGvBtn', 'show', {
                expires: 1
            });
        }
    });

    // MODAL - DEFAULT
    $('a.modal').click(function () {
        var x = this.title || $(this).text() || this.href;
        md_show(x, this.href, 550, 490);
        return false;
    });

    // MODAL - FILE EXPLORER
    $('a.modal2').click(function () {
        var x = this.title || $(this).text() || this.href;
        md_show(x, this.href, 550, 790);
        return false;
    });

    // MODAL - USER ROLES
    $('a.modal3').click(function () {
        var x = this.title || $(this).text() || this.href;
        md_show(x, this.href, 420, 480);
        return false;
    });

    // INTITIALIZE SUPERFISH MENU
    $('ul.sf-menu').superfish({
        delay: 500,
        // delay on mouseout - seconds
        animation: {
            opacity: 'show',
            height: 'show'
        },
        // fade-in and slide-down animation 
        speed: 'fast',
        // faster animation speed 
        autoArrows: true,
        // generation of arrow mark-up 
        dropShadows: true // drop shadows 
    });

    // TREEVIEW
    $('ul.treeview:gt(0)').hide();
    $('.toggle').click(function () {
        $(this).parents('li:first').next('ul').slideToggle('fast');
        return false;
    });
    $('#expand').click(function () {
        $('ul.treeview').show();
    });
    $('#collapse').click(function () {
        $('ul.treeview:gt(0)').hide();
    });

    // ADMIN FOOTER
    $('#toggleFooterPanel').click(function () {
        $('#FooterPanel').slideToggle(500);
        $(this).toggleClass('active');
        return false;
    });

    // SLIDE DOWN / UP MESSAGES
    if ($('.msgBox1').is(':visible')) {
        $('.msgBox1').hide().slideDown('slow').delay(3000).slideToggle();
    }

    if ($('.msgBox2').is(':visible')) {
        $('.msgBox2').hide().slideDown('slow').delay(3000).slideToggle();
    }

    if ($('.msgBox3').is(':visible')) {
        $('.msgBox3').hide().slideDown('slow').delay(3000).slideToggle();
    }

    if ($('.msgBox4').is(':visible')) {
        $('.msgBox4').hide().slideDown('slow').delay(3000).slideToggle();
    }
});