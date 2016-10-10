<?php namespace darrenmerrett\ReactTag\app\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;    
use App\companies;

use darrenmerrett\ReactTag\App\Http\Controllers\BatchController;

class AddBatchMutation extends Mutation {

    protected $attributes = [
        'name' => 'AddBatch'
    ];

    public function type()
    {
        return GraphQL::type('batch');
    }

    public function args()
    {
        return [
            'name' => ['name' => 'name', 'type' => Type::nonNull(Type::string())],
            'taggable_type' => ['name' => 'taggable_type', 'type' => Type::nonNull(Type::string())],
            'multi' => ['name' => 'multi', 'type' => Type::boolean()],
            'selections' => ['name' => 'selections', 'type' => Type::nonNull(Type::string())],
        ];
    }

    public function resolve($root, $args) {

    	return (new BatchController)->addBatch($args);

    }

}