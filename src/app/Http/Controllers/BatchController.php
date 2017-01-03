<?php namespace z5internet\ReactTag\App\Http\Controllers;

use z5internet\ReactUserFramework\App\Http\Controllers\Controller;

use z5internet\ReactTag\Model\TagBatch;

use z5internet\ReactTag\Model\Tagged;

use Team;

use Auth;

use Nuwave\Lighthouse\Support\Traits\GlobalIdTrait;

class BatchController extends Controller {

    use GlobalIdTrait;

    public function __construct() {

    }

    public function getBatchs($args) {

        $batchs = TagBatch::where('tid', Team::currentTeam());

        $type = '';

        if (array_get($args, 'type')) {
    
            $type = $this->getTaggableTypeFromSlug($args['type']);

            $batchs = $batchs->where('taggable_type',$type);

        }

        $batchs = $batchs->get();

        $out = [];

        foreach($batchs as $key => $tb) {

            $batchs[$key]->taggable_type = $this->getSlugFromTaggableType($tb->taggable_type);
            $batchs[$key]->options = json_decode($tb->options);

        }

        if (array_get($args, 'type')) {

            $batchIndex = [];

            foreach($batchs as $key => $tb) {

                $batchIndex[$tb->id] = $key;

            }

            $db = Tagged::where('tid', Team::currentTeam());
            $db = $db->where('taggable_type',$type);

            $db = $this->getDBById($db, $args['id']);

            $temp = []; 

            foreach ($db as $tdb) {

                $bid = $tdb->tag_batch_id;

                $bidIndex = $batchIndex[$bid];

                $temp = array_add($temp,$bidIndex,[]);

                array_push($temp[$bidIndex], [

                    'name' => $tdb->tag_name,
                    'slug' => $tdb->tag_slug,

                ]);

            }

            foreach ($temp as $k => $v) {

                $batchs[$k]->tags = $v;

            }

        }

        return $batchs;

    }

    public function getBatchNames() {

        return $this->getBatchConfig();

    }

    public function addBatch($args) {

        $uid = Auth::id();

        $batch = new TagBatch;

        $selections = explode(',', $args['selections']);

        foreach ($selections as $k => $v) {

            $selections[$k] = [
                'name' => trim($v),
                'slug' => str_slug(trim($v)),
            ];

        }

        $batchOptions = [
            'quantity' => $args['multi']?0:1,
            'selections' => $selections,
        ];

        $batch->tid = Team::currentTeam();
        $batch->added_by = $uid;
        $batch->taggable_type = $this->getTaggableTypeFromSlug($args['taggable_type']);
        $batch->slug = str_slug($args['name']);
        $batch->name = $args['name'];
        $batch->options = json_encode($batchOptions);
        
        $batch->save();

        $batch->taggable_type = $args['taggable_type'];
        $batch->options = $batchOptions;

        return $batch;

    }

    public function getSlugFromTaggableType($tt) {

        $conf = $this->getBatchConfig();

        foreach($conf as $v) {

            if ($v['model'] == $tt) {

                return $v['slug'];

            }

        }

    }

    public function getTaggableTypeFromSlug($slug) {

        $conf = $this->getBatchConfig();

        foreach($conf as $v) {

            if ($v['slug'] == $slug) {

                return $v['model'];

            }

        }
        
    }

    private function getBatchConfig() {

        return config('DM.react-tag.tag_batches');

    }

    private function getDBById($db, $id) {

        if (is_string($id)) {

            return $this->getDBByStringId($db, $id);

        }

        return $this->getDBByNumericId($db, $id);

    }

    private function getDBByNumericId($db, $id) {

        $db = $db->where('taggable_id',$id);
        $db = $db->get();

        return $db;

    }

    private function getDBByStringId($db, $id) {

        $stringId = $this->decodeGlobalId($id)[1];

        $db1 = $db->where('taggable_id', $stringId);
        $db1 = $db1->get();

        if (!$db1) {

            $db1 = $this->getDBByNumericId($db, $id);

        }

        return $db1;

    }

}

