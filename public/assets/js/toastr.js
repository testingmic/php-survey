﻿function getInternetExplorerVersion(){var e,n=-1;return"Microsoft Internet Explorer"==navigator.appName&&(e=navigator.userAgent,null!=new RegExp("MSIE ([0-9]{1,}[.0-9]{0,})").exec(e)&&(n=parseFloat(RegExp.$1))),n}function checkVersion(){var e="You're not using Windows Internet Explorer.",n=getInternetExplorerVersion();-1<n&&(e=8<=n?"You're using a recent copy of Windows Internet Explorer.":"You should upgrade your copy of Windows Internet Explorer."),alert(e)}function isIE8orlower(){var e="0",n=getInternetExplorerVersion();return-1<n&&(e=9<=n?0:1),e}(typeof define==="function"&&define.amd?define:function(e,n){if(typeof module!=="undefined"&&module.exports)module.exports=n(require("jquery"));else window["toastr"]=n(window["jQuery"])})(["jquery"],function(h){return function(){var l,n,u=0,o="error",s="info",i="success",r="warning",a="custom",e={clear:function(e){var n=f();l||g(n);if(e&&0===h(":focus",e).length)return void e[n.hideMethod]({duration:n.hideDuration,easing:n.hideEasing,complete:function(){m(e)}});l.children().length&&l[n.hideMethod]({duration:n.hideDuration,easing:n.hideEasing,complete:function(){l.remove()}})},error:function(e,n,t){return d({type:o,iconClass:f().iconClasses.error,message:e,optionsOverride:t,title:n})},getContainer:g,info:function(e,n,t){return d({type:s,iconClass:f().iconClasses.info,message:e,optionsOverride:t,title:n})},options:{},subscribe:function(e){n=e},success:function(e,n,t){return d({type:i,iconClass:f().iconClasses.success,message:e,optionsOverride:t,title:n})},version:"2.0.1",warning:function(e,n,t){return d({type:r,iconClass:f().iconClasses.warning,message:e,optionsOverride:t,title:n})},custom:function(e,n,t){return d({type:a,iconClass:f().iconClass,message:e,optionsOverride:t,title:n})}};return e;function p(e){n&&n(e)}function d(e){var n=f(),t=e.iconClass||n.iconClass;void 0!==e.optionsOverride&&(n=h.extend(n,e.optionsOverride),t=e.optionsOverride.iconClass||t),u++,l=g(n);var o=null,s=h("<div/>"),i=h("<div/>"),r=h("<div/>"),a=h(n.closeHtml),d={toastId:u,state:"visible",startTime:new Date,options:n,map:e};e.iconClass&&s.addClass(n.toastClass).addClass(t),e.title&&(i.append(e.title).addClass(n.titleClass),s.append(i)),e.message&&(r.append(e.message).addClass(n.messageClass),s.append(r)),n.closeButton&&(a.addClass("toast-close-button"),s.prepend(a)),n.positionClass&&l.attr("class")!=n.positionClass&&(l.html(""),l.removeAttr("class"),l.addClass(n.positionClass)),s.hide(),n.newestOnTop?l.prepend(s):l.append(s),s[n.showMethod]({duration:n.showDuration,easing:n.showEasing,complete:n.onShown}),0<n.timeOut&&(o=setTimeout(c,n.timeOut)),s.hover(function(){clearTimeout(o),s.stop(!0,!0)[n.showMethod]({duration:n.showDuration,easing:n.showEasing})},function(){(0<n.timeOut||0<n.extendedTimeOut)&&(o=setTimeout(c,n.extendedTimeOut))}),!n.onclick&&n.tapToDismiss&&s.click(c),n.closeButton&&a&&a.click(function(e){e.stopPropagation?e.stopPropagation():void 0!==e.cancelBubble&&!0!==e.cancelBubble&&(e.cancelBubble=!0),c(!0)}),n.onclick&&s.click(function(){n.onclick(),c()}),p(d);return isIE8orlower(),n.debug&&console&&console.log(d),s;function c(e){if(!h(":focus",s).length||e)return s[n.hideMethod]({duration:n.hideDuration,easing:n.hideEasing,complete:function(){m(s),n.onHidden&&n.onHidden(),d.state="hidden",d.endTime=new Date,p(d)}})}}function g(e){return e=e||f(),(l=h("#"+e.containerId)).length||(l=h("<div/>").attr("id",e.containerId).addClass(e.positionClass)).appendTo(h(e.target)),l}function f(){return h.extend({},{tapToDismiss:!0,toastClass:"toast",containerId:"toast-container",debug:!1,showMethod:"fadeIn",showDuration:300,showEasing:"swing",onShown:void 0,hideMethod:"fadeOut",hideDuration:1e3,hideEasing:"swing",onHidden:void 0,extendedTimeOut:1e3,iconClasses:{error:"toast-error",info:"toast-info",success:"toast-success",warning:"toast-warning",custom:"toast-custom"},iconClass:"toast-info",positionClass:"toast-top-right",timeOut:5e3,titleClass:"toast-title",messageClass:"toast-message",target:"body",closeHtml:"<button>&times;</button>",newestOnTop:!0},e.options)}function m(e){l=l||g(),e.is(":visible")||(e.remove(),e=null,0===l.children().length&&l.remove())}}()});