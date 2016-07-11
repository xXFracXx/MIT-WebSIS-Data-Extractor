<?php
function pg_connection_string_from_database_url() {
  $url = $_ENV["DATABASE_URL"];
  $user = parse_url($url, PHP_URL_USER);
  $pass = parse_url($url, PHP_URL_PASS);
  $host = parse_url($url, PHP_URL_HOST);
  $port = parse_url($url, PHP_URL_PORT);
  $db_temp = parse_url($url, PHP_URL_PATH);
  $db = ltrim($db_temp, '/');
  $conn_url = "user=".$user." password=".$pass." host=".$host." port=".$port." dbname=".$db;
  echo $conn_url;
  return $conn_url;
}

if(pg_connect($conn) == 'FALSE') {
    echo "fail";
}

$conn = pg_connection_string_from_database_url();
$pg_conn = pg_connect($conn);

function test_pg_conn() {
    $result = pg_query($pg_conn, "SELECT * FROM student_info");
    print "<pre>\n";
    if (!pg_num_rows($result)) {
      print("Your connection is working, but your database is empty.\nFret not. This is expected for new apps.\n");
    } else {
      print "Tables in your database:\n";
      while ($row = pg_fetch_row($result)) { print("- $row[0]\n"); }
    }
    print "\n";
    exit();
}

function addToDB($id, $dob) {
    $result = pg_query($pg_conn, "SELECT * FROM student_info WHERE roll_no ='$id'");

    if(!pg_num_rows($result)) {
        pg_query($pg_conn, "INSERT INTO student_info VALUES ('$id', '$dob') ");
    } else {
        pg_query($pg_conn, "UPDATE student_info SET date_of_birth = '$dob' WHERE roll_no = '$id' ");
    }
}
?>
