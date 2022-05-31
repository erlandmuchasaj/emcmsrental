"use strict";
!function(a){"use strict";"function"==typeof define&&define.amd?define(["jquery"],a):a("object"==typeof exports?require("jquery"):jQuery)}(function(a){"use strict";function b(a){return"string"==typeof a?parseInt(a,10):~~a}var c={wheelSpeed:1,wheelPropagation:!1,swipePropagation:!0,minScrollbarLength:null,maxScrollbarLength:null,useBothWheelAxes:!1,useKeyboard:!0,suppressScrollX:!1,suppressScrollY:!1,scrollXMarginOffset:0,scrollYMarginOffset:0,includePadding:!1},d=0,e=function(){var a=d++;return function(b){var c=".perfect-scrollbar-"+a;return void 0===b?c:b+c}},f="WebkitAppearance"in document.documentElement.style;a.fn.perfectScrollbar=function(d,g){return this.each(function(){function h(a,c){var d=a+c,e=C-K;L=0>d?0:d>e?e:d;var f=b(L*(E-C)/(C-K));z.scrollTop(f)}function i(a,c){var d=a+c,e=B-G;H=0>d?0:d>e?e:d;var f=b(H*(D-B)/(B-G));z.scrollLeft(f)}function j(a){return y.minScrollbarLength&&(a=Math.max(a,y.minScrollbarLength)),y.maxScrollbarLength&&(a=Math.min(a,y.maxScrollbarLength)),a}function k(){var a={width:I};a.left=N?z.scrollLeft()+B-D:z.scrollLeft(),T?a.bottom=S-z.scrollTop():a.top=U+z.scrollTop(),Q.css(a);var b={top:z.scrollTop(),height:M};$?b.right=N?D-z.scrollLeft()-Z-Y.outerWidth():Z-z.scrollLeft():b.left=N?z.scrollLeft()+2*B-D-_-Y.outerWidth():_+z.scrollLeft(),X.css(b),R.css({left:H,width:G-V}),Y.css({top:L,height:K-ab})}function l(){z.removeClass("ps-active-x"),z.removeClass("ps-active-y"),B=y.includePadding?z.innerWidth():z.width(),C=y.includePadding?z.innerHeight():z.height(),D=z.prop("scrollWidth"),E=z.prop("scrollHeight"),!y.suppressScrollX&&D>B+y.scrollXMarginOffset?(F=!0,I=B-W,G=j(b(I*B/D)),H=b(z.scrollLeft()*(I-G)/(D-B))):(F=!1,G=0,H=0,z.scrollLeft(0)),!y.suppressScrollY&&E>C+y.scrollYMarginOffset?(J=!0,M=C-bb,K=j(b(M*C/E)),L=b(z.scrollTop()*(M-K)/(E-C))):(J=!1,K=0,L=0,z.scrollTop(0)),H>=I-G&&(H=I-G),L>=M-K&&(L=M-K),k(),F&&z.addClass("ps-active-x"),J&&z.addClass("ps-active-y")}function m(){var b,c,d=function(a){i(b,a.pageX-c),l(),a.stopPropagation(),a.preventDefault()},e=function(){Q.removeClass("in-scrolling"),a(P).unbind(O("mousemove"),d)};R.bind(O("mousedown"),function(f){c=f.pageX,b=R.position().left,Q.addClass("in-scrolling"),a(P).bind(O("mousemove"),d),a(P).one(O("mouseup"),e),f.stopPropagation(),f.preventDefault()}),b=c=null}function n(){var b,c,d=function(a){h(b,a.pageY-c),l(),a.stopPropagation(),a.preventDefault()},e=function(){X.removeClass("in-scrolling"),a(P).unbind(O("mousemove"),d)};Y.bind(O("mousedown"),function(f){c=f.pageY,b=Y.position().top,X.addClass("in-scrolling"),a(P).bind(O("mousemove"),d),a(P).one(O("mouseup"),e),f.stopPropagation(),f.preventDefault()}),b=c=null}function o(a,b){var c=z.scrollTop();if(0===a){if(!J)return!1;if(0===c&&b>0||c>=E-C&&0>b)return!y.wheelPropagation}var d=z.scrollLeft();if(0===b){if(!F)return!1;if(0===d&&0>a||d>=D-B&&a>0)return!y.wheelPropagation}return!0}function p(a,b){var c=z.scrollTop(),d=z.scrollLeft(),e=Math.abs(a),f=Math.abs(b);if(f>e){if(0>b&&c===E-C||b>0&&0===c)return!y.swipePropagation}else if(e>f&&(0>a&&d===D-B||a>0&&0===d))return!y.swipePropagation;return!0}function q(){function a(a){var b=a.originalEvent.deltaX,c=-1*a.originalEvent.deltaY;return(void 0===b||void 0===c)&&(b=-1*a.originalEvent.wheelDeltaX/6,c=a.originalEvent.wheelDeltaY/6),a.originalEvent.deltaMode&&1===a.originalEvent.deltaMode&&(b*=10,c*=10),b!==b&&c!==c&&(b=0,c=a.originalEvent.wheelDelta),[b,c]}function b(b){if(f||!(z.find("select:focus").length>0)){var d=a(b),e=d[0],g=d[1];c=!1,y.useBothWheelAxes?J&&!F?(z.scrollTop(g?z.scrollTop()-g*y.wheelSpeed:z.scrollTop()+e*y.wheelSpeed),c=!0):F&&!J&&(z.scrollLeft(e?z.scrollLeft()+e*y.wheelSpeed:z.scrollLeft()-g*y.wheelSpeed),c=!0):(z.scrollTop(z.scrollTop()-g*y.wheelSpeed),z.scrollLeft(z.scrollLeft()+e*y.wheelSpeed)),l(),c=c||o(e,g),c&&(b.stopPropagation(),b.preventDefault())}}var c=!1;void 0!==window.onwheel?z.bind(O("wheel"),b):void 0!==window.onmousewheel&&z.bind(O("mousewheel"),b)}function r(){var b=!1;z.bind(O("mouseenter"),function(){b=!0}),z.bind(O("mouseleave"),function(){b=!1});var c=!1;a(P).bind(O("keydown"),function(d){if((!d.isDefaultPrevented||!d.isDefaultPrevented())&&b){for(var e=document.activeElement?document.activeElement:P.activeElement;e.shadowRoot;)e=e.shadowRoot.activeElement;if(!a(e).is(":input,[contenteditable]")){var f=0,g=0;switch(d.which){case 37:f=-30;break;case 38:g=30;break;case 39:f=30;break;case 40:g=-30;break;case 33:g=90;break;case 32:case 34:g=-90;break;case 35:g=d.ctrlKey?-E:-C;break;case 36:g=d.ctrlKey?z.scrollTop():C;break;default:return}z.scrollTop(z.scrollTop()-g),z.scrollLeft(z.scrollLeft()+f),c=o(f,g),c&&d.preventDefault()}}})}function s(){function a(a){a.stopPropagation()}Y.bind(O("click"),a),X.bind(O("click"),function(a){var c=b(K/2),d=a.pageY-X.offset().top-c,e=C-K,f=d/e;0>f?f=0:f>1&&(f=1),z.scrollTop((E-C)*f)}),R.bind(O("click"),a),Q.bind(O("click"),function(a){var c=b(G/2),d=a.pageX-Q.offset().left-c,e=B-G,f=d/e;0>f?f=0:f>1&&(f=1),z.scrollLeft((D-B)*f)})}function t(){function b(){var a=window.getSelection?window.getSelection():document.getSlection?document.getSlection():{rangeCount:0};return 0===a.rangeCount?null:a.getRangeAt(0).commonAncestorContainer}function c(){e||(e=setInterval(function(){return A()?(z.scrollTop(z.scrollTop()+f.top),z.scrollLeft(z.scrollLeft()+f.left),void l()):void clearInterval(e)},50))}function d(){e&&(clearInterval(e),e=null),Q.removeClass("in-scrolling"),X.removeClass("in-scrolling")}var e=null,f={top:0,left:0},g=!1;a(P).bind(O("selectionchange"),function(){a.contains(z[0],b())?g=!0:(g=!1,d())}),a(window).bind(O("mouseup"),function(){g&&(g=!1,d())}),a(window).bind(O("mousemove"),function(a){if(g){var b={x:a.pageX,y:a.pageY},e=z.offset(),h={left:e.left,right:e.left+z.outerWidth(),top:e.top,bottom:e.top+z.outerHeight()};b.x<h.left+3?(f.left=-5,Q.addClass("in-scrolling")):b.x>h.right-3?(f.left=5,Q.addClass("in-scrolling")):f.left=0,b.y<h.top+3?(f.top=5>h.top+3-b.y?-5:-20,X.addClass("in-scrolling")):b.y>h.bottom-3?(f.top=5>b.y-h.bottom+3?5:20,X.addClass("in-scrolling")):f.top=0,0===f.top&&0===f.left?d():c()}})}function u(b,c){function d(a,b){z.scrollTop(z.scrollTop()-b),z.scrollLeft(z.scrollLeft()-a),l()}function e(){r=!0}function f(){r=!1}function g(a){return a.originalEvent.targetTouches?a.originalEvent.targetTouches[0]:a.originalEvent}function h(a){var b=a.originalEvent;return b.targetTouches&&1===b.targetTouches.length?!0:b.pointerType&&"mouse"!==b.pointerType&&b.pointerType!==b.MSPOINTER_TYPE_MOUSE?!0:!1}function i(a){if(h(a)){s=!0;var b=g(a);m.pageX=b.pageX,m.pageY=b.pageY,n=(new Date).getTime(),null!==q&&clearInterval(q),a.stopPropagation()}}function j(a){if(!r&&s&&h(a)){var b=g(a),c={pageX:b.pageX,pageY:b.pageY},e=c.pageX-m.pageX,f=c.pageY-m.pageY;d(e,f),m=c;var i=(new Date).getTime(),j=i-n;j>0&&(o.x=e/j,o.y=f/j,n=i),p(e,f)&&(a.stopPropagation(),a.preventDefault())}}function k(){!r&&s&&(s=!1,clearInterval(q),q=setInterval(function(){return A()?.01>Math.abs(o.x)&&.01>Math.abs(o.y)?void clearInterval(q):(d(30*o.x,30*o.y),o.x*=.8,void(o.y*=.8)):void clearInterval(q)},10))}var m={},n=0,o={},q=null,r=!1,s=!1;b&&(a(window).bind(O("touchstart"),e),a(window).bind(O("touchend"),f),z.bind(O("touchstart"),i),z.bind(O("touchmove"),j),z.bind(O("touchend"),k)),c&&(window.PointerEvent?(a(window).bind(O("pointerdown"),e),a(window).bind(O("pointerup"),f),z.bind(O("pointerdown"),i),z.bind(O("pointermove"),j),z.bind(O("pointerup"),k)):window.MSPointerEvent&&(a(window).bind(O("MSPointerDown"),e),a(window).bind(O("MSPointerUp"),f),z.bind(O("MSPointerDown"),i),z.bind(O("MSPointerMove"),j),z.bind(O("MSPointerUp"),k)))}function v(){z.bind(O("scroll"),function(){l()})}function w(){z.unbind(O()),a(window).unbind(O()),a(P).unbind(O()),z.data("perfect-scrollbar",null),z.data("perfect-scrollbar-update",null),z.data("perfect-scrollbar-destroy",null),R.remove(),Y.remove(),Q.remove(),X.remove(),z=Q=X=R=Y=F=J=B=C=D=E=G=H=S=T=U=K=L=Z=$=_=N=O=null}function x(){l(),v(),m(),n(),s(),t(),q(),(cb||db)&&u(cb,db),y.useKeyboard&&r(),z.data("perfect-scrollbar",z),z.data("perfect-scrollbar-update",l),z.data("perfect-scrollbar-destroy",w)}var y=a.extend(!0,{},c),z=a(this),A=function(){return!!z};if("object"==typeof d?a.extend(!0,y,d):g=d,"update"===g)return z.data("perfect-scrollbar-update")&&z.data("perfect-scrollbar-update")(),z;if("destroy"===g)return z.data("perfect-scrollbar-destroy")&&z.data("perfect-scrollbar-destroy")(),z;if(z.data("perfect-scrollbar"))return z.data("perfect-scrollbar");z.addClass("ps-container");var B,C,D,E,F,G,H,I,J,K,L,M,N="rtl"===z.css("direction"),O=e(),P=this.ownerDocument||document,Q=a("<div class='ps-scrollbar-x-rail'>").appendTo(z),R=a("<div class='ps-scrollbar-x'>").appendTo(Q),S=b(Q.css("bottom")),T=S===S,U=T?null:b(Q.css("top")),V=b(Q.css("borderLeftWidth"))+b(Q.css("borderRightWidth")),W=b(Q.css("marginLeft"))+b(Q.css("marginRight")),X=a("<div class='ps-scrollbar-y-rail'>").appendTo(z),Y=a("<div class='ps-scrollbar-y'>").appendTo(X),Z=b(X.css("right")),$=Z===Z,_=$?null:b(X.css("left")),ab=b(X.css("borderTopWidth"))+b(X.css("borderBottomWidth")),bb=b(X.css("marginTop"))+b(X.css("marginBottom")),cb="ontouchstart"in window||window.DocumentTouch&&document instanceof window.DocumentTouch,db=null!==window.navigator.msMaxTouchPoints;return x(),z})}});
function Timer(a,b,c,d,e,f){function H(a,b,c){try{a=addEventListener(b,c)}catch(d){a=attachEvent("on"+b,c)}}function I(a){var b=a.match(/^\d*\d\/\d*\d\/(\d{4})/),c=a.match(/^\d*\d\/(\d*\d)/),d=a.match(/^(\d*\d)/),e=a.match(/^\d*\d\/\d*\d\/\d{4} +(\d*\d)/),f=a.match(/^\d*\d\/\d*\d\/\d{4} +\d*\d:(\d*\d)/),g=new Date(b[1],parseInt(d[1])-1,c[1],e[1],f[1]).getTime();return g}function J(){var a=w-Date.now();a<0?(v.days=0,v.hours=0,v.minutes=0,v.seconds=0):(v.days=Math.floor(a/o),a-=v.days*o,v.hours=Math.floor(a/p),a-=v.hours*p,v.minutes=Math.floor(a/q),a-=v.minutes*q,v.seconds=Math.floor(a/1e3)),-1!==E?N(E):M()}function K(b){for(var b=b||(a.width-g-8*e+4*f)/3,c=0;c<4;c++)t={},t.x=g+e+c*(b+e)+f/2,t.y=e+g,t.opacity=m[c],u[c]=t;M()}function L(){s.clearRect(0,0,a.width,a.height)}function M(){L();for(var a=0,c=0,d=e-j-Math.floor(f/2),g=0,h=0,i=0;i<4;i++){switch(s.beginPath(),s.arc(u[i].x,u[i].y,e,0,2*Math.PI,!1),s.strokeStyle="rgba("+b+","+u[i].opacity+")",s.lineWidth=f,s.stroke(),s.closePath(),s.beginPath(),i){case 0:g=1.5*Math.PI-2*Math.PI/x*v.days;break;case 1:g=-1*(2*Math.PI/24)*v.hours;break;case 2:g=.5*Math.PI-2*Math.PI/60*v.minutes;break;case 3:g=Math.PI-2*Math.PI/60*v.seconds}a=u[i].x+d*Math.cos(g),c=u[i].y+d*Math.sin(g),s.arc(a,c,l,0,2*Math.PI,!1),s.fillStyle="rgba("+b+","+u[i].opacity+")",s.lineWidth=f,s.fill(),s.closePath()}if(-1!==E){switch(s.beginPath(),E){case 3:g=Math.PI-2*Math.PI/60*v.seconds,h=Math.PI;break;case 2:g=.5*Math.PI-2*Math.PI/60*v.minutes,h=.5*Math.PI;break;case 1:g=-1*(2*Math.PI/24)*v.hours,h=0;break;case 0:g=1.5*Math.PI-2*Math.PI/x*v.days,h=1.5*Math.PI}s.arc(u[E].x,u[E].y,d,g,h,!1),s.lineWidth=n,s.strokeStyle="rgba("+b+","+(u[E].opacity-.3)+")",s.stroke(),s.closePath()}}function N(a){L(),M();var c="",d="",g=0,j=0,l=0,m=0;switch(a){case 0:c=v.days+"",d="DAYS";break;case 1:c=v.hours+"",d="HOURS";break;case 2:c=v.minutes+"",d="MINUTES";break;case 3:c=v.seconds+"",d="SECONDS";break;default:return}g=u[a].x,j=u[a].y+2*e+f+k,l=u[a].x,m=j+18,s.textAlign="center",s.font=i+" 24px "+h,s.fillStyle="rgba("+b+","+u[a].opacity+")",s.fillText(c,g,j),s.font=i+" 14px "+h,s.fillText(d,l,m)}function O(a){return Math.pow(a,3)}function P(a,b,c){clearInterval(A),y=!0;for(var d=g+(G-2*g-1.5*f-8*e)/2,h=h||18,c=c||100,i=(new Date).getTime(),j=[],k=[],a=a||"",l=0;l<4;l++)k[l]=d+e+f/2+2*l*e,j[l]=u[l].x;A=setInterval(function(){var f,d=(new Date).getTime()-i,e=d/c;e=e>1?1:e;for(var h=0;h<4;h++)f=(k[h]-j[h])*O(e)+j[h],u[h].x=f;M(),1===e&&(clearInterval(A),"start"===a?R():"returnOpacity"===a?Q(b):(y=!1,z=!1))},h)}function Q(a,b,c){for(var c=c||14,b=b||200,d=D++,e=[],f=[],g=(new Date).getTime(),h=0;h<4;h++)e[h]=u[h].opacity,f[h]=m[h];C[d]=setInterval(function(){var i,c=(new Date).getTime()-g,h=c/b;h=h>1?1:h;for(var j=0;j<4;j++)i=(f[j]-e[j])*h+e[j],u[j].opacity=i;M(),1===h&&(clearInterval(C[d]),y=!1,z=!1,F?Z(r):(E=-1,V(a)))},c)}function R(a,b,c){y=!0;for(var a=a||"show",c=c||14,b=b||200,d=(new Date).getTime(),e=[],f=[],g=0;g<4;g++)e[g]=u[g].opacity,f[g]="show"===a?1:m[g];A=setInterval(function(){var h,c=(new Date).getTime()-d,g=c/b;g=g>1?1:g;for(var i=0;i<4;i++)h=(f[i]-e[i])*g+e[i],u[i].opacity=h;M(),1===g&&(clearInterval(A),"show"===a?R("hide",250):y=!1)},c)}function S(a,b,c){y=!0,z=!0;for(var h,c=c||14,b=b||250,d=(new Date).getTime(),f=[],g=[],i=0;i<4;i++)a!==i?(f[i]=u[i].x,g[i]=i>a?u[i].x+2*e:u[i].x-2*e):h=u[i].opacity;A=setInterval(function(){var i,j,c=(new Date).getTime()-d,e=c/b;e=e>1?1:e;for(var k=0;k<4;k++)k!==a?(i=(g[k]-f[k])*O(e)+f[k],u[k].x=i):(j=(1-h)*O(e)+h,u[k].opacity=j);N(a),1===e&&(clearInterval(A),y=!1)},c)}function T(a,b,c,d){return Math.sqrt((a-c)*(a-c)+(b-d)*(b-d))<=e+f}function U(){var b=a,c=b.getContext("2d"),d=window.devicePixelRatio||1,e=c.webkitBackingStorePixelRatio||c.mozBackingStorePixelRatio||c.msBackingStorePixelRatio||c.oBackingStorePixelRatio||c.backingStorePixelRatio||1,f=d/e;if(d!==e){var g=b.width,h=b.height;b.width=g*f,b.height=h*f,b.style.width=g+"px",b.style.height=h+"px",c.scale(f,f)}}function V(a){switch(a){case 0:return void(0!==E&&(E=0,S(0)));case 1:return void(1!==E&&(E=1,S(1)));case 2:return void(2!==E&&(E=2,S(2)));case 3:return void(3!==E&&(E=3,S(3)))}}function W(a){return a.getBoundingClientRect?Y(a):X(a)}function X(a){for(var b=0,c=0;a;)b+=parseInt(a.offsetTop),c+=parseInt(a.offsetLeft),a=a.offsetParent;return{top:b,left:c}}function Y(a){var b=a.getBoundingClientRect(),c=document.body,d=document.documentElement,e=window.pageYOffset||d.scrollTop||c.scrollTop,f=window.pageXOffset||d.scrollLeft||c.scrollLeft,g=d.clientTop||c.clientTop||0,h=d.clientLeft||c.clientLeft||0,i=b.top+e-g,j=b.left+f-h;return{top:Math.round(i),left:Math.round(j)}}function Z(b){var b=b||event,c=!1,d=-1;if(r.pageX=b.pageX,r.pageY=b.pageY,!y){for(var e=W(a),f=0;f<4;f++)if(T(e.left+u[f].x,e.top+u[f].y,b.pageX,b.pageY)){(E===f||-1===E)&&(c=!0,d=f);break}z&&!c&&(P("returnOpacity"),z=!1,E=-1),V(d)}}function $(b){var c=-1,d=-1;if(b.clientX&&b.clientY?(c=b.clientX,d=b.clientY):b.targetTouches&&(c=b.targetTouches[0].clientX,d=b.targetTouches[0].clientY),F=!1,r.pageX=c,r.pageY=d,!y)for(var e=0;e<4;e++){var f=W(a);if(T(f.left+u[e].x,f.top+u[e].y,c,d))return-1===E?void V(e):E===e?(P("returnOpacity"),void(E=-1)):(P("returnOpacity",e),void(E=-1));-1!==E&&P("returnOpacity")}}var A,B,b=a.getAttribute("data-color")?a.getAttribute("data-color"):b,c=a.getAttribute("data-startDate")?a.getAttribute("data-startDate"):c,d=a.getAttribute("data-finishDate")?a.getAttribute("data-finishDate"):d,e=e||20,f=f||8,g=6,h="Open Sans",i="normal",j=3,k=5,l=2,m=[.7,.6,.5,.4],n=2,o=864e5,p=36e5,q=6e4,r={pageX:-1,pageY:-1},s=a.getContext("2d"),t={},u=[],v={days:0,hours:0,minutes:0,seconds:0},w=I(d),x=Math.floor(w/o-I(c)/o),y=!1,z=!1,C=[],D=0,E=-1,F=!0,G=a.width;"ontouchstart"in window?H(a,"touchstart",$):H(document,"mousemove",Z),U(),K(),J(),P("start",null,500),B=setInterval(J,1e3)}

var toggleFlag = false,
	toggle,
	isSend = true,
	newQuery = true,
	isTouchDevice = navigator.userAgent.match(/(iPhone|iPod|iPad|Android|BlackBerry|Windows Phone)/);

function toggleInterval(){
	toggleFlag = false;
	clearTimeout(toggle);
}

function imgtosvg() {
	$('img.svg').each(function(){
		var $img = $(this),
			imgID = $img.attr('id'),
			imgClass = $img.attr('class'),
			imgURL = $img.attr('src');
		$.get(imgURL, function(data) {
			var $svg = $(data).find('svg');
			if(typeof imgID !== 'undefined') {
				$svg = $svg.attr('id', imgID);
			}
			if(typeof imgClass !== 'undefined') {
				$svg = $svg.attr('class', imgClass+' replaced-svg');
			}
			$svg = $svg.removeAttr('xmlns:a');
			$img.replaceWith($svg);
		}, 'xml');
	});
}

function social() {
	$('.social-links').hide();
	if ( $('body').width() > 1080 ) {
		$('.social-links').removeClass('fadeOutLeftBig').addClass('fadeOutRightBig');
	} else {
		$('.social-links').removeClass('fadeOutRightBig').addClass('fadeOutLeftBig');
	}
	$('.soc-link').on('click', function(event){
		var target = $(event.target);
		$('.social-links').show();
		if ( $('body').width()> 1080 ) {
			if (target.hasClass('soc-link-img') && !toggleFlag) {
				$('.social-links').toggleClass('fadeOutRightBig fadeInRightBig');
				toggleFlag =true;
				toggle = setTimeout(toggleInterval,50);
				return false;
			}
		} else {
			if (target.hasClass('soc-link-img')  && !toggleFlag) {
				$('.social-links').toggleClass('fadeOutLeftBig fadeInRightBig');
				toggleFlag =true;
				toggle = setTimeout(toggleInterval,50);
				return false;
			}
		}
	});
}

function layout() {
	var heightcontent=$('body').height()-350-$('.impala').height();
	if (heightcontent < 0 ) {
		$('.copyright-block').css('position','static');
		$('.impala-home').css({'height':'auto'});
		$('.impala').css({'display':'block', 'padding-bottom': '60px'});
		if ( $('body').width() > 768 && $('body').width() < 1080 ) {
			$('.social-block, .copyright-block ').css('position','static');
		} else {
			$('.social-block ').css('position','absolute');
		}
	} else {
		$('.copyright-block').css('position','absolute');
		$('.impala-home').css({'height':'100%'});
	 	$('.impala').css({'display':'table-cell', 'padding-bottom': '175px'});
 		if ( $('body').width() > 768 && $('body').width() < 1080 ) {
 			$('.social-block, .copyright-block ').css('position','absolute');
 		}
	}
}

function resetForm(e){
	isSend = true;
	if(e.keyCode !== 13){
		resetFormError($('.text-danger'));
		$(this).off('keydown');
	}else{
		$('.notify-me').trigger('submit');
	}
}

function resetFormError(message, interval){
	interval = interval || 500;
	$('.form-control').css('color',"#fff");
	message.fadeOut(interval);
	setTimeout(function(){
		message.removeClass('text-danger');
		newQuery = true;
	}, interval);
}

(function($){
    $(document).ready(function() {
        "use strict";
        social();
        imgtosvg();
        if ($('.impala').length) {
        	layout();
        }

        if (navigator.userAgent.match(/(iPhone|iPod|iPad|Android|BlackBerry|Windows Phone)/)){
        	$('.impala-scroll-overlay').perfectScrollbar("destroy");
        	$('.impala-scroll-overlay').addClass('scroll-block');
        	$('.bg-video').find('video').remove();
        } else {
        	$('.impala-scroll-overlay').perfectScrollbar();
        	$('.impala-scroll-overlay').removeClass('scroll-block');
        }

        $('.notify-me').submit(function(e){
        	var form           = $(this),
        		message        = form.find('.form-message'),
        		messageSuccess = 'Your email is sended',
        		messageInvalid = 'Please enter a valid email address',
        		messageSigned  = 'This email is already signed',
        		messageErrore  = 'Error request';
        	e.preventDefault();
        	e.stopPropagation();
        	if(isSend === false){
        		isSend = true;
        		resetFormError(message);
        		return;
        	}
        	if(newQuery){
        		newQuery = false;
        		$.ajax({
        			url     : fullBaseUrl + "/contacts/ajaxAddContact",
        			type    : 'POST',
        			dataType: 'json',
        			data    : form.serialize(),
        			success : function(data){
        				form.find('.btn').prop('disabled', true);
        				message.removeClass('text-danger').removeClass('text-success').fadeOut();
        				var data = $.parseJSON(JSON.stringify(data));
        				if (data.error==0) {
        					message.html(data.message).addClass('text-success').fadeIn();
        					setTimeout(function(){
        						form.trigger('reset');
        						message.fadeOut().delay(500).queue(function(){
        							message.html('').dequeue().removeClass('text-success');
        							newQuery = true;
        						});
        					},4000);
        				} else {
        					message.html(data.message).addClass('text-danger').fadeIn();
        					setTimeout(function(){
        						form.trigger('reset');
        						message.queue(function(){
        							message.html('').dequeue().removeClass('text-danger');
        						});
        						newQuery = true;
        					}, 4000);
        				}
        				form.find('.btn').prop('disabled', false);
        			},
        			error:function(xhr, textStatus, errorThrown){
        				//called when there is an error
        				var messageresponse = '';
        				if(xhr.responseJSON.hasOwnProperty('message')){
        					//do struff
        					messageresponse = xhr.responseJSON.message;
        				}
        				form.find('.btn').prop('disabled', false);
        				message.html(textStatus + ' : ' + errorThrown + ' : ' + messageresponse).addClass('text-danger').fadeIn();
        				setTimeout(function(){
        					form.trigger('reset');
        					message.queue(function(){
        						message.html('').dequeue().removeClass('text-danger');
        					});
        					newQuery = true;
        				}, 5000);
        				form.find('.btn').prop('disabled', false);
        			},
        			complete: function(done){
        			},
        		});
        	}
        });
    });
})(jQuery);

$(window).on("load", function (e) {
	if ($('.timer').length) {
		var elem = document.getElementsByClassName("timer")[0];
		var timer = new Timer(elem);
	}
	$('.loader').delay(750).fadeOut();
});

//Window Resize
(function(){
	var delay = (function(){
		var timer = 0;
		return function(callback, ms){
			clearTimeout (timer);
			timer = setTimeout(callback, ms);
		};
	})();
	function resizeFunctions() {
		if($('.impala').length) {layout();}
	}

	if(isTouchDevice) {
		$(window).bind('orientationchange', function(){
			delay(function(){
				resizeFunctions();
			}, 300);
		});
	} else {
		$(window).on('resize', function(){
			delay(function(){
				resizeFunctions();
				if(!$('.social-links').hasClass('fadeInRightBig')){
					social();
				}
			}, 500);
		});
	}
}());