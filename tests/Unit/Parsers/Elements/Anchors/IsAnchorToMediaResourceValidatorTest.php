<?php

namespace Tests\Unit\Parsers\Elements\Anchors;

use PHPUnit\Framework\TestCase;
use Zeus\Parsers\Elements\Anchors\IsAnchorToMediaResourceValidator;

class IsAnchorToMediaResourceValidatorTest extends TestCase
{
    /**
     * @param bool $expected
     * @param string $input
     *
     * @dataProvider mediaResourcesProvider
     */
    public function testLinksToMediaResourcesAreDetected(bool $expected, string $input): void
    {
        $validator = new IsAnchorToMediaResourceValidator();
        $this->assertEquals($expected, $validator->validate($input));
    }

    public function mediaResourcesProvider(): array
    {
        return [
            [true, '/assets/images/ryrobbo-logo.png'],
            [true, '/assets/images/ryrobbo-logo.jpg'],
            [true, '/assets/images/ryrobbo-logo.jpeg'],
            [true, '/assets/images/ryrobbo-logo.gif'],
            [true, '/assets/images/ryrobbo-logo.svg'],
            [true, '/assets/images/ryrobbo-logo.mp3'],
            [true, '/assets/images/ryrobbo-logo.mp4'],
            [false, '/pages/contact.php'],
            [false, '/pages/index.html'],
            [false, '/help.aspx'],
            [false, '/test.py'],
            [false, '/'],
            [false, '/pages/about-us'],
            [false, '/index'],
        ];
    }
}
