<?php

namespace App\Http\Controllers;

use App\OnlineService;
use App\Post;
use App\PostCategory;
use App\PostTag;
use App\ServiceCategory;
use App\Testimonial;
use App\User;
use App\Video;
use App\WorkLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Service;
use App\Content;
use App\Services\CalculatorService;
use App\Services\SeoService;
use App\Mail\CustomerQuery;


class HomeController extends Controller
{
    private $seoService;
    private $userController;

    function __construct(SeoService $seoService, UserController $userController)
    {
        $this->seoService = $seoService;
        $this->userController = $userController;
    }

    public function index()
    {

//       if(env('ENABLE_APP_SETUP_CONFIG') != TRUE)
//       {
//          return redirect()->route('installer_page');
//       }
        $this->seoService->load('home');
        $services = Service::all();
        $service_categories=ServiceCategory::all();
        $writers= $this->userController->getWriters();
        $reviews=Testimonial::where('status','PUBLISH')->get();
        $posts = Post::where('status','=','PUBLISH')->where('feature',1)->orderBy('id','desc')->limit(6)->get();
        $videos = Video::orderBy('feature','desc')->where('type',1)->get();
        $work_levels=WorkLevel::whereNull('inactive')->get();
        $online_services = OnlineService::get();

        return view('website.index', compact('services','service_categories','writers','reviews','posts','videos','work_levels','online_services'));
    }

    function pricing(CalculatorService $calculator)
    {
        $this->seoService->load('pricing');

        return view('website.pricing')->with(['data' => $calculator->priceList()]);
    }

    function content(Request $request)
    {
        $this->seoService->load($request->route()->getName());

        $slug = $request->segment(count($request->segments()));

        $content = Content::where('slug', $slug)->get();

        if ($content->count() > 0) {
            $content = $content->first();
        } else {
            abort(404);
        }

        return view('website.content')->with('content', $content);
    }

    function contact()
    {
        $this->seoService->load('contact');
        $work_levels=WorkLevel::whereNull('inactive')->get();

        return view('website.contact-us',compact('work_levels'));
    }

    function handle_email_query(Request $request)
    {
        $to = "info@academian.co.uk";/*Your Email*/
        $subject = 'Contact';

        $date = date("l, F jS, Y");
        $time = date("h:i A");

        $name = $request['name'];
        $email = $request['email'];
        $phone = $request['message'];
        $program = $request['program'];

        $msg = "
		Message sent from website form on date  $date, hour: $time.\n
		Name: $name\n
		Phone Number: $phone\n
		Email: $email\n
		Program selection: $program
		";
        if ($email == "") {
            echo "<div class='alert alert-danger'>
			  <a class='close' data-dismiss='alert'>×</a>
			  <strong>Warning!</strong> Please fill all the fields.
		  </div>";
        } else {
            mail($to,$subject,$msg,"From:".$email);
            return back()->with('success', 'Message Sent');
        }
    }

    public function blog()
    {
        $categories = PostCategory::all();
        $lpost = Post::where('status', '=', 'PUBLISH')->orderBy('id', 'desc')->limit(5)->get();
        $posts = Post::where('status', '=', 'PUBLISH')->orderBy('id', 'desc')->paginate(3);
        $recent = Post::orderBy('id', 'desc')->limit(5)->get();
        $tags = PostTag::all();

        return view('website.blog', compact('categories', 'lpost', 'posts', 'recent', 'tags'));
    }

    public function blogshow($slug)
    {
        $categories = PostCategory::all();
        $lpost = Post::where('status', '=', 'PUBLISH')->orderBy('id', 'desc')->limit(5)->get();
        $post = Post::where('slug', $slug)->firstOrFail();
        $old = $post->views;
        $new = $old + 1;
        $post->views = $new;
        $post->update();
        $recent = Post::orderBy('id', 'desc')->limit(5)->get();
        $tags = PostTag::get();
        return view ('website.blogshow',compact('categories','lpost','post','recent','tags'));

    }

    public function category(PostCategory $category)
    {
        $categories = PostCategory::all();
        $lpost = Post::where('status', '=', 'PUBLISH')->orderBy('id', 'desc')->limit(5)->get();
        $posts = $category->posts()->latest()->paginate(6);
        $recent = Post::orderBy('id', 'desc')->limit(5)->get();
        $tags = PostTag::all();
        return view('website.blog', compact('categories', 'lpost', 'posts', 'recent', 'tags'));
    }

    public function tag(PostTag $tag)
    {
        $categories = PostCategory::all();
        $lpost = Post::where('status', '=', 'PUBLISH')->orderBy('id', 'desc')->limit(5)->get();
        $posts = $tag->posts()->latest()->paginate(12);
        $recent = Post::orderBy('id', 'desc')->limit(5)->get();
        $tags = PostTag::all();
        return view('website.blog', compact('categories', 'lpost', 'posts', 'recent', 'tags'));
    }

    public function search()
    {
        $query = request("query");
        $categories = PostCategory::all();
        $lpost = Post::where('status', '=', 'PUBLISH')->orderBy('id', 'desc')->limit(5)->get();
        $posts = Post::where("title", "like", "%$query%")->latest()->paginate(9);
        $recent = Post::orderBy('id', 'desc')->limit(5)->get();
        $tags = PostTag::all();

        return view('website.blog', compact('categories', 'lpost', 'posts', 'query', 'recent', 'tags'));
    }

    public function sendmail(Request $request)
    {
        $to = "info@academian.co.uk";/*Your Email*/
        $subject = 'Contact';

        $date = date("l, F jS, Y");
        $time = date("h:i A");

        $name = $request['name'];
        $email = $request['email'];
        $phone = $request['message'];
        $program = $request['program'];

        $msg = "
		Message sent from website form on date  $date, hour: $time.\n
		Name: $name\n
		Phone Number: $phone\n
		Email: $email\n
		Program selection: $program
		";
        if ($email == "") {
            echo "<div class='alert alert-danger'>
			  <a class='close' data-dismiss='alert'>×</a>
			  <strong>Warning!</strong> Please fill all the fields.
		  </div>";
        } else {
            mail($to,$subject,$msg,"From:".$email);
            return back()->with('success', 'Message Sent');
        }
    }

    public function reviews()
    {
        $reviews = Testimonial::where('status','=','PUBLISH')->orderBy('id','desc')->get();

        return view ('website.reviews',compact('reviews'));
    }

    public function about()
    {
        $reviews = Testimonial::where('status','=','PUBLISH')->orderBy('id','desc')->get();

        return view ('website.about-us',compact('reviews'));
    }

    public function gallery()
    {
        $gallery=Video::all();
        return view ('website.gallery',compact('gallery'));
    }

    public function gallerywatch($id)
    {
        $item=Video::find($id);
        return view('website.gallery-watch',compact('item'));
    }
}
