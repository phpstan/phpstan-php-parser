<?php declare(strict_types = 1);

namespace PHPStan\Reflection\PHPParser;

class PhpParserNameClassReflectionExtensionTest extends \PHPStan\Testing\PHPStanTestCase
{

	/**
	 * @return array<array{bool, string, string}>
	 */
	public function dataHasProperty(): array
	{
		return [
			[
				true,
				\PhpParser\Node\Stmt\Class_::class,
				'namespacedName',
			],
			[
				true,
				\PhpParser\Node\Stmt\Function_::class,
				'namespacedName',
			],
			[
				true,
				\PhpParser\Node\FunctionLike::class,
				'namespacedName',
			],
			[
				false,
				\PhpParser\Node\Expr\Closure::class,
				'namespacedName',
			],
			[
				false,
				\PhpParser\Node\Stmt\Class_::class,
				'foo',
			],
		];
	}

	/**
	 * @dataProvider dataHasProperty
	 * @param bool $expectedHas
	 * @param string $className
	 * @param string $propertyName
	 */
	public function testHasProperty(
		bool $expectedHas,
		string $className,
		string $propertyName
	): void
	{
		$broker = $this->createBroker();
		$classReflection = $broker->getClass($className);
		$extension = new PhpParserNameClassReflectionExtension();
		$this->assertSame($expectedHas, $extension->hasProperty($classReflection, $propertyName));
	}

}
