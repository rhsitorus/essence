<?php

/**
 *	@author Félix Girault <felix.girault@gmail.com>
 *	@license FreeBSD License (http://opensource.org/licenses/BSD-2-Clause)
 */
namespace Essence;

use PHPUnit_Framework_TestCase as TestCase;



/**
 *	Test case for Provider.
 */
class ProviderTest extends TestCase {

	/**
	 *
	 */
	public $Provider = null;
	public $Media = null;



	/**
	 *
	 */
	public function setup() {
		$this->Media = new Media([
			'url' => 'http://foo.bar.com/resource',
			'title' => 'Title',
			'description' => 'Description',
			'width' => 800,
			'height' => 600
		]);

		$this->Provider = $this->getMockForAbstractClass(
			'\\Essence\\Provider'
		);
	}



	/**
	 *
	 */
	public function testEmbed() {
		$this->Provider
			->expects($this->any())
			->method('_embed')
			->will($this->returnValue($this->Media));

		$this->assertEquals(
			$this->Media,
			$this->Provider->embed('  http://foo.bar  ')
		);
	}
}
