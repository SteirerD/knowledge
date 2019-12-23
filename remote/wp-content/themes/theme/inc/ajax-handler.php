<?php
/**
 * Ajax news actions handler
 */
function kcs_news_actions_handler() {

  check_ajax_referer( 'newsactions-nonce', 'nonce' );

  //fix for Visual Composer is_admin() shortcode parsing
  if( method_exists('WPBMap', 'addAllMappedShortcodes') && !isset( $GLOBALS['shortcode_tags']['vc_row'] ) ) {
    WPBMap::addAllMappedShortcodes();
  }

  $businessegment_ids = isset( $_POST['businessegment_ids'] ) ? $_POST['businessegment_ids'] : array();
  $pageNumber = isset( $_POST['pagenumber'] ) ? $_POST['pagenumber'] : '';
  $ppp = isset( $_POST['ppp'] ) ? $_POST['ppp'] : get_option( 'posts_per_page' );
  $search_string = isset( $_POST['search_string'] ) ? trim( $_POST['search_string'] ) : '';

  $meta_query = array();

	if( $search_string ) {

	  $args = array(
			's' => $search_string,
	    'post_type' => array( 'post' ),
	    'posts_per_page' => $ppp,
	    'page' => $pageNumber
	  );

	  $news_query = new SWP_Query( $args );

  } else {

	  $args = array(
	    'post_type' => 'post',
	    'post_status' => 'publish',
	    'posts_per_page' => $ppp,
	    'paged' => $pageNumber
	  );

	  if( $businessegment_ids ) {

			foreach( $businessegment_ids as $businessegment_id ) {
			  array_push( $meta_query, array(
					'key'     => 'kcs_news_businesssegment',
					'value' => '"' . $businessegment_id . '"',
					'compare' => 'LIKE'
			  ));
			}
			$args['meta_query'] = array(
			  'relation' => 'OR',
			) + $meta_query;

		}

		$news_query = new WP_Query( $args );
  }


	global $post;
	if ( ! empty( $news_query->posts ) ) {
		ob_start();
	  foreach( $news_query->posts as $post ) : setup_postdata( $post );
	  	get_template_part( 'template-parts/content', 'news' );
	  endforeach;
	  wp_reset_postdata();
	  $output = ob_get_contents();
	  ob_end_clean();
	}

  if( ! empty($_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
		$output = json_encode( array( 'total_count' => $news_query->found_posts, 'posts' => is_null( $output ) ? false : $output ) );
    echo $output;
  }
  else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  }

  die();
}

add_action( 'wp_ajax_news_actions', 'kcs_news_actions_handler' );
add_action( 'wp_ajax_nopriv_news_actions', 'kcs_news_actions_handler' );

/**
 * Ajax press actions handler
 */
function kcs_press_actions_handler() {
  
  check_ajax_referer( 'pressactions-nonce', 'nonce' );
  
  //fix for Visual Composer is_admin() shortcode parsing
  if( method_exists('WPBMap', 'addAllMappedShortcodes') && !isset( $GLOBALS['shortcode_tags']['vc_row'] ) ) {
    WPBMap::addAllMappedShortcodes();
  }
  
  $businessegment_ids = isset( $_POST['businessegment_ids'] ) ? $_POST['businessegment_ids'] : array();
  $pageNumber = isset( $_POST['pagenumber'] ) ? $_POST['pagenumber'] : '';
  $ppp = isset( $_POST['ppp'] ) ? $_POST['ppp'] : get_option( 'posts_per_page' );
  $search_string = isset( $_POST['search_string'] ) ? trim( $_POST['search_string'] ) : '';
  
  $meta_query = array();
  //var_dump($search_string);
  if( $search_string ) {
    
    $args = array(
      's' => $search_string,
      'post_type' => array( 'press' ),
      'posts_per_page' => $ppp,
      'page' => $pageNumber
    );
    
    $news_query = new SWP_Query( $args );
    
  } else {
    
    $args = array(
      'post_type' => 'press',
      'post_status' => 'publish',
      'posts_per_page' => $ppp,
      'paged' => $pageNumber
    );
    
    if( $businessegment_ids ) {
      
      foreach( $businessegment_ids as $businessegment_id ) {
        array_push( $meta_query, array(
          'key'     => 'kcs_news_businesssegment',
          'value' => '"' . $businessegment_id . '"',
          'compare' => 'LIKE'
        ));
      }
      $args['meta_query'] = array(
          'relation' => 'OR',
        ) + $meta_query;
      
    }
    
    $news_query = new WP_Query( $args );
  }
  
  
  global $post;
  if ( ! empty( $news_query->posts ) ) {
    ob_start();
    foreach( $news_query->posts as $post ) : setup_postdata( $post );
      get_template_part( 'template-parts/content', 'press' );
    endforeach;
    wp_reset_postdata();
    $output = ob_get_contents();
    ob_end_clean();
  }
  
  if( ! empty($_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
    $output = json_encode( array( 'total_count' => $news_query->found_posts, 'posts' => is_null( $output ) ? false : $output ) );
    echo $output;
  }
  else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  }
  
  die();
}
  
  add_action( 'wp_ajax_press_actions', 'kcs_press_actions_handler' );
  add_action( 'wp_ajax_nopriv_press_actions', 'kcs_press_actions_handler' );

/**
 * Ajax documentcollection add handler
 */
function kcs_documentcollection_add_handler() {

  check_ajax_referer( 'documentcollection-add-nonce', 'nonce' );

  $download_id = isset( $_POST['download_id'] ) ? $_POST['download_id'] : '';

  $args = array(
	  'post_type' => 'download',
	  'post_status' => 'publish',
    'p' => $download_id
  );

  $downloads_query = new WP_Query( $args );

  if ( $downloads_query->have_posts() ) :

    ob_start();

    while ( $downloads_query->have_posts()) : $downloads_query->the_post(); ?>

    	<div class="c-document-collection__slider-download swiper-slide<?php echo get_field( 'kcs_download_onlyloggedin', $download_id ) ? ' c-document-collection__slider-download--is-protected' : ''; ?>">

				<?php kcs_print_downloadentry( true, false, array( 'delete' ) ); ?>

    	</div>

    <?php endwhile;

    $output = ob_get_contents();
    ob_end_clean();

  endif;
  wp_reset_postdata();

  wp_send_json( array(
		'status' => $output ? 'success' : 'error',
		'html' => $output
	) );
}

add_action( 'wp_ajax_documentcollection_add', 'kcs_documentcollection_add_handler' );
add_action( 'wp_ajax_nopriv_documentcollection_add', 'kcs_documentcollection_add_handler' );

/**
 * Ajax userdownloads update handler
 */
function kcs_userdownloads_update_handler() {

  check_ajax_referer( 'userdownloads-nonce', 'nonce' );

  $download_id = isset( $_POST['download_id'] ) ? $_POST['download_id'] : '';
  $mode = isset( $_POST['mode'] ) ? $_POST['mode'] : '';
  $user_id = get_current_user_id();
	$bookmarks_user = get_field( 'kcs_user_favoritedownloads', 'user_' . $user_id ) ? get_field( 'kcs_user_favoritedownloads', 'user_' . $user_id ) : array();

  if( $mode == 'bookmark' || $mode == 'collect' ) {

	  $args = array(
		  'post_type' => 'download',
		  'post_status' => 'publish',
	    'p' => $download_id
	  );

	  if( $mode == 'bookmark_add' && in_array( $download_id, $bookmarks_user ) ) {
		// bookmark already in
	  } else {
		  $download_query = new WP_Query( $args );

		  if ( $download_query->have_posts() ) :

		    ob_start();

		    while ( $download_query->have_posts()) : $download_query->the_post();
		    	if( $mode == 'bookmark_add' ) {
			    	$controls = array( 'collect', 'delete' );
		    	} else {
			    	$controls = array( 'bookmark', 'delete' );
		    	}
		    	?>

					<?php kcs_print_downloadentry( true, '8', $controls, true ); ?>

		    <?php endwhile;

		    $output = ob_get_contents();
		    ob_end_clean();

		  endif;
		  wp_reset_postdata();

			if( $mode == 'bookmark' ) {
				// Add new value to array
			  array_push( $bookmarks_user, $download_id );
			} else {
				$status = $output;
			}
	  }

	} else if( $mode == 'bookmark_remove' ) {
		// Remove value from array
		if( ( $key = array_search( $download_id, $bookmarks_user ) ) !== false ) {
    	unset( $bookmarks_user[$key] );
		}
	}

	if( $mode == 'bookmark' || $mode == 'bookmark_remove' ) {
		$status = update_field( 'kcs_user_favoritedownloads', $bookmarks_user, 'user_' . $user_id );
	}

  wp_send_json( array(
		'status' => $status ? 'success' : 'error',
		'download' => $output
	) );
}

add_action( 'wp_ajax_userdownloads_update', 'kcs_userdownloads_update_handler' );

/**
 * Ajax documentcollection download handler
 */
function kcs_documents_download_handler() {

  check_ajax_referer( 'documents-download-nonce', 'nonce' );

	$downloadtype = isset( $_POST['downloadtype'] ) ? $_POST['downloadtype'] : '';
  $download_ids = isset( $_POST['download_ids'] ) ? $_POST['download_ids'] : '';
  $user_id = get_current_user_id();
	$bookmarks_user = get_field( 'kcs_user_favoritedownloads', 'user_' . $user_id );

  $downloads_base_path = get_home_path() . 'downloads/';
  $downloads_base_url = site_url() . '/downloads/';

  if( !file_exists( $downloads_base_path ) ) {
	  mkdir( $downloads_base_path );
  }

  if( !empty( $download_ids ) || !empty( $bookmarks_user ) ) {

	  $key = wp_generate_password( 20, false );
	  $zip = new ZipArchive();
	  $filename_path = $downloads_base_path . 'kirchdorfer-downloads-' . $key . '.zip';
	  $filename_url = $downloads_base_url . 'kirchdorfer-downloads-' . $key . '.zip';

	  if ($zip->open($filename_path, ZipArchive::CREATE)!==TRUE) {
	    $status = 'error';
	  } else {
		  $status = 'success';

		  if( $downloadtype == 'bookmarks' ) {
			  $download_ids = $bookmarks_user;
		  }

			foreach( $download_ids as $download_id ) {
				$download_object = get_field( 'kcs_download_file', $download_id );
				if( get_field( 'kcs_download_onlyloggedin', $download_id ) && !is_user_logged_in() ) continue;

				if( is_readable( get_attached_file( $download_object['ID'] ) ) ) {
					$zip->addFile( get_attached_file( $download_object['ID'] ), $download_object['filename'] );
				} else {
					$status = 'error';
				}
			}
	  }
	}

  $zip->close();

  wp_send_json( array(
		'status' => $status,
		'fileurl' => $filename_url
	) );
}

add_action( 'wp_ajax_documents_download', 'kcs_documents_download_handler' );
add_action( 'wp_ajax_nopriv_documents_download', 'kcs_documents_download_handler' );

/**
 * Ajax user signin handler
 */
function kcs_usersignin_handler() {

  check_ajax_referer( 'usersignin-nonce', 'nonce' );

  $username = isset( $_POST['signin-email'] ) ? $_POST['signin-email'] : '';
	$password = isset( $_POST['signin-password'] ) ? $_POST['signin-password'] : '';

  $login_data = array();
  $login_data['user_login'] = $username;
  $login_data['user_password'] = $password;

  $user_signin = wp_signon( $login_data, false );

  if ( is_wp_error( $user_signin ) ) {

    $status = 'error';

    if( $user_signin->get_error_code() == 'incorrect_password' ) {
	    $text = __( 'Ungültiges Passwort.' , 'kirchdorfer' );
    } elseif( $user_signin->get_error_code() == 'empty_password' ) {
	    $text = __( 'Passwortfeld leer.' , 'kirchdorfer' );
    } elseif( $user_signin->get_error_code() == 'invalid_username' || $user_signin->get_error_code() == 'invalid_email' ) {
	    $text = __( 'Ungültige E-Mail-Adresse.' , 'kirchdorfer' );
    } elseif( $user_signin->get_error_code() == 'empty_username' ) {
	    $text = __( 'E-Mail-Adressfeld ist leer.' , 'kirchdorfer' );
    } elseif( $user_signin->get_error_code() == 'pending_registration' ) {
	    $text = $user_signin->get_error_message();
    } elseif( $user_signin->get_error_code() == '' && $username == '' && $password == '' ) {
	    $text = __( 'E-Mail-Adressfeld und Passwortfeld leer.' , 'kirchdorfer' );
	  } else {
	    $text = __( 'Es ist ein unerwarteter Fehler aufgetreten. Bitte versuchen Sie es zu einem späteren Zeitpunkt.' , 'kirchdorfer' );
    }

  } else {

   	$status = 'success';
   	$text = __( 'Login erfolgreich.', 'kirchdorfer' );

  }

  wp_send_json( array(
		'status' => $status,
		'text' => $text
	) );
}

add_action( 'wp_ajax_nopriv_usersignin', 'kcs_usersignin_handler' );

/**
 * Ajax user register handler
 */
function kcs_userregister_handler() {

  check_ajax_referer( 'userregister-nonce', 'nonce' );

	$salutation = isset( $_POST['register-salutation'] ) ? $_POST['register-salutation'] : '';
  $firstname = isset( $_POST['register-firstname'] ) ? $_POST['register-firstname'] : '';
	$lastname = isset( $_POST['register-lastname'] ) ? $_POST['register-lastname'] : '';
  $company = isset( $_POST['register-company'] ) ? $_POST['register-company'] : '';
  $position = isset( $_POST['register-position'] ) ? $_POST['register-position'] : '';
  $sector = isset( $_POST['register-sector'] ) ? $_POST['register-sector'] : '';
  $street = isset( $_POST['register-street'] ) ? $_POST['register-street'] : '';
  $zip = isset( $_POST['register-zip'] ) ? $_POST['register-zip'] : '';
  $email = isset( $_POST['register-email'] ) ? $_POST['register-email'] : '';
  $phone = isset( $_POST['register-tel'] ) ? $_POST['register-tel'] : '';
  $newsletter = isset( $_POST['register-newsletter'] ) ? true : false;
  $dsgvo = isset( $_POST['register-dsgvo'] ) ? true : false;
  $password = isset( $_POST['register-password'] ) ? $_POST['register-password'] : '';
  $repassword = isset( $_POST['register-repassword'] ) ? $_POST['register-repassword'] : '';

  $fields = array(
	  'register-salutation' => array( 'value' => $salutation, 'required' => true, 'valid' => false ),
	  'register-firstname' => array( 'value' => $firstname, 'required' => true, 'valid' => false ),
	  'register-lastname' => array( 'value' => $lastname, 'required' => true, 'valid' => false ),
	  'register-company' => array( 'value' => $company, 'required' => true, 'valid' => false ),
		'register-position' => array( 'value' => $position, 'required' => true, 'valid' => false ),
		'register-sector' => array( 'value' => $position, 'required' => true, 'valid' => false ),
	  'register-street' => array( 'value' => $street, 'required' => true, 'valid' => false ),
	  'register-zip' => array( 'value' => $zip, 'required' => true, 'valid' => false ),
	  'register-email' => array( 'value' => $email, 'required' => true, 'valid' => false ),
		'register-tel' => array( 'value' => $phone, 'required' => true, 'valid' => false ),
	  'register-newsletter' => array( 'value' => $newsletter, 'required' => false, 'valid' => true ),
	  'register-dsgvo' => array( 'value' => $dsgvo, 'required' => true, 'valid' => false ),
	  'register-password' => array( 'value' => $password, 'required' => true, 'valid' => false ),
	  'register-repassword' => array( 'value' => $repassword, 'required' => true, 'valid' => false ),
  );

  $validaton_error = false;

  foreach( $fields as $key => $field ) {
		if( $field['required'] ) {
			if( !empty( trim ( $field['value'] ) ) ) {
				$fields[$key]['valid'] = true;
			} else {
				$validaton_error = 'empty';
			}
		} else {
			$fields[$key]['valid'] = true;
		}
  }

  if( !$validaton_error && !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
    $validaton_error = 'email';
		$fields['register-email']['valid'] = false;
  }

  if( !$validaton_error && strlen( $password ) < 8 ) {
    $validaton_error = 'passwordlength';
		$fields['register-password']['valid'] = false;
		$fields['register-repassword']['valid'] = false;
  }

  if( !$validaton_error && $password !== $repassword ) {
    $validaton_error = 'passwordmismatch';
		$fields['register-password']['valid'] = false;
		$fields['register-repassword']['valid'] = false;
  }

  if ( !$validaton_error ) {

		$user_data = array(
		  'first_name' => $firstname,
		  'last_name' => $lastname,
	    'user_login' => strtolower( $email ),
	    'user_email' => $email,
	    'user_pass' => $password,
	    'role' => 'downloader'
	  );

		$user_id = wp_insert_user( $user_data );

		if ( !is_wp_error( $user_id ) ) {

			update_user_meta( $user_id, 'salutation', $salutation );
			update_user_meta( $user_id, 'company', $company );
			update_user_meta( $user_id, 'position', $position );
			update_user_meta( $user_id, 'sector', $sector );
			update_user_meta( $user_id, 'street', $street );
			update_user_meta( $user_id, 'zip', $zip );
			update_user_meta( $user_id, 'phone', $phone );
			update_user_meta( $user_id, 'newsletter', $newsletter );
			update_user_meta( $user_id, 'user_status', 'pending' );
			$user_activation_key = wp_generate_password( 40, false );
			update_user_meta( $user_id, 'activate_user_key', $user_activation_key );

			$site_name  = get_bloginfo( 'name' );
		  $admin_email = get_option( 'admin_email' );

		  //Email to user
			$subject_user =  sprintf( __('Website %s – Benutzerkonto aktivieren', 'kirchdorfer' ), $site_name );
			$header_user .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$header_user .= 'From: ' . $site_name . ' <' . $admin_email . "> \r\n";
			$message_user = sprintf( __( 'Sehr %s %s', 'kirchdorfer' ) . '<br><br>', $salutation == 'mr' ? _x( 'geehrter Herr', 'mr', 'kirchdorfer' ) : _x( 'geehrte Frau', 'mrs', 'kirchdorfer' ), $lastname );
			$message_user .= sprintf( __( 'vielen Dank für Ihre Registrierung. Bitte aktivieren Sie Ihr Benutzerkonto unter folgendem Link: %s<br><br>', 'kirchdorfer' ), '<a href="' . home_url() . '?user-activation-key=' . $user_activation_key . '#notification">' . __('Registrierung aktivieren >>', 'kirchdorfer') . '</a>' );
			$message_user .= __( 'Mit freundlichen Grüßen,<br>Ihr Team der Kirchdorfer Concrete Solutions', 'kirchdorfer');
			wp_mail( $email, $subject_user, $message_user, $header_user );

		  //Email to admin
			$subject_admin =  sprintf( __('Website %s – neuer Benutzer', 'kirchdorfer' ), $site_name );
			$header_admin .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$header_admin .= 'From: ' . $site_name . ' <' . $admin_email . "> \r\n";
			$message_admin = __( 'Sehr geehrter Admin,<br><br>', 'kirchdorfer' );
			$message_admin .= __( 'ein neuer Benutzer hat sich auf der Website registriert:<br><br>', 'kirchdorfer' );

			$output_fields = array(
				sprintf( __( 'Anrede: %s', 'kirchdorfer' ), $salutation == 'mr' ? __( 'Herr', 'kirchdorfer' ) : __( 'Frau', 'kirchdorfer' ) ) . ' <br>',
				sprintf( __( 'Vorname: %s', 'kirchdorfer' ), $firstname ) . ' <br>',
				sprintf( __( 'Nachname: %s', 'kirchdorfer' ), $lastname ) . ' <br>',
				sprintf( __( 'Unternehmen: %s', 'kirchdorfer' ), $company ) . ' <br>',
				sprintf( __( 'Position: %s', 'kirchdorfer' ), $position ) . ' <br>',
				sprintf( __( 'Branche: %s', 'kirchdorfer' ), $sector ) . ' <br>',
				sprintf( __( 'Adresse: %s', 'kirchdorfer' ), $street ) . ' <br>',
				sprintf( __( 'PLZ: %s', 'kirchdorfer' ), $zip ) . ' <br>',
				sprintf( __( 'E-Mail-Adresse: %s', 'kirchdorfer' ), $email ) . ' <br>',
				sprintf( __( 'Telefonnummer: %s', 'kirchdorfer' ), $phone ) . ' <br>',
				sprintf( __( 'Newsletter: %s', 'kirchdorfer' ), $newsletter ? __( 'Ja', 'kirchdorfer' ) : __( 'Nein', 'kirchdorfer' ) )
			);

			$message_admin .= implode( '', $output_fields ) . '<br><br>';
			$message_admin .= __( 'Mit freundlichen Grüßen,<br>Ihr Team der Kirchdorfer Concrete Solutions', 'kirchdorfer');

			wp_mail( $admin_email, $subject_admin, $message_admin, $header_admin );

			$status = 'success';
			$text = __( 'Ihre Registrierung war erfolgreich. Bitte verifizieren sie Ihren Benutzer per Link in der an Sie gesendeten E-Mail.', 'kirchdorfer' );

		} else {

	  	if ( isset( $user_id->errors[ 'existing_user_login' ] ) ) {
        $status = 'error';
				$text = __( 'Ein Benutzerkonto mit der selben E-Mail-Adresse besteht bereits. Bitte registrieren Sie sich mit einer anderen E-Mail-Adresse.', 'kirchdorfer' );
    	} else {
        $status = 'error';
				$text = __( 'Leider ist ein Fehler aufgetreten. Bitte versuchen Sie es zu einem späteren Zeitpunkt wieder.', 'kirchdorfer' );
    	}

		}

  } else {
    $status = 'error';
	  if( $validaton_error == 'empty' ) {
			$text = __( 'Bitte füllen Sie alle Pflichtfelder aus.', 'kirchdorfer' );
	  } else if( $validaton_error == 'email' ) {
			$text = __( 'Bitte geben Sie eine valide E-Mail-Adresse ein.', 'kirchdorfer' );
	  } else if( $validaton_error == 'passwordlength' ) {
			$text = __( 'Das gewählte Passwort ist zu kurz. Das Passwort muss mindestens 8 Zeichen lang sein.', 'kirchdorfer' );
	  } else if( $validaton_error == 'passwordmismatch' ) {
			$text = __( 'Die eingegebenen Passwörter stimmen nicht überein. Die Passwörter müssen ident sein.', 'kirchdorfer' );
	  }
  }

  wp_send_json( array(
		'status' => $status,
		'text' => $text,
		'fields' => $fields
	) );
}

add_action( 'wp_ajax_userregister', 'kcs_userregister_handler' );
add_action( 'wp_ajax_nopriv_userregister', 'kcs_userregister_handler' );

/**
 * Ajax user changedata handler
 */
function kcs_userchangedata_handler() {

  check_ajax_referer( 'userchangedata-nonce', 'nonce' );

	$salutation = isset( $_POST['changedata-salutation'] ) ? $_POST['changedata-salutation'] : '';
  $firstname = isset( $_POST['changedata-firstname'] ) ? $_POST['changedata-firstname'] : '';
	$lastname = isset( $_POST['changedata-lastname'] ) ? $_POST['changedata-lastname'] : '';
  $company = isset( $_POST['changedata-company'] ) ? $_POST['changedata-company'] : '';
  $position = isset( $_POST['changedata-position'] ) ? $_POST['changedata-position'] : '';
  $sector = isset( $_POST['changedata-sector'] ) ? $_POST['changedata-sector'] : '';
  $street = isset( $_POST['changedata-street'] ) ? $_POST['changedata-street'] : '';
  $zip = isset( $_POST['changedata-zip'] ) ? $_POST['changedata-zip'] : '';
  $phone = isset( $_POST['changedata-tel'] ) ? $_POST['changedata-tel'] : '';
  $newsletter = isset( $_POST['changedata-newsletter'] ) ? true : false;

  $fields = array(
	  'changedata-salutation' => array( 'value' => $salutation, 'required' => true, 'valid' => false ),
	  'changedata-firstname' => array( 'value' => $firstname, 'required' => true, 'valid' => false ),
	  'changedata-lastname' => array( 'value' => $lastname, 'required' => true, 'valid' => false ),
	  'changedata-company' => array( 'value' => $company, 'required' => true, 'valid' => false ),
		'changedata-position' => array( 'value' => $position, 'required' => true, 'valid' => false ),
		'changedata-sector' => array( 'value' => $position, 'required' => true, 'valid' => false ),
	  'changedata-street' => array( 'value' => $street, 'required' => true, 'valid' => false ),
	  'changedata-zip' => array( 'value' => $zip, 'required' => true, 'valid' => false ),
		'changedata-tel' => array( 'value' => $phone, 'required' => true, 'valid' => false ),
	  'changedata-newsletter' => array( 'value' => $newsletter, 'required' => false, 'valid' => true ),
  );

  $validaton_error = false;

  foreach( $fields as $key => $field ) {
		if( $field['required'] ) {
			if( !empty( trim ( $field['value'] ) ) ) {
				$fields[$key]['valid'] = true;
			} else {
				$validaton_error = 'empty';
			}
		} else {
			$fields[$key]['valid'] = true;
		}
  }

  $user_id = get_current_user_id();

  if ( !$validaton_error ) {
		update_user_meta( $user_id, 'salutation', $salutation );
		update_user_meta( $user_id, 'company', $company );
		update_user_meta( $user_id, 'position', $position );
		update_user_meta( $user_id, 'sector', $sector );
		update_user_meta( $user_id, 'street', $street );
		update_user_meta( $user_id, 'zip', $zip );
		update_user_meta( $user_id, 'phone', $phone );
		update_user_meta( $user_id, 'newsletter', $newsletter );

		$status = 'success';
		$text = __( 'Ihre Daten wurden erfolgreich geändert.', 'kirchdorfer' );
  } else {
    $status = 'error';
	  if( $validaton_error == 'empty' ) {
			$text = __( 'Bitte füllen Sie alle Pflichtfelder aus.', 'kirchdorfer' );
	  }
  }

  wp_send_json( array(
		'status' => $status,
		'text' => $text,
		'fields' => $fields
	) );
}

add_action( 'wp_ajax_userchangedata', 'kcs_userchangedata_handler' );

/**
 * Ajax user change password handler
 */
function kcs_userchangepassword_handler() {

  check_ajax_referer( 'userchangepassword-nonce', 'nonce' );

	$actualpassword = isset( $_POST['changepassword-actualpassword'] ) ? $_POST['changepassword-actualpassword'] : '';
  $password = isset( $_POST['changepassword-password'] ) ? $_POST['changepassword-password'] : '';
  $repassword = isset( $_POST['changepassword-repassword'] ) ? $_POST['changepassword-repassword'] : '';

  $fields = array(
	  'changepassword-actualpassword' => array( 'value' => $actualpassword, 'required' => true, 'valid' => false ),
	  'changepassword-password' => array( 'value' => $password, 'required' => true, 'valid' => false ),
	  'changepassword-repassword' => array( 'value' => $repassword, 'required' => true, 'valid' => false ),
  );

  $validaton_error = false;

  foreach( $fields as $key => $field ) {
		if( $field['required'] ) {
			if( !empty( trim ( $field['value'] ) ) ) {
				$fields[$key]['valid'] = true;
			} else {
				$validaton_error = 'empty';
			}
		} else {
			$fields[$key]['valid'] = true;
		}
  }

  $user = wp_get_current_user();

  if( !$validaton_error && !wp_check_password( $actualpassword, $user->user_pass, $user->ID )) {
    $validaton_error = 'actualpasswordincorrect';
		$fields['changepassword-actualpassword']['valid'] = false;
  }

  if( !$validaton_error && strlen( $password ) < 8 ) {
    $validaton_error = 'passwordlength';
		$fields['changepassword-password']['valid'] = false;
		$fields['changepassword-repassword']['valid'] = false;
  }

  if( !$validaton_error && $password !== $repassword ) {
    $validaton_error = 'passwordmismatch';
		$fields['changepassword-password']['valid'] = false;
		$fields['changepassword-repassword']['valid'] = false;
  }

  if ( !$validaton_error ) {

	  wp_set_password( $password, $user->ID );

		$status = 'success';
		$text = __( 'Ihr Passwort wurde erfolgreich geändert.', 'kirchdorfer' );

  } else {
    $status = 'error';
	  if( $validaton_error == 'empty' ) {
			$text = __( 'Bitte füllen Sie alle Pflichtfelder aus.', 'kirchdorfer' );
	  } else if( $validaton_error == 'actualpasswordincorrect' ) {
			$text = __( 'Üngültiges derzeitiges Passwort.', 'kirchdorfer' );
	  } else if( $validaton_error == 'passwordlength' ) {
			$text = __( 'Das gewählte Passwort ist zu kurz. Das Passwort muss mindestens 8 Zeichen lang sein.', 'kirchdorfer' );
	  } else if( $validaton_error == 'passwordmismatch' ) {
			$text = __( 'Die eingegebenen Passwörter stimmen nicht überein. Die Passwörter müssen ident sein.', 'kirchdorfer' );
	  }
  }

  wp_send_json( array(
		'status' => $status,
		'text' => $text,
		'fields' => $fields
	) );
}

add_action( 'wp_ajax_userchangepassword', 'kcs_userchangepassword_handler' );
add_action( 'wp_ajax_nopriv_userchangepassword', 'kcs_userchangepassword_handler' );

function kcs_userforgotpassword_handler() {
  check_ajax_referer( 'userforgotpassword-nonce', 'nonce' );

  $email = isset( $_POST['forgotpw-email'] ) ? $_POST['forgotpw-email'] : '';
	$validation_error = false;

	$fields = array(
	  'forgotpw-email' => array( 'value' => $email, 'required' => true, 'valid' => false ),
  );

	if( !is_email( $email ) ) {
		$validation_error = 'email';
	}

	if( !$validation_error && !email_exists( $email ) ) $validation_error = 'notregistered';

	if( !$validation_error ) {

		$user = get_user_by( 'email', trim( $email ) );

		$user_login = $user->user_login;
		$user_email = $user->user_email;

		$salutation = get_user_meta( $user->ID, 'salutation', true );
		$title = get_user_meta( $user->ID, 'title', true );
		$lastname = get_user_meta( $user->ID, 'last_name', true );
		$key = get_password_reset_key( $user );

		if( ! is_wp_error( $key ) ) {

			$fields['forgotpw-email']['valid'] = true;

			$site_name  = get_bloginfo( 'name' );
		  $admin_email = get_option( 'admin_email' );

		  //Email to user
			$subject_user =  sprintf( __('Website %s – Passwort vergessen', 'kirchdorfer' ), $site_name );
			$header_user .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$header_user .= 'From: ' . $site_name . ' <' . $admin_email . "> \r\n";
			$message_user = sprintf( 'Sehr %s %s,<br><br>', $salutation == 'mr' ? _x( 'geehrter Herr', 'mr', 'kirchdorfer' ) : _x( 'geehrte Frau', 'mrs', 'kirchdorfer' ), $lastname );

			$message_user .= sprintf( __( 'es wurde eine Anfrage gestellt, um das Kennwort für das Benutzerkonto mit der E-Mail-Adresse %s zurückzusetzen.<br><br>Wenn dies nicht beabsichtigt war, ignorieren Sie einfach diese E-Mail.<br><br>Um das Passwort zurückzusetzen, klicken Sie bitte auf den folgenden Link: %s<br><br>', 'avi' ), $user_email, '<a href="' . home_url() . '?action=rp&key=' . $key . '&login=' . rawurlencode( $user_login ) . '#reset-password">' . __( 'Passwort zurücksetzen >>', 'kirchdorfer' ) . '</a>' );
			$message_user .= __( 'Mit freundlichen Grüßen,<br>Ihr Team der Kirchdorfer Concrete Solutions', 'kirchdorfer');
			wp_mail( $user_email, $subject_user, $message_user, $header_user );

	    $status = 'success';
			$text = __( 'Bitte überprüfe Sie ihren E-Mail-Eingang für den Bestätigungslink zum Zurücksetzen des Passworts.', 'avi' );

		} else {
			$status = 'error';
			$text = __( 'Es ist ein Key-Generierungsfehler aufgetreten. Bitte versuchen Sie es nochmals.', 'avi' );
		}

	} else {
		if( $validation_error == 'email' ) {
			$status = 'error';
			$text = __( 'Die eingegebene E-Mail-Adresse ist leer oder ungültig.', 'kirchdorfer' );
		} else if( $validation_error == 'notregistered' ) {
			$status = 'error';
			$text = __( 'Es existiert kein User zu dieser E-Mail-Adresse.', 'kirchdorfer' );
		}
	}

  wp_send_json( array(
		'status' => $status,
		'text' => $text,
		'fields' => $fields
	) );
}

add_action( 'wp_ajax_userforgotpassword', 'kcs_userforgotpassword_handler' );
add_action( 'wp_ajax_nopriv_userforgotpassword', 'kcs_userforgotpassword_handler' );

function kcs_userresetpassword_handler() {
	check_ajax_referer( 'userresetpassword-nonce', 'nonce' );

  $password = isset( $_POST['reset-password'] ) ? $_POST['reset-password'] : '';
  $repassword = isset( $_POST['reset-repassword'] ) ? $_POST['reset-repassword'] : '';
  $key = isset( $_POST['user_key'] ) ? $_POST['user_key'] : '';
  $login = isset( $_POST['user_login'] ) ? $_POST['user_login'] : '';

  $fields = array(
	  'reset-password' => array( 'value' => $password, 'required' => true, 'valid' => false ),
	  'reset-repassword' => array( 'value' => $repassword, 'required' => true, 'valid' => false ),
  );

	$validaton_error = false;

	$user = check_password_reset_key( $key, $login );

	if( !$user || is_wp_error( $user ) ) {
		$validaton_error = 'key';
	}

	if( !$validaton_error ) {
	  foreach( $fields as $key => $field ) {
			if( $field['required'] ) {
				var_dump(empty( trim ( $field['value'] ) ));
				if( !empty( trim ( $field['value'] ) ) ) {
					$fields[$key]['valid'] = true;
				} else {
					$validaton_error = 'empty';
				}
			} else {
				$fields[$key]['valid'] = true;
			}
	  }
	}

  if( !$validaton_error && strlen( $password ) < 8 ) {
    $validaton_error = 'passwordlength';
		$fields['register-password']['valid'] = false;
		$fields['register-repassword']['valid'] = false;
  }

  if( !$validaton_error && $password !== $repassword ) {
    $validaton_error = 'passwordmismatch';
		$fields['register-password']['valid'] = false;
		$fields['register-repassword']['valid'] = false;
  }

	if ( !$validaton_error ) {
		reset_password( $user, $password );

	  $status = 'success';
	  $text = __( 'Das Passwort wurde erfolgreich zurückgesetzt.', 'kirchdorfer' );
	} else {
		$status = 'error';
		if( $validaton_error == 'key' ) {
			if ( $user->get_error_code() === 'expired_key' ) {
			  $text = __( 'Key ist abgelaufen.', 'kirchdorfer' );
			} else if( $user->get_error_code() === 'invalid_key' ) {
				$text = __( 'Key ist nicht valide.', 'kirchdorfer' );
			} else {
				$text = __( 'Es ist ein Fehler aufgetreten.', 'kirchdorfer' );
			}
		}
	  if( $validaton_error == 'empty' ) {
			$text = __( 'Bitte füllen Sie alle Pflichtfelder aus.', 'kirchdorfer' );
	  } else if( $validaton_error == 'passwordlength' ) {
			$text = __( 'Das gewählte Passwort ist zu kurz. Das Passwort muss mindestens 8 Zeichen lang sein.', 'kirchdorfer' );
	  } else if( $validaton_error == 'passwordmismatch' ) {
			$text = __( 'Die eingegebenen Passwörter stimmen nicht überein. Die Passwörter müssen ident sein.', 'kirchdorfer' );
	  }
	}

  wp_send_json( array(
		'status' => $status,
		'text' => $text,
		'fields' => $fields
	) );
}

add_action( 'wp_ajax_userresetpassword', 'kcs_userresetpassword_handler' );
add_action( 'wp_ajax_nopriv_userresetpassword', 'kcs_userresetpassword_handler' );