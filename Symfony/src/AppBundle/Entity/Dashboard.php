<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dashboard
 *
 * @ORM\Table(name="dashboard", uniqueConstraints={@ORM\UniqueConstraint(name="city_name_UNIQUE", columns={"city_name"})}, indexes={@ORM\Index(name="user_id_dashboard_idx", columns={"user_id"})})
 * @ORM\Entity
 */
class Dashboard implements \JsonSerializable
{
    /**
     * @var string
     *
     * @ORM\Column(name="city_name", type="string", length=100, nullable=true)
     */
    private $cityName;

    /**
     * @var string
     *
     * @ORM\Column(name="temperature", type="string", length=10, nullable=true)
     */
    private $temperature;

    /**
     * @var string
     *
     * @ORM\Column(name="rain_possibility", type="string", length=100, nullable=true)
     */
    private $rainPossibility;

    /**
     * @var string
     *
     * @ORM\Column(name="icon", type="string", length=10, nullable=true)
     */
    private $icon;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_updated", type="datetime", nullable=false)
     */
    private $lastUpdated;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @return string
     */
    public function getCityName()
    {
        return $this->cityName;
    }

    /**
     * @param string $cityName
     */
    public function setCityName($cityName)
    {
        $this->cityName = $cityName;
    }

    /**
     * @return string
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * @param string $temperature
     */
    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;
    }

    /**
     * @return string
     */
    public function getRainPossibility()
    {
        return $this->rainPossibility;
    }

    /**
     * @param string $rainPossibility
     */
    public function setRainPossibility($rainPossibility)
    {
        $this->rainPossibility = $rainPossibility;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return \DateTime
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    /**
     * @param \DateTime $lastUpdated
     */
    public function setLastUpdated($lastUpdated)
    {
        $this->lastUpdated = $lastUpdated;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }



    public function jsonSerialize()
    {
        return [
            'id'    => $this->id,
            'cityName'=>$this->cityName,
            'icon' => $this->icon,
            'temperature'  => $this->temperature,
            'rainPossibility'=>$this->rainPossibility,
            'lastUpdated'=>$this->lastUpdated,
            'user'=>$this->user
        ];
    }
}

