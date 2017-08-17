CREATE TABLE `BOARD_GIFT_MGR` (
  `GM_NO` bigint(20) NOT NULL auto_increment COMMENT '번호',
  `GM_B_CODE` varchar(50) default NULL COMMENT '커뮤니티 코드',
  `GM_UB_NO` bigint(20) default NULL COMMENT '게시판 번호',
  `GM_TYPE` varchar(20) default NULL COMMENT '발급유형(point, coupon)',
  `GM_AREA` varchar(20) default NULL COMMENT '발급위치(data, comment)',
  `GM_USE` varchar(10) default NULL COMMENT '사용유무(사용=Y, 사용안함=N)',
  `GM_GIVE_TYPE` varchar(10) default NULL COMMENT '지급방법(자동=A, 수동=M, 멀티=T)',
  `GM_MAX` int(11) default NULL COMMENT '발급개수',
  `GM_TITLE` varchar(500) default NULL COMMENT '제목',
  `GM_DATA` varchar(200) default NULL COMMENT '데이터(포인트=금액, 쿠폰=쿠폰번호)',
  PRIMARY KEY  (`GM_NO`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='커뮤니티 포인트/쿠폰 옵션';

