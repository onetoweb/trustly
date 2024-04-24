<?php

namespace Onetoweb\Trustly;

use Ramsey\Uuid\Uuid;

/**
 * Request
 */
class Request
{
    /**
     * @var string
     */
    private $uuid;
    
    /**
     * @var array
     */
    private $attributes = [];
    
    /**
     * @var string
     */
    private $endUserId = '';
    
    /**
     * @var string
     */
    private $messageId = '';
    
    /**
     * @var string|null
     */
    private $notificationUrl = null;
    
    /**
     * @param string $uuid
     */
    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }
    
    /**
     * @return string
     */
    public static function generateUuid(): string
    {
        return (string) Uuid::uuid4();
    }
    
    /**
     * @param string $uuid
     * @param array $attributes = []
     * @param string $endUserId = ''
     * @param string $messageId = ''
     * @param string $notificationUrl = null
     */
    public static function create(
        string $uuid,
        array $attributes = [],
        string $endUserId = '',
        string $messageId = '',
        string $notificationUrl = null
    ): Request {
        
        return (new Request($uuid))
            ->setNotificationUrl($notificationUrl)
            ->setEndUserId($endUserId)
            ->setMessageId($messageId)
            ->setAttributes($attributes)
        ;
    }
    
    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }
    
    /**
     * @return array $attributes
     * 
     * @return self
     */
    public function setAttributes(array $attributes): self
    {
        $this->attributes = $attributes;
        
        return $this;
    }
    
    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
    
    /**
     * @return string $endUserId
     * 
     * @return self
     */
    public function setEndUserId(string $endUserId): self
    {
        $this->endUserId = $endUserId;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getEndUserId(): string
    {
        return $this->endUserId;
    }
    
    /**
     * @return string $messageId
     * 
     * @return self
     */
    public function setMessageId(string $messageId): self
    {
        $this->messageId = $messageId;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getMessageId(): string
    {
        return $this->messageId;
    }
    
    /**
     * @return string $notificationUrl
     *
     * @return self
     */
    public function setNotificationUrl(string $notificationUrl): self
    {
        $this->notificationUrl = $notificationUrl;
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getNotificationUrl(): ?string
    {
        return $this->notificationUrl;
    }
}
