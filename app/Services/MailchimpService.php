<?php

namespace App\Services;

use App\Models\User;
use DrewM\MailChimp\MailChimp;

class MailchimpService
{
    protected $mailchimp;

    public function __construct()
    {
        // Replace 'your-api-key' with your actual Mailchimp API key
        $this->mailchimp = new MailChimp(env('NEWSLETTER_API_KEY'));
    }

    public function createList($listName, $emailTypeOption = false)
    {
        $response = $this->mailchimp->post('lists', [
            'name' => $listName,
            'contact' => [
                'company' => 'Your Company',
                'address1' => 'Your Address',
                'city' => 'Your City',
                'state' => 'Your State',
                'zip' => 'Your Zip',
                'country' => 'Your Country',
            ],
            'permission_reminder' => 'You are receiving this email because you signed up for updates from us.',
            'campaign_defaults' => [
                'from_name' => 'Your Name',
                'from_email' => 'your@email.com',
                'subject' => 'Subject of your campaigns',
                'language' => 'en',
            ],
            'email_type_option' => $emailTypeOption,
        ]);

        return $response;
    }

    public function addSubscriberToList($listId, User $user)
    {
        $response = $this->mailchimp->post("lists/{$listId}/members", [
            'email_address' => $user->email,
            'status' => 'subscribed',
        ]);

        return $response;
    }

    public function getAllLists()
    {
        $response = $this->mailchimp->get('lists');

        return $response;
    }

    public function getListDetails($listId)
    {
        $response = $this->mailchimp->get("lists/{$listId}");

        return $response;
    }
}
