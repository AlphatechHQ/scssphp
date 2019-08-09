<?php
/**
 * SCSSPHP
 *
 * @copyright 2012-2019 Leaf Corcoran
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @link http://scssphp.github.io/scssphp
 */

namespace ScssPhp\ScssPhp\Tests;

use ScssPhp\ScssPhp\Compiler;

class FrameworkTest extends \PHPUnit_Framework_TestCase
{
    protected static $frameworks = [
        [
            "frameworkVersion" => "twbs/bootstrap4.3",
            "inputdirectory" => "../vendor/twbs/bootstrap/scss/",
            "inputfiles" => "bootstrap.scss",
        ],
        [
            "frameworkVersion" => "zurb/foundation6.5",
            "inputdirectory" => "../vendor/zurb/foundation/assets/",
            "inputfiles" => "foundation.scss",
        ]
    ];

    private $saveDir;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->scss = new Compiler();
        $this->saveDir = getcwd();

        chdir(__DIR__);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        chdir($this->saveDir);
    }

    /**
     * @dataProvider frameworkProvider
     */
    public function testFramework($frameworkVersion, $inputdirectory, $inputfiles)
    {
        $this->scss->addImportPath($inputdirectory);

        $input = file_get_contents($inputdirectory . $inputfiles);

        // Test if no exceptions are raised for the given framework
        $e = null;

        try {
            $this->scss->compile($input, $inputfiles);
        } catch (\Exception $e) {
            // test fail
        }

        $this->assertNull($e);
    }

    public function frameworkProvider()
    {
        return self::$frameworks;
    }
}
