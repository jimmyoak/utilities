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
        $this->anObject = new \DateTime('1992-10-07 21:05', new \DateTimeZone('Europe/Madrid'));
        $this->anArrayOfObjects = [
            $this->anObject,
            $this->anObject
        ];
    }
}
