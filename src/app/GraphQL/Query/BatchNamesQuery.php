<?php namespace darrenmerrett\ReactTag\app\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;    

use darrenmerrett\ReactTag\App\Http\Controllers\BatchController;

class BatchNamesQuery extends Query {

    protected $attributes = [
        'name' => 'BatchNamesQuery'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('BatchNames'));
    }

    public function args()
    {
        return [];
    }

    public function resolve($root, $args) {

    	return (new BatchController)->getBatchNames($args);

    }

}