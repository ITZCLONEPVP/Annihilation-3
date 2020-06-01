<?php
/*
 * ©Symfony (c) Fabien Potencier <fabien@symfony.com>
 * This is a(n) Yaml library for my plugin, uses to replace pmmp yaml
 * Author: NTT
 * Source: https://github.com/NTT1906/yaml-lib
 */

namespace Symfony\Component\Yaml\Tag;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 * @author Guilhem N. <egetick@gmail.com>
 */
final class TaggedValue{
    private $tag;
    private $value;

    public function __construct(string $tag, $value)
    {
        $this->tag = $tag;
        $this->value = $value;
    }

    public function getTag(): string
    {
        return $this->tag;
    }

    public function getValue()
    {
        return $this->value;
    }
}
