<?php
require('lib.php');

$student_id = "140905025";
$student_dob = "1996-10-06";

$post_cred = "idValue=".$student_id."&birthDate_i18n=".$student_dob."&birthDate=".$student_dob;

$login_url = "http://websismit.manipal.edu/websis/control/createAnonSession";

login($login_url, $post_cred);

$student_summary = "http://websismit.manipal.edu/websis/control/StudentAcademicProfile";
$student_latest_enrollment = "http://websismit.manipal.edu/websis/control/ListCTPEnrollment";

$page = grab_page($student_latest_enrollment);

//echo $page;

$html = str_get_html($page);

$row_count = 0;
$col = 0;

foreach($html->find('table[id=ListTermEnrollment_table]') as $table) {
    foreach($table->find('tr') as $row) {
        $c_data[$row_count]['id'] = $row_count;
        foreach($row->find('td') as $cell) {
            $cell_text = $cell->plaintext;
            switch ($col) {
                case 0:
                    $c_data[$row_count]['course_code'] = $cell_text;
                    $col++;
                    break;
                case 1:
                    $c_data[$row_count]['option'] = $cell_text;
                    $col++;
                    break;
                case 2:
                    $c_data[$row_count]['name'] = $cell_text;
                    $col++;
                    break;
                case 3:
                    $c_data[$row_count]['credits'] = $cell_text;
                    $col++;
                    break;
                case 4:
                    $c_data[$row_count]['section'] = $cell_text;
                    $col++;
                    break;
                case 5:
                    $c_data[$row_count]['status'] = $cell_text;
                    $col++;
                    break;
                case 6:
                    $c_data[$row_count]['exam_only'] = $cell_text;
                    break;
            }
        }
        $col = 0;
        $row_count++;
    }
}

//$temp_c_data = str_replace('$nbsp;', '', $c_data);
$json = json_encode($c_data); //JSON_PRETTY_PRINT
echo $json;

?>
