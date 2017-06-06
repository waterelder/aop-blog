<?php

namespace AppBundle\Utils;

/**
 * Class Markdown
 * @package AppBundle\Utils
 */
class Markdown
{
    /**
     * @var \Parsedown
     */
    private $parser;

    /**
     * Markdown constructor.
     */
    public function __construct()
    {
        $this->parser = new \Parsedown();
    }

    /**
     * @param string $text
     *
     * @return string
     */
    public function toHtml($text)
    {
        $html = $this->parser->text($text);
        
        return $html;
    }
}
