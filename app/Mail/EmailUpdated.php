<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $new_email;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\User $user
     * @param string $new_email
     */
    public function __construct($user, $new_email)
    {
        $this->user = $user;
        $this->new_email = $new_email;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Email, '.$this->new_email.', Has Been Updated',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'auth.emails.email_updated', // Specify the view for the email
            with: [
                'user' => $this->user->name,
                'new_email' => $this->new_email,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
