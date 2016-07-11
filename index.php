<?php
require('lib.php');
require('extract_data.php');

$base_url = $_SERVER['REQUEST_URI'];
$routes = array();
$routes = explode('/', $base_url);
foreach($routes as $route) {
    if(trim($route) != '')
        array_push($routes, $route);
}
//Now, $routes will contain all the routes. $routes[0] will correspond to first route. For e.g. in above example $routes[0] is search, $routes[1] is book and $routes[2] is fitzgerald

if($routes[1] == "test") {
    function pg_connection_string_from_database_url() {
      extract(parse_url($_ENV["DATABASE_URL"]));
      return "user=$user password=$pass host=$host dbname=" . substr($path, 1); # <- you may want to add sslmode=require there too
    }
    # Here we establish the connection. Yes, that's all.
    $conn = pg_connection_string_from_database_url();
    $pg_conn = pg_connect($conn);
    # Now let's use the connection for something silly just to prove it works:
    $result = pg_query($pg_conn, "SELECT relname FROM pg_stat_user_tables WHERE schemaname='public'");
    print "<pre>\n";
    if (!pg_num_rows($result)) {
      print("Your connection is working, but your database is empty.\nFret not. This is expected for new apps.\n");
    } else {
      print "Tables in your database:\n";
      while ($row = pg_fetch_row($result)) { print("- $row[0]\n"); }
    }
    print "\n";

    echo $_ENV["DATABASE_URL"];
    echo "hello world";

    exit();
}

$student_id = (string)$routes[1];
$student_dob = (string)$routes[2];

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
    } else if($routes[4] == "IA2") {
        $data = get_IA2_data($data_html);
    } else if($routes[4] == "IA3") {
        $data = get_IA3_data($data_html);
    }
} else if($routes[3] == "attendance") {
    $data = get_attendance_data($data_html);
} else if($routes[3] == "course") {
    $data = get_course_data($data_html);
}

$json = json_encode($data, JSON_PRETTY_PRINT);
printf('<pre>%s</pre>', $json)

?>
