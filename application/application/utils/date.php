<?php
class Date 
{    
    private $shortDateFormat = "F j, Y"; 
    private $longDateFormat = "F j, Y, g:i a"; 
    private $timestamp = 0; 
    
    /** 
    * Default constructor 
    * 
    * @param    integer        $timestamp    unix time stamp 
    */ 
    function __construct($timestamp = 0) 
    { 
        $this->timestamp = $timestamp; 
    } 
    
    /** 
    * Returns the given timestamp in the constructor 
    * 
    * @return    integer        time stamp 
    */ 
    public function getTime() 
    { 
        return (int) $this->timestamp; 
    } 
    
    /* 
     * Returns long formatted date of the given timestamp 
     * 
     * @access public 
     * @return     string    Long formatted date 
     */ 
    public function long() 
    { 
        if ( $this->timestamp > 0 ) 
        { 
            return date ( $this->longDateFormat , $this->timestamp ); 
        } 
        else 
        { 
            return ""; 
        } 
    } 

    /* 
     * Returns short formatted date of the given timestamp 
     * 
     * @access public 
     * @return     string    Short formatted date 
     */    
    public function short() 
    { 
        if ( $this->timestamp > 0 ) 
        { 
            return date ( $this->shortDateFormat , $this->timestamp ); 
        } 
        else 
        { 
            return ""; 
        } 
    } 
    
    public function __toString() 
    { 
        return $this->timestamp; 
    } 
    
} 
?>
