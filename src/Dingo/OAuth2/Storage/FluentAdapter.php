<?php namespace Dingo\OAuth2\Storage;

use Illuminate\Database\Connection;
use Dingo\OAuth2\Storage\Fluent\Scope;
use Dingo\OAuth2\Storage\Fluent\Token;
use Dingo\OAuth2\Storage\Fluent\Client;
use Dingo\OAuth2\Storage\Fluent\AuthorizationCode;

class FluentAdapter extends Adapter {

	/**
	 * Illuminate database connection.
	 * 
	 * @var \Illuminate\Database\Connection
	 */
	protected $connection;

	/**
	 * Array of tables used when interacting with database.
	 * 
	 * @var array
	 */
	protected $tables = [
		'clients'                   => 'oauth_clients',
		'client_endpoints'          => 'oauth_client_endpoints',
		'tokens'                    => 'oauth_tokens',
		'token_scopes'              => 'oauth_token_scopes',
		'authorization_code'        => 'oauth_authorization_codes',
		'authorization_code_scopes' => 'oauth_authorization_code_scopes',
		'scopes'                    => 'oauth_scopes'
	];

	/**
	 * Create a new Dingo\OAuth2\Storage\FluentAdapter instance.
	 * 
	 * @param  \Illuminate\Database\Connection  $connection
	 * @param  array  $tables
	 * @return void
	 */
	public function __construct(Connection $connection, array $tables = [])
	{
		$this->connection = $connection;
		$this->tables = array_merge($this->tables, $tables);
	}

	/**
	 * Create the client storage instance.
	 * 
	 * @return \Dingo\OAuth2\Storage\Fluent\Client
	 */
	public function createClientStorage()
	{
		return new Client($this->connection, $this->tables);
	}
	
	/**
	 * Create the token storage instance.
	 * 
	 * @return \Dingo\OAuth2\Storage\Fluent\Token
	 */
	public function createTokenStorage()
	{
		return new Token($this->connection, $this->tables);
	}

	/**
	 * Create the authorization code storage instance.
	 * 
	 * @return \Dingo\OAuth2\Storage\Fluent\AuthorizationCode
	 */
	public function createAuthorizationStorage()
	{
		return new AuthorizationCode($this->connection, $this->tables);
	}

	/**
	 * Create the scope storage instance.
	 * 
	 * @return \Dingo\OAuth2\Storage\Fluent\Scope
	 */
	public function createScopeStorage()
	{
		return new Scope($this->connection, $this->tables);
	}

}