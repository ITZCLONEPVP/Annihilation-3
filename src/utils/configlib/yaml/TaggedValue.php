<?php
namespace yaml\tag;
/*
 *	   _     _ _                          
 *	 | |   (_) |__  _ __ __ _ _ __ _   _ 
 *	 | |   | | '_ \| '__/ _` | '__| | | |
 *	 | |___| | |_) | | | (_| | |  | |_| |
 *	 |_____|_|_.__/|_|  \__,_|_|   \__, |
 *                               |___/ 
 * This is a(n) Yaml library for my plugin, uses to replace pmmp yaml
 * Author: NTT
 * Source: https://github.com/NTT1906/yaml-lib
*/

/**
 * @author Nicolas Grekas <p@tchwork.com>
 * @author Guilhem N. <egetick@gmail.com>
 */
final class TaggedValue{
    private $tag;
    private $value;

    public function __construct(string $tag, $value){
        $this->tag = $tag;
        $this->value = $value;
    }

    public function getTag(): string{
        return $this->tag;
    }

    public function getValue(){
        return $this->value;
    }
}
