<?php

/**
 *	@author Félix Girault <felix.girault@gmail.com>
 *	@license FreeBSD License (http://opensource.org/licenses/BSD-2-Clause)
 */

namespace Essence;

use PHPUnit_Framework_TestCase;
use Essence\Cache\Engine;
use Essence\Cache\Engine\Volatile;



/**
 *
 */

class CacheableImplementation {

	use Cacheable;



	/**
	 *
	 */

	protected function _cacheKey( $signature ) {

		return 'key';
	}



	/**
	 *
	 */

	public function cachedMethod( Engine $Engine, $arg ) {

		return $this->_cached( $Engine, '_cachedMethod', $arg );
	}



	/**
	 *
	 */

	public function _cachedMethod( $arg ) {

		return $arg;
	}
}



/**
 *	Test case for Cacheable.
 */

class CacheableTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $Engine = null;



	/**
	 *
	 */

	public $Cacheable = null;



	/**
	 *
	 */

	public function setUp( ) {

		$this->Engine = new Volatile( );
		$this->Cacheable = new CacheableImplementation( );
	}



	/**
	 *
	 */

	public function testCached( ) {

		$this->assertFalse( $this->Engine->has( 'key' ));
		$this->assertEquals( 'result', $this->Cacheable->cachedMethod( $this->Engine, 'result' ));
		$this->assertEquals( 'result', $this->Engine->get( 'key' ));
	}
}
