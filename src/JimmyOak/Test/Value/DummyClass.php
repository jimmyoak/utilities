<?php

namespace JimmyOak\Test\Value;

class DummyClass extends ParentDummyClass
{
    private $aPrivateProperty = 'A STRING';
    protected $aProtectedProperty = 1234;
    public $aPublicProperty = 'ANOTHER STRING';
    private $anObject;
    private $anArrayOfObjects;

    public function __construct()
    {
        $this->anObject = new AnotherDummyClass();
        $this->anArrayOfObjects = [
            $this->anObject,
            $this->anObject
        ];
    }
}
