<?php

namespace Twp\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Twp\Entity\IssueRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Issue
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\MaxLength(100)
     */
    protected $title;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank()
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="issues")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;
    
    /**
     * @ORM\OneToOne(targetEntity="Status")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $currentStatus;
    
    /**
     * @ORM\OneToMany(targetEntity="Status", mappedBy="issue", cascade={"remove"})
     */
    protected $statuses;
    
    /**
     * @ORM\ManyToMany(targetEntity="Comment", mappedBy="issue", cascade={"remove"})
     */
    protected $comments;
    
    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="affectedByIssues")
     * @ORM\JoinTable(name="issue_user", 
     *      joinColumns={@ORM\JoinColumn(name="issue_id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", onDelete="CASCADE")}
     * )
     */
    protected $affectedUsers;
    
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
        $this->affectedUsers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Issue
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
     * @return Issue
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
     * @return Issue
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
     * @return Issue
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
     * @param \Twp\Entity\User $user
     * @return Issue
     */
    public function setUser(\Twp\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Twp\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set currentStatus
     *
     * @param \Twp\Entity\Status $currentStatus
     * @return Issue
     */
    public function setCurrentStatus(\Twp\Entity\Status $currentStatus = null)
    {
        $this->currentStatus = $currentStatus;
    
        return $this;
    }

    /**
     * Get currentStatus
     *
     * @return \Twp\Entity\Status 
     */
    public function getCurrentStatus()
    {
        return $this->currentStatus;
    }

    /**
     * Add statuses
     *
     * @param \Twp\Entity\Status $status
     * @return Issue
     */
    public function addStatus(\Twp\Entity\Status $status)
    {
        $this->statuses[] = $status;
        
        $this->currentStatus = $status;
    
        return $this;
    }

    /**
     * Remove statuses
     *
     * @param \Twp\Entity\Status $status
     */
    public function removeStatus(\Twp\Entity\Status $status)
    {
        $this->statuses->removeElement($status);
    }

    /**
     * Get statuses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStatuses()
    {
        return $this->statuses;
    }

    /**
     * Add comments
     *
     * @param \Twp\Entity\Comment $comments
     * @return Issue
     */
    public function addComment(\Twp\Entity\Comment $comments)
    {
        $this->comments[] = $comments;
    
        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Twp\Entity\Comment $comments
     */
    public function removeComment(\Twp\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add affectedUsers
     *
     * @param \Twp\Entity\User $affectedUsers
     * @return Issue
     */
    public function addAffectedUser(\Twp\Entity\User $affectedUsers)
    {
        $this->affectedUsers[] = $affectedUsers;
    
        return $this;
    }

    /**
     * Remove affectedUsers
     *
     * @param \Twp\Entity\User $affectedUsers
     */
    public function removeAffectedUser(\Twp\Entity\User $affectedUsers)
    {
        $this->affectedUsers->removeElement($affectedUsers);
    }

    /**
     * Get affectedUsers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAffectedUsers()
    {
        return $this->affectedUsers;
    }

    /**
     * Add statuses
     *
     * @param \Twp\Entity\Status $statuses
     * @return Issue
     */
    public function addStatuse(\Twp\Entity\Status $statuses)
    {
        $this->statuses[] = $statuses;
    
        return $this;
    }

    /**
     * Remove statuses
     *
     * @param \Twp\Entity\Status $statuses
     */
    public function removeStatuse(\Twp\Entity\Status $statuses)
    {
        $this->statuses->removeElement($statuses);
    }

    public function isClosed()
    {
        return $this->getCurrentStatus()->isClosing();
    }
}