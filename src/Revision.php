<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SimpleThings\EntityAudit;

/**
 * Revision is returned from {@link AuditReader::getRevisions()}.
 */
class Revision
{
    /**
     * @var int|string
     */
    private $rev;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $locale;

    /**
     * @param $rev
     * @param \DateTime $timestamp
     * @param string|null $username
     * @param string|null $locale
     */
    public function __construct($rev, \DateTime $timestamp, ?string $username, ?string $locale)
    {
        $this->rev = $rev;
        $this->timestamp = $timestamp;
        $this->username = $username;
        $this->locale = !empty($locale) ? $locale : '-';
    }

    /**
     * @return int|string
     */
    public function getRev()
    {
        return $this->rev;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return string|null
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string|null
     */
    public function getLocale()
    {
        return $this->locale!== '' ? $this->locale : '-';
    }
}
