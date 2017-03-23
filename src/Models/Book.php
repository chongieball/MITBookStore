<?php

namespace MBS\Models;

class Book extends BaseModel
{
	protected $table   = 'book';

    protected $column  = ['`id`, `publisher_id`, `isbn`, `title`, `description`,
                        `publish_year`,`total_page`, `synopsis`, `images`, `price`, `stock`'];

    protected $columns = ['b.id', 'b.publisher_id', 'b.isbn','b.title',
                        'b.description','b.publish_year', 'b.total_page', 'b.synopsis','b.images', 'b.price', 'b.stock', 'p.name AS name_publisher'];

	public function getIdWhereIn($ids)
	{
		if (!empty($ids)) {
			$this->db->select($this->column)
					 ->from($this->table)
					 ->where('id IN (' . implode(',', $ids) . ')');
			$result = $this->db->execute();
			return $result->fetchAll();
		}
	}

    public function add(array $data, $images)
    {
        $data = [
            'publisher_id'    => $data['publisher_id'],
            'isbn'            => $data['isbn'],
            'title'           => $data['title'],
            'description'     => $data['description'],
            'publish_year'    => $data['publish_year'],
            'total_page'      => $data['total_page'],
            'synopsis'        => $data['synopsis'],
            'images'          => $images,
            'price'           => $data['price'],
            'stock'           => $data['stock']
        ];
        $this->create($data);
    }

    public function changeImage($images, $column, $id)
    {
        $data = [
            'images'          => $images
        ];
        $this->update($data, $column, $id);
    }

    public function allJoin($deleted)
    {
        $param = ':deleted';
        $this->db->select($this->columns)
        ->from('book AS', 'b')
        ->join('b', 'publisher AS', 'p', 'b.publisher_id=p.id')
        ->where('b.deleted ='.$param)
        ->setParameter($param, $deleted);
        $result = $this->db->execute();
        return $result->fetchAll();
    }

    public function allDetail($id)
    {
        $param = ':id';
        $this->db->select($this->columns)
        ->from('book AS', 'b')
        ->join('b', 'publisher AS', 'p', 'b.publisher_id=p.id')
        ->where('b.deleted =0 AND b.id='.$param)
        ->setParameter($param, $id);
        $result = $this->db->execute();
        return $result->fetch();
    }
}