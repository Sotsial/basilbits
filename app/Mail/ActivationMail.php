<?php
// app/Mail/ActivationMail.php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ActivationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $activationLink;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param string $activationLink
     * @return void
     */
    public function __construct($user, $activationLink)
    {
        $this->user = $user;
        $this->activationLink = $activationLink;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Добавляем подробное логирование
        \Log::info('Компоновка письма активации', [
            'user_email' => $this->user->email,
            'activation_link' => $this->activationLink
        ]);

        return $this->subject('Активация аккаунта')
                    ->markdown('emails.activation')
                    ->with([
                        'name' => $this->user->name,
                        'activationLink' => $this->activationLink
                    ]);
    }
}