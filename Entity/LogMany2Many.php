<?php
namespace Ibrows\LoggableBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation as Sonata;

/**
 * @ORM\Entity(repositoryClass="Ibrows\LoggableBundle\Repository\LogMany2ManyRepository")
 */
class LogMany2Many extends AbstractLog
{

    public function __construct(){
        $this->parents = new ArrayCollection();
        $this->setLoggedAt();
        $this->version = 0;
    }


    /**
     * @return string
     */
    public function getInverseClass()
    {
        return $this->childClass;
    }

    /**
     * @param string $inverseClass
     */
    public function setInverseClass($inverseClass)
    {
        $this->childClass = $inverseClass;
    }

    /**
     * @return string
     */
    public function getInverseId()
    {
        return $this->childId;
    }

    /**
     * @param string $inverseId
     */
    public function setInverseId($inverseId)
    {
        $this->childId = $inverseId;
    }

    public function getLogType()
    {
        return self::LOG_TYPE_MANY2MANY;
    }


}
