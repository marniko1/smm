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
use Maatwebsite\Excel\Concerns\ToCollection;
// use Maatwebsite\Excel\Concerns\ToModel;

class PostsImport implements ToCollection
// class PostsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    // public function model(array $row)
    {
        unset($rows[0]);

        foreach ($rows as $row) 
        {
            $author_id = $row[3];
            $author_name = $row[2];
            
            $domain = Domain::firstOrCreate(['name' => $row[9]]);
            $type = Type::firstOrCreate(['name' => $row[1]]);
            $author = Author::updateOrCreate( ['author_id' => $author_id], ['name' => $author_name] ); // Retrieve author by author id, or create it with the author id and name attributes...
            $sentiment = Sentiment::firstOrCreate(['name' => mb_strtolower($row[8])]);
            $project = Project::firstOrCreate(['name' => $row[12]]);
            $gender = Gender::firstOrCreate(['name' => $row[11]]);

            
            $tags_names = explode('|', str_replace(' ', '', $row[10]));
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

            $post = Post::updateOrCreate(
                ['so_id' => $row[0]], //find to update by 'so_id'
                ['content' => $row[4], //if can't find use 'so_id' along with this other values to create new
                'link' => $row[7],
                'sm_created_at' => $row[5],
                'so_added_to_system' => $row[6],
                'domain_id' => $domain->id,
                'type_id' => $type->id,
                'author_id' => $author->id,
                'sentiment_id' => $sentiment->id,
                'project_id' => $project->id,
                'gender_id' => $gender->id,]
            );

            //connect new post with tags or sync tags if post is updated


            $post->tags()->sync($tags);
        }
    }
}
