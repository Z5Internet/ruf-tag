<?php namespace darrenmerrett\ReactTag\app\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;    

use darrenmerrett\ReactTag\App\Http\Controllers\BatchController;

class BatchsQuery extends Query {

    protected $attributes = [
        'name' => 'batchs'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('batch'));
    }

    public function args()
    {
        return [
			'id' => ['name' => 'id', 'type' => Type::int()],
        ];
    }

    public function resolve($root, $args) {

    	return (new BatchController)->getBatchs($args);

    }

}