<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Article;
use App\Http\Requests;
use App\Http\Requests\ArticleRequest;
use App\Http\Controllers\Controller;
class ArticlesController extends Controller
{

    //show all articles
    public function index(){
        //without using function
        //$articles=Article::latest('published_at')->where('published_at','<=',Carbon::now())->get();
        $articles=Article::latest('published_at')->published()->get();
        return view('articles.index',compact('articles'));
    }

    //view of create article page
    public function create(){
    	return view('articles.create');
    }

    /*
    validation without using article request
    public function store(Request $request)
    {
        $this->validate($request, [
        'title' => 'required|unique:posts|max:255',
        'body' => 'required',
    ]);
    }
    */


    /*
    Post function of create article view to store new article
    ArticleRequest is used for validating the request through rules defind in that file
    */
    public function store(ArticleRequest $request)
    {
        //after validation not using facade
        Article::create($request->all());
        
       // before validation i.e. CreateArticleRequest 
       //  Article::create(Request::all());
        /*
        if we dont want to use redirect
        $articles=Article::latest('published_at')->published()->get();
        return view('articles.index',compact('articles'));
        */
        return redirect('articles');
    }

    //to edit the article
    public function edit($id)
    {
        $article=Article::findOrFail($id);
        return view('articles.edit',compact('article'));
    }
    public function update($id,ArticleRequest $request)
    {
        $article=Article::findOrFail($id);
        $article->update($request->all());
        return redirect('articles');
    }
    
    //to show a single article of particular id
    public function show($id){        
        $articles=Article::findOrFail($id);
        // dd($articles->published_at->diffForHumans());
        return view('articles.show',compact('articles'));
    }
}
?>