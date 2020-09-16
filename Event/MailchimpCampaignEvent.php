<?php


namespace BrandcodeNL\SonataMailchimpPublisherBundle\Event;


use AppBundle\Entity\TimelineMessage;
use Symfony\Component\EventDispatcher\Event;

class MailchimpCampaignEvent extends Event
{

    protected $resultData;

    public function __construct(array $resultData)
    {
        $this->resultData = $resultData;
    }

    public function getResultData(): array
    {
        return $this->resultData;
    }

}
