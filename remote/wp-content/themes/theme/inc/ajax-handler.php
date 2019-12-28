<?php
  
  /**
   * Ajax user signin handler
   */
  function wiki_usersignin_handler() {
    
    check_ajax_referer( 'usersignin-nonce', 'nonce' );
    
    $username = isset( $_POST['signin-email'] ) ? $_POST['signin-email'] : '';
    $password = isset( $_POST['signin-password'] ) ? $_POST['signin-password'] : '';
    
    $login_data = array();
    $login_data['user_login'] = $username;
    $login_data['user_password'] = $password;
    
    $user_signin = wp_signon( $login_data, false );
    
    if ( is_wp_error( $user_signin ) ) {
      
      $status = 'error';
      
      if ( $user_signin->get_error_code() == 'incorrect_password' ) {
        $text = __( 'Ungültiges Passwort.', 'wiki' );
      } elseif ( $user_signin->get_error_code() == 'empty_password' ) {
        $text = __( 'Passwortfeld leer.', 'wiki' );
      } elseif ( $user_signin->get_error_code() == 'invalid_username' || $user_signin->get_error_code() == 'invalid_email' ) {
        $text = __( 'Ungültige E-Mail-Adresse.', 'wiki' );
      } elseif ( $user_signin->get_error_code() == 'empty_username' ) {
        $text = __( 'E-Mail-Adressfeld ist leer.', 'wiki' );
      } elseif ( $user_signin->get_error_code() == 'pending_registration' ) {
        $text = $user_signin->get_error_message();
      } elseif ( $user_signin->get_error_code() == '' && $username == '' && $password == '' ) {
        $text = __( 'E-Mail-Adressfeld und Passwortfeld leer.', 'wiki' );
      } else {
        $text = __( 'Es ist ein unerwarteter Fehler aufgetreten. Bitte versuchen Sie es zu einem späteren Zeitpunkt.', 'wiki' );
      }
      
    } else {
      
      $status = 'success';
      $text = __( 'Login erfolgreich.', 'wiki' );
      
    }
    
    wp_send_json( array(
                    'status' => $status,
                    'text' => $text
                  ) );
  }
  
  add_action( 'wp_ajax_nopriv_usersignin', 'wiki_usersignin_handler' );
  
  
  /**
   * Ajax user signin handler
   */
  function wiki_usersignout_handler() {
    
    check_ajax_referer( 'usersignout-nonce', 'nonce' );
    
    $user_signout = wp_logout();
    
    if ( is_wp_error( $user_signout ) ) {
      
      $status = 'error';
      $text = __( 'Es ist ein unerwarteter Fehler aufgetreten. Bitte versuchen Sie es zu einem späteren Zeitpunkt.', 'wiki' );
    } else {
      
      $status = 'success';
      $text = __( 'Login erfolgreich.', 'wiki' );
      
    }
    
    wp_send_json( array(
                    'status' => $status,
                    'text' => $text
                  ) );
  }
  
  add_action( 'wp_ajax_usersignout', 'wiki_usersignout_handler' );
  
  function wiki_add_post_handler () {
    check_ajax_referer( 'add-post-nonce', 'nonce' );
    
    //fix for Visual Composer is_admin() shortcode parsing
    if ( method_exists( 'WPBMap', 'addAllMappedShortcodes' ) && !isset( $GLOBALS['shortcode_tags']['vc_row'] ) ) {
      WPBMap::addAllMappedShortcodes();
    }
    
    $files = $_FILES;
    $posts = $_POST;
    
    
    $message = '';
    $status = 'success';
    $fields = array(
      'add-post-title' => array('required' => true, 'valid' => true, 'type' => array('empty'), 'value' => isset($posts['add-post-title']) ? $posts['add-post-title'] : ''),
      'add-post-text' => array('required' => false, 'valid' => false, 'type' => array('empty'), 'value' => isset($posts['add-post-text']) ? $posts['add-post-text'] : ''),
    );
    
    
    if ($error = verify_form_fields($fields)) {
      $status = 'error';
    }
    
    $secret_key = get_field('recaptcha_secret_key', 'options');
    
//    if ($status == 'success' && !verify_recaptcha($_POST['g-recaptcha-response'], $secret_key)) {
//      $error = 'captcha';
//      $status = 'error';
//    }
    
    $insert_success ='';
    if($status == 'success') {
      
      $terms = get_categories();
      //var_dump($terms);
      $terms_array = array();
      foreach ($terms as $term) {
        if(isset($posts['add-post-'.$term -> slug.''])) {
          $terms_array[] = $term->term_id;
        }
      }
      
      
      $postarr = array(
        'post_author'           => '',
        'post_content'          => $posts['add-post-text'],
        'post_content_filtered' => '',
        'post_title'            => $posts['add-post-title'],
        'post_excerpt'          => '',
        'post_status'           => 'publish',
        'post_type'             => 'post',
        'comment_status'        => '',
        'ping_status'           => '',
        'post_password'         => '',
        'to_ping'               => '',
        'pinged'                => '',
        'post_parent'           => 0,
        'menu_order'            => 0,
        'guid'                  => '',
        'import_id'             => 0,
        'context'               => '',
        'post_category'         => $terms_array,
      );
      
     $insert_success = wp_insert_post($postarr , true);
      if ( !$insert_success ) {
        $status = 'error';
        $error = 'setpost';
      }
      
    }
    
    
    if ($status != 'success') {
      switch ($error) {
        case 'empty':
          $message = __('Bitte füllen Sie alle Pflichtfelder aus.', 'wiki');
          break;
        case 'email':
          $message = __('Bitte geben Sie eine valide E-Mail-Adresse ein.', 'wiki');
          break;
        case 'captcha':
          $message = __('Bitte überzeugen Sie uns davon, dass Sie kein Roboter sind.', 'wiki');
          break;
        case 'setpost':
          $message = __('Es ist ein Fehler aufgetreten.', 'wiki');
          break;
        default:
          break;
      }
    } else {
      $status = 'success';
      $message = __('Dein Post wurde erfolgreich erstellt.', 'wiki');
    }
    
    
//    if($status == 'success') {
//      send_mail($insert_success, $posts['add-post-title']);
//    }
    
    
    wp_send_json(
      array(
        'status' => $status,
        'message' => $message,
        'fields' => $fields
      )
    );
    
    die();
    
  }
  
  add_action( 'wp_ajax_add-post', 'wiki_add_post_handler' );
  add_action( 'wp_ajax_nopriv_add-post', 'wiki_add_post_handler' );
  
  
  function verify_form_fields(&$fields)
  {
    
    $validation_error = array();
    foreach ($fields as $key => $field) {
      //write_log($field);
      if ($field['required'] && in_array('empty', $field['type']) && empty(trim($field['value']))) {
        $validation_error[] = 'empty';
        $fields[$key]['valid'] = false;
      }
      
      if ($field['required'] && in_array('privacy', $field['type']) && empty(trim($field['value']))) {
        $validation_error[] = 'privacy';
        $fields[$key]['valid'] = false;
      }
      
      if (in_array('email', $field['type']) && !filter_var($field['value'], FILTER_VALIDATE_EMAIL)) {
        $validation_error[] = 'email';
        $fields[$key]['valid'] = false;
      }
    }
    
    if( count($validation_error) > 0 ) {
      if(in_array('email',$validation_error)){
        return 'email';
      } else if(in_array('privacy',$validation_error)){
        return 'privacy';
      }
      else {
        return 'empty';
      }
    }
    else {
      return '';
    }
    
  }
  
  function verify_recaptcha($key,$secret){
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $fields = array(
      'secret' => $secret,
      'response' => $key,
    );
    $fields_string = http_build_query($fields);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
    curl_close($ch);
    return json_decode($server_output)->{'success'};
  }
  
  function send_mail($new_post_id, $recipe_name)
  {
    $admin_email = get_field('mail_uploaded_recipe_email' , 'options');
    $site_name = get_bloginfo('name');
    $header_admin = '';
    $header_admin .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $header_admin .= 'From: ' . $site_name . ' <' . $admin_email . "> \r\n";
    //  $header_admin .= 'Reply-To: ' . $fields['contact-name']['value'] . ' <' . $fields['contact-email']['value'] . "> \r\n";
    //  $responded_email = $fields['contact-email']['value'];
    
    $title = __('Neuer Post', 'wiki');
    $subtitle = '';
    $heading_infos =__('Es wurde ein neuer Post aufgegeben:', 'wiki');
    $subject_admin = sprintf(__('Website %s – neuer Post', 'wiki'), $site_name);
    
    $output = sprintf(__('<b>Post</b>: %s', 'wiki'), $recipe_name) . ' <br>';
    $output .= '<a href="http://wiki.steirer.info/wp-admin/post.php?post='.$new_post_id.'&action=edit">Link zum Rezept</a><br>';
    
    $content = $output;
    $footer = '';
    
    //admin mail
    create_custom_mail($title, $subtitle, $content, $admin_email, $subject_admin, $header_admin, $footer, $heading_infos );
    
  }
  
  function create_custom_mail($title, $subtitle, $content, $admin_email, $subject_admin, $header_admin, $footer, $heading_infos)
  {
    ob_start(); ?>
    <!DOCTYPE html>
    <html <?php language_attributes(); ?>>
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>"/>
      <title><?php echo get_bloginfo('name', 'display'); ?></title>
    </head>
    <body <?php echo is_rtl() ? 'rightmargin' : 'leftmargin'; ?>="0" marginwidth="0" topmargin="0" marginheight="0" offset
    ="0">
    <div id="wrapper" dir="<?php echo is_rtl() ? 'rtl' : 'ltr' ?>"
         style="background-color: rgba(0,0,0,00.07); margin: 0; padding: 70px 0 70px 0; width: 100%; -webkit-text-size-adjust: none;">
      <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
        <tr>
          <td align="center" valign="top">
            <div id="template_header_image">
              <?php
                if ($img = get_option('woocommerce_email_header_image')) {
                  echo '<p style="margin-top:0;"><img src="' . esc_url($img) . '" alt="' . get_bloginfo('name', 'display') . '" /></p>';
                }
              ?>
            </div>
            <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container"
                   style="background-color: #ffffff; border: 1px solid #d3d0ca; box-shadow: 0 1px 4px rgba(0,0,0,0.1); border-radius: 3px;">
              <tr>
                <td align="center" valign="top">
                  <!-- Header -->
                  <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header"
                         style='background-color: rgba(0,0,0,0.07); color: #000; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; border-radius: 3px 3px 0 0;'>
                    <tr>
                      <td id="header_wrapper" style="padding: 36px 48px; display: block;">
                        <h1
                          style='color #000; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: left; text-shadow: 0 1px 0 #7e7875;'><?php echo $title; ?></h1>
                      </td>
                    </tr>
                  </table>
                  <!-- End Header -->
                </td>
              </tr>
              <tr>
                <td align="center" valign="top">
                  <!-- Body -->
                  <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
                    <tr>
                      <td valign="top" id="body_content" style="background-color: #ffffff;">
                        <!-- Content -->
                        <table border="0" cellpadding="20" cellspacing="0" width="100%">
                          <tr>
                            <td valign="top" style="padding: 48px 48px 0;">
                              <div id="body_content_inner"
                                   style='color #000; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 14px; line-height: 150%; text-align: left;'>
                                <h2
                                  style='color #000; display: block; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 18px; font-weight: bold; line-height: 130%; margin: 0 0 18px; text-align: left;'><?php echo $subtitle; ?></h2>
                                <?php if( !empty($heading_infos)) : ?>
                                  <h3><?php echo $heading_infos; ?></h3>
                                <?php endif; ?>
                                <?php echo $content; ?>
                              </div>
                            </td>
                          </tr>
                        </table>
                        <!-- End Content -->
                      </td>
                    </tr>
                  </table>
                  <!-- End Body -->
                </td>
              </tr>
              <tr>
                <td align="center" valign="top">
                  <!-- Footer -->
                  <table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
                    <tr>
                      <td valign="top" style="padding: 0; -webkit-border-radius: 6px;">
                        <table border="0" cellpadding="10" cellspacing="0" width="100%">
                          <tr>
                            <td colspan="2" valign="middle" id="credit"
                                style="padding: 0 48px 48px 48px; -webkit-border-radius: 6px; border: 0; color #000; font-family: Arial; font-size: 12px; line-height: 125%; text-align: center;">
                              <?php echo $footer; ?>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                  <!-- End Footer -->
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </div>
    </body>
    </html>
    <?php
    $message_admin = ob_get_clean();
    //  $admin_email = 'lukas.kurzmann@sunlime.at';
    wp_mail($admin_email, $subject_admin, $message_admin, $header_admin);
    //wp_mail( 'daniel.steirer@sunlime.at', $subject_admin, $message_admin, $header_admin );
    
  }





