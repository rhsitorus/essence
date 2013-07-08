<?php

/**
 *	@author Félix Girault <felix.girault@gmail.com>
 *	@license FreeBSD License (http://opensource.org/licenses/BSD-2-Clause)
 */

namespace fg\Essence\Provider;

if ( !defined( 'ESSENCE_BOOTSTRAPPED')) {
	require_once dirname( dirname( dirname( dirname( __FILE__ ))))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}



/**
 *
 */

class TestableOEmbed extends OEmbed {

	/**
	 *
	 */

	public function setOption( $name, $value ) {

		$this->_options[ $name ] = $value;
	}



	/**
	 *
	 */

	public function completeEndpoint( $endpoint, $options ) {

		return $this->_completeEndpoint( $endpoint, $options );
	}
}



/**
 *	Test case for OEmbed.
 */

class OEmbedTest extends \PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $OEmbed = null;



	/**
	 *
	 */

	public function setup( ) {

		$this->OEmbed = new TestableOEmbed(
			array(
				'endpoint' => 'file://' . ESSENCE_HTTP . '%s.json',
				'format' => OEmbed::json
			)
		);
	}



	/**
	 *
	 */

	public function testPrepare( ) {

		$this->assertEquals( 'valid', OEmbed::prepare( 'valid#anchor' ));
		$this->assertEquals( 'valid', OEmbed::prepare( 'valid?argument=value' ));
		$this->assertEquals( 'valid', OEmbed::prepare( 'valid?argument=value#anchor' ));
	}



	/**
	 *
	 */

	public function testCompleteEndpoint( ) {


		$this->assertEquals(
			'url?maxwidth=120&maxheight=60',
			$this->OEmbed->completeEndpoint(
				'url',
				array(
					'maxwidth' => 120,
					'maxheight' => 60
				)
			)
		);

		$this->assertEquals(
			'url?maxwidth=120',
			$this->OEmbed->completeEndpoint(
				'url',
				array(
					'maxwidth' => 120,
					'unsupported' => 'unsupported'
				)
			)
		);

		$this->assertEquals(
			'url?param=value&maxwidth=120',
			$this->OEmbed->completeEndpoint(
				'url?param=value',
				array( 'maxwidth' => 120 )
			)
		);
	}



	/**
	 *
	 */

	public function testEmbedJson( ) {

		$this->assertNotNull( $this->OEmbed->embed( 'valid' ));
	}



	/**
	 *
	 */

	public function testEmbedInvalidJson( ) {

		$this->setExpectedException( '\\fg\\Essence\\Exception' );
		$this->OEmbed->embed( 'invalid' );
	}



	/**
	 *
	 */

	public function testEmbedXml( ) {

		$this->OEmbed->setOption( 'endpoint', 'file://' . ESSENCE_HTTP . '%s.xml' );
		$this->OEmbed->setOption( 'format', OEmbed::xml );

		$this->assertNotNull( $this->OEmbed->embed( 'valid' ));
	}



	/**
	 *
	 */

	public function testEmbedInvalidXml( ) {

		$this->OEmbed->setOption( 'endpoint', 'file://' . ESSENCE_HTTP . '%s.xml' );
		$this->OEmbed->setOption( 'format', OEmbed::xml );

		try {
			$this->OEmbed->embed( 'invalid' );
		} catch ( \Exception $e ) {
			return;
		}

		$this->fail( 'An expected exception has not been raised.' );
	}



	/**
	 *
	 */

	public function testEmbedUnsupportedFormat( ) {

		$this->OEmbed->setOption( 'format', 'unsupported' );

		try {
			$this->OEmbed->embed( 'valid' );
		} catch ( \Exception $e ) {
			return;
		}

		$this->fail( 'An expected exception has not been raised.' );
	}



	/**
	 *
	 */

	public function testEmbedGeneric( ) {

		$this->OEmbed->setOption( 'endpoint', '' );

		$this->assertNotNull(
			$this->OEmbed->embed( 'file://' . ESSENCE_HTTP . 'valid.html' )
		);
	}
}
