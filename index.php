<?php
require('php/lib.php');
require('php/extract_data.php');
require('php/postgres_conn.php');

$date = date('Y/m/d');
$current_date = array();
$current_date[1] = substr($date, 0, 4);
$current_date[2] = substr($date, 5, 2);
$current_date[3] = substr($date, 8, 2);

$base_url = $_SERVER['REQUEST_URI'];
$routes = array();
$routes = explode('/', $base_url);
foreach($routes as $route) {
    if(trim($route) != '')
        array_push($routes, $route);
}

if($routes[1] == "test") {
    //test stuff
    exit();
}

if($routes[1] == "postgresTest") {
    test_pg_conn();
    exit();
}

$student_id = $routes[1];
$student_dob = $routes[2];

$post_cred = "idValue=".$student_id."&birthDate_i18n=".$student_dob."&birthDate=".$student_dob;

$login_url = "http://websismit.manipal.edu/websis/control/createAnonSession";

login($login_url, $post_cred);

$student_summary = "http://websismit.manipal.edu/websis/control/StudentAcademicProfile";
//$student_latest_enrollment = "http://websismit.manipal.edu/websis/control/ListCTPEnrollment";

$data_page = grab_page($student_summary); //echo $page;
$data_html = str_get_html($data_page);

if($routes[3] == "testAfterLogin") {
    //test stuff
    exit();
}

if(checkLogin($data_html) == FALSE) {
    print "Invalid Credentials";
    exit();
} else {
    $is_new_user = addStudentInfoToDB($student_id,$student_dob);
    //$existing_info = grabExistingData($student_id);

    $student_yr = substr($student_id, 0, 2);

    $latest_sem = findCurrentSem($student_yr, $current_date);
    if($routes[4] == "latest") {
        $requested_sem = $latest_sem;
    } else {
        $requested_sem = $routes[4];
    }

    if(!($requested_sem <= $latest_sem && $requested_sem > 0)) {
        echo "Invalid semester request!";
        exit();
    }

    $links = genLinks($student_yr, $latest_sem);

    $final_link = "http://websismit.manipal.edu/websis/control/ListCTPEnrollment?customTimePeriodId=".$links[$requested_sem];
    $data_page = grab_page($final_link);
    $data_html = str_get_html($data_page);

    if($routes[3] == "semester") {
        if($routes[5] == "attendance") {
            $data = get_attendance_data($data_html);
            dispData($data);
        } else if($routes[5] == "course") {
            $data = get_course_data($data_html);
            dispData($data);
        } else if($routes[5] == "marks") {
            if($routes[6] == "IA1") {
                $data = get_IA1_data($data_html);
                dispData($data);
            } else if($routes[6] == "IA2") {
                $data = get_IA2_data($data_html);
                dispData($data);
            } else if($routes[6] == "IA3") {
                $data = get_IA3_data($data_html);
                dispData($data);
            }
        }
    }

    // if($is_new_user == TRUE) {
    //     $sem_count = $latest_sem;
    //     while($sem_count > 0) {
    //
    //     }
    //
    // }

    echo $is_new_user;
}
exit();
?>
