<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;	
use Session;
use Redirect;
use App\User;
use View;
use Validator;
use Illuminate\Support\Facades\Input;
use File;
use App\Template;
use App\UserCard;
use Response;
use Config;
use App\Category;
use Excel;
use App\UserTemplate;
use App\UserTemplateFeild;
use App\UserTemplateImage;
use App\TemplateImage;
use App\TemplateFeild;
use App\Material;
use App\Order;
use App\UserObject;
use App\Objects;

/**
 * Controlls user side templates
 *
 * @package   TemplatesController
 * @author     webdesignandsolution15@gmail.com
 * @link       http://www.webdesignandsolution.com/
 */
class TemplatesController extends Controller
{
    //
    public function __construct()
    {
    }

    /**
     * Save template images
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array image
     * @return   void
     */
    public function save_image(Request $request)
    {
        $username=Auth::user()->username;

        $img = $request->image; // Your data 'data:image/png;base64,AAAFBfj42Pj4';
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $name = str_random(40);
        $path = public_path() .'/images/'.$username;   
        
        if(!File::exists($path))
        { 
            File::makeDirectory($path);
        } 
        file_put_contents('images/'. $username .'/'.$name.'.png', $data);

        $user_id = Auth::user()->id;

        UserCard::create(array(
            'image' => $name.'.png',
            'user_id' => $user_id
            ));

    }
    

    /**
     * Display cards with data
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    string category_name
     * @return   view
     */
    public function index($category_name = null)
    {
        $template = Template::where('is_delete',0)->orderBy('created_at','desc')->take(Config::get('settings.number_of_items')); 
        $data['category_id'] = null;

        if($category_name)
        {
            $category = Category::where('is_delete',0)->where('name',$category_name)->first();
            $template->where('category_id',$category->id)->orderBy('created_at','asec'); 
            
            $data['category_id'] = $category->id;
        }

        $data['materials'] = Material::where('is_delete',0)->get();

        $data['templates'] = $template->get();
        $data['categories'] = Category::where('is_delete',0)->get();
        
        return view('gallery',$data);
    }


    /**
     * Do ajax pagination on scroll the page in cards 
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array page_no,orientations,category
     * @return   json templates
     */
    public function ajax_templates(Request $request)
    {
        $templates = Template::orderBy('created_at','desc')
                                ->skip($request->page_no*Config::get('settings.number_of_items'))
                                ->take(Config::get('settings.number_of_items'));

        if($request->orientations)
        {
            $templates->whereIn('type', $request->orientations);
        }

        if($request->category)
        {
            $templates->whereIn('category_id', $request->category);
        }
        
        $data = $templates->get();
        return response()->json($data);

    }


    /**
     * Fetch template's data
     * Fetch template's lables
     * Fetch template's objects
     * If template is both side get the data,lables and objects of backside
     * According to template is both side or not it will show the view
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    String url
     * @return   view
     */
    public function get_template($url)
    {
                $data['template'] = Template::where('is_delete', 0)->where('url', $url)->first();
                $data['feilds'] = TemplateFeild::where('template_id',$data['template']->id)->where('is_back',0)->get();
                
                $ids = array();
                foreach($data['feilds'] as $feild)
                {
                  array_push($ids, $feild->id);
                }

                $data['images'] = TemplateImage::whereIn('template_feild_id',$ids)->get();

                $imageids = array();
                foreach ($data['images'] as $key => $value) {
                    array_push($imageids, $value->template_feild_id);
                }

                $data['feilds'] = TemplateFeild::where('template_id', $data['template']->id)->where('is_back',0)->whereNotIn('id', $imageids)->where('is_label',0)->get();
                $data['labels'] = TemplateFeild::where('template_id', $data['template']->id)->where('is_back',0)->whereNotIn('id', $imageids)->where('is_label',1)->get();
                $data['image_css'] = TemplateFeild::where('template_id', $data['template']->id)->where('is_back',0)->whereIn('id', $imageids)->get();
               
                $names = array();
                foreach($data['feilds'] as $feild)
                {
                  array_push($names, $feild->name);
                }

                $labels = array();
                foreach($data['labels'] as $label)
                {
                  array_push($labels, $label->name);
                }

                $template_images = array();
                foreach($data['image_css'] as $image)
                {
                  array_push($template_images, $image->id);
                }

                $data['names'] = $names;
                $data['template_images'] = $template_images;
                $data['template_labels'] = $labels;


                $data['back_feilds'] = TemplateFeild::where('template_id',$data['template']->id)->where('is_back',1)->get();
                
                $ids = array();
                foreach($data['back_feilds'] as $feild)
                {
                  array_push($ids, $feild->id);
                }

                $data['back_images'] = TemplateImage::whereIn('template_feild_id',$ids)->get();

                $imageids = array();
                foreach ($data['back_images'] as $key => $value) {
                    array_push($imageids, $value->template_feild_id);
                }

                $data['back_feilds'] = TemplateFeild::where('template_id', $data['template']->id)->where('is_back',1)->whereNotIn('id', $imageids)->where('is_label',0)->get();
                $data['back_labels'] = TemplateFeild::where('template_id', $data['template']->id)->where('is_back',1)->whereNotIn('id', $imageids)->where('is_label',1)->get();
                $data['back_image_css'] = TemplateFeild::where('template_id', $data['template']->id)->where('is_back',1)->whereIn('id', $imageids)->get();
               
                $back_names = array();
                foreach($data['back_feilds'] as $feild)
                {
                  array_push($back_names, $feild->name);
                }

                $back_labels = array();
                foreach($data['back_labels'] as $label)
                {
                  array_push($back_labels, $label->name);
                }

                $back_template_images = array();
                foreach($data['back_image_css'] as $image)
                {
                  array_push($back_template_images, $image->id);
                }

                $data['back_names'] = $back_names;
                $data['back_template_images'] = $back_template_images;
                $data['back_template_labels'] = $back_labels;
                $data['objects'] = Objects::where('is_back',0)->where('template_id',$data['template']->id)->get();
                $data['circles'] = Objects::where('type','circle')->where('is_back',0)->where('template_id',$data['template']->id)->pluck('name');
                $data['lines'] = Objects::where('type','line')->where('is_back',0)->where('template_id',$data['template']->id)->pluck('name');
                $data['squares'] = Objects::where('type','square')->where('is_back',0)->where('template_id',$data['template']->id)->pluck('name');
                $data['back_objects'] = Objects::where('is_back',1)->where('template_id',$data['template']->id)->get();
                $data['back_circles'] = Objects::where('type','circle')->where('is_back',1)->where('template_id',$data['template']->id)->pluck('name');
                $data['back_lines'] = Objects::where('type','line')->where('is_back',1)->where('template_id',$data['template']->id)->pluck('name');
                $data['back_squares'] = Objects::where('type','square')->where('is_back',1)->where('template_id',$data['template']->id)->pluck('name');
             
                if($data['template']->is_both_side == 1)
                {
                   return view('user.templates.create_double_side',$data);
                }
                else
                {
                    return view('user.templates.create', $data);
                }

        
    }


    /**
     * Do ajax pagination on scroll in cards gallery
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array product_id,category
     * @return   json template
     */
    public function filter_ajax(Request $request)
    {
        $filtered_templates = Template::orderBy('created_at','desc')
                                        ->take(Config::get('settings.number_of_items'));

        if($request->orientations)
        {
            $filtered_templates->whereIn('type', $request->orientations);
        }

        if($request->category)
        {
            $filtered_templates->whereIn('category_id', $request->category)->where('is_delete',0);
        }

        $data = $filtered_templates->where('is_delete',0)->get();
        return response()->json($data);

    }


    /**
     * Create unique url of template
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    int template_id, int user_id
     * @return   url
     */
    public function get_unique_url($template_id,$user_id)
    {
        $c = UserTemplate::where('template_id',$template_id)->where('user_id',$user_id)->count();
        $url = Template::where('id', $template_id)->pluck('url');
        
        if($c > 0)
        {
            $url = $url[0] ."-". $c;

        }
        else
        {
            $url = $url[0];
        }
        return $url;
    }


    /**
     * Save Template's backside
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array template_id,user_template_id,feilds,labels,images,back_circle_object,back_square_object,back_line_object,deleted_line_object,deleted_square_object,deleted_circle_object
     * @return   json String 
     */
    public function back_save_user_template(Request $request)
    { 
        $template =  Template::where('id',$request->template_id)->first();
        $user_fields=array(
                
          'background_image_back' => $template->background_image_back,
          'back_snap'=> $template->back_snap,
        );

        UserTemplate::where('id', $request->user_template_id)->update($user_fields);

        if($request->feilds)
        {
            foreach ($request->feilds as $feild) 
            { 
                $feild["template_id"] = $request->user_template_id; 
                $feild["is_back"] = 1;
                UserTemplateFeild::create($feild);    
            }
        }

        if($request->labels)
        {
            foreach ($request->labels as $label) 
            { 
                $label["template_id"] = $request->user_template_id; 
                $label["is_label"] = 1;
                $label["is_back"] = 1;
                UserTemplateFeild::create($label);    
            }
        }

       
        if($request->images)
        {
            foreach ($request->images as $image) {

               $id =  UserTemplateFeild::insertGetId(['name'=>$image['name'],'is_back' => 1,'template_id' => $request->user_template_id,'css' => $image['div_css'], 'font_css' => $image['css'], 'created_at' => date('Y-m-d H:s:i'), 'updated_at' => date('Y-m-d H:s:i')]);

                $image_data = TemplateImage::where('template_feild_id', $image['id'])->first();   
                UserTemplateImage::create(['src' => $image_data->src, 'template_feild_id' => $id]);
                 
           }
        }
        
        
        $circle_names = UserObject::where('is_back',1)->where('type', 'circle')->where('template_id', $request->user_template_id)->pluck('name');
        
         if($request->back_circle_object)
         {  
            foreach ($request->back_circle_object as $circle) 
            {
                $update = 0;
                $circle['template_id'] = $request->user_template_id;
                 foreach ($circle_names as $key => $value) {

                        if($value == $circle['name'])
                        { 
                            $id = $key;
                            $update = 1;
                        }
                }
                if($update == 1)
                {
                    $object = UserObject::where('name', $circle['name'])->update($circle);
                }
                else
                {   
                    $circle['is_back'] = 1;
                    UserObject::create($circle);
                }
               
            }
        }


        $square_names = UserObject::where('is_back',1)->where('type', 'square')->where('template_id', $request->user_template_id)->pluck('name');
         if($request->back_square_object)
         {  
            foreach ($request->back_square_object as $square) 
            {
                $update = 0;
                $square['template_id'] = $request->user_template_id;
                 foreach ($square_names as $key => $value) {

                        if($value == $square['name'])
                        { 
                            $id = $key;
                            $update = 1;
                        }
                }
                if($update == 1)
                {
                    $object = UserObject::where('name', $square['name'])->update($square);
                }
                else
                {   
                    $square['is_back'] = 1;
                    UserObject::create($square);
                }
            }
        }

        $line_names = UserObject::where('is_back',1)->where('type', 'line')->where('template_id', $request->user_template_id)->pluck('name');
         if($request->back_line_object)
         {  
            foreach ($request->back_line_object as $line) 
            {
                $update = 0;
                $line['template_id'] = $request->user_template_id;
                 foreach ($line_names as $key => $value) {

                        if($value == $line['name'])
                        { 
                            $id = $key;
                            $update = 1;
                        }
                }
                if($update == 1)
                {
                    $object = UserObject::where('name', $line['name'])->update($line);
                }
                else
                {   
                    $line['is_back'] = 1;
                    UserObject::create($line);
                }
               
            }
        }

        if($request->deleted_line_object!=null)
            {
                foreach ($request->deleted_line_object as $value) {
                    UserObject::where('name',$value)->where('is_back',1)->where('template_id',$request->user_template_id)->delete();
                }
            }
            if($request->deleted_circle_object!=null)
            {
                foreach ($request->deleted_circle_object as $value) {
                    UserObject::where('name',$value)->where('is_back',1)->where('template_id',$request->user_template_id)->delete();
                }
            }
            if($request->deleted_square_object!=null)
            {
                foreach ($request->deleted_square_object as $value) {
                    UserObject::where('name',$value)->where('is_back',1)->where('template_id',$request->user_template_id)->delete();
                }
            }
   
       return json_encode("Template is Saved..!");

    }


    /**
     * Save user's templates
     * Save all the data of user template
     * Save lables and objects of user's templates
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array template_id,snap,feilds,labels,images
     * @return   int user_template_id
     */
    public function save_user_template(Request $request)
    { 

           $template =  Template::where('id',$request->template_id)->first();
        if(Auth::user())
        {
            $user_id=Auth::user()->id;
            $url = TemplatesController::get_unique_url($request->template_id, $user_id);
            
            $user_fields=array(
                'name' => $template->name,
                'price' => $template->price,
                'template_id' => $template->id,
                'background_image' => $template->background_image,
                'url' => $url,
                'type' => $template->type,
                'user_id' => $user_id,
                'snap'=> $request->snap,
                'is_both_side' => $template->is_both_side,
                'created_at' => date('Y-m-d H:s:i'),
                'updated_at' => date('Y-m-d H:s:i')
        );
        }
        else
        {
            $session_id = Session::getId();
            $user_fields=array(
                'name' => $template->name,
                'price' => $template->price,
                'template_id' => $template->id,
                'background_image' => $template->background_image,
                'type' => $template->type,
                'session_id' => $session_id,
                'snap'=> $request->snap,
                'is_both_side' => $template->is_both_side,
                'created_at' => date('Y-m-d H:s:i'),
                'updated_at' => date('Y-m-d H:s:i')
            );
            $user_id = $session_id;
        }
         
        $user_template_id = userTemplate::insertGetId($user_fields); 
        if($request->feilds)
        {
            foreach ($request->feilds as $feild) 
            { 
                $feild["template_id"] = $user_template_id; 
                $feild["user_id"] = $user_id;
                UserTemplateFeild::create($feild);    
            }
        }

        if($request->labels)
        {
            foreach ($request->labels as $label) 
            { 
                $label["template_id"] = $user_template_id; 
                $label["user_id"] = $user_id;
                $label["is_label"] = 1;
                UserTemplateFeild::create($label);    
            }
        }

       
       if($request->images)
       {
            foreach ($request->images as $image) {

             $id =  UserTemplateFeild::insertGetId(['name'=>$image['name'],'user_id' => $user_id,'template_id' => $user_template_id,'css' => $image['div_css'], 'font_css' => $image['css'], 'created_at' => date('Y-m-d H:s:i'), 'updated_at' => date('Y-m-d H:s:i')]);

                $image_data = TemplateImage::where('template_feild_id', $image['id'])->first();   
                UserTemplateImage::create([ 'src' => $image_data->src, 'template_feild_id' => $id]);
                 
           }
        }

        $circle_names = UserObject::where('is_back',0)->where('type', 'circle')->where('template_id', $user_template_id)->pluck('name');
         if($request->circle_object)
         {  
            foreach ($request->circle_object as $circle) 
            {
                $update = 0;
                $circle['template_id'] = $user_template_id; 
                foreach ($circle_names as $key => $value) 
                {
                    if($value == $circle['name'])
                    {
                        $id = $key;
                        $update = 1;
                    }
                }
                if($update == 1)
                {
                    $object = UserObject::where('name', $circle['name'])->update($circle);
                }
                else
                {   
                    $circle['is_back'] = 0;
                    UserObject::create($circle);
                }
               
            }
        }


        $square_names = UserObject::where('is_back',0)->where('type', 'square')->where('template_id', $user_template_id)->pluck('name');
         if($request->square_object)
         {  
            foreach ($request->square_object as $square) 
            {
                $update = 0;
                $square['template_id'] = $user_template_id;
                 foreach ($square_names as $key => $value) {

                        if($value == $square['name'])
                        { 
                            $id = $key;
                            $update = 1;
                        }
                }
                if($update == 1)
                {
                    $object = UserObject::where('name', $square['name'])->update($square);
                }
                else
                {   
                    $square['is_back'] = 0;
                    UserObject::create($square);
                }
               
            }
        }


        $line_names = UserObject::where('is_back',0)->where('type', 'line')->where('template_id', $request->template_id)->pluck('name');
         if($request->line_object)
         {  
            foreach ($request->line_object as $line) 
            {
                $update = 0;
                $line['template_id'] = $user_template_id;
                 foreach ($line_names as $key => $value) {

                        if($value == $line['name'])
                        { 
                            $id = $key;
                            $update = 1;
                        }
                }
                if($update == 1)
                {
                    $object = UserObject::where('name', $line['name'])->update($line);
                }
                else
                {   
                    $line['is_back'] = 0;
                    UserObject::create($line);
                }
               
            }
        }

         if($request->deleted_line_object!=null)
            {
                foreach ($request->deleted_line_object as $value) {
                    UserObject::where('name',$value)->where('is_back',0)->where('template_id',$user_template_id)->delete();
                }
            }
            if($request->deleted_circle_object!=null)
            {
                foreach ($request->deleted_circle_object as $value) {
                    UserObject::where('name',$value)->where('is_back',0)->where('template_id',$user_template_id)->delete();
                }
            }
            if($request->deleted_square_object!=null)
            {
                foreach ($request->deleted_square_object as $value) {
                    UserObject::where('name',$value)->where('is_back',0)->where('template_id',$user_template_id)->delete();
                }
            }

            if($request->deleted_labels!=null)
            {
                foreach ($request->deleted_labels as $value) {
                    UserTemplateFeild::where('name',$value)->where('is_label',1)->where('template_id',$user_template_id)->delete();
                }
            }

       return json_encode($user_template_id);

    }


    /**
     * What function does
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return   view
     */
    public function show_user_gallery()
    {
        $user = Auth::user();
        $data['username'] = $user->username;
        
        $data['user_cards'] = UserTemplate::where('user_id',$user->id)->orderBy('id','desc')->take(Config::get('settings.number_of_items'))->get(); 
        if(count($data['user_cards'])==0)
        {
            $data['user_cards'] = false;
        }

        $data['materials'] = Material::where('is_delete',0)->get();
        
        return view('user.templates.list',$data);
    }


    /**
     * Show User template
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    String url
     * @return   view
     */
    public function show_user_template($url)
    {

        $data['template'] = UserTemplate::where('url',$url)->first(); 
        $data['feilds'] = UserTemplateFeild::where('template_id', $data['template']->id)->get();
        $data['images'] = UserTemplateImage::where('template_id', $data['template']->id)->get();
        $field_names = array();
        foreach($data['feilds'] as $names)
        {
            array_push($field_names, $names->name);
        }
        $template_images = array();
         foreach($data['images'] as $names)
        {
            array_push($template_images, $names->name);
        }
        $data['field_names']= json_encode($field_names);

        $data['template_images']=json_encode($template_images);

        return view('user.templates.create',$data);
    }


    /**
     * Edit template
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param     int product_id
     * @return     array product_info
     */
    public function edit_user_template($url)
    {
        $data['template'] = UserTemplate::where('is_delete', 0)->where('url', $url)->first();
                
                $data['feilds'] = UserTemplateFeild::where('template_id',$data['template']->id)->where('is_back',0)->get();
                
                $ids = array();
                foreach($data['feilds'] as $feild)
                {
                  array_push($ids, $feild->id);
                }

                $data['images'] = UserTemplateImage::whereIn('template_feild_id',$ids)->get();

                $imageids = array();
                foreach ($data['images'] as $key => $value) {
                    array_push($imageids, $value->template_feild_id);
                }

                $data['feilds'] = UserTemplateFeild::where('template_id', $data['template']->id)->where('is_back',0)->whereNotIn('id', $imageids)->where('is_label',0)->get();
                $data['labels'] = UserTemplateFeild::where('template_id', $data['template']->id)->where('is_back',0)->whereNotIn('id', $imageids)->where('is_label',1)->get();
                $data['image_css'] = UserTemplateFeild::where('template_id', $data['template']->id)->where('is_back',0)->whereIn('id', $imageids)->get();
               
                $names = array();
                foreach($data['feilds'] as $feild)
                {
                  array_push($names, $feild->name);
                }

                $labels = array();
                foreach($data['labels'] as $label)
                {
                  array_push($labels, $label->name);
                }

                $template_images = array();
                foreach($data['image_css'] as $image)
                {
                  array_push($template_images, $image->id);
                }

                $data['names'] = $names;
                $data['template_images'] = $template_images;
                $data['template_labels'] = $labels;


                $data['back_feilds'] = UserTemplateFeild::where('template_id',$data['template']->id)->where('is_back',1)->get();
                
                $ids = array();
                foreach($data['back_feilds'] as $feild)
                {
                  array_push($ids, $feild->id);
                }

                $data['back_images'] = UserTemplateImage::whereIn('template_feild_id',$ids)->get();

                $imageids = array();
                foreach ($data['back_images'] as $key => $value) {
                    array_push($imageids, $value->template_feild_id);
                }

                $data['back_feilds'] = UserTemplateFeild::where('template_id', $data['template']->id)->where('is_back',1)->whereNotIn('id', $imageids)->where('is_label',0)->get();
                $data['back_labels'] = UserTemplateFeild::where('template_id', $data['template']->id)->where('is_back',1)->whereNotIn('id', $imageids)->where('is_label',1)->get();
                $data['back_image_css'] = UserTemplateFeild::where('template_id', $data['template']->id)->where('is_back',1)->whereIn('id', $imageids)->get();
               
                $back_names = array();
                foreach($data['back_feilds'] as $feild)
                {
                  array_push($back_names, $feild->name);
                }

                $back_labels = array();
                foreach($data['back_labels'] as $label)
                {
                  array_push($back_labels, $label->name);
                }

                $back_template_images = array();
                foreach($data['back_image_css'] as $image)
                {
                  array_push($back_template_images, $image->id);
                }

                $data['back_names'] = $back_names;
                $data['back_template_images'] = $back_template_images;
                $data['back_template_labels'] = $back_labels;

                $data['back_names'] = $back_names;
                $data['back_template_images'] = $back_template_images;
                $data['back_template_labels'] = $back_labels;
                $data['objects'] = UserObject::where('is_back',0)->where('template_id',$data['template']->id)->get();
                $data['circles'] = UserObject::where('type','circle')->where('is_back',0)->where('template_id',$data['template']->id)->pluck('name');
                $data['lines'] = UserObject::where('type','line')->where('is_back',0)->where('template_id',$data['template']->id)->pluck('name');
                $data['squares'] = UserObject::where('type','square')->where('is_back',0)->where('template_id',$data['template']->id)->pluck('name');
                $data['back_objects'] = UserObject::where('is_back',1)->where('template_id',$data['template']->id)->get();
                $data['back_circles'] = UserObject::where('type','circle')->where('is_back',1)->where('template_id',$data['template']->id)->pluck('name');
                $data['back_lines'] = UserObject::where('type','line')->where('is_back',1)->where('template_id',$data['template']->id)->pluck('name');
                $data['back_squares'] = UserObject::where('type','square')->where('is_back',1)->where('template_id',$data['template']->id)->pluck('name');
                if($data['template']->is_both_side == 1)
                {
                  return view('user.templates.edit_double_side',$data);
                }
                else
                {
                   return view('user.templates.edit',$data);
                }  
        
    }
    

    /**
     * Save all the modification which is being done on edit page
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array snap,template_id,feilds,labels,deleted_feilds,deleted_labels,deleted_images,images,line_object,square_object,circle_object,deleted_line_object,deleted_square_object,deleted_circle_object
     * @return   json String
     */
    public function edit_user_template_post(Request $request)
    { 

        //$template =  Template::where('id',$request->template_id)->first();
         
         $user_id=Auth::user()->id;
       
            
        $user_fields=array(
            
                'snap'=> $request->snap,
        );

        UserTemplate::where('id', $request->template_id)->update($user_fields);
        if($request->feilds)
        {
            foreach ($request->feilds as $feild) 
            { 
                $exists = UserTemplateFeild::where('is_back',0)->where('template_id',$request->template_id)->where('name',trim($feild['name']))->first();
                if($exists)
                {
                    UserTemplateFeild::where('is_back',0)->where('template_id',$request->template_id)->where('name',trim($feild['name']))->update(['css' => $feild['css'], 'font_css' => $feild['font_css']]);
                }
                else
                {
                    $feild['template_id'] = $request->template_id;
                    UserTemplateFeild::create($feild);
                } 
            }
        }
        if($request->labels)
        {
            foreach ($request->labels as $label) 
            { 
                $exists = UserTemplateFeild::where('is_back',0)->where('template_id',$request->template_id)->where('name',trim($label['name']))->first();
                if($exists)
                {
                    UserTemplateFeild::where('is_back',0)->where('template_id',$request->template_id)->where('name',trim($label['name']))->update(['css' => $label['css'], 'font_css' => $label['font_css']]);
                }
                else
                {
                    $label['template_id'] = $request->template_id;
                    $label['is_label'] = 1;
                    UserTemplateFeild::create($label);
                } 
        }
    }
        if($request->deleted_feilds)
        {
            foreach ($request->deleted_feilds as  $feild) {
                UserTemplateFeild::where('is_back',0)->where('template_id', $request->template_id)->where('name', trim($feild))->delete();
            }

        }
       

        if($request->deleted_labels)
        {
            foreach ($request->deleted_labels as  $label) {
                UserTemplateFeild::where('is_back',0)->where('name',trim($label))->where('is_label',1)->where('template_id',$request->template_id)->delete();
            }

        }

         if($request->deleted_images!=null)
            {

                foreach ($request->deleted_images as $value) {

                    $image_name = UserTemplateImage::where('template_feild_id',$value)->first();
                    @unlink(public_path("templates\\images\\".$image_name->src));
                    UserTemplateImage::where('template_feild_id',$value)->delete();
                    userTemplateFeild::where('is_back',0)->where('id',$value)->delete();
                }
            }
       
       if($request->images)
       {
           foreach ($request->images as $image) {
            UserTemplateFeild::where('is_back',0)->where('id', $image['id'])->update(['css' => $image['div_css'], 'font_css' => $image['css']]);
            }
        }

        $circle_names = UserObject::where('is_back',0)->where('type', 'circle')->where('template_id', $request->template_id)->pluck('name');
         if($request->circle_object)
         {  
            foreach ($request->circle_object as $circle) 
            {
                $update = 0;
                $circle['template_id'] = $request->template_id;
                 foreach ($circle_names as $key => $value) {

                        if($value == $circle['name'])
                        { 
                            $id = $key;
                            $update = 1;
                        }
                }
                if($update == 1)
                {
                    $object = UserObject::where('name', $circle['name'])->where('template_id',$request->template_id)->update($circle);
                }
                else
                {   
                    $circle['is_back'] = 0;
                    UserObject::create($circle);
                }
               
            }
        }


        $square_names = UserObject::where('is_back',0)->where('type', 'square')->where('template_id', $request->template_id)->pluck('name');
         if($request->square_object)
         {  
            foreach ($request->square_object as $square) 
            {
                $update = 0;
                $square['template_id'] = $request->template_id;
                 foreach ($square_names as $key => $value) {

                        if($value == $square['name'])
                        { 
                            $id = $key;
                            $update = 1;
                        }
                }
                if($update == 1)
                {
                    $object = UserObject::where('name', $square['name'])->where('template_id',$request->template_id)->update($square);
                }
                else
                {   
                    $square['is_back'] = 0;
                    UserObject::create($square);
                }
               
            }
        }


        $line_names = UserObject::where('is_back',0)->where('type', 'line')->where('template_id', $request->template_id)->pluck('name');
         if($request->line_object)
         {  
            foreach ($request->line_object as $line) 
            {
                $update = 0;
                $line['template_id'] = $request->template_id;
                 foreach ($line_names as $key => $value) {

                        if($value == $line['name'])
                        { 
                            $id = $key;
                            $update = 1;
                        }
                }
                if($update == 1)
                {
                    $object = UserObject::where('name', $line['name'])->where('template_id',$request->template_id)->update($line);
                }
                else
                {   
                    $line['is_back'] = 0;
                    UserObject::create($line);
                }
               
            }
        }

         if($request->deleted_line_object!=null)
            {
                foreach ($request->deleted_line_object as $value) {
                    UserObject::where('name',$value)->where('is_back',0)->where('template_id',$request->template_id)->delete();
                }
            }
            if($request->deleted_circle_object!=null)
            {
                foreach ($request->deleted_circle_object as $value) {
                    UserObject::where('name',$value)->where('is_back',0)->where('template_id',$request->template_id)->delete();
                }
            }
            if($request->deleted_square_object!=null)
            {
                foreach ($request->deleted_square_object as $value) {
                    UserObject::where('name',$value)->where('is_back',0)->where('template_id',$request->template_id)->delete();
                }
            }

            
     
       return json_encode('saved.!');
    }


    /**
     * Save all the modification of template's backside which is being done on edit page
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array snap,template_id,feilds,labels,deleted_feilds,deleted_labels,deleted_images,images,line_object,square_object,circle_object,deleted_line_object,deleted_square_object,deleted_circle_object
     * @return   json String
     */
    public function edit_user_template_back_post(Request $request)
    {
        //$template =  Template::where('id',$request->template_id)->first();
         
         $user_id=Auth::user()->id;
       
            
        $user_fields=array(
            
                'back_snap'=> $request->snap,
        );

        userTemplate::where('id', $request->template_id)->update($user_fields);
        if($request->feilds)
        {
            foreach ($request->feilds as $feild) 
            { 
                $exists = UserTemplateFeild::where('is_back',1)->where('template_id',$request->template_id)->where('name',trim($feild['name']))->first();
                if($exists)
                {
                    UserTemplateFeild::where('is_back',1)->where('template_id',$request->template_id)->where('name',trim($feild['name']))->update(['css' => $feild['css'], 'font_css' => $feild['font_css']]);
                }
                else
                {
                    $feild['template_id'] = $request->template_id;
                    $feild['is_back'] = 1;
                    UserTemplateFeild::create($feild);
                } 
            }
        }
        if($request->labels)
        {
            foreach ($request->labels as $label) 
            { 
                $exists = UserTemplateFeild::where('is_back',1)->where('template_id',$request->template_id)->where('name',trim($label['name']))->first();
                if($exists)
                {
                    UserTemplateFeild::where('is_back',1)->where('template_id',$request->template_id)->where('name',trim($label['name']))->update(['css' => $label['css'], 'font_css' => $label['font_css']]);
                }
                else
                {
                    $label['template_id'] = $request->template_id;
                    $label['is_label'] = 1;
                    $label['is_back'] = 1;
                    UserTemplateFeild::create($label);
                } 
        }
    }

    $circle_names = UserObject::where('is_back',1)->where('type', 'circle')->where('template_id', $request->template_id)->pluck('name');
         if($request->back_circle_object)
         {  
            foreach ($request->back_circle_object as $circle) 
            {
                $update = 0;
                $circle['template_id'] = $request->template_id;
                 foreach ($circle_names as $key => $value) {

                        if($value == $circle['name'])
                        { 
                            $id = $key;
                            $update = 1;
                        }
                }
                if($update == 1)
                {
                    $object = UserObject::where('name', $circle['name'])->where('template_id',$request->template_id)->update($circle);
                }
                else
                {   
                    $circle['is_back'] = 1;
                    UserObject::create($circle);
                }
               
            }
        }


        $square_names = UserObject::where('is_back',1)->where('type', 'square')->where('template_id', $request->template_id)->pluck('name');
         if($request->back_square_object)
         {  
            foreach ($request->back_square_object as $square) 
            {
                $update = 0;
                $square['template_id'] = $request->template_id;
                 foreach ($square_names as $key => $value) {

                        if($value == $square['name'])
                        { 
                            $id = $key;
                            $update = 1;
                        }
                }
                if($update == 1)
                {
                    $object = UserObject::where('name', $square['name'])->where('template_id',$request->template_id)->update($square);
                }
                else
                {   
                    $square['is_back'] = 1;
                    UserObject::create($square);
                }
               
            }
        }


        $line_names = UserObject::where('is_back',1)->where('type', 'line')->where('template_id', $request->template_id)->pluck('name');
         if($request->back_line_object)
         {  
            foreach ($request->back_line_object as $line) 
            {
                $update = 0;
                $line['template_id'] = $request->template_id;
                 foreach ($line_names as $key => $value) {

                        if($value == $line['name'])
                        { 
                            $id = $key;
                            $update = 1;
                        }
                }
                if($update == 1)
                {
                    $object = UserObject::where('name', $line['name'])->where('template_id',$request->template_id)->update($line);
                }
                else
                {   
                    $line['is_back'] = 1;
                    UserObject::create($line);
                }
               
            }
        }

         if($request->back_deleted_line_object!=null)
            {
                foreach ($request->back_deleted_line_object as $value) {
                    UserObject::where('name',$value)->where('is_back',1)->where('template_id',$request->template_id)->delete();
                }
            }
            if($request->back_deleted_circle_object!=null)
            {
                foreach ($request->back_deleted_circle_object as $value) {
                    UserObject::where('name',$value)->where('is_back',1)->where('template_id',$request->template_id)->delete();
                }
            }
            if($request->back_deleted_square_object!=null)
            {
                foreach ($request->back_deleted_square_object as $value) {
                    UserObject::where('name',$value)->where('is_back',1)->where('template_id',$request->template_id)->delete();
                }
            }
        if($request->deleted_feilds)
        {
            foreach ($request->deleted_feilds as  $feild) {
                UserTemplateFeild::where('is_back',1)->where('template_id', $request->template_id)->where('name', trim($feild))->delete();
            }

        }
       

        if($request->deleted_labels)
        {
            foreach ($request->deleted_labels as  $label) {
                UserTemplateFeild::where('is_back',1)->where('name',trim($label))->where('is_label',1)->where('template_id',$request->template_id)->delete();
            }

        }

         if($request->deleted_images!=null)
            {

                foreach ($request->deleted_images as $value) {

                    $image_name = UserTemplateImage::where('template_feild_id',$value)->first();
                    @unlink(public_path("templates\\images\\".$image_name->src));
                    UserTemplateImage::where('template_feild_id',$value)->delete();
                    userTemplateFeild::where('is_back',1)->where('id',$value)->delete();
                }
            }
       
       if($request->images)
       {
           foreach ($request->images as $image) {
            UserTemplateFeild::where('is_back',1)->where('id', $image['id'])->update(['css' => $image['div_css'], 'font_css' => $image['css']]);
            }
        }
            
     
       return json_encode("Template is Edited..!");

    

    }


    /**
     * Delete user template
     * Delete snap of template
     * Delete lables and data of template
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    String url
     * @return   redirect back on view
     */
    public function delete_user_template($url)
    {
        $user_template = UserTemplate::where('url', $url)->where('user_id', Auth::user()->id)->first();
        $username = Auth::user()->username;

        @unlink(public_path("images\\".$username."\\".$user_template->snap));
        $feilds = UserTemplateFeild::where('template_id', $user_template->id)->get();
        $ids = array();
        foreach ($feilds as $value) {
            array_push($ids, $value->id); 
        }
        UserTemplateImage::whereIn('template_Feild_id', $ids)->delete();
        UserTemplateFeild::where('template_id', $user_template->id)->delete();
        UserTemplate::where('id', $user_template->id)->delete();
        UserObject::where('template_id',$user_template->id)->delete();
        return Redirect()->back();
    }


    /**
     * Get the data,lables and objects of the template
     * If the template is both side than get the data,lables and objects of backside
     * According to template is both side or not it will show the view
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    String url
     * @return   array product_info
     */
    public function create_single_card($url)
    {
        $data['template'] = UserTemplate::where('is_delete', 0)->where('url', $url)->first();
        
        $data['feilds'] = UserTemplateFeild::where('template_id',$data['template']->id)->where('is_back',0)->get();
        
        $ids = array();
        foreach($data['feilds'] as $feild)
        {
          array_push($ids, $feild->id);
        }

        $data['images'] = UserTemplateImage::whereIn('template_feild_id',$ids)->get();

        $imageids = array();
        foreach ($data['images'] as $key => $value) {
            array_push($imageids, $value->template_feild_id);
        }

        $data['feilds'] = UserTemplateFeild::where('template_id', $data['template']->id)->where('is_back',0)->whereNotIn('id', $imageids)->where('is_label',0)->get();
        $data['labels'] = UserTemplateFeild::where('template_id', $data['template']->id)->where('is_back',0)->whereNotIn('id', $imageids)->where('is_label',1)->get();
        $data['image_css'] = UserTemplateFeild::where('template_id', $data['template']->id)->where('is_back',0)->whereIn('id', $imageids)->get();
       
        $names = array();
        foreach($data['feilds'] as $feild)
        {
          array_push($names, $feild->name);
        }

        $labels = array();
        foreach($data['labels'] as $label)
        {
          array_push($labels, $label->name);
        }

        $template_images = array();
        foreach($data['image_css'] as $image)
        {
          array_push($template_images, $image->id);
        }

        $data['names'] = $names;
        $data['template_images'] = $template_images;
        $data['template_labels'] = $labels;


        $data['back_feilds'] = UserTemplateFeild::where('template_id',$data['template']->id)->where('is_back',1)->get();
        
        $ids = array();
        foreach($data['back_feilds'] as $feild)
        {
          array_push($ids, $feild->id);
        }

        $data['back_images'] = UserTemplateImage::whereIn('template_feild_id',$ids)->get();

        $imageids = array();
        foreach ($data['back_images'] as $key => $value) {
            array_push($imageids, $value->template_feild_id);
        }

        $data['back_feilds'] = UserTemplateFeild::where('template_id', $data['template']->id)->where('is_back',1)->whereNotIn('id', $imageids)->where('is_label',0)->get();
        $data['back_labels'] = UserTemplateFeild::where('template_id', $data['template']->id)->where('is_back',1)->whereNotIn('id', $imageids)->where('is_label',1)->get();
        $data['back_image_css'] = UserTemplateFeild::where('template_id', $data['template']->id)->where('is_back',1)->whereIn('id', $imageids)->get();
       
        $back_names = array();
        foreach($data['back_feilds'] as $feild)
        {
          array_push($back_names, $feild->name);
        }

        $back_labels = array();
        foreach($data['back_labels'] as $label)
        {
          array_push($back_labels, $label->name);
        }

        $back_template_images = array();
        foreach($data['back_image_css'] as $image)
        {
          array_push($back_template_images, $image->id);
        }

        $data['back_names'] = $back_names;
        $data['back_template_images'] = $back_template_images;
        $data['back_template_labels'] = $back_labels; 
        $data['objects'] = UserObject::where('is_back',0)->where('template_id',$data['template']->id)->get();
        $data['circles'] = UserObject::where('type','circle')->where('is_back',0)->where('template_id',$data['template']->id)->pluck('name');
        $data['lines'] = UserObject::where('type','line')->where('is_back',0)->where('template_id',$data['template']->id)->pluck('name');
        $data['squares'] = UserObject::where('type','square')->where('is_back',0)->where('template_id',$data['template']->id)->pluck('name');
        $data['back_objects'] = UserObject::where('is_back',1)->where('template_id',$data['template']->id)->get();
        $data['back_circles'] = UserObject::where('type','circle')->where('is_back',1)->where('template_id',$data['template']->id)->pluck('name');
        $data['back_lines'] = UserObject::where('type','line')->where('is_back',1)->where('template_id',$data['template']->id)->pluck('name');
        $data['back_squares'] = UserObject::where('type','square')->where('is_back',1)->where('template_id',$data['template']->id)->pluck('name');
       
        if($data['template']->is_both_side == 1)
        {
          return view('user.cards.single_card_double_side_create',$data);
        }
        else
        {
           return view('user.cards.single_card_create',$data);
        }  
             
    }


    /**
     * Save snap of template
     * Put the image in folder
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array image
     * @return   json image,user_id
     */
    public function save_card(Request $request)
    {
        $username=Auth::user()->username;

        $img = $request->image; // Your data 'data:image/png;base64,AAAFBfj42Pj4';
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $name = str_random(40);
        $path = public_path() .'/images/'.$username;   
        
        if(!File::exists($path))
        { 
            File::makeDirectory($path);
        } 
        file_put_contents('images/'. $username .'/'.$name.'.png', $data);

        $user_id = Auth::user()->id;

        $save = UserCard::create(array(
            'image' => $name.'.png',
            'user_id' => $user_id
            ));

        Session::flash('flash_message','Card successfully saved');
        return response()->json($save);
    }


    /**
     * Show upload items according to the template is being selected
     * If template is back side show upload items according to the template is being selected
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    String url
     * @return     array product_info
     */
    public function show_multiple_cards($url)
    {
        $user_id = Auth::user()->id;

        $data['template_url'] = array($url);

        $template_id = UserTemplate::where('url',$url)->where('user_id',$user_id)->first();
        
        $feilds = UserTemplateFeild::where('template_id',$template_id->id)->get();
       
        $user_template_ids = array();
        foreach ($feilds as $feild) {
            $user_template_ids[] = $feild->id;
        }

        $image_feilds = UserTemplateImage::whereIn('template_feild_id',$user_template_ids)->get();
        
        $image_feilds_ids = array();
        foreach ($image_feilds as $feild) {
            $image_feilds_ids[] = $feild->template_feild_id;
        }

        $data['image_feilds_name'] = UserTemplateFeild::whereIn('id',$image_feilds_ids)->get();

        $username=Auth::user()->username;
        $directory = public_path().'/temp/'.$username.'/front';

        if(File::exists($directory))
        { 
            $user_template_images = scandir($directory);
        } 
        
        if(count(glob("$directory/*")) === 0)
        {
            $data['user_template_images'] = array();
        } 
        else
        {
            $directory = public_path().'/temp/'.$username.'/front';
            $data['user_template_images'] = scandir($directory);
            $data['username'] = $username;
            
            unset($data['user_template_images'][0]);
            unset($data['user_template_images'][1]);
        }

        $directory2 = public_path().'/temp/'.$username.'/back';

        if(File::exists($directory2))
        { 
            $user_template_images = scandir($directory2);
        } 
        
        if(count(glob("$directory2/*")) === 0)
        {
            $data['user_template_back_images'] = array();
        }
        else
        {
            $directory2 = public_path().'/temp/'.$username.'/back';
            $data['user_template_back_images'] = scandir($directory2);

            unset($data['user_template_back_images'][0]);
            unset($data['user_template_back_images'][1]);
        }
        
        return view('multiple_cards',$data);
    }


    /**
    * According to the template is being selected user can download the excel file with appropriate values  
    *
    * @author   webdesignandsolution15@gmail.com
    * @access   public
    * $param    String url
    * @return   void
    */
    public function download_excel_file($url)
    {
        $user_id = Auth::user()->id;
        $username = Auth::user()->username;
        $user_template_id = UserTemplate::where('url',$url)->where('user_id',$user_id)->lists('id');
        
        $data = UserTemplateFeild::where('template_id',$user_template_id)->where('is_label','0')->pluck('name'); 
       
        return Excel::create($username." ".$url, function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->export('xls');
    }


    /**
     * User can upload appropriate excel file
     * User can only upload the file which header is being matching to the template feilds
     * User can not upload empty excel file
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array excel_file,String url
     * @return   view
     */
    public function upload_excel_file(Request $request,$url)
    {
        $user = Auth::user();
        $username = $user->username;
        $user_id = $user->id;

        $v = Validator::make([
                'excel_file' => $request->excel_file
            ],
            [
                'excel_file' => 'required'
            ]);

        if($v->fails())
        {
            return redirect()->back()->withErrors($v->errors()); 
        }

        $data['template_data'] = UserTemplate::where('url',$url)->where('user_id',$user_id)->get();
        
        $data['feilds'] = UserTemplateFeild::where('template_id',$data['template_data'][0]->id)->where('user_id',$user_id)->where('is_back',0)->get();

        $data['template_feilds'] = UserTemplateFeild::where('template_id',$data['template_data'][0]->id)->where('user_id',$user_id)->get();

        $user_template_ids = array();
        foreach ($data['template_feilds'] as $feild) {
            $user_template_ids[] = $feild->id;
        }

        $data['user_feilds'] = UserTemplateFeild::where('template_id',$data['template_data'][0]->id)->where('is_back','0')->get();
            
        $feilds_name = UserTemplateFeild::whereIn('id',$user_template_ids)->where('is_label',0)->where('is_back','0')->get();            

        $data['images'] = UserTemplateImage::whereIn('template_feild_id',$user_template_ids)->get();

        $imageids = array();
        foreach ($data['images'] as $key => $value) {
            array_push($imageids, $value->template_feild_id);
        }

        $data['image_css'] = UserTemplateFeild::where('template_id', $data['template_data'][0]->id)->whereIn('id', $imageids)->get();   

        $template_images = array();
        foreach($data['image_css'] as $image)
        {
            array_push($template_images, $image->id);
        }
        $data['template_images'] = $template_images;

        $image_name = UserTemplateFeild::whereIn('id',$imageids)->where('is_back',0)->lists('id','name');

        $data['image_feilds_name'] = $image_name;
        
        $image_feilds_name = UserTemplateFeild::whereIn('id',$imageids)->lists('name');

        //Check image folders are available or not 

            foreach ($image_feilds_name as $name) 
            {
                $name = str_replace(" ","_",$name);
                $name = strtolower($name);
            
                $check = public_path().'/user/'.$username.'/'.$name;
                if(!File::exists($check))
                { 
                    Session::flash('flash_message','First you must upload images');
                    return redirect()->back();
                } 

                $check_folder = scandir($directory = public_path().'/user/'.$username.'/'.$name);    

                unset($check_folder[0]);
                unset($check_folder[1]);
                
                if($check_folder == null)
                {
                    Session::flash('flash_message','First you must upload images');
                    return redirect()->back();
                }
            }
            
        //End Checking

        // Getting File Headers 

            $filename = $request->excel_file->getClientOriginalName();
            $upload_success = $request->excel_file->move('excelfiles/', $filename);
           
            $file_headers = Excel::load('excelfiles/'.$filename, function($reader) { 

            })->first(); 

            if($file_headers == null)
            {
                Session::flash('flash_message','File is null');
                @unlink('excelfiles/'.$filename);
                return redirect()->back();
            }

            $header_names = array();
            foreach($file_headers as $key => $header)
            {
                array_push($header_names, $key);
            }

        //End Getting Headers

        //Get name of database feilds
            
            $img_feilds_name = UserTemplateFeild::whereIn('id',$user_template_ids)->where('is_label',0)->get();            

            $feild_names = array();
            foreach($img_feilds_name as $name)
            {
                $name = str_replace(" ","_",$name->name);
                $name = strtolower($name);

                array_push($feild_names,$name);
            }
           
        //End getting

        //Comparing Feilds
           
            $new_feild_names = array();
            foreach ($feild_names as $value) 
            {
                $new_val = str_replace(' ', '_', $value);
                array_push($new_feild_names,$new_val);
            }

            if($new_feild_names === $header_names) {
                
            } 
            else
            {
                @unlink('excelfiles/'.$filename);
                Session::flash('flash_message','Please Upload Proper File');
                return redirect()->back();
            }

        //End Comparing

        $data['cards_data'] = Excel::load('excelfiles/'.$filename, function($reader) { 

        })->get(); 

        $data['quentity'] = count($data['cards_data']);
        $data['username'] = $username;


        $data['back_feilds'] = UserTemplateFeild::where('template_id',$data['template_data'][0]->id)->where('is_back',1)->get();
               
        $ids = array();
        foreach($data['back_feilds'] as $feild)
        {
            array_push($ids, $feild->id);
        }

        $data['back_images'] = UserTemplateImage::whereIn('template_feild_id',$ids)->get();

        $imageids = array();
        foreach ($data['back_images'] as $key => $value) {
            array_push($imageids, $value->template_feild_id);
        }

        $data['back_feilds'] = UserTemplateFeild::where('template_id', $data['template_data'][0]->id)->where('is_back',1)->whereNotIn('id', $imageids)->where('is_label',0)->get();
        $data['back_labels'] = UserTemplateFeild::where('template_id', $data['template_data'][0]->id)->where('is_back',1)->whereNotIn('id', $imageids)->where('is_label',1)->get();
        $data['back_image_css'] = UserTemplateFeild::where('template_id', $data['template_data'][0]->id)->where('is_back',1)->whereIn('id', $imageids)->get();
             
        $back_names = array();
        foreach($data['back_feilds'] as $feild)
        {
            array_push($back_names, $feild->name);
        }

        $back_labels = array();
        foreach($data['back_labels'] as $label)
        {
            array_push($back_labels, $label->name);
        }

        $back_template_images = array();
        foreach($data['back_image_css'] as $image)
        {
            array_push($back_template_images, $image->id);
        }

        $data['back_template_images_name'] = UserTemplateFeild::whereIn('id',$back_template_images)->lists('id','name');

        $data['back_names'] = $back_names; 
        $data['back_template_images'] = $back_template_images;
        $data['back_template_labels'] = $back_labels;
        $data['objects'] = UserObject::where('is_back',0)->where('template_id',$data['template_data'][0]->id)->get();
        $data['circles'] = UserObject::where('type','circle')->where('is_back',0)->where('template_id',$data['template_data'][0]->id)->pluck('name');
        $data['lines'] = UserObject::where('type','line')->where('is_back',0)->where('template_id',$data['template_data'][0]->id)->pluck('name');
        $data['squares'] = UserObject::where('type','square')->where('is_back',0)->where('template_id',$data['template_data'][0]->id)->pluck('name');
        $data['back_objects'] = UserObject::where('is_back',1)->where('template_id',$data['template_data'][0]->id)->get();
        $data['back_circles'] = UserObject::where('type','circle')->where('is_back',1)->where('template_id',$data['template_data'][0]->id)->pluck('name');
        $data['back_lines'] = UserObject::where('type','line')->where('is_back',1)->where('template_id',$data['template_data'][0]->id)->pluck('name');
        $data['back_squares'] = UserObject::where('type','square')->where('is_back',1)->where('template_id',$data['template_data'][0]->id)->pluck('name');
       
        if($data['template_data'][0]->is_both_side == 1)
        {  
            return view('user.multiple_double_side_cards_snap',$data);
        }   
        else
        {
            return view('user.multiple_cards_snap',$data);
        }


    }


    /**
     * User uploads the file
     * Folder is being created with username 
     * Images are being strore in username folder
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array id, String url
     * @return   redirect back on view
     */
    public function upload_images(Request $request,$url)
    {   
        $user = Auth::user();
        $username = $user->username;
        $user_id = $user->id;

        $data['template_data'] = UserTemplate::where('url',$url)->where('user_id',$user_id)->first();
            
        $data['feilds'] = UserTemplateFeild::where('template_id',$data['template_data']->id)->where('user_id',$user_id)->get();

        $user_template_ids = array();
        foreach ($data['feilds'] as $feild) {
            $user_template_ids[] = $feild->id;
        }

        $data['images'] = UserTemplateImage::whereIn('template_feild_id',$user_template_ids)->get();
                 
        $imageids = array();
        foreach ($data['images'] as $key => $value) {
            array_push($imageids, $value->template_feild_id);
        }
        
        $data['feilds'] = UserTemplateFeild::where('template_id', $data['template_data']->id)->whereNotIn('id', $imageids)->get();
              
        $data['image_css'] = UserTemplateFeild::where('template_id', $data['template_data']->id)->whereIn('id', $imageids)->get();
      
        
        $template_images = array();

        foreach($data['image_css'] as $image)
        {
            array_push($template_images, $image->id);
        }
        $data['template_images'] = $template_images;
        
        $image_feilds_name = UserTemplateFeild::whereIn('id',$imageids)->lists('name');

        $image_name = UserTemplateFeild::whereIn('id',$imageids)->lists('id','name');

        $data['image_feilds_name'] = $image_name;
        $path = public_path().'/user/'.$username;

        if(!File::exists($path))
        { 
            File::makeDirectory($path);
        }

        foreach ($image_feilds_name as $name) 
        {
            $id = str_replace(" ","_",$name);
            $id = strtolower($id);
            $name = $id;

            $path = public_path().'/user/'.$username.'/'.$name;   

            if(!File::exists($path))
            { 
                File::makeDirectory($path);
            } 
          
            $files = $request->$id;
            if($request->$id)
            {
                foreach($files as $file)
                {
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $picture = $filename;
                    $destinationPath = public_path().'/user/'.$username.'/'.$name; 
                    $file->move($destinationPath, $picture);
                }
            }
        }

        Session::flash('flash_success','Photoes successfully uploaded.');
        return redirect()->back();
        
    }


    /**
     * Create username folder
     * If there are Front side's images in template than front named folder is being created ad stored image in that folder
     * If there are back side's images in template than back named folder is being created ad stored image in that folder
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array image
     * @return   json image
     */
    public function multiple_image_save(Request $request)
    {   
        $username=Auth::user()->username;

        $img = $request->image; // Your data 'data:image/png;base64,AAAFBfj42Pj4';
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $name = str_random(40);
        $path = public_path() .'/temp/'.$username;  

        if(!File::exists($path))
        { 
            File::makeDirectory($path);
        } 

        $path = public_path() .'/temp/'.$username.'/front';  
        if(!File::exists($path))
        { 
            File::makeDirectory($path);
        } 

        if($request->image_name)
        {
            if($request->is_back)
            {
                $path = public_path().'/temp/'.$username.'/back';
                $count = count(glob($path."/*"));

                $name = $count + 1;

                if(!File::exists($path))
                { 
                    File::makeDirectory($path);
                } 

                file_put_contents('temp/'. $username .'/back/'.$request->image_name.'.png', $data);
                return json_encode($request->image_name);
            }
            else
            {
                $path = public_path().'/temp/'.$username.'/front';
                $count = count(glob($path."/*"));

                $name = $count + 1;
                
                if(!File::exists($path))
                { 
                    File::makeDirectory($path);
                } 

                file_put_contents('temp/'. $username .'/front/'.$request->image_name.'.png', $data);
                
                return json_encode($request->image_name);
            }
        } 

        file_put_contents('temp/'. $username .'/front/'.$name.'.png', $data);
        
        return json_encode($name.".png");
    }


    /**
     * Get all the images ad show the images
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * @return    view
     */
    public function show_multiple_image_preview()
    {
        $username = Auth::user()->username;
        $directory = public_path().'/temp/'.$username.'/front/'; 
        $data['user_template_images'] = scandir($directory);
        $data['username'] = $username;

        unset($data['user_template_images'][0]);
        unset($data['user_template_images'][1]);
    
        return view('show_multiple_cards_preview',$data);
    }


    /**
     * Delete image from multiple preview
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array image_name
     * @return   json String
     */
    public function delete_image_from_multiple_preview(Request $request)
    {
        @unlink(public_path("temp/".Auth::user()->username.'/front/'.$request->image_name));
        return response()->json("save");
    }


     /**
     * Delete backside image from multiple preview
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array image_name
     * @return   json String
     */
    public function delete_back_image_from_multiple_preview(Request $request)
    {
        @unlink(public_path("temp/".Auth::user()->username.'/back/'.$request->image_name));
        return response()->json("save");
    }


     /**
     * Delete all images of template
     * Delete folder and excel file of that template
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array image_name
     * @return   json String
     */
    public function delete_multiple_preview_folder($url)
    {  
        $user = Auth::user();
        $username = $user->username;
        $user_id = $user->id;

        $dir = public_path()."/temp/".$username.'/front';
        
        foreach(glob("{$dir}/*") as $file)
        {
            if(is_dir($file)) { 
                recursiveRemoveDirectory($file);
            } else {
                unlink($file);
            }

        }
        rmdir($dir);

        $dir = public_path()."/temp/".$username.'/back';

        if(File::exists($dir))
        { 
            foreach(glob("{$dir}/*") as $file)
            {
                if(is_dir($file)) { 
                    recursiveRemoveDirectory($file);
                } else {
                    unlink($file);
                }

            }
            rmdir($dir);
        } 

        

        rmdir(public_path()."/temp/".$username);

        $template_data = UserTemplate::where('url',$url)->where('user_id',$user_id)->first();
        $feilds = UserTemplateFeild::where('template_id',$template_data->id)->where('user_id',$user_id)->get();
        
        $user_template_ids = array();
        foreach ($feilds as $feild) {
            $user_template_ids[] = $feild->id;
        }

        $images = UserTemplateImage::whereIn('template_feild_id',$user_template_ids)->get();
                        
        $imageids = array();
        foreach ($images as $key => $value) {
            array_push($imageids, $value->template_feild_id);
        }
        
        $image_feilds_name = UserTemplateFeild::whereIn('id',$imageids)->lists('name');

        $image_feild_name = array();
        foreach ($image_feilds_name as $value) {
            $name = str_replace(" ","_", $value); 
            $name = strtolower($name); 
            array_push($image_feild_name, $name);
        }

        foreach ($image_feild_name as $name) 
        {   
            $directory = public_path()."/user/".$username."/".$name;
        
            foreach(glob("{$directory}/*") as $file)
            {
                if(is_dir($file)) { 
                    recursiveRemoveDirectory($file);
                } else {
                    unlink($file);
                }
            }

            rmdir($directory);

        }
        //rmdir(public_path()."/user/".$username);
        @unlink(public_path()."/excelfiles/".$username." ".$url.".xls");

        return redirect()->back();
    }


    /**
     * Save material_id in session
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    int material_id
     * @return   array product_info
     */
    public function get_material_id($material_id)
    {
        Session::put('material_id',$material_id);
        return redirect('cards');
    }


    /**
     * Save material_id in session
     *
     * @author   webdesignandsolution15@gmail.com
     * @access   public
     * $param    array material_id
     * @return   json
     */
    public function save_material_id(Request $request)
    {
        Session::put('material_id',$request->material_id);
        return response()->json();
    }


    // public function change_material(Request $request)
    // {
    //     $order_no = $request->order_no;
    //     $material = Order::where('order_no',$order_no)
    //                             ->update(['material_id' => $request->material_id]);
      
    //     return redirect('/order/'.$order_no.'/payment');

    // }


}