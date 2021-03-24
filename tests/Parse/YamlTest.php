<?php

use Winter\Storm\Parse\Yaml as YamlParser;
use Winter\Storm\Parse\Processor\VersionYamlProcessor;

class YamlTest extends TestCase
{
    public function testParseWithoutProcessor()
    {
        $this->expectException(Symfony\Component\Yaml\Exception\ParseException::class);

        $parser = new YamlParser;
        $yaml = $parser->parse(file_get_contents(dirname(__DIR__) . '/fixtures/yaml/version.yaml'));
    }

    public function testParseWithProcessor()
    {
        $parser = new YamlParser;
        $parser->setProcessor(new VersionYamlProcessor);
        $yaml = $parser->parse(file_get_contents(dirname(__DIR__) . '/fixtures/yaml/version.yaml'));

        $this->assertEquals([
            '1.3.2' => 'Added support for Translate plugin. Added some new languages.',
            '1.3.1' => [
                'Minor bug fix Please see changelog',
                'fix_database.php',
            ],
            '1.3.0' => '!!! We\'ve refactored major parts of this plugin. Please see the website for more information.',
            '1.2.0' => [
                '!!! Security update - see: https://wintercms.com'
            ],
            '1.1.0' => [
                '!!! Drop support for blog settings',
                'drop_blog_settings_table.php',
            ],
            '1.0.5' => [
                'Create blog settings table',
                'Another update message',
                'Yet one more update message',
                'create_blog_settings_table.php',
            ],
            '1.0.4' => 'Another fix',
            '1.0.3' => 'Bug fix update that uses no scripts',
            '1.0.2' => 'Added some stuff',
            '1.0.1' => [
                'Added some upgrade file and some seeding',
                'some_upgrade_file.php',
                'some_seeding_file.php',
            ],
        ], $yaml);
    }
}
