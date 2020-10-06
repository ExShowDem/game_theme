"use strict";
var $sw = jQuery.noConflict(),
    $document = $sw(document),
    $window = $sw(window);


$window.load(function() {
    $sw(".se-pre-con").fadeOut("slow")
});

function shopping_cart_dropdown() {
    let t = $sw(".widget_shopping_cart .widget_shopping_cart_content .cart_list .empty"),
        e = $sw(".widget_shopping_cart .widget_shopping_cart_content .cart_list"),
        o = $sw(".cart-menu-wrap");
    !t.length && e.length > 0 && o.addClass("has_products")
}

function shopping_cart_dropdown_show(t) {
    let e = $sw(".widget_shopping_cart .widget_shopping_cart_content .cart_list .empty"),
        o = $sw(".widget_shopping_cart .widget_shopping_cart_content .cart_list"),
        a = $sw(".container .cart-menu-wrap"),
        n = $sw(".container .cart-notification");
    clearTimeout(timeout), !e.length && o.length > 0 && void 0 !== t.type && (a.hasClass("has_products") ? n.is(":visible") ? n.show() : n.fadeIn(400) : setTimeout(function() {
        n.fadeIn(400)
    }, 400), timeout = setTimeout(hideCart, 2700))
}

function hideCart() {
    $sw(".container .cart-notification").stop(!0, !0).fadeOut()
}
let $add_to_cart = $sw(".add_to_cart_button"),
    $item_name = $sw(".container .cart-notification span.item-name");
$add_to_cart.on( "click", function() {
    $productToAdd = $sw(this).parents("li").find("h2").text(), $item_name.html($productToAdd)
});
let $cart_notification = $sw(".container .cart-notification"),
    $widget_shopping_cart = $sw(".container .widget_shopping_cart"),
    $cart_list = $sw(".container .cart_list");
$cart_notification.hover(function() {
    $sw(this).fadeOut(400), $widget_shopping_cart.stop(!0, !0).fadeIn(400), $cart_list.stop(!0, !0).fadeIn(400), clearTimeout(timeout)
});
let $cart_outer = $sw(".container div.cart-outer"),
    $body = ($widget_shopping_cart = $sw(".container .widget_shopping_cart"), $sw("body"));

$cart_outer.hover(function() {
    $widget_shopping_cart.stop(!0, !0).fadeIn(400), $cart_list.stop(!0, !0).fadeIn(400), clearTimeout(timeout), $cart_notification.fadeOut(300)
}, function() {
    $widget_shopping_cart.stop(!0, !0).fadeOut(300), $cart_list.stop(!0, !0).fadeOut(300)
}), $body.bind("added_to_cart", shopping_cart_dropdown_show), $body.bind("added_to_cart", shopping_cart_dropdown), setTimeout(shopping_cart_dropdown, 550), $document.ready(function() {

});

let $back_to_top = $sw("#back-to-top");
if ($back_to_top.length) {
    let $scrollTrigger = 100,
        backToTop = function() {
            $window.scrollTop() > $scrollTrigger ? $sw("#back-to-top").addClass("show") : $sw("#back-to-top").removeClass("show")
        };
    backToTop();
    let $win = $window,
        $html_body = $sw("html, body");
    $win.on("scroll", function() {
        backToTop()
    }), $back_to_top.on("click", function(t) {
        t.preventDefault(), $html_body.animate({
            scrollTop: 0
        }, 700)
    })
};

/**menu script**/
$document.ready(function() {
    "use strict";
    let t = $sw("ul.sub-menu");
    t.parent().addClass("dropdown"), t.addClass("dropdown-menu");
    let e = $sw("dropdown-menu.children");
    e.parent().addClass("dropdown"), e.addClass("dropdown-menu");
    let r = $sw("dropdown-menu.children");
    r.parent().addClass("dropdown");
    let o = $sw(".menu ul");
    o.parent().addClass("dropdown");
    let i = $sw(".dropdown .dropdown-menu");
    i.removeClass("children"),
        r.hover(function() {
            $sw(this).parent().addClass("active")
        }, function() {
            $sw(this).parent().removeClass("active")
        }), t.hover(function() {
        $sw(this).parent().addClass("active")
    }, function() {
        $sw(this).parent().removeClass("active")
    });
    let a = $sw(".menu ul");
    a.addClass("nav"), e.removeClass("nav");

    let menuWithChildren = $sw(".menu-item-has-children a");

    menuWithChildren.on( "click", function(e) {
        if($sw(this).parent().hasClass( "active_mobile" )){
            $sw(this).parent().removeClass('active_mobile');
        }else{
            $sw(this).parent().addClass('active_mobile');
        }
    });

    $sw('#menuToggle').on( "click", function(e) {
        if($sw(this).is(":checked")){
            $body.addClass('mobile_menu_open');
        }else{
            $body.removeClass('mobile_menu_open');
        }
    });
});

// menu out of the screen fix
let dropdownList = $sw(".nav li");
dropdownList.on('mouseenter mouseleave', function (e) {
    let container = $sw(".main-wrapper");
    if ($sw('ul', this).length) {
        let elm = $sw('ul:first', this);
        let off = elm.offset();
        let l = off.left;
        let w = elm.width();
        let docW = container.width();

        let isEntirelyVisible = (l + w <= docW);

        if (!isEntirelyVisible) {
            $sw(this).addClass('edge');
        } else {
            $sw(this).removeClass('edge');
        }
    }
});

/**Image Appear**/
(function($) {
    $.fn.visible = function(partial) {

        let $t            = $(this),
            $w            = $(window),
            viewTop       = $w.scrollTop(),
            viewBottom    = viewTop + $w.height(),
            _top          = $t.offset().top + 300,
            _bottom       = _top + $t.height(),
            compareTop    = partial === true ? _bottom : _top,
            compareBottom = partial === true ? _top : _bottom;

        return ((compareBottom <= viewBottom) && (compareTop >= viewTop));

    };

})(jQuery);

let selectors = $sw('.widget, .blog_item_wrapper  .spcard');
selectors.addClass('app-effect');

selectors.each(function(i, el) {
    var el = $sw(el);
    if (el.visible(true)) {
        el.addClass("ae-onview");
    }
});

$window.scroll(function() {

    selectors.each(function(i, el) {
        var el = $sw(el);
        if (el.visible(true)) {
            el.addClass("ae-onview");
        }
    });

});

/**PrettyPhoto initialize**/
$sw(function() {
    let pretty = $sw("a[rel^='prettyPhoto']");
    if (pretty.length > 0)
        pretty.prettyPhoto({
            overlay_gallery: false,
            show_title: false,
            hideflash: true,
            autoplay: true,
            social_tools: "",
            iframe_markup: "<iframe src='{path}' width='{width}' height='{height}'  allowfullscreen='true' ></iframe>",
            deeplinking: false
        });
});

/**search**/
(function() {

    'use strict';

    let mainContainer = document.querySelector('.container'),
        openCtrl = document.getElementById('btn-search'),
        closeCtrl = document.getElementById('btn-search-close'),
        searchContainer = document.querySelector('.headsearch'),
        inputSearch = searchContainer.querySelector('.search__input'),
        $main = $sw('.main-wrapper');

    function init() {
        if(openCtrl != null && closeCtrl != null && searchContainer != null && inputSearch != null){
            initEvents();
        }
    }

    function initEvents() {
        openCtrl.addEventListener('click', openSearch);
        closeCtrl.addEventListener('click', closeSearch);
        document.addEventListener('keyup', function(ev) {
            // escape key.
            if( ev.keyCode == 27 ) {
                closeSearch();
            }
        });
    }

    function openSearch() {
        mainContainer.classList.add('main-wrap--move');
        searchContainer.classList.add('search--open');
        $main.addClass('search-opn');
        setTimeout(function() {
            inputSearch.focus();
        }, 800);
    }

    function closeSearch() {
        mainContainer.classList.remove('main-wrap--move');
        searchContainer.classList.remove('search--open');
        $main.removeClass('search-opn');
        inputSearch.blur();
        inputSearch.value = '';
    }

    init();

})(window);



/**tooltip**/
tippy('[title-tip]');

/**header parallax**/
 let base = window.base || {};
 window.base = base, base.window = $window, base.document = $document, base.windowScrollTop = 0;
 let timeout, $productToAdd, headerParallaxEffect = function() {
    let t = $sw(".header-flex"),
        e = $sw(".page-title-bg");
    e.hasClass("rest-enable-parallax") && base.window.on("scroll", function(t) {
        let o = base.windowScrollTop,
            a = (e.parent().height(), .3 * o);
        window.returnAnimationFrame(function() {
            e.css({
                "-webkit-transform": "translate3d(0," + a + "px,0)",
                "-moz-transform": "translate3d(0," + a + "px,0)",
                "-o-transform": "translate3d(0," + a + "px,0)",
                transform: "translate3d(0," + a + "px,0)"
            })
        })
    }), t.hasClass("header-enable-parallax") && base.window.on("scroll", function(e) {
        let o = base.windowScrollTop,
            a = t.parent().height(),
            n = .333 * o;
        window.returnAnimationFrame(function() {
            t.css({
                "-webkit-transform": "translate3d(0," + n + "px,0)",
                "-moz-transform": "translate3d(0," + n + "px,0)",
                "-o-transform": "translate3d(0," + n + "px,0)",
                transform: "translate3d(0," + n + "px,0)",
                opacity: 1 - o / a
            })
        })
    })
};
if (window.returnAnimationFrame = window.requestAnimationFrame || function(t, e) {
    window.setTimeout(t, 1e3 / 60)
}, base.initObjectsSizing = function() {
    try {
        base.sameOrigin = window.parent.location.host == window.location.host
    } catch (t) {
        base.sameOrigin = !1
    }
    let t = function() {
        base.windowScrollTop = base.window.scrollTop()
    };
    base.document.ready(function() {
        let t = document.createElement("div");
        t.style.overflowY = "scroll", t.style.width = "50px", t.style.height = "50px", t.style.visibility = "hidden", document.body.appendChild(t), base.scrollbarWidth = t.offsetWidth - t.clientWidth, document.body.removeChild(t)
    });
    let e = function() {
        base.windowHeight = base.window.height(), base.windowWidth = base.window.width() + base.scrollbarWidth, t()
    };
    e(), t(), base.window.on("resize load", e).on("scroll", t)
});

$document.ready(function() {
    base.windowScrollTop = base.window.scrollTop(), base.initObjectsSizing(), headerParallaxEffect()
});


let $blog_item_wrap = $sw(".blog_item_wrapper"),
    $grid = $blog_item_wrap.masonry({
        itemSelector: ".spcard",
        percentPosition: !0,
        columnWidth: ".grid-sizer"
    });

$grid.imagesLoaded().progress(function() {
    $grid.masonry("layout")
});


$document.ready(function() {
    setTimeout(function(){
        let $widget_width = $sw('.bmatchul');
            $widget_width.each(function (index) {
                if ($sw(this).outerWidth() < 450) {
                    $sw(this).addClass('bmatch-sc');
                }
            });

    }, 200);
});


function respawnFixedMenu() {
    let t = $sw("header"),
        e = $window;
    e.scroll(function() {
        e.scrollTop() >= 200 ? t.addClass("header-alt") : t.removeClass("header-alt")
    })
}

if(settingsGlobal.fixedMenu == 'fixed'){
    respawnFixedMenu();
}

