<?php

/**
 * Class Validation
 */
class Validation {
    private $msg;
    private $min;
    private $max;

    public function check( string $str, string $inputName = 'text', int $min = 3, int $max = 15 ) {
        $this->min = $min;
        $this->max = $max;
        $inputName = mb_strtolower( $inputName );

        // Check <input type="text">
        if ( $inputName === 'text' ) {
            return $this->check_text( $this->special_security( $str ) );
        }

        // Check <input type="checkbox">
        if ( $inputName === 'checkbox' ) {
            return $this->check_checkbox( $str );
        }

        // Check <input type="url">
        if ( $inputName === 'url' ) {
            return $this->check_url( $this->special_security( $str ) );
        }

        // Check <textarea>
        if ( $inputName === 'description' ) {
            return $this->check_textarea( $this->special_security( $str, $min, $max ) );
        }

//        if($inputName === 'select'){}

        return 'Такого типа <input> нет';
    }

    private function check_text( $str ) {

        $this->msg = [];

        // check input on special symbols
        if ( preg_match( "/[^0-9a-z _]/ui", $str ) ) {
            array_push( $this->msg, 'Значение не должно содержать символы и латиницу' );
        }

        // check on mix count symbols
        if ( iconv_strlen( $str ) < $this->min ) {
            array_push( $this->msg, "Значение должно составлять не менее {$this->min} символов" );
        }

        // check on max count symbols
        if ( iconv_strlen( $str ) > $this->max ) {
            array_push( $this->msg, "Значение должно составлять не более {$this->max} символов" );
        }

        return $this->msg;
    }

    private function special_security( $str ) {
        $str = htmlspecialchars( $str );
        $str = strip_tags( $str );

        return $str;
    }

    private function check_checkbox( $check ) {
        $this->msg = [];

        if ( empty( $check ) || $check != 'on' ) {
            array_push( $this->msg, "Чекбокс должен быть включен" );
        }

        return $this->msg;
    }

    private function check_url( $url ) {
        $this->msg = [];
//        if ( ! checkdnsrr( $url, 'A' ) && ! get_headers( $url, 1 ) ) {
//            array_push( $this->msg, "Такого сайта не существует" );
//            return '1';
//        }

        if ( ! preg_match( '/^(https?:\/\/)?([\w\.]+)\.([a-z]{2,6}\.?)(\/[\w\.]*)*\/?$/', $url ) ) {
            array_push( $this->msg, "Введите валидный адрес" );
        }

        return $this->msg;
    }

    private function check_textarea( string $desc) {
        $this->msg = [];

        // check on mix count symbols
        if ( $this->min && iconv_strlen( $desc ) < $this->min ) {
            array_push( $this->msg, "Значение должно составлять не менее {$this->min} символов" );
        }

        // check on max count symbols
        if ( $this->max && iconv_strlen( $desc ) > $this->max ) {
            array_push( $this->msg, "Значение должно составлять не более {$this->max} символов" );
        }

        return $this->msg;
    }

    public function get_error() {
        return $this->msg;
    }

    private function check_select() {
        return false;
    }
}