/*! SlimScroll*/
(function(e){e.fn.extend({slimScroll:function(f){var a=e.extend({width:"auto",height:"250px",size:"7px",color:"#000",position:"right",distance:"1px",start:"top",opacity:.4,alwaysVisible:!1,disableFadeOut:!1,railVisible:!1,railColor:"#333",railOpacity:.2,railDraggable:!0,railClass:"slimScrollRail",barClass:"slimScrollBar",wrapperClass:"slimScrollDiv",allowPageScroll:!1,wheelStep:20,touchScrollStep:200,borderRadius:"7px",railBorderRadius:"7px"},f);this.each(function(){function v(d){if(r){d=d||window.event;var c=0;d.wheelDelta&&(c=-d.wheelDelta/120);d.detail&&(c=d.detail/3);e(d.target||d.srcTarget||d.srcElement).closest("."+a.wrapperClass).is(b.parent())&&n(c,!0);d.preventDefault&&!k&&d.preventDefault();k||(d.returnValue=!1)}}function n(d,g,e){k=!1;var f=b.outerHeight()-c.outerHeight();g&&(g=parseInt(c.css("top"))+d*parseInt(a.wheelStep)/100*c.outerHeight(),g=Math.min(Math.max(g,0),f),g=0<d?Math.ceil(g):Math.floor(g),c.css({top:g+"px"}));l=parseInt(c.css("top"))/(b.outerHeight()-c.outerHeight());g=l*(b[0].scrollHeight-b.outerHeight());e&&(g=d,d=g/b[0].scrollHeight*b.outerHeight(),d=Math.min(Math.max(d,0),f),c.css({top:d+"px"}));b.scrollTop(g);b.trigger("slimscrolling",~~g);w();p()}function x(){u=Math.max(b.outerHeight()/b[0].scrollHeight*b.outerHeight(),30);c.css({height:u+"px"});var a=u==b.outerHeight()?"none":"block";c.css({display:a})}function w(){x();clearTimeout(B);l==~~l?(k=a.allowPageScroll,C!=l&&b.trigger("slimscroll",0==~~l?"top":"bottom")):k=!1;C=l;u>=b.outerHeight()?k=!0:(c.stop(!0,!0).fadeIn("fast"),a.railVisible&&m.stop(!0,!0).fadeIn("fast"))}function p(){a.alwaysVisible||(B=setTimeout(function(){a.disableFadeOut&&r||y||z||(c.fadeOut("slow"),m.fadeOut("slow"))},1E3))}var r,y,z,B,A,u,l,C,k=!1,b=e(this);if(b.parent().hasClass(a.wrapperClass)){var q=b.scrollTop(),c=b.siblings("."+a.barClass),m=b.siblings("."+a.railClass);x();if(e.isPlainObject(f)){if("height"in f&&"auto"==f.height){b.parent().css("height","auto");b.css("height","auto");var h=b.parent().parent().height();b.parent().css("height",h);b.css("height",h)}else"height"in f&&(h=f.height,b.parent().css("height",h),b.css("height",h));if("scrollTo"in f)q=parseInt(a.scrollTo);else if("scrollBy"in f)q+=parseInt(a.scrollBy);else if("destroy"in f){c.remove();m.remove();b.unwrap();return}n(q,!1,!0)}}else if(!(e.isPlainObject(f)&&"destroy"in f)){a.height="auto"==a.height?b.parent().height():a.height;q=e("<div></div>").addClass(a.wrapperClass).css({position:"relative",overflow:"hidden",width:a.width,height:a.height});b.css({overflow:"hidden",width:a.width,height:a.height});var m=e("<div></div>").addClass(a.railClass).css({width:a.size,height:"100%",position:"absolute",top:0,display:a.alwaysVisible&&a.railVisible?"block":"none","border-radius":a.railBorderRadius,background:a.railColor,opacity:a.railOpacity,zIndex:90}),c=e("<div></div>").addClass(a.barClass).css({background:a.color,width:a.size,position:"absolute",top:0,opacity:a.opacity,display:a.alwaysVisible?"block":"none","border-radius":a.borderRadius,BorderRadius:a.borderRadius,MozBorderRadius:a.borderRadius,WebkitBorderRadius:a.borderRadius,zIndex:99}),h="right"==a.position?{right:a.distance}:{left:a.distance};m.css(h);c.css(h);b.wrap(q);b.parent().append(c);b.parent().append(m);a.railDraggable&&c.bind("mousedown",function(a){var b=e(document);z=!0;t=parseFloat(c.css("top"));pageY=a.pageY;b.bind("mousemove.slimscroll",function(a){currTop=t+a.pageY-pageY;c.css("top",currTop);n(0,c.position().top,!1)});b.bind("mouseup.slimscroll",function(a){z=!1;p();b.unbind(".slimscroll")});return!1}).bind("selectstart.slimscroll",function(a){a.stopPropagation();a.preventDefault();return!1});m.hover(function(){w()},function(){p()});c.hover(function(){y=!0},function(){y=!1});b.hover(function(){r=!0;w();p()},function(){r=!1;p()});b.bind("touchstart",function(a,b){a.originalEvent.touches.length&&(A=a.originalEvent.touches[0].pageY)});b.bind("touchmove",function(b){k||b.originalEvent.preventDefault();b.originalEvent.touches.length&&(n((A-b.originalEvent.touches[0].pageY)/a.touchScrollStep,!0),A=b.originalEvent.touches[0].pageY)});x();"bottom"===a.start?(c.css({top:b.outerHeight()-c.outerHeight()}),n(0,!0)):"top"!==a.start&&(n(e(a.start).position().top,null,!0),a.alwaysVisible||c.hide());window.addEventListener?(this.addEventListener("DOMMouseScroll",v,!1),this.addEventListener("mousewheel",v,!1)):document.attachEvent("onmousewheel",v)}});return this}});e.fn.extend({slimscroll:e.fn.slimScroll})})(jQuery);
/*FASTCLIOCK*/
!function(){"use strict";function a(b,d){function f(a,b){return function(){return a.apply(b,arguments)}}var e;if(d=d||{},this.trackingClick=!1,this.trackingClickStart=0,this.targetElement=null,this.touchStartX=0,this.touchStartY=0,this.lastTouchIdentifier=0,this.touchBoundary=d.touchBoundary||10,this.layer=b,this.tapDelay=d.tapDelay||200,this.tapTimeout=d.tapTimeout||700,!a.notNeeded(b)){for(var g=["onMouse","onClick","onTouchStart","onTouchMove","onTouchEnd","onTouchCancel"],h=this,i=0,j=g.length;i<j;i++)h[g[i]]=f(h[g[i]],h);c&&(b.addEventListener("mouseover",this.onMouse,!0),b.addEventListener("mousedown",this.onMouse,!0),b.addEventListener("mouseup",this.onMouse,!0)),b.addEventListener("click",this.onClick,!0),b.addEventListener("touchstart",this.onTouchStart,!1),b.addEventListener("touchmove",this.onTouchMove,!1),b.addEventListener("touchend",this.onTouchEnd,!1),b.addEventListener("touchcancel",this.onTouchCancel,!1),Event.prototype.stopImmediatePropagation||(b.removeEventListener=function(a,c,d){var e=Node.prototype.removeEventListener;"click"===a?e.call(b,a,c.hijacked||c,d):e.call(b,a,c,d)},b.addEventListener=function(a,c,d){var e=Node.prototype.addEventListener;"click"===a?e.call(b,a,c.hijacked||(c.hijacked=function(a){a.propagationStopped||c(a)}),d):e.call(b,a,c,d)}),"function"==typeof b.onclick&&(e=b.onclick,b.addEventListener("click",function(a){e(a)},!1),b.onclick=null)}}var b=navigator.userAgent.indexOf("Windows Phone")>=0,c=navigator.userAgent.indexOf("Android")>0&&!b,d=/iP(ad|hone|od)/.test(navigator.userAgent)&&!b,e=d&&/OS 4_\d(_\d)?/.test(navigator.userAgent),f=d&&/OS [6-7]_\d/.test(navigator.userAgent),g=navigator.userAgent.indexOf("BB10")>0;a.prototype.needsClick=function(a){switch(a.nodeName.toLowerCase()){case"button":case"select":case"textarea":if(a.disabled)return!0;break;case"input":if(d&&"file"===a.type||a.disabled)return!0;break;case"label":case"iframe":case"video":return!0}return/\bneedsclick\b/.test(a.className)},a.prototype.needsFocus=function(a){switch(a.nodeName.toLowerCase()){case"textarea":return!0;case"select":return!c;case"input":switch(a.type){case"button":case"checkbox":case"file":case"image":case"radio":case"submit":return!1}return!a.disabled&&!a.readOnly;default:return/\bneedsfocus\b/.test(a.className)}},a.prototype.sendClick=function(a,b){var c,d;document.activeElement&&document.activeElement!==a&&document.activeElement.blur(),d=b.changedTouches[0],c=document.createEvent("MouseEvents"),c.initMouseEvent(this.determineEventType(a),!0,!0,window,1,d.screenX,d.screenY,d.clientX,d.clientY,!1,!1,!1,!1,0,null),c.forwardedTouchEvent=!0,a.dispatchEvent(c)},a.prototype.determineEventType=function(a){return c&&"select"===a.tagName.toLowerCase()?"mousedown":"click"},a.prototype.focus=function(a){var b;d&&a.setSelectionRange&&0!==a.type.indexOf("date")&&"time"!==a.type&&"month"!==a.type?(b=a.value.length,a.setSelectionRange(b,b)):a.focus()},a.prototype.updateScrollParent=function(a){var b,c;if(b=a.fastClickScrollParent,!b||!b.contains(a)){c=a;do{if(c.scrollHeight>c.offsetHeight){b=c,a.fastClickScrollParent=c;break}c=c.parentElement}while(c)}b&&(b.fastClickLastScrollTop=b.scrollTop)},a.prototype.getTargetElementFromEventTarget=function(a){return a.nodeType===Node.TEXT_NODE?a.parentNode:a},a.prototype.onTouchStart=function(a){var b,c,f;if(a.targetTouches.length>1)return!0;if(b=this.getTargetElementFromEventTarget(a.target),c=a.targetTouches[0],d){if(f=window.getSelection(),f.rangeCount&&!f.isCollapsed)return!0;if(!e){if(c.identifier&&c.identifier===this.lastTouchIdentifier)return a.preventDefault(),!1;this.lastTouchIdentifier=c.identifier,this.updateScrollParent(b)}}return this.trackingClick=!0,this.trackingClickStart=a.timeStamp,this.targetElement=b,this.touchStartX=c.pageX,this.touchStartY=c.pageY,a.timeStamp-this.lastClickTime<this.tapDelay&&a.preventDefault(),!0},a.prototype.touchHasMoved=function(a){var b=a.changedTouches[0],c=this.touchBoundary;return Math.abs(b.pageX-this.touchStartX)>c||Math.abs(b.pageY-this.touchStartY)>c},a.prototype.onTouchMove=function(a){return!this.trackingClick||((this.targetElement!==this.getTargetElementFromEventTarget(a.target)||this.touchHasMoved(a))&&(this.trackingClick=!1,this.targetElement=null),!0)},a.prototype.findControl=function(a){return void 0!==a.control?a.control:a.htmlFor?document.getElementById(a.htmlFor):a.querySelector("button, input:not([type=hidden]), keygen, meter, output, progress, select, textarea")},a.prototype.onTouchEnd=function(a){var b,g,h,i,j,k=this.targetElement;if(!this.trackingClick)return!0;if(a.timeStamp-this.lastClickTime<this.tapDelay)return this.cancelNextClick=!0,!0;if(a.timeStamp-this.trackingClickStart>this.tapTimeout)return!0;if(this.cancelNextClick=!1,this.lastClickTime=a.timeStamp,g=this.trackingClickStart,this.trackingClick=!1,this.trackingClickStart=0,f&&(j=a.changedTouches[0],k=document.elementFromPoint(j.pageX-window.pageXOffset,j.pageY-window.pageYOffset)||k,k.fastClickScrollParent=this.targetElement.fastClickScrollParent),h=k.tagName.toLowerCase(),"label"===h){if(b=this.findControl(k)){if(this.focus(k),c)return!1;k=b}}else if(this.needsFocus(k))return a.timeStamp-g>100||d&&window.top!==window&&"input"===h?(this.targetElement=null,!1):(this.focus(k),this.sendClick(k,a),d&&"select"===h||(this.targetElement=null,a.preventDefault()),!1);return!(!d||e||(i=k.fastClickScrollParent,!i||i.fastClickLastScrollTop===i.scrollTop))||(this.needsClick(k)||(a.preventDefault(),this.sendClick(k,a)),!1)},a.prototype.onTouchCancel=function(){this.trackingClick=!1,this.targetElement=null},a.prototype.onMouse=function(a){return!this.targetElement||(!!a.forwardedTouchEvent||(!a.cancelable||(!(!this.needsClick(this.targetElement)||this.cancelNextClick)||(a.stopImmediatePropagation?a.stopImmediatePropagation():a.propagationStopped=!0,a.stopPropagation(),a.preventDefault(),!1))))},a.prototype.onClick=function(a){var b;return this.trackingClick?(this.targetElement=null,this.trackingClick=!1,!0):"submit"===a.target.type&&0===a.detail||(b=this.onMouse(a),b||(this.targetElement=null),b)},a.prototype.destroy=function(){var a=this.layer;c&&(a.removeEventListener("mouseover",this.onMouse,!0),a.removeEventListener("mousedown",this.onMouse,!0),a.removeEventListener("mouseup",this.onMouse,!0)),a.removeEventListener("click",this.onClick,!0),a.removeEventListener("touchstart",this.onTouchStart,!1),a.removeEventListener("touchmove",this.onTouchMove,!1),a.removeEventListener("touchend",this.onTouchEnd,!1),a.removeEventListener("touchcancel",this.onTouchCancel,!1)},a.notNeeded=function(a){var b,d,e,f;if("undefined"==typeof window.ontouchstart)return!0;if(d=+(/Chrome\/([0-9]+)/.exec(navigator.userAgent)||[,0])[1]){if(!c)return!0;if(b=document.querySelector("meta[name=viewport]")){if(b.content.indexOf("user-scalable=no")!==-1)return!0;if(d>31&&document.documentElement.scrollWidth<=window.outerWidth)return!0}}if(g&&(e=navigator.userAgent.match(/Version\/([0-9]*)\.([0-9]*)/),e[1]>=10&&e[2]>=3&&(b=document.querySelector("meta[name=viewport]")))){if(b.content.indexOf("user-scalable=no")!==-1)return!0;if(document.documentElement.scrollWidth<=window.outerWidth)return!0}return"none"===a.style.msTouchAction||"manipulation"===a.style.touchAction||(f=+(/Firefox\/([0-9]+)/.exec(navigator.userAgent)||[,0])[1],!!(f>=27&&(b=document.querySelector("meta[name=viewport]"),b&&(b.content.indexOf("user-scalable=no")!==-1||document.documentElement.scrollWidth<=window.outerWidth)))||("none"===a.style.touchAction||"manipulation"===a.style.touchAction))},a.attach=function(b,c){return new a(b,c)},"function"==typeof define&&"object"==typeof define.amd&&define.amd?define(function(){return a}):"undefined"!=typeof module&&module.exports?(module.exports=a.attach,module.exports.FastClick=a):window.FastClick=a}();

/*! AdminLTE app.js
 * ================
 * Main JS application file for AdminLTE v2. This file
 * should be included in all pages. It controls some layout
 * options and implements exclusive AdminLTE plugins.
 *
 * @Author  Almsaeed Studio
 * @Support <http://www.almsaeedstudio.com>
 * @Email   <abdullah@almsaeedstudio.com>
 * @version 2.3.6
 * @license MIT <http://opensource.org/licenses/MIT>
 */

//Make sure jQuery has been loaded before app.js
if (typeof jQuery === "undefined") {
  throw new Error("AdminLTE requires jQuery");
}

/* AdminLTE
 *
 * @type Object
 * @description $.AdminLTE is the main object for the template's app.
 *              It's used for implementing functions and options related
 *              to the template. Keeping everything wrapped in an object
 *              prevents conflict with other plugins and is a better
 *              way to organize our code.
 */
$.AdminLTE = {};

	/* --------------------
	 * - AdminLTE Options -
	 * --------------------
	 * Modify these options to suit your implementation
	 */
	$.AdminLTE.options = {
	//Add slimscroll to navbar menus
	//This requires you to load the slimscroll plugin
	//in every page before app.js
	navbarMenuSlimscroll: true,
	navbarMenuSlimscrollWidth: "3px", //The width of the scroll bar
	navbarMenuHeight: "200px", //The height of the inner menu
	//General animation speed for JS animated elements such as box collapse/expand and
	//sidebar treeview slide up/down. This options accepts an integer as milliseconds,
	//'fast', 'normal', or 'slow'
	animationSpeed: 500,
	//Sidebar push menu toggle button selector
	sidebarToggleSelector: "[data-toggle='offcanvas']",
	//Activate sidebar push menu
	sidebarPushMenu: true,
	//Activate sidebar slimscroll if the fixed layout is set (requires SlimScroll Plugin)
	sidebarSlimScroll: true,
	//Enable sidebar expand on hover effect for sidebar mini
	//This option is forced to true if both the fixed layout and sidebar mini
	//are used together
	sidebarExpandOnHover: false,
	//BoxRefresh Plugin
	enableBoxRefresh: true,
	//Bootstrap.js tooltip
	enableBSToppltip: true,
	BSTooltipSelector: "[data-toggle='tooltip']",
	//Enable Fast Click. Fastclick.js creates a more
	//native touch experience with touch devices. If you
	//choose to enable the plugin, make sure you load the script
	//before AdminLTE's app.js
	enableFastclick: true,
	//Control Sidebar Options
	enableControlSidebar: true,
	controlSidebarOptions: {
		//Which button should trigger the open/close event
		toggleBtnSelector: "[data-toggle='control-sidebar']",
		//The sidebar selector
		selector: ".control-sidebar",
		//Enable slide over content
		slide: true
	},
	//Box Widget Plugin. Enable this plugin
	//to allow boxes to be collapsed and/or removed
	enableBoxWidget: true,
	//Box Widget plugin options
	boxWidgetOptions: {
		boxWidgetIcons: {
			//Collapse icon
			collapse: 'fa-minus',
			//Open icon
			open: 'fa-plus',
			//Remove icon
			remove: 'fa-times'
		},
		boxWidgetSelectors: {
			//Remove button selector
			remove: '[data-widget="remove"]',
			//Collapse button selector
			collapse: '[data-widget="collapse"]'
		}
	},
	//Direct Chat plugin options
	directChat: {
		//Enable direct chat by default
		enable: true,
		//The button to open and close the chat contacts pane
		contactToggleSelector: '[data-widget="chat-pane-toggle"]'
	},
	//Define the set of colors to use globally around the website
	colors: {
		lightBlue: "#3c8dbc",
		red: "#f56954",
		green: "#00a65a",
		aqua: "#00c0ef",
		yellow: "#f39c12",
		blue: "#0073b7",
		navy: "#001F3F",
		teal: "#39CCCC",
		olive: "#3D9970",
		lime: "#01FF70",
		orange: "#FF851B",
		fuchsia: "#F012BE",
		purple: "#8E24AA",
		maroon: "#D81B60",
		black: "#222222",
		gray: "#d2d6de"
	},
	//The standard screen sizes that bootstrap uses.
	//If you change these in the variables.less file, change
	//them here too.
	screenSizes: {
		xs: 480,
		sm: 768,
		md: 992,
		lg: 1200
	}
};

/* ------------------
 * - Implementation -
 * ------------------
 * The next block of code implements AdminLTE's
 * functions and plugins as specified by the
 * options above.
 */
$(function () {
	"use strict";

	//Fix for IE page transitions
	$("body").removeClass("hold-transition");

	//Extend options if external options exist
	if (typeof AdminLTEOptions !== "undefined") {
	$.extend(true, $.AdminLTE.options, AdminLTEOptions);
	}

	//Easy access to options
	var o = $.AdminLTE.options;

	//Set up the object
	_init();

	//Activate the layout maker
	$.AdminLTE.layout.activate();

	//Enable sidebar tree view controls
	$.AdminLTE.tree('.sidebar');

	//Enable control sidebar
	if (o.enableControlSidebar) {
		$.AdminLTE.controlSidebar.activate();
	}

	//Add slimscroll to navbar dropdown
	if (o.navbarMenuSlimscroll && typeof $.fn.slimscroll != 'undefined') {
		$(".navbar .menu").slimscroll({
			height: o.navbarMenuHeight,
			alwaysVisible: false,
			size: o.navbarMenuSlimscrollWidth
		}).css("width", "100%");
	}

	//Activate sidebar push menu
	if (o.sidebarPushMenu) {
		$.AdminLTE.pushMenu.activate(o.sidebarToggleSelector);
	}

	//Activate Bootstrap tooltip
	if (o.enableBSToppltip) {
		$('body').tooltip({
			selector: o.BSTooltipSelector
		});
	}

	//Activate box widget
	if (o.enableBoxWidget) {
		$.AdminLTE.boxWidget.activate();
	}

	//Activate fast click
	if (o.enableFastclick && typeof FastClick != 'undefined') {
		FastClick.attach(document.body);
	}

	//Activate direct chat widget
	if (o.directChat.enable) {
		$(document).on('click', o.directChat.contactToggleSelector, function () {
			var box = $(this).parents('.direct-chat').first();
			box.toggleClass('direct-chat-contacts-open');
		});
	}

  /*
   * INITIALIZE BUTTON TOGGLE
   * ------------------------
   */
	$('.btn-group[data-toggle="btn-toggle"]').each(function () {
		var group = $(this);
		$(this).find(".btn").on('click', function (e) {
			group.find(".btn.active").removeClass("active");
			$(this).addClass("active");
			e.preventDefault();
		});
	});
});

/* ----------------------------------
 * - Initialize the AdminLTE Object -
 * ----------------------------------
 * All AdminLTE functions are implemented below.
 */
function _init() {
  'use strict';
  /* Layout
   * ======
   * Fixes the layout height in case min-height fails.
   *
   * @type Object
   * @usage $.AdminLTE.layout.activate()
   *        $.AdminLTE.layout.fix()
   *        $.AdminLTE.layout.fixSidebar()
   */
  $.AdminLTE.layout = {
	activate: function () {
	  var _this = this;
	  _this.fix();
	  _this.fixSidebar();
	  $(window, ".wrapper").resize(function () {
		_this.fix();
		_this.fixSidebar();
	  });
	},
	fix: function () {
	  //Get window height and the wrapper height
	  var neg = $('.main-header').outerHeight() + $('.main-footer').outerHeight();
	  var window_height = $(window).height();
	  var sidebar_height = $(".sidebar").height();
	  //Set the min-height of the content and sidebar based on the
	  //the height of the document.
	  if ($("body").hasClass("fixed")) {
		$(".content-wrapper, .right-side").css('min-height', window_height - $('.main-footer').outerHeight());
	  } else {
		var postSetWidth;
		if (window_height >= sidebar_height) {
		  $(".content-wrapper, .right-side").css('min-height', window_height - neg);
		  postSetWidth = window_height - neg;
		} else {
		  $(".content-wrapper, .right-side").css('min-height', sidebar_height);
		  postSetWidth = sidebar_height;
		}

		//Fix for the control sidebar height
		var controlSidebar = $($.AdminLTE.options.controlSidebarOptions.selector);
		if (typeof controlSidebar !== "undefined") {
		  if (controlSidebar.height() > postSetWidth)
			$(".content-wrapper, .right-side").css('min-height', controlSidebar.height());
		}

	  }
	},
	fixSidebar: function () {
	  //Make sure the body tag has the .fixed class
	  if (!$("body").hasClass("fixed")) {
		if (typeof $.fn.slimScroll != 'undefined') {
		  $(".sidebar").slimScroll({destroy: true}).height("auto");
		}
		return;
	  } else if (typeof $.fn.slimScroll == 'undefined' && window.console) {
		window.console.error("Error: the fixed layout requires the slimscroll plugin!");
	  }
	  //Enable slimscroll for fixed layout
	  if ($.AdminLTE.options.sidebarSlimScroll) {
		if (typeof $.fn.slimScroll != 'undefined') {
		  //Destroy if it exists
		  $(".sidebar").slimScroll({destroy: true}).height("auto");
		  //Add slimscroll
		  $(".sidebar").slimscroll({
			height: ($(window).height() - $(".main-header").height()) + "px",
			color: "rgba(0,0,0,0.2)",
			size: "3px"
		  });
		}
	  }
	}
  };

  /* PushMenu()
   * ==========
   * Adds the push menu functionality to the sidebar.
   *
   * @type Function
   * @usage: $.AdminLTE.pushMenu("[data-toggle='offcanvas']")
   */
  $.AdminLTE.pushMenu = {
	activate: function (toggleBtn) {
	  //Get the screen sizes
	  var screenSizes = $.AdminLTE.options.screenSizes;

	  //Enable sidebar toggle
	  $(document).on('click', toggleBtn, function (e) {
		e.preventDefault();

		//Enable sidebar push menu
		if ($(window).width() > (screenSizes.sm - 1)) {
		  if ($("body").hasClass('sidebar-collapse')) {
			$("body").removeClass('sidebar-collapse').trigger('expanded.pushMenu');
		  } else {
			$("body").addClass('sidebar-collapse').trigger('collapsed.pushMenu');
		  }
		}
		//Handle sidebar push menu for small screens
		else {
		  if ($("body").hasClass('sidebar-open')) {
			$("body").removeClass('sidebar-open').removeClass('sidebar-collapse').trigger('collapsed.pushMenu');
		  } else {
			$("body").addClass('sidebar-open').trigger('expanded.pushMenu');
		  }
		}
	  });

	  $(".content-wrapper").click(function () {
		//Enable hide menu when clicking on the content-wrapper on small screens
		if ($(window).width() <= (screenSizes.sm - 1) && $("body").hasClass("sidebar-open")) {
		  $("body").removeClass('sidebar-open');
		}
	  });

	  //Enable expand on hover for sidebar mini
	  if ($.AdminLTE.options.sidebarExpandOnHover
		|| ($('body').hasClass('fixed')
		&& $('body').hasClass('sidebar-mini'))) {
		this.expandOnHover();
	  }
	},
	expandOnHover: function () {
	  var _this = this;
	  var screenWidth = $.AdminLTE.options.screenSizes.sm - 1;
	  //Expand sidebar on hover
	  $('.main-sidebar').hover(function () {
		if ($('body').hasClass('sidebar-mini')
		  && $("body").hasClass('sidebar-collapse')
		  && $(window).width() > screenWidth) {
		  _this.expand();
		}
	  }, function () {
		if ($('body').hasClass('sidebar-mini')
		  && $('body').hasClass('sidebar-expanded-on-hover')
		  && $(window).width() > screenWidth) {
		  _this.collapse();
		}
	  });
	},
	expand: function () {
	  $("body").removeClass('sidebar-collapse').addClass('sidebar-expanded-on-hover');
	},
	collapse: function () {
	  if ($('body').hasClass('sidebar-expanded-on-hover')) {
		$('body').removeClass('sidebar-expanded-on-hover').addClass('sidebar-collapse');
	  }
	}
  };

  /* Tree()
   * ======
   * Converts the sidebar into a multilevel
   * tree view menu.
   *
   * @type Function
   * @Usage: $.AdminLTE.tree('.sidebar')
   */
  $.AdminLTE.tree = function (menu) {
	var _this = this;
	var animationSpeed = $.AdminLTE.options.animationSpeed;
	$(document).off('click', menu + ' li a')
	  .on('click', menu + ' li a', function (e) {
		//Get the clicked link and the next element
		var $this = $(this);
		var checkElement = $this.next();

		//Check if the next element is a menu and is visible
		if ((checkElement.is('.treeview-menu')) && (checkElement.is(':visible')) && (!$('body').hasClass('sidebar-collapse'))) {
		  //Close the menu
		  checkElement.slideUp(animationSpeed, function () {
			checkElement.removeClass('menu-open');
			//Fix the layout in case the sidebar stretches over the height of the window
			//_this.layout.fix();
		  });
		  checkElement.parent("li").removeClass("active");
		}
		//If the menu is not visible
		else if ((checkElement.is('.treeview-menu')) && (!checkElement.is(':visible'))) {
		  //Get the parent menu
		  var parent = $this.parents('ul').first();
		  //Close all open menus within the parent
		  var ul = parent.find('ul:visible').slideUp(animationSpeed);
		  //Remove the menu-open class from the parent
		  ul.removeClass('menu-open');
		  //Get the parent li
		  var parent_li = $this.parent("li");

		  //Open the target menu and add the menu-open class
		  checkElement.slideDown(animationSpeed, function () {
			//Add the class active to the parent li
			checkElement.addClass('menu-open');
			parent.find('li.active').removeClass('active');
			parent_li.addClass('active');
			//Fix the layout in case the sidebar stretches over the height of the window
			_this.layout.fix();
		  });
		}
		//if this isn't a link, prevent the page from being redirected
		if (checkElement.is('.treeview-menu')) {
		  e.preventDefault();
		}
	  });
  };

  /* ControlSidebar
   * ==============
   * Adds functionality to the right sidebar
   *
   * @type Object
   * @usage $.AdminLTE.controlSidebar.activate(options)
   */
  $.AdminLTE.controlSidebar = {
	//instantiate the object
	activate: function () {
	  //Get the object
	  var _this = this;
	  //Update options
	  var o = $.AdminLTE.options.controlSidebarOptions;
	  //Get the sidebar
	  var sidebar = $(o.selector);
	  //The toggle button
	  var btn = $(o.toggleBtnSelector);

	  //Listen to the click event
	  btn.on('click', function (e) {
		e.preventDefault();
		//If the sidebar is not open
		if (!sidebar.hasClass('control-sidebar-open')
		  && !$('body').hasClass('control-sidebar-open')) {
		  //Open the sidebar
		  _this.open(sidebar, o.slide);
		} else {
		  _this.close(sidebar, o.slide);
		}
	  });

	  //If the body has a boxed layout, fix the sidebar bg position
	  var bg = $(".control-sidebar-bg");
	  _this._fix(bg);

	  //If the body has a fixed layout, make the control sidebar fixed
	  if ($('body').hasClass('fixed')) {
		_this._fixForFixed(sidebar);
	  } else {
		//If the content height is less than the sidebar's height, force max height
		if ($('.content-wrapper, .right-side').height() < sidebar.height()) {
		  _this._fixForContent(sidebar);
		}
	  }
	},
	//Open the control sidebar
	open: function (sidebar, slide) {
	  //Slide over content
	  if (slide) {
		sidebar.addClass('control-sidebar-open');
	  } else {
		//Push the content by adding the open class to the body instead
		//of the sidebar itself
		$('body').addClass('control-sidebar-open');
	  }
	},
	//Close the control sidebar
	close: function (sidebar, slide) {
	  if (slide) {
		sidebar.removeClass('control-sidebar-open');
	  } else {
		$('body').removeClass('control-sidebar-open');
	  }
	},
	_fix: function (sidebar) {
	  var _this = this;
	  if ($("body").hasClass('layout-boxed')) {
		sidebar.css('position', 'absolute');
		sidebar.height($(".wrapper").height());
		if (_this.hasBindedResize) {
		  return;
		}
		$(window).resize(function () {
		  _this._fix(sidebar);
		});
		_this.hasBindedResize = true;
	  } else {
		sidebar.css({
		  'position': 'fixed',
		  'height': 'auto'
		});
	  }
	},
	_fixForFixed: function (sidebar) {
	  sidebar.css({
		'position': 'fixed',
		'max-height': '100%',
		'overflow': 'auto',
		'padding-bottom': '50px'
	  });
	},
	_fixForContent: function (sidebar) {
	  $(".content-wrapper, .right-side").css('min-height', sidebar.height());
	}
  };

  /* BoxWidget
   * =========
   * BoxWidget is a plugin to handle collapsing and
   * removing boxes from the screen.
   *
   * @type Object
   * @usage $.AdminLTE.boxWidget.activate()
   *        Set all your options in the main $.AdminLTE.options object
   */
  $.AdminLTE.boxWidget = {
	selectors: $.AdminLTE.options.boxWidgetOptions.boxWidgetSelectors,
	icons: $.AdminLTE.options.boxWidgetOptions.boxWidgetIcons,
	animationSpeed: $.AdminLTE.options.animationSpeed,
	activate: function (_box) {
	  var _this = this;
	  if (!_box) {
		_box = document; // activate all boxes per default
	  }
	  //Listen for collapse event triggers
	  $(_box).on('click', _this.selectors.collapse, function (e) {
		e.preventDefault();
		_this.collapse($(this));
	  });

	  //Listen for remove event triggers
	  $(_box).on('click', _this.selectors.remove, function (e) {
		e.preventDefault();
		_this.remove($(this));
	  });
	},
	collapse: function (element) {
	  var _this = this;
	  //Find the box parent
	  var box = element.parents(".box").first();
	  //Find the body and the footer
	  var box_content = box.find("> .box-body, > .box-footer, > form  >.box-body, > form > .box-footer");
	  if (!box.hasClass("collapsed-box")) {
		//Convert minus into plus
		element.children(":first")
		  .removeClass(_this.icons.collapse)
		  .addClass(_this.icons.open);
		//Hide the content
		box_content.slideUp(_this.animationSpeed, function () {
		  box.addClass("collapsed-box");
		});
	  } else {
		//Convert plus into minus
		element.children(":first")
		  .removeClass(_this.icons.open)
		  .addClass(_this.icons.collapse);
		//Show the content
		box_content.slideDown(_this.animationSpeed, function () {
		  box.removeClass("collapsed-box");
		});
	  }
	},
	remove: function (element) {
	  //Find the box parent
	  var box = element.parents(".box").first();
	  box.slideUp(this.animationSpeed);
	}
  };
}

/* ------------------
 * - Custom Plugins -
 * ------------------
 * All custom plugins are defined below.
 */

/*
 * BOX REFRESH BUTTON
 * ------------------
 * This is a custom plugin to use with the component BOX. It allows you to add
 * a refresh button to the box. It converts the box's state to a loading state.
 *
 * @type plugin
 * @usage $("#box-widget").boxRefresh( options );
 */
(function ($) {

  "use strict";

  $.fn.boxRefresh = function (options) {

	// Render options
	var settings = $.extend({
	  //Refresh button selector
	  trigger: ".refresh-btn",
	  //File source to be loaded (e.g: ajax/src.php)
	  source: "",
	  //Callbacks
	  onLoadStart: function (box) {
		return box;
	  }, //Right after the button has been clicked
	  onLoadDone: function (box) {
		return box;
	  } //When the source has been loaded

	}, options);

	//The overlay
	var overlay = $('<div class="overlay"><div class="fa fa-refresh fa-spin"></div></div>');

	return this.each(function () {
	  //if a source is specified
	  if (settings.source === "") {
		if (window.console) {
		  window.console.log("Please specify a source first - boxRefresh()");
		}
		return;
	  }
	  //the box
	  var box = $(this);
	  //the button
	  var rBtn = box.find(settings.trigger).first();

	  //On trigger click
	  rBtn.on('click', function (e) {
		e.preventDefault();
		//Add loading overlay
		start(box);

		//Perform ajax call
		box.find(".box-body").load(settings.source, function () {
		  done(box);
		});
	  });
	});

	function start(box) {
	  //Add overlay and loading img
	  box.append(overlay);

	  settings.onLoadStart.call(box);
	}

	function done(box) {
	  //Remove overlay and loading img
	  box.find(overlay).remove();

	  settings.onLoadDone.call(box);
	}

  };
})(jQuery);

/*
 * EXPLICIT BOX CONTROLS
 * -----------------------
 * This is a custom plugin to use with the component BOX. It allows you to activate
 * a box inserted in the DOM after the app.js was loaded, toggle and remove box.
 *
 * @type plugin
 * @usage $("#box-widget").activateBox();
 * @usage $("#box-widget").toggleBox();
 * @usage $("#box-widget").removeBox();
 */
(function ($) {

  'use strict';

  $.fn.activateBox = function () {
	$.AdminLTE.boxWidget.activate(this);
  };

  $.fn.toggleBox = function () {
	var button = $($.AdminLTE.boxWidget.selectors.collapse, this);
	$.AdminLTE.boxWidget.collapse(button);
  };

  $.fn.removeBox = function () {
	var button = $($.AdminLTE.boxWidget.selectors.remove, this);
	$.AdminLTE.boxWidget.remove(button);
  };
})(jQuery);

/*
 * TODO LIST CUSTOM PLUGIN
 * -----------------------
 * This plugin depends on iCheck plugin for checkbox and radio inputs
 *
 * @type plugin
 * @usage $("#todo-widget").todolist( options );
 */
(function ($) {

  'use strict';

  $.fn.todolist = function (options) {
	// Render options
	var settings = $.extend({
	  //When the user checks the input
	  onCheck: function (ele) {
		return ele;
	  },
	  //When the user unchecks the input
	  onUncheck: function (ele) {
		return ele;
	  }
	}, options);

	return this.each(function () {

	  if (typeof $.fn.iCheck != 'undefined') {
		$('input', this).on('ifChecked', function () {
		  var ele = $(this).parents("li").first();
		  ele.toggleClass("done");
		  settings.onCheck.call(ele);
		});

		$('input', this).on('ifUnchecked', function () {
		  var ele = $(this).parents("li").first();
		  ele.toggleClass("done");
		  settings.onUncheck.call(ele);
		});
	  } else {
		$('input', this).on('change', function () {
		  var ele = $(this).parents("li").first();
		  ele.toggleClass("done");
		  if ($('input', ele).is(":checked")) {
			settings.onCheck.call(ele);
		  } else {
			settings.onUncheck.call(ele);
		  }
		});
	  }
	});
  };
}(jQuery));
