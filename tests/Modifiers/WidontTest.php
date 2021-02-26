<?php

namespace Tests\Modifiers;

use Statamic\Modifiers\Modify;
use Tests\TestCase;

class WidontTest extends TestCase
{

    /**
     * @test
     */
    public function it_adds_space_to_plain_text()
    {
        $value = 'Lorem ipsum dolor sit amet.';

        $this->assertEquals('Lorem ipsum dolor sit&nbsp;amet.', $this->modify($value));
    }

    /** @test */
    public function it_uses_params_to_add_space_to_plain_text()
    {
        $value = 'Lorem ipsum dolor sit amet.';

        $this->assertEquals('Lorem ipsum dolor&nbsp;sit&nbsp;amet.', $this->modify($value, 2));
    }

    /** @test */
    public function it_uses_params_to_add_space_to_long_broken_text()
    {
        $value = <<<'EOD'
            Lorem ipsum dolor sit amet.
            Lorem ipsum dolor sit amet.
            Lorem ipsum dolor sit amet.
            EOD;

        $expected = <<<'EOD'
            Lorem ipsum dolor sit&nbsp;amet.
            Lorem ipsum dolor sit&nbsp;amet.
            Lorem ipsum dolor sit&nbsp;amet.
            EOD;

        $this->assertEquals($expected, $this->modify($value, 1));
    }

    /** @test */
    public function it_adds_space_to_text_within_html_tags()
    {
        $value1 = '<p>Lorem ipsum dolor sit amet.</p>';
        $value2 = '<h1>Lorem ipsum dolor sit amet.</h1>';
        $value3 = '<h2>Lorem ipsum dolor sit amet.</h2>';

        $this->assertEquals('<p>Lorem ipsum dolor sit&nbsp;amet.</p>', $this->modify($value1, 1));
        $this->assertEquals('<h1>Lorem ipsum dolor sit&nbsp;amet.</h1>', $this->modify($value2, 1));
        $this->assertEquals('<h2>Lorem ipsum dolor sit&nbsp;amet.</h2>', $this->modify($value3, 1));
    }

    /** @test */
    public function it_adds_space_to_text_within_multiple_html_tags()
    {
        $value = '<p>Lorem ipsum dolor sit amet.</p><p>Consectetur adipiscing elit.</p>';

        $this->assertEquals('<p>Lorem ipsum dolor sit&nbsp;amet.</p><p>Consectetur adipiscing&nbsp;elit.</p>', $this->modify($value));
    }

    /** @test */
    public function it_uses_params_to_add_space_to_text_within_html_tags()
    {
        $value1 = '<p>Lorem ipsum dolor sit amet.</p>';
        $value2 = '<h1>Lorem ipsum dolor sit amet.</h1>';
        $value3 = '<h2>Lorem ipsum dolor sit amet.</h2>';

        $this->assertEquals('<p>Lorem ipsum dolor&nbsp;sit&nbsp;amet.</p>', $this->modify($value1, 2));
        $this->assertEquals('<h1>Lorem ipsum&nbsp;dolor&nbsp;sit&nbsp;amet.</h1>', $this->modify($value2, 3));
        $this->assertEquals('<h2>Lorem&nbsp;ipsum&nbsp;dolor&nbsp;sit&nbsp;amet.</h2>', $this->modify($value3, 4));
    }

    /** @test */
    public function it_uses_params_to_add_space_to_text_within_multiple_html_tags()
    {
        $value = '<p>Lorem ipsum dolor sit amet.</p><p>Consectetur adipiscing elit.</p>';

        $this->assertEquals('<p>Lorem ipsum dolor&nbsp;sit&nbsp;amet.</p><p>Consectetur&nbsp;adipiscing&nbsp;elit.</p>', $this->modify($value, 2));
    }

    /** @test */
    public function it_pases_bard_test()
    {
        $value = '<p>Lorem ipsum dolor sit amet.</p><p></p><p>Consectetur adipiscing elit.</p>';

        $this->assertEquals('<p>Lorem ipsum dolor sit&nbsp;amet.</p><p></p><p>Consectetur adipiscing&nbsp;elit.</p>', $this->modify($value, 1));
    }

    public function modify($value, $params = 1)
    {
        return Modify::value($value)->widont($params)->fetch();
    }
}
