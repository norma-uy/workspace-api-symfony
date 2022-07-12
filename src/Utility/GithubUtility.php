<?php

namespace App\Utility;


class GithubUtility
{
	public static function HeaderScopesDecode(string $scopes): array
	{
		$scopes = !empty($scopes) ? explode(',', $scopes) : [];
		$scopes = array_map(function ($scope) {

			return trim($scope);
		}, $scopes);

		return $scopes;
	}

	public static function HeaderScopesEncode(array $scopes): string
	{
		$scopes = !empty($scopes) ? implode(', ', $scopes) : '';

		return $scopes;
	}
}
