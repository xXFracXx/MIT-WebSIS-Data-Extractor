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
    $result_id = pg_query($pg_conn, "SELECT roll_no FROM student_info WHERE roll_no ='$id'");
    $result_dob = pg_query($pg_conn, "SELECT date_of_birth FROM student_info WHERE roll_no ='$id'");
    if(!pg_num_rows($result_id)) {
        pg_query($pg_conn, "INSERT INTO student_info VALUES ('$id', '$dob')");
        return TRUE;
    } else {
        if($result_dob != $dob)
            pg_query($pg_conn, "UPDATE student_info SET date_of_birth = '$dob' WHERE roll_no = '$id'");
        return FALSE;
    }
}

function uploadToDB($data, $id, $requested_sem, $col) {
    $db_sem = "Semester ".$requested_sem;
    $old_info = downloadFromDB($id, $col);
    $new_info[$db_sem] = $data;
    $final_info = array_merge($old_info, $new_info);
    $json = json_encode($new_info); //data_final
    $conn = pg_connection_string_from_database_url();
    $pg_conn = pg_connect($conn);
    $result = pg_query($pg_conn, "SELECT roll_no FROM student_info WHERE roll_no ='$id'");
    if(pg_num_rows($result)) {
        pg_query($pg_conn, "UPDATE student_info SET $col = '$json' WHERE roll_no = '$id'");
    }
}

function downloadFromDB($id, $col) {
    $conn = pg_connection_string_from_database_url();
    $pg_conn = pg_connect($conn);
    $result = pg_query($pg_conn, "SELECT roll_no FROM student_info WHERE roll_no ='$id'");
    if(pg_num_rows($result)) {
        $result = pg_query($pg_conn, "SELECT $id FROM student_info WHERE roll_no ='$id'");
    }
    $data = pg_fetch_all($result);
    $data_decoded = json_decode($data);
    echo $data;
    return $data_decoded;
}
?>
