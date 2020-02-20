<?php

namespace houssemBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * react
 *
 * @ORM\Table(name="react")
 * @ORM\Entity(repositoryClass="houssemBundle\Repository\reactRepository")
 */
class react
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="reaction", type="string", length=255, nullable=true)
     */
    private $reaction;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=true)
     */
    private $comment;
    /**
     * @var string
     *
     * @ORM\Column(name="user", type="string", length=255, nullable=true)
     */
    private $user;

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="idblog", type="integer")
     */
    private $idblog;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set reaction
     *
     * @param string $reaction
     *
     * @return react
     */
    public function setReaction($reaction)
    {
        $this->reaction = $reaction;

        return $this;
    }

    /**
     * Get reaction
     *
     * @return string
     */
    public function getReaction()
    {
        return $this->reaction;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return react
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set idblog
     *
     * @param integer $idblog
     *
     * @return react
     */
    public function setIdblog($idblog)
    {
        $this->idblog = $idblog;

        return $this;
    }

    /**
     * Get idblog
     *
     * @return int
     */
    public function getIdblog()
    {
        return $this->idblog;
    }

    public function __toString()
    {
        return $this->reaction;
    }

}

