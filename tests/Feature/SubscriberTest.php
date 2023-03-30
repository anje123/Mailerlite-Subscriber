<?php

namespace Tests\Feature;

use App\Models\Account;
use MailerLiteApi\MailerLite;
use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubscriberTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        // Add a new row to the `account` table
        Account::create([
            'api_key' => 'Test API key',
        ]);
    }

    public function test_new_subscriber_was_created_sucessfully()
    {
        $mailerLiteMock = Mockery::mock(MailerLite::class)->makePartial();
        $mailerLiteMock->shouldReceive('subscribers->create')
            ->once() 
            ->andReturn(collect());

        $this->app->instance(MailerLite::class, $mailerLiteMock);

        $data = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'country' => 'US',
        ];

        $response = $this->post('/subscriber', $data);

        $response->assertSessionHas('success');
        $response->assertSessionHas('success', 'Subscriber stored successfully');
    }

    public function test_account_cannot_create_subscriber_with_invalid_infos()
    {
        $data = [
            'name' => 12,
            'email' => '12',
            'country' => 'US',
        ];

        $this->post('/subscriber', $data);

        $this->assertFalse(session()->has('success'));
    }

    public function test_subscribers_was_gotten_sucessfully()
    {
        $mailerLiteMock = Mockery::mock(MailerLite::class)->makePartial();
        $mailerLiteMock->shouldReceive('subscribers->get')
            ->once() 
            ->andReturn(collect());
    
        $this->app->instance(MailerLite::class, $mailerLiteMock);
    
        // Make a request to the index method
        $response = $this->get('/subscriber', []);
    
        $response->assertOk();
        $response->assertViewIs('subscriber.index');
    }

    public function test_subscriber_was_updated_sucessfully()
    {
        $id = 123;
        $requestData = [
            'name' => 'John Doe',
            'country' => 'US'
        ];

        $mailerLiteMock = Mockery::mock(MailerLite::class)->makePartial();
        $mailerLiteMock->shouldReceive('subscribers->update')
            ->once() 
            ->with($id, $requestData)
            ->andReturn(collect());

        $this->app->instance(MailerLite::class, $mailerLiteMock);

        $response = $this->patch(route('subscriber.update', $id), $requestData);


        $response->assertSessionHas('success');
        $response->assertSessionHas('success', 'Subscriber updated successfully');
    }

    public function test_account_cannot_update_subscriber_with_invalid_infos()
    {
        $data = [
            'name' => 12,
        ];

        $this->post('/subscriber', $data);

        $this->assertFalse(session()->has('success'));
    }

    public function test_subscriber_was_deleted_sucessfully()
    {
        $id = 123;
    
        $mailerLiteMock = Mockery::mock(MailerLite::class)->makePartial();
        $mailerLiteMock->shouldReceive('subscribers->delete')
        ->once()
        ->andReturn(collect());

        $this->app->instance(MailerLite::class, $mailerLiteMock);

        $response = $this->delete(route('subscriber.destroy', $id));


        $response->assertSessionHas('success');
        $response->assertSessionHas('success', 'Subscriber deleted successfully');
    }
}
