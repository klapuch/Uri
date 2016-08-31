<?php
declare(strict_types = 1);
namespace Klapuch\Uri;

abstract class Mockery extends \Tester\TestCase {
	protected function mockery($class) {
		return \Mockery::mock($class);
	}

	protected function tearDown() {
		parent::tearDown();
		\Mockery::close();
	}
}