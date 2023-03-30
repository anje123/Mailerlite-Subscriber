<?php

namespace App\Interfaces;

interface MailerRepositoryInterface 
{
/**
 * Get all subscribers.
 *
 * @return array Returns an array of all subscribers.
 */
public function getSubscribers();

/**
 * Get subscriber.
 *
 * @return object response
 */
public function getSubscriber($id);

/**
 * Delete a subscriber by ID.
 *
 * @param int $id The ID to delete.
 * @return object response
 */
public function deleteSubscriber($id);

/**
 * Create a new subscriber.
 *
 * @param array $details An array of subscriber details including email, name, and country.
 * @return object response
 */
public function createSubscriber(array $details);

/**
 * Update an existing subscriber.
 *
 * @param int $id The ID of the subscriber to update.
 * @param array $newDetails An array of updated subscriber details including name and country.
 * @return object response
 */
public function updateSubscriber($id, array $newDetails);

}
