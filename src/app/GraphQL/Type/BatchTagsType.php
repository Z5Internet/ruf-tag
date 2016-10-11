<?php namespace darrenmerrett\ReactTag\app\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

use GraphQl;

class BatchTagsType extends GraphQLType {

    protected $attributes = [
        'name' => 'batchTags',
        'description' => 'Batch Tags',
    ];

    public function fields() {

        return [
			'name' => [
				'type' => Type::string(),
				'description' => 'batch tags name',
			],
			'slug' => [
				'type' => Type::string(),
				'description' => 'batch tags slug',
			],
		];

    }

}