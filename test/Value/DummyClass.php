<?php

namespace JimmyOak\Test\Value;

class DummyClass extends ParentDummyClass
{
    private $aPrivateProperty = 'A STRING';
    protected $aProtectedProperty = 1234;
    public $aPublicProperty = 'ANOTHER STRING';
    private $anObject;
    private $anArrayOfObjects;
    public $aResource;
    private $aDateTime;
    private $aDateTimeImmutable;
    private $aDateInterval;
    private $aDateTimeZone;

    public function __construct()
    {
        $this->anObject = new AnotherDummyClass();
        $this->anArrayOfObjects = [
            $this->anObject,
            $this->anObject
        ];
        $this->aResource = tmpfile();
        $this->aDateTime = new \DateTime('1992-10-07 21:05:10');
        $this->aDateTimeImmutable = new \DateTimeImmutable('2017-01-25 21:18:20');
        $this->aDateInterval = new \DateInterval('P1DT1H2M3S');
        $this->aDateTimeZone = new \DateTimeZone('Europe/Madrid');
    }

    /**
     * @return string
     */
    public function getAPrivateProperty()
    {
        return $this->aPrivateProperty;
    }

    /**
     * @param string $aPrivateProperty
     *
     * @return $this
     */
    public function setAPrivateProperty($aPrivateProperty)
    {
        $this->aPrivateProperty = $aPrivateProperty;
        return $this;
    }

    /**
     * @return int
     */
    public function getAProtectedProperty()
    {
        return $this->aProtectedProperty;
    }

    /**
     * @param int $aProtectedProperty
     *
     * @return $this
     */
    public function setAProtectedProperty($aProtectedProperty)
    {
        $this->aProtectedProperty = $aProtectedProperty;
        return $this;
    }

    /**
     * @return string
     */
    public function getAPublicProperty()
    {
        return $this->aPublicProperty;
    }

    /**
     * @param string $aPublicProperty
     *
     * @return $this
     */
    public function setAPublicProperty($aPublicProperty)
    {
        $this->aPublicProperty = $aPublicProperty;
        return $this;
    }

    /**
     * @return AnotherDummyClass
     */
    public function getAnObject()
    {
        return $this->anObject;
    }

    /**
     * @param AnotherDummyClass $anObject
     *
     * @return $this
     */
    public function setAnObject($anObject)
    {
        $this->anObject = $anObject;
        return $this;
    }

    /**
     * @return array
     */
    public function getAnArrayOfObjects()
    {
        return $this->anArrayOfObjects;
    }

    /**
     * @param array $anArrayOfObjects
     *
     * @return $this
     */
    public function setAnArrayOfObjects($anArrayOfObjects)
    {
        $this->anArrayOfObjects = $anArrayOfObjects;
        return $this;
    }
}
