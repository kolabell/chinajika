<?php
/**
 *  插件的安装文件, 默认名字为 install.php , 安装新插件的时候会自动执行
 *  或者是可以通过修改 XML 文件来实现
 **/

/** 防止非法引用 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

//插件表前缀
$tablepre=getglobal('config/db/1/tablepre').'plugin_';

$sql = <<<EOF
--
-- 表的结构 `kapian`
--

CREATE TABLE IF NOT EXISTS `{$tablepre}zoushitu` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`mingcheng` varchar(45) DEFAULT NULL,
		`mianzhi` varchar(25) DEFAULT NULL,
		`meishu` int(11) DEFAULT NULL,
		`faxingliang` int(11) DEFAULT NULL,
		`faxingshijian` varchar(45) DEFAULT NULL,
		`faxingjia` int(11) DEFAULT NULL,
		`zoushi` text,
		PRIMARY KEY (`id`),
		UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
EOF;


/** 实现 SQL ddl 语句 */
runquery($sql);

/** 注意这里, 必须把 $finish 设为 TRUE , 提示系统说安装已经结束, 否则会出现白屏!! */
$finish = TRUE;