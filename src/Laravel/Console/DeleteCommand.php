<?php namespace Dingo\OAuth2\Laravel\Console;

use Dingo\OAuth2\Token;
use Dingo\OAuth2\Storage\Adapter;
use Symfony\Component\Console\Input\InputArgument;

class DeleteCommand extends Command {

	/**
	 * Command name.
	 * 
	 * @var string
	 */
	protected $name = 'oauth:delete';

	/**
	 * Command description.
	 * 
	 * @var string
	 */
	protected $description = 'Delete a scope or client from storage';

	/**
	 * Fire the install command.
	 * 
	 * @return void
	 */
	public function fire()
	{
		$entity = $this->argument('entity');

		if ( ! in_array($entity, ['scope', 'client']))
		{
			$this->error('Unable to delete unknown entity "'.$entity.'", available entities "scope" or "client".');

			exit;
		}

		$this->{'delete'.ucfirst($entity).'Entity'}();
	}

	/**
	 * Delete a scope entity.
	 * 
	 * @return void
	 */
	protected function deleteScopeEntity()
	{
		$identifier = $this->argument('identifier');

		$scope = $this->storage('scope')->get($identifier);

		if ( ! $scope)
		{
			$this->error('Scope "'.$identifier.'" does not exist in storage.');

			exit;
		}

		$this->comment('Please review the scopes JSON representation below.');

		$this->blankLine();

		$this->line(json_encode($scope->getAttributes(), JSON_PRETTY_PRINT));

		$this->blankLine();

		if ($this->confirm('Are you sure you want to delete this scope? (y/N)</question> ', false))
		{
			$this->storage('scope')->delete($identifier);

			$this->info('Scope has been deleted.');
		}
		else
		{
			$this->comment('Scope was not deleted.');
		}
	}

	/**
	 * Delete a client entity.
	 * 
	 * @return void
	 */
	protected function deleteClientEntity()
	{
		$identifier = $this->argument('identifier');

		$client = $this->storage('client')->get($identifier);

		if ( ! $client)
		{
			$this->error('Client "'.$identifier.'" does not exist in storage.');

			exit;
		}

		$this->comment('Please review the clients JSON representation below.');

		$this->blankLine();

		$this->line(json_encode($client->getAttributes(), JSON_PRETTY_PRINT));

		$this->blankLine();

		if ($this->confirm('Are you sure you want to delete this client? (y/N)</question> ', false))
		{
			$this->storage('client')->delete($identifier);

			$this->info('Client has been deleted.');
		}
		else
		{
			$this->comment('Client was not deleted.');
		}
	}

	/**
	 * Get the command arguments.
	 * 
	 * @return array
	 */
	public function getArguments()
	{
		return [
			['entity', InputArgument::REQUIRED, 'Entity to delete (scope or client).'],
			['identifier', InputArgument::REQUIRED, 'Scope or client identifier.']
		];
	}

}