<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class Repository implements RepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Find a specific record in the database
     * @return Model
     */
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create new record in the database
     * @return Model
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update a record in the database
     * @return Model
     */
    public function update($id, array $data)
    {
        $object = $this->find($id);
        $object->update($data);

        return $object;
    }

    /**
     * Delete a record in the database
     * @return boolean
     */
    public function delete($id)
    {
        $object = $this->find($id);
        return $object->delete();
    }

    /**
     * Create Query Builder from the model
     *
     * @return Model
     */
    public function query()
    {
        return $this->model->query();
    }
}