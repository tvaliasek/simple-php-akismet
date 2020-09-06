<?php
declare(strict_types=1);

namespace SimpleAkismet\DataObject;

class Message
{
    public const MESSAGE_TYPE_COMMENT = 'comment',
        MESSAGE_TYPE_FORUM_POST = 'forum-post',
        MESSAGE_TYPE_REPLY = 'reply',
        MESSAGE_TYPE_BLOG_POST = 'blog-post',
        MESSAGE_TYPE_CONTACT_FORM = 'contact-form',
        MESSAGE_TYPE_SIGNUP = 'signup',
        MESSAGE_TYPE_MESSAGE = 'message';

    public const FIELD_BLOG = 'blog',
        FIELD_USER_IP = 'user_ip',
        FIELD_USER_AGENT = 'user_agent',
        FIELD_REFERRER = 'referrer',
        FIELD_PERMALINK = 'permalink',
        FIELD_COMMENT_TYPE = 'comment_type',
        FIELD_COMMENT_AUTHOR = 'comment_author',
        FIELD_COMMENT_AUTHOR_EMAIL = 'comment_author_email',
        FIELD_COMMENT_AUTHOR_URL = 'comment_author_url',
        FIELD_COMMENT_CONTENT = 'comment_content',
        FIELD_COMMENT_DATE_GMT = 'comment_date_gmt',
        FIELD_COMMENT_POST_MODIFIED_GMT = 'comment_post_modified_gmt',
        FIELD_BLOG_LANG = 'blog_lang',
        FIELD_BLOG_CHARSET = 'blog_charset',
        FIELD_USER_ROLE = 'user_role',
        FIELD_IS_TEST = 'is_test',
        FIELD_RECHECK_REASON = 'recheck_reason';

    protected string $blog;
    protected string $userIp;
    protected ?string $userAgent = null;
    protected ?string $referrer = null;
    protected ?string $permalink = null;
    protected ?string $commentType = null;
    protected ?string $commentAuthor = null;
    protected ?string $commentAuthorEmail = null;
    protected ?string $commentAuthorUrl = null;
    protected ?string $commentContent = null;
    protected ?\DateTimeInterface $commentDateGmt = null;
    protected ?\DateTimeInterface $commentPostModifiedGmt = null;
    protected ?string $blogLang = null;
    protected ?string $blogCharset = 'UTF-8';
    protected ?string $userRole = null;
    protected bool $isTest = false;
    protected ?string $recheckReason = null;

    public function toArray(): array
    {
        $values = [
            self::FIELD_BLOG => $this->getBlog(),
            self::FIELD_USER_IP => $this->getUserIp(),
            self::FIELD_USER_AGENT => $this->getUserAgent(),
            self::FIELD_REFERRER => $this->getReferrer(),
            self::FIELD_PERMALINK => $this->getPermalink(),
            self::FIELD_COMMENT_TYPE => $this->getCommentType(),
            self::FIELD_COMMENT_AUTHOR => $this->getCommentAuthor(),
            self::FIELD_COMMENT_AUTHOR_EMAIL => $this->getCommentAuthorEmail(),
            self::FIELD_COMMENT_AUTHOR_URL => $this->getCommentAuthorUrl(),
            self::FIELD_COMMENT_CONTENT => $this->getCommentContent(),
            self::FIELD_COMMENT_DATE_GMT => ($this->getCommentDateGmt() instanceof \DateTimeInterface) ? $this->getCommentDateGmt()->format('c') : null,
            self::FIELD_COMMENT_POST_MODIFIED_GMT => ($this->getCommentPostModifiedGmt() instanceof \DateTimeInterface) ? $this->getCommentPostModifiedGmt()->format('c') : null,
            self::FIELD_BLOG_LANG => $this->getBlogLang(),
            self::FIELD_BLOG_CHARSET => $this->getBlogCharset(),
            self::FIELD_USER_ROLE => $this->getUserRole(),
            self::FIELD_IS_TEST => $this->isTest() ? 'true' : 'false',
            self::FIELD_RECHECK_REASON => $this->getRecheckReason()
        ];
        return array_filter(
            $values,
            function ($item) {
                return !empty($item);
            }
        );
    }

    public static function fromArray(array $values): Message
    {
        $message = new Message();
        if (key_exists(self::FIELD_BLOG, $values) && !empty($values[self::FIELD_BLOG])) {
            $message->setBlog($values[self::FIELD_BLOG]);
        }
        if (key_exists(self::FIELD_USER_IP, $values) && !empty($values[self::FIELD_USER_IP])) {
            $message->setUserIp($values[self::FIELD_USER_IP]);
        }
        if (key_exists(self::FIELD_USER_AGENT, $values) && !empty($values[self::FIELD_USER_AGENT])) {
            $message->setUserAgent($values[self::FIELD_USER_AGENT]);
        }
        if (key_exists(self::FIELD_REFERRER, $values) && !empty($values[self::FIELD_REFERRER])) {
            $message->setReferrer($values[self::FIELD_REFERRER]);
        }
        if (key_exists(self::FIELD_PERMALINK, $values) && !empty($values[self::FIELD_PERMALINK])) {
            $message->setPermalink($values[self::FIELD_PERMALINK]);
        }
        if (key_exists(self::FIELD_COMMENT_TYPE, $values) && !empty($values[self::FIELD_COMMENT_TYPE])) {
            $message->setCommentType($values[self::FIELD_COMMENT_TYPE]);
        }
        if (key_exists(self::FIELD_COMMENT_AUTHOR, $values) && !empty($values[self::FIELD_COMMENT_AUTHOR])) {
            $message->setCommentAuthor($values[self::FIELD_COMMENT_AUTHOR]);
        }
        if (key_exists(self::FIELD_COMMENT_AUTHOR_EMAIL, $values) && !empty($values[self::FIELD_COMMENT_AUTHOR_EMAIL])) {
            $message->setCommentAuthorEmail($values[self::FIELD_COMMENT_AUTHOR_EMAIL]);
        }
        if (key_exists(self::FIELD_COMMENT_AUTHOR_URL, $values) && !empty($values[self::FIELD_COMMENT_AUTHOR_URL])) {
            $message->setCommentAuthorUrl($values[self::FIELD_COMMENT_AUTHOR_URL]);
        }
        if (key_exists(self::FIELD_COMMENT_CONTENT, $values) && !empty($values[self::FIELD_COMMENT_CONTENT])) {
            $message->setCommentContent($values[self::FIELD_COMMENT_CONTENT]);
        }
        if (key_exists(self::FIELD_COMMENT_DATE_GMT, $values) && !empty($values[self::FIELD_COMMENT_DATE_GMT]) && $values[self::FIELD_COMMENT_DATE_GMT] instanceof \DateTimeInterface) {
            $message->setCommentDateGmt($values[self::FIELD_COMMENT_DATE_GMT]);
        }
        if (key_exists(self::FIELD_COMMENT_POST_MODIFIED_GMT, $values) && !empty($values[self::FIELD_COMMENT_POST_MODIFIED_GMT]) && $values[self::FIELD_COMMENT_POST_MODIFIED_GMT] instanceof \DateTimeInterface) {
            $message->setCommentPostModifiedGmt($values[self::FIELD_COMMENT_POST_MODIFIED_GMT]);
        }
        if (key_exists(self::FIELD_BLOG_LANG, $values) && !empty($values[self::FIELD_BLOG_LANG])) {
            $message->setBlogLang($values[self::FIELD_BLOG_LANG]);
        }
        if (key_exists(self::FIELD_BLOG_CHARSET, $values) && !empty($values[self::FIELD_BLOG_CHARSET])) {
            $message->setBlogCharset($values[self::FIELD_BLOG_CHARSET]);
        }
        if (key_exists(self::FIELD_USER_ROLE, $values) && !empty($values[self::FIELD_USER_ROLE])) {
            $message->setUserRole($values[self::FIELD_USER_ROLE]);
        }
        if (key_exists(self::FIELD_IS_TEST, $values) && !empty($values[self::FIELD_IS_TEST])) {
            $message->setIsTest($values[self::FIELD_IS_TEST]);
        }
        if (key_exists(self::FIELD_RECHECK_REASON, $values) && !empty($values[self::FIELD_RECHECK_REASON])) {
            $message->setRecheckReason($values[self::FIELD_RECHECK_REASON]);
        }
        return $message;
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
     * @return \DateTimeInterface|null
     */
    public function getCommentDateGmt(): ?\DateTimeInterface
    {
        return $this->commentDateGmt;
    }

    /**
     * @param \DateTimeInterface|null $commentDateGmt
     * @return Message
     */
    public function setCommentDateGmt(?\DateTimeInterface $commentDateGmt): Message
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
