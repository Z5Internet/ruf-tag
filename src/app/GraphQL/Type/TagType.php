<?php namespace darrenmerrett\ReactTag\app\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

use GraphQl;

class TagType extends GraphQLType {

    protected $attributes = [
        'name' => 'tag',
        'description' => 'Tag',
    ];

    public function fields() {

        return [
			'id' => [
				'type' => Type::int(),
				'description' => 'Company ID',
			],
			'tag' => [
				'type' => Type::string(),
				'description' => 'Tag',
			],
			'taggable_type' => [
				'type' => Type::string(),
				'description' => 'Taggable type',
			],
			'added_by' => [
				'type' => Type::int(),
				'description' => 'Tag added by',
			],
		];

    }

}