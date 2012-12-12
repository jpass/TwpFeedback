<?php

namespace Twp\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Status
{
    const STATUS_NEW = 1;
    const STATUS_UNDER_REVIEW = 2;
    const STATUS_PLANNED = 3;
    const STATUS_STARTED = 4;
    const STATUS_COMPLETED = 5;
    const STATUS_DECLINED = 6;
    const STATUS_DUPLICATE = 7;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $type;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;
    
    // Relations
    
    /**
     * @ORM\ManyToOne(targetEntity="Idea", inversedBy="statuses")
     * @ORM\JoinColumn(name="idea_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $idea;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="statuses")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $user;
    
    /**
     * @ORM\OneToOne(targetEntity="Comment")
     * @ORM\JoinColumn(name="comment_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $comment;
    
    public function __construct($type = self::STATUS_NEW)
    {
        $this->type = $type;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
       $this->createdAt = new \DateTime();
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
     * Set type
     *
     * @param integer $type
     * @return Status
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Status
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
     * Set idea
     *
     * @param Twp\Entity\Idea $idea
     * @return Status
     */
    public function setIdea(\Twp\Entity\Idea $idea = null)
    {
        $this->idea = $idea;
    
        return $this;
    }

    /**
     * Get idea
     *
     * @return Twp\Entity\Idea 
     */
    public function getIdea()
    {
        return $this->idea;
    }

    /**
     * Set user
     *
     * @param Twp\Entity\User $user
     * @return Status
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
     * Set comment
     *
     * @param Twp\Entity\Comment $comment
     * @return Status
     */
    public function setComment(\Twp\Entity\Comment $comment = null)
    {
        $this->comment = $comment;
    
        return $this;
    }

    /**
     * Get comment
     *
     * @return Twp\Entity\Comment 
     */
    public function getComment()
    {
        return $this->comment;
    }
    
    public static function getChoices()
    {
        return array(
            self::STATUS_NEW => 'new',
            self::STATUS_UNDER_REVIEW => 'under review',
            self::STATUS_PLANNED => 'planned',
            self::STATUS_STARTED => 'started',
            self::STATUS_COMPLETED => 'completed',
            self::STATUS_DECLINED => 'declined',
            self::STATUS_DUPLICATE => 'duplicate'
        );
    }
    
    public function __toString() 
    {
        $v = $this->getChoices();
        return $v[$this->getType()];
    }
}