<?php

function get_course_data($html){
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

    return $c_data;
}

function get_attendance_data($html) {
    $row_count = 0;
    $col = 0;
    foreach($html->find('table[id=ListAttendanceSummary_table]') as $table) {
        foreach($table->find('tr') as $row) {
            $a_data[$row_count]['id'] = $row_count;
            foreach($row->find('td') as $cell) {
                $cell_text = $cell->plaintext;
                switch ($col) {
                    case 0:
                        $a_data[$row_count]['course_code'] = $cell_text;
                        $col++;
                        break;
                    case 1:
                        $a_data[$row_count]['name'] = $cell_text;
                        $col++;
                        break;
                    case 2:
                        $a_data[$row_count]['classes'] = $cell_text;
                        $col++;
                        break;
                    case 3:
                        $a_data[$row_count]['attended'] = $cell_text;
                        $col++;
                        break;
                    case 4:
                        $a_data[$row_count]['absent'] = $cell_text;
                        $col++;
                        break;
                    case 5:
                        $a_data[$row_count]['percentage'] = $cell_text;
                        $col++;
                        break;
                    case 6:
                        $a_data[$row_count]['updated'] = $cell_text;
                        break;
                }
            }
            $col = 0;
            $row_count++;
        }
    }

    return $a_data;
}

?>
