<?php

namespace Sentinel\Repositories\Group;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Sentinel\Models\User;

interface SentinelGroupRepositoryInterface
{
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($data);
    
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id);

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id);

    /**
     * Return a specific user by a given id
     *
     * @param  integer $id
     * @return User
     */
    public function retrieveById($id);

    /**
     * Return a specific user by a given name
     *
     * @param  string $name
     * @return User
     */
    public function retrieveByName($name);

    /**
     * Return all the registered users
     *
     * @return Collection
     */
    public function all();
}
