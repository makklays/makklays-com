<?php

namespace App\Mail;

use App\Models\Call;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CallMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $call;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Call $call)
    {
        $this->call = $call;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@makklays.com')
            ->to('office@makklays.com')
            ->subject('Заказ разработки - перезвонить | makklays.com')
            ->view('emails.call')
            ->with([
                'fio' => $this->call->fio,
                'lang' => $this->call->lang,
                'phone' => $this->call->phone,
                'messenger' => $this->call->messenger,
                'want_development' => $this->call->want_development,
                'pathToFile' => base_path() . '/public/makklays.png',
            ]);
            /*->attach(base_path() . '/public/img/makklays_.png', [
                'as' => 'makklays_logo',
                'mime' => 'image/png',
            ]);*/
    }
}
