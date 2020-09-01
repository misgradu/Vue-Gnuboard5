<?php
function login_check($mb, $link, $is_social_login) {
  global $g5, $config;
  $src = '';
  $mb_id = $mb['mb_id'];
  if( $mb_id ){
    $member_img = G5_DATA_PATH.'/member_image/'.substr($mb_id,0,2).'/'.get_mb_icon_name($mb_id).'.gif';
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
  $mb['mb_profile_img'] = $src;
  $mb = unset_data($mb);
  echo json_encode($mb, JSON_UNESCAPED_UNICODE);
  exit;
}
function password_wrong($login, $mb) {
  echo '{ "msg" : "가입된 회원아이디가 아니거나 비밀번호가 틀립니다.\\n비밀번호는 대소문자를 구분합니다."}';
  exit;
}
function logout($link) {
  echo '{ "msg" : "로그아웃에 성공하였습니다."}';
  exit;
}
function vue_alert($msg='', $url='', $error=true, $post=false) {
  global $g5, $config, $member;
  global $is_admin;
  $msg = strip_tags($msg, '<br>');
  $msg = str_replace("<br>", "\\n", $msg);
  echo '{"msg" : "'.$msg.'", "url" : "'.$url.'"}';
  exit;
}
function vue_alert_close($msg, $error=true) {
  global $g5;
  $msg = strip_tags($msg, '<br>');
  $msg = str_replace("<br>", "\\n", $msg);
  echo '{"msg" : "'.$msg.'"}';
  exit;
}
// confirm 창
function vue_confirm($msg, $url1='', $url2='', $url3='') {
  global $g5;
  if (!$msg) {
    $msg = '올바른 방법으로 이용해 주십시오.';
    alert($msg);
  }
  if(!trim($url1) || !trim($url2)) {
    $msg = $url1.' 과 '.$url2.' 를 지정해 주세요.';
    alert($msg);
  }
  $msg = strip_tags($msg, '<br>');
  $msg = str_replace("<br>", "\\n", $msg);
  if (!$url3) $url3 = clean_xss_tags($_SERVER['HTTP_REFERER']);
  echo '{"msg" : "'.$msg.'"}';
  exit;
}
add_event('alert', 'vue_alert',10,2); 
add_event('alert_close', 'vue_alert_close',10,2); 
add_event('confirm', 'vue_confirm',10,2); 
//글쓰기
function write_update($board, $wr_id, $w, $qstr, $redirect_url) {
  echo '{"redirect_url" : "'.str_replace(G5_URL, '', $redirect_url).'"}';
  exit;
}
function write_comment_update($board, $wr_id, $w, $qstr, $redirect_url, $comment_id, $reply_array) {
  echo '{"redirect_url" : "'.str_replace(G5_URL, '', $redirect_url).'"}';
  exit;
}
function unset_data($data) {
  unset($data['cf_icode_id']);
  unset($data['cf_icode_pw']);
  unset($data['cf_googl_shorturl_apikey']);
  unset($data['cf_google_clientid']);
  unset($data['cf_google_secret']);
  unset($data['cf_icode_server_ip']);
  unset($data['cf_icode_server_port']);
  unset($data['cf_icode_token_key']);
  unset($data['cf_icode_token_key']);
  unset($data['config']['cf_icode_id']);
  unset($data['config']['cf_icode_pw']);
  unset($data['config']['cf_googl_shorturl_apikey']);
  unset($data['config']['cf_google_clientid']);
  unset($data['config']['cf_google_secret']);
  unset($data['config']['cf_icode_server_ip']);
  unset($data['config']['cf_icode_server_port']);
  unset($data['config']['cf_icode_token_key']);
  unset($data['config']['cf_icode_token_key']);
  unset($data['member']['mb_password']);
  unset($data['ss_name']);
  unset($data['sst']);
  unset($data['stx']);
  unset($data['sql']);
  unset($data['sql2']);
  unset($data['sql3']);
  unset($data['sql_search']);
  unset($data['sql_common']);
  unset($data['sql_order']);
  unset($data['write']['wr_password']);
  unset($data['result']);
  unset($data['config']['cf_recaptcha_secret_key']);
  unset($data['config']['cf_recaptcha_site_key']);
  if(is_array($data['list'])){
    for ($i=0; $i < count($data['list']); $i++) { 
      unset($data['list'][$i]['wr_ip']);
      unset($data['list'][$i]['wr_password']);
    }
  }
  unset($data['view']['wr_password']);
  unset($data['view']['wr_ip']);
  return $data;
}
function delete_all($tmp_array, $board) {
  global $bo_table, $page, $qstr;
  $redirect_url = short_url_clean(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&page='.$page.$qstr);
  echo '{"redirect_url" : "'.str_replace(G5_URL, '', $redirect_url).'"}';
  exit;
}
function delete($write, $board) {
  global $bo_table, $page, $qstr;
  $redirect_url = short_url_clean(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&page='.$page.$qstr);
  echo '{"redirect_url" : "'.str_replace(G5_URL, '', $redirect_url).'"}';
  exit;
}
function delete_comment($comment_id, $board) {
  global $bo_table, $page, $qstr,$write;
  $redirect_url = short_url_clean(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$_POST['wr_id'].'&amp;page='.$page. $qstr);
  echo '{"redirect_url" : "'.str_replace(G5_URL, '', $redirect_url).'"}';
  exit;
}
function VueCaptcha(){
  global $config;
  if($config['cf_captcha'] == "kcaptcha") {
    include_once(G5_PLUGIN_PATH.'/kcaptcha/kcaptcha_config.php');
    while(true){
      $keystring='';
      for($i=0;$i<$length;$i++){
          $keystring.=$allowed_symbols[mt_rand(0,strlen($allowed_symbols)-1)];
      }
      if(!preg_match('/cp|cb|ck|c6|c9|rn|rm|mm|co|do|cl|db|qp|qb|dp|ww/', $keystring)) break;
    }
    set_session("ss_captcha_count", 0);
    set_session("ss_captcha_key", $keystring);
    return $keystring;
  }
}
function Vue_move_update($bo_table, $chk_bo_table, $wr_id_list, $opener_href) {
  global $msg;
  echo '{"redirect_url" : "'.str_replace(G5_URL, '', $opener_href).'", "msg" : "'.$msg.'"}';
  exit;
}
function Vue_memo_form_update_after($member_list, $str_nick_list, $redirect_url, $me_memo) {
  alert($str_nick_list." 님께 쪽지를 전달하였습니다.", $redirect_url, false);
}
function Vue_memo_form_update_failed($member_list, $str_nick_list, $redirect_url, $me_memo) {
  alert("회원아이디 오류 같습니다.", $redirect_url, false);
}
?>