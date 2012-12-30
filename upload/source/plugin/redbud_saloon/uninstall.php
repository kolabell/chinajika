<?php
/**
 *  插件的卸载文件, 默认名字为 uninstall.php , 卸载插件的时候会自动执行
 *  或者是可以通过修改 XML 文件来实现
 **/

/** 防止非法引用 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/** 注意这里, 必须把 $finish 设为 TRUE , 提示系统说安装已经结束, 否则会出现白屏!! */
$finish = TRUE;