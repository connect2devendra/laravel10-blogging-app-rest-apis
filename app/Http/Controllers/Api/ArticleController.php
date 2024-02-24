<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController as BaseController;

class ArticleController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            //fetch all article list with auther details
            $articles = Article::with(['auther:id,name,email'])->get();

            if(count($articles) == 0){
               return $this->sendError('Articles list not found.', [], 404);
            }

            return $this->sendResponse($articles->toArray(), 'Article list with auther details.');

        } catch (\Throwable $th) {
            
            return $this->sendError($th->getMessage(), []);
        }   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //save article
        try {
            $inputs = $request->all();
            $validator = Validator::make($inputs, [
                "article_title" => "required|string|max:250",
                "article_slug" => "required|string|max:250",
                "user_id" => "required|integer",
                "status" => "required|integer"                
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), 422);
            }

            $article = new Article();
            $article->article_title = $inputs['article_title'];
            $article->article_slug = $inputs['article_slug'];
            $article->user_id = $inputs['user_id'];
            $article->status = $inputs['status'];
            $insertLastId = $article->save();

            if(!$insertLastId){
                return $this->sendError('Failed to save.', [], 400);
            }

            return $this->sendResponse($article->toArray(), "Article created successfully.", 201);            

        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), []);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        try {
            //show sing article details
            if(empty($article)){
                return $this->sendError('Articles details not found.', [], 404);
            }

            return $this->sendResponse($article->toArray(), 'Article list with auther details.');

        } catch (\Throwable $th) {

            return $this->sendError($th->getMessage(), []);
        }     
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
         //save article
         try {
            $inputs = $request->all();

            if(!$article){
                return $this->sendError('Articles details not found.', [], 404);
            }  
            
            if(isset($inputs['article_title']) && !empty($inputs['article_title'])){

                $article->article_title = $inputs['article_title'];
            }

            if(isset($inputs['article_slug']) && !empty($inputs['article_slug'])){

                $article->article_slug = $inputs['article_slug'];
            }

            if(isset($inputs['user_id']) && !empty($inputs['user_id'])){

                $article->user_id = $inputs['user_id'];
            }

            if(isset($inputs['status']) && !empty($inputs['status'])){

                $article->status = $inputs['status'];
            }

            $article->update();
            
            return $this->sendResponse($article->toArray(), "Article created successfully.", 200);            

        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), []);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //Delete article
        try {
            //show sing article details
            if(!$article){
                return $this->sendError('Articles details not found.', [], 404);
            }

            $article->delete();

            return $this->sendResponse($article->toArray(), 'Article detail deleted successfully.');

        } catch (\Throwable $th) {

            return $this->sendError($th->getMessage(), []);
        }    
    }
}
