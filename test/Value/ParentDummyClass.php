<?php

namespace JimmyOak\Test\Value;

class ParentDummyClass
{
    private $aParentProperty = 5;

    /**
     * @return int
     */
    public function getAParentProperty()
    {
        return $this->aParentProperty;
    }

    /**
     * @param int $aParentProperty
     *
     * @return $this
     */
    public function setAParentProperty($aParentProperty)
    {
        $this->aParentProperty = $aParentProperty;
        return $this;
    }
}
