<?php namespace darrenmerrett\ReactTag\app\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;    

use darrenmerrett\ReactTag\App\Http\Controllers\BatchController;

class BatchsQuery extends Query {

    protected $attributes = [
        'name' => 'BatchsQuery'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('Batch'));
    }

    public function args()
    {
        return [
			'id' => ['name' => 'id', 'type' => Type::int()],
            'type' => ['name' => 'type', 'type' => Type::string()],
        ];
    }

    public function resolve($root, $args) {

    	return (new BatchController)->getBatchs($args);

    }

}