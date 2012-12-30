<?php
define('APPTYPEID', 3);
define('CURSCRIPT', 'group');


require './upload/source/class/class_core.php';
require './upload/source/class/table/table_forum_forum.php';

$discuz = C::app();

$discuz->init();
runhooks();
$discuzurl = $_G['setting']['discuzurl'];

$sql = "select fid, fup, name from ".DB::table("forum_forum")." where fup = 1";
//大版块数组
$result = DB::fetch_all($sql);


function getsubforums($fatherfid){
	$sql = "select fid from ".DB::table("forum_forum")." where fup = $fatherfid";
	$result_1 = DB::fetch_all($sql);
	foreach($result_1 as $key=>$val){
		$result_1[$key]=$result_1[$key]['fid'];
	}
    return fetch_all_info_by_fids($result_1,1,0,0,1);
}

function fetch_all_info_by_fids($fids, $status = 0, $limit = 0, $fup = 0, $displayorder = 0, $onlyforum = 0, $noredirect = 0, $type = '', $start = 0) {
	$sql = $fids ? "f.".DB::field('fid', $fids) : '';
	$sql .= empty($fup) ? '' : ($sql ? ' AND ' : '').'f.'.DB::field('fup', $fup);
	if(!strcmp($status, 'available')) {
		$sql .= ($sql ? ' AND ' : '')." f.status>'0'";
	} elseif($status) {
		$sql .= $status ? ($sql ? ' AND ' : '')." f.".DB::field('status', $status) : '';
	}
	$sql .= $onlyforum ? ($sql ? ' AND ' : '').'f.type<>\'group\'' : '';
	$sql .= $type ? ($sql ? ' AND ' : '').'f.'.DB::field('type', $type) : '';
	$sql .= $noredirect ? ($sql ? ' AND ' : '').'ff.redirect=\'\'' : '';
	$ordersql = $displayorder ? ' ORDER BY f.displayorder' : '';
	$limitsql = $limit ? DB::limit($start, $limit) : '';
	if(!$sql) {
		return array();
	}
	return DB::fetch_all("SELECT ff.description, ff.moderators, f.fid,f.name FROM %t f LEFT JOIN %t ff USING (fid) WHERE $sql $ordersql $limitsql", array('forum_forum', 'forum_forumfield'), 'fid');
}

$threads = new table_forum_thread();

function fetch_portaltitlelist_by_catid($catid){
	$result = null;
	$tablename='portal_article_title';
	$sql='select aid,title from '.DB::table($tablename).' where catid = '.$catid.' order by aid desc';
	$result= DB::fetch_all($sql);
	return $result;
}


/*
echo '<pre>';
var_dump(getsubforums(2));
echo '</pre>';

echo '<pre>';
var_dump($tff->fetch_all_info_by_fids(array(41,42)));
echo '</pre>';
*/

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>中国集卡网</title>
    <script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
    <link type="text/css" rel="stylesheet" href="css/main.css" />
</head>
<body>
<div class="header clearfix">
    <div class="header_1">
        <div class="logo"><img src="images/logo.png" /></div>
    </div>
    <div class="header_2"></div>
</div>
<div class="nav_container clearfix">
<ul class="nav">
    <li><a style="padding-left: 32px" href="">首页</a></li>
    <li><a target="_blank" href="<?php echo $discuzurl.'/portal.php?mod=list&catid=2' ?>">行业新闻</a></li>
    <li><a target="_blank" href="<?php echo $discuzurl.'/portal.php?mod=list&catid=3' ?>">集卡新闻</a></li>
    <li><a target="_blank" href="<?php echo $discuzurl.'/portal.php?mod=list&catid=4' ?>">每日行情</a></li>
    <li><a target="_blank" href="<?php echo $discuzurl.'/plugin.php?id=redbud_zoushitu:zoushitu' ?>">国卡走势图</a></li>
    <li class="kahai"><a target="_blank" href="<?php echo $discuzurl.'/portal.php?mod=list&catid=5' ?>">卡海钩沉</a>
    <ul class="subkahai">
				<li><a target="_blank" href="<?php echo $discuzurl?>/portal.php?mod=list&catid=6">知识库</a></li>
				<li><a target="_blank" href="<?php echo $discuzurl?>/portal.php?mod=list&catid=7">换卡旧闻</a></li>
				<li><a target="_blank" href="###">历届拍卖纪录</a></li>
				<li><a target="_blank" href="<?php echo $discuzurl.'/plugin.php?id=saloon:addsaloon' ?>">集卡沙龙</a></li>
				<li><a target="_blank" href="###">电话卡友</a></li>
			</ul>
	</li>
    <li><a target="_blank" href="<?php echo $discuzurl?>">论坛</a></li>
</ul>
<ul class="nav_right">
    <li style="padding-left: 15px"><a href="">设为首页</a></li>
    <li><a style="padding-left: 11px" href="">|</a></li>
    <li><a style="padding-left: 10px" href="">加为收藏</a></li>
</ul>
</div>
<div class="main">
    <div class="main_1 clearfix">
        <div class="main_1_left">
            <div class="small_container left">
                <div class="title1"><span>专家视点</span></div>
                <ul class="bk_list">
                <?php
                    $count=0;
                foreach (fetch_portaltitlelist_by_catid(1) as $val){
                    if($count>9) break;
                ?>
                    <li><a href="<?php echo $val['aid']?>"><?php echo $val['title']?></a></li>
                <?php
                    $count++;
                }
                ?>
                </ul>
            </div>
            <div class="small_container left">
                <div class="title1"><span>行业新闻</span></div>
                <ul class="bk_list">
                    <?php
                    $count = 0;
                    foreach(fetch_portaltitlelist_by_catid(2) as $val){
                        if($count>7)break;
                        if($count == 0){
                    ?>
                    <li class="clearfix" style="background: none;padding-left: 0">
                        <table style="float: left">
                            <tr>
                                <td><img src="images/houzi.png" /></td>
                                <td valign="top" style="width: 120px;padding-left: 7px">
                                    <div><a style="color: #009cd9;font-weight: bold" href="#"><?php echo $val['title'] ?></a></div>
                                    <div><a style="color: #999999;font-size: 12px" href="#">六部委授权电信广电互推</a><a style="font-size: 12px;color: #e8ac00;">&nbsp;[详细]</a></div>
                                </td>
                            </tr></table>
                    </li>
                    <?php
                    }else{
                    ?>
                    <li><a href="<?php echo $val['aid']?>"><?php echo $val['title']?></a></li>
                    <?php
                        }
                        $count++;
                    }
                    ?>
                </ul>
            </div>
            <div class="small_container left">
                <div class="title1"><span>集卡新闻</span></div>
                <ul class="bk_list">
                    <?php
                    $count = 0;
                    foreach(fetch_portaltitlelist_by_catid(3) as $val){
                        if($count>7)break;
                        if($count == 0){
                            ?>
                            <li class="clearfix" style="background: none;padding-left: 0">
                                <table style="float: left">
                                    <tr>
                                        <td><img src="images/houzi.png" /></td>
                                        <td valign="top" style="width: 120px;padding-left: 7px">
                                            <div><a style="color: #009cd9;font-weight: bold" href="#"><?php echo $val['title'] ?></a></div>
                                            <div><a style="color: #999999;font-size: 12px" href="#">六部委授权电信广电互推</a><a style="font-size: 12px;color: #e8ac00;">&nbsp;[详细]</a></div>
                                        </td>
                                    </tr></table>
                            </li>
                            <?php
                        }else{
                            ?>
                            <li><a href="<?php echo $val['aid']?>"><?php echo $val['title']?></a></li>
                            <?php
                        }
                        $count++;
                    }
                    ?>
                </ul>
            </div>


        </div>
        <div class="main_1_right">
        <?php  if (empty($_G['uid'])) {?>
                <div class="title title1"><span>论坛(未登录)</span></div>
<form onsubmit="return lsSubmit();" action="<?php echo $discuzurl?>/member.php?mod=logging&amp;action=login&amp;loginsubmit=yes&amp;infloat=yes&amp;lssubmit=yes" id="lsform" autocomplete="off" method="post">
                <div class="bbs_login">
                    <div><span style="padding-left: 3px">用户名:</span></div>
                    <div><span><input type="input" autocomplete="off" id="ls_username" name="username" /></span></div>
                    <div><span style="padding-left: 3px">密&nbsp;&nbsp;&nbsp;&nbsp;码:</span></div>
                    <div><span><input type="input" autocomplete="off" id="ls_password" name="password" /></span></div>
                    <div style="font-size: 12px">
                        <span><label class="labelCheckbox" for="autoLogin" title="为了确保您的信息安全，请不要在网吧或者公共机房勾选此项！">
                            <input type="checkbox" tabindex="4" value="true" id="autoLogin" name="autoLogin">下次自动登录
                        </label></span>
                        <span style="float: right;margin-right: 14px"><a style="font-size: 12px;color: #ffcf00" href="#">取回密码</a></span>
                    </div>
                    <div class="btn_login"><span><input type="submit" value="登录" /></span></div>
                    <div style="margin-bottom: 15px;"><span><a style="font-size: 12px;color: white" href="<?php echo $discuzurl.'/member.php?mod=register'?>">没有帐号请先注册</a></span></div>
            </form>
                </div>
<?php } 
 else { ?>
                <div class="title title1"><span>论坛(已登录)</span></div>
 <div align="right">欢迎您：<a href="<?php echo $discuzurl?>//home.php?mod=space&uid=<?php echo $_G['uid']; ?>" class="yellow">
<?php echo  $_G['username']; ?></a> <a href="<?php echo $discuzurl?>/home.php?mod=spacecp">设置</a> 
 <a href="<?php echo $discuzurl?>/home.php">个人中心</a> 
 <a href="<?php echo $discuzurl?>/member.php?mod=logging&action=logout&formhash=<?php echo FORMHASH;?>">退出登陆</a></div></div><?php }?>
            
        </div>
    </div>
    <div class="main_2 clearfix">
        <div class="main_2_left">
            <div class="clearfix block">
                <div class="main_2_small_container left forum1">
                    <div class="title"><span><img class="section_ico" src="images/2.PNG"/><a target="_blank" href="<?php echo $discuzurl.'/forum.php?mod=forumdisplay&fid='.$result[0]['fid'];?>"><?php echo $result[0]['name'];?></a></span></div>
                    <ul class="tabs clearfix">
                        <li><a href="#">网站公告</a></li>
                        <li><a href="#">各地卡展</a></li>
                        <li><a href="#">卡博会</a></li>
                        <li><a href="#">集卡新闻</a></li>
                        <li><a href="#">投资心得</a></li>
                        <li onclick="window.open('<?php echo $discuzurl.'/forum.php?mod=forumdisplay&fid='.$result[0]['fid'];?>')"><a href="#">更多</a></li>
                    </ul>
                    <!-- tab "panel" -->
                    <div class="panel">
                    <?php 
                    foreach(getsubforums($result[0]['fid']) as $val){
					?>
					<div class="subpanel">
                            <span class="subpanel_title"><?php echo $val['name']?></span>
                            <span class="subpanel_content"><?php echo $val['description']?></span>
                            <span style="margin-top: 8px">版主: <a class="banzhu"><?php echo $val['moderators']?></a></span>
                        </div>
					<?php 
					}
                    ?>
                    </div>
                    <ul class="bk_list">
                    	<?php
                    	$forum_threads=$threads->fetch_all_by_fid(array_keys(getsubforums($result[0]['fid'])),0,12);
                    	foreach (array_reverse($forum_threads) as $key=>$val){
						?>
                        <li><a href="<?php echo $val['tid']?>"><?php echo $val['subject']?></a></li>
						<?php 
						}
                    	?>
                        
                    </ul>
                </div>
                <div class="main_2_small_container left forum2">
                    <div class="title"><span><img class="section_ico" src="images/4.PNG"/><a target="_blank" href="<?php echo $discuzurl.'/forum.php?mod=forumdisplay&fid='.$result[1]['fid'];?>"><?php echo $result[1]['name'];?></a></span></div>
                    <ul class="tabs clearfix">
                        <li><a href="#">集卡研究</a></li>
                        <li><a href="#">制作与欣赏</a></li>
                        <li><a href="#">奇珍错卡</a></li>
                        <li><a href="#">资治通鉴</a></li>
                        <li><a href="#">精品杂玩</a></li>
                    </ul>
                    <!-- tab "panel" -->
                    <div class="panel">
                    <?php 
                    foreach(getsubforums($result[1]['fid']) as $val){
					?>
					<div class="subpanel">
                            <span class="subpanel_title"><?php echo $val['name']?></span>
                            <span class="subpanel_content"><?php echo $val['description']?></span>
                            <span style="margin-top: 8px">版主: <a class="banzhu"><?php echo $val['moderators']?></a></span>
                        </div>
					<?php 
					}
                    ?>
                    </div>
                    <ul class="bk_list">
                    	<?php
                    	$forum_threads=$threads->fetch_all_by_fid(array_keys(getsubforums($result[1]['fid'])),0,12);
                    	foreach (array_reverse($forum_threads) as $key=>$val){
						?>
                        <li><a href="<?php echo $val['tid']?>"><?php echo $val['subject']?></a></li>
						<?php 
						}
                    	?>
                        
                    </ul>
                </div>
            </div>
            <div class="clearfix block">
                <div class="main_2_small_container left forum3">
                    <div class="title"><span><img class="section_ico" src="images/5.PNG"/><a target="_blank" href="<?php echo $discuzurl.'/forum.php?mod=forumdisplay&fid='.$result[2]['fid'];?>"><?php echo $result[2]['name'];?></a></span></div>
                    <ul class="tabs clearfix">
                        <li><a href="#">联机卡</a></li>
                        <li><a href="#">金融卡</a></li>
                        <li><a href="#">手机卡</a></li>
                        <li><a href="#">交通卡</a></li>
                        <li><a href="#">游戏卡</a></li>
                        <li><a href="#">其他卡</a></li>
                    </ul>
                    <!-- tab "panel" -->
                    <div class="panel">
                    <?php 
                    foreach(getsubforums($result[2]['fid']) as $val){
					?>
					<div class="subpanel">
                            <span class="subpanel_title"><?php echo $val['name']?></span>
                            <span class="subpanel_content"><?php echo $val['description']?></span>
                            <span style="margin-top: 8px">版主: <a class="banzhu"><?php echo $val['moderators']?></a></span>
                        </div>
					<?php 
					}
                    ?>
                    </div>
                    <ul class="bk_list">
                    	<?php
                    	$forum_threads=$threads->fetch_all_by_fid(array_keys(getsubforums($result[2]['fid'])),0,12);
                    	foreach (array_reverse($forum_threads) as $key=>$val){
						?>
                        <li><a href="<?php echo $val['tid']?>"><?php echo $val['subject']?></a></li>
						<?php 
						}
                    	?>
                        
                    </ul>
                </div>
                <div class="main_2_small_container left forum4">
                    <div class="title"><span><img class="section_ico" src="images/7.PNG"/><a target="_blank" href="<?php echo $discuzurl.'/forum.php?mod=forumdisplay&fid='.$result[3]['fid'];?>"><?php echo $result[3]['name'];?></a></span></div>
                    <ul class="tabs clearfix">
                        <li><a href="#">密码电话</a></li>
                        <li><a href="#">田村太科</a></li>
                        <li><a href="#">IC电话卡</a></li>
                        <li><a href="#">金融卡</a></li>
                        <li><a href="#">移动SIM卡</a></li>
                    </ul>
                    <!-- tab "panel" -->
                    <div class="panel">
                    <?php 
                    foreach(getsubforums($result[3]['fid']) as $val){
					?>
					<div class="subpanel">
                            <span class="subpanel_title"><?php echo $val['name']?></span>
                            <span class="subpanel_content"><?php echo $val['description']?></span>
                            <span style="margin-top: 8px">版主: <a class="banzhu"><?php echo $val['moderators']?></a></span>
                        </div>
					<?php 
					}
                    ?>
                    </div>
                    <ul class="bk_list">
                    	<?php
                    	$forum_threads=$threads->fetch_all_by_fid(array_keys(getsubforums($result[3]['fid'])),0,12);
                    	foreach (array_reverse($forum_threads) as $key=>$val){
						?>
                        <li><a href="<?php echo $val['tid']?>"><?php echo $val['subject']?></a></li>
						<?php 
						}
                    	?>
                        
                    </ul>
                </div>
            </div>
            <div class="clearfix block" style="border: none">
                <div class="main_2_small_container left forum5">
                    <div class="title"><span><img class="section_ico" src="images/8.PNG"/><a target="_blank" href="<?php echo $discuzurl.'/forum.php?mod=forumdisplay&fid='.$result[4]['fid'];?>"><?php echo $result[4]['name'];?></a></span></div>
                    <ul class="tabs clearfix">
                        <li><a href="#">邮票专区</a></li>
                        <li><a href="#">钱币专区</a></li>
                        <li><a href="#">杂玩市场</a></li>
                        <li><a href="#">瓶瓶罐罐</a></li>
                    </ul>
                    <!-- tab "panel" -->
                    <div class="panel">
                    <?php 
                    foreach(getsubforums($result[4]['fid']) as $val){
					?>
					<div class="subpanel">
                            <span class="subpanel_title"><?php echo $val['name']?></span>
                            <span class="subpanel_content"><?php echo $val['description']?></span>
                            <span style="margin-top: 8px">版主: <a class="banzhu"><?php echo $val['moderators']?></a></span>
                        </div>
					<?php 
					}
                    ?>
                    </div>
                    <ul class="bk_list">
                    	<?php
                    	$forum_threads=$threads->fetch_all_by_fid(array_keys(getsubforums($result[4]['fid'])),0,12);
                    	foreach (array_reverse($forum_threads) as $key=>$val){
						?>
                        <li><a href="<?php echo $val['tid']?>"><?php echo $val['subject']?></a></li>
						<?php 
						}
                    	?>
                        
                    </ul>
                </div>
                <div class="main_2_small_container left forum6">
                    <div class="title"><span><img class="section_ico" src="images/9.PNG"/><a target="_blank" href="<?php echo $discuzurl.'/forum.php?mod=forumdisplay&fid='.$result[5]['fid'];?>"><?php echo $result[5]['name'];?></a></span></div>
                    <ul class="tabs clearfix">
                        <li><a href="#">地铁卡网</a></li>
                        <li><a href="#">水乡卡苑</a></li>
                        <li><a href="#">荣才收藏</a></li>
                        <li><a href="#">姑姑小店</a></li>
                        <li><a href="#">天津金融卡苑</a></li>
                    </ul>
                    <!-- tab "panel" -->
                    <div class="panel">
                    <?php 
                    foreach(getsubforums($result[5]['fid']) as $val){
					?>
					<div class="subpanel">
                            <span class="subpanel_title"><?php echo $val['name']?></span>
                            <span class="subpanel_content"><?php echo $val['description']?></span>
                            <span style="margin-top: 8px">版主: <a class="banzhu"><?php echo $val['moderators']?></a></span>
                        </div>
					<?php 
					}
                    ?>
                    </div>
                    <ul class="bk_list">
                    	<?php
                    	$forum_threads=$threads->fetch_all_by_fid(array_keys(getsubforums($result[5]['fid'])),0,12);
                    	foreach (array_reverse($forum_threads) as $key=>$val){
						?>
                        <li><a href="<?php echo $val['tid']?>"><?php echo $val['subject']?></a></li>
						<?php 
						}
                    	?>
                        
                    </ul>
                </div>
            </div>
        </div>
        <div class="main_2_right">
            <div class="main_2_right_small_container forumright1">
                <div class="title"><span><img style="margin-bottom: 2px" class="section_ico" src="images/3.PNG"/>最新市价</span></div>
                <div class="rightlist_subtitle_1">
                    <span style="margin-left: 18px">名称</span>
                    <span style="margin-left: 105px">价格(元)</span>
                </div>
                <ul class="bk_list">
                    <li><span class="nu">CNT00</span><span class="name">试机卡</span><span class="price">780</span></li>
                    <li><span class="nu">CNT00</span><span class="name">试机卡</span><span class="price">780</span></li>
                    <li><span class="nu">CNT00</span><span class="name">试机卡</span><span class="price">780</span></li>
                    <li><span class="nu">CNT00</span><span class="name">试机卡</span><span class="price">780</span></li>
                    <li><span class="nu">CNT00</span><span class="name">试机卡</span><span class="price">780</span></li>
                    <li><span class="nu">CNT00</span><span class="name">试机卡</span><span class="price">780</span></li>
                    <li><span class="nu">CNT00</span><span class="name">试机卡</span><span class="price">780</span></li>
                    <li><span class="nu">CNT00</span><span class="name">试机卡</span><span class="price">780</span></li>
                    <li><span class="nu">CNT00</span><span class="name">试机卡</span><span class="price">780</span></li>
                    <li><span class="nu">CNT00</span><span class="name">试机卡</span><span class="price">780</span></li>
                    <li><span class="nu">CNT00</span><span class="name">试机卡</span><span class="price">780</span></li>
                    <li><span class="nu">CNT00</span><span class="name">试机卡</span><span class="price">780</span></li>
                    <li><span class="nu">CNT00</span><span class="name">试机卡</span><span class="price">780</span></li>
                    <li><span class="nu">CNT00</span><span class="name">试机卡</span><span class="price">780</span></li>
                    <li><span class="nu">CNT00</span><span class="name">试机卡</span><span class="price">780</span></li>
                    <li><span class="nu">CNT00</span><span class="name">试机卡</span><span class="price">780</span></li>
                    <li><span class="nu">CNT00</span><span class="name">试机卡</span><span class="price">780</span></li>
                    <li><span class="nu">CNT00</span><span class="name">试机卡</span><span class="price">780</span></li>
                    <li><span class="nu">CNT00</span><span class="name">试机卡</span><span class="price">780</span></li>
                    <li><span class="nu">CNT00</span><span class="name">试机卡</span><span class="price">780</span></li>
                </ul>
            </div>
            <div class="main_2_right_small_container forumright2">
                <div class="rightlist_title_2"><span><img style="margin-bottom: 4px" class="section_ico" src="images/12.PNG"/>电话卡目录</span></div>
                <div class="rightlist_subtitle_2">
                    <span style="margin-left: 15px">通用卡</span>
                </div>
                <ul class="bk_list">
                    <li>
                        <div><span>电信：通用版IC卡</span></div>
                        <ul class="card_sublist">
                            <li style="margin-top: 6px">IC-00&nbsp;&nbsp;纪念卡</li>
                            <li>IC-P&nbsp;&nbsp;&nbsp;&nbsp;普通卡</li>
                            <li>IC-G&nbsp;&nbsp;&nbsp;&nbsp;广告卡</li>
                            <li>IC-PG&nbsp;普广卡</li>
                            <li>IC-T&nbsp;&nbsp;&nbsp;&nbsp;特种卡</li>
                            <li>电总IC实验卡</li>
                            <li>各省黄河IC卡</li>
                            <li>电信版密码卡</li>
                        </ul>
                    </li>
                    <li><span>电信： 通用版磁卡</span></li>
                    <li><span>电信： 通用加字卡</span></li>
                    <li><span>联通： 地方版IC卡</span></li>
                    <li><span>网通： 地方版IC卡</span></li>
                    <li><span>铁通： 通用版IC卡</span></li>
                </ul>
                <div class="rightlist_subtitle_2">
                    <span style="margin-left: 15px">地方卡</span>
                </div>
                <div class="bk_list" style="padding-top: 10px">
                    <table style="width: 197px;">
                        <tr>
                            <td><a href="#">北京</a></td>
                            <td><a href="#">上海</a></td>
                            <td><a href="#">天津</a></td>
                            <td><a href="#">重庆</a></td>
                            <td><a href="#">四川</a></td>
                        </tr>
                        <tr>
                            <td><a href="#">云南</a></td>
                            <td><a href="#">贵州</a></td>
                            <td><a href="#">西藏</a></td>
                            <td><a href="#">新疆</a></td>
                            <td><a href="#">甘肃</a></td>
                        </tr>
                        <tr>
                            <td><a href="#">青海</a></td>
                            <td><a href="#">内蒙</a></td>
                            <td><a href="#">宁夏</a></td>
                            <td><a href="#">黑龙</a></td>
                            <td><a href="#">吉林</a></td>
                        </tr>
                        <tr>
                            <td><a href="#">辽宁</a></td>
                            <td><a href="#">浙江</a></td>
                            <td><a href="#">福建</a></td>
                            <td><a href="#">安徽</a></td>
                            <td><a href="#">海南</a></td>
                        </tr>
                        <tr>
                            <td><a href="#">江苏</a></td>
                            <td><a href="#">江西</a></td>
                            <td><a href="#">湖南</a></td>
                            <td><a href="#">湖北</a></td>
                            <td><a href="#">山东</a></td>
                        </tr>
                        <tr>
                            <td><a href="#">山西</a></td>
                            <td><a href="#">陕西</a></td>
                            <td><a href="#">河南</a></td>
                            <td><a href="#">河北</a></td>
                            <td><a href="#">广东</a></td>
                        </tr>
                        <tr>
                            <td><a href="#">广西</a></td>
                            <td colspan="2"><a href="#">联合发行</a></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="main_2_right_small_container forumright2">
                <div class="rightlist_title_2"><span><img style="margin-bottom: 4px" class="section_ico" src="images/11.PNG"/>地铁卡目录</span></div>
                <div class="rightlist_subtitle_2">
                    <span style="margin-left: 15px">地铁卡</span>
                </div>
                <div class="bk_list" style="padding-left: 14px;padding-top:10px">
                    <div><span style="margin-right: 29px"><a>北京</a></span><span><a>上海</a></span></div>
                    <div style="margin-top: 5px"><span style="margin-right: 29px"><a>天津</a></span><span><a>广州</a></span></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <div class="ct_friendlink">
        <div class="friendlink_title"><span><img style="margin-bottom: 2px" class="section_ico" src="images/10.PNG"/>友情链接</span></div>
        <div class="friendlink_content">
            <div class="friendlinkblock"><span class="link"><a href="#">中国信息产业网</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">中国电信集团公司</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">中国联通</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">中国移动</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">中华电信</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">上海市通信管理局</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">中国银联</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">中国收藏家协会</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">新华网收藏频道</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">新浪网收藏频道</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">上海商报艺术品投资</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">卡趣</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">卡友俱乐部</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">中国地铁卡网</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">上海地铁卡集藏协会</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">上海公共交通股份有限公司</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">广州羊城通有限公司</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">上海轨道交通俱乐部</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">地铁族</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">中国金融收藏网</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">51银行卡收藏沙龙</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">colnect.com</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">藏卡网</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">卡优网</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">易集藏论坛</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">中华卡迷网</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">邮币卡互动网</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">中国投资咨询网</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">中国集邮总公司</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">炒邮网</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">黎明邮讯</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">中国集币在线</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">赵涌在线</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">母老虎投资在线</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">中国艺术品网</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">建军邮社</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">九州好邮币卡投资网</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
            <div class="friendlinkblock"><span class="link"><a href="#">中国收藏热线</a></span><span class="seperator"><img src="images/seperator.png"/></span></div>
        </div>
    </div>
    <div class="ct_footer">
        <div style="height: 25px">关于本站 | 联系方式 | 版权声明 | 广告合作 | 友情链接</div>
        <div style="margin-bottom: 24px">Copyright © chinajika.com All Rights Reserved&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;业务联系: <a style="text-decoration: none" href="mailto:wuhao@chinajika.com">吴昊</a></div>
    </div>
</div>

<script>
    // perform JavaScript after the document is scriptable.
    $(function() {
        // setup ul.tabs to work as tabs for each div directly under div.panes
        $("ul.tabs").tabs("div.panel > div");
    });
</script>
</body>
</html>
