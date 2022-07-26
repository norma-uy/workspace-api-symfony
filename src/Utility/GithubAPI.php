<?php

namespace App\Utility;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class GithubAPI
{
    private const GITHUB_API_URL = 'https://api.github.com/';
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => self::GITHUB_API_URL]);
    }

    /**
     * Undocumented function
     *
     * @param string $pa_token
     * @param string $username
     * @return ResponseInterface|null
     */
    public function getUser(
        string $pa_token,
        string $username,
    ): ?ResponseInterface {
        if (empty($pa_token) || empty($username)) {
            return null;
        }

        $uri = "/users/{$username}";

        $response = $this->client->request('GET', $uri, [
            'headers' => [
                'Accept' => 'application/vnd.github+json',
                'Authorization' => "token {$pa_token}",
            ],
        ]);

        return $response->getStatusCode() == 200 ? $response : null;
    }

    /**
     * Undocumented function
     *
     * @param string $pa_token
     * @param string $org_name
     * @return ResponseInterface|null
     */
    public function getOrganization(
        string $pa_token,
        string $org_name,
    ): ?ResponseInterface {
        if (empty($pa_token) || empty($org_name)) {
            return null;
        }

        $uri = "/orgs/{$org_name}";

        $response = $this->client->request('GET', $uri, [
            'headers' => [
                'Accept' => 'application/vnd.github+json',
                'Authorization' => "token {$pa_token}",
            ],
        ]);

        return $response->getStatusCode() == 200 ? $response : null;
    }

    /**
     * Undocumented function
     *
     * @param string $pa_token
     * @return ResponseInterface|null
     */
    public function getOrganizationByAuthenticatedUser(
        string $pa_token,
    ): ?ResponseInterface {
        if (empty($pa_token)) {
            return null;
        }

        $uri = '/user/orgs';

        $response = $this->client->request('GET', $uri, [
            'headers' => [
                'Accept' => 'application/vnd.github+json',
                'Authorization' => "token {$pa_token}",
            ],
        ]);

        return $response->getStatusCode() == 200 ? $response : null;
    }
}
