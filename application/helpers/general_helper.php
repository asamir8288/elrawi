<?php

function substring($string, $id = '', $page = 'news-details', $wordsNumber = 30) {
    $strArray = explode(' ', $string);
    $new_string = '';
    if (count($strArray) > $wordsNumber) {
        for ($i = 0; $i <= $wordsNumber; $i++) {

            if (trim($strArray[$i]) != '<div>' && trim($strArray[$i]) != '</div>') {
                $new_string .= $strArray[$i] . ' ';
            } elseif (trim($strArray[$i]) == '</div>') {
                $new_string .= '<br />';
            }
        }

        if ($id === true) {
            $new_string .= '<a href="' . base_url($page) . '" class="more-link">' . lang('frontend_more_link') . '</a>';
        } else if ($id) {
            $new_string .= '<a href="' . base_url($page . '/' . $id) . '" class="more-link">' . lang('frontend_more_link') . '</a>';
        } else {
            $new_string .= '...';
        }
    } else {
        $new_string = $string;
    }

    return $new_string;
}

function shuffle_assoc($list) {
    if (!is_array($list))
        return $list;

    $keys = array_keys($list);
    shuffle($keys);
    $random = array();
    foreach ($keys as $key) {
        $random[] = $list[$key];
    }
    return $random;
}

function static_url() {
    $CI = & get_instance();
    return $CI->config->item('static_url');
}

function generate_error_message($message) {
    if (isset($message) && !empty($message)) {
        return '<span class="error_message">' . $message . '</span>';
    }
}

?>
