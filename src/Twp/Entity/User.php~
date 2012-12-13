<?php

namespace Twp\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface, \Serializable
{
    /**
     * number of votes user can use
     */
    const USER_VOTES_AVAILABLE = 10;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="integer") 
     */
    protected $glueId;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $salt;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    protected $isActive;
    
    /**
     * @ORM\Column(type="array")
     */
    protected $roles;
    
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;
    
    // Relations
    
    /**
     * @ORM\OneToMany(targetEntity="Idea", mappedBy="user")
     */
    protected $ideas;
    
    /**
     * @ORM\OneToMany(targetEntity="Vote", mappedBy="user")
     */
    protected $votes;
    
    /**
     * @ORM\OneToMany(targetEntity="Status", mappedBy="user")
     */
    protected $statuses;
    
    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="user")
     */
    protected $comments;
    
    /**
     * @ORM\OneToMany(targetEntity="Watch", mappedBy="user")
     */
    protected $watching;
    
    /**
     * @ORM\OneToMany(targetEntity="Issue", mappedBy="user")
     */
    protected $issues;
    
    /**
     * @ORM\ManyToMany(targetEntity="Issue", mappedBy="affectedUsers")
     */
    protected $affectedByIssues;
    
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
       $this->createdAt = new \DateTime();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ideas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->votes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->statuses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->watching = new \Doctrine\Common\Collections\ArrayCollection();
        
        $this->isActive = true;
        $this->salt = md5(uniqid(null, true));
        $this->roles = array('ROLE_USER');
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
     * Set glueId
     *
     * @param integer $glueId
     * @return User
     */
    public function setGlueId($glueId)
    {
        $this->glueId = $glueId;
    
        return $this;
    }

    /**
     * Get glueId
     *
     * @return integer 
     */
    public function getGlueId()
    {
        return $this->glueId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
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
     * Add ideas
     *
     * @param Twp\Entity\Idea $ideas
     * @return User
     */
    public function addIdea(\Twp\Entity\Idea $ideas)
    {
        $this->ideas[] = $ideas;
    
        return $this;
    }

    /**
     * Remove ideas
     *
     * @param Twp\Entity\Idea $ideas
     */
    public function removeIdea(\Twp\Entity\Idea $ideas)
    {
        $this->ideas->removeElement($ideas);
    }

    /**
     * Get ideas
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getIdeas()
    {
        return $this->ideas;
    }

    /**
     * Add votes
     *
     * @param Twp\Entity\Vote $votes
     * @return User
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

    /**
     * Add statuses
     *
     * @param Twp\Entity\Status $statuses
     * @return User
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
     * @return User
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
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    
        return $this;
    }
    
    public function getSalt() {
        $this->salt;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }
    
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
    
    
    /**
     * Set roles
     *
     * @param array $roles
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    
        return $this;
    }
    
    public function getRoles() {
        return $this->roles;
    }
    
    
    public function eraseCredentials() {
        
    }

    public function getUsername() 
    {
        return $this->getEmail();
    }
    
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }
    
    public function unserialize($serialized)
    {
        list (
            $this->id,
        ) = unserialize($serialized);
    }
    
    public function getRemainingVotes()
    {
        return self::USER_VOTES_AVAILABLE - count($this->getVotes());
    }
    
    public function getVotesforIdea($idea)
    {
        $v = $this->getVotes();
        $arr = array();
        foreach($v as $item)
        {
            if($item->getIdea() === $idea)
            {
                $arr[] = $item;
            }
        }
        return $arr;
    }
    
    public function isWatching($idea_id)
    {
        // TODO: find better way to check, this is ugly
        foreach ($this->getWatching() as $item) {
             if ($item->getIdea()->getId() == $idea_id) {
                 return true;
             }
         }
        return false;
    }

    /**
     * Add watching
     *
     * @param \Twp\Entity\Watch $watching
     * @return User
     */
    public function addWatching(\Twp\Entity\Watch $watching)
    {
        $this->watching[] = $watching;
    
        return $this;
    }

    /**
     * Remove watching
     *
     * @param \Twp\Entity\Watch $watching
     */
    public function removeWatching(\Twp\Entity\Watch $watching)
    {
        $this->watching->removeElement($watching);
    }

    /**
     * Get watching
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWatching()
    {
        return $this->watching;
    }

    /**
     * Add issues
     *
     * @param \Twp\Entity\Issue $issues
     * @return User
     */
    public function addIssue(\Twp\Entity\Issue $issues)
    {
        $this->issues[] = $issues;
    
        return $this;
    }

    /**
     * Remove issues
     *
     * @param \Twp\Entity\Issue $issues
     */
    public function removeIssue(\Twp\Entity\Issue $issues)
    {
        $this->issues->removeElement($issues);
    }

    /**
     * Get issues
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIssues()
    {
        return $this->issues;
    }

    /**
     * Add affectedByIssues
     *
     * @param \Twp\Entity\Issue $affectedByIssues
     * @return User
     */
    public function addAffectedByIssue(\Twp\Entity\Issue $affectedByIssues)
    {
        $this->affectedByIssues[] = $affectedByIssues;
    
        return $this;
    }

    /**
     * Remove affectedByIssues
     *
     * @param \Twp\Entity\Issue $affectedByIssues
     */
    public function removeAffectedByIssue(\Twp\Entity\Issue $affectedByIssues)
    {
        $this->affectedByIssues->removeElement($affectedByIssues);
    }

    /**
     * Get affectedByIssues
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAffectedByIssues()
    {
        return $this->affectedByIssues;
    }
}