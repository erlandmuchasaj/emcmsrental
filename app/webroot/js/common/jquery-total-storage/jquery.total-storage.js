/*!
 * JavaScript Cookie v2.1.3
 * https://github.com/js-cookie/js-cookie
 *
 * Copyright 2006, 2015 Klaus Hartl & Fagner Brack
 * Released under the MIT license
 */
!function(a){var b=!1;if("function"==typeof define&&define.amd&&(define(a),b=!0),"object"==typeof exports&&(module.exports=a(),b=!0),!b){var c=window.Cookies,d=window.Cookies=a();d.noConflict=function(){return window.Cookies=c,d}}}(function(){function a(){for(var a=0,b={};a<arguments.length;a++){var c=arguments[a];for(var d in c)b[d]=c[d]}return b}function b(c){function d(b,e,f){var g;if("undefined"!=typeof document){if(arguments.length>1){if(f=a({path:"/"},d.defaults,f),"number"==typeof f.expires){var h=new Date;h.setMilliseconds(h.getMilliseconds()+864e5*f.expires),f.expires=h}try{g=JSON.stringify(e),/^[\{\[]/.test(g)&&(e=g)}catch(a){}return e=c.write?c.write(e,b):encodeURIComponent(String(e)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g,decodeURIComponent),b=encodeURIComponent(String(b)),b=b.replace(/%(23|24|26|2B|5E|60|7C)/g,decodeURIComponent),b=b.replace(/[\(\)]/g,escape),document.cookie=[b,"=",e,f.expires?"; expires="+f.expires.toUTCString():"",f.path?"; path="+f.path:"",f.domain?"; domain="+f.domain:"",f.secure?"; secure":""].join("")}b||(g={});for(var i=document.cookie?document.cookie.split("; "):[],j=/(%[0-9A-Z]{2})+/g,k=0;k<i.length;k++){var l=i[k].split("="),m=l.slice(1).join("=");'"'===m.charAt(0)&&(m=m.slice(1,-1));try{var n=l[0].replace(j,decodeURIComponent);if(m=c.read?c.read(m,n):c(m,n)||m.replace(j,decodeURIComponent),this.json)try{m=JSON.parse(m)}catch(a){}if(b===n){g=m;break}b||(g[n]=m)}catch(a){}}return g}}return d.set=d,d.get=function(a){return d.call(d,a)},d.getJSON=function(){return d.apply({json:!0},[].slice.call(arguments))},d.defaults={},d.remove=function(b,c){d(b,"",a(c,{expires:-1}))},d.withConverter=b,d}return b(function(){})});

/**
 * TotalStorage
 *
 * Copyright (c) 2012 Jared Novack & Upstatement (upstatement.com)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 * Total Storage is the conceptual the love child of jStorage by Andris Reinman, 
 * and Cookie by Klaus Hartl -- though this is not connected to either project.
 */

/**
 * Create a local storage parameter
 *
 == What makes it TOTAL Storage? ==
 
 * The browser doesn't support local storage it will fall-back to cookies! (Using the
   wonderful $.cookie plugin).
 * Send it strings, numbers even complex object arrays! TotalStorage does not care.
   Your efforts to defeat it will prove futile. 
 * Simple as shit. jStorage and some other very well-written plugins provide a bevy of
   options for expiration, security and so forth. Frequently this is more power than you
   need and vulnerable to confusion if you're just want it to work (JWITW)
   
 * @desc Set the value of a key to a string
 * @example $.totalStorage('the_key', 'the_value');
 * @desc Set the value of a key to a number
 * @example $.totalStorage('the_key', 800.2);
 * @desc Set the value of a key to a complex Array
 * @example	var myArray = new Array();
 *			myArray.push({name:'Jared', company:'Upstatement', zip:63124});
			myArray.push({name:'McGruff', company:'Police', zip:60652};
			$.totalStorage('people', myArray);
			//to return:
			$.totalStorage('people');
			-----------------------------------
            $.totalStorage.setItem(key, value);
            $.totalStorage.getItem('name');
            $.totalStorage.getAll();
            $.totalStorage.deleteItem('name');
 *
 * @name $.totalStorage
 * @cat Plugins/Cookie
 * @author Jared Novack/jared@upstatement.com
 * @version 1.1.2
 * @url http://upstatement.com/blog/2012/01/jquery-local-storage-done-right-and-easy/
 */
!function(a,b){var c,d,e="test";if("localStorage"in window)try{d="undefined"==typeof window.localStorage?b:window.localStorage,c="undefined"!=typeof d&&"undefined"!=typeof window.JSON,window.localStorage.setItem(e,"1"),window.localStorage.removeItem(e)}catch(a){c=!1}a.totalStorage=function(b,c,d){return a.totalStorage.impl.init(b,c)},a.totalStorage.setItem=function(b,c){return a.totalStorage.impl.setItem(b,c)},a.totalStorage.getItem=function(b){return a.totalStorage.impl.getItem(b)},a.totalStorage.getAll=function(){return a.totalStorage.impl.getAll()},a.totalStorage.deleteItem=function(b){return a.totalStorage.impl.deleteItem(b)},a.totalStorage.impl={init:function(a,b){return"undefined"!=typeof b?this.setItem(a,b):this.getItem(a)},setItem:function(a,b){if(!c)try{return Cookies.set(a,b),b}catch(a){console.log("Local Storage not supported by this browser. Install the cookie plugin on your site to take advantage of the same functionality. You can get it at https://github.com/carhartl/jquery-cookie")}var e=JSON.stringify(b);return d.setItem(a,e),this.parseResult(e)},getItem:function(a){if(!c)try{return this.parseResult(Cookies.get(a))}catch(a){return null}var b=d.getItem(a);return this.parseResult(b)},deleteItem:function(a){if(!c)try{return Cookies.set(a,null),!0}catch(a){return!1}return d.removeItem(a),!0},getAll:function(){var a=[];if(c)for(var h in d)h.length&&a.push({key:h,value:this.parseResult(d.getItem(h))});else try{for(var b=document.cookie.split(";"),e=0;e<b.length;e++){var f=b[e].split("="),g=f[0];a.push({key:g,value:this.parseResult(Cookies.get(g))})}}catch(a){return null}return a},parseResult:function(a){var b;try{b=JSON.parse(a),"undefined"==typeof b&&(b=a),"true"==b&&(b=!0),"false"==b&&(b=!1),parseFloat(b)==b&&"object"!=typeof b&&(b=parseFloat(b))}catch(c){b=a}return b}}}(jQuery);
