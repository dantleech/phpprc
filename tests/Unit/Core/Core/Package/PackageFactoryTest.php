<?php

namespace Phpprc\Tests\Unit\Core\Core\Package;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Phpprc\Core\Core\ConfigResolver;
use Phpprc\Core\Core\Package\PackageFactory;

class PackageFactoryTest extends TestCase
{
    public function testFromString()
    {
        $package = $this->createFactory()->createFromFullNameAndConfig('vendor/name', [
            'base_path' => '/base/path',
        ]);

        $this->assertEquals('name', $package->name());
        $this->assertEquals('vendor', $package->vendor());
    }

    /**
     * @dataProvider provideInvalidName
     */
    public function testInvalidName(string $name)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid package name');
        $this->createFactory([
            'base_path' => '/base/path',
        ])->createFromFullNameAndConfig($name, []);
    }

    public function provideInvalidName()
    {
        yield 'empty' => [ '' ];
        yield 'one part' => [ 'one' ];
        yield 'three parts' => ['one/two/three'];
    }

    private function createFactory($prototype = []): PackageFactory
    {
        return new PackageFactory($prototype, new ConfigResolver());
    }
}
