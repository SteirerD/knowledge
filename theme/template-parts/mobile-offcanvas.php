<div class="c-mobile-offcanvas">
  <div class="c-mobile-offcanvas__main">
    <div class="c-main-nav-mobile">
      <?php wp_nav_menu( array( 'theme_location' => 'mainmenu', 'menu_id' => 'c-main-nav-mobile__ul', 'menu_class' => 'c-main-nav-mobile__ul', 'container' => false, 'depth' => 2, 'walker' => new MainNavMobileWalker() ) ); ?>
    </div>
<!--    <div class="c-main-header__logo-mobile">-->
<!--      <a href="--><?php //echo esc_url( home_url( '/' ) ); ?><!--" class="c-main-header__logo-link">-->
<!--        <img src="--><?php //echo get_stylesheet_directory_uri() . '/assets/img/Logo.png'; ?><!--"-->
<!--             class="c-main-header__logo-img" alt="Logo Steirerhaus">-->
<!--      </a>-->
<!--    </div>-->
    <?php
      $link = get_field('general_link_archive', 'options');
      if($link && get_field('general_show_button_rent', 'options')):
        ?>
        <div class="c-main-header__rent-logo__wrapper-mobile">
          <div class="c-main-header__rent-logo">
            <span class="c-main-header__rent-logo-text">MIETEN</span>
            <a class="c-main-header__rent-logo-link" href="<?php echo $link ?>"></a>
          </div>
        </div>
      <?php endif; ?>
  </div>

</div>
