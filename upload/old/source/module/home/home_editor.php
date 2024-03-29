<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: home_editor.php 21126 2011-03-16 04:16:02Z maruitao $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if(empty($_GET['charset']) || !in_array(strtolower($_GET['charset']), array('gbk', 'big5', 'utf-8'))) $_GET['charset'] = '';
$allowhtml = empty($_GET['allowhtml'])?0:1;

$doodle = empty($_GET['doodle'])?0:1;
$isportal = empty($_GET['isportal'])?0:1;
if(empty($_GET['op'])) {

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=<?=$_GET['charset']?>" />
<title>Editor</title>
<script type="text/javascript" src="static/js/common.js"></script>
<script type="text/javascript" src="static/js/home.js"></script>
<script language="javascript" src="static/image/editor/editor_base.js"></script>
<style type="text/css">
body{margin:0;padding:0;}
body, td, input, button, select, textarea {font: 12px/1.5em Tahoma, Arial, Helvetica, snas-serif;}
textarea { resize: none; font-size: 14px; line-height: 1.8em; }
.submit { padding: 0 10px; height: 22px; border: 1px solid; border-color: #DDD #264F6E #264F6E #DDD; background: #2782D6; color: #FFF; line-height: 20px; letter-spacing: 1px; cursor: pointer; }
a.dm{text-decoration:none}
a.dm:hover{text-decoration:underline}
a{font-size:12px}
img{border:0}
td.icon{width:24px;height:24px;text-align:center;vertical-align:middle}
td.sp{width:8px;height:24px;text-align:center;vertical-align:middle}
td.xz{width:47px;height:24px;text-align:center;vertical-align:middle}
td.bq{width:49px;height:24px;text-align:center;vertical-align:middle}
div a.n{height:16px;line-height:16px;display:block;padding:2px;color:#000000;text-decoration:none}
div a.n:hover{background:#E5E5E5}
.r_op { float: right; }
.eMenu{position:absolute;margin-top: -2px;background:#FFFFFF;border:1px solid #C5C5C5;padding:4px}
	.eMenu ul, .eMenu ul li { margin: 0; padding: 0; }
	.eMenu ul li{list-style: none;float:left}
	#editFaceBox { padding: 5px; }
		#editFaceBox li { width: 25px; height: 25px; overflow: hidden; }
.t_input { padding: 3px 2px; border-style: solid; border-width: 1px; border-color: #7C7C7C #C3C3C3 #DDD; line-height: 16px; }
a.n1{height:16px;line-height:16px;display:block;padding:2px;color:#000000;text-decoration:none}
a.n1:hover{background:#E5E5E5}
a.cs{height:15px;position:relative}
*:lang(zh) a.cs{height:12px}
.cs .cb{font-size:0;display:block;width:10px;height:8px;position:absolute;left:4px;top:3px;cursor:hand!important;cursor:pointer}
.cs span{position:absolute;left:19px;top:0px;cursor:hand!important;cursor:pointer;color:#333}

.fRd1 .cb{background-color:#800}
.fRd2 .cb{background-color:#800080}
.fRd3 .cb{background-color:#F00}
.fRd4 .cb{background-color:#F0F}
.fBu1 .cb{background-color:#000080}
.fBu2 .cb{background-color:#00F}
.fBu3 .cb{background-color:#0FF}
.fGn1 .cb{background-color:#008080}
.fGn2 .cb{background-color:#008000}
.fGn3 .cb{background-color:#808000}
.fGn4 .cb{background-color:#0F0}
.fYl1 .cb{background-color:#FC0}
.fBk1 .cb{background-color:#000}
.fBk2 .cb{background-color:#808080}
.fBk3 .cb{background-color:#C0C0C0}
.fWt0 .cb{background-color:#FFF;border:1px solid #CCC}

.mf_nowchose{height:30px;background-color:#DFDFDF;border:1px solid #B5B5B5;border-left:none}
.mf_other{height:30px;border-left:1px solid #B5B5B5}
.mf_otherdiv{height:30px;width:30px;border:1px solid #FFF;border-right-color:#D6D6D6;border-bottom-color:#D6D6D6;background-color:#F8F8F8}
.mf_otherdiv2{height:30px;width:30px;border:1px solid #B5B5B5;border-left:none;border-top:none}
.mf_link{font-size:12px;color:#000000;text-decoration:none}
.mf_link:hover{font-size:12px;color:#000000;text-decoration:underline}

.ico{height:24px;width:24px;vertical-align:middle;text-align:center}
.ico2{height:24px;width:27px;vertical-align:middle;text-align:center}
.ico3{height:24px;width:25px;vertical-align:middle;text-align:center}
.ico4{height:24px;width:8px;vertical-align:middle;text-align:center}

.icons a,.edTb,.sepline,.switch,.tbri{background-image:url(static/image/editor/editor_boolbar.gif)}

.toobar{position:relative;height:29px;overflow:hidden}
.tble{position:absolute;left:0;top:2px }
*:lang(zh) .tble{top:2px}
.tbri{width:20px;position:absolute;right:3px;top:2px;background-position:0 -33px}
*:lang(zh) .tbri{top:2px;background-position:0 -31px}

.icons a{width:23px;height:23px;background-repeat:no-repeat;display:block;float:left;border:1px solid #efefef;border-top:1px solid #EFEFEF;border-bottom:1px solid #F2F3F2}
*:lang(zh) .icons a{margin-right:1px}
.icons a:hover{border-top:1px solid #CCC;border-right:1px solid #999;border-bottom:1px solid #999;border-left:1px solid #CCC;background-color:#FFF}
a.icoCut{background-position:1px 2px;}
a.icoCpy{background-position:-27px 1px;}
a.icoPse{background-position:-55px 1px}
a.icoFfm{background-position:-82px 1px;width:27px}
a.icoFsz{background-position:-111px 1px;}
*:lang(zh) a.icoFsz{margin:0}
a.icoWgt{background-position:-139px 0;}
*:lang(zh) a.icoWgt{width:21px}
a.icoIta{background-position:-166px 0;}
*:lang(zh) a.icoIta{width:21px}
a.icoUln{background-position:-196px 1px;}
*:lang(zh) a.icoUln{margin:0}
a.icoAgn{background-position:-224px 1px}
a.icoLst{background-position:-252px 1px}
a.icoOdt{background-position:-309px 1px}
a.icoIdt{background-position:-308px 1px}
a.icoFcl{background-position:-335px 1px}
a.icoBcl{background-position:-362px 1px}
a.icoUrl{background-position:-392px 1px;}
a.icoMoveUrl{background-position:-486px 1px}
a.icoRenew {background-position:-519px 1px}
a.icoFace {background-position:-553px 1px}
a.icoPage {background-position:-702px 1px}
a.icoDown {background-position:-734px 1px}
a.icoDoodle {background-position:-584px 1px}
a.icoImg{background-position:-420px 1px}
a.icoSwf{background-position:-447px 1px}
a.icoSwitchTxt{background-position:-638px 0px;width:23px;float:right}
a.icoSwitchMdi{background-position:-671px 0px;width:23px}

.edTb{border-bottom:1px solid #c5c5c5;background-position:0 -28px}
.sepline{width:4px;height:20px;margin-top:2px;margin-right:3px;background-position:-476px 0;background-repeat:no-repeat;float:left }
</style>
<script language="JavaScript">
function fontname(obj){format('fontname',obj.innerHTML);obj.parentNode.style.display='none'}
function fontsize(size,obj){format('fontsize',size);obj.parentNode.style.display='none'}
</script>
</head>
<body style="overflow-y:hidden">
<table cellpadding="0" cellspacing="0" width="100%" id="dvHtmlLnk" style="display:none">
<tr>
<td height="31">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="edTb">
<tr>
<td height="31" style="padding-left:3px;">

<div class="toobar">
<div class="icons tble">
<a href="javascript:;" class="icoSwitchMdi" title="<?=lang('home/editor', 'editor_switch_media')?>" onClick="changeEditType(true);return false;"></a>
</div>
</div>
</td></tr></table>
</td></tr></table>
<textarea id="dvtext" style="overflow-y:auto;padding:4px;width:100%;height:369px;word-wrap:break-word;border:0;display:none;"></textarea>
<div >

<table cellpadding="0" cellspacing="0" width="100%" height="100%" id="dvhtml">
<tr>
<td height="31">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="edTb">
<tr>
<td height="31" style="padding-left:3px">

<div class="toobar">
<div class="icons tble">
<a href="javascript:;" class="icoCut" title="<?=lang('home/editor', 'editor_cut')?>" onClick="format('Cut');return false;"></a>
<a href="javascript:;" class="icoCpy" title="<?=lang('home/editor', 'editor_copy')?>" onClick="format('Copy');return false;"></a>
<a href="javascript:;" class="icoPse" title="<?=lang('home/editor', 'editor_paste')?>" onClick="format('Paste');return false;"></a>
<div class="sepline"></div>
<a href="javascript:;" class="icoFfm" id="imgFontface" title="<?=lang('home/editor', 'editor_font')?>" onClick="fGetEv(event);fDisplayElement('fontface','');return false;"></a>
<a href="javascript:;" class="icoFsz" id="imgFontsize" title="<?=lang('home/editor', 'editor_fontsize')?>" onClick="fGetEv(event);fDisplayElement('fontsize','');return false;"></a>
<a href="javascript:;" class="icoWgt" onClick="format('Bold');return false;" title="<?=lang('home/editor', 'editor_fontbold')?>"></a>
<a href="javascript:;" class="icoIta" title="<?=lang('home/editor', 'editor_fontitalic')?>" onClick="format('Italic');return false;"></a>
<a href="javascript:;" class="icoUln" onClick="format('Underline');return false;" title="<?=lang('home/editor', 'editor_fontunderline')?>"></a>
<a href="javascript:;" class="icoFcl" title="<?=lang('home/editor', 'editor_funtcolor')?>" onClick="foreColor(event);return false;" id="imgFontColor"></a>
<a href="javascript:;" class="icoAgn" id="imgAlign" onClick="fGetEv(event);fDisplayElement('divAlign','');return false;" title="<?=lang('home/editor', 'editor_align')?>"></a>
<a href="javascript:;" class="icoLst" id="imgList" onClick="fGetEv(event);fDisplayElement('divList','');return false;"title="<?=lang('home/editor', 'editor_list')?>"></a>
<a href="javascript:;" class="icoOdt" id="imgInOut" onClick="fGetEv(event);fDisplayElement('divInOut','');return false;" title="<?=lang('home/editor', 'editor_indent')?>"></a>
<div class="sepline"></div>
<a href="javascript:;" class="icoUrl" id="icoUrl" onClick="createLink(event, 1);return false;" title="<?=lang('home/editor', 'editor_hyperlink')?>"></a>
<a href="javascript:;" class="icoMoveUrl" onClick="clearLink();return false;" title="<?=lang('home/editor', 'editor_remove_link')?>"></a>
<a href="javascript:;" class="icoImg" id="icoImg" onClick="createImg(event, 1);return false;" title="<?=lang('home/editor', 'editor_link_image')?>"></a>
<a href="javascript:;" class="icoSwf" id="icoSwf" onClick="createFlash(event, 1);return false;" title="<?=lang('home/editor', 'editor_link_flash')?>"></a>
<a href="javascript:;" class="icoFace" id="faceBox" onClick="faceBox(event);return false;" title="<?=lang('home/editor', 'editor_insert_smiley')?>"></a>
<?php if($doodle) { ?>
<a href="javascript:;" class="icoDoodle" id="doodleBox" onClick="doodleBox(event, this.id);return false;" title="<?=lang('home/editor', 'editor_doodle')?>"></a>
<?php }?>
<?php if($isportal) {?>
<a href="javascript:;" class="icoPage" id="newPage" onClick="pageBreak();return false;" title="<?=lang('home/editor', 'editor_pagebreak')?>"></a>
<a href="javascript:;" class="icoDown" id="newPage" onClick="parent.downRemoteFile();return false;" title="<?=lang('home/editor', 'editor_download_remote')?>"></a>
<?php }?>
<a href="javascript:;" class="icoRenew" onClick="renewContent();return false;" title="<?=lang('home/editor', 'editor_restore')?>"></a>
<?php if($allowhtml) {?>
<input type="checkbox" value="1" name="switchMode" id="switchMode" style="float:left;margin-top:6px!important;margin-top:2px" onClick="setMode(this.checked)" onMouseOver="fSetModeTip(this)" onMouseOut="fHideTip()">
<?php } else {?>
<input type="hidden" value="1" name="switchMode" id="switchMode">
<?php }?>

</div>
<div class="icons tbri">
<a href="javascript:;" class="icoSwitchTxt" title="<?=lang('home/editor', 'editor_switch_text')?>" onClick="changeEditType(false, event);return false;"></a>
</div>
</div>

<div class="toobar" style="display:none" id="dvHtmlLnk">
<div class="icons tble">
<a href="javascript:;" class="icoSwitchMdi" title="<?=lang('home/editor', 'editor_switch_media')?>" onClick="changeEditType(true, event);return false;"></a>
</div>
</div>
</td>
</tr>
</table>

<div style="width:100px;height:100px;position:absolute;display:none;top:-500px;left:-500px" ID="dvPortrait"></div>
<div id="fontface" class="eMenu" style="z-index:99;display:none;top:35px;left:2px;width:110px;height:265px">
<a href="javascript:;" onClick="fontname(this)" class="n" style="font:normal 12px '<?=lang('home/editor', 'editor_font_song')?>';"><?=lang('home/editor', 'editor_font_song')?></a>
<a href="javascript:;" onClick="fontname(this)" class="n" style="font:normal 12px '<?=lang('home/editor', 'editor_font_hei')?>';"><?=lang('home/editor', 'editor_font_hei')?></a>
<a href="javascript:;" onClick="fontname(this)" class="n" style="font:normal 12px '<?=lang('home/editor', 'editor_font_kai')?>';"><?=lang('home/editor', 'editor_font_kai')?></a>
<a href="javascript:;" onClick="fontname(this)" class="n" style="font:normal 12px '<?=lang('home/editor', 'editor_font_li')?>';"><?=lang('home/editor', 'editor_font_li')?></a>
<a href="javascript:;" onClick="fontname(this)" class="n" style="font:normal 12px '<?=lang('home/editor', 'editor_font_you')?>';"><?=lang('home/editor', 'editor_font_you')?></a>
<a href="javascript:;" onClick="fontname(this)" class="n" style="font:normal 12px Arial;">Arial</a>
<a href="javascript:;" onClick="fontname(this)" class="n" style="font:normal 12px 'Arial Narrow';">Arial Narrow</a>
<a href="javascript:;" onClick="fontname(this)" class="n" style="font:normal 12px 'Arial Black';">Arial Black</a>
<a href="javascript:;" onClick="fontname(this)" class="n" style="font:normal 12px 'Comic Sans MS';">Comic Sans MS</a>
<a href="javascript:;" onClick="fontname(this)" class="n" style="font:normal 12px Courier;">Courier</a>
<a href="javascript:;" onClick="fontname(this)" class="n" style="font:normal 12px System;">System</a>
<a href="javascript:;" onClick="fontname(this)" class="n" style="font:normal 12px 'Times New Roman';">Times New Roman</a>
<a href="javascript:;" onClick="fontname(this)" class="n" style="font:normal 12px Verdana;">Verdana</a>
</div>
<div id="fontsize" class="eMenu" style="display:none;top:35px;left:26px;width:125px;height:120px">
<a href="javascript:;" onClick="fontsize(1,this)" class="n" style="font-size:xx-small;line-height:120%;"><?=lang('home/editor', 'editor_fontsize_xxsmall')?></a>
<a href="javascript:;" onClick="fontsize(2,this)" class="n" style="font-size:x-small;line-height:120%;"><?=lang('home/editor', 'editor_fontsize_xsmall')?></a>
<a href="javascript:;" onClick="fontsize(3,this)" class="n" style="font-size:small;line-height:120%;"><?=lang('home/editor', 'editor_fontsize_small')?></a>
<a href="javascript:;" onClick="fontsize(4,this)" class="n" style="font-size:medium;line-height:120%;"><?=lang('home/editor', 'editor_fontsize_medium')?></a>
<a href="javascript:;" onClick="fontsize(5,this)" class="n" style="font-size:large;line-height:120%;"><?=lang('home/editor', 'editor_fontsize_large')?></a>
</div>

<div id="divList" class="eMenu" style="display:none;top:35px;left:26px;width:64px;height:40px;"><a href="javascript:;" onClick="format('Insertorderedlist');fHide(this.parentNode)" class="n"><?=lang('home/editor', 'editor_list_order')?></a><a href="javascript:;" onClick="format('Insertunorderedlist');fHide(this.parentNode)" class="n"><?=lang('home/editor', 'editor_list_unorder')?></a></div>
<div id="divAlign" class="eMenu" style="display:none;top:35px;left:26px;width:64px;height:60px;"><a href="javascript:;" onClick="format('Justifyleft');fHide(this.parentNode)" class="n"><?=lang('home/editor', 'editor_align_left')?></a><a href="javascript:;" onClick="format('Justifycenter');fHide(this.parentNode)" class="n"><?=lang('home/editor', 'editor_align_center')?></a><a href="javascript:;" onClick="format('Justifyright');fHide(this.parentNode)" class="n"><?=lang('home/editor', 'editor_align_right')?></a></div>
<div id="divInOut" class="eMenu" style="display:none;top:35px;left:26px;width:64px;height:40px;"><a href="javascript:;" onClick="format('Indent');fHide(this.parentNode)" class="n"><?=lang('home/editor', 'editor_indent_inc')?></a><a href="javascript:;" onClick="format('Outdent');fHide(this.parentNode)" class="n"><?=lang('home/editor', 'editor_indent_dec')?></a></div>

<div id="dvForeColor" class="eMenu" style="display:none;top:35px;left:26px;width:90px;">
<a href="javascript:;" onClick="format(gSetColorType,'#800000')" class="n cs fRd1"><b class="cb"></b><span><?=lang('home/editor', 'editor_color_darkred')?></span></a>
<a href="javascript:;" onClick="format(gSetColorType,'#800080')" class="n cs fRd2"><b class="cb"></b><span><?=lang('home/editor', 'editor_color_purple')?></span></a>
<a href="javascript:;" onClick="format(gSetColorType,'#F00000')" class="n cs fRd3"><b class="cb"></b><span><?=lang('home/editor', 'editor_color_red')?></span></a>
<a href="javascript:;" onClick="format(gSetColorType,'#F000F0')" class="n cs fRd4"><b class="cb"></b><span><?=lang('home/editor', 'editor_color_pink')?></span></a>
<a href="javascript:;" onClick="format(gSetColorType,'#000080')" class="n cs fBu1"><b class="cb"></b><span><?=lang('home/editor', 'editor_color_darkblue')?></span></a>
<a href="javascript:;" onClick="format(gSetColorType,'#0000F0')" class="n cs fBu2"><b class="cb"></b><span><?=lang('home/editor', 'editor_color_blue')?></span></a>
<a href="javascript:;" onClick="format(gSetColorType,'#00F0F0')" class="n cs fBu3"><b class="cb"></b><span><?=lang('home/editor', 'editor_color_lakeblue')?></span></a>
<a href="javascript:;" onClick="format(gSetColorType,'#008080')" class="n cs fGn1"><b class="cb"></b><span><?=lang('home/editor', 'editor_color_greenblue')?></span></a>
<a href="javascript:;" onClick="format(gSetColorType,'#008000')" class="n cs fGn2"><b class="cb"></b><span><?=lang('home/editor', 'editor_color_green')?></span></a>
<a href="javascript:;" onClick="format(gSetColorType,'#808000')" class="n cs fGn3"><b class="cb"></b><span><?=lang('home/editor', 'editor_color_olives')?></span></a>
<a href="javascript:;" onClick="format(gSetColorType,'#00F000')" class="n cs fGn4"><b class="cb"></b><span><?=lang('home/editor', 'editor_color_lightgreen')?></span></a>
<a href="javascript:;" onClick="format(gSetColorType,'#F0C000')" class="n cs fYl1"><b class="cb"></b><span><?=lang('home/editor', 'editor_color_orange')?></span></a>
<a href="javascript:;" onClick="format(gSetColorType,'#000000')" class="n cs fBk1"><b class="cb"></b><span><?=lang('home/editor', 'editor_color_black')?></span></a>
<a href="javascript:;" onClick="format(gSetColorType,'#808080')" class="n cs fBk2"><b class="cb"></b><span><?=lang('home/editor', 'editor_color_grey')?></span></a>
<a href="javascript:;" onClick="format(gSetColorType,'#C0C0C0')" class="n cs fBk3"><b class="cb"></b><span><?=lang('home/editor', 'editor_color_silver')?></span></a>
<a href="javascript:;" onClick="format(gSetColorType,'#FFFFFF')" class="n cs fWt0"><b class="cb"></b><span><?=lang('home/editor', 'editor_color_white')?></span></a>
</div>

<div id="editFaceBox" class="eMenu" style="display:none;top:35px;left:26px;width:165px;"></div>

<div id="createUrl" class="eMenu" style="display:none;top:35px;left:26px;width:300px;font-size:12px">
	<?=lang('home/editor', 'editor_prompt_textlink')?>:<br/>
	<input type="text" id="insertUrl" name="url" value="http://" onfocus="checkURL(this, 1);" onblur="checkURL(this, 0);" class="t_input" style="width: 190px;"> <input type="button" onclick="createLink();" name="createURL" value="<?=lang('home/editor', 'editor_ok')?>" class="submit" /> <a href="javascript:;" onclick="fHide($('createUrl'));"><?=lang('home/editor', 'editor_cancel')?></a>
</div>
<div id="createImg" class="eMenu" style="display:none;top:35px;left:26px;width:300px;font-size:12px">
	<?=lang('home/editor', 'editor_prompt_imagelink')?>:<br/>
	<input type="text" id="imgUrl" name="imgUrl" value="http://" onfocus="checkURL(this, 1);" onblur="checkURL(this, 0);" class="t_input" style="width: 190px;" /> <input type="button" onclick="createImg();" name="createURL" value="<?=lang('home/editor', 'editor_ok')?>" class="submit" /> <a href="javascript:;" onclick="fHide($('createImg'));"><?=lang('home/editor', 'editor_cancel')?></a>
</div>
<div id="createSwf" class="eMenu" style="display:none;top:35px;left:26px;width:400px;font-size:12px">
	<?=lang('home/editor', 'editor_prompt_videolink')?>:<br/>
	<select name="vtype" id="vtype">
		<option value="0"><?=lang('home/editor', 'editor_prompt_video_flash')?></option>
		<option value="1"><?=lang('home/editor', 'editor_prompt_video_media')?></option>
		<option value="2"><?=lang('home/editor', 'editor_prompt_video_real')?></option>
	</select>
	<input type="text" id="videoUrl" name="videoUrl" value="http://" onfocus="checkURL(this, 1);" onblur="checkURL(this, 0);" class="t_input" style="width: 200px;" />
	<input type="button" onclick="createFlash();" name="createURL" value="<?=lang('home/editor', 'editor_ok')?>" class="submit" />
	<a href="javascript:;" onclick="fHide($('createSwf'));"><?=lang('home/editor', 'editor_cancel')?></a>
</div>

</td></tr>
<tr><td>
<table cellpadding="0" cellspacing="0" style="height:100%;width:100%;overflow:hidden">
<tr>
<td>
<SCRIPT LANGUAGE="JavaScript">
	function blank_load() {
		var inihtml = '';
		var obj = parent.document.getElementById('uchome-ttHtmlEditor');
		if(obj) {
			inihtml = obj.value;
		}
		if(! inihtml && !window.Event) {
			inihtml = '<div></div>';
		}
		window.frames['HtmlEditor'].document.body.innerHTML = inihtml;
	}
	if(document.all){
		document.write('<table width="100%" height="369" border="0" cellspacing="0" cellpadding="0" id="divEditor"><tr><td style="padding-left:4px;background-color:#fff"><IFRAME class="HtmlEditor" ID="HtmlEditor" name="HtmlEditor" style="height:100%;width:100%" frameBorder="0" marginHeight=0 marginWidth=0 src="home.php?mod=editor&op=blank&charset=<?php echo $_GET['charset'];?>" onload="blank_load();"></IFRAME></td></tr></table>');
	}else{
		document.write('<table width="100%" height="369" border="0" cellspacing="0" cellpadding="0" id="divEditor"><tr><td style="padding-left:4px;background-color:#fff"><IFRAME class="HtmlEditor" ID="HtmlEditor" name="HtmlEditor" style="height:100%;width:100%;" frameBorder="0" marginHeight=0 marginWidth=0 src="home.php?mod=editor&op=blank&charset=<?php echo $_GET['charset'];?>" onload="blank_load();"></IFRAME></td></tr></table>');
	}
</SCRIPT>
<textarea id="sourceEditor" style="overflow-y:auto;padding-left:4px;width:100%;height:369px;word-wrap:break-word;display:none;border:0;"></textarea>
</td>
</tr>
</table>
</td>
</tr>
</table>
</div>
<input type="hidden" name="uchome-editstatus" id="uchome-editstatus" value="html">
</body>
</html>
<?php

} else {


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html;charset=<?=$_GET['charset']?>" />
<title>New Document</title>
<style>
body { margin: 0; padding: 0; word-wrap: break-word; font-size:14px; line-height:1.8em; font-family: Tahoma, Arial, Helvetica, snas-serif; }
</style>
<meta content="mshtml 6.00.2900.3132" name=generator>
</head>
<body>
</body>
</html>
<?}?>