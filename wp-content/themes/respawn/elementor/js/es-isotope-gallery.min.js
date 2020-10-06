var $sw=jQuery.noConflict();
function isScrolledIntoView(e) {
    var n=$sw(e),
        t=$sw(window),
        a=t.scrollTop(),
        i=a+t.height(),
        o=n.offset().top;
    return o+n.height()<=i&&a<=o
}

$sw(document).ready(function() {
        "undefined"!=typeof elementorFrontend&&void 0!==elementorFrontend.hooks?elementorFrontend.hooks.addAction("frontend/element_ready/widget", function(e) {
                "isotope_gallery.default"===e.data("widget_type")&&($sw('[id^="gallery_content_center_"]').imagesLoaded(function() {
                        var t="gallery-header-center-right-links-current", a=$sw(".gallery-header-center-right-links"), e=[];
                        $sw(".main-content").find("[id^='gallery_content_center_']").each(function() {
                                e.push(this)
                            }
                        ), $sw.each(e, function(e, n) {
                                $sw(n).imagesLoaded(function() {
                                        $sw(n).isotope( {
                                                itemSelector: ".grid_element", layoutMode: "masonry"
                                            }
                                        )
                                    }
                                ), $sw('[id^="gallery_content_center_"]').css("display", "block")
                            }
                        ), a.on("click", function() {
                                var e=$sw(this).parent().parent().find("[id^='gallery_content_center_']");
                                $sw(".grid_element").each(function() {
                                        $sw(this).addClass("in-view")
                                    }
                                );
                                var n=$sw(this).attr("data-filter");
                                a.removeClass(t), $sw(this).addClass(t), e.isotope( {
                                        filter: n
                                    }
                                )
                            }
                        )
                    }
                ), $sw(".grid_element").each(function() {
                        !0===isScrolledIntoView(this)&&$sw(this).addClass("in-view")
                    }
                ))
            }
        ):$sw('[id^="gallery_content_center_"]').imagesLoaded(function() {
                var t="gallery-header-center-right-links-current", a=$sw(".gallery-header-center-right-links"), e=[];
                $sw(".main-content").find("[id^='gallery_content_center_']").each(function() {
                        e.push(this)
                    }
                ), $sw.each(e, function(e, n) {
                        $sw(n).imagesLoaded(function() {
                                $sw(n).isotope( {
                                        itemSelector: ".grid_element", layoutMode: "masonry"
                                    }
                                )
                            }
                        ), $sw('[id^="gallery_content_center_"]').css("display", "block")
                    }
                ), a.on("click", function() {
                        var e=$sw(this).parent().parent().find("[id^='gallery_content_center_']");
                        $sw(".grid_element").each(function() {
                                $sw(this).addClass("in-view")
                            }
                        );
                        var n=$sw(this).attr("data-filter");
                        a.removeClass(t), $sw(this).addClass(t), e.isotope( {
                                filter: n
                            }
                        )
                    }
                )
            }
        )
    }

),
    $sw(window).on("load resize scroll", function(e) {
            $sw(".grid_element").each(function() {
                    !0===isScrolledIntoView(this)&&$sw(this).addClass("in-view")
                }
            )
        }

    ),
    function() {
        var t=[ {}
                ,
                {
                    movement: {
                        imgWrapper: {
                            translation: {
                                x: 10, y: 10, z: 30
                            }
                            ,
                            rotation: {
                                x: 0, y: -10, z: 0
                            }
                            ,
                            reverseAnimation: {
                                duration: 200, easing: "easeOutQuad"
                            }
                        }
                        ,
                        lines: {
                            translation: {
                                x: 10, y: 10, z: [0, 70]
                            }
                            ,
                            rotation: {
                                x: 0, y: 0, z: -2
                            }
                            ,
                            reverseAnimation: {
                                duration: 2e3, easing: "easeOutExpo"
                            }
                        }
                        ,
                        caption: {
                            rotation: {
                                x: 0, y: 0, z: 2
                            }
                            ,
                            reverseAnimation: {
                                duration: 200, easing: "easeOutQuad"
                            }
                        }
                        ,
                        overlay: {
                            translation: {
                                x: 10, y: -10, z: 0
                            }
                            ,
                            rotation: {
                                x: 0, y: 0, z: 2
                            }
                            ,
                            reverseAnimation: {
                                duration: 2e3, easing: "easeOutExpo"
                            }
                        }
                        ,
                        shine: {
                            translation: {
                                x: 100, y: 100, z: 0
                            }
                            ,
                            reverseAnimation: {
                                duration: 200, easing: "easeOutQuad"
                            }
                        }
                    }
                }
                ,
                {
                    movement: {
                        imgWrapper: {
                            rotation: {
                                x: -5, y: 10, z: 0
                            }
                            ,
                            reverseAnimation: {
                                duration: 900, easing: "easeOutCubic"
                            }
                        }
                        ,
                        caption: {
                            translation: {
                                x: 30, y: 30, z: [0, 40]
                            }
                            ,
                            rotation: {
                                x: [0, 15], y: 0, z: 0
                            }
                            ,
                            reverseAnimation: {
                                duration: 1200, easing: "easeOutExpo"
                            }
                        }
                        ,
                        overlay: {
                            translation: {
                                x: 10, y: 10, z: [0, 20]
                            }
                            ,
                            reverseAnimation: {
                                duration: 1e3, easing: "easeOutExpo"
                            }
                        }
                        ,
                        shine: {
                            translation: {
                                x: 100, y: 100, z: 0
                            }
                            ,
                            reverseAnimation: {
                                duration: 900, easing: "easeOutCubic"
                            }
                        }
                    }
                }
                ,
                {
                    movement: {
                        imgWrapper: {
                            rotation: {
                                x: -5, y: 10, z: 0
                            }
                            ,
                            reverseAnimation: {
                                duration: 50, easing: "easeOutQuad"
                            }
                        }
                        ,
                        caption: {
                            translation: {
                                x: 20, y: 20, z: 0
                            }
                            ,
                            reverseAnimation: {
                                duration: 200, easing: "easeOutQuad"
                            }
                        }
                        ,
                        overlay: {
                            translation: {
                                x: 5, y: -5, z: 0
                            }
                            ,
                            rotation: {
                                x: 0, y: 0, z: 6
                            }
                            ,
                            reverseAnimation: {
                                duration: 1e3, easing: "easeOutQuad"
                            }
                        }
                        ,
                        shine: {
                            translation: {
                                x: 50, y: 50, z: 0
                            }
                            ,
                            reverseAnimation: {
                                duration: 50, easing: "easeOutQuad"
                            }
                        }
                    }
                }
                ,
                {
                    movement: {
                        imgWrapper: {
                            translation: {
                                x: 0, y: -8, z: 0
                            }
                            ,
                            rotation: {
                                x: 3, y: 3, z: 0
                            }
                            ,
                            reverseAnimation: {
                                duration: 1200, easing: "easeOutExpo"
                            }
                        }
                        ,
                        lines: {
                            translation: {
                                x: 15, y: 15, z: [0, 15]
                            }
                            ,
                            reverseAnimation: {
                                duration: 1200, easing: "easeOutExpo"
                            }
                        }
                        ,
                        overlay: {
                            translation: {
                                x: 0, y: 8, z: 0
                            }
                            ,
                            reverseAnimation: {
                                duration: 600, easing: "easeOutExpo"
                            }
                        }
                        ,
                        caption: {
                            translation: {
                                x: 10, y: -15, z: 0
                            }
                            ,
                            reverseAnimation: {
                                duration: 900, easing: "easeOutExpo"
                            }
                        }
                        ,
                        shine: {
                            translation: {
                                x: 50, y: 50, z: 0
                            }
                            ,
                            reverseAnimation: {
                                duration: 1200, easing: "easeOutExpo"
                            }
                        }
                    }
                }
                ,
                {
                    movement: {
                        lines: {
                            translation: {
                                x: -5, y: 5, z: 0
                            }
                            ,
                            reverseAnimation: {
                                duration: 1e3, easing: "easeOutExpo"
                            }
                        }
                        ,
                        caption: {
                            translation: {
                                x: 15, y: 15, z: 0
                            }
                            ,
                            rotation: {
                                x: 0, y: 0, z: 3
                            }
                            ,
                            reverseAnimation: {
                                duration: 1500, easing: "easeOutElastic", elasticity: 700
                            }
                        }
                        ,
                        overlay: {
                            translation: {
                                x: 15, y: -15, z: 0
                            }
                            ,
                            reverseAnimation: {
                                duration: 500, easing: "easeOutExpo"
                            }
                        }
                        ,
                        shine: {
                            translation: {
                                x: 50, y: 50, z: 0
                            }
                            ,
                            reverseAnimation: {
                                duration: 500, easing: "easeOutExpo"
                            }
                        }
                    }
                }
                ,
                {
                    movement: {
                        imgWrapper: {
                            translation: {
                                x: 5, y: 5, z: 0
                            }
                            ,
                            reverseAnimation: {
                                duration: 800, easing: "easeOutQuart"
                            }
                        }
                        ,
                        caption: {
                            translation: {
                                x: 10, y: 10, z: [0, 50]
                            }
                            ,
                            reverseAnimation: {
                                duration: 1e3, easing: "easeOutQuart"
                            }
                        }
                        ,
                        shine: {
                            translation: {
                                x: 50, y: 50, z: 0
                            }
                            ,
                            reverseAnimation: {
                                duration: 800, easing: "easeOutQuart"
                            }
                        }
                    }
                }
                ,
                {
                    movement: {
                        lines: {
                            translation: {
                                x: 40, y: 40, z: 0
                            }
                            ,
                            reverseAnimation: {
                                duration: 1500, easing: "easeOutElastic"
                            }
                        }
                        ,
                        caption: {
                            translation: {
                                x: 20, y: 20, z: 0
                            }
                            ,
                            rotation: {
                                x: 0, y: 0, z: -5
                            }
                            ,
                            reverseAnimation: {
                                duration: 1e3, easing: "easeOutExpo"
                            }
                        }
                        ,
                        overlay: {
                            translation: {
                                x: -30, y: -30, z: 0
                            }
                            ,
                            rotation: {
                                x: 0, y: 0, z: 3
                            }
                            ,
                            reverseAnimation: {
                                duration: 750, easing: "easeOutExpo"
                            }
                        }
                        ,
                        shine: {
                            translation: {
                                x: 100, y: 100, z: 0
                            }
                            ,
                            reverseAnimation: {
                                duration: 750, easing: "easeOutExpo"
                            }
                        }
                    }
                }
            ],
            a=0;
        [].slice.call(document.querySelectorAll(".grid_element")).forEach(function(e, n) {
                a=n%2==0?a+1: a, new TiltFx(e, t[a-1])
            }
        )
    }

    ();