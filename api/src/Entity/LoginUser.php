<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource(
 *     collectionOperations={},
 *     itemOperations={
 *          "login_form"={"method"="GET", "route_name"="login_form"}
 *     }
 * )
 * @author Daniel West <daniel@silverback.is>
 */
class LoginUser
{
    /**
     * @ApiProperty(identifier=true)
     * @var int
     */
    protected $id = 0;

    /**
     * @ApiProperty()
     * @var string
     */
    protected $_username = '';

    /**
     * @ApiProperty()
     * @var string
     */
    protected $_password = '';

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->_username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username): void
    {
        $this->_username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->_password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password): void
    {
        $this->_password = $password;
    }
}
