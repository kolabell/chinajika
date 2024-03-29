<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: function_forumsort.php 7183 2010-03-30 07:58:28Z tiger $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function gettypetemplate($option, $optionvalue) {
	global $_G;

	if(in_array($option['type'], array('number', 'text', 'email', 'calendar', 'image', 'url', 'range', 'upload', 'range'))) {
		if($option['type'] == 'calendar') {
			$showoption[$option['identifier']]['value'] = '<script type="text/javascript" src="'.$_G['setting']['jspath'].'calendar.js?'.VERHASH.'"></script><input type="text" name="typeoption['.$option['identifier'].']" tabindex="1" id="typeoption_'.$option['identifier'].'" style="width:'.$option['inputsize'].'px;" onBlur="checkoption(\''.$option['identifier'].'\', \''.$option['required'].'\', \''.$option['type'].'\')" value="'.$optionvalue['value'].'" onclick="showcalendar(event, this, false)" '.$optionvalue['unchangeable'].' class="px"/>';
		} elseif($option['type'] == 'image') {
			$showoption[$option['identifier']]['value'] = '<button type="button" class="pn" onclick="uploadWindow(function (aid, url){updatesortattach(aid, url, \''.$_G['setting']['attachurl'].'forum\', \''.$option['identifier'].'\')})"><span>'.($optionvalue['value'] ? lang('forum/misc', 'sort_update') : lang('forum/misc', 'sort_upload')).'</span></button>
				<input type="hidden" name="typeoption['.$option['identifier'].'][aid]" id="sortaid_'.$option['identifier'].'" value="'.$optionvalue['value']['aid'].'" tabindex="1" />'.
				($optionvalue['value']['aid'] ? '<input type="hidden" name="oldsortaid['.$option['identifier'].']" value="'.$optionvalue['value']['aid'].'" tabindex="1" />' : '').
				'<input type="hidden" name="typeoption['.$option['identifier'].'][url]" id="sortattachurl_'.$option['identifier'].'" '.($optionvalue['value']['url'] ? 'value="'.$optionvalue['value']['url'].'"' : '').'tabindex="1" />
				<div id="sortattach_image_'.$option['identifier'].'" class="ptn">';

			if($optionvalue['value']['url']) {
				$showoption[$option['identifier']]['value'] .= '<a href="'.$optionvalue['value']['url'].'" target="_blank"><img class="spimg" src="'.$optionvalue['value']['url'].'" alt="" /></a>';
			}

			$showoption[$option['identifier']]['value'] .= '</div>';

		} else {
			$showoption[$option['identifier']]['value'] = '<input type="text" name="typeoption['.$option['identifier'].']" tabindex="1" id="typeoption_'.$option['identifier'].'" style="width:'.$option['inputsize'].'px;" onBlur="checkoption(\''.$option['identifier'].'\', \''.$option['required'].'\', \''.$option['type'].'\', \''.intval($option['maxnum']).'\', \''.intval($option['minnum']).'\', \''.intval($option['maxlength']).'\')" value="'.$optionvalue['value'].'" '.$optionvalue['unchangeable'].' class="px"/>';
		}
	} elseif(in_array($option['type'], array('radio', 'checkbox', 'select'))) {
		if($option['type'] == 'select') {
			$showoption[$option['identifier']]['value'] = '<span class="ftid"><select name="typeoption['.$option['identifier'].']" id="typeoption_'.$option['identifier'].'" tabindex="1" '.$optionvalue['unchangeable'].' class="ps">';
			foreach($option['choices'] as $id => $value) {
				$showoption[$option['identifier']]['value'] .= '<option value="'.$id.'" '.$optionvalue['value'][$id].'>'.$value.'</option>';
			}
			$showoption[$option['identifier']]['value'] .= '</select></span>';
		} elseif($option['type'] == 'radio') {
			foreach($option['choices'] as $id => $value) {
				$showoption[$option['identifier']]['value'] .= '<span class="fb"><input type="radio" class="pr" name="typeoption['.$option['identifier'].']" tabindex="1" id="typeoption_'.$option['identifier'].'" onclick="checkoption(\''.$option['identifier'].'\', \''.$option['required'].'\', \''.$option['type'].'\')" value="'.$id.'" '.$optionvalue['value'][$id].' '.$optionvalue['unchangeable'].' class="pr">'.$value.'</span>';
			}
		} elseif($option['type'] == 'checkbox') {
			foreach($option['choices'] as $id => $value) {
				$showoption[$option['identifier']]['value'] .= '<span class="fb"><input type="checkbox" class="pc" name="typeoption['.$option['identifier'].'][]" tabindex="1" id="typeoption_'.$option['identifier'].'" onclick="checkoption(\''.$option['identifier'].'\', \''.$option['required'].'\', \''.$option['type'].'\')" value="'.$id.'" '.$optionvalue['value'][$id][$id].' '.$optionvalue['unchangeable'].' class="pc">'.$value.'</span>';
			}
		}
	} elseif(in_array($option['type'], array('textarea'))) {
		$showoption[$option['identifier']]['value'] = '<span><textarea name="typeoption['.$option['identifier'].']" tabindex="1" id="typeoption_'.$option['identifier'].'" rows="'.$option['rowsize'].'" cols="'.$option['colsize'].'" onBlur="checkoption(\''.$option['identifier'].'\', \''.$option['required'].'\', \''.$option['type'].'\', 0, 0{if $option[maxlength]}, \'$option[maxlength]\'{/if})" '.$optionvalue['unchangeable'].' class="pt">'.$optionvalue['value'].'</textarea><span>';
	}

	return $showoption;

}

function quicksearch($sortoptionarray) {
	global $_G;

	$quicksearch = array();
	if($sortoptionarray) {
		foreach($sortoptionarray as $optionid => $option) {
			if($option['search']) {
				$quicksearch[$optionid]['title'] = $option['title'];
				$quicksearch[$optionid]['identifier'] = $option['identifier'];
				$quicksearch[$optionid]['unit'] = $option['unit'];
				$quicksearch[$optionid]['type'] = $option['type'];
				if(in_array($option['type'], array('radio', 'select', 'checkbox'))) {
					$quicksearch[$optionid]['choices'] = $option['choices'];
				} elseif(!empty($option['searchtxt'])) {
					$choices = array();
					$prevs = 'd';
					foreach($option['searchtxt'] as $choice) {
						$value = "$prevs|$choice";
						if($choice) {
							$quicksearch[$optionid]['choices'][$value] = $prevs == 'd' ? lang('forum/misc', 'lower').$choice.$option['unit'] : $prevs.'-'.$choice.$option['unit'];
							$prevs = $choice;
						}
						$max = $choice;
					}
					$value = "u|$choice";
					$quicksearch[$optionid]['choices'][$value] .= lang('forum/misc', 'higher').$max.$option['unit'];
				}
			}
		}
	}

	return $quicksearch;
}

function sortsearch($sortid, $sortoptionarray, $searchoption = array(), $selecturladd = array(), $sortfid = 0) {

	$sortid = intval($sortid);
	$selectsql = '';
	$optionide = $searchsorttids = array();

	if($selecturladd) {
		foreach($sortoptionarray[$sortid] as $optionid => $option) {
			if(in_array($option['type'], array('checkbox', 'radio', 'select', 'range'))) {
				$optionide[$option['identifier']] = $option['type'];
			}
		}

		foreach($selecturladd as $fieldname => $value) {
			if($optionide[$fieldname] && $value != 'all') {
				if($optionide[$fieldname] == 'range') {
					$value = explode('|', $value);
					if($value[0] == 'd') {
						$sql = "$fieldname<'$value[1]'";
					} elseif($value[0] == 'u') {
						$sql = "$fieldname>'$value[1]'";
					} else {
						$sql = "($fieldname BETWEEN ".intval($value[0])." AND ".intval($value[1]).")";
					}
				} elseif($optionide[$fieldname] == 'checkbox') {
					$sql = "$fieldname LIKE '%".$value."%'";
				} else {
					$sql = "$fieldname='$value'";
				}
				$selectsql .= "AND $sql ";
			}
		}
	}

	if(!empty($searchoption) && is_array($searchoption)) {
		foreach($searchoption as $optionid => $option) {
			$fieldname = $sortoptionarray[$sortid][$optionid]['identifier'] ? $sortoptionarray[$sortid][$optionid]['identifier'] : 1;
			if($option['value']) {
				if(in_array($option['type'], array('number', 'radio', 'select'))) {
					$option['value'] = intval($option['value']);
					$exp = '=';
					if($option['condition']) {
						$exp = $option['condition'] == 1 ? '>' : '<';
					}
					$sql = "$fieldname$exp'$option[value]'";
				} elseif($option['type'] == 'checkbox') {
					$sql = "$fieldname LIKE '%".(implode("%", $option['value']))."%'";
				} elseif($option['type'] == 'range') {
					$value = explode('|', $option['value']);
					if($value[0] == 'd') {
						$sql = "$fieldname<'$value[1]'";
					} elseif($value[0] == 'u') {
						$sql = "$fieldname>'$value[1]'";
					} else {
						$sql = $value[0] || $value[1] ? "($fieldname BETWEEN ".intval($value[0])." AND ".intval($value[1]).")" : '';
					}
				} else {
					$sql = "$fieldname LIKE '%$option[value]%'";
				}
				$selectsql .= "AND $sql ";
			}
		}
	}

	$query = DB::query("SELECT tid FROM ".DB::table('forum_optionvalue')."$sortid WHERE 1 $selectsql ".($sortfid ? "AND fid='$sortfid'" : '')."");
	while($thread = DB::fetch($query)) {
		$searchsorttids[] = $thread['tid'];
	}

	return $searchsorttids;

}

function showsorttemplate($sortid, $fid, $sortoptionarray, $templatearray, $threadlist, $threadids = array()) {
	global $_G;

	$searchtitle = $searchvalue = $searchunit = $stemplate = $searchtids = $sortlistarray = $skipaids = $sortdata = array();

	$addsortid = !empty($sortid) ? "sortid='$sortid' AND" : '';
	$addthreadid = !empty($threadids) ? "AND tid IN (".dimplode($threadids).")" : '';
	$query = DB::query("SELECT sortid, tid, optionid, value, expiration FROM ".DB::table('forum_typeoptionvar')." WHERE $addsortid fid='$fid' $addthreadid");
	while($sortthread = DB::fetch($query)) {
		$optionid = $sortthread['optionid'];
		$sortid = $sortthread['sortid'];
		$tid = $sortthread['tid'];
		$arrayoption = $sortoptionarray[$sortid][$optionid];
		if($sortoptionarray[$sortid][$optionid]['subjectshow']) {
			$_G['optionvaluelist'][$sortid][$tid][$arrayoption['identifier']]['title'] = $arrayoption['title'];
			$_G['optionvaluelist'][$sortid][$tid][$arrayoption['identifier']]['unit'] = $arrayoption['unit'];
			if(in_array($arrayoption['type'], array('radio', 'checkbox', 'select'))) {
				if($arrayoption['type'] == 'checkbox') {
					foreach(explode("\t", $sortthread['value']) as $choiceid) {
						$sortthreadlist[$tid][$arrayoption['title']] .= $arrayoption['choices'][$choiceid].'&nbsp;';
						$_G['optionvaluelist'][$sortid][$tid][$arrayoption['identifier']]['value'] .= $arrayoption['choices'][$choiceid].'&nbsp;';
					}
				} else {
					$sortthreadlist[$tid][$arrayoption['title']] = $_G['optionvaluelist'][$sortid][$tid][$arrayoption['identifier']]['value'] = $arrayoption['choices'][$sortthread['value']];
				}
			} elseif($arrayoption['type'] == 'image') {
				$imgoptiondata = unserialize($sortthread['value']);
				if(empty($templatearray[$sortid])) {
					$maxwidth = $arrayoption['maxwidth'] ? 'width="'.$arrayoption['maxwidth'].'"' : '';
					$maxheight = $arrayoption['maxheight'] ? 'height="'.$arrayoption['maxheight'].'"' : '';
					$sortthreadlist[$tid][$arrayoption['title']] = $_G['optionvaluelist'][$sortid][$tid][$arrayoption['identifier']]['value'] = $imgoptiondata['url'] ? "<img src=\"$imgoptiondata[url]\" onload=\"thumbImg(this)\" $maxwidth $maxheight border=\"0\">" : '';
				} else {
					$sortthread['value'] = '';
					if($imgoptiondata['aid']) {
						$sortthread['value'] = getforumimg($imgoptiondata['aid'], 0, 120, 120);
					} elseif($imgoptiondata['url']) {
						$sortthread['value'] = $imgoptiondata['url'];
					}
					$sortthreadlist[$tid][$arrayoption['title']] = $_G['optionvaluelist'][$sortid][$tid][$arrayoption['identifier']]['value'] = $sortthread['value'] ? $sortthread['value'] : './static/image/common/nophotosmall.gif';
				}
			} else {
				$sortthreadlist[$tid][$arrayoption['title']] = $_G['optionvaluelist'][$sortid][$tid][$arrayoption['identifier']]['value'] = $sortthread['value'] ? $sortthread['value'] : $arrayoption['defaultvalue'];
			}
			$sortthreadlist[$tid]['sortid'] = $sortid;
			$sortthreadlist[$tid]['expiration'] = $sortthread['expiration'] && $sortthread['expiration'] <= TIMESTAMP ? 1 : 0;
		}
	}

	if($templatearray && $sortthreadlist) {
		foreach($threadlist as $thread) {
			$thread['digest'] = $thread['digest'] ? '&nbsp;<img src="'.$_G['style']['imgdir'].'/digest_'.$thread['digest'].'.gif" class="vm" alt="" title="" />' : '';
			$sortdata[$thread['tid']]['subject'] = '<a href="forum.php?mod=viewthread&tid='.$thread['tid'].'" '.$thread['highlight'].'>'.$thread['subject'].'</a>'.$thread['digest'];
			$sortdata[$thread['tid']]['author'] = '<a href="home.php?mod=space&uid='.$thread['authorid'].'" target="_blank">'.$thread['author'].'</a>';
		}

		foreach($sortoptionarray as $sortid => $optionarray) {
			foreach($optionarray as $option) {
				if($option['subjectshow']) {
					$searchtitle[$sortid][] = '/{('.$option['identifier'].')}/e';
					$searchvalue[$sortid][] = '/\[('.$option['identifier'].')value\]/e';
					$searchunit[$sortid][] = '/\[('.$option['identifier'].')unit\]/e';
				}
			}
		}

		foreach($sortthreadlist as $tid => $option) {
			$sortid = $option['sortid'];
			$sortexpiration[$sortid][$tid] = $option['expiration'];
			$stemplate[$sortid][$tid] = preg_replace(
							array("/\{sortname\}/i", "/\{author\}/i", "/\{subject\}/i", "/\[url\](.+?)\[\/url\]/i"),
							array(
								'<a href="forum.php?mod=forumdisplay&fid='.$_G['fid'].'&filter=sortid&sortid='.$sortid.'">'.$_G['forum']['threadsorts']['types'][$sortid].'</a>',
								$sortdata[$tid]['author'],
								$sortdata[$tid]['subject'],
								"<a href=\"forum.php?mod=viewthread&tid=$tid\">\\1</a>"
							), stripslashes($templatearray[$sortid]));
			$stemplate[$sortid][$tid] = preg_replace($searchtitle[$sortid], "showlistoption('\\1', 'title', '$tid', '$sortid')", $stemplate[$sortid][$tid]);
			$stemplate[$sortid][$tid] = preg_replace($searchvalue[$sortid], "showlistoption('\\1', 'value', '$tid', '$sortid')", $stemplate[$sortid][$tid]);
			$stemplate[$sortid][$tid] = preg_replace($searchunit[$sortid], "showlistoption('\\1', 'unit', '$tid', '$sortid')", $stemplate[$sortid][$tid]);
		}
	}

	$sortlistarray['template'] = $stemplate;
	$sortlistarray['expiration'] = $sortexpiration;

	return $sortlistarray;
}

function showlistoption($var, $type, $tid, $sortid) {
	global $_G;
	if($_G['optionvaluelist'][$sortid][$tid][$var][$type]) {
		return $_G['optionvaluelist'][$sortid][$tid][$var][$type];
	} else {
		return '';
	}
}

function threadsortshow($sortid, $tid) {
	global $_G;

	loadcache(array('threadsort_option_'.$sortid, 'threadsort_template_'.$sortid));
	$sortoptionarray = $_G['cache']['threadsort_option_'.$sortid];
	$templatearray = $_G['cache']['threadsort_template_'.$sortid];
	$threadsortshow = $optiondata = $searchtitle = $searchvalue = $searchunit = $memberinfofield = $_G['forum_option'] = array();
	if($sortoptionarray) {

		$query = DB::query("SELECT optionid, value, expiration FROM ".DB::table('forum_typeoptionvar')." WHERE tid='$tid'");
		while($option = DB::fetch($query)) {
			$optiondata[$option['optionid']]['value'] = $option['value'];
			$optiondata[$option['optionid']]['expiration'] = $option['expiration'] && $option['expiration'] <= TIMESTAMP ? 1 : 0;
			$sortdataexpiration = $option['expiration'];
		}

		foreach($sortoptionarray as $optionid => $option) {
			$_G['forum_option'][$option['identifier']]['title'] = $option['title'];
			$_G['forum_option'][$option['identifier']]['unit'] = $option['unit'];
			$_G['forum_option'][$option['identifier']]['type'] = $option['type'];

			if(($option['expiration'] && !$optiondata[$optionid]['expiration']) || empty($option['expiration'])) {
				if(($option['protect']['usergroup'] && strstr("\t".$option['protect']['usergroup']."\t", "\t$_G[groupid]\t")) || empty($option['protect']['usergroup']) || $_G['forum_thread']['authorid'] == $_G['uid']) {
					if($option['type'] == 'checkbox') {
						$_G['forum_option'][$option['identifier']]['value'] = '';
						foreach(explode("\t", $optiondata[$optionid]['value']) as $choiceid) {
							$_G['forum_option'][$option['identifier']]['value'] .= $option['choices'][$choiceid].'&nbsp;';
						}
					} elseif(in_array($option['type'], array('radio', 'select'))) {
						$_G['forum_option'][$option['identifier']]['value'] = $option['choices'][$optiondata[$optionid]['value']];
					} elseif($option['type'] == 'image') {
						$imgoptiondata = unserialize($optiondata[$optionid]['value']);
						$threadsortshow['sortaids'][] = $imgoptiondata['aid'];
						if(empty($templatearray['viewthread'])) {
							$maxwidth = $option['maxwidth'] ? 'width="'.$option['maxwidth'].'"' : '';
							$maxheight = $option['maxheight'] ? 'height="'.$option['maxheight'].'"' : '';
							$_G['forum_option'][$option['identifier']]['value'] = $imgoptiondata['url'] ? "<img src=\"".$imgoptiondata['url']."\" onload=\"thumbImg(this)\" $maxwidth $maxheight border=\"0\">" : '';
						} else {
							$_G['forum_option'][$option['identifier']]['value'] = $imgoptiondata['url'] ? $imgoptiondata['url'] : './static/image/common/nophoto.gif';
						}
					} elseif($option['type'] == 'url') {
						$_G['forum_option'][$option['identifier']]['value'] = $optiondata[$optionid]['value'] ? "<a href=\"".$optiondata[$optionid]['value']."\" target=\"_blank\">".$optiondata[$optionid]['value']."</a>" : '';
					} elseif($option['type'] == 'textarea') {
						$_G['forum_option'][$option['identifier']]['value'] = $optiondata[$optionid]['value'] ? nl2br($optiondata[$optionid]['value']) : '';
					} else {
						if($option['protect']['status'] && $optiondata[$optionid]['value']) {
							$optiondata[$optionid]['value'] = $option['protect']['mode'] == 1 ? '<image src="forum.php?mod=misc&action=protectsort&tid='.$tid.'&sortvalue='.$optiondata[$optionid]['value'].'">' : '<span id="sortmessage_'.$option['identifier'].'"><a href="###" onclick="ajaxget(\'forum.php?mod=misc&action=protectsort&tid='.$tid.'&optionid='.$optionid.'\', \'sortmessage_'.$option['identifier'].'\');return false;">'.lang('forum/misc', 'click_view').'</a></span>';
						}

						$_G['forum_option'][$option['identifier']]['value'] = $optiondata[$optionid]['value'] ? $optiondata[$optionid]['value'] : $option['defaultvalue'];
					}
				} else {
					$_G['forum_option'][$option['identifier']]['value'] = lang('forum/misc', 'view_noperm');
				}
			} else {
				$_G['forum_option'][$option['identifier']]['value'] = lang('forum/misc', 'has_expired');
			}
		}

		$typetemplate = '';
		if($templatearray['viewthread']) {
			foreach($sortoptionarray as $option) {
				$searchtitle[] = '/{('.$option['identifier'].')}/e';
				$searchvalue[] = '/\[('.$option['identifier'].')value\]/e';
				$searchunit[] = '/\[('.$option['identifier'].')unit\]/e';
			}

			$threadexpiration = $sortdataexpiration ? dgmdate($sortdataexpiration) : lang('forum/misc', 'never_expired');
			$typetemplate = preg_replace(array("/\{expiration\}/i"), array($threadexpiration), stripslashes($templatearray['viewthread']));
			$typetemplate = preg_replace($searchtitle, "showoption('\\1', 'title')", $typetemplate);
			$typetemplate = preg_replace($searchvalue, "showoption('\\1', 'value')", $typetemplate);
			$typetemplate = preg_replace($searchunit, "showoption('\\1', 'unit')", $typetemplate);
		}
	}

	$threadsortshow['optionlist'] = !$optionexpiration ? $_G['forum_option'] : 'expire';
	$threadsortshow['typetemplate'] = $typetemplate;
	$threadsortshow['expiration'] = dgmdate($sortdataexpiration, 'd');

	return $threadsortshow;
}

function showoption($var, $type) {
	global $_G;
	if($_G['forum_option'][$var][$type]) {
		return $_G['forum_option'][$var][$type];
	} else {
		return '';
	}
}

function threadsort_checkoption($sortid = 0, $unchangeable = 1) {
	global $_G;

	$_G['forum_selectsortid'] = $sortid ? intval($sortid) : '';
	loadcache(array('threadsort_option_'.$sortid));
	$_G['forum_optionlist'] = $_G['cache']['threadsort_option_'.$sortid];
	$_G['forum_checkoption'] = array();
	if(is_array($_G['forum_optionlist'])) {
		foreach($_G['forum_optionlist'] as $optionid => $option) {
			$_G['forum_checkoption'][$option['identifier']]['optionid'] = $optionid;
			$_G['forum_checkoption'][$option['identifier']]['title'] = $option['title'];
			$_G['forum_checkoption'][$option['identifier']]['type'] = $option['type'];
			$_G['forum_checkoption'][$option['identifier']]['required'] = $option['required'] ? 1 : 0;
			$_G['forum_checkoption'][$option['identifier']]['unchangeable'] = $_G['gp_action'] == 'edit' && $unchangeable && $option['unchangeable'] ? 1 : 0;
			$_G['forum_checkoption'][$option['identifier']]['maxnum'] = $option['maxnum'] ? intval($option['maxnum']) : '';
			$_G['forum_checkoption'][$option['identifier']]['minnum'] = $option['minnum'] ? intval($option['minnum']) : '';
			$_G['forum_checkoption'][$option['identifier']]['maxlength'] = $option['maxlength'] ? intval($option['maxlength']) : '';
		}
	}
}

function threadsort_optiondata($pid, $sortid, $sortoptionarray, $templatearray) {
	global $_G;
	$_G['forum_optiondata'] = $_G['forum_typetemplate'] = $_G['forum_option'] = $_G['forum_memberinfo'] = $searchcontent = array();
	$id = $_G['tid'];

	if($id) {
		$query = DB::query("SELECT optionid, value, expiration FROM ".DB::table('forum_typeoptionvar')." WHERE tid='$id'");
		while($option = DB::fetch($query)) {
			$_G['forum_optiondata'][$option['optionid']] = $option['value'];
			$_G['forum_optiondata']['expiration'] = $option['expiration'];
		}
	}

	$_G['forum_optiondata']['expiration'] = $_G['forum_optiondata']['expiration'] ? dgmdate($_G['forum_optiondata']['expiration'], 'd') : '';

	foreach($sortoptionarray as $optionid => $option) {
		if($id) {
			$_G['forum_optionlist'][$optionid]['unchangeable'] = $sortoptionarray[$optionid]['unchangeable'] ? 'readonly' : '';
			if($sortoptionarray[$optionid]['type'] == 'radio') {
				$_G['forum_optionlist'][$optionid]['value'] = array($_G['forum_optiondata'][$optionid] => 'checked="checked"');
			} elseif($sortoptionarray[$optionid]['type'] == 'select') {
				$_G['forum_optionlist'][$optionid]['value'] = array($_G['forum_optiondata'][$optionid] => 'selected="selected"');
			} elseif($sortoptionarray[$optionid]['type'] == 'checkbox') {
				foreach(explode("\t", $_G['forum_optiondata'][$optionid]) as $value) {
					$_G['forum_optionlist'][$optionid]['value'][$value] = array($value => 'checked="checked"');
				}
			} elseif($sortoptionarray[$optionid]['type'] == 'image') {
				$_G['forum_optionlist'][$optionid]['value'] = unserialize($_G['forum_optiondata'][$optionid]);
			} else {
				$_G['forum_optionlist'][$optionid]['value'] = $_G['forum_optiondata'][$optionid];
			}
			if(!isset($_G['forum_optiondata'][$optionid])) {
				DB::query("INSERT INTO ".DB::table('forum_typeoptionvar')." (sortid, tid, fid, optionid)
				VALUES ('$sortid', '$id', '$_G[fid]', '$optionid')");
			}
		}

		if($templatearray['post']) {
			$_G['forum_option'][$option['identifier']]['title'] = $option['title'];
			$_G['forum_option'][$option['identifier']]['unit'] = $option['unit'];
			$_G['forum_option'][$option['identifier']]['description'] = $option['description'];
			$_G['forum_option'][$option['identifier']]['required'] = $option['required'] ? '*' : '';
			$_G['forum_option'][$option['identifier']]['tips'] = '<span id="check'.$option['identifier'].'"></span>';

			$showoption = gettypetemplate($option, $_G['forum_optionlist'][$optionid]);
			$_G['forum_option'][$option['identifier']]['value'] = $showoption[$option['identifier']]['value'];

			$searchcontent['title'][] = '/{('.$option['identifier'].')}/e';
			$searchcontent['value'][] = '/\[('.$option['identifier'].')value\]/e';
			$searchcontent['unit'][] = '/\[('.$option['identifier'].')unit\]/e';
			$searchcontent['description'][] = '/\[('.$option['identifier'].')description\]/e';
			$searchcontent['required'][] = '/\[('.$option['identifier'].')required\]/e';
			$searchcontent['tips'][] = '/\[('.$option['identifier'].')tips\]/e';
		}
	}

	if($templatearray['post']) {
		$typetemplate = $templatearray['post'];
		foreach($searchcontent as $key => $content) {
			$typetemplate = preg_replace($searchcontent[$key], "showoption('\\1', '$key')", stripslashes($typetemplate));
		}

		$_G['forum_typetemplate'] = $typetemplate;
	}
}

function threadsort_validator($sortoption, $pid) {
	global $_G, $var;
	$postaction = $_G['tid'] && $pid ? "edit&tid=$_G[tid]&pid=$pid" : 'newthread';
	$_G['forum_optiondata'] = array();
	foreach($_G['forum_checkoption'] as $var => $option) {
		if($_G['forum_checkoption'][$var]['required'] && (!$sortoption[$var] && $_G['forum_checkoption'][$var]['type'] != 'number')) {
			showmessage('threadtype_required_invalid', "forum.php?mod=post&action=$postaction&fid=$_G[fid]&sortid=".$_G['forum_selectsortid'], array('typetitle' => $_G['forum_checkoption'][$var]['title']));
		} elseif($sortoption[$var] && ($_G['forum_checkoption'][$var]['type'] == 'number' && !is_numeric($sortoption[$var]) || $_G['forum_checkoption'][$var]['type'] == 'email' && !isemail($sortoption[$var]))){
			showmessage('threadtype_format_invalid', "forum.php?mod=post&action=$postaction&fid=$_G[fid]&sortid=".$_G['forum_selectsortid'], array('typetitle' => $_G['forum_checkoption'][$var]['title']));
		} elseif($sortoption[$var] && $_G['forum_checkoption'][$var]['maxlength'] && strlen($sortoption[$var]) > $_G['forum_checkoption'][$var]['maxlength']) {
			showmessage('threadtype_toolong_invalid', "forum.php?mod=post&action=$postaction&fid=$_G[fid]&sortid=".$_G['forum_selectsortid'], array('typetitle' => $_G['forum_checkoption'][$var]['title']));
		} elseif($sortoption[$var] && (($_G['forum_checkoption'][$var]['maxnum'] && $sortoption[$var] > $_G['forum_checkoption'][$var]['maxnum']) || ($_G['forum_checkoption'][$var]['minnum'] && $sortoption[$var] < $_G['forum_checkoption'][$var]['minnum']))) {
			showmessage('threadtype_num_invalid', "forum.php?mod=post&action=$postaction&fid=$_G[fid]&sortid=".$_G['forum_selectsortid'], array('typetitle' => $_G['forum_checkoption'][$var]['title']));
		} elseif($sortoption[$var] && $_G['forum_checkoption'][$var]['unchangeable'] && !($_G['tid'] && $pid)) {
			showmessage('threadtype_unchangeable_invalid', "forum.php?mod=post&action=$postaction&fid=$_G[fid]&sortid=".$_G['forum_selectsortid'], array('typetitle' => $_G['forum_checkoption'][$var]['title']));
		}
		if($_G['forum_checkoption'][$var]['type'] == 'checkbox') {
			$sortoption[$var] = $sortoption[$var] ? implode("\t", $sortoption[$var]) : '';
		} elseif($_G['forum_checkoption'][$var]['type'] == 'url') {
			$sortoption[$var] = $sortoption[$var] ? (substr(strtolower($sortoption[$var]), 0, 4) == 'www.' ? 'http://'.$sortoption[$var] : $sortoption[$var]) : '';
		}

		$sortoption[$var] = $_G['forum_checkoption'][$var]['type'] != 'image' ? dhtmlspecialchars(censor(trim($sortoption[$var]))) : addslashes(serialize($sortoption[$var]));
		$_G['forum_optiondata'][$_G['forum_checkoption'][$var]['optionid']] = $sortoption[$var];
	}

	return $_G['forum_optiondata'];
}

?>