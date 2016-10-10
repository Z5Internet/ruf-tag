<?php namespace darrenmerrett\ReactTag\app\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

use GraphQl;

class BatchNamesType extends GraphQLType {

    protected $attributes = [
        'name' => 'batchNames',
        'description' => 'Batch names',
    ];

    public function fields() {

        return [
			'name' => [
				'type' => Type::string(),
				'description' => 'name',
			],
			'slug' => [
				'type' => Type::string(),
				'description' => 'slug',
			],
		];

    }

}