<?php

namespace EC\Poetry\Tests;

use EC\Poetry\Messages\Components\AbstractComponent;
use EC\Poetry\Poetry;
use Symfony\Component\Yaml\Yaml;

/**
 * Class SensitizationTest.
 *
 * @package EC\Poetry\Tests
 */
class SanitizationTest extends AbstractTest
{

    /**
     * @param string $name
     * @param array  $setters
     * @param array  $getters
     *
     * @dataProvider dataProvider
     */
    public function testSensitization($name, array $setters, array $getters)
    {
        $poetry = new Poetry();
        /** @var AbstractComponent $component */
        $component = $poetry->get('component.'.$name);

        foreach ($setters as $setter => $value) {
            $component->$setter($value);
        }

        $xml = $poetry->getRenderEngine()->render($component->getTemplate(), [
            'component' => $component,
        ]);

        $actual = $poetry->get('component.'.$name)->fromXml($xml);
        // If XML is not valid test will fail here.
        new \SimpleXMLElement($xml);
        foreach ($getters as $getter => $value) {
            expect($actual->$getter($value))->to->equal($value);
        }
    }

    /**
     * @return array
     */
    public function dataProvider()
    {
        return Yaml::parse($this->getFixture('sanitization.yml'));
    }
}
