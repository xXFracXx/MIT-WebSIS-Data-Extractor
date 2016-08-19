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
// foreach($routes as $route) {
//     if(trim($route) != '')
//         array_push($routes, $route);
// }

$test_code = $_SERVER['HTTP_TESTCODE'];
$should_update = $_SERVER['HTTP_SHOULDUPDATE'];

if($test_code == "test") {
    //test stuff
    exit();
}

if($test_code == "postgresTest") {
    test_pg_conn();
    exit();
}

//$student_id = $routes[1];
//$student_dob = $routes[2];
$student_id = $_SERVER['HTTP_USERNAME'];
$student_dob = $_SERVER['HTTP_PASSWORD'];

$post_cred = "idValue=".$student_id."&birthDate_i18n=".$student_dob."&birthDate=".$student_dob;

$login_url = "http://websismit.manipal.edu/websis/control/createAnonSession";

login($login_url, $post_cred);

$student_summary = "http://websismit.manipal.edu/websis/control/StudentAcademicProfile";
//$student_latest_enrollment = "http://websismit.manipal.edu/websis/control/ListCTPEnrollment";

$data_page = grab_page($student_summary); //echo $page;
$data_html = str_get_html($data_page);

if($test_code == "testAfterLogin") {
    //test stuff
    exit();
}

if($routes[1] == "semester") {
    $student_yr = substr($student_id, 0, 2);

    $latest_sem = findCurrentSem($student_yr, $current_date);
    if($routes[2] == "latest")
        $requested_sem = $latest_sem;
    else
        $requested_sem = $routes[2];

    if(($should_update == "no" || $should_update == "NO" || $should_update == "No") || isWebSISDown()) {
        if($routes[3] == "attendance") {
            $all_data = (array)downloadFromDB($student_id, "attendance");
            $db_sem = "Semester ".$requested_sem;
            $data = $all_data[$db_sem]["attendance"];
            if($data == NULL)
                header($_SERVER["SERVER_PROTOCOL"]." 204 No Content");
            dispData($data);
        } else if($routes[3] == "course") {
            $all_data = (array)downloadFromDB($student_id, "course");
            $db_sem = "Semester ".$requested_sem;
            $data = $all_data[$db_sem]["course"];
            if($data == NULL)
                header($_SERVER["SERVER_PROTOCOL"]." 204 No Content");
            dispData($data);
        } else if($routes[3] == "marks") {
            if($routes[4] == "IA1") {
                $all_data = (array)downloadFromDB($student_id, "marks_ia1");
                $db_sem = "Semester ".$requested_sem;
                $data = $all_data[$db_sem]["marks_ia1"];
                if($data == NULL)
                    header($_SERVER["SERVER_PROTOCOL"]." 204 No Content");
                dispData($data);
            } else if($routes[4] == "IA2") {
                $all_data = (array)downloadFromDB($student_id, "marks_ia2");
                $db_sem = "Semester ".$requested_sem;
                $data = $all_data[$db_sem]["marks_ia2"];
                if($data == NULL)
                    header($_SERVER["SERVER_PROTOCOL"]." 204 No Content");
                dispData($data);
            } else if($routes[4] == "IA3") {
                $all_data = (array)downloadFromDB($student_id, "marks_ia3");
                $db_sem = "Semester ".$requested_sem;
                $data = $all_data[$db_sem]["marks_ia3"];
                if($data == NULL)
                    header($_SERVER["SERVER_PROTOCOL"]." 204 No Content");
                dispData($data);
            }
        } else if($routes[3] == "gcg") {
            $all_data = (array)downloadFromDB($student_id, "gcg");
            $db_sem = "Semester ".$requested_sem;
            $data = $all_data[$db_sem]["gcg"];
            if($data == NULL)
                header($_SERVER["SERVER_PROTOCOL"]." 204 No Content");
            dispData($data);
        }
    } else {
        if(checkLogin($data_html) == FALSE) {
            echo "Invalid Credentials";
            echo $student_id." ".$student_dob;
        } else {
            $is_new_user = addStudentInfoToDB($student_id,$student_dob);

            if($requested_sem > $latest_sem || $requested_sem < 0) {
                echo "Invalid semester request!";
            } else {
                $Semlinks = genSemLinks($student_yr, $latest_sem);

                $request_link = "http://websismit.manipal.edu/websis/control/ListCTPEnrollment?customTimePeriodId=".$Semlinks[$requested_sem];
                $data_page = grab_page($request_link);
                $data_html = str_get_html($data_page);

                if($routes[3] == "attendance") {
                    $data = get_attendance_data($data_html);
                    dispData($data);
                    uploadToDB($data, $student_id, $requested_sem, "attendance");
                } else if($routes[3] == "course") {
                    $data = get_course_data($data_html);
                    dispData($data);
                    uploadToDB($data, $student_id, $requested_sem, "course");
                } else if($routes[3] == "marks") {
                    if($routes[4] == "IA1") {
                        $data = get_IA1_data($data_html);
                        dispData($data);
                        uploadToDB($data, $student_id, $requested_sem, "marks_ia1");
                    } else if($routes[4] == "IA2") {
                        $data = get_IA2_data($data_html);
                        dispData($data);
                        uploadToDB($data, $student_id, $requested_sem, "marks_ia2");
                    } else if($routes[4] == "IA3") {
                        $data = get_IA3_data($data_html);
                        dispData($data);
                        uploadToDB($data, $student_id, $requested_sem, "marks_ia3");
                    }
                } else if($routes[3] == "gcg") {
                    $GCGLinks = genGCGLinks($data_html, $latest_sem);

                    $request_link = "http://websismit.manipal.edu".$GCGLinks[$requested_sem];
                    $data_page = grab_page($request_link);
                    $data_html = str_get_html($data_page);

                    $gr_data = get_grades_data($data_html);
                    $tot_cr_data = $gr_data["total_credits"];
                    unset($gr_data["total_credits"]);
                    $cg_data = get_cg_data($data_html);

                    $data["grades"] = $gr_data;
                    $data["total_credits"] = $tot_cr_data;
                    $data["credits_acquired"] = $cg_data["credits"];
                    $data["gpa_acquired"] = $cg_data["gpa"];

                    dispData($data);
                    uploadToDB($data, $student_id, $requested_sem, "gcg");
                }
            }

            if($is_new_user == TRUE){

            }
        }
    }
} else if($routes[1] == "genNoticeLinks") {
    $data = get_notice_links($data_html);
    dispData($data);
}

//Removes the page & html data variables, MUST ALWAYS BE AT THE END (before varDump if clause)...
unset($data_page, $data_html);

if($test_code == "varDump") {
    echo nl2br("\n\n");
    var_dump(get_defined_vars());
}
?>
