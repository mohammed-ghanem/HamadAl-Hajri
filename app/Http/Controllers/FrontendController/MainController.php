<?php

namespace App\Http\Controllers\FrontendController;

use App\Models\Book;
use App\Models\Audio;
use App\Models\Video;
use App\Models\Fatwas;
use App\Models\Lesson;
use App\Models\Speech;
use App\Models\Article;
use App\Models\Lecture;
use App\Models\Visitor;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\ReligiousBenefits;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;


class MainController extends Controller
{
    
     //category-lessons
     public function category_lesson($slug)
     {
        $visitors = Visitor::orderBy('id','desc')->first();
        $visitors->increment('visitor_count');
        
         $category = Category::whereSlug($slug)->orWhere('id', $slug)->whereStatus(1)->first()->id;
 
         if ($category) {
             $lessons = Lesson::with('category')
                 ->whereCategoryId($category)
                 ->whereStatus(1)
                 ->orderBy('id', 'desc')
                 ->paginate(10);

               
 
             return view('frontend.lessons.lessons', compact('lessons','visitors'));
         }
 
         return redirect()->route('frontend.index');
     }
 
     
     //lessons (navbar)
     public function lesson()
     {
        $visitors = Visitor::orderBy('id','desc')->first();
        $visitors->increment('visitor_count');
        
         $lessons = Lesson::with('category')
          ->whereHas('category', function ($query) {
            $query->whereStatus(1);
     })
     ->whereStatus(1)->orderBy('id','desc')->get();
     
     return view('frontend.lessons.lessons', compact('lessons','visitors'), ['title' => trans('frontend/pages/all.lesson_title')]);
         
     }
 
     
         //lesson content
     public function lesson_show($slug, Request $request)
     {

        $visitors = Visitor::orderBy('id','desc')->first();
        $visitors->increment('visitor_count');

        
         $lesson = Lesson::with(['category','audios','videos'])
        ->whereHas('category', function ($query) {
         $query->whereStatus(1);
         
     });
     
     $lesson= $lesson->whereSlug($slug)->whereStatus(1)->orderBy('id','desc')->first();
     $lesson->increment('view_count') ;
   
 
     if($request->ajax())
     {
        $lesson->increment('download_count') ;
        $lesson->save(); 
     }
      
     $lesson->save(); 
    
 
     if($lesson)
     {
 
         return view('frontend.lessons.lesson-show' , compact('lesson','visitors'), ['title' => $lesson->slug ]);
         
     }else{
         return redirect()->route('frontend.index');
     }
 
    
         
     }
 
    
 
     // public function download($file)
     // {
     //     return response()->download('/files/lessons/'.$file);
     // }
 

      //category-lessons
      public function category_benefit($slug)
      {
        $visitors = Visitor::orderBy('id','desc')->first();
        $visitors->increment('visitor_count');
        
          $category = Category::whereSlug($slug)->orWhere('id', $slug)->whereStatus(1)->first()->id;
  
          if ($category) {
              $benefits = ReligiousBenefits::with('category')
                  ->whereCategoryId($category)
                  ->whereStatus(1)
                  ->orderBy('id', 'desc')
                  ->paginate(10);
  
              return view('frontend.religious-benefits.benefits', compact('benefits','visitors'));
          }
  
          return redirect()->route('frontend.index');
      }

    //benefits (navbar)
    public function benefit()
    {
        $visitors = Visitor::orderBy('id','desc')->first();
        $visitors->increment('visitor_count');
        
        $benefits = ReligiousBenefits::with('category')
         ->whereHas('category', function ($query) {
           $query->whereStatus(1);
    })
    ->whereStatus(1)->orderBy('id','desc')->paginate(10);


    return view('frontend.religious-benefits.benefits', compact('benefits','visitors'), ['title' => trans('frontend/pages/all.benefit_title')]);
        
    }

    
        //benefits content
    public function benefit_show($slug)
    {

        $visitors = Visitor::orderBy('id','desc')->first();
        $visitors->increment('visitor_count');
        
        $benefit = ReligiousBenefits::with('category')
    ->whereHas('category', function ($query) {
        $query->whereStatus(1);
    });
    $benefit= $benefit->whereSlug($slug)->whereStatus(1)->orderBy('id','desc')->first();
    $benefit->increment('view_count') ;
    
    $benefit->save(); 
    
  
    
    if($benefit)
    {
        return view('frontend.religious-benefits.content' , compact('benefit','visitors'), ['title' => $benefit->slug ]);
        
    }else{
        return redirect()->route('frontend.index');
    }

   
        
    }

     //category-lectures
     public function category_lecture($slug)
     {
        $visitors = Visitor::orderBy('id','desc')->first();
        $visitors->increment('visitor_count');
        
         $category = Category::whereSlug($slug)->orWhere('id', $slug)->whereStatus(1)->first()->id;
 
         if ($category) {
             $lectures = Lecture::with('category')
                 ->whereCategoryId($category)
                 ->whereStatus(1)
                 ->orderBy('id', 'desc')
                 ->paginate(10);
 
             return view('frontend.lectures.lectures', compact('lectures','visitors'));
         }
 
         return redirect()->route('frontend.index');
     }

   //lectures (navbar)
   public function lecture()
   {
    $visitors = Visitor::orderBy('id','desc')->first();
    $visitors->increment('visitor_count');
    
       $lectures = Lecture::with('category')
        ->whereHas('category', function ($query) {
          $query->whereStatus(1);
   })
   ->whereStatus(1)->orderBy('id','desc')->paginate(10);

   return view('frontend.lectures.lectures', compact('lectures','visitors'), ['title' => trans('frontend/pages/all.lec_title')]);
       
   }

   
       //lectures content
   public function lecture_show($slug , Request $request)
   {

    $visitors = Visitor::orderBy('id','desc')->first();
    $visitors->increment('visitor_count');
    
       $lecture = Lecture::with(['category','audios','videos'])
   ->whereHas('category', function ($query) {
       $query->whereStatus(1);
   });
   $lecture= $lecture->whereSlug($slug)->whereStatus(1)->orderBy('id','desc')->first();
   $lecture->increment('view_count') ;
   if($request->ajax())
   {
      $lecture->increment('download_count') ;
      $lecture->save(); 
   }
    
    $lecture->save(); 

   
   if($lecture)
   {
       return view('frontend.lectures.lecture-content' , compact('lecture','visitors'), ['title' => $lecture->slug ]);
       
   }else{
       return redirect()->route('frontend.index');
   }

  
       
   }


    //category-speeches
    public function category_speech($slug)
    {
        $visitors = Visitor::orderBy('id','desc')->first();
        $visitors->increment('visitor_count');
        
        $category = Category::whereSlug($slug)->orWhere('id', $slug)->whereStatus(1)->first()->id;

        if ($category) {
            $speeches = Speech::with('category')
                ->whereCategoryId($category)
                ->whereStatus(1)
                ->orderBy('id', 'desc')
                ->paginate(10);

            return view('frontend.speeches.speeches', compact('speeches','visitors'));
        }

        return redirect()->route('frontend.index');
    }

  //speeches (navbar)
  public function speech()
  {
    $visitors = Visitor::orderBy('id','desc')->first();
    $visitors->increment('visitor_count');
    
      $speeches = Speech::with('category')
       ->whereHas('category', function ($query) {
         $query->whereStatus(1);
  })
  ->whereStatus(1)->orderBy('id','desc')->paginate(10);


  return view('frontend.speeches.speeches', compact('speeches','visitors'), ['title' => trans('frontend/pages/all.speech_title')]);
      
  }

  
      //speeches content
  public function speech_show($slug , Request $request)
  {

    $visitors = Visitor::orderBy('id','desc')->first();
    $visitors->increment('visitor_count');
    
      $speech = Speech::with(['category','audios','videos'])
  ->whereHas('category', function ($query) {
      $query->whereStatus(1);
  });
  $speech= $speech->whereSlug($slug)->whereStatus(1)->orderBy('id','desc')->first();
  $speech->increment('view_count') ;
  if($request->ajax())
  {
     $speech->increment('download_count') ;
     $speech->save(); 
  }
   
   $speech->save(); 

  if($speech)
  {
      return view('frontend.speeches.speech-content' , compact('speech','visitors'), ['title' => $speech->slug ]);
      
  }else{
      return redirect()->route('frontend.index');
  }

 
      
  }



  //category-articles
  public function category_article($slug)
  {
    $visitors = Visitor::orderBy('id','desc')->first();
    $visitors->increment('visitor_count');
    
      $category = Category::whereSlug($slug)->orWhere('id', $slug)->whereStatus(1)->first()->id;

      if ($category) {
          $articles = Article::with('category')
              ->whereCategoryId($category)
              ->whereStatus(1)
              ->orderBy('id', 'desc')
              ->paginate(10);

    
          return view('frontend.articles.articles', compact('articles','visitors'));
      }

      return redirect()->route('frontend.index');
  }

//articles (navbar)
public function article()
{
    $visitors = Visitor::orderBy('id','desc')->first();
    $visitors->increment('visitor_count');
    
    $articles = Article::with('category')
     ->whereHas('category', function ($query) {
       $query->whereStatus(1);
})
->whereStatus(1)->orderBy('id','desc')->paginate(10);


return view('frontend.articles.articles', compact('articles','visitors'), ['title' => trans('frontend/pages/all.article_title')]);
    
}


    //articles content
public function article_show($slug, Request $request)
{
    $visitors = Visitor::orderBy('id','desc')->first();
    $visitors->increment('visitor_count');
    
    $article = Article::with('category')
->whereHas('category', function ($query) {
    $query->whereStatus(1);
});
$article= $article->whereSlug($slug)->whereStatus(1)->orderBy('id','desc')->first();
$article->increment('view_count') ;
if($request->ajax())
{
   $article->increment('download_count') ;
   $article->save(); 
}
 
 $article->save(); 

if($article)
{
    return view('frontend.articles.article-content' , compact('article','visitors'), ['title' => $article->slug ]);
    
}else{
    return redirect()->route('frontend.index');
}


    
}

     //category-articles
  public function category_book($slug)
  {
    $visitors = Visitor::orderBy('id','desc')->first();
    $visitors->increment('visitor_count');
    
      $category = Category::whereSlug($slug)->orWhere('id', $slug)->whereStatus(1)->first()->id;

      if ($category) {
          $books = Book::with('category')
              ->whereCategoryId($category)
              ->whereStatus(1)
              ->orderBy('id', 'desc')
              ->paginate(10);

          return view('frontend.books.books', compact('books','visitors'));
      }

      return redirect()->route('frontend.index');
  }

//articles (navbar)
public function book()
{
    $visitors = Visitor::orderBy('id','desc')->first();
    $visitors->increment('visitor_count');
    
    $books = Book::with('category')
     ->whereHas('category', function ($query) {
       $query->whereStatus(1);
})
->whereStatus(1)->orderBy('id','desc')->paginate(10);

return view('frontend.books.books', compact('books','visitors'), ['title' => trans('frontend/pages/all.book_title')]);
    
}


    //articles content
public function book_show($slug , Request $request)
{
    $visitors = Visitor::orderBy('id','desc')->first();
    $visitors->increment('visitor_count');
    
    $book = Book::with('category')
->whereHas('category', function ($query) {
    $query->whereStatus(1);
});
$book= $book->whereSlug($slug)->whereStatus(1)->orderBy('id','desc')->first();
$book->increment('view_count') ;
if($request->ajax())
{
   $book->increment('download_count') ;
   $book->save(); 
}
 
 $book->save(); 

if($book)
{
    return view('frontend.books.book-content' , compact('book','visitors'), ['title' => $book->slug ]);
    
}else{
    return redirect()->route('frontend.index');
}


    
}


 //videos
    public  function video()
    {
        $visitors = Visitor::orderBy('id','desc')->first();
        $visitors->increment('visitor_count');
        //get videos
       $videos = Video::whereHasMorph(
        'videoable' ,
        ['App\Models\Lesson', 'App\Models\Lecture' , 'App\Models\Speech'],
       function(Builder $query){
           $query->where('youtubeLink', 'like' ,'https%');
           
       })->orderBy('id','desc')->paginate(6);
     
       return view('frontend.videos.all-videos', compact('videos','visitors') ,['title' => trans('frontend/pages/all.video_title')]);
    } 


     //videos
     public  function audio()
     {
        $visitors = Visitor::orderBy('id','desc')->first();
        $visitors->increment('visitor_count');
        
         //get audios
        $audios = Audio::whereHasMorph(
         'audioable' ,
         ['App\Models\Lesson', 'App\Models\Lecture' , 'App\Models\Speech'],
        function(Builder $query){
            $query->where('embedLink', '!=' ,'')
            ->orWhere('audioFile', '!=' , '');
            
        })->orderBy('id','desc')->get();
 
        return view('frontend.audios.all-audios', compact('audios','visitors'),['title' => trans('frontend/pages/all.audio_title')]);
     } 

        //audio content
    public function audio_content($slug, Request $request)
    {

        $visitors = Visitor::orderBy('id','desc')->first();
        $visitors->increment('visitor_count');

         //get audios
         $audio = Audio::whereHasMorph(
            'audioable' ,
            ['App\Models\Lesson', 'App\Models\Lecture' , 'App\Models\Speech'],
           function(Builder $query){
               $query->where('embedLink', '!=' ,'')
               ->orWhere('audioFile', '!=' , '');
               
           });

           $audio= $audio->whereSlug($slug)->orderBy('id','desc')->first();

           $audio->increment('view_count') ;
        if($request->ajax())
        {
        $audio->increment('download_count') ;
        $audio->save(); 
        }
        
        $audio->save(); 
        if($audio)
        {
            return view('frontend.audios.audio-content' ,compact('audio','visitors'), ['title' => $audio->slug ]);

        }else{
            return redirect()->route('frontend.index');
        }
        
        
    
   
        
    }

      //Question from fatwas
      public function question()
      {
        $visitors = Visitor::orderBy('id','desc')->first();
        $visitors->increment('visitor_count');
        
          $fatwas = Fatwas::with('question')
          ->whereHas('question', function ($query) {
            $query->where('answer' , '!=' ,'')
            ->orWhere('mp3File' , '!=' ,'');
     })
       ->whereStatus(1)->orderBy('id','desc')->paginate(10); 
       
       return view('frontend.answers.qustions', compact('fatwas','visitors') ,['title' => trans('frontend/pages/all.ques_title')]);
     }
  
     public function answer($id)
      {
  
        $visitors = Visitor::orderBy('id','desc')->first();
        $visitors->increment('visitor_count');
          //$fatwa = Fatwas::findOrFail($id);
          
           $answer = Question::with('fatwas')->where('fatwas_id' , '=' , $id )
              ->orderBy('id','desc')->first();
  
           if($answer)
           {
               return view('frontend.answers.answers-content', compact('answer','visitors'),['title' => $answer->fatwas->message]);
           }
         
            
     }

}