<?php
namespace App\Scopes;

use Adldap\Query\Builder;
use Adldap\Laravel\Scopes\ScopeInterface;

class EvpiuScope implements ScopeInterface
{
    /**
     * Apply the scope to a given LDAP query builder.
     *
     * @param Builder $query
     *
     * @return void
     */
    public function apply(Builder $query)
    {
        // The distinguished name of our LDAP group.
        $evpiu = 'CN=EV-PIU,DC=ciev,DC=local';

        $query->whereMemberOf($evpiu);
    }
}
