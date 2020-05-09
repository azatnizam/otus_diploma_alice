<?php
namespace Azatnizam;

final class Button
{
    private $value;
    private $title;

    public function setValue($value): Button
    {
        $this->value = $value;
        return $this;
    }

    public function setTitle(string $title): Button
    {
        $this->title = $title;
        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getTitle(): string
    {
        return (string) $this->title;
    }
}