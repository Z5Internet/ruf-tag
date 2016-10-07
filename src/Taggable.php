<?php namespace darrenmerrett\ReactTag;

use Conner\Tagging\Taggable as RTTaggable;

use darrenmerrett\ReactTag\Model\Tagged;
use darrenmerrett\ReactTag\Model\TagGroup;

use Conner\Tagging\Events\TagAdded;
use Conner\Tagging\Events\TagRemoved;
use Conner\Tagging\Contracts\TaggingUtility;

use Team;

use Auth;

use darrenmerrett\ReactTag\Model\TagBatch;

/**
 * Copyright (C) 2014 Robert Conner
 */
trait Taggable
{

	use RTTaggable;

	public function tag($batch_id, $tagNames) {

		$tagNames = static::$taggingUtility->makeTagArray($tagNames);
		
		foreach($tagNames as $tagName) {
			$this->addTag($batch_id, $tagName);
		}

	}

	private function addTag($batch_id, $tagName) {

		$this->checkBatchBelongsToCurrentTeamOrFail($batch_id);

		$tagName = trim($tagName);
		
		$normalizer = config('tagging.normalizer');
		$normalizer = $normalizer ?: [static::$taggingUtility, 'slug'];

		$tagSlug = call_user_func($normalizer, $tagName);
		
		$previousCount = $this->tagged()->where('tag_slug', '=', $tagSlug)->take(1)->count();
		if($previousCount >= 1) { return; }
		
		$displayer = config('tagging.displayer');
		$displayer = empty($displayer) ? '\Illuminate\Support\Str::title' : $displayer;

		$checkBatch = TagBatch::find($batch_id);

		if (count($checkBatch)==0) {

			throw new \Exception('TagBatch '.$batch_id.' doesn\'t exist');

		}

		$options = json_decode($checkBatch->options);

		if (!is_null($options->selections) && !in_array($tagName, $options->selections)) {

			throw new \Exception('Tag not in selection');

		}	

		if ($options->quantity == 1) {

			$this->untag($batch_id);

		}

		$tagged = new Tagged(array(
			'tag_name'=>call_user_func($displayer, $tagName),
			'tag_slug'=>$tagSlug,
			'tid' => Team::currentTeam(),
			'tag_batch_id' => $batch_id,
			'added_by' => Auth::id(),
		));
		
		$this->tagged()->save($tagged);

		static::$taggingUtility->incrementCount($tagName, $tagSlug, 1);
		
		unset($this->relations['tagged']);
		event(new TagAdded($this));
	}

	public function untag($batch_id, $tagNames=null)
	{ 
		if(is_null($tagNames)) {
			$tagNames = $this->getTagNamesForBatch($batch_id);
		}
		
		$tagNames = static::$taggingUtility->makeTagArray($tagNames);
		
		foreach($tagNames as $tagName) {
			$this->removeTag($batch_id, $tagName);
		}
		
		if(static::shouldDeleteUnused()) {
			static::$taggingUtility->deleteUnusedTags();
		}
	}
	
	private function removeTag($batch_id, $tagName)
	{

		$this->checkBatchBelongsToCurrentTeamOrFail($batch_id);

		$tagName = trim($tagName);
		
		$normalizer = config('tagging.normalizer');
		$normalizer = $normalizer ?: [static::$taggingUtility, 'slug'];
		
		$tagSlug = call_user_func($normalizer, $tagName);
		
		if($count = $this->tagged()
			->where('tag_batch_id', '=', $batch_id)
			->where('tag_slug', '=', $tagSlug)
			->delete()) {
			static::$taggingUtility->decrementCount($tagName, $tagSlug, $count);
		}
		
		unset($this->relations['tagged']);
		event(new TagRemoved($this));
	}

	public function addGroup($group_name) {

		$className = $this->getModel()->getMorphClass();

		$a = new TagGroup;
		$a->name = $group_name;
		$a->slug = app(TaggingUtility::class)->slug($group_name);
		$a->tid = Team::currentTeam();
		$a->taggable_type = $className;
		
		$a->save();
		return $a;

	}

	public function addBatch($batch_name, $options) {

		$className = $this->getModel()->getMorphClass();

		$batch = TagBatch::where('name',$batch_name);
		$batch = $batch->where('tid',Team::currentTeam());
		$batch = $batch->where('taggable_type',$className);
		$batch = $batch->get();

		if (count($batch)) {

			return $batch;

		}

		$a = new TagBatch;
		$a->name = $batch_name;
		$a->slug = app(TaggingUtility::class)->slug($batch_name);
		$a->tid = Team::currentTeam();
		$a->taggable_type = $className;
		$a->added_by = Auth::id();

		$a->options = json_encode($options);
		
		$a->save();

		return $a;

	}

	private function checkBatchBelongsToCurrentTeamOrFail($batch_id) {

		if (!$this->checkBatchBelongsToCurrentTeam($batch_id)) {

			throw new \Exception('Batch '.$batch_id.' doesn\'t belong to team '.Team::currentTeam());

		}

	}

	private function checkBatchBelongsToCurrentTeam($batch_id) {

		return $this->checkBatchBelongsToTeam(Team::currentTeam(), $batch_id);

	}

	private function checkBatchBelongsToTeam($tid, $batch_id) {

		$batch = TagBatch::where('id',$batch_id);
		$batch = $batch->where('tid',$tid);
		$batch = $batch->count();

		return !!$batch;

	}

	private function getTagNamesForBatch($batch_id) {

		return Tagged::where('tag_batch_id',$batch_id)->get(['tag_name'])->map(function($item){
			return $item->tag_name;
		})->toArray();

	}

}