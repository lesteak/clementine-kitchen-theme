<?php

namespace Tofino\ContactForm;


/**
 * AJAX Contact Form
 */
function ajax_contact_form() {

  $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); // XSS
  $nonce = $_POST['nextNonce']; // Nonce from POST request

  if (!wp_verify_nonce($nonce, 'next_nonce')) { // Compare to server generated nonce
    $response = array(
      'success' => false,
      'message' => __('Security check failed.', 'tofino')
    );
    send_json_response($response);
  }

  $reCaptcha_enabled = tofino_get_option('enable_captcha_checkbox');

  $form_data = array();
  parse_str($_POST['data'], $form_data); // Give it the POST data

  if (array_key_exists('email', $form_data)) { // Found email field
    $emailArray = explode('@', $form_data['email']); // Split it on @
    $hostname   = $emailArray[1];
    if (filter_var($form_data['email'], FILTER_VALIDATE_EMAIL) === false || checkdnsrr($hostname, 'MX') === false || gethostbyname($hostname) === $hostname) { //DNS lookup of MX or A/CNAME record
      $response = array(
        'success' => false,
        'message' => __('Invalid email address.', 'tofino')
      );
      send_json_response($response);
    }
  }

  // reCaptcha enabled
  if ($reCaptcha_enabled) {
    // Captcha secret check
    if (tofino_get_option('captcha_secret')) { //Get from theme options
      $secret = tofino_get_option('captcha_secret');
    } else {
      $response = array(
        'success' => false,
        'message' => __('reCaptcha sitekey and/or secret not found. Set this up in the theme options.', 'tofino')
      );
      send_json_response($response);
    }

    // Captcha validation check
    $recaptcha = new \ReCaptcha\ReCaptcha($secret);
    $resp = $recaptcha->verify($form_data['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
    if (!$resp->isSuccess()) {
      $errors = $resp->getErrorCodes(); // Should we send some real error codes back to the user?
      $response = array(
        'success' => false,
        'message' => __('Captcha failed.', 'tofino')
      );
      send_json_response($response);
    }
  }

  $send_to    = get_recipient();
  $send_cc    = (tofino_get_option('contact_form_cc_address') ? tofino_get_option('contact_form_cc_address') : null);
  $send_from  = (tofino_get_option('contact_form_from_address') ? tofino_get_option('contact_form_from_address') : null);
  $subject    = (tofino_get_option('contact_form_email_subject') ? tofino_get_option('contact_form_email_subject') : __('Form submission from ', 'tofino') . $_SERVER['SERVER_NAME']);
  $email_body = build_email_body($form_data);
  $send_mail  = send_mail($send_to, $send_cc, $subject, $email_body, $send_from);

  if (true === $send_mail) {
    $response = array(
      'success' => true,
      'message' => tofino_get_option('contact_form_success_message')
    );
  } else {
    $response = array(
      'success' => false,
      //'message' => $send_mail
      'message' => __('Unable to complete request due to a system error. Send mail failed.', 'tofino')
    );
  }

  send_json_response($response);
}
add_action('wp_ajax_contact-form', __NAMESPACE__ . '\\ajax_contact_form');
add_action('wp_ajax_nopriv_contact-form', __NAMESPACE__ . '\\ajax_contact_form');


/**
 * Get receipient from theme options
 */
function get_recipient() {
  if (tofino_get_option('contact_form_to_address')) { // Email address from contact form options
    $recipient = tofino_get_option('contact_form_to_address');
  } elseif (tofino_get_option('email_address')) { // Email address from general options
    $recipient = tofino_get_option('email_address');
  } else {
    $response = array(
      'success' => false,
      'message' => __('No recipient email address.', 'tofino')
    );
    send_json_response($response);
  }
  return $recipient;
}


/**
 * Genereate email body using html template
 */
function build_email_body($form_data) {
  // Remove reCaptcha from message content
  if (array_key_exists('g-recaptcha-response', $form_data)) {
    unset($form_data['g-recaptcha-response']);
  }

  // Loop through each array item ouput the key value as a string
  $content = null;
  foreach ($form_data as $key => $value) {
    $content .= $key . ': ' . $value . '<br>';
  }

  $message = file_get_contents(get_template_directory() . '/templates/email/contact-form.html'); // Get the template.
  $message = str_replace('%message%', $content, $message);
  $message = str_replace('%ip_address%', __('Client IP Address: ') . $_SERVER['REMOTE_ADDR'], $message);
  $message = str_replace('%referrer%', __('Referrer: ') . $_SERVER['HTTP_REFERER'], $message);

  return $message;
}


/**
 * Send JSON and only JSON, then exit.
 */
function send_json_response($response) {
  header('Content-type: application/json');
  $response = json_encode($response);
  echo $response;
  exit;
}


/**
 * Send mail. Uses wp_mail (PHPMailer).
 */
function send_mail($recipient, $recipient_cc, $subject, $email_body, $from = null) {

  $headers = ['Content-Type: text/html; charset=UTF-8'];

  if ($from) {
    $headers[] = 'From: ' . $from;
  }

  if ($recipient_cc) {
    $headers[] = 'Cc: ' . $recipient_cc;
  }

  $mail = wp_mail($recipient, $subject, $email_body, $headers);

  if ($mail) {
    return true;
  } else {
    return false;
  }
}
