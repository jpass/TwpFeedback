<?php

namespace Twp\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Idea
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $title;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;
    
    // Relations:
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="ideas")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;
    
    /**
     * @ORM\OneToOne(targetEntity="Status", inversedBy="idea")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     */
    protected $currentStatus;
    
    /**
     * @ORM\OneToMany(targetEntity="Status", mappedBy="idea")
     */
    protected $statuses;
    
    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="idea")
     */
    protected $comments;
    
    /**
     * @ORM\OneToMany(targetEntity="Vote", mappedBy="idea")
     */
    protected $votes;
    
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
       $this->createdAt = new \DateTime();
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
       $this->updatedAt = new \DateTime();
    }
}