<?php

  class MainNavMobileWalker extends Walker_Nav_Menu {

    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
      if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
        $t = '';
        $n = '';
      } else {
        $t = "\t";
        $n = "\n";
      }
      $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

      $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
      $classes[] = 'menu-item-' . $item->ID;

      /**
       * Filters the arguments for a single nav menu item.
       *
       * @since 4.4.0
       *
       * @param stdClass $args  An object of wp_nav_menu() arguments.
       * @param WP_Post  $item  Menu item data object.
       * @param int      $depth Depth of menu item. Used for padding.
       */
      $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

      /**
       * Filters the CSS classes applied to a menu item's list item element.
       *
       * @since 3.0.0
       * @since 4.1.0 The `$depth` parameter was added.
       *
       * @param string[] $classes Array of the CSS classes that are applied to the menu item's `<li>` element.
       * @param WP_Post  $item    The current menu item.
       * @param stdClass $args    An object of wp_nav_menu() arguments.
       * @param int      $depth   Depth of menu item. Used for padding.
       */
      $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
      $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

      /**
       * Filters the ID applied to a menu item's list item element.
       *
       * @since 3.0.1
       * @since 4.1.0 The `$depth` parameter was added.
       *
       * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
       * @param WP_Post  $item    The current menu item.
       * @param stdClass $args    An object of wp_nav_menu() arguments.
       * @param int      $depth   Depth of menu item. Used for padding.
       */
      $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
      $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

      $output .= $indent . '<li' . $id . $class_names . '>';

      $atts           = array();
      $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
      $atts['target'] = ! empty( $item->target ) ? $item->target : '';
      if ( '_blank' === $item->target && empty( $item->xfn ) ) {
        $atts['rel'] = 'noopener noreferrer';
      } else {
        $atts['rel'] = $item->xfn;
      }
      $atts['href']         = ! empty( $item->url ) ? $item->url : '';
      $atts['aria-current'] = $item->current ? 'page' : '';

      /**
       * Filters the HTML attributes applied to a menu item's anchor element.
       *
       * @since 3.6.0
       * @since 4.1.0 The `$depth` parameter was added.
       *
       * @param array $atts {
       *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
       *
       *     @type string $title        Title attribute.
       *     @type string $target       Target attribute.
       *     @type string $rel          The rel attribute.
       *     @type string $href         The href attribute.
       *     @type string $aria_current The aria-current attribute.
       * }
       * @param WP_Post  $item  The current menu item.
       * @param stdClass $args  An object of wp_nav_menu() arguments.
       * @param int      $depth Depth of menu item. Used for padding.
       */
      $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

      $attributes = '';
      foreach ( $atts as $attr => $value ) {
        if ( ! empty( $value ) ) {
          $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
          $attributes .= ' ' . $attr . '="' . $value . '"';
        }
      }

      /** This filter is documented in wp-includes/post-template.php */
      $title = apply_filters( 'the_title', $item->title, $item->ID );

      /**
       * Filters a menu item's title.
       *
       * @since 4.4.0
       *
       * @param string   $title The menu item's title.
       * @param WP_Post  $item  The current menu item.
       * @param stdClass $args  An object of wp_nav_menu() arguments.
       * @param int      $depth Depth of menu item. Used for padding.
       */
      $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

      $item_output  = $args->before;
      $item_output .= '<div class="menu-item__inner">';
      $item_output .= '<a' . $attributes . '>';
      $item_output .= $args->link_before . $title . $args->link_after;
      $item_output .= '</a>';

      // only add the white arrow SVG to the first level of menu items that have children
      if ( $item->menu_item_parent == '0' && is_array( $item->classes ) && in_array( 'menu-item-has-children', $item->classes ) ) {
//        $item_output .= '<a href="" class="menu-item__sub-menu-opener">
//                          <svg class="menu-item__sub-menu-opener-icon" width="14.75" height="16.864" viewBox="0 0 14.75 16.864">
//                            <g transform="translate(-152.625 -2562.568)">
//                              <g transform="translate(0 -116)">
//                                <g transform="translate(-188.5 1803.5)">
//                                  <path d="M-2.088-2.295v-8l-7-4-7,4v8l7,4Z" transform="translate(357.588 889.795)" fill="none" stroke="#ffffff" stroke-width="0.75"/>
//                                </g>
//                              </g>
//                              <path d="M3.883,0,7.765,4.578H0Z" transform="translate(163.765 2573.578) rotate(180)" fill="#ffffff"/>
//                            </g>
//                          </svg>
//                         </a>';
        $item_output .= '<a href="" class="menu-item__sub-menu-opener">
                          <span class="menu-item__sub-menu-opener-icon" width="14.75" height="16.864" ">>
                          </span>
                         </a>';
        
      }

      $item_output .= '</div>';
      $item_output .= $args->after;

      /**
       * Filters a menu item's starting output.
       *
       * The menu item's starting output only includes `$args->before`, the opening `<a>`,
       * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
       * no filter for modifying the opening and closing `<li>` for a menu item.
       *
       * @since 3.0.0
       *
       * @param string   $item_output The menu item's starting HTML output.
       * @param WP_Post  $item        Menu item data object.
       * @param int      $depth       Depth of menu item. Used for padding.
       * @param stdClass $args        An object of wp_nav_menu() arguments.
       */
      $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
  }
