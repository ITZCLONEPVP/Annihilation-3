<?php
declare(strict_types = 1);
namespace annihilation\lib\formapi;
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

class FormAPI{

    /**
     * @deprecated
     *
     * @param callable|null $function
     * @return CustomForm
     */
    public function createCustomForm(?callable $function = null) : CustomForm {
        return new CustomForm($function);
    }

    /**
     * @deprecated
     *
     * @param callable|null $function
     * @return SimpleForm
     */
    public function createSimpleForm(?callable $function = null) : SimpleForm {
        return new SimpleForm($function);
    }

    /**
     * @deprecated
     *
     * @param callable|null $function
     * @return ModalForm
     */
    public function createModalForm(?callable $function = null) : ModalForm {
        return new ModalForm($function);
    }
}
