<?php namespace darrenmerrett\ReactTag\Model;

use Conner\Tagging\Contracts\TaggingUtility;
use Illuminate\Database\Eloquent\Model as Eloquent;

class TagBatch extends Eloquent
{
    protected $table = 'tagging_tag_batch';
    public $timestamps = false;
    protected $softDelete = false;
    public $fillable = ['name'];
    protected $taggingUtility;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->taggingUtility = app(TaggingUtility::class);
    }

    /**
     * sets the slug when setting the group name
     *
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

}
