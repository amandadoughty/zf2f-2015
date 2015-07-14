<?php
namespace Application\Plugins;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
class SomeDate extends AbstractPlugin
{
    public function __invoke($timeInfo = NULL)
    {
        if ($timeInfo) {
            if (is_string($timeInfo)) {
                $date = new \DateTime($timeInfo);
            }
        } else {
            $date = new \DateTime('now');
        }
        return $date;
    }
}