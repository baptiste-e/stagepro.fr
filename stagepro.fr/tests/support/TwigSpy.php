<?php

declare(strict_types=1);

final class TwigSpy
{
    public ?string $lastTemplate = null;
    public array $lastContext = [];
    private string $returnValue;

    public function __construct(string $returnValue = 'rendered')
    {
        $this->returnValue = $returnValue;
    }

    public function render(string $template, array $context = []): string
    {
        $this->lastTemplate = $template;
        $this->lastContext = $context;

        return $this->returnValue;
    }
}