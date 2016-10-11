<?php namespace darrenmerrett\ReactTag\app\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

use GraphQl;

class BatchType extends GraphQLType {

    protected $attributes = [
        'name' => 'batch',
        'description' => 'Batch',
    ];

    public function fields() {

        return [
			'id' => [
				'type' => Type::int(),
				'description' => 'Company ID',
			],
			'added_by' => [
				'type' => Type::int(),
				'description' => 'Added by',
			],
			'taggable_type' => [
				'type' => Type::string(),
				'description' => 'Taggable type',
			],
			'slug' => [
				'type' => Type::string(),
				'description' => 'Slug',
			],
            'name' => [
                'type' => Type::string(),
                'description' => 'Name',
            ],
            'options' => [
                'type' => GraphQL::type('batchOptions'),
                'description' => 'Options',
            ],
            'tags' => [
                'type' => Type::listOf(GraphQL::type('batchTags')),
                'description' => 'Tags',
            ],
		];

    }

}