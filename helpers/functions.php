<?php
  function url_for($script_path) {
    // add the leading '/' if not present
    if($script_path[0] != '/') {
      $script_path = "/" . $script_path;
    }
    return WWW_ROOT . $script_path;
  }
  
  function u($string="") {
    return urlencode($string);
  }
  
  function raw_u($string="") {
    return rawurlencode($string);
  }
  
  function h($string="") {
    return htmlspecialchars($string);
  }
  
  function redirect_to($location) {
    header("Location: " . $location);
    exit;
  }
  
  function is_post_request() {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
  }
  
  function is_get_request() {
    return $_SERVER['REQUEST_METHOD'] == 'GET';
  }

  function display_bootstrap_error($error) {
    $output = '';
    if(!empty($error)) {
      $output .= '<div class="alert alert-danger alert-dismissible">';
      $output .= '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
      $output .= "<strong>Error! &nbsp;</strong>" .  $error;
      $output .= '</div>';
    }
    return $output;
  }
  function display_bootstrap_success($success) {
    $output = '';
    if(!empty($success)) {
      $output .= '<div class="alert alert-success alert-dismissible">';
      $output .= '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
      $output .= "<strong>Success! &nbsp;</strong>" .  $success;
      $output .= '</div>';
    }
    return $output;
  }
?>
