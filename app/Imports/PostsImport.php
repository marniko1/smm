<?php

namespace App\Imports;

use App\Author;
use App\Category;
use App\Domain;
use App\Gender;
use App\Post;
use App\Project;
use App\Sentiment;
use App\Tag;
use App\Type;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
// use Maatwebsite\Excel\Concerns\ToModel;

class PostsImport implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    public $failures = array();
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        // $failures = array();
        foreach ($rows as $key => $row) 
        {
            try {
                $author_id = $row['author_id'];
                $author_name = $row['author'];
                    
                $domain = Domain::firstOrCreate(['name' => $row['domain_group']]);
                $type = Type::firstOrCreate(['name' => $row['specific_type']]);
                $author = Author::updateOrCreate( ['author_id' => $author_id], ['name' => $author_name] ); // Retrieve author by author id, or create it with the author id and name attributes...
                $sentiment = Sentiment::firstOrCreate(['name' => mb_strtolower($row['sentiment'])]);
                $project = Project::firstOrCreate(['name' => $row['project_name']]);
                $gender = Gender::firstOrCreate(['name' => $row['gender']]);

                
                if (!empty($row['tag'])) {
                    $tags_names = explode('|', str_replace(' ', '', $row['tag']));
                    $tags = array();

                    
                    foreach ($tags_names as $name) {

                        $prefix = explode('_', $name);
                        $prefix = $prefix[0] . '_';

                        // if ($prefix != 'SENT_') {

                            $category_id = Category::where('prefix', $prefix)->first()->id;

                            $tag = Tag::firstOrCreate(['name' => $name], ['category_id' => $category_id]);

                            array_push($tags, $tag->id);
                        // } 
                        // else {
                            // part that converts sentiment tag in SentiOne sentiment
                            switch ($name) {
                                case 'SENT_poz':
                                    $sentiment = Sentiment::where('name', 'positive')->first();
                                    break;

                                case 'SENT_neg':
                                    $sentiment = Sentiment::where('name', 'negative')->first();
                                    break;

                                case 'SENT_neut':
                                    $sentiment = Sentiment::where('name', 'neutral')->first();
                                    break;
                                
                                default:
                                    # code...
                                    break;
                            }
                        // }

                    }
                }

                $post = Post::updateOrCreate(
                    ['so_id' => $row['id']], //find to update by 'so_id'
                    ['content' => $row['content_of_posts'], //if can't find use 'so_id' along with this other values to create new
                    'link' => $row['link_to_the_source'],
                    'sm_created_at' => $row['created'],
                    'so_added_to_system' => $row['added_to_system'],
                    'domain_id' => $domain->id,
                    'type_id' => $type->id,
                    'author_id' => $author->id,
                    'sentiment_id' => $sentiment->id,
                    'project_id' => $project->id,
                    'gender_id' => $gender->id,]
                );

                if (!empty($row['tag'])) {
                    //connect new post with tags or sync tags if post is updated
                    $post->tags()->sync($tags);
                }
            } catch (\Illuminate\Database\QueryException $e) {

                // throw $e;
                // dd($e);
                // $e::report($exception);
                // $this->throw();
                // throw new \Exception($e);
                $this->failures[] = "On row " . $row . " " . $e->errorInfo[2];
                // $this->failures[] = "On row " . ($key + 2) . " " . $e->errorInfo[2];
                // dd($failures);
                // return response()->view('admin.import', [], 500); 
                // return back()->withFailures($failures);
                // return Redirect::to('/admin/import')->withFailures( $this->failures );
                
            }
        }
        // $this->failures = $failures;
        // dd($this->failures);
    }

    // this function returns all validation errors after import:
    public function getErrors()
    {
        return $this->errors;
    }

    public function rules(): array
    {
        // return [
        //     '0' => 'required|max:255',
        //     '1' => 'required|max:255',
        //     '2' => 'required|unique:users,email|email|max:255',
        // ];
    }

    public function validationMessages()
    {
        // return [
        //     '0.required' => trans('user.first_name_is_required'),
        //     '1.required' => trans('user.last_name_is_required'),
        //     '2.required' => trans('user.email_is_required'),
        //     '2.unique' => trans('user.email_must_be_unique'),
        //     '2.email' => trans('user.email_must_be_valid'),
        // ];
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
