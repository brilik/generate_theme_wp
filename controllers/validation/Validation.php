<?php

/**
 * Class Validation
 */
class Validation {
    private $msg;
    private $min;
    private $max;
    
    public function check( string $str, string $inputName = 'text', int $min = 3, int $max = 10 ) {
        $this->min = $min;
        $this->max = $max;
        
        $str = htmlspecialchars( $str );
        $str = strip_tags( $str );
        
        $inputName = mb_strtolower( $inputName );
        
        if ( $inputName === 'text' ) {
            return $this->check_text( $str );
        }

//        if($inputName === 'checkbox'){}
//        if($inputName === 'select'){}
        
        return 'Такого типа <input> нет';
    }
    
    private function check_text( $str ) {
        
        $this->msg = [];
        
        // check input on special symbols
        if ( preg_match( "/[^0-9a-z _]/ui", $str ) ) {
            array_push( $this->msg, 'Название не должно содержать символы и латиницу' );
        }
        
        // check on mix count symbols
        if ( iconv_strlen( $str ) < $this->min ) {
            array_push( $this->msg, "Значение должно составлять не менее {$this->min} символов" );
        }
        
        // check on max count symbols
        if ( iconv_strlen( $str ) > $this->max ) {
            array_push( $this->msg, "Значение должно составлять не более {$this->max} символов" );
        }
        
        return 0;
    }
    
    private function check_checkbox() {
        return false;
    }
    
    private function check_select() {
        return false;
    }
    
    public function get_error() {
        return $this->msg;
    }
}