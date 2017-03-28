<?php

namespace MBS\Models;

class Book extends BaseModel
{
	protected $table   = 'book';
    protected $column  = ['`id`, `publisher_id`, `isbn`, `title`, `slug`, `description`, `publish_year`,`total_page`, `synopsis`, `images`, `price`, `stock`'];
    protected $columns = ['b.id', 'b.publisher_id', 'b.isbn','b.title',
                        'b.description', 'b.slug', 'b.publish_year', 'b.total_page', 'b.synopsis','b.images', 'b.price', 'b.stock', 'p.name AS publisher_name'];

	public function getIdWhereIn($ids)
	{
		if (!empty($ids)) {
			$this->qb->select($this->column)
					 ->from($this->table)
					 ->where('id IN (' . implode(',', $ids) . ')');
			$result = $this->qb->execute();
			return $result->fetchAll();
		}
	}

    public function add(array $data, $images)
    {
        if ($data['publisher_id']) {
            $data['publisher_id'];
        } else {
            settype($data['publisher_id'], "null");
        }
        $data = [
            'publisher_id'  => $data['publisher_id'],
            'isbn'          => $data['isbn'],
            'title'         => $data['title'],
            'slug'          => preg_replace('/[^A-Za-z0-9-]+/', '-', $data['title']),
            'description'   => $data['description'],
            'publish_year'  => $data['publish_year'],
            'total_page'    => $data['total_page'],
            'synopsis'      => $data['synopsis'],
            'images'        => $images,
            'price'         => $data['price'],
            'stock'         => $data['stock']
        ];
        $this->create($data);
    }

    public function changeImage($images, $column, $id)
    {
        $data = [
            'images'    => $images
        ];
        $this->update($data, $column, $id);
    }

    public function allDetail($column, $value, $deleted)
    {
        $find = $this->find($column, $value);
        $param = ':id';
        $this->qb->select($this->columns)
        ->from('book AS', 'b')
        ->leftJoin('b', 'publisher AS', 'p', 'b.publisher_id=p.id')
        ->where('b.deleted = '. $deleted. ' AND b.id='.$param)
        ->setParameter($param, $find['id']);
        $result = $this->qb->execute();
        return $result->fetch();
    }

    public function bookUpdate(array $data, $column, $value)
    {
        if ($data['publisher_id']) {
            $data['publisher_id'];
        } else {
            settype($data['publisher_id'], "null");
        }
        $data = [
            'publisher_id'  => $data['publisher_id'],
            'isbn'          => $data['isbn'],
            'title'         => $data['title'],
            'slug'          => preg_replace('/[^A-Za-z0-9-]+/', '-', $data['title']),
            'description'   => $data['description'],
            'publish_year'  => $data['publish_year'],
            'total_page'    => $data['total_page'],
            'synopsis'      => $data['synopsis'],
            'price'         => $data['price'],
            'stock'         => $data['stock']
        ];
        $this->update($data, $column, $value);
    }
}