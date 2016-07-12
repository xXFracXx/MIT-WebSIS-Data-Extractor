<?php
function pg_connection_string_from_database_url() {
  $url = $_ENV["DATABASE_URL"];
  $user = parse_url($url, PHP_URL_USER);
  $pass = parse_url($url, PHP_URL_PASS);
  $host = parse_url($url, PHP_URL_HOST);
  $port = parse_url($url, PHP_URL_PORT);
  $db_temp = parse_url($url, PHP_URL_PATH);
  $db = ltrim($db_temp, '/');
  $conn_url = "host=".$host." port=".$port." user=".$user." password=".$pass." dbname=".$db;
  return $conn_url;
}

// $conn = pg_connection_string_from_database_url();
// $pg_conn = pg_connect($conn);

function test_pg_conn() {
    $conn = pg_connection_string_from_database_url();
    $pg_conn = pg_connect($conn);
    $result = pg_query($pg_conn, "SELECT roll_no, date_of_birth FROM student_info");
    print "<pre>\n";
    if (!pg_num_rows($result)) {
      print("Your connection is working, but your database is empty.\nFret not. This is expected for new apps.\n");
    } else {
      print("Data in student_info:\n");
      while ($row = pg_fetch_row($result)) { print("- $row[0]\n"); }
    }
    print "\n</pre>";
}

function addStudentInfoToDB($id, $dob) {
    $conn = pg_connection_string_from_database_url();
    $pg_conn = pg_connect($conn);
    $result = pg_query($pg_conn, "SELECT roll_no FROM student_info WHERE roll_no ='$id'");

    if(!pg_num_rows($result)) {
        pg_query($pg_conn, "INSERT INTO student_info VALUES ('$id', '$dob')");
    } else {
        pg_query($pg_conn, "UPDATE student_info SET date_of_birth = '$dob' WHERE roll_no = '$id'");
    }
}

function addDataToDB($json, $id, $col) {
    $conn = pg_connection_string_from_database_url();
    $pg_conn = pg_connect($conn);
    $result = pg_query($pg_conn, "SELECT roll_no FROM student_info WHERE roll_no ='$id'");
    if(pg_num_rows($result)) {
        pg_query($pg_conn, "UPDATE student_info SET $col = '$json' WHERE roll_no = '$id'");
        pg_query($pg_conn, "UPDATE student_info SET ts = CURRENT_TIMESTAMP WHERE roll_no = '$id'");
    }
}

function grabExistingData($id) {
    $conn = pg_connection_string_from_database_url();
    $pg_conn = pg_connect($conn);
    $result = pg_query($pg_conn, "SELECT roll_no FROM student_info WHERE roll_no ='$id'");
    if(pg_num_rows($result)) {
        $attendance = pg_query($pg_conn, "SELECT attendance FROM student_info WHERE roll_no ='$id'");
        $course = pg_query($pg_conn, "SELECT course FROM student_info WHERE roll_no ='$id'");
        $marks_ia1 = pg_query($pg_conn, "SELECT marks_ia1 FROM student_info WHERE roll_no ='$id'");
        $marks_ia2 = pg_query($pg_conn, "SELECT marks_ia2 FROM student_info WHERE roll_no ='$id'");
        $marks_ia3 = pg_query($pg_conn, "SELECT marks_ia3 FROM student_info WHERE roll_no ='$id'");
    }
    $info["attendance"] = $attendance;
    $info["course"] = $course;
    $info["marks_ia1"] = $marks_ia1;
    $info["marks_ia2"] = $marks_ia2;
    $info["marks_ia3"] = $marks_ia3;

    return $info;
}
?>
