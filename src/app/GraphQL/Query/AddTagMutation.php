<?php namespace darrenmerrett\ReactTag\app\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;    
use App\companies;

use darrenmerrett\ReactTag\App\Http\Controllers\TagController;

class AddTagMutation extends Mutation {

    protected $attributes = [
        'name' => 'AddTag'
    ];

    public function type()
    {
        return GraphQL::type('Tag');
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::nonNull(Type::int())],
            'bid' => ['name' => 'bid', 'type' => Type::nonNull(Type::int())],
            'taggable_type' => ['name' => 'taggable_type', 'type' => Type::nonNull(Type::string())],
            'tag' => ['name' => 'tag', 'type' => Type::nonNull(Type::string())],
        ];
    }

    public function resolve($root, $args) {

    	return (new TagController)->addTag($args);

    }

}