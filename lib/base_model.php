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

    public function errors(){
      // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
      $errors = array();

      foreach($this->validators as $validator){
        // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
        $validation = $this->{$validator}();
        $errors = array_merge($errors, $validation);
      }

      return $errors;
    }

    // TODO: add generic validators, not null, numeric, equal

    public function validate_string_length($string, $descr, $min, $max) {
      $errors = array();
      if ($string == '' || $string == null) {
        $errors[] = $descr . ' can not be empty';
      }
      if (strlen($string) < $min) {
        $errors[] = $descr . ' must be at least ' . $min . ' characters';
      }
      if (strlen($string) > $max) {
        $errors[] = $descr . ' can not be longer than ' . $max;
      }
      return $errors;
    }

  }
