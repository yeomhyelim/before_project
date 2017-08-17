<?
/*@ boardWrite @*/
$BOARD_INFO['PHOTO']['b_code']                                         = "PHOTO";                                                            // 커뮤니티 코드
$BOARD_INFO['PHOTO']['b_name']                                         = "포토갤러리";                                                  // 커뮤니티 이름
$BOARD_INFO['PHOTO']['b_grp_no']                                       = "";                                                                 // 커뮤니티 그룹 번호
$BOARD_INFO['PHOTO']['b_kind']                                         = "data";                                                             // 커뮤니티 종류
$BOARD_INFO['PHOTO']['b_skin']                                         = "gallery";                                                          // 커뮤니티 스킨
$BOARD_INFO['PHOTO']['b_css']                                          = "basicCss2";                                                        // 커뮤니티 CSS
/*@ boardWrite @*/
/*@ boardModifyBasic @*/
$BOARD_INFO['PHOTO']['bi_start_mode']                                  = "dataList";                                                         // 커뮤니티 시작 페이지(list,view,write)
$BOARD_INFO['PHOTO']['bi_admin_nickname']                              = "";                                                                 // 커뮤니티 관리자 명칭 
$BOARD_INFO['PHOTO']['bi_comment_use']                                 = "M";                                                                // 커뮤니티 코멘트 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)
$BOARD_INFO['PHOTO']['bi_comment_member_auth'][0]                      = "N";                                                                // 커뮤니티 코멘트 사용 권한(일반회원, 관리자회원, 공급사회원)
$BOARD_INFO['PHOTO']['bi_comment_member_auth'][1]                      = "N";                                                                // 커뮤니티 코멘트 사용 권한(일반회원, 관리자회원, 공급사회원)
$BOARD_INFO['PHOTO']['bi_datalist_use']                                = "A";                                                                // 커뮤니티 리스트 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)
$BOARD_INFO['PHOTO']['bi_datalist_member_auth'][0]                     = "N";                                                                // 커뮤니티 보기 사용 권한(일반회원, 관리자회원, 공급사회원)
$BOARD_INFO['PHOTO']['bi_datalist_member_auth'][1]                     = "N";                                                                // 커뮤니티 보기 사용 권한(일반회원, 관리자회원, 공급사회원)
$BOARD_INFO['PHOTO']['bi_column_default']                              = "1";                                                                // 세로줄 수
$BOARD_INFO['PHOTO']['bi_list_default']                                = "10";                                                               // 리스트 수
$BOARD_INFO['PHOTO']['bi_page_default']                                = "";                                                                 // 페이지 수
$BOARD_INFO['PHOTO']['bi_datalist_field_use'][1]                       = "Y";                                                                // 커뮤니티 리스트 목록 설정(번호=0,작성자=1,등록일=2,조회수=3)
$BOARD_INFO['PHOTO']['bi_datalist_field_use'][2]                       = "Y";                                                                // 커뮤니티 리스트 목록 설정(번호=0,작성자=1,등록일=2,조회수=3)
$BOARD_INFO['PHOTO']['bi_datalist_field_use'][3]                       = "Y";                                                                // 커뮤니티 리스트 목록 설정(번호=0,작성자=1,등록일=2,조회수=3)
$BOARD_INFO['PHOTO']['bi_datalist_field_use'][0]                       = "N";                                                                // 커뮤니티 리스트 목록 설정(번호=0,작성자=1,등록일=2,조회수=3)
$BOARD_INFO['PHOTO']['bi_datalist_writer_show'][0]                     = "N";                                                                // 커뮤니티 리스트 작성자 표시 방법([0]=성명,[1]=아이디)
$BOARD_INFO['PHOTO']['bi_datalist_writer_show'][1]                     = "N";                                                                // 커뮤니티 리스트 작성자 표시 방법([0]=성명,[1]=아이디)
$BOARD_INFO['PHOTO']['bi_datalist_writer_hidden']                      = "";                                                                 // 커뮤니티 리스트 작성자 부분 숨김(갯수)
$BOARD_INFO['PHOTO']['bi_dataview_use']                                = "A";                                                                // 커뮤니티 보기 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)
$BOARD_INFO['PHOTO']['bi_dataview_member_auth'][0]                     = "N";                                                                // 커뮤니티 보기 사용 권한(일반회원, 관리자회원, 공급사회원)
$BOARD_INFO['PHOTO']['bi_dataview_member_auth'][1]                     = "N";                                                                // 커뮤니티 보기 사용 권한(일반회원, 관리자회원, 공급사회원)
$BOARD_INFO['PHOTO']['bi_dataview_twitter_use']                        = "Y";                                                                // 트위터 사용
$BOARD_INFO['PHOTO']['bi_dataview_facebook_use']                       = "Y";                                                                // 페이스북 사용
$BOARD_INFO['PHOTO']['bi_dataview_m2day_use']                          = "";                                                                 // 미투데이
$BOARD_INFO['PHOTO']['bi_datawrite_use']                               = "M";                                                                // 커뮤니티 쓰기/수정 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)
$BOARD_INFO['PHOTO']['bi_datawrite_member_auth'][0]                    = "N";                                                                // 커뮤니티 보기 사용 권한(일반회원, 관리자회원, 공급사회원)
$BOARD_INFO['PHOTO']['bi_datawrite_member_auth'][1]                    = "N";                                                                // 커뮤니티 보기 사용 권한(일반회원, 관리자회원, 공급사회원)
$BOARD_INFO['PHOTO']['bi_datawrite_notice_use']                        = "Y";                                                                // 공지글 사용(사용=Y, 사용안함=N)
$BOARD_INFO['PHOTO']['bi_datawrite_lock_use']                          = "";                                                                 // 비밀글 사용(사용자선택=C.무조건=E,사용안함=N or '')
$BOARD_INFO['PHOTO']['bi_datawrite_form']                              = "textWrite";                                                        // 글쓰기 폼(텍스트폼=textWrite, 에디터폼=editWrite)
$BOARD_INFO['PHOTO']['bi_datawrite_icon_use']                          = "";                                                                 // 아이콘(사용=Y, 사용안함=N)
$BOARD_INFO['PHOTO']['bi_datawrite_end_move']                          = "dataList";                                                         // 글쓰기 완료 후, 이동경로(목록화면, 글쓰기화면, 상세보기화면)
$BOARD_INFO['PHOTO']['bi_datadelete_use']                              = "M";                                                                // 커뮤니티 삭제/기타 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)
$BOARD_INFO['PHOTO']['bi_datadelete_member_auth'][0]                   = "N";                                                                // 커뮤니티 삭제 사용 권한(일반회원, 관리자회원, 공급사회원)
$BOARD_INFO['PHOTO']['bi_datadelete_member_auth'][1]                   = "N";                                                                // 커뮤니티 삭제 사용 권한(일반회원, 관리자회원, 공급사회원)
$BOARD_INFO['PHOTO']['bi_datamodify_use']                              = "M";                                                                // 커뮤니티 수정 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)
$BOARD_INFO['PHOTO']['bi_datamodify_member_auth'][0]                   = "N";                                                                // 커뮤니티 수정 사용 권한(일반회원, 관리자회원, 공급사회원)
$BOARD_INFO['PHOTO']['bi_datamodify_member_auth'][1]                   = "N";                                                                // 커뮤니티 수정 사용 권한(일반회원, 관리자회원, 공급사회원)
$BOARD_INFO['PHOTO']['bi_attachedfile_use']                            = "1";                                                                // 커뮤니티 첨부파일 사용(사용=1/2/3/4..., 사용안함=0)
$BOARD_INFO['PHOTO']['bi_attachedfile_name'][0]                        = "목록이미지";                                                  // 커뮤니티 첨부파일 이름
$BOARD_INFO['PHOTO']['bi_attachedfile_name'][1]                        = "";                                                                 // 커뮤니티 첨부파일 이름
$BOARD_INFO['PHOTO']['bi_attachedfile_name'][2]                        = "";                                                                 // 커뮤니티 첨부파일 이름
$BOARD_INFO['PHOTO']['bi_attachedfile_name'][3]                        = "";                                                                 // 커뮤니티 첨부파일 이름
$BOARD_INFO['PHOTO']['bi_attachedfile_name'][4]                        = "";                                                                 // 커뮤니티 첨부파일 이름
$BOARD_INFO['PHOTO']['bi_attachedfile_key'][0]                         = "listImage";                                                        // 커뮤니티 첨부파일 키(file, image, movie..)
$BOARD_INFO['PHOTO']['bi_attachedfile_key'][1]                         = "file";                                                             // 커뮤니티 첨부파일 키(file, image, movie..)
$BOARD_INFO['PHOTO']['bi_attachedfile_key'][2]                         = "file";                                                             // 커뮤니티 첨부파일 키(file, image, movie..)
$BOARD_INFO['PHOTO']['bi_attachedfile_key'][3]                         = "file";                                                             // 커뮤니티 첨부파일 키(file, image, movie..)
$BOARD_INFO['PHOTO']['bi_attachedfile_key'][4]                         = "file";                                                             // 커뮤니티 첨부파일 키(file, image, movie..)
$BOARD_INFO['PHOTO']['bi_userfield_use']                               = "";                                                                 // 커뮤니티 추가필드 사용(사용=Y 사용안함=N)
$BOARD_INFO['PHOTO']['bi_userfield_field_use']                         = "";                                                                 // 커뮤니티 추가필드 필드 사용(사용=Y 사용안함=N)
$BOARD_INFO['PHOTO']['bi_userfield_name']                              = "";                                                                 // 커뮤니티 추가필드 이름
$BOARD_INFO['PHOTO']['bi_userfield_sort']                              = "";                                                                 // 커뮤니티 추가필드 정렬
$BOARD_INFO['PHOTO']['bi_dataanswer_use']                              = "N";                                                                // 커뮤니티 답변 사용(사용=Y, 모든회원/비회원=A, 회원전용=M, 사용안함=N)
$BOARD_INFO['PHOTO']['bi_dataanswer_member_auth'][0]                   = "N";                                                                // 커뮤니티 답변 사용 권한(일반회원, 관리자회원, 공급사회원)
$BOARD_INFO['PHOTO']['bi_dataanswer_member_auth'][1]                   = "N";                                                                // 커뮤니티 답변 사용 권한(일반회원, 관리자회원, 공급사회원)
/*@ boardModifyBasic @*/
/*@ boardModifyCategory @*/
$BOARD_INFO['PHOTO']['bi_category_use']                                = "";                                                                 // 카테고리 사용(사용=Y, 사용안함=N)
$BOARD_INFO['PHOTO']['bi_category_skin']                               = "";                                                                 // 카테고리 스킨(텍스트=text, 이미지=image, 콤보박스=combobox)
/*@ boardModifyCategory @*/
/*@ boardModifyPoint @*/
$BOARD_INFO['PHOTO']['bi_point_use']                                   = "";                                                                 // 포인트사용(사용=Y, 사용안함=N)
$BOARD_INFO['PHOTO']['bi_point_w_use']                                 = "";                                                                 // 글쓰기시 포인트지급(사용=Y, 사용안함=N)
$BOARD_INFO['PHOTO']['bi_point_w_give']                                = "";                                                                 // 글쓰기시 포인트지급방법(자동=A, 수동=M)
$BOARD_INFO['PHOTO']['bi_point_w_mark']                                = "";                                                                 // 글쓰기시 포인트
$BOARD_INFO['PHOTO']['bi_coupon_w_use']                                = "";                                                                 // 글쓰기시 쿠폰지급사용(사용=Y, 사용안함=N)
$BOARD_INFO['PHOTO']['bi_coupon_w_give']                               = "";                                                                 // 글쓰기시 쿠폰지급방법(자동=A, 수동=M)
$BOARD_INFO['PHOTO']['bi_coupon_w_mark']                               = "";                                                                 // 글쓰기시 쿠폰
$BOARD_INFO['PHOTO']['bi_point_c_use']                                 = "";                                                                 // 댓글 포인트지급사용(사용=Y, 사용안함=N)
$BOARD_INFO['PHOTO']['bi_point_c_give']                                = "";                                                                 // 댓글 포인트지급방법(자동=A, 수동=M)
$BOARD_INFO['PHOTO']['bi_point_c_mark']                                = "";                                                                 // 댓글 포인트
$BOARD_INFO['PHOTO']['bi_coupon_c_use']                                = "";                                                                 // 댓글 쿠폰지급사용(사용=Y, 사용안함=N)
$BOARD_INFO['PHOTO']['bi_coupon_c_give']                               = "";                                                                 // 댓글 쿠폰지급방법(자동=A, 수동=M)
$BOARD_INFO['PHOTO']['bi_coupon_c_mark']                               = "";                                                                 // 댓글 쿠폰 이름
$BOARD_INFO['PHOTO']['bi_coupon_c_coupon']                             = "";                                                                 // 댓글 쿠폰 번호
$BOARD_INFO['PHOTO']['bi_point_w_multi_count']                         = "";                                                                 // 글쓰기 차등 포인트 지급 개수
$BOARD_INFO['PHOTO']['bi_point_w_multi_title']                         = "";                                                                 // 글쓰기 차등 포인트 제목
$BOARD_INFO['PHOTO']['bi_point_w_multi_point']                         = "";                                                                 // 글쓰기 차등 포인트 포인트
$BOARD_INFO['PHOTO']['bi_point_w_multi_max']                           = "";                                                                 // 글쓰기 차등 포인트 컬럼 수
$BOARD_INFO['PHOTO']['bi_coupon_w_multi_count']                        = "";                                                                 // 글쓰기 차등 쿠폰 지급 개수
$BOARD_INFO['PHOTO']['bi_coupon_w_multi_title']                        = "";                                                                 // 글쓰기 차등 쿠폼 제목
$BOARD_INFO['PHOTO']['bi_coupon_w_multi_coupon']                       = "";                                                                 // 글쓰기 차등 쿠폰 포인트
$BOARD_INFO['PHOTO']['bi_coupon_w_multi_max']                          = "";                                                                 // 글쓰기 차등 쿠폰 포인트
$BOARD_INFO['PHOTO']['bi_point_c_multi_count']                         = "";                                                                 // 댓글 글쓰기 차등 포인트 지급 개수
$BOARD_INFO['PHOTO']['bi_point_c_multi_title']                         = "";                                                                 // 댓글 글쓰기 차등 포인트 제목
$BOARD_INFO['PHOTO']['bi_point_c_multi_point']                         = "";                                                                 // 댓글 글쓰기 차등 포인트 포인트
$BOARD_INFO['PHOTO']['bi_point_c_multi_max']                           = "";                                                                 // 댓글 글쓰기 차등 포인트 컬럼 수
$BOARD_INFO['PHOTO']['bi_coupon_c_multi_count']                        = "";                                                                 // 댓글 글쓰기 차등 쿠폰 지급 개수
$BOARD_INFO['PHOTO']['bi_coupon_c_multi_title']                        = "";                                                                 // 댓글 글쓰기 차등 쿠폼 제목
$BOARD_INFO['PHOTO']['bi_coupon_c_multi_coupon']                       = "";                                                                 // 댓글 글쓰기 차등 쿠폰 포인트
$BOARD_INFO['PHOTO']['bi_coupon_c_multi_max']                          = "";                                                                 // 댓글 글쓰기 차등 쿠폰 지급 개수
/*@ boardModifyPoint @*/
/*@ boardModifyScriptWidget @*/
$BOARD_INFO['PHOTO']['bi_widget_column_default']                       = "";                                                                 // 세로줄 수
$BOARD_INFO['PHOTO']['bi_widget_list_default']                         = "";                                                                 // 리스트 수
$BOARD_INFO['PHOTO']['bi_widget_datalist_field_use']                   = "";                                                                 // 커뮤니티 리스트 목록 설정(번호=0,작성자=1,등록일=2,조회수=3)
$BOARD_INFO['PHOTO']['bi_widget_datalist_title_len']                   = "";                                                                 // WIDGET 타이틀 자리수
$BOARD_INFO['PHOTO']['bi_widget_skin']                                 = "";                                                                 // WIDGET SKIN
$BOARD_INFO['PHOTO']['bi_widget_datawrite_end_move']                   = "";                                                                 // 글쓰기 완료 후, 이동경로(닫기, 목록화면)
/*@ boardModifyScriptWidget @*/
/*@ boardModifyUserfield @*/
$BOARD_INFO['PHOTO']['bi_userfield_use']                               = "";                                                                 // 커뮤니티 추가필드 사용(사용=Y 사용안함=N)
$BOARD_INFO['PHOTO']['bi_userfield_field_use']                         = "";                                                                 // 커뮤니티 추가필드 필드 사용(사용=Y 사용안함=N)
$BOARD_INFO['PHOTO']['bi_userfield_name']                              = "";                                                                 // 커뮤니티 추가필드 이름
$BOARD_INFO['PHOTO']['bi_userfield_sort']                              = "";                                                                 // 커뮤니티 추가필드 정렬
/*@ boardModifyUserfield @*/
?>
