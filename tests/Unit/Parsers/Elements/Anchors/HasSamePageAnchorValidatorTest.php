<?php

namespace Tests\Unit\Parsers\Elements\Anchors;

use PHPUnit\Framework\TestCase;
use Zeus\Parsers\Elements\Anchors\HasSamePageAnchorValidator;

class HasSamePageAnchorValidatorTest extends TestCase
{
    /**
     * @param bool $expected
     * @param string $input
     *
     * @dataProvider samePageAnchorProvider
     */
    public function testLinksWithSamePageAnchorsAreDetected(bool $expected, string $input): void
    {
        $validator = new HasSamePageAnchorValidator();
        $this->assertEquals($expected, $validator->validate($input));
    }

    public function samePageAnchorProvider(): array
    {
        return [
            [false, '/page/about-us'],
            [false, '/page/contact'],
            [false, '/'],
            [true, '#'],
            [true, '/page/about-us#here'],
            [true, '#here'],
        ];
    }
}
