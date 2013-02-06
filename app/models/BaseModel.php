<?php

use Dws\Slender\Api\Support\Query\FromArrayBuilder;

/**
 * Base Model
 */
class BaseModel extends MongoModel
{
	protected $site = 'default';

	protected $schema = array();
	
	protected $relations = array(
		'children' => array(),
		'parents' => array(),
	);

	public function findById($id)
	{
		return parent::find($id);
	}
	
	/**
	 * Get a collection of documents in this collection
	 * 
	 * @param array $conditions
	 * @param array $orders
	 * @param type $limit
	 * @param type $offset
	 */
	public function findMany(array $conditions, array $fields, array $orders, &$meta, array $aggregate = null, $take = null, $skip = null)
	{
		
		$builder = $this->getCollection();

		if ($conditions) {
			$builder = FromArrayBuilder::buildWhere($builder, $conditions);
		}

		if ($aggregate) {

			/*
			determine the type of aggregate function
			end run the correct execution
			return the aggregate data via ref $meta
			*/

			if ($aggregate[0] == 'count') {
				$results = $builder->count();
			} else {
				$results = $builder->$aggregate[0]($aggregate[1]); 
				$meta['count'] = null;
			}


			$meta[$aggregate[0]] = $results; 

			return [];
		}

		if ($orders) {
			$builder = FromArrayBuilder::buildOrders($builder,$orders);
		}

		if ($take) {
			$builder = $builder->take($take);	
		}

		if ($skip) {
			$builder = $builder->skip($skip);	
		}

		if ($fields) {
			$result = $builder->get($fields);	
		} else {
			$result = $builder->get();	
		}	

		$entities = array();

		foreach ($result as $entity) {
			$entities[] = $entity;
		}

		$meta['count'] = count($entities);

		return $entities;
	}
	
	/**
	 * Insert data into the collection
	 * 
	 * @param array $data
	 * @return array
	 */
	public function insert(array $data)
	{
		$id = $this->getCollection()->insert($data);
		$entity = $this->findById($id);
		$this->updateParents($id, $entity);
		return $entity;
	}
	
	/**
	 * Update data of the record
	 *
	 * @param string $id 
	 * @param array $data
	 * @return array
	 */
	public function update($id, array $data)
	{
		$this->getCollection()->where('_id', $id)->update($data);
		$entity = $this->findById($id);
		return $entity;
	}
	
	/**
	 * Delete record
	 *
	 * @param string $id 
	 * @return array
	 */
	public function delete($id)
	{
		$this->getCollection()->where('_id', $id)->delete();
		$this->updateParents($id, true);
		return true;
	}
	
	/**
	 * Return information about abstract record including 
	 * representation of the fields to help to pass correct data
	 * for insert and update methods
	 *
	 * @return array
	 */
	public function options()
	{	
		// @TODO clean up $this->schema before passing up
		return array(
				'fields' => $this->schema,
			);
	}
	
	/**
	 * @todo
	 * @param array $data
	 */
	protected function embedChildren(array $data)
	{
	}
	
	/**
	 * @todo
	 * @param array $data
	 * @param boolean $isDelete
	 */
	protected function updateParents($id, $isDelete = false)
	{
	}


	public function getSchemaValidation(){
		return $this->schema;
	}
}
