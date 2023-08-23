<?php

namespace AiDaYu\Customer\Model;

use AiDaYu\Customer\Api\Data\AppUserInterface;
use AiDaYu\Customer\Api\Data\AppUserExtensionInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

class AppUser extends AbstractExtensibleModel implements AppUserInterface
{

    protected function _construct()
    {
        $this->_init(ResourceModel\AppUser::class);
    }
    /**
     * @inheritDoc
     */
    public function getId()
    {
        return parent::getData(self::ID);
    }

    /**
     * @inheritDoc
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return parent::getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getEmail()
    {
        return parent::getData(self::EMAIL);
    }

    /**
     * @inheritDoc
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * @inheritDoc
     */
    public function getPhone()
    {
        return parent::getData(self::PHONE);
    }

    /**
     * @inheritDoc
     */
    public function setPhone($phone)
    {
        return $this->setData(self::PHONE, $phone);
    }

    /**
     * @inheritDoc
     */
    public function getExtensionAttributes(): ?AppUserExtensionInterface
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * @inheritDoc
     */
    public function setExtensionAttributes(AppUserExtensionInterface $extensionAttributes)
    {
        $this->_setExtensionAttributes($extensionAttributes);
    }
}
