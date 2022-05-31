/**
 * Slide and swipe menu (https://github.com/JoanClaret/slide-and-swipe-menu)
 *
 * @copyright Copyright 2013-2015 Joan claret
 * @license   MIT
 * @author    Joan Claret Teruel <dpam23 at gmail dot com>
 *
 * Licensed under The MIT License (MIT).
 * Copyright (c) Joan Claret Teruel <dpam23 at gmail dot com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the 'Software'), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
;(function($, document, window, undefined) {
    'use strict';
    var slideAndSwipe =
        $.fn.slideAndSwipe = function(options) {
            var nav = $(this), // get the element to swipe
                html = $('body'),
                navWidth = -nav.outerWidth(),
                transInitial = navWidth,
                hamburger = $('.ssm-toggle-nav'),
                overlay = $('.ssm-overlay');

            // get settings
            var settings = $.extend({
                triggerOnTouchEnd   : true,
                swipeStatus         : swipeStatus,
                swipeRight          : null,
                allowPageScroll     : 'vertical',
                threshold           : 100,
                excludedElements    : 'label, button, input, select, textarea, .noSwipe',
                speed               : 250

            }, options );

            nav.swipe(settings);

            /**
             * Catch each phase of the swipe.
             * move : we drag the navigation
             * cancel : open navigation
             * end : close navigation
             */
            function swipeStatus(event, phase, direction, distance) {
                if(phase == 'start') {
                    if(nav.hasClass('ssm-nav-visible')) {
                        transInitial = 0;
                    } else {
                        transInitial = navWidth;
                    }
                }
                var mDistance;

                if (phase == 'move' && (direction == 'left')) {
                    if(transInitial < 0) {

                        mDistance = transInitial - distance;
                    } else {
                        mDistance = -distance;
                    }

                    scrollNav(mDistance, 0);

                } else if (phase == 'move' && direction == 'right') {
                    if(transInitial < 0) {
                        mDistance = transInitial + distance;
                    } else {
                        mDistance = distance;
                    }
                    scrollNav(mDistance, 0);
                } else if (phase == 'cancel' && (direction == 'left') && transInitial === 0) {
                    scrollNav(0, settings.speed);
                } else if (phase == 'end' && (direction == 'left')) {
                    hideNavigation();
                } else if ((phase == 'end' || phase == 'cancel') && (direction == 'right')) {
                    console.log('end');
                }
            }

            /**
             * Manually update the position of the nav on drag
             */
            function scrollNav(distance, duration) {
                if(distance >= 0) {
                    distance = 0;
                }
                if(distance <= navWidth) {
                    distance = navWidth;
                }

                nav.css({
                    '-webkit-transition-duration': (duration / 1000).toFixed(1) + 's',
                    'transition-duration': (duration / 1000).toFixed(1) + 's',
                    '-webkit-transform': 'translate3d(' + distance + 'px, 0, 0)',
                    'transform': 'translate3d(' + distance + 'px, 0, 0)'
                });

                if(distance == '0') {
                    nav.addClass('ssm-nav-visible');
                    // hamburger.addClass('ssm-nav-visible');
                    html.addClass('is-navOpen');
                    overlay.fadeIn();
                }
            }

            /**
             * Open / close by click on burger icon
             */
            var hideNavigation = (function() {
                nav.removeClass('ssm-nav-visible');
                scrollNav(navWidth, settings.speed);
                html.removeClass('is-navOpen');
               
                overlay.fadeOut();
                hamburger.toggleClass('open');
            });

            var showNavigation = (function() {
                nav.addClass('ssm-nav-visible');
                scrollNav(0, settings.speed);
                hamburger.toggleClass('open');
            });

            hamburger.on('click',function(e) {
                e.stopPropagation();
                e.preventDefault();
                if(nav.hasClass('ssm-nav-visible')) {
                    hideNavigation();
                } else{
                    showNavigation();
                }
                
            });
            // added by @erlandMuchasaj
            $(".swipe-area").swipe({
                swipeStatus:function(event, phase, direction, distance, duration, fingers){
                    if (phase=="move" && direction =="right") {
                        if(!nav.hasClass('ssm-nav-visible')) {
                            showNavigation();
                        }
                        return false;
                    }
                },
                threshold:15, //To ensure that the gesture was an intentional swipe
                maxTimeThreshold:40,
            });
        }
    ;
})(window.jQuery || window.$, document, window);
/*
 * Export as a CommonJS module
 */
if (typeof module !== 'undefined' && module.exports) {
    module.exports = slideAndSwipe;
}
