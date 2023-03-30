<?php

namespace App\Repositories;

use App\Interfaces\MailerRepositoryInterface;
use MailerLiteApi\MailerLite;


class MailerRepository implements MailerRepositoryInterface 
{
    protected $mailerLite;

    public function __construct(MailerLite $mailerLite) {
       $this->mailerLite =  $mailerLite;
    }

    public function getSubscribers() 
    {
        return $this->mailerLite->subscribers()->get();
    }

    public function getSubscriber($id) 
    {
        return $this->mailerLite->subscribers()->find($id);
    }

    public function deleteSubscriber($id) 
    {
        return $this->mailerLite->subscribers()->delete($id);
    }

    public function createSubscriber(array $details) 
    {
        return $this->mailerLite->subscribers()->create($details);
    }

    public function updateSubscriber($id, array $newDetails) 
    {
       return $this->mailerLite->subscribers()->update($id, $newDetails);
    }
}
