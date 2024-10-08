<?php
/**
 * Convert into an Array
 * 
 * @desc Converts a string to an array
 * @param $string The string that will be converted to the array
 * @param $delimeter The character for the separation
 * 
 * @return Array
 */
function string_to_array($string, $delimiter = ",", $key_name = [], $allowEmpty = false) {
    
    // if its already an array then return the data
    if(is_array($string) || empty($string)) {
        return $string;
    }
    
    $array = [];
    $expl = explode($delimiter, $string);
    
    foreach($expl as $key => $each) {
        if(!empty($each) || $allowEmpty) {
            if(!empty($key_name)) {
                $array[$key_name[$key]] = (trim($each) === "NULL" ? null : trim($each));
            } else{
                $array[] = (trim($each) === "NULL") ? null : trim($each, "\"");
            }
        }
    }
    return $array;
}

/**
 * Check if the value is required
 * 
 * @param String $rule
 * @param String $string
 * @param String $variable_name
 * 
 * @return String
 */
function required($rule, $string, $variable_name = 'the variable') {
    if(empty($string)) {
        return "The ".ucwords($variable_name)." must not be empty";
    }
    return true;
}

/**
 * Get the items that are acceptable by the file upload button
 * 
 * @param String $key
 * 
 * @return String
 */
function file_accept($key = null) {
    // set the mime types to accept
    $mimes = [
        'post' => '.png,.jpg,.gif,.jpeg,.pjeg,.webp'
    ];

    // if the mime type exists
    if(isset($mimes[$key])) {
        return "accept=\"{$mimes[$key]}\"";
    }
}

/**
 * Days either to go or ago
 * 
 * @param String
 */
function days_to_go($upcomingDate = null) {
    if(empty($upcomingDate)) {
        return '0 days';
    }
    $earlier = new DateTime(date("Y-m-d"));
    $later = new DateTime($upcomingDate);

    $abs_diff = $later->diff($earlier);

    $diff = "";
    $diff .= !empty($abs_diff->y) ? "{$abs_diff->y} years " : null;
    $diff .= !empty($abs_diff->m) ? "{$abs_diff->m} months " : null;
    $diff .= !empty($abs_diff->d) ? "{$abs_diff->d} days " : null;
    
    return $diff;
}

/**
 * Verify if a string parsed is a valid date
 * 
 * @param String $date 		This is the date String that has been parsed by the user
 * @param String $format 	This is the format for that date to use
 * 
 * @return Bool
 */
function valid_date($date, $format = 'Y-m-d') {
    
    $date = date($format, strtotime($date));

    // if the date equates this, then return false
    if($date === "1970-01-01") { return false; }

    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

/**
 * @method list_days
 * 
 * @desc It lists dates between two specified dates
 * 
 * @param String $startDate 	This is the date to begin query from
 * @param String $endDate	This is the date to end the request query
 * @param String $format 	This is the format that will be applied to the date to be returned
 * 
 * @return Array
**/
function list_days($startDate, $endDate, $format='Y-m-d', $weekends = true) {

    $period = new DatePeriod(
        new DateTime($startDate),
        new DateInterval('P1D'),
        new DateTime(date('Y-m-d', strtotime($endDate. '+1 days')))
    );

    $days = array();
    $sCheck = (array) $period->start;

    // check the date parsed
    if(date("Y-m-d", strtotime($sCheck['date'])) == "1970-01-01") {
        
        // set a new start date and call the function again
        return list_days(date("Y-m-d", strtotime("first day of this week")), date("Y-m-d", strtotime("today")));

        // exit the query
        exit;
    }
    
    // fetch the days to display
    foreach ($period as $key => $value) {
        // exempt weekends from the list
        if($weekends || !in_array(date("l", strtotime($value->format($format))), ['Sunday', 'Saturday'])) {
            $days[] = $value->format($format);
        }
        
    }
    
    return $days;
}

/**
 * Create a date Interval List
 * 
 * @return String
 */
function _date_interval($period = 'week') {
    $range = "";
    switch($period) {
        case 'week':
            $range = date('Y-m-d', strtotime('-1 week')) . ':' . date('Y-m-d');
            break;
        case 'month':
            $range = date('Y-m-d', strtotime('-1 month')) . ':' . date('Y-m-d');
            break;
        case 'year':
            $range = date('Y-m-d', strtotime('-1 year')) . ':' . date('Y-m-d');
            break;
        case '2weeks':
            $range = date('Y-m-d', strtotime('-2 week')) . ':' . date('Y-m-d');
            break;
        default:
            break;
    }
    return $range;
}

/**
 * Convert into an Integer Array
 * 
 * @desc Converts a string to an array
 * @param $string The string that will be converted to the array
 * @param $delimeter The character for the separation
 * 
 * @return Array
 */
function string_to_int_array($string, $delimiter = ",") {
    
    // if its already an array then return the data
    if(is_array($string) || empty($string)) {
        return $string;
    }
    
    $array = [];
    $expl = explode($delimiter, $string);
    
    foreach($expl as $key => $each) {
        $array[] = (int) $each;
    }
    return $array;
}

/**
 * Show the array data in a pre tag
 * 
 * @param Array $data
 * 
 * @return String
 */
function prep($data = []) {
    print "<pre style='background:#fff; padding: 20px; font-size:13px;'>";
    print_r($data);
    print "</pre>";
    exit;
}



/**
 * Clean the text especially for html_entity_encoded text
 * 
 * revert it back to its original format and the strip tags
 * 
 * @param string    $string
 * @param array     $exempt
 * 
 * @return string
 */
function clean_text($string, $exempt = ['div', 'br','strong','em', 'ul', 'li', 'ol', 'p']) {

    if( is_array($string) ) {
        return array_map('clean_text', $string);
    }

    $string = htmlspecialchars_decode(html_entity_decode($string));
    $string = strip_tags($string, $exempt);
    $string = str_ireplace(['<p><br></p><p><br></p>'], ['<p><br></p>'], $string);
    return $string;
}

/**
 * Clean the Label Text
 * 
 * @param Strin
 */
function clean_label($string, $exempt = []) {

    $string = htmlspecialchars_decode(html_entity_decode($string));
    $string = strip_tags($string, $exempt);
    $string = str_ireplace('_', ' ', $string);
    $string = ucwords($string);
    return $string;
}

/**
 * Confirm if the text contains a word or string
 * 
 * @param String    $string     => The string to search for a word
 * @param Array     $words      => An array of words to look out for in the string
 * 
 * @return Bool
 */
function contains($string, array $words) {

    if(is_array($string)) {
        return false;
    }
    
    if(function_exists('str_contains')) {
        foreach($words as $word) {
            if(str_contains($string, $word)) {
                return true;
            }
        }
    } else {
        foreach($words as $word) {
            if(stristr($string, $word) !== false) {
                return true;
            }
        }
    }
    return false;
}

function min_length($min, $string, $variable_name = 'the variable') {
    $string = is_array($string) ? json_encode($string) : $string;
    if(mb_strlen($string) < $min) {
        return "Minimum length for {$variable_name} is {$min}";
    }
    return true;
}

function max_length($max, $string, $variable_name = 'the variable') {
    $string = is_array($string) ? json_encode($string) : $string;
    if(mb_strlen($string) > $max) {
        return "Maximum length for {$variable_name} is {$max}";
    }
    return true;
}

function matched($rule, $string, $variable_name = 'the variable') {
    if(!preg_match("/^[{$rule},]+$/", $string)) {
        return "The accepted characters for {$variable_name} are {$rule}";
    }
    return true;
}

function matches($rule, $string, $variable_name = 'the variable') {
    // convert the rule and string into an array
    $rule = string_to_array($rule);
    $string = string_to_array($string);

    // get the difference
    $difference = array_diff($string, $rule);

    // loop through the difference
    foreach($difference as $key) {
        if(!in_array($key, $rule)) {
            return "The accepted values for {$variable_name} are: ".implode(", ", $rule);
        }
    }

    return true;
}

function is_an_array($rule, $string, $variable_name = 'the variable') {
    if(!is_array($string)) {
        return "The {$variable_name} must be an array";
    }
    return true;
}

function match_num($rule, $string, $variable_name = 'the variable') {
    if(!preg_match("/^[0-9]+$/", $string)) {
        if(is_bool($variable_name)) {
            return false;
        }
        return "The accepted characters for {$variable_name} are 0-9";
    }
    return true;
}

function match_alpha($rule, $string, $variable_name = 'the variable') {
    if(!preg_match("/^[a-zA-Z]+$/", $string)) {
        return "The accepted characters for {$variable_name} are a-zA-Z";
    }
    return true;
}

function match_alphanum($rule, $string, $variable_name = 'the variable') {
    $string = clean_tags($string);
    if(!preg_match("/^[0-9a-zA-Z.,()_><=|\/\\-&@ ]+$/", $string)) {
        return "The accepted characters for {$variable_name} are 0-9a-zA-Z.,()_><";
    }
    return true;
}

function is_email($rule, $string, $variable_name = null) {
    if(!filter_var($string, FILTER_VALIDATE_EMAIL)) {
        return "{$variable_name} must be a valid email address";
    }
    return true;
}

function is_date($rule, $string, $variable_name = null) {
    
    $date = date('Y-m-d', strtotime($string));

    if($date === "1970-01-01") { return "{$variable_name} must be a valid date"; }
    
    $d = DateTime::createFromFormat('Y-m-d', $date);
    $test = $d && $d->format('Y-m-d') === $date;

    if(empty($test)) {
        return "{$variable_name} must be a valid date";
    }
    return true;
}

function is_url($rule, $string, $variable_name = 'the variable') {
    if(!filter_var($string, FILTER_VALIDATE_URL)) {
        return "{$variable_name} must be a valid website address.";
    }
    return true;
}

function is_contact($rule, $string, $variable_name = 'the variable') {
    if(!preg_match("/^[+0-9]{8,15}+$/", $string)) {
        return "{$variable_name} should consist of the characters 0-9+";
    }
    return true;
}

/**
 * Password Strength Checker
 * 
 * Check if the password is at least:
 *  
 * 8 characters long, and contains
 * 1 uppercase, 
 * 1 lowercase, 
 * 1 number and 
 * 1 special character.
 * 
 * @param String $password
 * 
 * @return Bool
 */
function password_strength($password) {
    
    // Validate password strength
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        return false;
    } else {
        return true;
    }
}

/**
 * Clean the text especially for html_entity_encoded text
 * 
 * revert it back to its original format and the strip tags
 * 
 * @param string    $string
 * @param array     $exempt
 * 
 * @return string
 */
function clean_tags($string, $exempt = ['div', 'br','strong','em', 'ul', 'li', 'ol', 'p']) {

    if( is_array($string) ) {
        return array_map('clean_tags', $string);
    }

    if( is_object($string) ) {
        return $string;
    }

    $string = htmlspecialchars_decode(html_entity_decode($string));
    $string = strip_tags($string, $exempt);
    $string = str_ireplace(['<p><br></p><p><br></p>'], ['<p><br></p>'], $string);
    return $string;
}

/**
 * Pads our string out so that all titles are the same length to nicely line up descriptions.
 *
 * @param int $extra How many extra spaces to add at the end
 */
function setPad($unique_id, $number = 4) {
    $preOrder = str_pad(($unique_id + 1), $number, '0', STR_PAD_LEFT);
    return $preOrder;
}

/**
 * Validate the api endpoint values
 * 
 * @param       Array   $rules              This is an array of the rules to be used
 * @param       String  $param_value        This is the value of the variable
 * @param       String  $variable_name          This is the name of the variable
 * 
 * @return Mixed
 */
function validate_value($rules, $param_value, $variable_name) {
    
    // set the result
    $result = [];

    // loop through the rules
    foreach($rules as $rule => $format) {
        if(function_exists($rule)) {
            $rule_result = $rule($format, $param_value, $variable_name);
            if(!empty($rule_result) && $rule_result !== true) {
                $result[] = $rule_result;
            }
        }
    }

    if(!empty($result)) {
        return $result;
    }
}

/**
 * Return a field that matches the data in the array list
 * 
 * @param Array     $array_list     This is the array list
 * @param String    $word           This is the word to match against the array column
 * @param String    $match          This is the table column to match against the word
 * @param Mixed     $field          This is the column field to return 
 */
function array_data_column($array_list, $word, $match = 'name', $field = 'id') {
    foreach($array_list as $row) {
        if(stristr($row[$match], $word) !== false) {
            return $row[$field];
        }
    }
    return "";
}

function array_column_key($array_list, $word, $match = 'name') {
    foreach($array_list as $key => $row) {
        if($row[$match] == $word) {
            return $key;
        }
    }
    return "";
}

/**
 * Loop through the array and get the keys with values only
 * 
 * @param Array     $array_list
 * 
 * @return Array
 */
function array_with_values(array $array_list) {
    foreach($array_list as $key => $value) {
        if(!empty($value)) {
            $data[$key] = $value;
        }
    }
    return $data ?? [];
}

/**
 * Get the metadata
 * 
 * @param Array     $metadata
 * 
 * @return String|Array
 */
function get_meta($metadata = [], $key_name = null) {
    if( !is_array($metadata) || empty($metadata) ) {
        return false;
    }
    foreach($metadata as $key => $value) {
        if($key == $key_name) {
            return $value;
        }
    }
    return false;
}

/**
 * Format User Meta Data
 * 
 * @param Array     $metadata
 * 
 * @return Array
 */
function format_metadata(array $metadata = []) {
    $data = [];
    foreach($metadata as $meta) {
        $data[$meta['name']] = in_array($meta['name'], ['permissions', 'guardian', 'location', 'subjects', 'interests']) ? 
                json_decode($meta['value'], true) : $meta['value'];
    }
    return $data;
}

/**
 * Get the metadata
 * 
 * @param Array     $metadata
 * 
 * @return String
 */
function get_metadata($metadata = [], $key_name = null) {
    return get_meta($metadata, $key_name);
}

/**
 * Get the question answer
 * 
 * @param   Int     $questionId
 * @param   Array   $theAnswers
 * 
 * @return String
 */
function selected_answer($questionId = null, $theAnswers = []) {
    if(is_null($theAnswers) || empty($questionId) || !is_array($theAnswers)) {
        return null;
    }

    foreach($theAnswers as $answer) {
        if($answer['question'] == $questionId) {
            return $answer['choice'];
        }
    }

    return null;
}

/**
 * Parse the user agent
 * 
 * @param String    $userAgent
 * 
 * @return Array
 */
function parseUserAgent($userAgent = null) {
    
    $result = [
        'browser' => 'Unknown',
        'browser_version' => 'Unknown',
        'os' => 'Unknown',
        'os_version' => 'Unknown',
        'device' => 'Unknown'
    ];

    if(empty($userAgent)) return;

    // Browser and version
    if (preg_match('/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i', $userAgent, $matches)) {
        $result['browser'] = $matches[1];
        if (strtolower($result['browser']) == 'trident') {
            $result['browser'] = 'Internet Explorer';
        }
        $result['browser_version'] = $matches[2];
    }

    // Chrome specific check
    if (preg_match('/Chrome\/(\d+)/', $userAgent, $matches)) {
        $result['browser'] = 'Chrome';
        $result['browser_version'] = $matches[1];
    }

    // OS and version
    if (preg_match('/(mac os x|windows nt|linux) ?([^;)]+)?/i', $userAgent, $matches)) {
        switch(strtolower($matches[1])) {
            case 'mac os x':
                $result['os'] = 'macOS';
                $result['os_version'] = str_replace('_', '.', $matches[2]);
                break;
            case 'windows nt':
                $result['os'] = 'Windows';
                $windowsVersions = [
                    '10.0' => '10',
                    '6.3' => '8.1',
                    '6.2' => '8',
                    '6.1' => '7',
                    '6.0' => 'Vista',
                    '5.2' => 'XP',
                    '5.1' => 'XP'
                ];
                $result['os_version'] = isset($windowsVersions[$matches[2]]) ? $windowsVersions[$matches[2]] : $matches[2];
                break;
            case 'linux':
                $result['os'] = 'Linux';
                $result['os_version'] = $matches[2] ?? 'Unknown';
                break;
        }
    }

    // Device type
    if (preg_match('/(mobile|tablet|ipad|iphone|android)/i', $userAgent)) {
        $result['device'] = 'Mobile';
    } else {
        $result['device'] = 'Desktop';
    }

    return $result;
}

/**
 * Format the question to be displayed
 * 
 * @param Array     $question
 * @param String    $answer
 * @param Bool      $show_edit
 * @param Bool      $show_border
 * @param Array     $permissions
 * @param Int       $count
 * 
 * @return Array 
 */
function format_question($question, $answer = null, $show_edit = false, $show_border = true, $permission = [], $count = 0) {
    
    $questionOption = !empty($question['options']) ? json_decode($question['options'], true) : [];

    $html = $show_border ? "<div class='questionnaire position-relative mt-3' data-question_id='{$question['id']}'>" : null;

    $html .= "
        <div class='hovercontrol' data-item='hover'>
            <div class='question' data-question_id='{$question['id']}'>
                <div class='select-notice'></div>
                <div class='label-question mt-1 mb-2' ".(!empty($question['is_required']) ? "title='Required Question'" : null).">
                    {$count}. ".(!empty($question['is_required']) ? "<span class='required'>*</span>" : null)."
                    <span class='question-title'>{$question['title']}</span>
                </div>
                <div class='choices position-relative'>";

                $html .= $show_edit ? form_overlay() : null;

                foreach($questionOption as $key => $option) { 
                    
                    $key++;
                    $html .= "
                    <div class='single-choice'>
                        <label class='choice choice-{$key}' for='form_choice_id_{$question['id']}_{$key}'>
                            <input ".(!is_null($answer) && ($answer == $key) ? "checked" : null)." class='styled' type='radio' value='{$key}' name='question[choice_id]' id='form_choice_id_{$question['id']}_{$key}' />
                            <label for='form_choice_id_{$question['id']}_{$key}'>
                                <p>{$option}</p>
                            </label>
                        </label>
                    </div>";

                }

            $html .= "
                <input type='hidden' hidden name='question[questionId]' value='{$question['id']}' readonly>
                <input type='hidden' hidden name='is_required' value='{$question['is_required']}' readonly>
                </div>
            </div>";

        if($show_edit) {
            $html .= "<div class='question_content'></div>";

            if(!empty($permission['canEdit']) || !empty($permission['canDelete'])) {
                $html .= "<div class='edit-options'>";
            }

            if(!empty($permission['canEdit'])) {
                $html .= "
                <div class='menu' onclick='return trigger_edit(\"{$show_edit}\", {$question['id']})'>
                    <i title='Edit' class='fa fa-edit text-primary'></i>
                </div>";
            }
            if(!empty($permission['canDelete'])) {
                $html .= "
                <div class='menu' onclick='return delete_question({$question['id']})'>
                    <i title='Delete' class='fa fa-trash text-danger'></i>
                </div>";
            }

            if(!empty($permission['canEdit']) || !empty($permission['canDelete'])) {
                $html .= "</div>";
            }

        }

    $html .= "</div>";
    $html .= $show_border ? "</div>" : null;
    
    return $html;
}

/**
 * Permission Handler
 * 
 * @param String    $section
 * @param String    $permission
 * @param Array     $user
 * 
 * @return Mixed
 */
function hasPermission($section = null, $role = null, $metadata = []) {

    // if the user permission key is empty then try to regenerate it
    if(empty($section) || empty($role) || empty($metadata)) {
        return false;
    }

    // set the user permissions
    $permission_list = $metadata['permissions'] ?? [];

    // if the permissions list is empty 
    if(empty($permission_list)) {
        // use the user_id obtained from session to get the user permissions
        return false;
    }

    // confirm that the requested page exists
    if(!isset($permission_list[$section])) {
        return false;
    }

    // confirm that the role exists
    if(!isset($permission_list[$section][$role])) {
        return false;
    }
    
    return 1;

}

/** 
 * Form loader placeholder 
 * 
 * @return String
 */
function form_overlay($display = "none") {
    return '
    <div class="formoverlay" style="display: '.$display.'; position: absolute;">
        <div class="offline-content text-center">
            <p><i style="color:#000" class="fa fa-spin fa-spinner fa-3x"></i></p>
        </div>
    </div>';
}

/**
 * Dashboard Header
 * 
 * @param String    $baseURL
 * @param Bool      $signup
 * @param Bool      $isLoggedIn
 * 
 * @return String
 */
function dashboard_header($baseURL = null, $signup = true, $isLoggedIn = false) {
    return '
        <div class="text-center top-section">
            <div class="header-container">
                <h3 class="header-title">
                    Create online surveys and forms that mean business
                </h3>
            </div>
            <p class="header-subtitle">
                Get better insights faster—with expert templates, helpful AI, and convenient ways to reach more people.
            </p>
            <div class="header-image mt-4">
                '.(!$isLoggedIn ? '
                    <a href="'.$baseURL.''.($signup ? 'signup' : 'login').'" class="btn mb-2 '.(!$signup ? 'hidden' : null).' signup-button">
                        <i class="fa fa-user-cog"></i> Sign Up for Free
                    </a>
                    <a href="'.$baseURL.'login" class="btn mb-2 '.($signup && $signup !== 'both' ? 'hidden' : null).' login-button">
                        <i class="fa fa-user"></i> Login Into Your Account
                    </a>' : '
                    <a href="'.$baseURL.'dashboard" class="btn mb-2 signup-button">
                        <i class="fa fa-home"></i> Go to Dashboard
                    </a>'
                ).'
                <div class="border-bottom mt-2 mb-2"></div>
            </div>
        </div>';
}

/**
 * Get the minute difference between two times
 * 
 * @param String    $time
 * 
 * @return Int
 */
function minute_diff($time) {

    $time_difference = strtotime($time) - time();
    
    $diff = floor($time_difference / 60);

    return $diff;

}
