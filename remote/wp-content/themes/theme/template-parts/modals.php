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
						<div class="l-col l-col-12">
							<div class="o-input o-input--floating-label">
	              <input type="text" name="signin-email" id="signin-email" class="o-input__field" placeholder="<?php _e( 'E-Mail-Adresse', 'wiki' ); ?>" required>
	              <label for="signin-email" class="o-input__label"><?php _e( 'E-Mail-Adresse', 'wiki' ); ?></label>
	            </div>
						</div>

						<div class="l-col l-col-12">
	            <div class="o-input o-input--floating-label">
	              <input type="password" name="signin-password" id="signin-password" class="o-input__field" placeholder="<?php _e( 'Passwort', 'wiki' ); ?>" autocomplete="on" required>
	              <label for="signin-password" class="o-input__label"><?php _e( 'Passwort', 'wiki' ); ?></label>
	            </div>
						</div>

						<input type="hidden" name="action" value="usersignin">
						<input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'usersignin-nonce' ); ?>">

						<div class="l-col l-col-12">
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
							<div class="l-col l-col-12">
		            <div class="c-forgot-password__description"><?php _e( 'Bitte gib deine E-Mail-Adresse hier ein. Du bekommst eine E-Mail zugesandt, mit deren Hilfe du ein neues Passwort setzen kannst.', 'wiki' ); ?></div>
							</div>
							<div class="l-col l-col-12">
		            <div class="o-input o-input--floating-label">
		              <input type="email" name="forgotpw-email" id="forgotpw-email" class="o-input__field" placeholder="<?php _e( 'E-Mail-Adresse', 'wiki' ); ?>" required>
		              <label for="forgotpw-email" class="o-input__label"><?php _e( 'E-Mail-Adresse', 'wiki' ); ?></label>
		            </div>
							</div>

							<input type="hidden" name="action" value="userforgotpassword">
							<input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'userforgotpassword-nonce' ); ?>">

							<div class="l-col l-col-12">
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

<div class="c-modal c-modal--large c-modal--add-post" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="c-modal__backdrop"></div>
  <div class="c-modal__dialog" role="document">
    <div class="c-modal__content">
      <button type="button" class="c-modal__close" aria-label="Close"><svg viewBox="0 0 8.11 8.11"><path d="M49,51l-2.86-2.86a.71.71,0,0,1,0-1,.71.71,0,0,1,1,0L50,50l2.86-2.86a.7.7,0,1,1,1,1L51,51l2.86,2.86a.71.71,0,0,1-.49,1.2.71.71,0,0,1-.5-.21L50,52l-2.86,2.86a.69.69,0,0,1-1,0,.71.71,0,0,1,0-1Z" transform="translate(-45.95 -46.95)"></path></svg></button>
      <div class="c-modal__header">
        <?php _e( 'Neuer Eintrag', 'wiki' ); ?>
      </div>
      <div class="c-modal__response"></div>
      <div class="c-modal__body">
        <form class="c-modal__form" novalidate>
          <div class="l-row">
            <div class="l-col l-col-12">
              <div class="o-input o-input--floating-label">
                <input type="text" name="add-post-title" id="add-post-title" class="o-input__field" placeholder="<?php _e( 'Titel', 'wiki' ); ?>" required>
                <label for="add-post-title" class="o-input__label"><?php _e( 'Titel', 'wiki' ); ?></label>
              </div>
            </div>

            <div class="l-col l-col-12">
              <div class="o-input o-input--floating-label">
                <textarea type="password" name="add-post-text" id="add-post-text" class="o-input__field" placeholder="<?php _e( 'Text', 'wiki' ); ?>"></textarea>
                <label for="add-post-text" class="o-input__label"><?php _e( 'Text', 'wiki' ); ?></label>
              </div>
            </div>
            
            <?php
              $args = array(
                'hide_empty' => 0,
              );
              $categories = get_categories($args);
              
              foreach ($categories as $category):
                if ( is_user_logged_in() ||  ! get_field('blog_private', $category)):?>
                    <div class="l-col l-col-6">
                      <div class="o-checkbox">
                        <input class="o-checkbox__input" type="checkbox" name="add-post-<?php echo $category->slug ?>" id="add-post-<?php echo $category->slug ?>" value="1" required>
                        <label class="o-checkbox__label" for="add-post-<?php echo $category->slug ?>"><?php echo $category->name ?>
                      </div>
                    </div>
            <?php
               endif;
              endforeach;
            ?>

            
            <input type="hidden" name="action" value="add-post">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'add-post-nonce' ); ?>">

            <div class="l-col l-col-12">
              <div class="c-modal__form-submit-container">
                <button type="submit" class="o-button"><?php _e( 'Neuen Eintrag speichern', 'wiki' ); ?></button>
              </div>
            </div>
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
						<div class="l-col l-col-12">
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

