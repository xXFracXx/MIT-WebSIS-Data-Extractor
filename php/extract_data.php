<?php
function get_course_data($html){
    $row_count = 0;
    $col = 0;
    foreach($html->find('table[id=ListTermEnrollment_table]') as $table) {
        foreach($table->find('tr') as $row) {
            $c_data[$row_count]['id'] = $row_count;
            foreach($row->find('td') as $cell) {
                $cell_text_temp = $cell->plaintext;
                $cell_text = trim($cell_text_temp);
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
                        $col++;
                        break;
                }
            }
            $col = 0;
            $row_count++;
        }
    }
    //array_splice($c_data, 0, 1);
    return $c_data;
}

function get_attendance_data($html) {
    $row_count = 0;
    $col = 0;
    foreach($html->find('table[id=ListAttendanceSummary_table]') as $table) {
        foreach($table->find('tr') as $row) {
            $a_data[$row_count]['id'] = $row_count;
            foreach($row->find('td') as $cell) {
                $cell_text_temp = $cell->plaintext;
                $cell_text = trim($cell_text_temp);
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
                        $temp_cell_text = str_replace('/', '-', $cell_text);
                        $a_data[$row_count]['updated'] = $temp_cell_text;
                        $col++;
                        break;
                }
            }
            $col = 0;
            $row_count++;
        }
    }
    //array_splice($a_data, 0, 1);
    return $a_data;
}

function get_IA1_data($html) {
    $row_count = 0;
    $col = 0;
    foreach($html->find('div.screenlet') as $main_table_div) {
        foreach($main_table_div->find('div.screenlet-title-bar ul li.h3') as $table_title) {
            $table_title_plain_text = $table_title->plaintext;
            if (strpos($table_title_plain_text, '(IA) - [1]') !== false) {
                foreach($main_table_div->find('table[id=ListAssessmentScores_table]') as $table) {
                    foreach($table->find('tr') as $row) {
                        $IA1_data[$row_count]['id'] = $row_count;
                        foreach($row->find('td') as $cell) {
                            $cell_text_temp = $cell->plaintext;
                            $cell_text = trim($cell_text_temp);
                            switch ($col) {
                                case 0:
                                    $IA1_data[$row_count]['course_code'] = $cell_text;
                                    $col++;
                                    break;
                                case 1:
                                    $IA1_data[$row_count]['course'] = $cell_text;
                                    $col++;
                                    break;
                                case 2:
                                    $IA1_data[$row_count]['marks'] = $cell_text;
                                    $col++;
                                    break;
                            }
                        }
                        $col = 0;
                        $row_count++;
                    }
                }
            }
        }
    }
    //array_splice($IA1_data, 0, 1);
    return $IA1_data;
}

function get_IA2_data($html) {
    $row_count = 0;
    $col = 0;
    foreach($html->find('div.screenlet') as $main_table_div) {
        foreach($main_table_div->find('div.screenlet-title-bar ul li.h3') as $table_title) {
            $table_title_plain_text = $table_title->plaintext;
            if (strpos($table_title_plain_text, '(IA) - [2]') !== false) {
                foreach($main_table_div->find('table[id=ListAssessmentScores_table]') as $table) {
                    foreach($table->find('tr') as $row) {
                        $IA2_data[$row_count]['id'] = $row_count;
                        foreach($row->find('td') as $cell) {
                            $cell_text_temp = $cell->plaintext;
                            $cell_text = trim($cell_text_temp);
                            switch ($col) {
                                case 0:
                                    $IA2_data[$row_count]['course_code'] = $cell_text;
                                    $col++;
                                    break;
                                case 1:
                                    $IA2_data[$row_count]['course'] = $cell_text;
                                    $col++;
                                    break;
                                case 2:
                                    $IA2_data[$row_count]['marks'] = $cell_text;
                                    $col++;
                                    break;
                            }
                        }
                        $col = 0;
                        $row_count++;
                    }
                }
            }
        }
    }
    //array_splice($IA2_data, 0, 1);
    return $IA2_data;
}

function get_IA3_data($html) {
    $row_count = 0;
    $col = 0;
    foreach($html->find('div.screenlet') as $main_table_div) {
        foreach($main_table_div->find('div.screenlet-title-bar ul li.h3') as $table_title) {
            $table_title_plain_text = $table_title->plaintext;
            if (strpos($table_title_plain_text, '(IA) - [3]') !== false) {
                foreach($main_table_div->find('table[id=ListAssessmentScores_table]') as $table) {
                    foreach($table->find('tr') as $row) {
                        $IA3_data[$row_count]['id'] = $row_count;
                        foreach($row->find('td') as $cell) {
                            $cell_text_temp = $cell->plaintext;
                            $cell_text = trim($cell_text_temp);
                            switch ($col) {
                                case 0:
                                    $IA3_data[$row_count]['course_code'] = $cell_text;
                                    $col++;
                                    break;
                                case 1:
                                    $IA3_data[$row_count]['course'] = $cell_text;
                                    $col++;
                                    break;
                                case 2:
                                    $IA3_data[$row_count]['marks'] = $cell_text;
                                    $col++;
                                    break;
                            }
                        }
                        $col = 0;
                        $row_count++;
                    }
                }
            }
        }
    }
    //array_splice($IA3_data, 0, 1);
    return $IA3_data;
}

function genGCGLinks($html, $latest_sem){
    $sem = $latest_sem;
    foreach($html->find('table[id=ProgramAdmissionItemSummary_table]') as $table) {
        foreach($table->find('tr') as $row) {
            foreach($row->find('a') as $cell) {
                $link = str_replace("&amp;", "&", $cell->href);
                $links[$sem] = $link;
                $sem = $sem - 1;
            }
        }
    }
    return $links;
}

function get_gc_data($html) {
    $row_count = 0;
    $col = 0;
    $total_credits = 0;
    foreach($html->find('table[id=TermGradeBookSummary_table]') as $table) {
        foreach($table->find('tr') as $row) {
            $gc_data[$row_count]['id'] = $row_count;
            foreach($row->find('td') as $cell) {
                $cell_text_temp = $cell->plaintext;
                $cell_text = trim($cell_text_temp);
                switch ($col) {
                    case 0:
                        $gc_data[$row_count]['course_code'] = $cell_text;
                        $col++;
                        break;
                    case 1:
                        $gc_data[$row_count]['name'] = $cell_text;
                        $col++;
                        break;
                    case 2:
                        $total_credits = $total_credits + $cell_text;
                        $gc_data[$row_count]['credits'] = $cell_text;
                        $col++;
                        break;
                    case 3:
                        $gc_data[$row_count]['grade'] = $cell_text;
                        $col++;
                        break;
                    case 4:
                        $gc_data[$row_count]['absent'] = $cell_text;
                        $col++;
                        break;
                    case 5:
                        $gc_data[$row_count]['session'] = $cell_text;
                        $col++;
                        break;
                }
            }
            $col = 0;
            $row_count++;
        }
    }
    //array_splice($a_data, 0, 1);
    $gc_data["total_credits"] = $total_credits;
    return $gc_data;
}

function get_gp_data($html, $requested_sem, $latest_sem) {
    $sem = $latest_sem;
    $sem_array_id = $latest_sem - $requested_sem;
    foreach($html->find('table[id=ProgramAdmissionItemSummary_table]') as $table) {
        foreach($table->find('tr') as $row) {
            foreach($row->find('td') as $cell) {
                $cell_text_temp = $cell->plaintext;
                $cell_text = trim($cell_text_temp);
                if(is_numeric($cell_text)) {
                    $cgpas[$sem] = $cell_text;
                    $sem = $sem - 1;
                }
            }
        }
    }

    var_dump($cgpas);
    //return $links;
}

?>
