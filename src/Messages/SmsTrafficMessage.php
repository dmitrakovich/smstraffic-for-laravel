<?php

namespace Illuminate\Notifications\Messages;

class SmsTrafficMessage
{
    /**
     * The message content.
     */
    public string $content;

    /**
     * The phone number the message should be sent from.
     */
    public ?string $from = null;

    /**
     * The phone number the message should be sent to.
     */
    public ?string $to = null;

    /**
     * The message route.
     */
    public ?string $route = null;

    /**
     * Create a new message instance.
     *
     * @param  string  $content
     * @return void
     */
    public function __construct(string $content = '')
    {
        $this->content = $content;
    }

    /**
     * Set the message content.
     */
    public function content(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the phone number the message should be sent from.
     */
    public function from(string $from): self
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Set the phone number the message should be sent to.
     */
    public function to(string $to): self
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $route format: \<channel\>(\<ttl\>)-\<channel\>(\<ttl\>)-….-\<channel\>(\<ttl\>)-\<channel\>
     */
    public function route(string $route): self
    {
        $this->route = $route;

        return $this;
    }

}
