<?php

/**
 *	@author Félix Girault <felix.girault@gmail.com>
 *	@license FreeBSD License (http://opensource.org/licenses/BSD-2-Clause)
 */

namespace Essence\Provider\OpenGraph;

if ( !defined( 'ESSENCE_BOOTSTRAPPED')) {
	require_once
		dirname( dirname( dirname( dirname( __FILE__ ))))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}



/**
 *	Test case for CanalPlus.
 */

class CanalPlusTest extends \PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $CanalPlus = null;



	/**
	 *
	 */

	public function setUp( ) {

		$this->CanalPlus = new CanalPlus( );
	}



	/**
	 *
	 */

	public function testCanFetch( ) {

		$this->assertTrue( $this->CanalPlus->canFetch( 'http://www.canalplus.fr/c-divertissement/pid1787-c-groland.html' ));
	}



	/**
	 *
	 */

	public function testCantFetch( ) {

		$this->assertFalse( $this->CanalPlus->canFetch( 'http://www.unsupported.com' ));
	}
}