<?php

namespace AppBundle\Twig;

use AppBundle\Utils\Markdown;

/**
 * Class MarkdownToHtmlExtension
 * @package AppBundle\Twig
 */
class MarkdownToHtmlExtension extends \Twig_Extension
{
    /**
     * @var Markdown
     */
    private $parser;

    /**
     * MarkdownToHtmlExtension constructor.
     * @param Markdown $parser
     */
    public function __construct(Markdown $parser)
    {
        $this->parser = $parser;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('md2html', [$this, 'markdownToHtml'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param string $content
     * @return string
     */
    public function markdownToHtml($content)
    {
        return $this->parser->toHtml($content);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'app.md2html';
    }
}
