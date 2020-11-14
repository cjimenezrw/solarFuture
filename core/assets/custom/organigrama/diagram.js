/*
 Modificado: DLOREAN (Jonathan Topete)
 */

/*
@license

dhtmlxDiagram v.1.0.0 Limited
This software can be used only as part of dhtmlx.com site.
You are not allowed to use it on any other site

(c) Dinamenta, UAB.
*/
!function(t){function e(r){if(n[r])return n[r].exports;var i=n[r]={i:r,l:!1,exports:{}};return t[r].call(i.exports,i,i.exports,e),i.l=!0,i.exports}var n={};e.m=t,e.c=n,e.i=function(t){return t},e.d=function(t,n,r){e.o(t,n)||Object.defineProperty(t,n,{configurable:!1,enumerable:!0,get:r})},e.n=function(t){var n=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(n,"a",n),n},e.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},e.p="/codebase/",e(e.s=43)}([function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.getUid=function(){return this._seed=this._seed||(new Date).valueOf(),++this._seed},e.isEqualObj=function(t,e){for(var n in t)if(t[n]!==e[n])return!1;return!0},e.naturalCompare=function(t,e){var n=[],r=[];for(t.replace(/(\d+)|(\D+)/g,function(t,e,r){n.push([e||1/0,r||""])}),e.replace(/(\d+)|(\D+)/g,function(t,e,n){r.push([e||1/0,n||""])});n.length&&r.length;){var i=n.shift(),o=r.shift(),s=i[0]-o[0]||i[1].localeCompare(o[1]);if(s)return s}return n.length-r.length},e.findByConf=function(t,e){if(e.rule&&"function"==typeof e.rule){if(e.rule.call(this,t))return t}else if(e.by&&e.match&&t[e.by]===e.match)return t},e.arrayGetIndex=function(t,e){for(var n=0;n<t.length;n++)if(t[n].id===e)return n;return-1},e.isDebug=function(){var t=window.dhx;if(void 0!==t)return void 0!==t.debug&&t.debug},e.dhxWarning=function(t){console.warn(t)},e.dhxError=function(t){throw new Error(t)}},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=function(){function t(t){this.config=this.setDefaults(t),this.id=t.id}return t.prototype.isConnector=function(){return!1},t.prototype.getCenter=function(){var t=this.config;return{x:Math.abs(t.width/2),y:Math.abs(t.height/2)}},t.prototype.move=function(t,e){this.update({x:t,y:e})},t.prototype.resize=function(t,e){this.update({width:t,height:e})},t.prototype.rotate=function(t){this.update({angle:t})},t.prototype.update=function(t){for(var e in t)this.config[e]=t[e]},t.prototype.toSVG=function(){return""},t.prototype.getPoint=function(t,e){var n=this.config;if(n.angle){var r=n.x+n.width/2,i=n.y+n.height/2,o=n.angle*(Math.PI/180);return{x:(t-r)*Math.cos(o)-(e-i)*Math.sin(o)+r,y:(t-r)*Math.sin(o)+(e-i)*Math.cos(o)+i}}return{x:t,y:e}},t.prototype.getCss=function(){return(this.config.$selected?"dhx_selected ":"")+(this.config.css||"")},t.prototype.setDefaults=function(t){return t},t}();e.BaseShape=r},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.getCircleTpl=function(t){if(!t.$count&&!1!==t.open)return"";var e="vertical"===t.dir,n=!1===t.open,r=t.width/2,i=t.height/2,o={x:e?0:r,y:e?i:t.height-4},s=n?'<polyline points="\n\t\t\t'+(o.x-5)+","+o.y+"\n\t\t\t"+o.x+","+o.y+"\n\t\t\t"+o.x+","+(o.y-5)+"\n\t\t\t"+o.x+","+(o.y+5)+"\n\t\t\t"+o.x+","+o.y+"\n\t\t\t"+(o.x+5)+","+o.y+'"\n\t\t\tstroke-width="2" stroke="white" fill="none"/>':'<line x1="'+(o.x-5)+'" y1="'+o.y+'" x2="'+(o.x+5)+'" y2="'+o.y+'" stroke-width="2" stroke="white"/>';return"\n\t\t<g x="+o.x+' y="'+o.y+'" dhx_diagram="hide" class="'+(n?"dhx_expand_icon":"dhx_hide_icon")+'">\n\t\t\t<circle r="10" cx="'+o.x+'" cy="'+o.y+'" fill="'+t.$expandColor+'"/>\n\t\t\t'+s+"\n\t\t</g>"},e.getHeaderTpl=function(t){var e=t.color||"#20b6e2";return'\n\t\t<rect\n\t\t\theight="3.5"\n\t\t\twidth="'+t.width+'"\n\n\t\t\tstroke="'+e+'"\n\t\t\tfill="'+e+'"\n\t\t\tstroke-width=1\n\t\t/>'},e.getTextTemplate=function(t,e){return t.text?'<foreignObject\n\t\twidth="'+t.width+'"\n\t\toverflow="hidden"\n\t\theight="'+t.height+'"\n\t\ttransform="translate(0 0)"\n\t\t>\n\t\t\t<div class="shape_content" style="width:'+t.width+"px;height:"+t.height+'px;">\n\t\t\t\t'+e+"\n\t\t\t</div>\n\t\t</foreignObject>":""}},function(t,e,n){"use strict";var r=this&&this.__extends||function(){var t=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,e){t.__proto__=e}||function(t,e){for(var n in e)e.hasOwnProperty(n)&&(t[n]=e[n])};return function(e,n){function r(){this.constructor=e}t(e,n),e.prototype=null===n?Object.create(n):(r.prototype=n.prototype,new r)}}();Object.defineProperty(e,"__esModule",{value:!0});var i=n(1),o=n(2),s=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return r(e,t),e.prototype.toSVG=function(){var t=this.config,e=this.getCenter(),n=t.$selected?t.color:"#E4E4E4";return'\n\t\t<g transform="\n\t\ttranslate('+t.x+","+t.y+") rotate("+(t.angle||0)+","+e.x+","+e.y+')"\n\t\tclass="'+this.getCss()+'"\n\t\tdhx_id="'+t.id+'"\n\t\t>\n\t\t\t<rect\n\t\t\t\tclass="dhx_item_shape"\n\t\t\t\tid="'+t.id+'"\n\t\t\t\theight="'+t.height+'"\n\t\t\t\twidth="'+t.width+'"\n\t\t\t\trx=1\n\t\t\t\try=1\n\t\t\t\tstroke="'+n+'"\n\t\t\t\tstroke-width=1\n\t\t\t/>\n\t\t\t'+o.getTextTemplate(t,this.text())+"\n\t\t\t"+o.getHeaderTpl(t)+"\n\t\t\t"+o.getCircleTpl(t)+"\n\t\t</g>"},e.prototype.getCss=function(){return"dhx_diagram_item "+t.prototype.getCss.call(this)},e.prototype.setDefaults=function(t){return t.width=t.width||140,t.height=t.height||86,t},e.prototype.text=function(){return this.config.text},e}(i.BaseShape);e.DiagramCard=s},,function(t,e,n){(function(e,n){!function(){function r(t){e.setImmediate?n(t):e.importScripts?setTimeout(t):(s[++o]=t,e.postMessage(o,"*"))}function i(t){"use strict";function e(t,e,n,r){if(2==c)return r();if("object"!=typeof u&&"function"!=typeof u||"function"!=typeof t)r();else try{var i=0;t.call(u,function(t){i++||(u=t,e())},function(t){i++||(u=t,n())})}catch(t){u=t,n()}}function n(){var t;try{t=u&&u.then}catch(t){return u=t,c=2,n()}e(t,function(){c=1,n()},function(){c=2,n()},function(){try{1==c&&"function"==typeof o?u=o(u):2==c&&"function"==typeof s&&(u=s(u),c=1)}catch(t){return u=t,f()}u==a?(u=TypeError(),f()):e(t,function(){f(3)},f,function(){f(1==c&&3)})})}if("function"!=typeof t&&void 0!=t)throw TypeError();if("object"!=typeof this||this&&this.then)throw TypeError();var o,s,a=this,c=0,u=0,h=[];a.promise=a,a.resolve=function(t){return o=a.fn,s=a.er,c||(u=t,c=1,r(n)),a},a.reject=function(t){return o=a.fn,s=a.er,c||(u=t,c=2,r(n)),a},a._d=1,a.then=function(t,e){if(1!=this._d)throw TypeError();var n=new i;return n.fn=t,n.er=e,3==c?n.resolve(u):4==c?n.reject(u):h.push(n),n},a.catch=function(t){return a.then(null,t)};var f=function(t){c=t||4,h.map(function(t){3==c&&t.resolve(u)||t.reject(u)})};try{"function"==typeof t&&t(a.resolve,a.reject)}catch(t){a.reject(t)}return a}var o=1,s={},a=!1;(e=this).setImmediate||e.addEventListener("message",function(t){if(t.source==e)if(a)r(s[t.data]);else{a=!0;try{s[t.data]()}catch(t){}delete s[t.data],a=!1}}),i.resolve=function(t){if(1!=this._d)throw TypeError();return t instanceof i?t:new i(function(e){e(t)})},i.reject=function(t){if(1!=this._d)throw TypeError();return new i(function(e,n){n(t)})},i.all=function(t){function e(r,i){return i?n.resolve(i):r?n.reject(r):(0==t.reduce(function(t,e){return e&&e.then?t+1:t},0)&&n.resolve(t),void t.map(function(n,r){n&&n.then&&n.then(function(n){return t[r]=n,e(),n},e)}))}if(1!=this._d)throw TypeError();if(!(t instanceof Array))return i.reject(TypeError());var n=new i;return e(),n},i.race=function(t){function e(r,i){return i?n.resolve(i):r?n.reject(r):(0==t.reduce(function(t,e){return e&&e.then?t+1:t},0)&&n.resolve(t),void t.map(function(t,n){t&&t.then&&t.then(function(t){e(null,t)},e)}))}if(1!=this._d)throw TypeError();if(!(t instanceof Array))return i.reject(TypeError());if(0==t.length)return new i;var n=new i;return e(),n},i._d=1,t.exports=i}()}).call(e,n(7),n(29).setImmediate)},,function(t,e){var n;n=function(){return this}();try{n=n||Function("return this")()||(0,eval)("this")}catch(t){"object"==typeof window&&(n=window)}t.exports=n},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=function(){function t(t){this.events={},this.context=t||this}return t.prototype.on=function(t,e,n){t=t.toLowerCase(),this.events[t]=this.events[t]||[],this.events[t].push({callback:e,context:n||this.context})},t.prototype.detach=function(t,e){var n=this.events[t];if(e)for(var r=0;r<n.length;r++)n[r].context===e&&n.splice(r,1);else this.events[t]=[]},t.prototype.fire=function(t,e){return t=t.toLowerCase(),e=e instanceof Array?e:[e],!this.events[t]||this.events[t].map(function(t){return t.callback.apply(t.context,e)}).indexOf(!1)<0},t}();e.EventSystem=r},function(t,e,n){"use strict";var r=this&&this.__assign||Object.assign||function(t){for(var e,n=1,r=arguments.length;n<r;n++){e=arguments[n];for(var i in e)Object.prototype.hasOwnProperty.call(e,i)&&(t[i]=e[i])}return t};Object.defineProperty(e,"__esModule",{value:!0});var i=n(17),o=n(8),s=n(19),a=n(12),c=n(10),u=n(0),h=function(){function t(t,e){var n=this;this._container=a.toNode(t),this._wrapper=a.insert(this._container,'<div class="dhx_diagram_wrapper"\n\t\t\tstyle="\n\t\t\t\twidth:'+this._container.offsetWidth+"px;\n\t\t\t\theight:"+this._container.offsetHeight+'px;\n\t\t\t"></div>'),this.config=e||{},this._event=new o.EventSystem(this),this.config.scale=this.config.scale||1;var i={x:40,y:40,itemX:40,itemY:40};this.config.margin?this.config.margin=r({},i,this.config.margin):this.config.margin=i,this.config.scroll=this.config.scroll||!1,window.SVGForeignObjectElement||(this.config.defaultShapeType="svg-card"),this._shapesCollection=new s.ShapesCollection(this.config.defaultShapeType||"card",this.config.defaultLinkType||"line"),this._shapesCollection.attachEvent("onBeforeAdd",function(t){return n.callEvent("onBeforeAdd",[t.id])}),this._shapesCollection.attachEvent("onAfterAdd",function(t){return n.callEvent("onAfterAdd",[t.id])}),this._setHandlers(),this.clearAll()}return t.prototype.attachEvent=function(t,e){this._event.on(t,e,this)},t.prototype.callEvent=function(t,e){return this._event.fire(t,e)},t.prototype.detachEvent=function(t){this._event.detach(t,this)},t.prototype.collapseItem=function(t){this.getItem(t).update({open:!1})},t.prototype.expandItem=function(t){this.getItem(t).update({open:!0})},t.prototype.clearAll=function(){this._shapesCollection.removeAll()},t.prototype.parse=function(t){this.clearAll();for(var e=0,n=t;e<n.length;e++){var r=n[e];this.addItem(r)}this.paint()},t.prototype.load=function(t,e){var n=this;if(void 0===e&&(e="json"),this.callEvent("onBeforeLoad",[t,e])){var r=this._shapesCollection.load(new i.DataProxy(t));return r.then(function(t){n.callEvent("onAfterLoad",[t]),n.paint()}),r}},t.prototype.getItem=function(t){return this._shapesCollection.getItem(t)},t.prototype.deleteItem=function(t){this.callEvent("onBeforeDelete",[t])&&(this._shapesCollection.remove(t),"org"===this.config.type&&this._shapesCollection.removeNested(t),this.callEvent("onAfterDelete",[t]),this.paint())},t.prototype.addItem=function(t){this._shapesCollection.add(t),"org"===this.config.type&&t.parent&&this.addItem({id:""+u.getUid(),from:t.parent,to:t.id})},t.prototype.updateItem=function(t,e){var n=this._shapesCollection.getItem(t);n.config=r({},n.config,e)},t.prototype.paint=function(){var t=this._getContent();this.config.scroll?this._wrapper.style.overflow="auto":(this._wrapper.style.width=t.width+"px",this._wrapper.style.height=t.height+"px",this._wrapper.style.overflow="visible"),this._wrapper.innerHTML='\n\t\t\t<svg\n\t\t\t\txmlns="http://www.w3.org/2000/svg"\n\t\t\t\twidth="'+t.width+'"\n\t\t\t\theight="'+t.height+'"\n\t\t\t\tviewBox="0 0 '+t.width/this.config.scale+" "+t.height/this.config.scale+'"\n\t\t\t\tshape-rendering='+(this.config.scale>=1?"crispedges":"auto")+'\n\t\t\t\t>\n\t\t\t\t<defs>\n\t\t\t\t\t<marker id="arrow" markerWidth="10" markerHeight="10" refX="2.3" refY="2" orient="auto" markerUnits="strokeWidth">\n\t\t\t\t\t\t<path d="M0,0 L0,4 L3,2 z" class="dhx_diagram_arrow" />\n\t\t\t\t\t</marker>\n\t\t\t\t</defs>\n\t\t\t\t'+t.shapes+"\n\t\t\t</svg>"},t.prototype.getSelectedId=function(){return this._selected},t.prototype.unselectItem=function(t){return!!this.callEvent("onBeforeUnSelect",[t])&&(this.updateItem(t,{$selected:!1}),this.callEvent("onAfterUnSelect",[t]),!0)},t.prototype.selectItem=function(t){var e=this._selected;e!==t&&this.callEvent("onBeforeSelect",[t])&&(e&&!this.unselectItem(e)||(this._selected=t,this.updateItem(t,{$selected:!0}),this.callEvent("onAfterSelect",[t])))},t.prototype.getScrollState=function(){return{x:this._wrapper.scrollLeft,y:this._wrapper.scrollTop}},t.prototype.scrollTo=function(t,e){this._wrapper.scrollLeft=t,this._wrapper.scrollTop=e},t.prototype.showItem=function(t){var e=this.getItem(t).config;this.scrollTo(e.x,e.y)},t.prototype._setHandlers=function(){var t=this;this._container.addEventListener("click",function(e){var n=a.locate(e);n&&(t.callEvent("onShapeClick",[n]),t.config.select&&(t.selectItem(n),setTimeout(function(){return t.paint()},1))),a.locate(e,"dhx_diagram")&&(t._toggleGraph(n),t.paint())}),this._container.addEventListener("dblclick",function(e){var n=a.locate(e);n&&t.callEvent("onShapeDblClick",[n])})},t.prototype._toggleGraph=function(t){var e=this.getItem(t);e.update({open:!1===e.config.open})},t.prototype._calcSizes=function(t,e){var n=(t.config.x+t.config.width)*this.config.scale,r=(t.config.y+t.config.height)*this.config.scale;n>e.width&&(e.width=n+this.config.margin.x),r>e.height&&(e.height=r+this.config.margin.y)},t.prototype._getContent=function(){var t,e={shapes:"",width:0,height:0};if(t="org"===this.config.type?c.AutoPlace(this._shapesCollection.getShapes(),this._shapesCollection.getLinks(),this.config):this._shapesCollection.getAll())for(var n=t.length-1;n>=0;n--)e.shapes+=t[n].toSVG(),this._calcSizes(t[n],e);return e},t}();e.Diagram=h},function(t,e,n){"use strict";function r(t,e){t:for(var n in t)for(var r in e){if(e[r].config.to===n)continue t;return n}return Object.keys(t)[0]}function i(t){var e={};for(var n in t){var r=t[n].config;(e[r.from]=e[r.from]||[]).push({to:r.to,id:n})}return e}function o(t,e,n,r){var i=t[n],s=e[n];if(s.config.$count=0,r&&"vertical"===e[r].config.dir&&i&&(s.config.dir="vertical"),!1===s.config.open)return 1;if(i){for(var a=0,c=i;a<c.length;a++){var u=c[a];s.config.$count+=o(t,e,u.to,s.config.id)}return"vertical"===s.config.dir?s.config.$count=1:s.config.$count}return 1}function s(t,e,n,r,i,o){var a=t.pull[e];t.visible.push(a);var c=(a.config.width+t.config.margin.itemX)*(a.config.$count||1),h=Math.round((c-a.config.width-t.config.margin.itemX)/2);a.config.x=h+n,a.config.y=r,a.config.color=a.config.color||u[i%u.length];var f=t.hash[e];if(f){a.config.$expandColor=u[(i+1)%u.length];var l=t.pull[f[0].to];l&&l.config.color&&(a.config.$expandColor=l.config.color)}if(!1!==a.config.open&&(r+=a.config.height+t.config.margin.itemY,f))for(var p=0,d=f;p<d.length;p++){var g=d[p];if("vertical"===a.config.dir){var _=n;o&&"vertical"===t.pull[o].config.dir&&(_=n+Math.round(t.config.margin.itemX/2),a.config.$gap=0);var v=s(t,g.to,_,r,i+1,e);if(t.hash[g.to]&&!1!==t.pull[g.to].config.open){r=v.dy;var y=v.width+Math.round(t.config.margin.itemX/2);y>c&&(c=y)}else r+=a.config.height+t.config.margin.itemY}else n+=s(t,g.to,n,r,i+1,e).width}return{width:c,dy:r}}function a(t,e){if(!1!==t.pull[e].config.open){var n=t.hash[e];if(n)for(var r=0,i=n;r<i.length;r++){var o=i[r];c(t,o.id),a(t,o.to)}}}function c(t,e){var n=t.links[e],r=t.pull[n.config.from].config,i=t.pull[n.config.to].config,o=r.$gap>=0?r.$gap:Math.round(t.config.margin.itemX/2),s=Math.round(t.config.margin.itemY/2);if("vertical"===r.dir){var a=r.x,c=Math.round(r.y+r.height/2),u=i.x,h=Math.round(i.y+i.height/2),f=a-o;n.config.points=[{x:a,y:c},{x:f,y:c},{x:f,y:h},{x:u,y:h}]}else{var a=Math.round(r.x+r.width/2),c=r.y+r.height,u=Math.round(i.x+i.width/2),h=i.y;n.config.points=[{x:a,y:c},{x:a,y:c+s},{x:u,y:h-s},{x:u,y:h}]}t.visible.push(n)}Object.defineProperty(e,"__esModule",{value:!0});var u=["#EF6C00","#607D8B","#00C7B5","#20B6E2","#9575CD","#FFB72B","#FF72A7"];e.AutoPlace=function(t,e,n){if(0!==Object.keys(t).length){var c=r(t,e),u=i(e);o(u,t,c);var h={visible:[],hash:u,pull:t,config:n,links:e};return s(h,c,n.margin.x,n.margin.y,0),a(h,c),h.visible}}},function(t,e,n){"use strict";var r=this&&this.__extends||function(){var t=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,e){t.__proto__=e}||function(t,e){for(var n in e)e.hasOwnProperty(n)&&(t[n]=e[n])};return function(e,n){function r(){this.constructor=e}t(e,n),e.prototype=null===n?Object.create(n):(r.prototype=n.prototype,new r)}}();Object.defineProperty(e,"__esModule",{value:!0});var i=function(t){function e(e){return t.call(this,e)||this}return r(e,t),e.prototype.isConnector=function(){return!0},e.prototype.toSVG=function(){return'<g dhx_id="">\n\t\t \t<polyline points = "'+this._getPoints()+'" '+this._getType()+' class="dhx_diagram_connector" stroke-width="1"/>\n\t\t</g>'},e.prototype._getType=function(){if(this.config.type)switch(this.config.type){case"line":return"";case"dash":return'stroke-dasharray="5, 5"';default:return""}},e.prototype._getPoints=function(){return this.config.points.map(function(t){return t.x+","+t.y}).join(" ")},e}(n(1).BaseShape);e.Connector=i},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.toNode=function(t){return"string"==typeof t&&(t=document.getElementById(t)||document.querySelector(t)),t||document.body},e.insert=function(t,e){return"string"==typeof e?(t.insertAdjacentHTML("beforeend",e),t.lastChild):(t.appendChild(e),e)},e.remove=function(t){t&&t.parentNode&&t.parentNode.removeChild(t)},e.children=function(t,e){for(var n=[],r=t.childNodes,i=0;i<r.length;++i){var o=r[i];0===o.className.indexOf(e)&&n.push(o)}return n},e.locate=function(t,e){void 0===e&&(e="dhx_id");for(var n=t.target;n&&n.getAttribute;){var r=n.getAttribute(e);if(r)return r;n=n.parentNode}},e.addCss=function(t,e){t.classList.add(e)},e.removeCss=function(t,e){t.classList.remove(e)},e.getCoords=function(t){var e=t.getBoundingClientRect(),n=document.body,r=window.pageYOffset||n.scrollTop,i=window.pageXOffset||n.scrollLeft;return{top:e.top+r,left:e.left+i,right:n.offsetWidth-e.right,bottom:n.offsetHeight-e.bottom,width:e.right-e.left,height:e.bottom-e.top}},e.isNested=function(t,e){for(;t&&e;){if(e===t)return!0;t=t.parentNode}return!1};var r=-1;e.getScrollbarWidth=function(){if(r>-1)return r;var t=document.createElement("div");return document.body.appendChild(t),t.style.cssText="position: absolute;left: -99999px;overflow:scroll;width: 100px;height: 100px;",r=t.offsetWidth-t.clientWidth,document.body.removeChild(t),r}},function(t,e,n){"use strict";var r=this&&this.__assign||Object.assign||function(t){for(var e,n=1,r=arguments.length;n<r;n++){e=arguments[n];for(var i in e)Object.prototype.hasOwnProperty.call(e,i)&&(t[i]=e[i])}return t};Object.defineProperty(e,"__esModule",{value:!0});var i=n(8),o=n(14),s=n(15),a=n(16),c=n(0),u=function(){function t(t){this._order=[],this._pull={},this._changes={order:[]},this._initOrder=null,this.config=t||{},this._copier=new o.Copier(this),this._sort=new a.Sort(this),this._loader=new s.Loader(this,this._changes),this._events=new i.EventSystem(this)}return t.prototype.attachEvent=function(t,e){this._events.on(t,e,this)},t.prototype.callEvent=function(t,e){return this._events.fire(t,e)},t.prototype.detachEvent=function(t){this._events.detach(t,this)},t.prototype.add=function(t,e){this.callEvent("onBeforeAdd",[t])&&(this.config.beforeAdd&&(t=this.config.beforeAdd(t)),t.id=t.id||c.getUid(),this._pull[t.id]&&c.dhxError("Item already exist"),this._initOrder&&this._initOrder.length&&this._addToOrder(this._initOrder,t,e),this._addToOrder(this._order,t,e),this._onChange("insert",t.id,t),this.callEvent("onAfterAdd",[t]))},t.prototype.remove=function(t){this.getIndex(t)>=0&&this._pull[t]&&(this._onChange("delete",t,this._pull[t]),this._order=this._order.filter(function(e){return e!==t}),delete this._pull[t]),this._initOrder&&this._initOrder.length&&(this._initOrder=this._initOrder.filter(function(e){return e!==t}))},t.prototype.removeAll=function(){this._pull={},this._order=[],this._changes.order=[],this._initOrder=null},t.prototype.exists=function(t){return!!this._pull[t]},t.prototype.getItem=function(t){return this._pull[t]},t.prototype.update=function(t,e){var n=this.getItem(t);if(n){if(c.isEqualObj(e,n))return;e.id&&t!==e.id?(c.dhxWarning("this method doesn't allow change id"),c.isDebug()):(this._pull[t]=r({},this._pull[t],e),this._onChange("update",t,this._pull[t]))}else c.dhxWarning("item not found")},t.prototype.getIndex=function(t){var e=this._order.indexOf(t);return this._pull[t]&&e>=0?e:-1},t.prototype.getId=function(t){return this._order[t]},t.prototype.filter=function(t){var e=this;if(!t)return this._order=this._initOrder||this._order,void(this._initOrder=null);var n=this._order.filter(function(n){return t.rule&&"function"==typeof t.rule?t.rule(e._pull[n]):e._pull[n][t.by]===t.match});!n.length||this._initOrder&&this._initOrder.length||(this._initOrder=this._order,this._order=n)},t.prototype.find=function(t){for(var e in this._pull)return c.findByConf(this._pull[e],t);return null},t.prototype.findAll=function(t){var e=[];for(var n in this._pull){var r=c.findByConf(this._pull[n],t);r&&e.push(r)}return e},t.prototype.sort=function(t){this._sort.sort(this._order,t),this._initOrder&&this._initOrder.length&&this._sort.sort(this._initOrder,t)},t.prototype.copy=function(t,e,n){return this._copier.copy(t,e,n)},t.prototype.move=function(t,e,n){return this._copier.move(this._order,t,e,n)},t.prototype.load=function(t){return this._loader.load(t)},t.prototype.parse=function(t){return this._loader.parse(t)},t.prototype.save=function(t){this._loader.save(t)},t.prototype.isSaved=function(){return!this._changes.order.length},t.prototype._addToOrder=function(t,e,n){n&&t[n]?(this._pull[e.id]=e,t.splice(n,0,e.id)):(this._pull[e.id]=e,t.push(e.id))},t.prototype._onChange=function(t,e,n){for(var i=0,o=this._changes.order;i<o.length;i++){var s=o[i];if(s.id===e&&!s.saving)return s.error&&(s.error=!1),void(s=r({},s,{obj:n,status:t}))}this._changes.order.push({id:e,status:t,obj:n,saving:!1})},t}();e.DataCollection=u},function(t,e,n){"use strict";var r=this&&this.__assign||Object.assign||function(t){for(var e,n=1,r=arguments.length;n<r;n++){e=arguments[n];for(var i in e)Object.prototype.hasOwnProperty.call(e,i)&&(t[i]=e[i])}return t};Object.defineProperty(e,"__esModule",{value:!0});var i=n(0),o=function(){function t(t){this._parent=t}return t.prototype.copy=function(t,e,n){if(!this._parent.exists(t))return null;var o=i.getUid();return n?n.exists(t)?(n.add(r({},this._parent.getItem[t],{id:o}),e),o):(n.add(this._parent.getItem(t),e),t):(this._parent.add(r({},this._parent.getItem(t),{id:o}),e),o)},t.prototype.move=function(t,e,n,r){if(r&&this._parent.exists(e)){var o=this._parent.getItem(e);return r.exists(e)&&(o.id=i.getUid()),r.add(o,n),this._parent.remove(o.id),o.id}return this._parent.getIndex(e)===n?null:(t.splice(n,0,t.splice(this._parent.getIndex(e),1)[0]),e)},t}();e.Copier=o},function(t,e,n){"use strict";(function(t){Object.defineProperty(e,"__esModule",{value:!0});var r=n(0),i=function(){function e(t,e){this._parent=t,this._changes=e}return e.prototype.load=function(e){var n=this;return new t(function(t,r){n._parent.loadData=e.load().then(function(e){n._loading=!1,n._parent.removeAll(),n.parse(e).then(function(){t("loaded")})}).catch(function(t){return r(t)})})},e.prototype.parse=function(e){var n=this;return new t(function(t){for(var r=0,i=e;r<i.length;r++){var o=i[r];n._parent.add(o)}t("parsed")})},e.prototype.save=function(e){var n=this;if(this._loading)this._parent.saveData=this._parent.loadData.then(function(){return n.save(e)});else{for(var i=this,o=0,s=this._changes.order;o<s.length;o++)!function(o){if(o.saving||o.pending)r.dhxWarning("item is saving");else{var s=i._findPrevState(o.id);if(s&&s.saving){var a=new t(function(t,i){s.promise.then(function(){o.pending=!1,t(n._setPromise(o,e))}).catch(function(t){n._removeFromOrder(s),n._setPromise(o,e),r.dhxWarning(t),i(t)})});i._addToChain(a),o.pending=!0}else i._setPromise(o,e)}}(s[o]);this._parent.saveData.then(function(){n._saving=!1})}},e.prototype._setPromise=function(t,e){var n=this;return t.promise=e.save(t.obj,t.status),t.promise.then(function(){n._removeFromOrder(t)}).catch(function(e){t.saving=!1,t.error=!0,r.dhxError(e)}),t.saving=!0,this._saving=!0,this._addToChain(t.promise),t.promise},e.prototype._addToChain=function(t){this._parent.saveData&&this._saving?this._parent.saveData=this._parent.saveData.then(function(){return t}):this._parent.saveData=t},e.prototype._findPrevState=function(t){for(var e=0,n=this._changes.order;e<n.length;e++){var r=n[e];if(r.id===t)return r}return null},e.prototype._removeFromOrder=function(t){this._changes.order=this._changes.order.filter(function(e){return!r.isEqualObj(e,t)})},e}();e.Loader=i}).call(e,n(5))},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=n(0),i=function(){function t(t){this._parent=t}return t.prototype.sort=function(t,e){var n=this;e.rule&&"function"==typeof e.rule?this._sort(t,e):e.by&&(e.rule=function(t,i){var o=n._checkVal(e.as,t[e.by]),s=n._checkVal(e.as,i[e.by]);return r.naturalCompare(o,s)},this._sort(t,e))},t.prototype._checkVal=function(t,e){return t?t.call(this,e):e},t.prototype._sort=function(t,e){var n=this,r={asc:1,desc:-1};return t.sort(function(t,i){var o=n._parent.getItem(t),s=n._parent.getItem(i);return e.rule.call(n,o,s)*(r[e.dir]||r.asc)})},t}();e.Sort=i},function(t,e,n){"use strict";(function(t){Object.defineProperty(e,"__esModule",{value:!0});var n=function(){function e(t){this.url=t}return e.prototype.load=function(){return this.ajax(this.url)},e.prototype.save=function(t,e){var n={insert:"POST",delete:"DELETE",update:"POST"};return this.ajax(this.url,t,n[e])},e.prototype.ajax=function(e,n,r){return void 0===r&&(r="GET"),new t(function(t,i){var o=new XMLHttpRequest;switch(o.onload=function(){o.status>=200&&o.status<300?t(JSON.parse(o.response||o.responseText)):i({status:o.status,statusText:o.statusText})},o.onerror=function(){i({status:o.status,statusText:o.statusText})},o.open(r,e),o.setRequestHeader("Content-Type","application/json"),r){case"POST":o.send(JSON.stringify(n));break;case"GET":o.send();break;case"DELETE":case"PUT":o.send(JSON.stringify(n));break;default:o.send()}})},e}();e.DataProxy=n}).call(e,n(5))},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=n(20),i=n(11),o=n(3),s=n(23),a=n(24),c=n(21),u=n(22);e.ShapesFactory=function(t){switch(t.type){case"rect":return new c.Rect(t);case"circle":return new r.Circle(t);case"triangle":return new u.Triangle(t);case"line":return new i.Connector(t);case"card":return new o.DiagramCard(t);case"img-card":return new s.DiagramImgCard(t);case"svg-card":return new a.DiagramSvgCard(t);default:window.console.error("Wrong shape type: "+t.type,t)}}},function(t,e,n){"use strict";var r=this&&this.__extends||function(){var t=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,e){t.__proto__=e}||function(t,e){for(var n in e)e.hasOwnProperty(n)&&(t[n]=e[n])};return function(e,n){function r(){this.constructor=e}t(e,n),e.prototype=null===n?Object.create(n):(r.prototype=n.prototype,new r)}}();Object.defineProperty(e,"__esModule",{value:!0});var i=n(13),o=n(18),s=function(t){function e(e,n){return t.call(this,{beforeAdd:function(t){var r=t.from?n:e;return t.type=t.type||r,o.ShapesFactory(t)}})||this}return r(e,t),e.prototype.getLinks=function(){return this._group().links},e.prototype.getShapes=function(){return this._group().shapes},e.prototype.getAll=function(){var t=this;return this._order.map(function(e){return t._pull[e]})},e.prototype.removeNested=function(t){var e=this._pull;for(var n in e){var r=e[n].config;r.from!==t&&r.to!==t&&r.id!==t||(this.remove(r.id),r.to&&this.removeNested(r.to))}},e.prototype._group=function(){var t={links:{},shapes:{}};for(var e in this._pull)this._pull[e].isConnector()?t.links[e]=this._pull[e]:t.shapes[e]=this._pull[e];return t},e}(i.DataCollection);e.ShapesCollection=s},function(t,e,n){"use strict";var r=this&&this.__extends||function(){var t=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,e){t.__proto__=e}||function(t,e){for(var n in e)e.hasOwnProperty(n)&&(t[n]=e[n])};return function(e,n){function r(){this.constructor=e}t(e,n),e.prototype=null===n?Object.create(n):(r.prototype=n.prototype,new r)}}();Object.defineProperty(e,"__esModule",{value:!0});var i=n(1),o=n(2),s=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return r(e,t),e.prototype.toSVG=function(){var t=this.config,e=this.getCenter();return'\n\t\t<g\n\t\t\tclass="'+(t.css||"")+'"\n\t\t\ttransform="translate('+t.x+","+t.y+") rotate("+(t.angle||0)+","+e.x+","+e.y+')"\n\t\t\tdhx_id="'+t.id+'">\n\t\t\t\t<path\n\t\t\t\t\tclass="shape"\n\t\t\t\t\td="\n\t\t\t\t\tM0,'+e.y+"\n\t\t\t\t\ta"+e.x+","+e.y+" 0 1,0 "+t.width+",0\n\t\t\t\t\ta"+e.x+","+e.y+" 0 1,0 "+-t.width+',0"\n\t\t\t\t/>\n\t\t\t\t'+o.getTextTemplate(t,t.text)+"\n\t\t\t</g>\n\t\t"},e}(i.BaseShape);e.Circle=s},function(t,e,n){"use strict";var r=this&&this.__extends||function(){var t=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,e){t.__proto__=e}||function(t,e){for(var n in e)e.hasOwnProperty(n)&&(t[n]=e[n])};return function(e,n){function r(){this.constructor=e}t(e,n),e.prototype=null===n?Object.create(n):(r.prototype=n.prototype,new r)}}();Object.defineProperty(e,"__esModule",{value:!0});var i=n(1),o=n(2),s=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return r(e,t),e.prototype.toSVG=function(){var t=this.config,e=this.getCenter();return'\n\t\t<g\n\t\t\ttransform="translate('+t.x+","+t.y+") rotate("+(t.angle||0)+","+e.x+","+e.y+')"\n\t\t\tclass="'+(t.css||"")+'"\n\t\t\tid="'+t.id+'"\n\t\t\tdhx_id="'+t.id+'">\n\t\t\t\t<rect\n\t\t\t\t\tclass="shape"\n\t\t\t\t\tid="'+t.id+'"\n\t\t\t\t\theight="'+t.height+'"\n\t\t\t\t\twidth="'+t.width+'"\n\t\t\t\t/>\n\t\t\t\t'+o.getTextTemplate(t,t.text)+"\n\t\t</g>"},e}(i.BaseShape);e.Rect=s},function(t,e,n){"use strict";var r=this&&this.__extends||function(){var t=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,e){t.__proto__=e}||function(t,e){for(var n in e)e.hasOwnProperty(n)&&(t[n]=e[n])};return function(e,n){function r(){this.constructor=e}t(e,n),e.prototype=null===n?Object.create(n):(r.prototype=n.prototype,new r)}}();Object.defineProperty(e,"__esModule",{value:!0});var i=n(1),o=n(2),s=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return r(e,t),e.prototype.toSVG=function(){var t=this.config,e=this.getCenter();return'\n\t\t<g transform="\n\t\t\ttranslate('+t.x+","+t.y+") rotate("+(t.angle||0)+","+e.x+","+e.y+')"\n\t\t\tclass="'+(t.css||"")+'" dhx_id="'+t.id+'">\n\t\t\t<path\n\t\t\t\tclass="shape"\n\t\t\t\td="M '+t.width/2+" 0 L"+t.width+" "+t.height+" L 0 "+t.height+' z"\n\t\t/>\n\t\t\t'+o.getTextTemplate(t,t.text)+"\n\t\t</g>"},e}(i.BaseShape);e.Triangle=s},function(t,e,n){"use strict";var r=this&&this.__extends||function(){var t=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,e){t.__proto__=e}||function(t,e){for(var n in e)e.hasOwnProperty(n)&&(t[n]=e[n])};return function(e,n){function r(){this.constructor=e}t(e,n),e.prototype=null===n?Object.create(n):(r.prototype=n.prototype,new r)}}();Object.defineProperty(e,"__esModule",{value:!0});var i=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return r(e,t),e.prototype.setDefaults=function(t){return t.width=t.width||300,t.height=t.height||100,t},e.prototype.getCss=function(){return"dhx_diagram_image "+t.prototype.getCss.call(this)},e.prototype.text=function(){var t=this.config;return"<img class='dhx_context_img' src=\""+t.img+"\">\n\t\t\t<div class='dhx_context_title'>"+(t.title||"")+"</div>\n\t\t\t<div class='dhx_context_text'>"+(t.text||"")+"</div>"},e}(n(3).DiagramCard);e.DiagramImgCard=i},function(t,e,n){"use strict";var r=this&&this.__extends||function(){var t=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,e){t.__proto__=e}||function(t,e){for(var n in e)e.hasOwnProperty(n)&&(t[n]=e[n])};return function(e,n){function r(){this.constructor=e}t(e,n),e.prototype=null===n?Object.create(n):(r.prototype=n.prototype,new r)}}();Object.defineProperty(e,"__esModule",{value:!0});var i=n(3),o=n(2),s=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return r(e,t),e.prototype.toSVG=function(){var t=this.config,e=this.getCenter(),n=t.$selected?t.color:"#E4E4E4";return'\n\t\t<g transform="\n\t\ttranslate('+t.x+","+t.y+") rotate("+(t.angle||0)+","+e.x+","+e.y+')"\n\t\tclass="'+this.getCss()+'"\n\t\tdhx_id="'+t.id+'"\n\t\t>\n\t\t\t<rect\n\t\t\t\tclass="dhx_item_shape"\n\t\t\t\tid="'+t.id+'"\n\t\t\t\theight="'+t.height+'"\n\t\t\t\twidth="'+t.width+'"\n\t\t\t\trx=1\n\t\t\t\try=1\n\t\t\t\tstroke="'+n+'"\n\t\t\t\tstroke-width=1\n\t\t\t/>\n\t\t\t<text y="'+t.height/2+'" dy="-5" x="'+t.width/2+'" text-anchor="middle">\n\t\t\t'+(t.title?'\n\t\t\t\t<tspan\n\t\t\t\t\tclass="dhx_content_title"\n\t\t\t\t>\n\t\t\t\t\t'+(t.title||"")+"\n\t\t\t\t</tspan>\n\t\t\t":"")+'\n\t\t\t\t<tspan\n\t\t\t\t\tclass="dhx_content_text"\n\t\t\t\t\tx='+t.width/2+"\n\t\t\t\t\tdy="+(t.title?"1.5em":".5em")+"\n\t\t\t\t>\n\t\t\t\t\t"+(t.text||"")+"\n\t\t\t\t</tspan>\n\t\t\t</text>\n\t\t\t"+o.getHeaderTpl(t)+"\n\t\t\t"+o.getCircleTpl(t)+"\n\t\t</g>"},e.prototype.getCss=function(){return"dhx_diagram_svg-card "+(t.prototype.getCss.call(this)||"")},e}(i.DiagramCard);e.DiagramSvgCard=s},,,function(t,e){function n(){throw new Error("setTimeout has not been defined")}function r(){throw new Error("clearTimeout has not been defined")}function i(t){if(h===setTimeout)return setTimeout(t,0);if((h===n||!h)&&setTimeout)return h=setTimeout,setTimeout(t,0);try{return h(t,0)}catch(e){try{return h.call(null,t,0)}catch(e){return h.call(this,t,0)}}}function o(t){if(f===clearTimeout)return clearTimeout(t);if((f===r||!f)&&clearTimeout)return f=clearTimeout,clearTimeout(t);try{return f(t)}catch(e){try{return f.call(null,t)}catch(e){return f.call(this,t)}}}function s(){g&&p&&(g=!1,p.length?d=p.concat(d):_=-1,d.length&&a())}function a(){if(!g){var t=i(s);g=!0;for(var e=d.length;e;){for(p=d,d=[];++_<e;)p&&p[_].run();_=-1,e=d.length}p=null,g=!1,o(t)}}function c(t,e){this.fun=t,this.array=e}function u(){}var h,f,l=t.exports={};!function(){try{h="function"==typeof setTimeout?setTimeout:n}catch(t){h=n}try{f="function"==typeof clearTimeout?clearTimeout:r}catch(t){f=r}}();var p,d=[],g=!1,_=-1;l.nextTick=function(t){var e=new Array(arguments.length-1);if(arguments.length>1)for(var n=1;n<arguments.length;n++)e[n-1]=arguments[n];d.push(new c(t,e)),1!==d.length||g||i(a)},c.prototype.run=function(){this.fun.apply(null,this.array)},l.title="browser",l.browser=!0,l.env={},l.argv=[],l.version="",l.versions={},l.on=u,l.addListener=u,l.once=u,l.off=u,l.removeListener=u,l.removeAllListeners=u,l.emit=u,l.prependListener=u,l.prependOnceListener=u,l.listeners=function(t){return[]},l.binding=function(t){throw new Error("process.binding is not supported")},l.cwd=function(){return"/"},l.chdir=function(t){throw new Error("process.chdir is not supported")},l.umask=function(){return 0}},function(t,e,n){(function(t,e){!function(t,n){"use strict";function r(t){delete c[t]}function i(t){var e=t.callback,r=t.args;switch(r.length){case 0:e();break;case 1:e(r[0]);break;case 2:e(r[0],r[1]);break;case 3:e(r[0],r[1],r[2]);break;default:e.apply(n,r)}}function o(t){if(u)setTimeout(o,0,t);else{var e=c[t];if(e){u=!0;try{i(e)}finally{r(t),u=!1}}}}if(!t.setImmediate){var s,a=1,c={},u=!1,h=t.document,f=Object.getPrototypeOf&&Object.getPrototypeOf(t);f=f&&f.setTimeout?f:t,"[object process]"==={}.toString.call(t.process)?s=function(t){e.nextTick(function(){o(t)})}:function(){if(t.postMessage&&!t.importScripts){var e=!0,n=t.onmessage;return t.onmessage=function(){e=!1},t.postMessage("","*"),t.onmessage=n,e}}()?function(){var e="setImmediate$"+Math.random()+"$",n=function(n){n.source===t&&"string"==typeof n.data&&0===n.data.indexOf(e)&&o(+n.data.slice(e.length))};t.addEventListener?t.addEventListener("message",n,!1):t.attachEvent("onmessage",n),s=function(n){t.postMessage(e+n,"*")}}():t.MessageChannel?function(){var t=new MessageChannel;t.port1.onmessage=function(t){o(t.data)},s=function(e){t.port2.postMessage(e)}}():h&&"onreadystatechange"in h.createElement("script")?function(){var t=h.documentElement;s=function(e){var n=h.createElement("script");n.onreadystatechange=function(){o(e),n.onreadystatechange=null,t.removeChild(n),n=null},t.appendChild(n)}}():s=function(t){setTimeout(o,0,t)},f.setImmediate=function(t){"function"!=typeof t&&(t=new Function(""+t));for(var e=new Array(arguments.length-1),n=0;n<e.length;n++)e[n]=arguments[n+1];var r={callback:t,args:e};return c[a]=r,s(a),a++},f.clearImmediate=r}}("undefined"==typeof self?void 0===t?this:t:self)}).call(e,n(7),n(27))},function(t,e,n){function r(t,e){this._id=t,this._clearFn=e}var i=Function.prototype.apply;e.setTimeout=function(){return new r(i.call(setTimeout,window,arguments),clearTimeout)},e.setInterval=function(){return new r(i.call(setInterval,window,arguments),clearInterval)},e.clearTimeout=e.clearInterval=function(t){t&&t.close()},r.prototype.unref=r.prototype.ref=function(){},r.prototype.close=function(){this._clearFn.call(window,this._id)},e.enroll=function(t,e){clearTimeout(t._idleTimeoutId),t._idleTimeout=e},e.unenroll=function(t){clearTimeout(t._idleTimeoutId),t._idleTimeout=-1},e._unrefActive=e.active=function(t){clearTimeout(t._idleTimeoutId);var e=t._idleTimeout;e>=0&&(t._idleTimeoutId=setTimeout(function(){t._onTimeout&&t._onTimeout()},e))},n(28),e.setImmediate=setImmediate,e.clearImmediate=clearImmediate},,,,,,,,,,,,,function(t,e){},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),n(42);var r=n(9);window.dhx=window.dhx||{},window.dhx.Diagram=r.Diagram}]);