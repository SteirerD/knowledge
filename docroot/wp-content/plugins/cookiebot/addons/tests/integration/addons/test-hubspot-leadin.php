<?php

namespace cookiebot_addons\tests\integration\addons;

class Test_Hubspot_Leadin extends \WP_UnitTestCase {
	
	public function setUp() {
	
	}
	
	/**
	 * This will validate if the hook for "hubspot_leadin" still exists
	 *
	 * @since 2.1.0
	 */
	public function test_hook() {
		$content = file_get_contents( 'http://plugins.svn.wordpress.org/leadin/trunk/main/ClassLeadin.php' );
		
		$this->assertNotFalse( strpos( $content, "const TRACKING_CODE_ID = 'leadin-script-loader-js';") );
	}
}
