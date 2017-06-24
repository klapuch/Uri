<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.0.0
 */
namespace Klapuch\Uri\Unit;

use Klapuch\Uri;
use Klapuch\Uri\TestCase;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class CachedUri extends Tester\TestCase {
	use TestCase\Mockery;

	public function testCallingReferenceJustOnce() {
		$origin = $this->mock(Uri\Uri::class);
		$origin->shouldReceive('reference')->once()->andReturn('www.google.com');
		$uri = new Uri\CachedUri($origin);
		Assert::same('www.google.com', $uri->reference());
		Assert::same('www.google.com', $uri->reference());
	}

	public function testCallingPathJustOnce() {
		$origin = $this->mock(Uri\Uri::class);
		$origin->shouldReceive('path')->once()->andReturn('/home');
		$uri = new Uri\CachedUri($origin);
		Assert::same('/home', $uri->path());
		Assert::same('/home', $uri->path());
	}
}

(new CachedUri())->run();