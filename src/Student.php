<?php
class Student {
    private $id;
    private $name;
    private $enroll_date;


    function __construct($id = null, $name, $enroll_date)
    {
      $this->name = $name;
      $this->enroll_date = $enroll_date;
      $this->id = $id;
    }

    function setName($new_name)
    {
      $this->name = $new_name;
    }

    function setEnrollDate($new_enroll_date)
    {
      $this->enroll_date = $new_enroll_date;
    }

    function getId()
    {
      return $this->id;
    }

    function getName()
    {
      return $this->name;
    }

    function getEnrollDate()
    {
      return $this->enroll_date;
    }


} ?>
