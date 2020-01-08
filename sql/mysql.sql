CREATE TABLE `jill_notice` (
  `sn` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `create_date` datetime NOT NULL COMMENT '建立時間',
  `deadline` datetime NOT NULL COMMENT '下架時間',
  `type` enum('text','textarea','url','img','ckeditor') NOT NULL COMMENT '類型',
  `title` varchar(255) NOT NULL COMMENT '標題',
  `content` text NOT NULL COMMENT '內文',
  `uid` mediumint(8) unsigned NOT NULL COMMENT '申請人員',
  `status` enum('0','1','2') NOT NULL COMMENT '是否啟用',
  `note` varchar(300) NOT NULL COMMENT '備註',
  `sort` smallint(5) unsigned NOT NULL COMMENT '排序',
  `cate_sn` smallint(6) unsigned NOT NULL COMMENT '分類編號',
  `auditor` mediumint(8) unsigned NOT NULL COMMENT '審核者',
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM COMMENT='臨時公告';

CREATE TABLE `jill_notice_cate` (
  `cate_sn` smallint(6) unsigned NOT NULL auto_increment COMMENT '分類編號',
  `cate_title` varchar(255) NOT NULL COMMENT '分類標題',
  `cate_desc` varchar(255) NOT NULL COMMENT '分類說明',
  `cate_sort` smallint(6) unsigned NOT NULL COMMENT '分類排序',
  `post_group` varchar(255) NOT NULL COMMENT '可編寫群組' ,
  `read_group` varchar(255) NOT NULL COMMENT '可讀群組',
  `auditors` varchar(255) NOT NULL COMMENT '審核者',
  PRIMARY KEY  (`cate_sn`)
) ENGINE=MyISAM;

CREATE TABLE `jill_notice_files_center` (
  `files_sn` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '檔案流水號',
  `col_name` varchar(255) NOT NULL COMMENT '欄位名稱',
  `col_sn` varchar(255) NOT NULL COMMENT '欄位編號',
  `sort` smallint(5) unsigned NOT NULL COMMENT '排序',
  `kind` enum('img','file') NOT NULL COMMENT '檔案種類',
  `file_name` varchar(255) NOT NULL COMMENT '檔案名稱',
  `file_type` varchar(255) NOT NULL COMMENT '檔案類型',
  `file_size` int(10) unsigned NOT NULL COMMENT '檔案大小',
  `description` text NOT NULL COMMENT '檔案說明',
  `counter` mediumint(8) unsigned NOT NULL COMMENT '下載人次',
  `original_filename` varchar(255) NOT NULL COMMENT '檔案名稱',
  `hash_filename` varchar(255) NOT NULL COMMENT '加密檔案名稱',
  `sub_dir` varchar(255) NOT NULL COMMENT '檔案子路徑',
  `upload_date` datetime NOT NULL COMMENT '上傳時間',
  `uid` mediumint(8) unsigned NOT NULL default 0 COMMENT '上傳者',
  `tag` varchar(255) NOT NULL default '' COMMENT '註記',
  PRIMARY KEY (`files_sn`)
)ENGINE=MyISAM;

