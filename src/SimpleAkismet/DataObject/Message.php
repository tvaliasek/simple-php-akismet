<?php
declare(strict_types=1);

namespace SimpleAkismet\DataObject;

class Message
{
    public const MESSAGE_TYPE_COMMENT = 'comment';
    public const MESSAGE_TYPE_FORUM_POST = 'forum-post';
    public const MESSAGE_TYPE_REPLY = 'reply';
    public const MESSAGE_TYPE_BLOG_POST = 'blog-post';
    public const MESSAGE_TYPE_CONTACT_FORM = 'contact-form';
    public const MESSAGE_TYPE_SIGNUP = 'signup';
    public const MESSAGE_TYPE_MESSAGE = 'message';

    protected string $blog;
    protected string $userIp;
    protected ?string $userAgent;
    protected ?string $referrer;
    protected ?string $permalink;
    protected ?string $commentType;
    protected ?string $commentAuthor;
    protected ?string $commentAuthorEmail;
    protected ?string $commentAuthorUrl;
    protected ?string $commentContent;
    protected ?\DateTimeInterface $commentDateGmt;
    protected ?\DateTimeInterface $commentPostModifiedGmt;
    protected ?string $blogLang;
    protected ?string $blogCharset = 'UTF-8';
    protected ?string $userRole;
    protected bool $isTest;
    protected ?string $recheckReason;

    public function toArray(): array
    {
        $values = [
            'blog' => $this->getBlog(),
            'user_ip' => $this->getUserIp(),
            'user_agent' => $this->getUserAgent(),
            'referrer' => $this->getReferrer(),
            'permalink' => $this->getPermalink(),
            'comment_type' => $this->getCommentType(),
            'comment_author' => $this->getCommentAuthor(),
            'comment_author_email' => $this->getCommentAuthorEmail(),
            'comment_author_url' => $this->getCommentAuthorUrl(),
            'comment_content' => $this->getCommentContent(),
            'comment_date_gmt' => ($this->getCommentDateGmt() instanceof \DateTimeInterface) ? $this->getCommentDateGmt(
            )->format('c') : null,
            'comment_post_modified_gmt' => ($this->getCommentPostModifiedGmt(
                ) instanceof \DateTimeInterface) ? $this->getCommentPostModifiedGmt()->format('c') : null,
            'blog_lang' => $this->getBlogLang(),
            'blog_charset' => $this->getBlogCharset(),
            'user_role' => $this->getUserRole(),
            'is_test' => $this->isTest() ? 'true' : 'false',
            'recheck_reason' => $this->getRecheckReason()
        ];
        return array_filter(
            $values,
            function ($item) {
                return !empty($item);
            }
        );
    }

    /**
     * @return string
     */
    public function getBlog(): string
    {
        return $this->blog;
    }

    /**
     * @param string $blog
     * @return Message
     */
    public function setBlog(string $blog): Message
    {
        $this->blog = $blog;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserIp(): string
    {
        return $this->userIp;
    }

    /**
     * @param string $userIp
     * @return Message
     */
    public function setUserIp(string $userIp): Message
    {
        $this->userIp = $userIp;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    /**
     * @param string|null $userAgent
     * @return Message
     */
    public function setUserAgent(?string $userAgent): Message
    {
        $this->userAgent = $userAgent;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReferrer(): ?string
    {
        return $this->referrer;
    }

    /**
     * @param string|null $referrer
     * @return Message
     */
    public function setReferrer(?string $referrer): Message
    {
        $this->referrer = $referrer;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPermalink(): ?string
    {
        return $this->permalink;
    }

    /**
     * @param string|null $permalink
     * @return Message
     */
    public function setPermalink(?string $permalink): Message
    {
        $this->permalink = $permalink;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCommentType(): ?string
    {
        return $this->commentType;
    }

    /**
     * @param string|null $commentType
     * @return Message
     */
    public function setCommentType(?string $commentType): Message
    {
        $this->commentType = $commentType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCommentAuthor(): ?string
    {
        return $this->commentAuthor;
    }

    /**
     * @param string|null $commentAuthor
     * @return Message
     */
    public function setCommentAuthor(?string $commentAuthor): Message
    {
        $this->commentAuthor = $commentAuthor;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCommentAuthorEmail(): ?string
    {
        return $this->commentAuthorEmail;
    }

    /**
     * @param string|null $commentAuthorEmail
     * @return Message
     */
    public function setCommentAuthorEmail(?string $commentAuthorEmail): Message
    {
        $this->commentAuthorEmail = $commentAuthorEmail;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCommentAuthorUrl(): ?string
    {
        return $this->commentAuthorUrl;
    }

    /**
     * @param string|null $commentAuthorUrl
     * @return Message
     */
    public function setCommentAuthorUrl(?string $commentAuthorUrl): Message
    {
        $this->commentAuthorUrl = $commentAuthorUrl;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCommentContent(): ?string
    {
        return $this->commentContent;
    }

    /**
     * @param string|null $commentContent
     * @return Message
     */
    public function setCommentContent(?string $commentContent): Message
    {
        $this->commentContent = $commentContent;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getCommentDateGmt(): ?DateTimeInterface
    {
        return $this->commentDateGmt;
    }

    /**
     * @param DateTimeInterface|null $commentDateGmt
     * @return Message
     */
    public function setCommentDateGmt(?DateTimeInterface $commentDateGmt): Message
    {
        $this->commentDateGmt = $commentDateGmt;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getCommentPostModifiedGmt(): ?DateTimeInterface
    {
        return $this->commentPostModifiedGmt;
    }

    /**
     * @param DateTimeInterface|null $commentPostModifiedGmt
     * @return Message
     */
    public function setCommentPostModifiedGmt(?DateTimeInterface $commentPostModifiedGmt): Message
    {
        $this->commentPostModifiedGmt = $commentPostModifiedGmt;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBlogLang(): ?string
    {
        return $this->blogLang;
    }

    /**
     * @param string|null $blogLang
     * @return Message
     */
    public function setBlogLang(?string $blogLang): Message
    {
        $this->blogLang = $blogLang;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBlogCharset(): ?string
    {
        return $this->blogCharset;
    }

    /**
     * @param string|null $blogCharset
     * @return Message
     */
    public function setBlogCharset(?string $blogCharset): Message
    {
        $this->blogCharset = $blogCharset;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUserRole(): ?string
    {
        return $this->userRole;
    }

    /**
     * @param string|null $userRole
     * @return Message
     */
    public function setUserRole(?string $userRole): Message
    {
        $this->userRole = $userRole;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTest(): bool
    {
        return $this->isTest;
    }

    /**
     * @param bool $isTest
     * @return Message
     */
    public function setIsTest(bool $isTest): Message
    {
        $this->isTest = $isTest;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRecheckReason(): ?string
    {
        return $this->recheckReason;
    }

    /**
     * @param string|null $recheckReason
     * @return Message
     */
    public function setRecheckReason(?string $recheckReason): Message
    {
        $this->recheckReason = $recheckReason;
        return $this;
    }

}