<?php
require('lib.php');
require('extract_data.php');
require('postgres_conn.php');

$base_url = $_SERVER['REQUEST_URI'];
$routes = array();
$routes = explode('/', $base_url);
foreach($routes as $route) {
    if(trim($route) != '')
        array_push($routes, $route);
}

if($routes[1] == "postgresTest") {
    test_pg_conn();
}

$student_id = $routes[1];
$student_dob = $routes[2];

$post_cred = "idValue=".$student_id."&birthDate_i18n=".$student_dob."&birthDate=".$student_dob;

$login_url = "http://websismit.manipal.edu/websis/control/createAnonSession";

login($login_url, $post_cred);

//$student_summary = "http://websismit.manipal.edu/websis/control/StudentAcademicProfile";
$student_latest_enrollment = "http://websismit.manipal.edu/websis/control/ListCTPEnrollment";

$data_page = grab_page($student_latest_enrollment); //echo $page;
$data_html = str_get_html($data_page);

if($routes[3] == "marks") {
    if($routes[4] == "IA1") {
        $data = get_IA1_data($data_html);
        dispjSON($data);
    } else if($routes[4] == "IA2") {
        $data = get_IA2_data($data_html);
        dispjSON($data);
    } else if($routes[4] == "IA3") {
        $data = get_IA3_data($data_html);
        dispjSON($data);
    }
} else if($routes[3] == "attendance") {
    $data = get_attendance_data($data_html);
    dispjSON($data);
} else if($routes[3] == "course") {
    $data = get_course_data($data_html);
    dispjSON($data);
}
?>
