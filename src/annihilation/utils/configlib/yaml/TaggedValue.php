<?php
namespace annihilation\utils\configlib\yaml;
/*
 *	   _     _ _                          
 *	 | |   (_) |__  _ __ __ _ _ __ _   _ 
 *	 | |   | | '_ \| '__/ _` | '__| | | |
 *	 | |___| | |_) | | | (_| | |  | |_| |
 *	 |_____|_|_.__/|_|  \__,_|_|   \__, |
 *                               |___/ 
 * This is a library for my plugin
 * Author: NTT
 * Source: https://github.com/NTT1906/library
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
