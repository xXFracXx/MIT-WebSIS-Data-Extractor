<?php
require('lib.php');
require('extract_data.php');

$student_id = "140905025";
$student_dob = "1996-10-06";

$post_cred = "idValue=".$student_id."&birthDate_i18n=".$student_dob."&birthDate=".$student_dob;

$login_url = "http://websismit.manipal.edu/websis/control/createAnonSession";

login($login_url, $post_cred);

//$student_summary = "http://websismit.manipal.edu/websis/control/StudentAcademicProfile";
$student_latest_enrollment = "http://websismit.manipal.edu/websis/control/ListCTPEnrollment";

$data_page = grab_page($student_latest_enrollment); //echo $page;
$data_html = str_get_html($data_page);

$c_data = get_course_data($data_html);
$a_data = get_attendance_data($data_html);
$IA1_data = get_IA1_data($data_html);
$IA2_data = get_IA2_data($data_html);
$IA3_data = get_IA3_data($data_html);

echo json_encode($c_data);
echo nl2br("\n\n\n");
echo json_encode($a_data);
echo nl2br("\n\n\n");
echo json_encode($IA1_data);
echo nl2br("\n\n\n");
echo json_encode($IA2_data);
echo nl2br("\n\n\n");
echo json_encode($IA3_data);

//$temp_c_data = str_replace('$nbsp;', '', $c_data);
//json = json_encode($c_data, JSON_PRETTY_PRINT);
//printf('<pre>%s</pre>', $json)
?>
