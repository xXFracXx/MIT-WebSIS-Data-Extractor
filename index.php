<?php
require('lib.php');
require('extract_data.php');

$base_url = getCurrentUri();
$routes = array();
$routes = explode('/', $base_url);
foreach($routes as $route) {
    if(trim($route) != '')
        array_push($routes, $route);
}
//Now, $routes will contain all the routes. $routes[0] will correspond to first route. For e.g. in above example $routes[0] is search, $routes[1] is book and $routes[2] is fitzgerald

$student_id = $routes[0];
$student_dob = $routes[1];

$post_cred = "idValue=".$student_id."&birthDate_i18n=".$student_dob."&birthDate=".$student_dob;

$login_url = "http://websismit.manipal.edu/websis/control/createAnonSession";

login($login_url, $post_cred);

//$student_summary = "http://websismit.manipal.edu/websis/control/StudentAcademicProfile";
$student_latest_enrollment = "http://websismit.manipal.edu/websis/control/ListCTPEnrollment";

$data_page = grab_page($student_latest_enrollment); //echo $page;
$data_html = str_get_html($data_page);

if($routes[2] == "marks") {
    if($routes[3] == "IA1") {
        $data = get_IA1_data($data_html);
    } else if($routes[3] == "IA2") {
        $data = get_IA2_data($data_html);
    } else if($routes[3] == "IA3") {
        $data = get_IA3_data($data_html);
    }
} else if($routes[2] == "attendance") {
    $data = get_attendance_data($data_html);
} else if($routes[2] == "course") {
    $data = get_course_data($data_html);
}

echo $_SERVER['REQUEST_URI'];
echo nl2br("\n");
echo $routes[0];
echo nl2br("\n");
echo $routes[1];
echo nl2br("\n");
echo $routes[2];
echo nl2br("\n");
echo $routes[3];
echo nl2br("\n\n");

$json = json_encode($data, JSON_PRETTY_PRINT);
printf('<pre>%s</pre>', $json)

?>
