<?php
include_once('./_common.php');
include_once('./hook.lib.php');
//include_once(G5_LIB_PATH.'/outlogin.lib.php');
//include_once(G5_LIB_PATH.'/poll.lib.php');
//include_once(G5_LIB_PATH.'/visit.lib.php');
//include_once(G5_LIB_PATH.'/connect.lib.php');
//include_once(G5_LIB_PATH.'/popular.lib.php');

class Vue { 
  function __construct() {
    $this->title = isset($_POST['title']) ? $_POST['title'] : null;
    $this->get_menu_db = isset($_POST['get_menu_db']) ? $_POST['get_menu_db'] : null;
    $this->latest = isset($_POST['latest']) ? $_POST['latest'] : null;
    $this->view = isset($_POST['view']) ? $_POST['view'] : null;
    $this->list = isset($_POST['list']) ? $_POST['list'] : null;
    $this->login = isset($_POST['login']) ? $_POST['login'] : null;
    $this->logout = isset($_POST['logout']) ? $_POST['logout'] : null;
    $this->isLogin = isset($_POST['isLogin']) ? $_POST['isLogin'] : null;
    $this->write = isset($_POST['write']) ? $_POST['write'] : null;
    $this->write_token = isset($_POST['write_token']) ? $_POST['write_token'] : null;
    $this->write_update = isset($_POST['write_update']) ? $_POST['write_update'] : null;
    $this->register = isset($_POST['register']) ? $_POST['register'] : null;
    $this->register_form = isset($_POST['register_form']) ? $_POST['register_form'] : null;
    $this->register_form_update = isset($_POST['register_form_update']) ? $_POST['register_form_update'] : null;
    $this->register_form_valid = isset($_POST['register_form_valid']) ? $_POST['register_form_valid'] : null;
    $this->write_comment_token = isset($_POST['write_comment_token']) ? $_POST['write_comment_token'] : null;
    $this->write_comment_update = isset($_POST['write_comment_update']) ? $_POST['write_comment_update'] : null;
    $this->vote = isset($_POST['vote']) ? $_POST['vote'] : null;
    $this->download = isset($_POST['download']) ? $_POST['download'] : null;
    $this->view_comment = isset($_POST['view_comment']) ? $_POST['view_comment'] : null;
    $this->board_list_update = isset($_POST['board_list_update']) ? $_POST['board_list_update'] : null;
    $this->move = isset($_POST['move']) ? $_POST['move'] : null;
    $this->move_update = isset($_POST['move_update']) ? $_POST['move_update'] : null;
    $this->copy = isset($_POST['copy']) ? $_POST['move'] : null;
    $this->faq = isset($_POST['faq']) ? $_POST['faq'] : null;
    $this->delete = isset($_POST['delete']) ? $_POST['delete'] : null;
    $this->delete_comment = isset($_POST['delete_comment']) ? $_POST['delete_comment'] : null;
    $this->content = isset($_POST['content']) ? $_POST['content'] : null;
    $this->fsearch = isset($_POST['fsearch']) ? $_POST['fsearch'] : null;
    $this->new = isset($_POST['new']) ? $_POST['new'] : null;
    $this->memo = isset($_POST['memo']) ? $_POST['memo'] : null;
    $this->memo_form_update = isset($_POST['memo_form_update']) ? $_POST['memo_form_update'] : null;
    $this->scrap = isset($_POST['scrap']) ? $_POST['scrap'] : null;
    $this->scrap_delete = isset($_POST['scrap_delete']) ? $_POST['scrap_delete'] : null;
    $this->password = isset($_POST['password']) ? $_POST['password'] : null;
    $this->password_check = isset($_POST['password_check']) ? $_POST['password_check'] : null;
    $this->f_scrap_popin_update = isset($_POST['f_scrap_popin_update']) ? $_POST['f_scrap_popin_update'] : null;
    $this->current_connect = isset($_POST['current_connect']) ? $_POST['current_connect'] : null;
    $this->captcha = isset($_POST['captcha']) ? $_POST['captcha'] : null;
    $this->point = isset($_POST['point']) ? $_POST['point'] : null;
    $this->visit = isset($_POST['visit']) ? $_POST['visit'] : null;
    $this->poll = isset($_POST['poll']) ? $_POST['poll'] : null;
    $this->poll_update = isset($_POST['poll_update']) ? $_POST['poll_update'] : null;
    $this->poll_result = isset($_POST['poll_result']) ? $_POST['poll_result'] : null;
  }
  public function result() {
    global $g5, $board, $board_skin_path, $wr_seo_title, $bo_table, $config, $member;
    $sql = " select sum(IF(mb_id<>'',1,0)) as mb_cnt, count(*) as total_cnt from {$g5['login_table']}  where mb_id <> '{$config['cf_admin']}' ";
    $row = sql_fetch($sql);
    $data['connect'] = $row;
    if ($this->title){
      $data = array();
      $data['g5_title'] = $config['cf_title'];
      return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK );
    }else if ($this->get_menu_db) {
      $menu_datas = get_menu_db(0, true);
      for ($i=0; $i < count($menu_datas) ; $i++) { 
        $menu_datas[$i]['me_link'] = str_replace(G5_URL, '' , $menu_datas[$i]['me_link']);
        if($menu_datas[$i]['sub']) {
          for ($k=0; $k < count($menu_datas[$i]['sub']); $k++) { 
            $menu_datas[$i]['sub'][$k]['me_link'] = str_replace(G5_URL, '' , $menu_datas[$i]['sub'][$k]['me_link']);
          }
        }
      }
      return json_encode($menu_datas, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK );
    }else if ($this->write) {
      //$bo_table = isset($_POST['bo_table']) ? $_POST['bo_table'] : null;
      @extract($_POST);
      @extract($_GET);
      include_once('./board/board_common.php');
      include_once('./board/write.php');
      $data['title'] = $g5['title'];
      $data = unset_data($data);
      return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK );
    }else if ($this->write_token) {
      include_once(G5_BBS_PATH.'/write_token.php');
    }else if ($this->write_update) {
      @extract($_POST);
      @extract($_GET);
      include_once('./board/board_common.php');
      add_event('write_update_after', 'write_update',10,5); 
      include_once(G5_BBS_PATH.'/write_update.php');
    }else if ($this->isLogin) {
      $src = '';
      if( $member['mb_id'] ){
        $member_img = G5_DATA_PATH.'/member_image/'.substr($member['mb_id'],0,2).'/'.get_mb_icon_name($member['mb_id']).'.gif';
        if (is_file($member_img)) {
          $src = str_replace(G5_DATA_PATH, G5_DATA_URL, $member_img);
        }
      }
      if( !$src ){
        // 프로필 이미지가 없을때 기본 이미지
        $no_profile_img = (defined('G5_THEME_NO_PROFILE_IMG') && G5_THEME_NO_PROFILE_IMG) ? G5_THEME_NO_PROFILE_IMG : G5_NO_PROFILE_IMG;
        $tmp = array();
        preg_match( '/src="([^"]*)"/i', $no_profile_img, $tmp );
        $src = isset($tmp[1]) ? $tmp[1] : G5_IMG_URL.'/no_profile.gif';    
      }
      $member['mb_profile_img'] = $src;
      return json_encode($member, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK );
    }else if($this->login) {
      add_event('member_login_check', 'login_check',10,3); 
      add_event('password_is_wrong', 'password_wrong',10,2); 
      include_once G5_BBS_PATH."/login_check.php";
    }else if($this->logout){
      add_event('member_logout', 'logout',10,1); 
      include_once G5_BBS_PATH."/logout.php";
    }else if($this->latest) {
      $bo_table = isset($_POST['bo_table']) ? $_POST['bo_table'] : null;
      $rows = isset($_POST['rows']) ? $_POST['rows'] : null;
      $subject_len = isset($_POST['subject_len']) ? $_POST['subject_len'] : null;
      return json_encode($this->latest($bo_table, $rows, $subject_len), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK );
    }else if($this->list){
      $sca = isset($_GET['sca']) ? $_GET['sca'] : null;
      @extract($_GET);
      $page = isset($_GET['page']) ? (int)$_GET['page'] : null;
      include_once('./board/board_common.php');
      include_once('./board/board.php');
      $data = unset_data($data);
      return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK , JSON_NUMERIC_CHECK);
    }else if($this->view) {
      include_once('./board/board_common.php');
      include_once('./board/board.php');
      $data = unset_data($data);
      return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK );
    }else if ($this->view_comment) {
      $bo_table = isset($_POST['bo_table']) ? $_POST['bo_table'] : null;
      include_once('./board/board_common.php');
      include_once('./board/view_comment.php');
      $data['title'] = $g5['title'];
      $data = unset_data($data);
      return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK );
    }else if($this->vote) {
      @extract($_POST);
      include_once('./board/board_common.php');
      include_once(G5_BBS_PATH.'/good.php');
    }else if ($this->write_comment_token) {
      include_once(G5_BBS_PATH.'/ajax.comment_token.php');
    }else if ($this->write_comment_update) {
      include_once('./board/board_common.php');
      @extract($_POST);
      add_event('comment_update_after', 'write_comment_update',10,7); 
      include_once(G5_BBS_PATH.'/write_comment_update.php');
    }else if ($this->register) {
      @extract($_POST);
      $arr = get_defined_vars();
      foreach ( $arr as $key => $value ) {
        $data[$key] = $value;
      }
      $data['title'] = '회원가입약관';
      $data = unset_data($data);
      return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK );      
    }else if ($this->register_form) {
      @extract($_POST);
      include_once('./board/board_common.php');
      include_once('./member/register_form.php');
      $arr = get_defined_vars();
      foreach ( $arr as $key => $value ) {
        $data[$key] = $value;
      }
      $data = unset_data($data);
      return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK );      
    }else if ($this->register_form_update) {
      @extract($_POST);
      //include_once('./board/board_common.php');
      include_once('./member/register_form_update.php');
      $arr = get_defined_vars();
      foreach ( $arr as $key => $value ) {
        $data[$key] = $value;
      }
      $data = unset_data($data);
      return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK );      
    }else if ($this->register_form_valid) {
      include_once(G5_LIB_PATH."/register.lib.php");
      @extract($_POST);
      $mb_nick = trim($_POST['reg_mb_nick']);
      $mb_hp   = trim($_POST['reg_mb_hp']);
      $mb_email = trim($_POST['reg_mb_email']);
      $mb_id   = trim($_POST['reg_mb_id']);
      $mb_recommend = trim($_POST["reg_mb_recommend"]);
      if($reg_mb_recommend_check == true) {
        if ($msg = valid_mb_id($mb_recommend)) {
          alert("추천인의 아이디는 영문자, 숫자, _ 만 입력하세요.");
        }
        if (!($msg = exist_mb_id($mb_recommend))) {
          alert("입력하신 추천인은 존재하지 않는 아이디 입니다.");
        }
        echo '{"success" : "'.$mb_recommend.'"}';
      }
      if($reg_mb_nick_check == true) {
        set_session('ss_check_mb_nick', '');
        if ($msg = empty_mb_nick($mb_nick)) alert($msg);
        if ($msg = valid_mb_nick($mb_nick)) alert($msg);
        if ($msg = count_mb_nick($mb_nick)) alert($msg);
        if ($msg = exist_mb_nick($mb_nick, $mb_id)) alert($msg);
        if ($msg = reserve_mb_nick($mb_nick)) alert($msg);
        set_session('ss_check_mb_nick', $mb_nick);
        echo '{"success" : "'.$mb_nick.'"}';
      }
      if($reg_mb_hp_check == true) {
        if ($msg = valid_mb_hp($mb_hp)) alert($msg);
        echo '{"success" : "'.$mb_hp.'"}';
      }
      if($reg_mb_email_check == true){
        set_session('ss_check_mb_email', '');
        if ($msg = empty_mb_email($mb_email)) alert($msg);
        if ($msg = valid_mb_email($mb_email)) alert($msg);
        if ($msg = prohibit_mb_email($mb_email)) alert($msg);
        if ($msg = exist_mb_email($mb_email, $mb_id)) alert($msg);
        set_session('ss_check_mb_email', $mb_email);
        echo '{"success" : "'.$mb_email.'"}';
      }
      if($reg_mb_id_check == true){
        set_session('ss_check_mb_id', '');
        if ($msg = empty_mb_id($mb_id))     alert($msg);
        if ($msg = valid_mb_id($mb_id))     alert($msg);
        if ($msg = count_mb_id($mb_id))     alert($msg);
        if ($msg = exist_mb_id($mb_id))     alert($msg);
        if ($msg = reserve_mb_id($mb_id))   alert($msg);
        set_session('ss_check_mb_id', $mb_id);
        echo '{"success" : "'.$mb_id.'"}';
      }
    }else if ($this->content) {
      @extract($_POST);
      include_once('./content/content.php');
      $data = unset_data($data);
      return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK );      
    }else if ($this->board_list_update) {
      include_once('./board/board_common.php');
      @extract($_POST);
      add_event('bbs_delete_all', 'delete_all',10,2); 
      $count = $_POST['chk_wr_id'] ? count($_POST['chk_wr_id']) : 1;
      if(!$count) {
        alert($_POST['btn_submit'].' 하실 항목을 하나 이상 선택하세요.');
      }
      if ($wr_id) $wr_id_list = $wr_id;
      if($_POST['btn_submit'] == '선택삭제') {
        include G5_BBS_PATH.'/delete_all.php';
      } else if($_POST['btn_submit'] == '선택복사') {  
        include './board/move.php';
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK );
      } else if($_POST['btn_submit'] == '선택이동') {
        include './board/move.php';
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK );
      } else {
        alert('올바른 방법으로 이용해 주세요.');
      }
    }else if ($this->move_update) {
      include_once('./board/board_common.php');
      @extract($_POST);
      add_event('bbs_move_update', 'Vue_move_update', 10 , 4); 
      include_once(G5_BBS_PATH.'/move_update.php');
    }else if ($this->faq) {
      include_once('./board/board_common.php');
      @extract($_POST);
      include_once('./faq/faq.php');
      $data = unset_data($data);
      return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK );      
    }else if ($this->delete) {
      @extract($_POST);
      @extract($_GET);
      include_once('./board/board_common.php');
      @extract($_POST);
      @extract($_GET);
      add_event('bbs_delete', 'delete',10,2); 
      include_once(G5_BBS_PATH.'/delete.php');
    }else if ($this->delete_comment) {
      @extract($_POST);
      @extract($_GET);
      include_once('./board/board_common.php');
      @extract($_POST);
      @extract($_GET);
      $write = sql_fetch(" select * from {$write_table} where wr_id = '{$comment_id}' ");
      add_event('bbs_delete_comment', 'delete_comment',10,2); 
      include_once(G5_BBS_PATH.'/delete_comment.php');
    }else if ($this->move || $this->copy) {
      @extract($_POST);
      include_once('./board/board_common.php');      
      include_once('./board/move.php');
      return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK );      
    }else if ($this->download) {
      @extract($_POST);
      include_once('./board/board_common.php');      
      include G5_BBS_PATH.'/download.php';
    }else if ($this->fsearch) {
      @extract($_POST);
      @extract($_GET);
      $page = isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : null;
      //include_once('./board/board_common.php');      
      include_once('./board/search.php');      
      return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK );
    }else if ($this->new) {
      @extract($_POST);
      @extract($_GET);
      $page = isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : null;
      //include_once('./board/board_common.php');      
      include_once('./board/new.php');      
      return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK );
    }else if ($this->memo) {
      @extract($_POST);
      @extract($_GET);
      $page = isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : null;
      //include_once('./board/board_common.php');
      if($kind == "memo_form"){
        include_once('./board/memo_form.php');      
      }else {
        include_once('./board/memo.php');      
      }
      return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK );
    }else if ($this->memo_form_update) {
      include G5_BBS_PATH.'/memo_form_update.php';
    }else if ($this->scrap) {
      @extract($_POST);
      @extract($_GET);
      $page = isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : null;
      include_once('./board/board_common.php');      
      include_once('./board/scrap.php');      
      return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK );
    }else if($this->scrap_delete) {
      include_once('./board/board_common.php');      
      @extract($_POST);
      @extract($_GET);
      if (!$is_member)
      alert('회원만 이용하실 수 있습니다.');
      $sql = " delete from {$g5['scrap_table']} where mb_id = '{$member['mb_id']}' and ms_id = '$ms_id' ";
      sql_query($sql);
      $sql = " update `{$g5['member_table']}` set mb_scrap_cnt = '".get_scrap_totals($member['mb_id'])."' where mb_id = '{$member['mb_id']}' ";
      sql_query($sql);
      alert('삭제하였습니다');
    }else if ($this->password) {
      @extract($_POST);
      @extract($_GET);
      include_once('./board/password.php');    
      return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK );  
    }else if ($this->password_check) {
      @extract($_POST);
      @extract($_GET);
      include_once('./board/board_common.php');
      include_once('./board/password_check.php');
    }else if ($this->f_scrap_popin_update) {
      @extract($_POST);
      @extract($_GET);
      include_once('./board/board_common.php');
      include_once('./board/scrap_popin_update.php');
    }else if ($this->current_connect) {
      include_once('./board/current_connect.php');
      return json_encode($list, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK ); 
    }else if ($this->captcha) {
      $data = array();
      $data['captcha'] = VueCaptcha();
      return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK ); 
    }else if ($this->point) {
      $page = isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : null;
      include_once('./board/point.php');
      $arr = get_defined_vars();
      foreach ( $arr as $key => $value ) {
        $data[$key] = $value;
      }
      $data = unset_data($data);
      return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK );    
    }else if ($this->visit) {
      return json_encode($config['cf_visit'], JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK );    
    }else if ($this->poll) {
      return json_encode($this->poll(), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK );    
    }else if ($this->poll_update) {
      @extract($_POST);
      @extract($_GET);
      include_once('./board/poll_update.php');
    }else if ($this->poll_result) {
      @extract($_POST);
      @extract($_GET);
      include_once('./board/poll_result.php');
      $data = unset_data($data);
      return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK ); 
    }
  }
  //내부 함수

  // 설문조사
  function poll($skin_dir='basic', $po_id=false)
  {
      global $config, $member, $g5, $is_admin;
      // 투표번호가 넘어오지 않았다면 가장 큰(최근에 등록한) 투표번호를 얻는다
      if (!$po_id) {
          $row = sql_fetch(" select MAX(po_id) as max_po_id from {$g5['poll_table']} ");
          $po_id = $row['max_po_id'];
      }
      if(!$po_id)
          return;
      if(preg_match('#^theme/(.+)$#', $skin_dir, $match)) {
          if (G5_IS_MOBILE) {
              $poll_skin_path = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/poll/'.$match[1];
              if(!is_dir($poll_skin_path))
                  $poll_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/poll/'.$match[1];
              $poll_skin_url = str_replace(G5_PATH, G5_URL, $poll_skin_path);
          } else {
              $poll_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/poll/'.$match[1];
              $poll_skin_url = str_replace(G5_PATH, G5_URL, $poll_skin_path);
          }
          //$skin_dir = $match[1];
      } else {
          if (G5_IS_MOBILE) {
              $poll_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/poll/'.$skin_dir;
              $poll_skin_url  = G5_MOBILE_URL.'/'.G5_SKIN_DIR.'/poll/'.$skin_dir;
          } else {
              $poll_skin_path = G5_SKIN_PATH.'/poll/'.$skin_dir;
              $poll_skin_url  = G5_SKIN_URL.'/poll/'.$skin_dir;
          }
      }
      $po = sql_fetch(" select * from {$g5['poll_table']} where po_id = '$po_id' ");
      return $po;
  }
  function latest($bo_table, $rows=10, $subject_len=40, $options='') {
    global $g5;
    $list = array();
    $board = get_board_db($bo_table, true);
    $bo_subject = get_text($board['bo_subject']);
    $tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
    $sql = " select * from {$tmp_write_table} where wr_is_comment = 0 order by wr_num limit 0, {$rows} ";
    
    $result = sql_query($sql);
    for ($i=0; $row = sql_fetch_array($result); $i++) {
      try {
        unset($row['wr_password']);     //패스워드 저장 안함( 아예 삭제 )
        unset($row['wr_ip']);
      } catch (Exception $e) {
      }
      $row['wr_email'] = '';              //이메일 저장 안함
      if (strstr($row['wr_option'], 'secret')){           // 비밀글일 경우 내용, 링크, 파일 저장 안함
          $row['wr_content'] = $row['wr_link1'] = $row['wr_link2'] = '';
          $row['file'] = array('count'=>0);
      }
      $list[$i] = get_list($row, $board, 'theme/pic_list', $subject_len);
      $list[$i]['first_file_thumb'] = (isset($row['wr_file']) && $row['wr_file']) ? get_board_file_db($bo_table, $row['wr_id'], 'bf_file, bf_content', "and bf_type between '1' and '3'", true) : array('bf_file'=>'', 'bf_content'=>'');
      $list[$i]['href'] = str_replace(G5_URL, '', short_url_clean($list[$i]['href']));
      $list[$i]['bo_table'] = $bo_table;
      $list[$i]['bo_subject'] = $bo_subject;
      // 썸네일 추가
      if($options && is_string($options)) {
          $options_arr = explode(',', $options);
          $thumb_width = $options_arr[0];
          $thumb_height = $options_arr[1];
          $thumb = get_list_thumbnail($bo_table, $row['wr_id'], $thumb_width, $thumb_height, false, true);
          // 이미지 썸네일
          if($thumb['src']) {
              $img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" width="'.$thumb_width.'" height="'.$thumb_height.'">';
              $list[$i]['img_thumbnail'] = '<a href="'.$list[$i]['href'].'" class="lt_img">'.$img_content.'</a>';
          }
      }
    }
    if($list) {
      return $list;
    }else {
      return $board;
    }
  }
}
