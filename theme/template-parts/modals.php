<div class="c-modal c-modal--signin" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="c-modal__backdrop"></div>
  <div class="c-modal__dialog" role="document">
    <div class="c-modal__content">
      <button type="button" class="c-modal__close" aria-label="Close"><svg viewBox="0 0 8.11 8.11"><path d="M49,51l-2.86-2.86a.71.71,0,0,1,0-1,.71.71,0,0,1,1,0L50,50l2.86-2.86a.7.7,0,1,1,1,1L51,51l2.86,2.86a.71.71,0,0,1-.49,1.2.71.71,0,0,1-.5-.21L50,52l-2.86,2.86a.69.69,0,0,1-1,0,.71.71,0,0,1,0-1Z" transform="translate(-45.95 -46.95)"></path></svg></button>
			<div class="c-modal__header">
				<?php _e( 'Login', 'wiki' ); ?>
			</div>
      <div class="c-modal__response"></div>
      <div class="c-modal__body">
        <form class="c-modal__form" novalidate>
	        <div class="l-row">
						<div class="l-col l-col-24">
							<div class="o-input o-input--floating-label">
	              <input type="text" name="signin-email" id="signin-email" class="o-input__field" placeholder="<?php _e( 'E-Mail-Adresse', 'wiki' ); ?>" required>
	              <label for="signin-email" class="o-input__label"><?php _e( 'E-Mail-Adresse', 'wiki' ); ?></label>
	            </div>
						</div>

						<div class="l-col l-col-24">
	            <div class="o-input o-input--floating-label">
	              <input type="password" name="signin-password" id="signin-password" class="o-input__field" placeholder="<?php _e( 'Passwort', 'wiki' ); ?>" autocomplete="on" required>
	              <label for="signin-password" class="o-input__label"><?php _e( 'Passwort', 'wiki' ); ?></label>
	            </div>
						</div>

						<input type="hidden" name="action" value="usersignin">
						<input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'usersignin-nonce' ); ?>">

						<div class="l-col l-col-24">
	            <div class="c-modal__form-submit-container">
	            	<button type="submit" class="o-button"><?php _e( 'Einloggen', 'wiki' ); ?></button>
							</div>
						</div>
	        </div>
        </form>
        <div class="c-modal__notes">
        	<a class="c-modal__trigger-footer-link" href=""><?php _e( 'Passwort vergessen?', 'wiki' ); ?></a>
				</div>
      </div>
			<div class="c-modal__footer">
				<div class="c-forgot-password">
      		<form class="c-forgot-password__form" novalidate>
        		<div class="l-row">
							<div class="l-col l-col-24">
		            <div class="c-forgot-password__description"><?php _e( 'Bitte gib deine E-Mail-Adresse hier ein. Du bekommst eine E-Mail zugesandt, mit deren Hilfe du ein neues Passwort setzen kannst.', 'wiki' ); ?></div>
							</div>
							<div class="l-col l-col-24">
		            <div class="o-input o-input--floating-label">
		              <input type="email" name="forgotpw-email" id="forgotpw-email" class="o-input__field" placeholder="<?php _e( 'E-Mail-Adresse', 'wiki' ); ?>" required>
		              <label for="forgotpw-email" class="o-input__label"><?php _e( 'E-Mail-Adresse', 'wiki' ); ?></label>
		            </div>
							</div>

							<input type="hidden" name="action" value="userforgotpassword">
							<input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'userforgotpassword-nonce' ); ?>">

							<div class="l-col l-col-24">
		            <div class="c-modal__form-submit-container">
		            	<button type="submit" class="o-button"><?php _e( 'Passwort anfordern', 'wiki' ); ?></button>
								</div>
							</div>
        		</div>
      		</form>
				</div>
      </div>
    </div>
  </div>
</div>


<div class="c-modal c-modal--no-permission" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="c-modal__backdrop"></div>
  <div class="c-modal__dialog" role="document">
    <div class="c-modal__content">
      <button type="button" class="c-modal__close" aria-label="Close"><svg viewBox="0 0 8.11 8.11"><path d="M49,51l-2.86-2.86a.71.71,0,0,1,0-1,.71.71,0,0,1,1,0L50,50l2.86-2.86a.7.7,0,1,1,1,1L51,51l2.86,2.86a.71.71,0,0,1-.49,1.2.71.71,0,0,1-.5-.21L50,52l-2.86,2.86a.69.69,0,0,1-1,0,.71.71,0,0,1,0-1Z" transform="translate(-45.95 -46.95)"></path></svg></button>
			<div class="c-modal__header">
				<?php _e( 'Sie müssen Kunden sein um diesen Inhalt nutzen zu können', 'wiki' ); ?>
			</div>
      <div class="c-modal__body">
        <div class="c-modal__controls">
	        <div class="l-row l-row--gap-small">
						<div class="l-col l-col-12">
	            <div class="c-modal__control">
	            	<a href="#login" class="o-button o-button--full-width"><?php _e( 'Login', 'wiki' ); ?></a>
							</div>
						</div>
						<div class="l-col l-col-12">
	            <div class="c-modal__control">
	            	<a href="#register" class="o-button o-button--full-width"><?php _e( 'Registrieren', 'wiki' ); ?></a>
							</div>
						</div>
	        </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="c-modal c-modal--notification<?php echo isset( $_SESSION['kcs_modal_notification'] ) ? ' is-loaded-initial' : ''; ?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="c-modal__backdrop"></div>
  <div class="c-modal__dialog" role="document">
    <div class="c-modal__content">
      <button type="button" class="c-modal__close" aria-label="Close"><svg viewBox="0 0 8.11 8.11"><path d="M49,51l-2.86-2.86a.71.71,0,0,1,0-1,.71.71,0,0,1,1,0L50,50l2.86-2.86a.7.7,0,1,1,1,1L51,51l2.86,2.86a.71.71,0,0,1-.49,1.2.71.71,0,0,1-.5-.21L50,52l-2.86,2.86a.69.69,0,0,1-1,0,.71.71,0,0,1,0-1Z" transform="translate(-45.95 -46.95)"></path></svg></button>
			<div class="c-modal__header"><?php echo isset( $_SESSION['kcs_modal_notification']['title'] ) ? $_SESSION['kcs_modal_notification']['title'] : ''; ?></div>
      <div class="c-modal__body">
	      <div class="c-modal__text">
	        <?php
		      echo isset( $_SESSION['kcs_modal_notification']['text'] ) ? $_SESSION['kcs_modal_notification']['text'] : '';
		      unset( $_SESSION['kcs_modal_notification'] );
		      unset( $_SESSION['ap_headernotificiaton_message'] );
		      ?>
	      </div>
        <div class="c-modal__controls">
	        <div class="l-row l-row--gap-small">
						<div class="l-col l-col-24">
	            <div class="c-modal__control">
	            	<a href="" class="o-button c-modal__button-close"><?php _e( 'Schließen', 'wiki' ); ?></a>
							</div>
						</div>
	        </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php if( is_user_logged_in() ) :
	$user_data = get_userdata( get_current_user_id() );

	$salutation = get_user_meta( $user->ID, 'salutation', true );
	$firstname = get_user_meta( $user->ID, 'first_name', true );
	$lastname = get_user_meta( $user->ID, 'last_name', true );
	$company = get_user_meta( $user->ID, 'company', true );
	$position = get_user_meta( $user->ID, 'position', true );
	$sector = get_user_meta( $user->ID, 'sector', true );
	$street = get_user_meta( $user->ID, 'street', true );
	$zip = get_user_meta( $user->ID, 'zip', true );
	$phone = get_user_meta( $user->ID, 'phone', true );
	$newsletter = get_user_meta( $user->ID, 'newsletter', true );
	?>
	<div class="c-modal c-modal--changedata c-modal--large" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="c-modal__backdrop"></div>
	  <div class="c-modal__dialog" role="document">
	    <div class="c-modal__content">
	      <button type="button" class="c-modal__close" aria-label="Close"><svg viewBox="0 0 8.11 8.11"><path d="M49,51l-2.86-2.86a.71.71,0,0,1,0-1,.71.71,0,0,1,1,0L50,50l2.86-2.86a.7.7,0,1,1,1,1L51,51l2.86,2.86a.71.71,0,0,1-.49,1.2.71.71,0,0,1-.5-.21L50,52l-2.86,2.86a.69.69,0,0,1-1,0,.71.71,0,0,1,0-1Z" transform="translate(-45.95 -46.95)"></path></svg></button>
				<div class="c-modal__header">
					<?php _e( 'Daten ändern', 'wiki' ); ?>
				</div>
	      <div class="c-modal__response"></div>
	      <div class="c-modal__body">
	        <div class="c-modal__text">
		        <?php _e( 'Ändern Sie Daten für ihren Benutzer.', 'wiki' ); ?>
	        </div>
	        <form class="c-modal__form" novalidate>
		        <div class="l-row l-row--gap-xsmall">
							<div class="l-col l-col-12">
								<div class="o-select">
									<div class="o-select__arrow">
										<svg width="24" height="12" viewBox="0 0 24 12"><polygon points="0 0 12 12 24 0 19.96 0 12 7.96 4.04 0 0 0" /></svg>
									</div>
									<select class="o-select__select" name="changedata-salutation" id="changedata-salutation" required>
		                <option value="" disabled><?php _e( 'Anrede', 'wiki' ); ?></option>
		                <option value="mrs" <?php selected( 'mrs', $salutation, true ); ?>><?php _e( 'Frau', 'wiki' ); ?></option>
										<option value="mr" <?php selected( 'mr', $salutation, true ); ?>><?php _e( 'Herr', 'wiki' ); ?></option>
		              </select>
		              <label for="changedata-salutation" class="o-select__label"><?php _e( 'Anrede', 'wiki' ); ?></label>
								</div>
							</div>

							<div class="l-col l-col-12">
		            <div class="o-input o-input--floating-label">
		              <input type="text" name="changedata-firstname" id="changedata-firstname" class="o-input__field" placeholder="<?php _e( 'Vorname', 'wiki' ); ?>" value="<?php echo $user_data->first_name; ?>" required>
		              <label for="changedata-firstname" class="o-input__label"><?php _e( 'Vorname', 'wiki' ); ?></label>
		            </div>
							</div>

							<div class="l-col l-col-12">
		            <div class="o-input o-input--floating-label">
		              <input type="text" name="changedata-lastname" id="changedata-lastname" class="o-input__field" placeholder="<?php _e( 'Nachname', 'wiki' ); ?>" value="<?php echo $user_data->last_name; ?>" required>
		              <label for="changedata-lastname" class="o-input__label"><?php _e( 'Nachname', 'wiki' ); ?></label>
		            </div>
							</div>

							<div class="l-col l-col-12">
		            <div class="o-input o-input--floating-label">
		              <input type="text" name="changedata-company" id="changedata-company" class="o-input__field" placeholder="<?php _e( 'Unternehmen', 'wiki' ); ?>" value="<?php echo $company; ?>" required>
		              <label for="changedata-company" class="o-input__label"><?php _e( 'Unternehmen', 'wiki' ); ?></label>
		            </div>
							</div>

							<div class="l-col l-col-12">
		            <div class="o-input o-input--floating-label">
		              <input type="text" name="changedata-position" id="changedata-position" class="o-input__field" placeholder="<?php _e( 'Position', 'wiki' ); ?>" value="<?php echo $position; ?>" required>
		              <label for="changedata-position" class="o-input__label"><?php _e( 'Position', 'wiki' ); ?></label>
		            </div>
							</div>

							<div class="l-col l-col-12">
		            <div class="o-input o-input--floating-label">
		              <input type="text" name="changedata-sector" id="changedata-sector" class="o-input__field" placeholder="<?php _e( 'Branche', 'wiki' ); ?>" value="<?php echo $sector; ?>" required>
		              <label for="changedata-sector" class="o-input__label"><?php _e( 'Branche', 'wiki' ); ?></label>
		            </div>
							</div>

							<div class="l-col l-col-12">
		            <div class="o-input o-input--floating-label">
		              <input type="text" name="changedata-street" id="changedata-street" class="o-input__field" placeholder="<?php _e( 'Adresse', 'wiki' ); ?>" value="<?php echo $street; ?>" required>
		              <label for="changedata-street" class="o-input__label"><?php _e( 'Adresse', 'wiki' ); ?></label>
		            </div>
							</div>

							<div class="l-col l-col-12">
		            <div class="o-input o-input--floating-label">
		              <input type="text" name="changedata-zip" id="changedata-zip" class="o-input__field" placeholder="<?php _e( 'Postleitzahl', 'wiki' ); ?>" value="<?php echo $zip; ?>" required>
		              <label for="changedata-zip" class="o-input__label"><?php _e( 'Postleitzahl', 'wiki' ); ?></label>
		            </div>
							</div>

							<div class="l-col l-col-12">
		            <div class="o-input o-input--floating-label">
		              <input type="text" name="changedata-tel" id="changedata-tel" class="o-input__field" placeholder="<?php _e( 'Telefonnummer', 'wiki' ); ?>" value="<?php echo $phone; ?>" required>
		              <label for="changedata-tel" class="o-input__label"><?php _e( 'Telefonnummer', 'wiki' ); ?></label>
		            </div>
							</div>

							<div class="l-col l-col-12">
		            <div class="o-input o-input--floating-label">
		              <input type="email" name="changedata-email" id="changedata-email" class="o-input__field" placeholder="<?php _e( 'E-Mail-Adresse', 'wiki' ); ?>" value="<?php echo $user_data->user_email; ?>" readonly required>
		              <label for="changedata-email" class="o-input__label"><?php _e( 'E-Mail-Adresse', 'wiki' ); ?></label>
		            </div>
							</div>

							<div class="l-col l-col-24">
		            <div class="o-checkbox o-checkbox--margintop">
						    	<input class="o-checkbox__input" type="checkbox" name="changedata-newsletter" id="changedata-newsletter" value="1" <?php checked( $newsletter ); ?>>
						    	<label class="o-checkbox__label" for="changedata-newsletter"><?php _e( 'Ja, ich möchte ab sofort den Newsletter erhalten.', 'wiki' ); ?></label>
								</div>
							</div>

							<input type="hidden" name="action" value="userchangedata">
							<input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'userchangedata-nonce' ); ?>">

							<div class="l-col l-col-24">
		            <div class="c-modal__form-submit-container">
		            	<button type="submit" class="o-button"><?php _e( 'Ändern', 'wiki' ); ?></button>
								</div>
							</div>
		        </div>
	        </form>
	      </div>
	    </div>
	  </div>
	</div>
<?php endif; ?>
