<?php

declare(strict_types=1);

/*
 * This file is part of Laravel Alert.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Alert;

use Illuminate\Session\Store;
use Illuminate\Support\MessageBag;

class Alert
{
    /**
     * @var Store
     */
    private $session;

    /**
     * \BrianFaust\Alert\Alert constructor.
     *
     * @param Store $session
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Flash an alert.
     *
     * @param string $message
     * @param string $level
     * @param string $title
     * @param bool   $overlay
     *
     * @return $this
     */
    public function flash($message, string $level = 'info', ?string $title = null, bool $overlay = false): self
    {
        if (is_array($message)) {
            $message = new MessageBag($message);
        }

        $values = $this->session->get('alert.messages', []);
        $values[] = compact('message', 'level', 'title');

        $this->session->flash('alert.messages', $values);

        return $this;
    }

    /**
     * Flash a success alert.
     *
     * @param string $message
     * @param string|null $title
     *
     * @return \BrianFaust\Alert\Alert
     */
    public function success(string $message, ?string $title = null): self
    {
        return $this->flash($message, config('laravel-alert.classes.success'), $title);
    }

    /**
     * Flash an info alert.
     *
     * @param string $message
     * @param string|null $title
     *
     * @return \BrianFaust\Alert\Alert
     */
    public function info(string $message, ?string $title = null): self
    {
        return $this->flash($message, config('laravel-alert.classes.info'), $title);
    }

    /**
     * Flash a warning alert.
     *
     * @param string $message
     * @param string|null $title
     *
     * @return \BrianFaust\Alert\Alert
     */
    public function warning(string $message, ?string $title = null): self
    {
        return $this->flash($message, config('laravel-alert.classes.warning'), $title);
    }

    /**
     * Flash an error alert.
     *
     * @param string $message
     * @param string|null $title
     *
     * @return \BrianFaust\Alert\Alert
     */
    public function error(string $message, ?string $title = null): self
    {
        return $this->flash($message, config('laravel-alert.classes.error'), $title);
    }
}
