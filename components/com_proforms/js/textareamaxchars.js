// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// @license: Mad4Media Javascipt License - copyright Mad4Media - Fahrettin Kutyol - All rights reserved    ++
// (re-) publishing or forking for any purpose of commercial or non-commercial use is not allowed.		   ++
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
dojo.addOnLoad(function(){console.log("MAX CHARS FOR TEXTAREA");dojo.query(".proformsMaxLength",dojo.byId("proforms_proforms")).forEach(function(_1){var _2=dojo.attr(_1,"name");_1.counter=dojo.byId("left_"+_2);_1.maximum=parseInt(dojo.attr(_1,"maxlength"));_1.process=function(){var _3=this.value.length;if(_3>this.maximum){_1.value=_1.value.substring(0,this.maximum);_3=this.maximum;}var _4=this.maximum-_3;this.counter.innerHTML=_4;};dojo.connect(_1,"onkeydown",function(){this.process();});dojo.connect(_1,"onchange",function(){this.process();});_1.process();});});