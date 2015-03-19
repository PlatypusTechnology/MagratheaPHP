<style>

 /*!
 *	style.css
 */
#pageTitle{
	padding-left: 0px;
	font-weight: bold;
}
.pageTitleContainer {
	width: 100%;
	float: left;
	margin-left: 0;
	padding-top: 20px;
	text-align: center;
	background-color: #FFF;
	padding-bottom: 10px;
}
#main_content {
	margin-top: 10px;
}
 #loader{position:absolute;background-color:rgba(0,0,0,0.7);width:100%;height:100%;top:0;left:0;z-index:9999}#loader img{width:20px;height:20px;position:absolute;top:50%;left:50%;margin-top:-10px;margin-left:-10px}.brand{position:absolute;left:20%}.main_container{padding-top:100px;padding-bottom:150px}ul.menu{background-color:#FFF;border-radius:6px 6px 6px 6px;box-shadow:0 1px 4px rgba(0,0,0,0.067);width:250px;top:70px;margin:30px 0 0;padding:0}ul.menu > li > a{border:1px solid #E5E5E5;display:block;margin:0 0 -1px;padding:8px 14px}ul.menu > li:first-child > a{border-radius:6px 6px 0 0}ul.menu > li:last-child > a{border-radius:0 0 6px 6px}ul.menu_sublist > li > a{border:1px solid #E5E5E5;background-color:#F7F7F7;margin-top:-1px;margin-bottom:-1px;padding:8px 20px}ul.menu > li > a > span.number{width:20px;height:20px;font-size:10px;border:1px solid #CCC;border-radius:3px;color:#000;float:right;background-color:#F3F3F3;text-align:center}.footer{background-color:#F5F5F5;border-top:1px solid #E5E5E5;margin-top:100px;height:30px;width:100%;text-align:center;bottom:0;position:fixed;z-index:9998;padding:5px 0}.footer p{color:#777;margin-bottom:0}.footer-links{margin:10px 0}.mag_section{border:1px solid #CCC;border-radius:6px;box-shadow:0 1px 4px rgba(0,0,0,0.067);margin-bottom:10px}.mag_section > header{background-color:#CCC;padding:10px 20px}.mag_section > header > h3{font-size:14px;color:#407ec4;line-height:0;display:inline}.mag_section > header span.breadc{font-size:14px;padding:0 10px}.mag_section > header span.breadc.active{font-weight:700}.mag_section > header span.breadc.divider{color:#407ec4}.mag_section > header.hide_opt > span.arrow{border-left:1px solid #407ec4;float:right}.mag_section > header.hide_opt > span.arrow > a{height:20px;width:20px}.mag_section > header.hide_opt > span.arrow > a > i{margin-left:50%}.mag_section > content{display:block;padding:10px}.mag_section > content > h3{font-variant:small-caps;padding:5px 5px 5px 50px}.mag_section > content > p{padding-bottom:10px;padding-left:15px;padding-right:15px}ul.nav-tabs{margin-bottom:0}.tab-content{border-top:0;border-left:1px solid #DDD;border-right:1px solid #DDD;border-bottom:1px solid #DDD;border-radius:0 0 6px 6px;padding:10px}.collapse{right:200px}.right{text-align:right}.center{text-align:center}.icon_light{opacity:0.3}i{cursor:default} 
.even {
	background-color: #CCC;
}
.odd {
	background-color: #EEE;
}
.plugin_install {
	padding-top: 20px;
}
.singlePlugin {
	margin-bottom: 5px;
	overflow: hidden;
}
.textarea_large{
	width: 90%;
	height: 200px;
}
/*!
 *	prettify.css
 */
.lit{color:#195f91}.fun{color:#dc322f}.str,.atv{color:#D14}.kwd,.linenums .tag{color:#1e347b}.typ,.atn,.dec,.var{color:teal}.pln{color:#48484c}.prettyprint{background-color:#f7f7f9;border:1px solid #e1e1e8;padding:8px}.prettyprint.linenums{-webkit-box-shadow:inset 40px 0 0 #fbfbfc, inset 41px 0 0 #ececf0;-moz-box-shadow:inset 40px 0 0 #fbfbfc, inset 41px 0 0 #ececf0;box-shadow:inset 40px 0 0 #fbfbfc, inset 41px 0 0 #ececf0}ol.linenums{margin:0 0 0 33px}ol.linenums li{padding-left:12px;color:#bebec5;line-height:18px;text-shadow:0 1px 0 #fff}.com,.pun,.opn,.clo{color:#93a1a1}
/*!
 *	jquery.ibutton.min.css
 */
.ibutton-container{position:relative;height:27px;cursor:pointer;overflow:hidden;max-width:400px;-khtml-user-select:none;-o-user-select:none;-moz-user-select:none;-moz-user-focus:ignore;-moz-user-input:disabled;width:60px}.ibutton-container input{position:absolute;top:0;left:0;filter:alpha(opacity=0);-moz-opacity:0.0;opacity:0.0;-moz-user-input:enabled!important}.ibutton-handle{display:block;height:27px;cursor:inherit;position:absolute;top:0;left:0;background:transparent url(/plugins/iButton/images/ibutton-slider-default.png) no-repeat scroll 0 -54px;z-index:3;padding-left:3px;width:22px}.ibutton-handle-right{height:100%;width:100%;padding-right:3px;background:transparent url(/plugins/iButton/images/ibutton-slider-default.png) no-repeat scroll 100% -54px;z-index:3}.ibutton-handle-middle{height:100%;width:100%;background:transparent url(/plugins/iButton/images/ibutton-slider-default.png) no-repeat scroll 50% -54px;z-index:3}div.ibutton-label-on,div.ibutton-label-off{white-space:nowrap;font-size:17px;line-height:17px;font-weight:700;font-family:Helvetica Neue, Arial, Helvetica, sans-serif;text-transform:uppercase;cursor:inherit;display:block;height:22px;position:absolute;width:auto;top:0;padding-top:5px;overflow:hidden;background:transparent url(/plugins/iButton/images/ibutton-slider-default.png) no-repeat scroll 0 0}div.ibutton-label-on{color:#fff;text-shadow:0 -1px 2px rgba(0,0,0,0.4);left:0;padding-top:5px;z-index:1}div.ibutton-label-on span{padding-left:5px}div.ibutton-label-off{color:#7c7c7c;background-position:100% 0;text-shadow:0 -1px 2px rgba(153,153,153,0.4);text-align:right;right:0;width:95%}div.ibutton-label-off span{padding-right:5px}.ibutton-container label{display:inline;cursor:inherit;font-size:1em!important;padding:1px 3px}.ibutton-focus label{border:1px dotted #666!important;padding:0 2px}.ibutton-focus div.ibutton-label-on span label{border-color:#fff!important}.ibutton-padding-left,.ibutton-padding-right{position:absolute;top:4px;z-index:2;background:transparent url(/plugins/iButton/images/ibutton-slider-default.png) no-repeat scroll 0 -4px;width:3px;height:20px}.ibutton-padding-left{left:0}.ibutton-padding-right{right:0;background-position:100% -4px}.ibutton-active-handle .ibutton-handle{background-position:0 -108px}.ibutton-active-handle .ibutton-handle-right{background-position:100% -108px}.ibutton-active-handle .ibutton-handle-middle{background-position:50% -108px}.ibutton-disabled{cursor:not-allowed!important}.ibutton-disabled .ibutton-handle{background-position:0 -81px}.ibutton-disabled .ibutton-handle-right{background-position:100% -81px}.ibutton-disabled .ibutton-handle-middle{background-position:50% -81px}.ibutton-disabled div.ibutton-label-on{background-position:0 -27px;color:#fff}.ibutton-disabled div.ibutton-label-off{background-position:100% -27px;color:#cbcbcb}.ibutton-disabled .ibutton-padding-left{background-position:0 -27px}.ibutton-disabled .ibutton-padding-right{background-position:100% -27px}

.menu a{
	cursor: pointer;
}

.magratheaShowAll {
	border: 1px solid #333;
}
.magratheaShowAll th { 
	color: #722;
	border: 1px solid #777;	
}
.magratheaShowAll td {
	border: 1px solid #777;
}
.magratheaShowAll tr:nth-child(even) {background: #DDD}
.magratheaShowAll tr:nth-child(odd) {background: #FFF}
</style>