<?php
declare(strict_types=1);
namespace annihilation\lib\formapi\forms;
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

class ModalForm extends Form{

    /** @var string */
    private $content = "";

    /**
     * @param callable|null $callable
     */
    public function __construct(?callable $callable) {
        parent::__construct($callable);
        $this->data["type"] = "modal";
        $this->data["title"] = "";
        $this->data["content"] = $this->content;
        $this->data["button1"] = "";
        $this->data["button2"] = "";
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title) : void {
        $this->data["title"] = $title;
    }

    /**
     * @return string
     */
    public function getTitle() : string {
        return $this->data["title"];
    }

    /**
     * @return string
     */
    public function getContent() : string {
        return $this->data["content"];
    }

    /**
     * @param string $content
     */
    public function setContent(string $content) : void {
        $this->data["content"] = $content;
    }

    /**
     * @param string $text
     */
    public function setButton1(string $text) : void {
        $this->data["button1"] = $text;
    }

    /**
     * @return string
     */
    public function getButton1() : string {
        return $this->data["button1"];
    }

    /**
     * @param string $text
     */
    public function setButton2(string $text) : void {
        $this->data["button2"] = $text;
    }

    /**
     * @return string
     */
    public function getButton2() : string {
        return $this->data["button2"];
    }
}
