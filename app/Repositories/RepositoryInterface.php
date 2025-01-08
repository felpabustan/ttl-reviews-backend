<?php
namespace App\Repositories;

interface RepositoryInterface
{
    /**
     * Find a specific record in the database
     */
    public function find($id);

    /**
     * Create new record in the database
     */
    public function create(array $data);

    /**
     * Update a record in the database
     */
    public function update($id, array $data);

    /**
     * Delete a record in the database
     */
    public function delete($id);

    /**
     * Create Query Builder from the model
     *
     * @return Model
     */
    public function query();
}