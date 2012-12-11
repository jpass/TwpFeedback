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
     * @ORM\OneToOne(targetEntity="Status")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     */
    protected $currentStatus;
    
    /**
     * @ORM\OneToMany(targetEntity="Status", mappedBy="idea")
     */
    protected $statuses;
    
    /**
     * @ORM\ManyToMany(targetEntity="Comment", mappedBy="idea")
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
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
       $this->updatedAt = new \DateTime();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->statuses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->votes = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Idea
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Idea
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Idea
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Idea
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set user
     *
     * @param Twp\Entity\User $user
     * @return Idea
     */
    public function setUser(\Twp\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return Twp\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set currentStatus
     *
     * @param Twp\Entity\Status $currentStatus
     * @return Idea
     */
    public function setCurrentStatus(\Twp\Entity\Status $currentStatus = null)
    {
        $this->currentStatus = $currentStatus;
    
        return $this;
    }

    /**
     * Get currentStatus
     *
     * @return Twp\Entity\Status 
     */
    public function getCurrentStatus()
    {
        return $this->currentStatus;
    }

    /**
     * Add statuses
     *
     * @param Twp\Entity\Status $statuses
     * @return Idea
     */
    public function addStatuse(\Twp\Entity\Status $statuses)
    {
        $this->statuses[] = $statuses;
    
        return $this;
    }

    /**
     * Remove statuses
     *
     * @param Twp\Entity\Status $statuses
     */
    public function removeStatuse(\Twp\Entity\Status $statuses)
    {
        $this->statuses->removeElement($statuses);
    }

    /**
     * Get statuses
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getStatuses()
    {
        return $this->statuses;
    }

    /**
     * Add comments
     *
     * @param Twp\Entity\Comment $comments
     * @return Idea
     */
    public function addComment(\Twp\Entity\Comment $comments)
    {
        $this->comments[] = $comments;
    
        return $this;
    }

    /**
     * Remove comments
     *
     * @param Twp\Entity\Comment $comments
     */
    public function removeComment(\Twp\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add votes
     *
     * @param Twp\Entity\Vote $votes
     * @return Idea
     */
    public function addVote(\Twp\Entity\Vote $votes)
    {
        $this->votes[] = $votes;
    
        return $this;
    }

    /**
     * Remove votes
     *
     * @param Twp\Entity\Vote $votes
     */
    public function removeVote(\Twp\Entity\Vote $votes)
    {
        $this->votes->removeElement($votes);
    }

    /**
     * Get votes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getVotes()
    {
        return $this->votes;
    }
}