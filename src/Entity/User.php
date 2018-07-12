<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Config\Definition\BooleanNode;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Date;


/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;
    /**
     * @var string
     * @ORM\Column(type="string",unique=true)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $addr;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $country;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $lastName;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $sexe;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $metier;
    /**
     * @var \DateTimeInterface
     * @ORM\Column(type="date")
     */
    private $birthday;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $depart;

    /**
     * @return string
     */
    public function getDepart()
    {
        return $this->depart;
    }

    /**
     * @param string $depart
     */
    public function setDepart(string $depart)
    {
        $this->depart = $depart;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }





    /**
     * @return mixed
     */
    public function getPlainPassword() {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword) {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $password;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $remember_token;
    /**
     * @var bool
     * @ORM\Column(columnDefinition="TINYINT(1)")
     */
    private $admin;

    /**
     * @return string
     */
    public function getAddr()
    {
        return $this->addr;
    }

    /**
     * @param string $addr
     */
    public function setAddr($addr)
    {
        $this->addr = $addr;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }


    /**
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * @param string $sexe
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
    }

    /**
     * @return string
     */
    public function getMetier()
    {
        return $this->metier;
    }

    /**
     * @param string $metier
     */
    public function setMetier( $metier)
    {
        $this->metier = $metier;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param \DateTimeInterface $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }






    /**
     * User constructor.
     */
    public function __construct() {
        $this->roles = array("ROLE_USER");
        $this->admin = 0;
        $this->email = "";
        $this->remember_token = "";
        $this->password = "";
        $this->name = "";
        $this->addr="";
        $this->country="";
        $this->metier="";
        $this->sexe="";
        $this->lastName="";


    }



    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getRememberToken(){
        return $this->remember_token;
    }

    /**
     * @param string $remember_token
     */
    public function setRememberToken($remember_token) {
        $this->remember_token = $remember_token;
    }

    /**
     * @return bool
     */
    public function isAdmin(){
        return $this->admin;
    }

    /**
     * @param bool $admin
     */
    public function setAdmin($admin) {
        $this->admin = $admin;
    }


    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize() {
        return serialize(
            array(
                $this->id,
                $this->email,
                $this->name,
                $this->password,
            )
        );
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized) {
        list (
            $this->id,
            $this->email,
            $this->name,
            $this->password,
            ) = unserialize($serialized);
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles() {
        if ($this->admin) {
            return array('ROLE_USER','ROLE_ADMIN');
        }

        return array('ROLE_USER');
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt() {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername() {
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials() {
        // TODO: Implement eraseCredentials() method.
    }
}
