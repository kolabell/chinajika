<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: spacecp_click.php 22942 2011-06-07 01:54:42Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$clickid = empty($_GET['clickid'])?0:intval($_GET['clickid']);
$idtype = empty($_GET['idtype'])?'':trim($_GET['idtype']);
$id = empty($_GET['id'])?0:intval($_GET['id']);

loadcache('click');
$clicks = empty($_G['cache']['click'][$idtype])?array():$_G['cache']['click'][$idtype];
$click = $clicks[$clickid];

if(empty($click)) {
	showmessage('click_error');
}

switch ($idtype) {
	case 'picid':
		$sql = "SELECT p.*, s.username, a.friend, pf.hotuser FROM ".DB::table('home_pic')." p
			LEFT JOIN ".DB::table('home_picfield')." pf ON pf.picid=p.picid
			LEFT JOIN ".DB::table('home_album')." a ON a.albumid=p.albumid
			LEFT JOIN ".DB::table('common_member')." s ON s.uid=p.uid
			WHERE p.picid='$id'";
		$tablename = DB::table('home_pic');
		break;
	case 'aid':
		$sql = "SELECT a.* FROM ".DB::table('portal_article_title')." a
			LEFT JOIN ".DB::table('portal_article_content')." af ON af.aid=a.aid
			WHERE a.aid='$id'";
		$tablename = DB::table('portal_article_title');
		break;
	default:
		$idtype = 'blogid';
		$sql = "SELECT b.*, bf.hotuser FROM ".DB::table('home_blog')." b
			LEFT JOIN ".DB::table('home_blogfield')." bf ON bf.blogid=b.blogid
			WHERE b.blogid='$id'";
		$tablename = DB::table('home_blog');
		break;
}
$query = DB::query($sql);
if(!$item = DB::fetch($query)) {
	showmessage('click_item_error');
}

$hash = md5($item['uid']."\t".$item['dateline']);
if($_GET['op'] == 'add') {
	if(!checkperm('allowclick') || $_GET['hash'] != $hash) {
		showmessage('no_privilege');
	}

	if($item['uid'] == $_G['uid']) {
		showmessage('click_no_self');
	}

	if(isblacklist($item['uid'])) {
		showmessage('is_blacklist');
	}

	$query = DB::query("SELECT * FROM ".DB::table('home_clickuser')." WHERE uid='$space[uid]' AND id='$id' AND idtype='$idtype'");
	if($value = DB::fetch($query)) {
		showmessage('click_have');
	}

	$setarr = array(
		'uid' => $space['uid'],
		'username' => $_G['username'],
		'id' => $id,
		'idtype' => $idtype,
		'clickid' => $clickid,
		'dateline' => $_G['timestamp']
	);
	DB::insert('home_clickuser', $setarr);

	DB::query("UPDATE $tablename SET click{$clickid}=click{$clickid}+1 WHERE $idtype='$id'");

	hot_update($idtype, $id, $item['hotuser']);

	$note_type = '';
	$q_note = '';
	$q_note_values = array();

	$fs = array();
	switch ($idtype) {
		case 'blogid':
			$fs['title_template'] = 'feed_click_blog';
			$fs['title_data'] = array(
				'touser' => "<a href=\"home.php?mod=space&uid=$item[uid]\">{$item[username]}</a>",
				'subject' => "<a href=\"home.php?mod=space&uid=$item[uid]&do=blog&id=$item[blogid]\">$item[subject]</a>",
				'click' => $click['name']
			);

			$note_type = 'clickblog';
			$q_note = 'click_blog';
			$q_note_values = array(
				'url'=>"home.php?mod=space&uid=$item[uid]&do=blog&id=$item[blogid]",
				'subject'=>$item['subject'],
				'from_id' => $item['blogid'],
				'from_idtype' => 'blogid'
			);
			break;
		case 'aid':
			$fs['title_template'] = 'feed_click_article';
			$fs['title_data'] = array(
				'touser' => "<a href=\"home.php?mod=space&uid=$item[uid]\">{$item[username]}</a>",
				'subject' => "<a href=\"portal.php?mod=view&aid=$item[aid]\">$item[title]</a>",
				'click' => $click['name']
			);

			$note_type = 'clickarticle';
			$q_note = 'click_article';
			$q_note_values = array(
				'url'=>"portal.php?mod=view&aid=$item[aid]",
				'subject'=>$item['title'],
				'from_id' => $item['aid'],
				'from_idtype' => 'aid'
			);
			break;
		case 'picid':
			$fs['title_template'] = 'feed_click_pic';
			$fs['title_data'] = array(
				'touser' => "<a href=\"home.php?mod=space&uid=$item[uid]\">{$item[username]}</a>",
				'click' => $click['name']
			);
			$fs['images'] = array(pic_get($item['filepath'], 'album', $item['thumb'], $item['remote']));
			$fs['image_links'] = array("home.php?mod=space&uid=$item[uid]&do=album&picid=$item[picid]");
			$fs['body_general'] = $item['title'];

			$note_type = 'clickpic';
			$q_note = 'click_pic';
			$q_note_values = array(
				'url'=>"home.php?mod=space&uid=$item[uid]&do=album&picid=$item[picid]",
				'from_id' => $item['picid'],
				'from_idtype' => 'picid'
			);
			break;
	}

	if(empty($item['friend']) && ckprivacy('click', 'feed')) {
		require_once libfile('function/feed');
		$fs['title_data']['hash_data'] = "{$idtype}{$id}";
		feed_add('click', $fs['title_template'], $fs['title_data'], '', array(), $fs['body_general'],$fs['images'], $fs['image_links']);
	}

	updatecreditbyaction('click', 0, array(), $idtype.$id);

	require_once libfile('function/stat');
	updatestat('click');

	notification_add($item['uid'], $note_type, $q_note, $q_note_values);

	showmessage('click_success', '', array('idtype' => $idtype, 'id' => $id, 'clickid' => $clickid), array('msgtype' => 3, 'showmsg' => true, 'closetime' => true));

} elseif ($_GET['op'] == 'show') {

	$maxclicknum = 0;
	foreach ($clicks as $key => $value) {
		$value['clicknum'] = $item["click{$key}"];
		$value['classid'] = mt_rand(1, 4);
		if($value['clicknum'] > $maxclicknum) $maxclicknum = $value['clicknum'];
		$clicks[$key] = $value;
	}

	$perpage = 18;
	$page = intval($_GET['page']);
	$start = ($page-1)*$perpage;
	if($start < 0) $start = 0;

	$count = getcount('home_clickuser', array('id'=>$id, 'idtype'=>$idtype));
	$clickuserlist = array();
	$click_multi = '';

	if($count) {
		$query = DB::query("SELECT * FROM ".DB::table('home_clickuser')."
			WHERE id='$id' AND idtype='$idtype'
			ORDER BY dateline DESC
			LIMIT $start,$perpage");
		while ($value = DB::fetch($query)) {
			$value['clickname'] = $clicks[$value['clickid']]['name'];
			$clickuserlist[] = $value;
		}

		$click_multi = multi($count, $perpage, $page, "home.php?mod=spacecp&ac=click&op=show&clickid=$clickid&idtype=$idtype&id=$id");
	}
}

include_once(template('home/spacecp_click'));

?>