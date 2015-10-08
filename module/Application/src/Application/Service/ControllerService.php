<?php
namespace Application\Service;

class ControllerService
{
    protected $test = 'TEST';
    
	/**
     * @return the $test
     */
    public function getTest()
    {
        return $this->test;
    }

	/**
     * @param string $test
     */
    public function setTest($test)
    {
        $this->test = $test;
    }

    
}