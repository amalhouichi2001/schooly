<?php





    
    namespace App\Mail;

    use App\Models\Inscription;
    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;
    
    class PaiementConfirmationMail extends Mailable
    {
        use Queueable, SerializesModels;
    
        public $inscription;
    
        public function __construct(Inscription $inscription)
        {
            $this->inscription = $inscription;
        }
    
        public function build()
        {
            return $this->subject('Confirmation de votre paiement')
                        ->markdown('emails.paiement.confirmation');
        }
   
    
    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.paiement.confirmation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
