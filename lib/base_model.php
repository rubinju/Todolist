<?php

  class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null){
      // Käydään assosiaatiolistan avaimet läpi
      foreach($attributes as $attribute => $value){
        // Jos avaimen niminen attribuutti on olemassa...
        if(property_exists($this, $attribute)){
          // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
          $this->{$attribute} = $value;
        }
      }
    }

    // Deprecated, switched to valitron
    public function errors() {
      // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
      $errors = array();

      // foreach($this->validators as $validator){
      //   // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
      //   Kint::dump($validator);
      //   $validator_errors = $this->{$validator}();
      //   Kint::dump($validator_errors);
        //$errors = array_merge($errors, $validator_errors);
      //}
      Kint::dump($errors);

      return $errors;
    }

    // Deprecated, switched to valitron
    // public function validate_string_length($string, $descr, $min, $max) {
    //   $errors_i = array();
    //   if ($string == '' || $string == null) {
    //     $errors_i[] = $descr . ' can not be empty';
    //   }
    //   if (strlen($string) < $min) {
    //     $errors_i[] = $descr . ' must be at least ' . $min . ' characters';
    //   }
    //   if (strlen($string) > $max) {
    //     $errors_i[] = $descr . ' can not be longer than ' . $max;
    //   }
    //   //Kint::dump($errors_i);
    //   return $errors_i;
    // }

    // public function validate_numeric($number, $descr) {
    //   $error = array();
    //   if (!is_numeric($number)) {
    //     $error[] = $descr . ' is not numeric';
    //   }
    //   return $error;
    // }

  }
