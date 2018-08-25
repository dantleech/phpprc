<?php

namespace Phpprc\Tests\Unit\Core\Package;

use PHPUnit\Framework\TestCase;
use Phpprc\Core\Package\Package;
use Prophecy\Exception\InvalidArgumentException;

class PackageTest extends TestCase
{
    public function testFromString()
    {
        $package = Package::fromString('vendor/name');

        $this->assertEquals('name', $package->name());
        $this->assertEquals('vendor', $package->vendor());
    }

    public function testSetAttributes()
    {
        $package = Package::fromString('foo/bar');
        $package = $package->withAttributes([
            'one' => 'two',
        ]);

        $this->assertEquals(['one' => 'two'], $package->attributes());
    }

    /**
     * @dataProvider provideInvalidName
     */
    public function testInvalidName(string $name)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid package name');
        Package::fromString($name);
    }

    public function provideInvalidName()
    {
        yield 'empty' => [ '' ];
        yield 'one part' => [ 'one' ];
        yield 'three parts' => ['one/two/three'];
    }
}
