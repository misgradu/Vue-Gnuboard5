<?php
include_once('./_common.php');

if ($is_guest)
    alert_close('회원만 조회하실 수 있습니다.');

$g5['title'] = get_text($member['mb_nick']).' 님의 포인트 내역';
$list = array();

$sql_common = " from {$g5['point_table']} where mb_id = '".escape_trim($member['mb_id'])."' ";
$sql_order = " order by po_id desc ";

$sql = " select count(*) as cnt {$sql_common} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sum_point1 = $sum_point2 = $sum_point3 = 0;

$sql = " select *
            {$sql_common}
            {$sql_order}
            limit {$from_record}, {$rows} ";
$result = sql_query($sql);
$list = array();
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $point1 = $point2 = 0;
    $point_use_class = '';
    if ($row['po_point'] > 0) {
        $point1 = '+' .number_format($row['po_point']);
        $sum_point1 += $row['po_point'];
        $list[$i]['point1'] = $point1;
        $list[$i]['sum_point1'] = $sum_point1;
    } else {
        $point2 = number_format($row['po_point']);
        $sum_point2 += $row['po_point'];
        $point_use_class = 'point_use';
        $list[$i]['point2'] = $point1;
        $list[$i]['sum_point2'] = $sum_point1;
        $list[$i]['point_use_class'] = true;
    }
    $po_content = $row['po_content'];
    $expr = '';
    if($row['po_expired'] == 1)
        $expr = ' txt_expired';
    $row['po_point'] = number_format($row['po_point']);
    $list[$i] = $row;
}
$perPage = G5_IS_MOBILE ? (int)$config['cf_mobile_pages'] : (int)$config['cf_write_pages'];

?>