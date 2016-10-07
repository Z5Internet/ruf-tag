<?php namespace darrenmerrett\ReactTag\Model;

use Conner\Tagging\Model\Tagged as RTTagged;

class Tagged extends RTTagged {

	protected $fillable = ['tag_name', 'tag_slug', 'tid', 'tag_batch_id', 'tag_group_id', 'added_by'];
	
}