<?php

namespace AiDaYu\Customer\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface AppUserInterface extends ExtensibleDataInterface
{
    const ID='id';
    const NAME='name';
    const EMAIL='email';
    const PHONE='phone';

    /**
     * Get id
     *
     * @return int
     */
    public function getId();

    /**
     * Set id
     *
     * @param int $id
     * @return void
     */
    public function setId(int $id);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name);

    /**
     * Get Email
     *
     * @return string
     */
    public function getEmail();

    /**
     * Set email
     *
     * @param string $email
     * @return void
     */
    public function setEmail(string $email);

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone();

    /**
     * Set phone
     *
     * @param string $phone
     * @return void
     */
    public function setPhone(string $phone);

    /**
     * Retrieve existing extension attributes object
     *
     * @return \AiDaYu\Customer\Api\Data\AppUserExtensionInterface|null
     */
    public function getExtensionAttributes(): ?AppUserExtensionInterface;

    /**
     * Set an extension attributes object
     *
     * @param \AiDaYu\Customer\Api\Data\AppUserExtensionInterface $extensionAttributes
     * @return void
     */
    public function setExtensionAttributes(AppUserExtensionInterface $extensionAttributes);
}
