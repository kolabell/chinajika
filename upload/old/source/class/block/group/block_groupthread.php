<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: block_groupthread.php 11780 2010-06-13 02:11:52Z xupeng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class block_groupthread {
	var $setting = array();
	function block_groupthread(){
		$this->setting = array(
			'tids' => array(
				'title' => 'groupthread_tids',
				'type' => 'text'
			),
			'fids'	=> array(
				'title' => 'groupthread_fids',
				'type' => 'text'
			),
			'gtids' => array(
				'title' => 'groupthread_gtids',
				'type' => 'mselect',
				'value' => array(
				),
			),
			'uids' => array(
				'title' => 'groupthread_uids',
				'type' => 'text'
			),
			'special' => array(
				'title' => 'groupthread_special',
				'type' => 'mcheckbox',
				'value' => array(
					array(1, 'groupthread_special_1'),
					array(2, 'groupthread_special_2'),
					array(3, 'groupthread_special_3'),
					array(4, 'groupthread_special_4'),
					array(5, 'groupthread_special_5'),
					array(0, 'groupthread_special_0'),
				),
				'default' => array('0')
			),
			'rewardstatus' => array(
				'title' => 'groupthread_special_reward',
				'type' => 'mradio',
				'value' => array(
					array(0, 'groupthread_special_reward_0'),
					array(1, 'groupthread_special_reward_1'),
					array(2, 'groupthread_special_reward_2')
				),
				'default' => 0,
			),
			'picrequired' => array(
				'title' => 'groupthread_picrequired',
				'type' => 'radio',
				'value' => '0'
			),
			'orderby' => array(
				'title' => 'groupthread_orderby',
				'type'=> 'mradio',
				'value' => array(
					array('lastpost', 'groupthread_orderby_lastpost'),
					array('dateline', 'groupthread_orderby_dateline'),
					array('replies', 'groupthread_orderby_replies'),
					array('views', 'groupthread_orderby_views'),
					array('heats', 'groupthread_orderby_heats'),
					array('recommends', 'groupthread_orderby_recommends'),
				),
				'default' => 'lastpost'
			),
			'lastpost' => array(
				'title' => 'groupthread_lastpost',
				'type'=> 'mradio',
				'value' => array(
					array('0', 'groupthread_lastpost_nolimit'),
					array('3600', 'groupthread_lastpost_hour'),
					array('86400', 'groupthread_lastpost_day'),
					array('604800', 'groupthread_lastpost_week'),
					array('2592000', 'groupthread_lastpost_month'),
				),
				'default' => '0'
			),
			'gviewperm' => array(
				'title' => 'groupthread_gviewperm',
				'type' => 'mradio',
				'value' => array(
					array('-1', 'groupthread_gviewperm_nolimit'),
					array('0', 'groupthread_gviewperm_only_member'),
					array('1', 'groupthread_gviewperm_all_member')
				),
				'default' => '-1'
			),
			'titlelength' => array(
				'title' => 'groupthread_titlelength',
				'type' => 'text',
				'default' => 40
			),
			'summarylength' => array(
				'title' => 'groupthread_summarylength',
				'type' => 'text',
				'default' => 80
			),
			'startrow' => array(
				'title' => 'groupthread_startrow',
				'type' => 'text',
				'default' => 0
			),
		);
	}

	function name() {
		return lang('blockclass', 'blockclass_groupthread_script_groupthread');
	}

	function blockclass() {
		return array('thread', lang('blockclass', 'blockclass_group_thread'));
	}

	function fields() {
		return array(
				'url' => array('name' => lang('blockclass', 'blockclass_groupthread_field_url'), 'formtype' => 'text', 'datatype' => 'string'),
				'title' => array('name' => lang('blockclass', 'blockclass_groupthread_field_title'), 'formtype' => 'title', 'datatype' => 'title'),
				'pic' => array('name' => lang('blockclass', 'blockclass_groupthread_field_pic'), 'formtype' => 'pic', 'datatype' => 'pic'),
				'summary' => array('name' => lang('blockclass', 'blockclass_groupthread_field_summary'), 'formtype' => 'summary', 'datatype' => 'summary'),
				'author' => array('name' => lang('blockclass', 'blockclass_groupthread_field_author'), 'formtype' => 'text', 'datatype' => 'string'),
				'authorid' => array('name' => lang('blockclass', 'blockclass_groupthread_field_authorid'), 'formtype' => 'text', 'datatype' => 'int'),
				'avatar' => array('name' => lang('blockclass', 'blockclass_groupthread_field_avatar'), 'formtype' => 'text', 'datatype' => 'string'),
				'avatar_middle' => array('name' => lang('blockclass', 'blockclass_groupthread_field_avatar_middle'), 'formtype' => 'text', 'datatype' => 'string'),
				'avatar_big' => array('name' => lang('blockclass', 'blockclass_groupthread_field_avatar_big'), 'formtype' => 'text', 'datatype' => 'string'),
				'posts' => array('name' => lang('blockclass', 'blockclass_groupthread_field_posts'), 'formtype' => 'text', 'datatype' => 'int'),
				'todayposts' => array('name' => lang('blockclass', 'blockclass_groupthread_field_todayposts'), 'formtype' => 'text', 'datatype' => 'int'),
				'lastpost' => array('name' => lang('blockclass', 'blockclass_groupthread_field_lastpost'), 'formtype' => 'date', 'datatype' => 'date'),
				'dateline' => array('name' => lang('blockclass', 'blockclass_groupthread_field_dateline'), 'formtype' => 'date', 'datatype' => 'date'),
				'replies' => array('name' => lang('blockclass', 'blockclass_groupthread_field_replies'), 'formtype' => 'text', 'datatype' => 'int'),
				'views' => array('name' => lang('blockclass', 'blockclass_groupthread_field_views'), 'formtype' => 'text', 'datatype' => 'int'),
				'heats' => array('name' => lang('blockclass', 'blockclass_groupthread_field_heats'), 'formtype' => 'text', 'datatype' => 'int'),
				'recommends' => array('name' => lang('blockclass', 'blockclass_groupthread_field_recommends'), 'formtype' => 'text', 'datatype' => 'int'),
				'groupname' => array('name' => lang('blockclass', 'blockclass_groupthread_field_groupname'), 'formtype' => 'text', 'datatype' => 'string'),
				'groupurl' => array('name' => lang('blockclass', 'blockclass_groupthread_field_groupurl'), 'formtype' => 'text', 'datatype' => 'string'),
			);
	}

	function fieldsconvert() {
		return array(
				'portal_article' => array(
					'name' => lang('blockclass', 'blockclass_portal_article'),
					'script' => 'article',
					'searchkeys' => array('author', 'authorid', 'groupurl', 'groupname', 'posts', 'views', 'replies'),
					'replacekeys' => array('username', 'uid', 'caturl', 'catname', 'articles', 'viewnum', 'commentnum'),
				),
				'space_blog' => array(
					'name' => lang('blockclass', 'blockclass_space_blog'),
					'script' => 'blog',
					'searchkeys' => array('author', 'authorid', 'views', 'replies'),
					'replacekeys' => array('username', 'uid', 'viewnum', 'replynum'),
				),
				'forum_thread' => array(
					'name' => lang('blockclass', 'blockclass_forum_thread'),
					'script' => 'thread',
					'replacekeys' => array('forumname', 'forumurl'),
					'searchkeys' => array('groupname', 'groupurl'),
				),
			);
	}

	function getsetting() {
		global $_G;
		$settings = $this->setting;

		if($settings['gtids']) {
			loadcache('grouptype');
			$settings['gtids']['value'][] = array(0, lang('portalcp', 'block_all_type'));
			foreach($_G['cache']['grouptype']['first'] as $gid=>$group) {
				$settings['gtids']['value'][] = array($gid, $group['name']);
				if($group['secondlist']) {
					foreach($group['secondlist'] as $subgid) {
						$settings['gtids']['value'][] = array($subgid, '&nbsp;&nbsp;'.$_G['cache']['grouptype']['second'][$subgid]['name']);
					}
				}
			}
		}
		return $settings;
	}

	function cookparameter($parameter) {
		return $parameter;
	}

	function getdata($style, $parameter) {
		global $_G;

		$parameter = $this->cookparameter($parameter);

		loadcache('grouptype');
		$typeids = array();
		if(!empty($parameter['gtids'])) {
			if($parameter['gtids'][0] == '0') {
				unset($parameter['gtids'][0]);
			}
			$typeids = $parameter['gtids'];
		}
		$tids		= !empty($parameter['tids']) ? explode(',', $parameter['tids']) : array();
		$fids		= !empty($parameter['fids']) ? explode(',', $parameter['fids']) : array();
		$uids		= !empty($parameter['uids']) ? explode(',', $parameter['uids']) : array();
		$startrow	= isset($parameter['startrow']) ? intval($parameter['startrow']) : 0;
		$items		= isset($parameter['items']) ? intval($parameter['items']) : 10;
		$special	= isset($parameter['special']) ? $parameter['special'] : array();
		$lastpost	= isset($parameter['lastpost']) ? intval($parameter['lastpost']) : 0;
		$rewardstatus	= isset($parameter['rewardstatus']) ? intval($parameter['rewardstatus']) : 0;
		$titlelength	= !empty($parameter['titlelength']) ? intval($parameter['titlelength']) : 40;
		$summarylength	= !empty($parameter['summarylength']) ? intval($parameter['summarylength']) : 80;
		$orderby	= in_array($parameter['orderby'], array('dateline','replies','views','threads', 'heats', 'recommends')) ? $parameter['orderby'] : 'lastpost';
		$picrequired = !empty($parameter['picrequired']) ? 1 : 0;
		$gviewperm = isset($parameter['gviewperm']) ? intval($parameter['gviewperm']) : -1;

		$bannedids = !empty($parameter['bannedids']) ? explode(',', $parameter['bannedids']) : array();

		$gviewwhere = $gviewperm == -1 ? '' : " AND ff.gviewperm='$gviewperm'";

		$groups = array();
		if(empty($fids) && $typeids) {
			$query = DB::query('SELECT f.fid, f.name, ff.description FROM '.DB::table('forum_forum')." f LEFT JOIN ".DB::table('forum_forumfield')." ff ON f.fid = ff.fid WHERE f.fup IN (".dimplode($typeids).") AND threads > 0$gviewwhere");
			while($value = DB::fetch($query)) {
				$groups[$value['fid']] = $value;
				$fids[] = intval($value['fid']);
			}
			if(empty($fids)){
				return array('html' => '', 'data' => '');
			}
		}

		require_once libfile('function/post');
		$datalist = $list = array();
		$threadtypeids = array();
		$sql = ($fids ? ' AND t.fid IN ('.dimplode($fids).')' : '')
			.($tids ? ' AND t.tid IN ('.dimplode($tids).')' : '')
			.($bannedids ? ' AND t.tid NOT IN ('.dimplode($bannedids).')' : '')
			.($uids ? ' AND t.authorid IN ('.dimplode($uids).')' : '')
			.($special ? ' AND t.special IN ('.dimplode($special).')' : '')
			.((in_array(3, $special) && $rewardstatus) ? ($rewardstatus == 1 ? ' AND t.price < 0' : ' AND t.price > 0') : '')
			.($picrequired ? ' AND t.attachment = 2' : '');

		if(empty($fids)) {
			$sql .= " AND t.isgroup='1'";
			if($gviewwhere) {
				$sql .= $gviewwhere;
			}
		}
		if($lastpost) {
			$time = TIMESTAMP - $lastpost;
			$sql .= " AND t.lastpost >= '$time'";
		}
		if($orderby == 'heats') {
			$heatdateline = TIMESTAMP - 86400 * $_G['setting']['indexhot']['days'];
			$sql .= " AND t.dateline>'$heatdateline' AND t.heats>'0'";
		}

		$sqlfield = '';
		$sqlfrom = "FROM `".DB::table('forum_thread')."` t";
		if(empty($fids)) {
			$sqlfield = ', f.name groupname';
			$sqlfrom .= ' LEFT JOIN '.DB::table('forum_forum').' f ON t.fid=f.fid LEFT JOIN '.DB::table('forum_forumfield').' ff ON f.fid = ff.fid';
		}

		$query = DB::query("SELECT t.* $sqlfield
			$sqlfrom WHERE t.readperm='0'
			$sql
			AND t.displayorder>='0'
			ORDER BY t.$orderby DESC
			LIMIT $startrow,$items;"
			);

		require_once libfile('block_thread', 'class/block/forum');
		$bt = new block_thread();
		while($data = DB::fetch($query)) {
			if($data['closed'] > 1 && $data['closed'] < $data['tid']) continue;
			$_G['thread'][$data['tid']] = $data;
			if($style['getpic'] && $data['attachment']=='2') {
				$pic = $bt->getpic($data['tid']);
				$data['attachment'] = $pic['attachment'];
				$data['remote'] = $pic['remote'];
			}
			$list[] = array(
				'id' => $data['tid'],
				'idtype' => 'tid',
				'title' => cutstr(str_replace('\\\'', '&#39;', $data['subject']), $titlelength, ''),
				'url' => 'forum.php?mod=viewthread&tid='.$data['tid'],
				'pic' => $data['attachment'] ? 'forum/'.$data['attachment'] : STATICURL.'image/common/nophoto.gif',
				'picflag' => $data['attachment'] ? ($data['remote'] ? '2' : '1') : '0',
				'summary' => $style['getsummary'] ? $bt->getthread($data['tid'], $summarylength) : '',
				'fields' => array(
					'fulltitle' => str_replace('\\\'', '&#39;', addslashes($data['subject'])),
					'icon' => 'forum/'.$data['icon'],
					'author' => $data['author'] ? $data['author'] : 'Anonymous',
					'authorid' => $data['author'] ? $data['authorid'] : 0,
					'avatar' => avatar(($data['author'] ? $data['authorid'] : 0), 'small', true, false, false, $_G['setting']['ucenterurl']),
					'avatar_middle' => avatar(($data['author'] ? $data['authorid'] : 0), 'middle', true, false, false, $_G['setting']['ucenterurl']),
					'avatar_big' => avatar(($data['author'] ? $data['authorid'] : 0), 'big', true, false, false, $_G['setting']['ucenterurl']),
					'dateline' => $data['dateline'],
					'lastpost' => $data['lastpost'],
					'posts' => $data['posts'],
					'todayposts' => $data['todayposts'],
					'replies' => $data['replies'],
					'views' => $data['views'],
					'heats' => $data['heats'],
					'recommends' => $data['recommends'],
					'groupname' => empty($groups[$data['fid']]['name']) ? $data['groupname'] : $groups[$data['fid']]['name'],
					'groupurl' => 'forum.php?mod=group&fid='.$data['fid'],
				)
			);
		}
		return array('html' => '', 'data' => $list);
	}
}


?>