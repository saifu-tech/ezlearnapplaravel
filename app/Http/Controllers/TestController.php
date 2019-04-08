<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;
use Validator;
use Redirect;
use App\Options;
use App\Option;
use App\User;
use App\Classname;
use App\Subjects;
use App\Category;
use App\Subcategory;
use App\Staff;
use App\Country;
use App\Students;
use App\Groupcourse;
use App\GroupMember;
use App\Group;
use App\GroupPostMeta;
use App\GroupPost;
use App\GroupComment;
use App\CourseComplete;
use App\Vote;
use App\Library;
use App\Dailytasks;
use App\Dailytaskstracker;
use App\Dailytasksstudent;
use App\Dailytasksmeta;
use App\Dailytasksmetatracker;
use App\Dailytasksstatus;
use App\Dailytasksstatustracker;
use App\Dailytasksresult;
use App\TaskComplete;
use App\Votemeta;
use App\Privilege;
use App\Pages;
use App\Discussion;
use App\Appsetting;
use App\Tracker;
use App\Studenttracker;
use App\Color;
use App\Trackerpercentage;
use DB;
use Mail;
use URL;
use Excel;
use App\Courses;
use App\Http\Controllers\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TestController extends BaseController{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $weekdays;

    public function __construct() {
    	$this->weekdays = ['','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
    }
    public function us(){
    	
 					
    				 $new = new User();
    				 
                     $new->full_name = 'Admin';
                     $new->user_id = 'admin';
                     $new->email = 'admin@cloudelabs.com';
                     $new->password = Hash::make('password');
                     $new->status = 'active';
                     $new->type = 'admin';
                     $new->save();

                    return response()->json(['status' => true]);
    }

    public function basictest(){
    	return view('test');
    }

    public function hello(){
    	return view('login');
    }

    public function loginpost(Request $req){
    	$input=$req->all();
	    $rules= ['userName'=>'required'];//,'password'=>'required'
	    $validation= Validator::make($input,$rules);
	    if($validation->fails())
	    {
	      return redirect('admin/login')->withErrors($validation)->withInput();
	    }
	    $type=  Options::getvalue("logintype");
	    if(Auth::attempt(['email'=>$input['userName'],'password'=>$input['password'],'status'=>'active']))
	    {
	      return redirect('admin');
	    }else{
	      return redirect('admin/login')->with('error','Invalid login credentails');
	    }
  	}

  	public function indexget(){
  		return view('dashboard');
  	}

  	public function logout(){
	    $userId=Auth::user()->userName;
	    Auth::logout();
	    return redirect('admin/login')->with('error',"You've been logged out successfully");
  	}

  	public function changepasswordget(){
	    return view('changePassword');
	}

	public function changepasswordpost(Request $req){
	    $input= $req->all();
	    $rules= array('currentPassword'=>'required',
	    	'newPassword' => 'required|min:6|max:15',
	    	'newPassword_confirmation' => 'required|min:6|max:15|same:newPassword'); 
	    $validation = Validator::make($input, $rules);
	    if($validation->fails()){
	        return back()->withErrors($validation)->withInput();
	    }  
	    $currentPassword=$input['currentPassword'];
	    $currentPassword1=Auth::user()->password;
	    if(Hash::check($currentPassword,$currentPassword1)){
	            $update = User::find(Auth::user()->id);
	            $newPassword = Hash::make($input['newPassword']);
	            $update->password=$newPassword;
	            $update->save();
	            return back()->with('success','Password changed successfully');
	    }else{
	        return back()->with('error','Your current password was wrong');
	    }
	}


	//Classes

	public function classesget(){
		$country=[];
		$countryBased=Options::getvalue('countryBased');
		if($countryBased=='yes'){
			$country=Country::where('status','active')->orderBy('name')->lists('name','id');
		}
	    $records=Classname::where('status','!=','deleted')->get();
	    return view('classes')->with('records',$records)->with('country',$country);
	}

	public function addclassespost(Request $req){
	    $input=$req->all();
	    $countryBased=Options::getvalue('countryBased');
	    if($countryBased=='yes'){
	    	$rules=['country'=>'required','classCode'=>'required','className'=>'required'];
	    }else{
	    	$rules=['classCode'=>'required','className'=>'required'];
	    }
	    $validation= Validator::make($input,$rules);
	    if($validation->fails()){
	      return back()->withErrors($validation,'add')->withInput()->with('classerror','add_row');
	    }
	    $insert=new Classname();
	    if($countryBased=='yes'){
	    	$insert->countryId=$input['country'];
	    }
	    $insert->code=$input['classCode'];
	    $insert->class_name=$input['className'];
	    $insert->status='active';
	    $insert->save();
	    return Redirect::to('admin/masters/classes/get')->with('success','New class added successfully.')->with('classerror','add_row');
	}

	public function getclassespost(Request $req){
	    $id= $req->input('editId');
	    $record= Classname::where('id',$id)->first();
	    $name='';
	    $code='';
	    $country='';
	    if(count($record)==1){
	    	$name=$record->class_name;
	    	$code=$record->code;
	    	$country=$record->countryId;
	    }
	    return Response::json(['status'=>'success','name'=>$name,'code'=>$code,'country'=>$country]);
	}

	public function editclassespost(Request $req){
	    $input=$req->all();
	    $countryBased=Options::getvalue('countryBased');
	    if($countryBased=='yes'){
	    	$rules=['country'=>'required','classCode'=>'required','className'=>'required'];
	    }else{
	    	$rules=['classCode'=>'required','className'=>'required'];
	    }
	    $validation= Validator::make($input,$rules);
	    if($validation->fails()){
	      return back()->withErrors($validation,'edit')->withInput()->with('classerror','edit_row');
	    }
	    $update=Classname::find($input['editId']);
	    if($countryBased=='yes'){
	    	$update->countryId=$input['country'];
	    }else{
	    	$update->countryId=NULL;
	    }
	    $update->code=$input['classCode'];
	    $update->class_name=$input['className'];
	    $update->save();
	    return back()->with('success','Class details updated successfully.')->with('classerror','edit_row')->withInput();
	}

	public function deleteclassespost(Request $req){
		$input=$req->all();
	    $ids=json_decode($input['ids']);
	    $delete=Classname::whereIn('id',$ids)->update(['status'=>'deleted']);
	    return Response::json(['status'=>'success']);
	}


	//Country

	public function countryget(){
	    $records=Country::where('status','!=','deleted')->get();
	    return view('country')->with('records',$records);
	}

	public function addcountrypost(Request $req){
	    $input=$req->all();
	    $rules=['countryName'=>'required|unique:country,name,NULL,id,status,active'];
	    $validation= Validator::make($input,$rules);
	    if($validation->fails()){
	      return back()->withErrors($validation,'add')->withInput()->with('countryerror','add_row');
	    }
	    $insert=new Country();
	    $insert->name=$input['countryName'];
	    $insert->status='active';
	    $insert->save();
	    return back()->with('success','New country added successfully.')->with('countryerror','add_row');
	}

	public function getcountrypost(Request $req){
	    $id= $req->input('editId');
	    $record= Country::find($id);
	    $name='';
	    if(count($record)==1){
	    	$name=$record->name;
	    }
	    return Response::json(['status'=>'success','name'=>$name]);
	}

	public function editcountrypost(Request $req){
	    $input=$req->all();
	    $rules=['countryName'=>'required|unique:country,name,'.$input['editId'].',id,status,active'];
	    $validation= Validator::make($input,$rules);
	    if($validation->fails()){
	      return back()->withErrors($validation,'edit')->withInput()->with('countryerror','edit_row');
	    }
	    $update=Country::find($input['editId']);
	    $update->name=$input['countryName'];
	    $update->save();
	    return back()->with('success','Country details updated successfully.')->with('countryerror','edit_row')->withInput();
	}

	public function deletecountrypost(Request $req){
		$input=$req->all();
	    $ids=json_decode($input['ids']);
	    $delete=Country::whereIn('id',$ids)->update(['status'=>'deleted']);
	    return Response::json(['status'=>'success']);
	}

	//Subjects
	public function subjectsget(){
		$countryBased=Options::getvalue('countryBased');
		$classes=Classname::where('status','active');
		$staffCountry=Staff::getstaffcountry(Auth::user()->userLink);
		if($countryBased=='yes'){
			$classes=$classes->where('countryId',$staffCountry);
		}
		$classes=$classes->lists('class_name','id');
	    $records=Subjects::where('status','!=','deleted')->get();
	    return view('subjects')->with('records',$records)->with('classes',$classes);
	}

	public function addsubjectspost(Request $req){
	    $input=$req->all();
	    $rules=['class'=>'required','subjectCode'=>'required|unique:subjects,code,NULL,id,status,active','subjectName'=>'required|unique:subjects,name,NULL,id,status,active'];
	    $validation= Validator::make($input,$rules);
	    if($validation->fails()){
	      return back()->withErrors($validation,'add')->withInput()->with('subjectserror','add_row');
	    }
	    $insert=new Subjects();
	    $insert->classId=$input['class'];
	    $insert->code=$input['subjectCode'];
	    $insert->name=$input['subjectName'];
	    $insert->status='active';
	    $insert->save();
	    return Redirect::to('admin/masters/subjects/get')->with('success','New subject added successfully.')->with('subjectserror','add_row');
	}

	public function getsubjectspost(Request $req){
	    $id= $req->input('editId');
	    $record= Subjects::where('id',$id)->first();
	    $name='';
	    $code='';
	    $class='';
	    if(count($record)==1){
	    	$name=$record->name;
	    	$class=$record->classId;
	    	$code=$record->code;
	    }
	    return Response::json(['status'=>'success','name'=>$name,'code'=>$code,'class'=>$class]);
	}

	public function editsubjectspost(Request $req){
	    $input=$req->all();
	    $rules=['class'=>'required','subjectCode'=>'required|unique:subjects,code,'.$input['editId'].',id,status,active','subjectName'=>'required|unique:subjects,name,'.$input['editId'].',id,status,active'];
	    $validation= Validator::make($input,$rules);
	    if($validation->fails()){
	      return back()->withErrors($validation,'edit')->withInput()->with('subjectserror','edit_row');
	    }
	    $update=Subjects::find($input['editId']);
	    $update->classId=$input['class'];
	    $update->code=$input['subjectCode'];
	    $update->name=$input['subjectName'];
	    $update->save();
	    return back()->with('success','Subject detail updated successfully.')->with('subjectserror','edit_row')->withInput();
	}

	public function deletesubjectspost(Request $req){
		$input=$req->all();
	    $ids=json_decode($input['ids']);
	    $delete=Subjects::whereIn('id',$ids)->update(['status'=>'deleted']);
	    return Response::json(['status'=>'success']);
	}


	//Courses
	public function coursesget(){
		$countryBased=Options::getvalue('countryBased');
		$classes=Classname::where('status','active');
		$staffCountry=Staff::getstaffcountry(Auth::user()->userLink);
		if($countryBased=='yes'){
			$classes=$classes->where('countryId',$staffCountry);
		}
		$classes=$classes->lists('class_name','id');
	    $records = [];
	    return view('courses')->with(['records'=>$records,'classes'=>$classes]);
	}

	public function addcoursespost(Request $req){
	    $input = $req->all();
	    $rules = ['class'=>'required','subject'=>'required','courseCode'=>'required|unique:courses,code,NULL,id,status,active','courseName'=>'required','startDate'=>'required','endDate'=>'required','youtubeLink'=>'url'];
	    $validation = Validator::make($input,$rules);
	    if($validation->fails()){
	      return back()->withErrors($validation,'add')->withInput()->with('classerror','add_row');
	    }

	    $insert = new Courses();
	    $insert->code=$input['courseCode'];
	    $insert->class_id=$input['class'];
	    $insert->subject=$input['subject'];
	    if($input['parentCategory']!=''){
	    	$insert->category=$input['parentCategory'];
	    }
	    if($input['courseSubCate']!=''){
	    	$insert->subcategory = $input['courseSubCate'];
	    }
	    
	    $insert->name = $input['courseName'];
	    $insert->description = $input['courseDescription'];
	    $insert->status = "active";
	    $insert->created_by = Auth::User()->id;
	    $insert->save();


	    $new = new Groupcourse();
		$new->code = str_random(8);
		$new->group_id = 0;
		$new->class_id=$insert->class_id;
		$new->subject_id=$insert->subject;
		$new->category_id=$insert->category;
		$new->subcategory_id=$insert->subcategory;
		$new->course_id=$insert->id;
		$new->admin = Auth::user()->id;
		$new->subscribed = 0;
		$new->completed = 0;
		$new->pending = 0;
		$new->course_name = $insert->name; 
		$new->start_date = strtotime($input['startDate']);
		$new->end_date = strtotime($input['endDate']);
	    $new->video_url = $input['youtubeLink'];
	    $new->status='inactive';
		$new->save();
	    return back()->with('success','New course added successfully.')->with('classerror','add_row');
	}

	public function getcoursespost(Request $req){
	    $id = $req->input('editId');
	    $record = Courses::find($id);
	    $classSubjects=Subjects::where('classId',$record->class_id)->where('status','active')->select('name','id')->get();
	    $classCategory=Category::where('parent_class',$record->class_id)->where('subject',$record->subject)->where('status','active')->select('category_name','id')->get();
	    $classSubCategory=Subcategory::where('parent',$record->category)->where('status','active')->select('name','id')->get();
	    $groupcoursedetails=Groupcourse::where('course_id',$id)->first();
	    $startDate='';
	    $endDate='';
	    $link='';
	    if(count($groupcoursedetails)==1){
	    	$startDate=date('d-m-Y',$groupcoursedetails->start_date);
	    	$endDate=date('d-m-Y',$groupcoursedetails->end_date);
	    	$link=$groupcoursedetails->video_url;
	    }
	    return Response::json(['status'=>'success','record'=>$record,'classSubjects'=>$classSubjects,'classCategory'=>$classCategory,'classSubCategory'=>$classSubCategory,'startDate'=>$startDate,'endDate'=>$endDate,'link'=>$link]);
	}

	public function editcoursespost(Request $req){
	    $input = $req->all();
	    $rules = ['class'=>'required','subject'=>'required','courseEditCode'=>'required|unique:courses,code,'.$input["editId"].',id,status,active','courseEditName'=>'required','startDate'=>'required','endDate'=>'required','youtubeLink'=>'url'];
	    $validation = Validator::make($input,$rules);
	    if($validation->fails()){
	      return back()->withErrors($validation,'edit')->withInput()->with('classerror','edit_row');
	    }
	    $update = Courses::find($input['editId']);
	    $update->class_id=$input['class'];
	    $update->subject=$input['subject'];
	    if($input['parentCategory']!=''){
	    	$update->category=$input['parentCategory'];
	    }
	    if($input['courseEditSubCate']!=''){
	    	$update->subcategory = $input['courseEditSubCate'];
	    }
	    $update->code=$input['courseEditCode'];
	    $update->name = $input['courseEditName'];
	    $update->description = $input['courseEditDescription'];
	    $update->save();

	    $groupcourse=Groupcourse::where('course_id',$update->id)->lists('id');
	    if(count($groupcourse)>0){
	    	Groupcourse::where('course_id',$update->id)->update(['start_date'=>strtotime($input['startDate']),'end_date'=>strtotime($input['endDate']),'video_url'=>$input['youtubeLink']]);
	    }else{
	    	$new = new Groupcourse();
			$new->code = str_random(8);
			$new->group_id = 0;
			$new->class_id=$update->class_id;
			$new->subject_id=$update->subject;
			$new->category_id=$update->category;
			$new->subcategory_id=$update->subcategory;
			$new->course_id=$update->id;
			$new->admin = Auth::user()->id;
			$new->subscribed = 0;
			$new->completed = 0;
			$new->pending = 0;
			$new->course_name = $update->name; 
			$new->start_date = strtotime($input['startDate']);
			$new->end_date = strtotime($input['endDate']);
		    $new->video_url = $input['youtubeLink'];
		    $new->status='inactive';
			$new->save();
	    }
	    return back()->with('success','Course details updated successfully.')->with('classerror','edit_row')->withInput();
	}

	public function deletecoursespost(Request $req){
		$input = $req->all();
	    $ids = json_decode($input['ids']);
	    $delete = Courses::whereIn('id',$ids)->update(['status'=>'deleted']);
	    $delte=Groupcourse::whereIn('course_id',$ids)->update('status','deleted');
	    return Response::json(['status'=>'success']);
	}


	//Categories
	
	public function categoryget(){
	    $records=[];//Category::where('status','active')->get();
	    $countryBased=Options::getvalue('countryBased');
		$classes=Classname::where('status','active');
		$staffCountry=Staff::getstaffcountry(Auth::user()->userLink);
		if($countryBased=='yes'){
			$classes=$classes->where('countryId',$staffCountry);
		}
		$classes=$classes->lists('class_name','id');
	    return view('category')->with('records',$records)->with('classes',$classes);
	}

	public function addcategorypost(Request $req){
	    $input=$req->all();
	    $rules=['categoryType'=>'required','class'=>'required','subject'=>'required'];
	    $validation=Validator::make($input,$rules);
	    if($validation->fails()){
	      return back()->withErrors($validation,'add')->withInput()->with('categoryerror','add_row');
	    }
	    if($input['categoryType']==1){
	    	$rules=['categoryCode'=>'required|unique:categories,code,NULL,id,status,active','categoryName'=>'required|unique:categories,category_name,NULL,id,status,active'];
	    }else{
	    	$rules=['categoryName'=>'required','categoryCode'=>'required|unique:sub_categories,code,NULL,id,status,active','parentCategory'=>'required'];
	    }
	    $validation= Validator::make($input,$rules);
	    if($validation->fails()){
	      return back()->withErrors($validation,'add')->withInput()->with('categoryerror','add_row');
	    }
	    if($input['categoryType']==1){
	    	$insert=new Category();
	    	$insert->code=$input['categoryCode'];
		    $insert->category_name=$input['categoryName'];
		    $insert->parent_class=$input['class'];
		    $insert->subject=$input['subject'];
		    $insert->created_by=Auth::user()->id;
		    $insert->status='active';
		    $insert->description=$input['description'];
		    $insert->save();
	    }elseif($input['categoryType']==2){
	    	$insert=new Subcategory();
	    	$insert->code=$input['categoryCode'];
	    	$insert->classes=$input['class'];
	    	$insert->subject=$input['subject'];
		    $insert->name=$input['categoryName'];
		    $insert->parent=$input['parentCategory'];
		    $insert->description=$input['description'];
		    $insert->created_by=Auth::user()->id;
		    $insert->status='active';
		    $insert->save();
	    }
	    
	    return Redirect::to('admin/masters/category/get')->with('success','New category added successfully.')->with('categoryerror','add_row');
	}

	public function getcategorypost(Request $req){
	    $id= $req->input('editId');
	    $catType=$req->input('type');
	    $class='';
		$subject='';
		$type=1;
		$parent='';
		$code='';
	    $name='';
	    $description='';
	    if($catType=='main'){
	    	$record=Category::where('id',$id)->first();
	    	$type=1;
	    	if(count($record)==1){ 
	    		$class=$record->parent_class;
	    		$subject=$record->subject;
	    		$code=$record->code;
	    		$name=$record->category_name; 
	    		$description=$record->description;
	    	}
	    }else{
	    	$type=2;
	    	$record=Subcategory::where('id',$id)->first();
	    	if(count($record)==1){
	    		$class=$record->classes;
	    		$subject=$record->subject;
	    		$parent=$record->parent;
	    		$code=$record->code;
	    		$name=$record->name;
	    		$description=$record->description;
	    	}
	    }
	    $classSubjects=Subjects::where('classId',$class)->where('status','active')->select('name','id')->get();
	    $classCategory=Category::where('parent_class',$class)->where('subject',$subject)->where('status','active')->select('category_name','id')->get();
	    return Response::json(['status'=>'success','name'=>$name,'type'=>$type,'description'=>$description,'parent'=>$parent,'class'=>$class,'subject'=>$subject,'code'=>$code,'classSubjects'=>$classSubjects,'classCategory'=>$classCategory]);
	}

	public function editcategorypost(Request $req){
	    $input=$req->all();
	    $rules=['categoryType'=>'required'];
	    $validation=Validator::make($input,$rules);
	    if($validation->fails()){
	      return back()->withErrors($validation,'edit')->withInput()->with('categoryerror','edit_row');
	    }
	    if($input['categoryType']==1){
	    	$rules=['subject'=>'required','categoryName'=>'required','class'=>'required','categoryCode'=>'required|unique:categories,code,'.$input["editId"].',id,status,active'];
	    }else{
	    	$rules=['categoryName'=>'required','parentCategory'=>'required','categoryCode'=>'required|unique:sub_categories,code,'.$input["editId"].',id,status,active'];
	    }
	    $validation= Validator::make($input,$rules);
	    if($validation->fails()){
	      return back()->withErrors($validation,'edit')->withInput()->with('categoryerror','edit_row');
	    }
	    if($input['categoryType']==1){
	    	$update=Category::find($input['editId']);
	    	$update->code=$input['categoryCode'];
		    $update->category_name=$input['categoryName'];
		    $update->parent_class=$input['class'];
		    $update->subject=$input['subject'];
		    $update->created_by=Auth::user()->id;
		    $update->status='active';
		    $update->description=$input['description'];
		    $update->save();
	    }elseif($input['categoryType']==2){
	    	$update=Subcategory::find($input['editId']);
	    	$update->code=$input['categoryCode'];
		    $update->name=$input['categoryName'];
		    $update->parent=$input['parentCategory'];
		    $update->description=$input['description'];
		    $update->created_by=Auth::user()->id;
		    $update->status='active';
		    $update->save();
	    }
	    return back()->with('success','Category details updated successfully.')->with('categoryerror','edit_row')->withInput();
	}

	public function deletecategorypost(Request $req){
		$input=$req->all();
	    $records=json_decode($input['records']);
	    foreach($records as $record){
	    	$id=$record->id;
	    	$type=$record->type;
	    	if($type=='main'){
	    		Category::where('id',$id)->update(['status'=>'deleted']);
	    	}elseif($type=='sub'){
	    		Subcategory::where('id',$id)->update(['status'=>'deleted']);
	    	}
	    }
	    return Response::json(['status'=>'success']);
	}

	public function staffget(){
		$country=Country::where('status','active')->orderBy('name')->lists('name','id');
	    $records=Staff::where('status','!=','deleted')->get();
	    $records=[];
	    return view('staff')->with('records',$records)->with('country',$country);
	}

	public function addstaffpost(Request $req){
		$input = $req->all();
	    $rules = ['staffCode'=>'required|unique:staff,code,NULL,id,status,active','fullname'=>'required','email'=>'required|email|unique:staff,email,NULL,id,status,active','gender'=>'required','loginId'=>'required|unique:users,user_id,NULL,id,status,active','password' => 'required|min:6|max:15','confirmPassword' => 'required|min:6|max:15|same:password','staffPic'=>'image|mimes:png,jpeg,jpg','country'=>'required'];
	    $validation = Validator::make($input,$rules);
	    if($validation->fails()){
	      return back()->withErrors($validation,'add')->withInput()->with('stafferror','add_row');
	    }
	    $staffPic = "";
	    if($req->hasFile('staffPic')){
	    	$file = $req->file('staffPic');
          	$destinationPath = 'uploads/';
          	$extension = $file->getClientOriginalExtension();
          	$filename = str_random(12).".{$extension}";
          	$upload_success = $file->move($destinationPath, $filename);
          	$staffPic = URL::asset($destinationPath.$filename);
	    }
	    $insert = new Staff();
	    $insert->code=$input['staffCode'];
	    $insert->fullname=$input['fullname'];
	    $insert->email=$input['email'];
	    $insert->gender=$input['gender'];
	    if($input['dob']!=''){
	    	$insert->dob=date('Y-m-d',strtotime($input['dob']));
	    }
	    $insert->mobile=$input['mobile'];
	    $insert->address=$input['address'];
	    $insert->countryId=$input['country'];
	    $insert->createdBy=Auth::user()->id;
	    $insert->status='active';
	    $insert->save();

	    for($i=1;$i<=3;$i++){
            $setting = new Appsetting();
            $setting->userid = $insert->id;
            $setting->preference = $i;
            $setting->value = 1;
            $setting->save();
        }

	    $insertUser=new User();
	    $insertUser->full_name=$input['fullname'];
	    $insertUser->user_id=$input['loginId'];
	    $insertUser->profile_picture = $staffPic;
	    $insertUser->password=Hash::make($input['password']);
	    $insertUser->email=$input['email'];
	    $insertUser->status='active';
	    $insertUser->type='staff';
	    $insertUser->userLink=$insert->id;
	    $insertUser->save();

	    // Mail::Send([], [], function($message) use($input){
     //    	$message->from(Options::getvalue('senderEmail') , Options::getvalue('senderName'));
     //        $message->to($input['email'],"Elearning Login Details")->subject('Elearning Login Details')->setBody("Dear ".$input['fullname'].",\n You have been registered successfully in elearning portal. \n Your login credentials are as follows, Login ID : ".$input['loginId']."\n Password : ".$input['password']);
     //  	});

	    return Redirect::to('admin/staff/get')->with('success','New staff added successfully.')->with('stafferror','add_row');
	}

	public function deletestaffpost(Request $req){
		$input=$req->all();
	    $ids=json_decode($input['ids']);
	    Staff::whereIn('id',$ids)->update(['status'=>'deleted']);
	    User::whereIn('userLink',$ids)->update(['status'=>'deleted']);
	    return Response::json(['status'=>'success']);
	}

	public function getstaffpost(Request $req){
	   	$id = $req->input('editId');
	    $record= Staff::where('id',$id)->first();
	    $user = User::where("userLink", $id)->first();
	    $fullname='';
	    $email='';
	    $gender='';
	    $dob='';
	    $mobile='';
	    $address='';
	    $code='';
	    $profilePic = '';
	    $country='';
	    if(count($record)==1 || count($user) == 1){
	    	$fullname=$record->fullname;
	    	$email=$record->email;
	    	$gender=$record->gender;
	    	if($record->dob!=''){
	    		$dob=date('d-m-Y',strtotime($record->dob));
	    	}
	    	$mobile=$record->mobile;
	    	$address=$record->address;
	    	if($user->profile_picture!=''){
	    		$profilePic=$user->profile_picture;
	    	}
	    	$code=$record->code;
	    	$country=$record->countryId;
	    }
	    return Response::json(['status'=>'success','fullname'=>$fullname,'email'=>$email,'gender'=>$gender,'dob'=>$dob,'mobile'=>$mobile,'address'=>$address,'profilePic'=>$profilePic,'code'=>$code,'country'=>$country]);
	}

	public function editstaffpost(Request $req){
	    $input=$req->all();
	    $rules=['staffCode'=>'required|unique:staff,code,'.$input["editId"].',id,status,active','fullname'=>'required','email'=>'required|email|unique:staff,email,'.$input['editId'].',id,status,active','gender'=>'required','country'=>'required'];
	    $validation= Validator::make($input,$rules);
	    if($validation->fails()){
	      return back()->withErrors($validation,'edit')->withInput()->with('stafferror','edit_row');
	    }
	    if($req->hasFile('editProfilePic')){
	    	$file = $req->file('editProfilePic');
          	$destinationPath = 'img/';
          	$extension = $file->getClientOriginalExtension();
          	$filename = str_random(12).".{$extension}";
          	$upload_success = $file->move($destinationPath, $filename);
          	$staffPic = URL::asset($destinationPath.$filename);
          	$update=User::where('userLink',$input['editId'])->update(['profile_picture'=>$staffPic]);
	    }
	    $update=Staff::find($input['editId']);
	    $update->code=$input['staffCode'];
	    $update->fullname=$input['fullname'];
	    $update->email=$input['email'];
	    $update->gender=$input['gender'];
	    $update->countryId=$input['country'];
	    if($input['dob']!=''){
	    	$update->dob=date('Y-m-d',strtotime($input['dob']));
	    }else{
	    	$update->dob=NULL;
	    }
	    
	    $update->mobile=$input['mobile'];
	    $update->address=$input['address'];
	    $update->save();

	    $update=User::where('userLink',$input['editId'])->update(['full_name'=>$input['fullname'],'email'=>$input['email']]);

	    
	    return back()->with('success','Staff details updated successfully.')->with('stafferror','edit_row')->with('currentID',$input['editId'])->withInput();
	}


	public function studentget(){
		$country=Country::where('status','active')->lists('name','id');
	    $records=Students::where('status','!=','deleted')->get();
	    return view('students')->with('records',$records)->with('country',$country);
	}

	public function addstudentpost(Request $req){
		$input=$req->all();
	    $rules=['studentCode'=>'required|unique:students,code,NULL,id,status,active','fullname'=>'required','email'=>'required|email|unique:students,email,NULL,id,status,active','gender'=>'required','loginId'=>'required|unique:users,user_id,NULL,id,status,active','password' => 'required|min:6|max:15','confirmPassword' => 'required|min:6|max:15|same:password'];
	    $validation= Validator::make($input,$rules);
	    if($validation->fails()){
	      return back()->withErrors($validation,'add')->withInput()->with('studenterror','add_row');
	    }

		$studentPic = "";
	    if($req->hasFile('studentPic')){
	    	$file = $req->file('studentPic');
          	$destinationPath = 'uploads/';
          	$extension = $file->getClientOriginalExtension();
          	$filename = str_random(12).".{$extension}";
          	$upload_success = $file->move($destinationPath, $filename);
          	$studentPic = URL::asset($destinationPath.$filename);
	    }

	    $insert = new Students();
	    $insert->code=$input['studentCode'];
	    $insert->fullname=$input['fullname'];
	    $insert->email=$input['email'];
	    $insert->gender=$input['gender'];
	    if($input['dob']!=''){
	    	$insert->dob=date('Y-m-d',strtotime($input['dob']));
	    }
	    $insert->mobile=$input['mobile'];
	    $insert->address=$input['address'];
	    if($input['country']!=''){
	    	$insert->countryId=$input['country'];
	    }else{
	    	$insert->countryId=NULL;
	    }
	    $insert->createdBy=Auth::user()->id;
	    $insert->status='active';
	    $insert->save();

	    $insertUser=new User();
	    $insertUser->full_name=$input['fullname'];
	    $insertUser->user_id=$input['loginId'];
	    $insertUser->password=Hash::make($input['password']);
	    $insertUser->profile_picture = $studentPic;
	    $insertUser->email=$input['email'];
	    $insertUser->status='active';
	    $insertUser->type='student';
	    $insertUser->userLink=$insert->id;
	    $insertUser->save();

	    // Mail::Send([],[],function($message) use($input){
     //    $message->from(Options::getvalue('senderEmail') , Options::getvalue('senderName'));
     //          $message->to($input['email'],"Elearning Login Details")->subject('Elearning Login Details')->setBody("Dear ".$input['fullname'].",\n You have been registered successfully in elearning portal. \n Your login credentials are as follows, Login ID : ".$input['loginId']."\n Password : ".$input['password']);
     //  	});

	    return Redirect::to('admin/student/get')->with('success','New student added successfully.')->with('studenterror','add_row');
	}

	public function deletestudentpost(Request $req){
		$input=$req->all();
	    $ids=json_decode($input['ids']);
	    Students::whereIn('id',$ids)->update(['status'=>'deleted']);
	    User::whereIn('userLink',$ids)->update(['status'=>'deleted']);
	    return Response::json(['status'=>'success']);
	}

	public function getstudentpost(Request $req){
	    $id= $req->input('editId');
	    $record= Students::where('id',$id)->first();
	    $fullname='';
	    $email='';
	    $gender='';
	    $dob='';
	    $mobile='';
	    $address='';
	    $code='';
	    $country='';
	    if(count($record)==1){
	    	$fullname=$record->fullname;
	    	$email=$record->email;
	    	$gender=$record->gender;
	    	if($record->dob!=''){
	    		$dob=date('d-m-Y',strtotime($record->dob));
	    	}
	    	$mobile=$record->mobile;
	    	$address=$record->address;
	    	$code=$record->code;
	    	$country=$record->countryId;
	    }
	    return Response::json(['status'=>'success','fullname'=>$fullname,'email'=>$email,'gender'=>$gender,'dob'=>$dob,'mobile'=>$mobile,'address'=>$address,'code'=>$code,'country'=>$country]);
	}

	public function editstudentpost(Request $req){
	    $input=$req->all();
	    $rules=['studentCode'=>'required|unique:students,code,'.$input["editId"].',id,status,active','fullname'=>'required','email'=>'required|email|unique:students,email,'.$input['editId'].',id,status,active','gender'=>'required'];
	    $validation= Validator::make($input,$rules);
	    if($validation->fails()){
	      return back()->withErrors($validation,'edit')->withInput()->with('studenterror','edit_row');
	    }
	    $update=Students::find($input['editId']);
	    $update->code=$input['studentCode'];
	    $update->fullname=$input['fullname'];
	    $update->email=$input['email'];
	    $update->gender=$input['gender'];
	    if($input['dob']!=''){
	    	$update->dob=date('Y-m-d',strtotime($input['dob']));
	    }
	    if($input['country']!=''){
	    	$update->countryId=$input['country'];
	    }else{
	    	$update->countryId=NULL;
	    }
	    $update->mobile=$input['mobile'];
	    $update->address=$input['address'];
	    $update->save();

	    $update=User::where('userLink',$input['editId'])->update(['full_name'=>$input['fullname'],'email'=>$input['email']]);
	    return back()->with('success','Student details updated successfully.')->with('studenterror','edit_row')->withInput();
	}

	public function groupsget(){
		$countryBased=Options::getvalue('countryBased');
		$staffCountry=Staff::getstaffcountry(Auth::user()->userLink);
	    $records=Group::where('status','!=','deleted');
	    if(Auth::user()->type=='staff'){
	    	$records=$records->where('group_admin',Auth::user()->id);
	    }
	    if($countryBased=='yes' && Auth::user()->type=='staff'){
	    	$records=$records->where('countryId',$staffCountry);
	    }
	    $records=$records->get();
	    $students=Students::where('status','active');
	    if($countryBased=='yes' && Auth::user()->type=='staff'){
	    	$students=$students->where('countryId',$staffCountry);
	    }
	    $students=$students->lists('fullname','id');
	    $country=Country::where('status','active')->orderBy('name')->lists('name','id');
	    return view('groups')->with('records',$records)->with('students',$students)->with('country',$country);
	}


	public function usersget(){
	    $records=User::where('status','!=','deleted')->where('id','!=',1)->get();
	    return view('users')->with('records',$records);
	}

	public function addgroupspost(Request $req){
	    $input=$req->all();
	    $rules=['groupCode'=>'required|unique:groups,code,NULL,id,status,active','groupName'=>'required'];
	    $validation= Validator::make($input,$rules);
	    if($validation->fails()){
	      return back()->withErrors($validation,'add')->withInput()->with('groupserror','add_row');
	    }
	    $insert=new Group();
	    if($input['country']!=''){
	    	$insert->countryId=$input['country'];
	    }
	    $insert->code=$input['groupCode'];
	    $insert->group_name=$input['groupName'];
	    $insert->group_name_slug=str_slug($input['groupName'],'_');
	    $insert->group_short_description=$input['shortDescription'];
	    $insert->group_long_description=$input['longDescription'];
	    $insert->group_admin=Auth::user()->id;
	    if(count($input['students'])>0){
	    	$insert->students=implode(',',$input['students']);
	    }
	    if($req->has('acceptance_mandatory')){
	    	$insert->acceptance_mandatory='no';
	    }else{
	    	$insert->acceptance_mandatory='yes';
	    }
	    $insert->status='active';
	    $insert->save();
	    return Redirect::to('admin/groups/get')->with('success','New group added successfully.')->with('groupserror','add_row');
	}

	public function getgroupspost(Request $req){
	    $id= $req->input('editId');
	    $record= Group::where('id',$id)->first();
	    $name='';
	    $short='';
	    $long='';
	    $code='';
	    $acceptance='no';
	    $country='';
	    $students=[];
	    $countryStudents=[];
	    $countryBased=Options::getvalue('countryBased');
	    if(count($record)==1){
	    	$name=$record->group_name;
	    	$short=$record->group_short_description;
	    	$long=$record->group_long_description;
	    	$code=$record->code;
	    	if($record->students!=''){
	    		$students=explode(',',$record->students);
	    	}
	    	$acceptance=$record->acceptance_mandatory;
	    	$country=$record->countryId;
	    	if($record->countryId!=''){
	    		$countryStudents=Students::where('status','active')->where('countryId',$record->countryId)->lists('fullname','id');
		    }else{
		    	$countryStudents=Students::where('status','active')->lists('fullname','id');
		    }
	    }else{
	    	$countryStudents=Students::where('status','active')->lists('fullname','id');
	    }
	    
	    
	    return Response::json(['status'=>'success','name'=>$name,'short'=>$short,'long'=>$long,'code'=>$code,'students'=>$students,'acceptance'=>$acceptance,'countryStudents'=>$countryStudents,'country'=>$country]);
	}

	public function editgroupspost(Request $req){
	    $input=$req->all();
	    $rules=['groupCode'=>'required|unique:groups,code,'.$input["editId"].',id,status,active','groupName'=>'required'];
	    $validation= Validator::make($input,$rules);
	    if($validation->fails()){
	      return back()->withErrors($validation,'edit')->withInput()->with('groupserror','edit_row');
	    }
	    $update=Group::find($input['editId']);
	    if($input['country']!=''){
	    	$update->countryId=$input['country'];
	    }else{
	    	$update->countryId=NULL;
	    }
	    $update->code=$input['groupCode'];
	    $update->group_name=$input['groupName'];
	    $update->group_name_slug=str_slug($input['groupName'],'_');
	    $update->group_short_description=$input['shortDescription'];
	    $update->group_long_description=$input['longDescription'];
	    if(isset($input['students']) && count($input['students'])>0){
	    	$update->students=implode(',',$input['students']);
	    }
	    if($req->has('acceptance_mandatory')){
	    	$update->acceptance_mandatory='no';
	    }else{
	    	$update->acceptance_mandatory='yes';
	    }
	    $update->save();
	    return back()->with('success','Group details updated successfully.')->with('groupserror','edit_row')->withInput();
	}

	public function deletegroupspost(Request $req){
		$input=$req->all();
	    $ids=json_decode($input['ids']);
	    $delete=Group::whereIn('id',$ids)->update(['status'=>'deleted']);
	    return Response::json(['status'=>'success']);
	}

	public function deleteuserspost(Request $req){
		$input=$req->all();
	    $ids=json_decode($input['ids']);
	    $delete=User::whereIn('id',$ids)->update(['status'=>'deleted']);
	    return Response::json(['status'=>'success']);
	}

	public function assigncourseget($id=null,$panel='course',$course=''){
		$countryBased=Options::getvalue('countryBased');
		$staffCountry=Staff::getstaffcountry(Auth::user()->userLink);
	    $groups=Group::where('group_admin',Auth::user()->id)->where('status','active');
	    if($countryBased=='yes'){
	    	$groups=$groups->where('countryId',$staffCountry);
	    }
	    $groups=$groups->get();

	    $reqId='';
	    if($id==null){
	    	$record=Group::where('group_admin',Auth::user()->id)->where('status','active');
	    	if($countryBased=='yes'){
		    	$record=$record->where('countryId',$staffCountry);
		    }
		    $record=$record->first();
	    	if(count($record)==1){
	    		$reqId=$record->id;
	    	}
	    }else{
	    	$reqId=$id;
	    }
	    $detail=[];
	   	if($reqId!=''){
	   		$detail=Group::find($reqId);
	   	}
	    $staffcourses=Groupcourse::where('status','inactive')->where('admin',Auth::user()->id)->lists('course_name','id');
	    return view('assignCourse')->with('groups',$groups)->with('groupId',$reqId)->with('panel',$panel)->with('detail',$detail)->with('courseId',$course)->with('staffcourses',$staffcourses);
	}

	public function getclasssubjects(Request $req){
		$classId=$req->input('val');
		$subjects=Subjects::where('classId',$classId)->where('status','active')->select('name','id')->get();
		return Response::json(['subjects'=>$subjects]);
	}

	public function getclasscategory(Request $req){
		$classId=$req->input('classId');
		$subjectId=$req->input('subject');
		$category=Category::where('parent_class',$classId)->where('subject',$subjectId)->where('status','active')->select('category_name','id')->get();
		return Response::json(['category'=>$category]);
	}

	public function getcategorysub(Request $req){
		$categoryId=$req->input('val');
		$subcategory=Subcategory::where('parent',$categoryId)->where('status','active')->select('name','id')->get();
		return Response::json(['subcategory'=>$subcategory]);
	}

	public function getsubcategorycourses(Request $req){
		$subcategory=$req->input('sub');
		$class=$req->input('class');
		$category=$req->input('category');
		$groupId=$req->input('groupId');
		$subject=$req->input('subject');
		$assignedCourses=Groupcourse::where('group_id',$groupId)->lists('course_id');
		$courses=Courses::where('class_id',$class)->where('subject',$subject)->whereNotIn('id',$assignedCourses)->where('status','active');
		if($category!=''){
			$courses=$courses->where('category',$category);
		}
		if($subcategory!=''){
			$courses=$courses->where('subcategory',$subcategory);
		}
		$courses=$courses->select('name','id')->get();
		return Response::json(['courses'=>$courses]);
	}

	public function getsubcategoryallcourses(Request $req){
		$subcategory=$req->input('sub');
		$class=$req->input('class');
		$category=$req->input('category');
		$groupId=$req->input('groupId');
		$courses=Courses::where('class_id',$class)->where('category',$category)->where('subcategory',$subcategory)->where('status','active')->select('name','id')->get();
		return Response::json(['courses'=>$courses]);
	}

	public function addassigncoursepost(Request $req){
		$input=$req->all();
	    $rules=['course'=>'required'];
	    $validation= Validator::make($input,$rules);
	    if($validation->fails()){
	      return Redirect::to('admin/assign/course/get/'.$input['groupId'].'/course/')->withErrors($validation,'add')->withInput()->with('classerror','add_row_course');
	    }
	    $new = Groupcourse::find($input['course']);
		$new->group_id = $input['groupId'];
	    if($req->has('studentAcceptance')){
	    	$new->acceptance_mandatory='no';
	    }else{
	    	$new->acceptance_mandatory='yes';
	    }
	    
	    $new->status='active';
		$new->save();

		if($req->has('sendnotification')){
			$record=Group::find($input['groupId']);
			if(count($record)==1 && $record->students!=''){
				$students=explode(',',$record->students);
				foreach($students as $student){
					$insert=new GroupMember();
					$insert->group_course_id=$new->id;
					$insert->groupid=$new->group_id;
					$insert->courseid=$new->course_id;
					$insert->studentid=$student;
					$insert->added_by=Auth::user()->id;
					$insert->added_on=time();
					if($req->has('studentAcceptance')){
						$insert->status='active';
					}else{
						$insert->status='inactive';
					}
					
					$insert->save();
					Group::find($new->group_id)->increment('member_count');		


					/* Push notifications */
	                $userinfo = User::where('userLink',$insert->studentid)->first();
	                if($userinfo->deviceToken != ''){
	                    $notificationMessage = ($new->acceptance_mandatory == 'yes') ? 'You have been invited to join a course' : 'A new course has been assigned to you';
	                    $payload = (object) array('type' => 'invite');
	                    $platform = ($userinfo->platform == 'android') ? 1 : 0;
	                    $data = array('platform' => $platform, 
	                                  'token' => $userinfo->deviceToken,
	                                  'msg'=> $notificationMessage,
	                                  'payload' => $payload);

	                    // use key 'http' even if you send the request to https://...
	                    $options = array(
	                        'http' => array(
	                            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n" .
	                                         "X-PUSHBOTS-APPID: ".env('PUSHBOTS_ID')."\r\n" .
	                                         "X-PUSHBOTS-SECRET: ".env('PUSHBOTS_SECRET')."\r\n",
	                            'method'  => 'POST',
	                            'content' => http_build_query($data),
	                        ),
	                    );
	                    $context  = stream_context_create($options);
	                    file_get_contents(env('PUSH_URL'), false, $context);
	                }
	                /* End push notifications*/	
				}
			}
		}
		
		Group::find($new->group_id)->increment('course_count');
	    return Redirect::to('admin/assign/course/get/'.$input['groupId'].'/students/'.$new->course_id)->with('courseSuccess','New course assigned successfully.')->with('courseId',$new->course_id);
	}


	public function addassignmemberspost(Request $req){
		$students=$req->input('students');
		$groupId=$req->input('groupId');
		$courseId=$req->input('courseId');
		$groupDetails=Group::find($groupId);
		$record=Groupcourse::where('group_id',$groupId)->where('course_id',$courseId)->where('admin',Auth::user()->id)->first();
		if(count($record)==1){
			if($students!=''){
				$students=explode(',',$students);
				foreach($students as $student){
					$insert=new GroupMember();
					$insert->group_course_id=$record->id;
					$insert->groupid=$groupId;
					$insert->courseid=$courseId;
					$insert->studentid=$student;
					$insert->added_by=Auth::user()->id;
					$insert->added_on=time();
					if($record->acceptance_mandatory=='yes'){
						$insert->status='inactive';
					}else{
						$insert->status='active';
					}
					$insert->save();

					/* Push notifications */
			            $userinfo = User::where('userLink',$insert->studentid)->first();
			            if($userinfo->deviceToken != ''){
			                $payload = (object) array('type' => 'invite');
			                $platform = ($userinfo->platform == 'android') ? 1 : 0;
			                $data = array('platform' => $platform, 
			                              'token' => $userinfo->deviceToken,
			                              'msg'=> 'You have been invited to join a course',
			                              'payload' => $payload);

			                // use key 'http' even if you send the request to https://...
			                $options = array(
			                    'http' => array(
			                        'header'  => "Content-Type: application/x-www-form-urlencoded\r\n" .
			                                     "X-PUSHBOTS-APPID: ".env('PUSHBOTS_ID')."\r\n" .
			                                     "X-PUSHBOTS-SECRET: ".env('PUSHBOTS_SECRET')."\r\n",
			                        'method'  => 'POST',
			                        'content' => http_build_query($data),
			                    ),
			                );
			                $context  = stream_context_create($options);
			                file_get_contents(env('PUSH_URL'), false, $context);
			            }
			        /* End push notifications*/
				}
			}
		}
		return Redirect::to('admin/assign/course/get/'.$groupId.'/'.'students/'.$courseId)->with('studentSuccess','New students invited successfully');
	}

	public function addassigntaskpost(Request $req){
		$input=$req->all();
	    $rules=['shortDescription'=>'required|max:50','course'=>'required','message'=>'required','dueDate'=>'required','youtubeLink'=>'url'];
	    $validation= Validator::make($input,$rules);
	    if($validation->fails()){
	      return Redirect::to('admin/assign/course/get/'.$input['groupId'].'/'.'task/'.$input['course'])->withErrors($validation,'add')->withInput()->with('classerror','add_row_task');
	    }
	    $insert=new GroupPost();
	    $insert->group_id=$input['groupId'];
	    $insert->course_id=$input['course'];
	    $insert->post_type='task';
	    $insert->author=Auth::user()->id;
	    $insert->text=$input['message'];
	    $insert->dueDate=date('Y-m-d',strtotime($input['dueDate']));
	    $insert->short_description=$input['shortDescription'];
	    $insert->time=time();
	    $insert->save();

	    $insertMeta=new GroupPostMeta();
	    $insertMeta->courseid=$input['course'];
	    $insertMeta->postid=$insert->id;
	    $insertMeta->video_url=$input['youtubeLink'];
	    $insertMeta->due_date=strtotime($input['dueDate']);
	    $insertMeta->save();
	    return Redirect::to('admin/assign/course/get/'.$input['groupId'].'/'.'task/'.$input['course'])->with('taskSuccess','New task added successfully');
	}

	public function getcoursetasks(Request $req){
		$input=$req->all();
		$tasks=GroupPost::where('post_type','task')->where('group_id',$input['groupId'])->where('course_id',$input['course'])->get();
		$taskCount=count($tasks);
		$html='';
		if($taskCount>0){
			foreach($tasks as $task){
				$userName=User::find($task->author)->fullname;
				$comments=GroupComment::where('postid',$task->id)->get();
				$html.='<div class="panel panel-default "><div class="panel-body status">
	              <ul class="panel-tools panel-tools-hover">
	                <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
	                <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
	              </ul>
	              
	              <div class="who clearfix">
	                <img src="'.User::getprofileimage($task->author).'" alt="img">
	                <span class="name"><b>'.$userName.'</b> </span>
	                <span class="from">at <b>'.date("d M Y, H:i A",$task->time).'</b></span>
	              </div>
	              <div class="text">'.$task->text.'</div>
	              <ul class="links">
	                <li><a href="#"><i class="fa fa-comment-o"></i>'.count($comments).' Comment</a></li>
	              </ul>';
	              $html.='<ul class="comments">';

	              if(count($comments)>0){
	              	foreach($comments as $comment){
	              		$userName=User::find($task->author)->fullname;
	              		$html.='<li>
	                  <img src="'.User::getprofileimage($comment->commenter).'" alt="img">
	                  <span class="name">'.$userName.'</span>
	                  '.$comment->comment.'
	                </li>';
	              	}
	              }

	              $html.='<li>
                  <img src="'.Auth::user()->profile_picture.'" alt="img">
                  <input type="text" class="form-control comment'.$task->id.'" placeholder="Post your comment...">
                  <input type="button" class="saveComment" id="'.$task->id.'" data-panel="task" value="Submit">
                </li>';
                $html.='</ul>';

	              $html.='</div></div>';
			}
		}else{
			$html.='<div class="kode-alert kode-alert-icon alert6-light">
            <i class="fa fa-lock"></i>
            <a href="#" class="closed">×</a>
            No task available.
          </div>';
		}

		return Response::json(['status'=>'success','html'=>$html]);
	}


	public function addassigndiscussionpost(Request $req){
		$input=$req->all();
	    $insert=new Discussion();
	    $insert->groupId=$input['groupId'];
	    $insert->message=$input['message'];
	    $insert->userId=Auth::user()->id;
	    $insert->time=time();
	    $insert->save();
	    $html='';
	    $discussions=Discussion::where('groupId',$input['groupId'])->where('id','<',$insert->id)->orderBy('id','DESC')->first();
	    if(count($discussions)==1){
	    	$previousDate=date('Y-m-d',$discussions->time);
	    	$previousUser=$discussions->userId;
	    	$currentUser=Auth::user()->id;
	    	$currentDate=date('Y-m-d');
	    	if($previousDate!=$currentDate){
	    		$html.='<li class="date"><b>'.date('F d',$insert->time).'</b></li>';
	    	}
	    	$html.='<li> <p class="ballon color1">';

	    	if($previousUser!=$currentUser){
	    		$html.='<span style="color:red">'.Auth::user()->full_name.'</span></br>';
	    	}
	    	$html.=$insert->message.'</br> <span>'.date('h:i A',$insert->time).'</span></p><br></li>';
	    }else{
	    	$html.='<li class="date"><b>'.date('F d',$insert->time).'</b></li>
	    			<li> <p class="ballon color1">
	    				<span style="color:red">'.Auth::user()->full_name.'</span></br>'.$insert->message.'</br> 
	    				<span>'.date('h:i A',$insert->time).'</span></p><br>
	    			</li>';
	    }



	    if($input['type'] == 'student'){
            $admin = Group::find($insert->groupId)->group_admin;
            $userinfo = User::find($admin);
            if($userinfo->deviceToken != ''){
                $payload = (object) array('type' => 'discussion', 'groupid'=>$insert->groupId);
                $platform = ($userinfo->platform == 'android') ? 1 : 0;
                $data = array('platform' => $platform, 
                              'token' => $userinfo->deviceToken,
                              'msg'=> 'New Message: '.substr($input['message'],0,30).'...',
                              'payload' => $payload);

                // use key 'http' even if you send the request to https://...
                $options = array(
                    'http' => array(
                        'header'  => "Content-Type: application/x-www-form-urlencoded\r\n" .
                                     "X-PUSHBOTS-APPID: ".env('PUSHBOTS_ID')."\r\n" .
                                     "X-PUSHBOTS-SECRET: ".env('PUSHBOTS_SECRET')."\r\n",
                        'method'  => 'POST',
                        'content' => http_build_query($data),
                    ),
                );
                $context  = stream_context_create($options);
                file_get_contents(env('PUSH_URL'), false, $context);
            }
        }

        $me = User::find($insert->userId)->userLink;
        $students = GroupMember::where('groupid',$insert->groupId)->where('status','active')->groupBy('studentid')->pluck('studentid');

        foreach($students as $std){
            if($std != '' and $std != $me){
                /* Push notifications */
                $userinfo = User::where('userLink',$std)->first();
                if($userinfo->deviceToken != ''){
                    $payload = (object) array('type' => 'discussion', 'groupid'=>$insert->groupId);
                    $platform = ($userinfo->platform == 'android') ? 1 : 0;
                    $data = array('platform' => $platform, 
                                  'token' => $userinfo->deviceToken,
                                  'msg'=> 'New Message: '.substr($input['message'],0,30).'...',
                                  'payload' => $payload);

                    // use key 'http' even if you send the request to https://...
                    $options = array(
                        'http' => array(
                            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n" .
                                         "X-PUSHBOTS-APPID: ".env('PUSHBOTS_ID')."\r\n" .
                                         "X-PUSHBOTS-SECRET: ".env('PUSHBOTS_SECRET')."\r\n",
                            'method'  => 'POST',
                            'content' => http_build_query($data),
                        ),
                    );
                    $context  = stream_context_create($options);
                    file_get_contents(env('PUSH_URL'), false, $context);
                }
                /* End push notifications*/
            }
        }

	    return Response::json(['html'=>$html]);
	}

	public function addtaskcommentpost(Request $req){
		$input=$req->all();
		$insert=new GroupComment();
		$insert->postid=$input['postId'];
		$insert->commenter=Auth::user()->id;
		$insert->comment=$input['message'];
		$insert->time=time();
		$insert->save();
		if($req->has('loginUser')){
			$url=URL::to('admin/student/assign/course/get/'.$input['groupId'].'/'.$input['panel'].'/'.$input['courseId']);
		}else{
			$url=URL::to('admin/assign/course/get/'.$input['groupId'].'/'.$input['panel'].'/'.$input['courseId']);
		}
		
		return Response::json(['status'=>'success','url'=>$url]);
	}


	public function getcoursediscussion(Request $req){
		$input=$req->all();
		$discussions=GroupPost::where('post_type','text')->where('group_id',$input['groupId'])->where('course_id',$input['course'])->get();
		$discussionCount=count($discussions);
		$html='';
		if($discussionCount>0){
			foreach($discussions as $discussion){
				$userName=User::find($discussion->author)->fullname;
				$comments=GroupComment::where('postid',$discussion->id)->get();
				$html.='<div class="panel-body status">
	              <ul class="panel-tools panel-tools-hover">
	                <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
	                <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
	              </ul>
	              
	              <div class="who clearfix">
	                <img src="'.User::getprofileimage($discussion->author).'" alt="img">
	                <span class="name"><b>'.$userName.'</b> </span>
	                <span class="from">at <b>'.date("d M Y, H:i A",$discussion->time).'</b></span>
	              </div>
	              <div class="text">'.$discussion->text.'</div>
	              <ul class="links">
	                <li><a href="#"><i class="fa fa-comment-o"></i>'.count($comments).' Comment</a></li>
	              </ul>';
	              $html.='<ul class="comments">';

	              if(count($comments)>0){
	              	foreach($comments as $comment){
	              		$userName=User::find($discussion->author)->fullname;
	              		$html.='<li>
	                  <img src="'.User::getprofileimage($comment->commenter).'" alt="img">
	                  <span class="name">'.$userName.'</span>
	                  '.$comment->comment.'
	                </li>';
	              	}
	              }

	              $html.='<li>
                  <img src="'.Auth::user()->profile_picture.'" alt="img">
                  <input type="text" class="form-control comment'.$discussion->id.'" placeholder="Post your comment...">
                  <input type="button" class="saveComment" id="'.$discussion->id.'" data-panel="discussion" value="Submit">
                </li>';
                $html.='</ul>';

	              $html.='</div>';
			}
		}else{
			$html.='<div class="kode-alert kode-alert-icon alert6-light">
            <i class="fa fa-lock"></i>
            <a href="#" class="closed">×</a>
            No task available.
          </div>';
		}

		return Response::json(['status'=>'success','html'=>$html]);
	}

	public function importcategoryget(){
		return view('importCategory');
	}

	public function importcategorypost(Request $req)
    {
	    $input = $req->all();
	    $rules = ["importFile"=>"required|mimes:xls,xlsx"];
	    $validation = Validator::make($input,$rules);
	    if($validation->fails())
	    {
	      return redirect('admin/import/category/get')->withInput()->withErrors($validation);
	    }
		$path = $req->file('importFile')->getRealPath();
		$data = Excel::load($path, function($reader) { })->get();
		if(!empty($data) && $data->count()){
			foreach($data as $key=>$value){
				$class=$value->class;
				$subject=$value->subject;
				$parent=$value->parent_category;
				$code=$value->code;
				$name=$value->name;
				if($class==''){
					return back()->with('failed','Please enter value in class field.');
				}
				
				if($subject==''){
					return back()->with('failed','Please enter value in subject field.');
				}

				if($code==''){
					return back()->with('failed','Please enter value in code field.');
				}

				if($name==''){
					return back()->with('failed','Please enter value in name field.');
				}

			}
			foreach ($data as $key => $value) {
				$class=$value->class;
				$subject=$value->subject;
				$parent=$value->parent_category;
				$code=$value->code;
				$name=$value->name;
				$description=$value->description;

				$classId='';
				$subjectId='';
				$record=Classname::where('code',$class)->first();
				if(count($record)==1){
					$classId=$record->id;
				}

				$record=Subjects::where('code',$subject)->first();
				if(count($record)==1){
					$subjectId=$record->id;
				}

				if($parent==''){
			    	$insert=new Category();
			    	$insert->code=Category::autogeneratecode();
				    $insert->category_name=$name;
				    $insert->parent_class=$classId;
				    $insert->subject=$subjectId;
				    $insert->created_by=Auth::user()->id;
				    $insert->status='active';
				    $insert->description=$description;
				    $insert->save();
			    }else{

			    	$parentId='';
					$record=Category::where('code',$parent)->first();
					if(count($record)==1){
						$parentId=$record->id;
					}

			    	$insert=new Subcategory();
			    	$insert->code=Subcategory::autogeneratecode();
				    $insert->name=$name;
				    $insert->parent=$parentId;
				    $insert->description=$description;
				    $insert->created_by=Auth::user()->id;
				    $insert->status='active';
				    $insert->save();
			    }
			}
		}
	    return redirect('admin/import/category/get')->with('success','Excel file imported successfully.');
	}

	public function importcoursesget(){
		return view('importCourses');
	}

	public function importcoursespost(Request $req)
    {
    	ini_set('max_execution_time', 3000000);
	    $input = $req->all();
	    $rules = ["importFile"=>"required|mimes:xls,xlsx"];
	    $validation = Validator::make($input,$rules);
	    if($validation->fails())
	    {
	      return redirect('admin/import/courses/get')->withInput()->withErrors($validation);
	    }
	    $i=1;
		$path = $req->file('importFile')->getRealPath();
		$data = Excel::load($path, function($reader) { })->get();
		$count=count($data);
		if(!empty($data) && $data->count()){
			foreach($data as $key=>$value){
				$class=$value->subject;
				$subject=$value->courses;
				$category=$value->chapter;

				$countClass=Classname::where('class_name',$class)->first();
				if(count($countClass)>0){
					$classId=$countClass->id;
				}else{
					$classCode=Classname::autogeneratecode();
					$insertClass=new Classname();
					$insertClass->code=$classCode;
					$insertClass->class_name=$class;
					$insertClass->status='active';
					$insertClass->countryId=NULL;
					$insertClass->save();
					$classId=$insertClass->id;
				}

				$countSubject=Subjects::where('name',$subject)->first();
				if(count($countSubject)>0){
					$subjectId=$countSubject->id;
				}else{
					$subjectCode=Subjects::autogeneratecode();
					$insertSubject=new Subjects();
					$insertSubject->code=$subjectCode;
					$insertSubject->classId=$classId;
					$insertSubject->name=$subject;
					$insertSubject->status='active';
					$insertSubject->save();
					$subjectId=$insertSubject->id;
				}

				$countCategory=Category::where('category_name',$category)->first();
				$categoryCode=Category::autogeneratecode();
				$insertCategory=new Category();
				$insertCategory->code=$categoryCode;
				$insertCategory->parent_class=$classId;
				$insertCategory->subject=$subjectId;
				$insertCategory->category_name=$category;
				$insertCategory->status='active';
				$insertCategory->created_by=Auth::user()->id;
				$insertCategory->save();
				$i++;
			}
		}
	    return redirect('admin/import/courses/get')->with('success','Excel file imported successfully.');
	}


	public function update(){
		$records=Group::get();
		$i=1001;
		foreach($records as $record){
			$code='GR'.$i;
			$update=Group::find($record->id);
			$update->code=$code;
			$update->save();
			$i++;
		}
		return 'success';
	}

	public function addassignvotepost(Request $req){
		$input=$req->all();
		$rules=['shortDescription'=>'required|max:50','message'=>'required','endDate'=>'required'];
		$validation=Validator::make($input,$rules);
	    if($validation->fails()){
	    	//return $validation->messages();
	      return redirect('admin/assign/course/get/'.$input['groupId'].'/vote/'.$input['course'])->withInput( $req->except('options'))->withErrors($validation,'add')->with('classerror','add_row_vote');
	    }
	    $insert=new Vote();
	    $insert->groupId=$input['groupId'];
	    $insert->courseId=$input['course'];
	    $insert->short_description=$input['shortDescription'];
	    $insert->message=$input['message'];
	    $insert->endDate=date('Y-m-d',strtotime($input['endDate']));
	    $insert->created_by=Auth::user()->id;
	    $insert->save();

	    foreach($input['options'] as $option){
	    	$insertMeta=new Votemeta();
		    $insertMeta->voteId=$insert->id;
		    $insertMeta->optionName=$option;
		    $insertMeta->countNo=0;
		    $insertMeta->save();
	    }
	    return redirect('admin/assign/course/get/'.$input['groupId'].'/vote/'.$input['course'])->with('voteSuccess','New vote added successfully');
	}


	public function removestudentfromcourse(Request $req){
		$id=$req->input('id');
		GroupMember::where('id',$id)->delete();
		return Response::json(['status'=>'success']);
	}

	public function libraryget(){
		$countryBased=Options::getvalue('countryBased');
	    $staffCountry=Staff::getstaffcountry(Auth::user()->userLink);
	    $records=Library::where('id','!=',0);
	    if($countryBased=='yes'){
	    	$records=$records->where('countryId',$staffCountry);
	    }
	    $records=$records->get();
	    
	    $classes=Classname::where('status','active');
	    if($countryBased=='yes'){
	    	$classes=$classes->where('countryId',$staffCountry);
	    }
	    $classes=$classes->lists('class_name','id');
	    $subjects=Subjects::where('status','active')->lists('name','id');
	    return view('library')->with('records',$records)->with(['classes'=>$classes,'subjects'=>$subjects]);
	}

	public function addlibrarypost(Request $req){
		$input=$req->all();
		$rules=['class'=>'required'];
		$validation=Validator::make($input,$rules);
		if($validation->fails()){
			return redirect('admin/library/get')->withErrors($validation,'add')->withInput();
		}
		if($req->hasFile('libraryFile')){
			$files=$input['libraryFile'];
			$uploadSize=Options::getvalue('libraryFileSize');
			$maxLimit=$uploadSize*1024*1024;
			foreach($files as $file){
				$memory=$file->getSize();
				if($memory>$maxLimit){
					return redirect('admin/library/get')->with('failed','Upload file size must be less than or equal to '.$uploadSize.' MB')->withInput();
				}
			}

			foreach($files as $file){
	          	$destinationPath = 'uploads/library/';
	          	$extension = $file->getClientOriginalExtension();
	          	$uploadName=$file->getClientOriginalName();
	          	$uploadName=explode('.',$uploadName);
	          	$uploadName=$uploadName[0];
	          	$filename = str_random(12).".{$extension}";
	          	$upload_success = $file->move($destinationPath, $filename);
	          	$fileUrl=$destinationPath.$filename;
	          	$url = URL::asset($destinationPath.$filename);

	          	$countryBased=Options::getvalue('countryBased');
	    		$staffCountry=Staff::getstaffcountry(Auth::user()->userLink);
	          	
	          	$insert=new Library();
	          	if($countryBased=='yes'){
	          		$insert->countryId=$staffCountry;
	          	}
	          	$insert->name=$uploadName;
	          	$insert->classes=$input['class'];
	          	if($input['subject']!=''){
	          		$insert->subject=$input['subject'];
	          	}
	          	if($input['category']!=''){
	          		$insert->category=$input['category'];
	          	}
	          	if($input['subCategory']!=''){
	          		$insert->subCategory=$input['subCategory'];
	          	}
	          	if($input['course']!=''){
	          		$insert->course=$input['course'];
	          	}
	          	$insert->fileLink=$url;
	          	$insert->publicLink=$fileUrl;
	          	$insert->created_by=Auth::user()->id;
	          	$insert->save();
			}
		}else{
			return redirect('admin/library/get')->with('failed','Please upload file')->withInput();
		}
		return redirect('admin/library/get')->with('success','New files added successfully.');
	}

	public function deletelibrarypost(Request $req){
		$input=$req->all();
	    $ids=json_decode($input['ids']);
	    foreach($ids as $id){
	    	$record=Library::find($id);
	    	if(count($record)==1){
	    		$url=$record->publicLink;
	    		unlink(public_path($url));
	    	}
	    	$record->delete();
	    }

	    return Response::json(['status'=>'success']);
	}

	public function settingsget(){
	    return view('settings');
	}

	public function addsettingspost(Request $req){
		$input=$req->all();
		$rules=['libraryFileSize'=>'required'];
		$validation=Validator::make($input,$rules);
		if($validation->fails()){
			return redirect('admin/settings/get')->withErrors($validation,'add')->withInput();
		}
		DB::table('options')->where(['key'=>'libraryFileSize'])->update(['value'=>$input['libraryFileSize']]);
		DB::table('options')->where(['key'=>'lable1'])->update(['value'=>$input['lable1']]);
		DB::table('options')->where(['key'=>'lable2'])->update(['value'=>$input['lable2']]);
		if($req->has('countryBased')){
			DB::table('options')->where(['key'=>'countryBased'])->update(['value'=>'yes']);
		}else{
			DB::table('options')->where(['key'=>'countryBased'])->update(['value'=>'no']);
		}
		return redirect('admin/settings/get')->with('success','Settings saved successfully.');
	}

	public function dailytasksstatusget(){
		$dailyGroups=[];
		if(Auth::user()->type=='staff'){
			$userCountry=Staff::getstaffcountry(Auth::user()->userLink);
		}else{
			$userCountry=Students::getstudentcountry(Auth::user()->userLink);
		}
		$countryBased=Options::getvalue('countryBased');
		if(Auth::user()->type=='student'){
			$dailyGroups=Dailytasks::where('status','active')->where('template','no')->where('students',Auth::user()->userLink);
			if($countryBased=='yes'){
				$dailyGroups=$dailyGroups->where('countryId',$userCountry);
			}
			$dailyGroups=$dailyGroups->lists('groupName','serialNo');
		}
		$groups=Dailytasks::where('status','!=','deleted')->where('template','no')->groupBy('serialNo');
		if(Auth::user()->type=='student'){
			$groups=$groups->where('students',Auth::user()->userLink);
		}else{
			$groups=$groups->where('createdBy',Auth::user()->id);
		}
		if($countryBased=='yes'){
			$groups=$groups->where('countryId',$userCountry);
		}
		$groups=$groups->lists('groupName','serialNo');
		return view('dailyTasksStatus')->with(['groups'=>$groups,'dailyGroups'=>$dailyGroups]);
	}

	public function dailytasksstatustrackerget(){
		$dailyGroups=[];
		if(Auth::user()->type=='staff'){
			$userCountry=Staff::getstaffcountry(Auth::user()->userLink);
		}else{
			$userCountry=Students::getstudentcountry(Auth::user()->userLink);
		}
		$countryBased=Options::getvalue('countryBased');
		if(Auth::user()->type=='student'){
			$dailyGroups=Dailytasks::where('status','active')->where('template','no')->where('students',Auth::user()->userLink);
			if($countryBased=='yes'){
				$dailyGroups=$dailyGroups->where('countryId',$userCountry);
			}
			$dailyGroups=$dailyGroups->lists('groupName','serialNo');
		}
		$groups=Dailytasks::where('status','!=','deleted')->where('template','no')->groupBy('serialNo');
		if(Auth::user()->type=='student'){
			$groups=$groups->where('students',Auth::user()->userLink);
		}else{
			$groups=$groups->where('createdBy',Auth::user()->id);
		}
		if($countryBased=='yes'){
			$groups=$groups->where('countryId',$userCountry);
		}
		$groups=$groups->lists('groupName','serialNo');
		$taskname = Dailytaskstracker::pluck('id','taskName')->all();
		return view('tracker.dailyTasksStatus',compact('groups','dailyGroups','taskname'));
	}
	public function dailytasksstatustrackergetdata(){
		$dailyGroups=[];
		if(Auth::user()->type=='staff'){
			$userCountry=Staff::getstaffcountry(Auth::user()->userLink);
		}else{
			$userCountry=Students::getstudentcountry(Auth::user()->userLink);
		}
		$countryBased=Options::getvalue('countryBased');
		if(Auth::user()->type=='student'){
			$dailyGroups=Dailytasks::where('status','active')->where('template','no')->where('students',Auth::user()->userLink);
			if($countryBased=='yes'){
				$dailyGroups=$dailyGroups->where('countryId',$userCountry);
			}
			$dailyGroups=$dailyGroups->lists('groupName','serialNo');
		}
		$groups=Dailytasks::where('status','!=','deleted')->where('template','no')->groupBy('serialNo');
		if(Auth::user()->type=='student'){
			$groups=$groups->where('students',Auth::user()->userLink);
		}else{
			$groups=$groups->where('createdBy',Auth::user()->id);
		}
		if($countryBased=='yes'){
			$groups=$groups->where('countryId',$userCountry);
		}
		$groups=$groups->lists('groupName','serialNo');
		$taskname = Dailytaskstracker::pluck('id','taskName')->all();
		return view('tracker.dailytaskstudentmultiple',compact('groups','dailyGroups','taskname'));
	}

	public function gettaskname(Request $req){
		$input = $req['data'];
		if($input != ''){
		 	$query = Dailytaskstracker::where('tasktype', $input)->where('type','x')->pluck('taskName','id');
		 	return Response::json(['status'=>'success','data'=>$query]);
		}
		else{
			return Response::json(['status'=>'wrong']);
		}
	}
	public function gettasknames(Request $req){
	$input = $req['data'];
		if($input != ''){
		 	$query = Dailytaskstracker::where('tasktype', $input)->where('type','y')->pluck('taskName','id');
		 	return Response::json(['status'=>'success','data'=>$query]);
		}
		else{
			return Response::json(['status'=>'wrong']);
		}
	}

	public function optionName(Request $req){
		$option = $req['data'];
		if($option != ''){
		 	//$query = Dailytaskstracker::where('id', $option)->pluck('id');
		 return	$data = Dailytasksmetatracker::where('trackerId', $option)->pluck('id','optionName');
		 	return Response::json(['status'=>'success','data'=>$data]);
		}
		else{
			return Response::json(['status'=>'wrong']);
		}
	}



	public function dailyTaskReportGet(){
		$dailyGroups=[];
		if(Auth::user()->type=='staff'){
			$userCountry=Staff::getstaffcountry(Auth::user()->userLink);
		}else{
			$userCountry=Students::getstudentcountry(Auth::user()->userLink);
		}
		$countryBased=Options::getvalue('countryBased');
		if(Auth::user()->type=='student'){
			$dailyGroups=Dailytasks::where('status','active')->where('template','no')->where('students',Auth::user()->userLink);
			if($countryBased=='yes'){
				$dailyGroups=$dailyGroups->where('countryId',$userCountry);
			}
			$dailyGroups=$dailyGroups->lists('groupName','serialNo');
		}
		$groups=Dailytasks::where('status','!=','deleted')->where('template','no')->groupBy('serialNo');
		if(Auth::user()->type=='student'){
			$groups=$groups->where('students',Auth::user()->userLink);
		}else{
			$groups=$groups->where('createdBy',Auth::user()->id);
		}
		if($countryBased=='yes'){
			$groups=$groups->where('countryId',$userCountry);
		}
		$groups=$groups->lists('groupName','serialNo');
		$taskname = Dailytaskstracker::pluck('id','taskName')->all();
		return view('tracker.dailytaskreport',compact('groups','dailyGroups','taskname'));
	}

	public function taskTrackerSaveData(Request $req){
		$input = $req->all();
		$input = $input['data'];
		$taskDetails = $input['taskdetails'];
		$taskId = $input['taskname'];
		$options=Dailytasksmetatracker::where('trackerId',$input['taskname'])->select('id', 'option_type')->get();
		$student = Dailytasksstudent::where('trackerId',$input['taskname'])->lists('studentId');
		$trackerType = [];
		foreach($options as $opt){
			// $type = 'alpha';
			// if($opt->option_type == 1){
			// 	$type = 'revenue';
			// }else if($opt->option_type == 2){
			// 	$type = 'cost';
			// }
			$se = Option::where('id',$opt->option_type)->first();
			$type = $se->type;
			$type;
			$trackerType[$opt->id] = $type;
		}

		foreach($taskDetails as $sedate=>$task){
			//return $sedate;
			$date = date('Y-m-d',strtotime($task['date']));
			$result = $task['result'];
			foreach($result as $key=>$val){
				foreach($val as $k=>$v){
					if($k != 'name' && $k != 'textcolor' && $k != 'bgcolor' && $k != 'changed' && $k != 'alternative'){
						$changedStatus = $val['changed'][$k];
						if($changedStatus == 'yes'){
							$check = Studenttracker::where('taskId', $taskId)->where('taskDate', $date)->where('studentId', $key)->where('optionId', $k)->first();
							if(count($check) == 1){
								$insert = Studenttracker::find($check->id);
							}else{
								$insert = new Studenttracker();
								$insert->taskId = $taskId;
								$insert->taskDate = $date;
								$insert->studentId = $key;
								$insert->optionId = $k;
							}
							$insert->value = $v;
							$insert->save();


							//change bgcolor & text color
							$percentage = 0;
							$masterRecord = DB::table('dailytasksstatustracker')->where('trackerId', $taskId)->where('studentId', $key)->where('optionId', $k)->first();
							if($masterRecord){
								$masterVal = $masterRecord->value;
								$actualVal = $v;
								if($masterVal > 0){
									$percentage = ($actualVal/$masterVal)*100;
								}
								
								if(isset($trackerType[$k])){
									if($trackerType[$k]== 'alpha'){
										$val['bgcolor'][$k] = 'white';
									$val['textcolor'][$k] = 'red';
									$result[$key] = $val;
									}else{
									$color = Trackerpercentage::getcolor($taskId, $trackerType[$k], $percentage);
									$val['bgcolor'][$k] = $color;
									$val['textcolor'][$k] = 'white';
									$result[$key] = $val;
								}
								}
							}
						}
					}
				}
			}
			$taskDetails[$sedate]['result'] = $result;
		}
		//$taskDetails[0]['result'] = $result;
		return Response::json(['status'=>'success', 'taskDetails'=>$taskDetails]);
		
	}
	public function taskTrackerSavepostdata(Request $req){
		$input = $req->all();
		$input = $input['data'];
		$taskDetails = $input['taskdetails'];
		$taskId = $input['taskname'];
		$options=Dailytasksmetatracker::where('trackerId',$input['taskname'])->select('id', 'option_type')->get();
		$student = Dailytasksstudent::where('trackerId',$input['taskname'])->lists('studentId');
		$colourvalue = Dailytasksstudent::where('trackerId',$input['taskname'])->get();
		$trackerType = [];
		foreach ($options as $opt) {
			foreach($colourvalue as $cv){
				$se = Option::where('id',$cv->type)->first();
				$type = $se->type;
				$type;
				$trackerType[$cv->id][$opt->id] = $type;
			}
		}

		foreach($taskDetails as $sedate=>$task){
			$date = date('Y-m-d',strtotime($task['date']));
			$result = $task['results'];
			foreach($result as $key=>$val){
				foreach($val['options'] as $k=>$v){
					if($k != 'name' && $k != 'textcolor' && $k != 'bgcolor' && $k != 'changed' && $k != 'alternativename'){
						$changedStatus = $val['options'][$k]['changed'];
						if($changedStatus == 'yes'){
							 $check = Studenttracker::where('taskId', $taskId)->where('taskDate', $date)->where('studentId', $val['studentId'])->where('optionId', $k)->where('type',$val['type'])->where('alternativeId',$v['alternativeId'])->first();
							if(count($check) == 1){
								$insert = Studenttracker::find($check->id);
							}else{
								$insert = new Studenttracker();
								$insert->taskId = $taskId;
								$insert->taskDate = $date;
								$insert->studentId = $val['studentId'];
								$insert->optionId = $k;
								$insert->type = $val['type'];
								$insert->alternativeId = $v['alternativeId'];
							}
							$insert->value = $v['opt'];
							$insert->save();


							//change bgcolor & text color
							$percentage = 0;
							$masterRecord = Dailytasksstatustracker::where('trackerId', $taskId)->where('studentId', $val['studentId'])->where('optionId', $k)->where('alternativeId',$v['alternativeId'])->first();
							if($masterRecord){
								$masterVal = $masterRecord->value;
								$actualVal = $v['opt'];
								if($masterVal > 0){
									$percentage = ($actualVal/$masterVal)*100;
								}
								foreach($colourvalue as $cv){
									if(isset($trackerType[$cv->id][$k])){
										if($trackerType[$cv->id][$k]== 'alpha'){
											$val['options'][$k]['bgcolor'] = 'white';
											$val['options'][$k]['textcolor'] = 'red';
										}else{
											$color = Trackerpercentage::getcolor($taskId, $trackerType[$cv->id][$k], $percentage);
											$val['options'][$k]['bgcolor'] = $color;
											$val['options'][$k]['textcolor'] = 'white';
										}
										$result[$key] = $val;
									}
								}
							}
						}
					}
				}
			}
			$taskDetails[$sedate]['results'] = $result;
		}
		return Response::json(['status'=>'success', 'taskDetails'=>$taskDetails]);
		
	}

	public function gettaskgroups(Request $req){
		$input=$req->all();
		$type=$input['type'];
		if(Auth::user()->type=='staff'){
			$userCountry=Staff::getstaffcountry(Auth::user()->userLink);
		}else{
			$userCountry=Students::getstudentcountry(Auth::user()->userLink);
		}
		$countryBased=Options::getvalue('countryBased');
		$groups=Dailytasks::where('status','!=','deleted')->where('template','no')->where('tasktype',$type)->groupBy('serialNo');
		if(Auth::user()->type=='student'){
			$groups=$groups->where('students',Auth::user()->userLink);
		}else{
			$groups=$groups->where('createdBy',Auth::user()->id);
		}
		if($countryBased=='yes'){
			$groups=$groups->where('countryId',$userCountry);
		}
		$groups=$groups->lists('groupName','serialNo');
		return Response::json(['groups'=>$groups]);
	}

	public function gettemplatedetails(Request $req){
		$input=$req->all();
		$serialNo=$input['serialNo'];
		$dailyTask=Dailytasks::where('serialNo',$serialNo)->first();
		$groupName=$dailyTask->groupName;
		$taskName=$dailyTask->taskName;
		$type=$dailyTask->tasktype;
		$day=$dailyTask->day;
		if($type=='daily'){
			$day==explode(',',$day);
		}
		$startDate=date('d-m-Y',strtotime($dailyTask->startDate));
		$endDate='';
		if($dailyTask->endDate!=''){
			$endDate=date('d-m-Y',strtotime($dailyTask->endDate));
		}
		$students=Dailytasks::where('serialNo',$serialNo)->lists('students');
		$options=Dailytasksmeta::where('serialNo',$serialNo)->get();
		$status=Dailytasksstatus::where('serialNo',$serialNo)->get();
		return Response::json(['groupName'=>$groupName,'taskName'=>$taskName,'startDate'=>$startDate,'options'=>$options,'status'=>$status,'students'=>$students,'endDate'=>$endDate,'type'=>$type,'day'=>$day]);
	}

	public function trackerview(){
		$students=Students::where('status','active');
		$students=$students->lists('fullname','id');
		$templates=Dailytasks::where('template','yes')->where('createdBy', Auth::id())->groupBy('serialNo')->lists('groupName','serialNo');
		$options = Option::select('id','value')->get();
		return view('tracker.tracker',compact('students','templates','options'));
	}

	public function trackerAdd(Request $request){
	return	$req = $request->all();
		$rules=[
			'groupName'=>'required',
			'taskName'=>'required'
		];
	    $validation= Validator::make($req,$rules);
	    if($validation->fails()){
	      return back()->withErrors($validation);
	    }

	}


	public function dailytasksget(){
		$countryBased=Options::getvalue('countryBased');
		$staffCountry=Staff::getstaffcountry(Auth::user()->userLink);
		$records=Dailytasks::where('status','!=','deleted')->where('template','no')->groupBy('serialNo')->where('createdBy',Auth::user()->id);
		if($countryBased=='yes'){
			$records=$records->where('countryId',$staffCountry);
		}
		$records=$records->get();
		$students=Students::where('status','active');
		if($countryBased=='yes'){
			$students=$students->where('countryId',$staffCountry);
		}
		$students=$students->lists('fullname','id');
		$templates=Dailytasks::where('template','yes')->where('createdBy', Auth::id())->groupBy('serialNo')->lists('groupName','serialNo');
		return view('dailyTasks')->with(['records'=>$records,'students'=>$students,'templates'=>$templates]);
	}


	public function adddailytaskspost(Request $req){
	    $input=$req->all();
	    if(count($input['dailyDay'])==0){
	    	$input['dailyDay']='';
	    }
	    $countryBased=Options::getvalue('countryBased');
	    $rules=['groupName'=>'required','taskName'=>'required','startDate'=>'required','endDate'=>'required','weeklyDay'=>'required_if:taskType,weekly','monthlyDay'=>'required_if:taskType,monthly','dailyDay'=>'required_if:taskType,daily'];
	    $validation= Validator::make($input,$rules);
	    if($validation->fails()){
	      return back()->withErrors($validation,'add')->withInput()->with('taskserror','add_row');
	    }
	    $students=$input['students'];
	    $options=$input['options'];
	    $status=$input['status'];
	    $record=Dailytasks::orderBy('serialNo','DESC')->first();
	    $serialNo = Dailytasks::getserialno();

    	foreach($students as $student){
    		if($student!=''){
		    	$insert=new Dailytasks();
		    	if($countryBased=='yes'){
		    		$staffCountry=Staff::getstaffcountry(Auth::user()->userLink);
		    		$insert->countryId=$staffCountry;
		    	}
		    	$insert->taskType=$input['taskType'];
		    	$insert->serialNo=$serialNo;
			    $insert->groupName=$input['groupName'];
			    $insert->taskName=$input['taskName'];
			    $insert->startDate=date('Y-m-d',strtotime($input['startDate']));
			    $insert->endDate=date('Y-m-d',strtotime($input['endDate']));
			    $insert->students=$student;
			    if($req->has('template')){
			    	$insert->template='yes';
			    }else{
			    	$insert->template='no';
			    }

			    if($input['taskType']=='daily'){
			    	$insert->day=implode(',',$input['dailyDay']);
			    }elseif($input['taskType']=='weekly'){
			    	$insert->day=$input['weeklyDay'];
			    }elseif($input['taskType']=='monthly'){
			    	$insert->day=$input['monthlyDay'];
			    }

			    $insert->status='active';
			    $insert->createdBy=Auth::user()->id;
			    $insert->save();
			}
	    }
	    foreach($options as $option){
	    	$insertMeta=new Dailytasksmeta();
	    	$insertMeta->serialNo=$serialNo;
	    	$insertMeta->optionName=$option;
	    	$insertMeta->save();
	    }
	    $colors=$input['color'];
	    $i=0;
	    foreach($status as $sta){
	    	$insertStatus=new Dailytasksstatus();
	    	$insertStatus->serialNo=$serialNo;
	    	$insertStatus->name=$sta;
	    	$insertStatus->color=$colors[$i];
	    	$insertStatus->save();
	    	$i++;
	    }
	    return Redirect::to('admin/daily/tasks/get')->with('success','New task created successfully.')->with('taskserror','add_row');
	}

	public function editdailytaskspost(Request $req){
	    $input=$req->all();
	    if(count($input['dailyDay'])==0){
	    	$input['dailyDay']='';
	    }
    	$rules=['groupName'=>'required','taskName'=>'required','startDate'=>'required','endDate'=>'required','weeklyDay'=>'required_if:taskType,weekly','monthlyDay'=>'required_if:taskType,monthly','dailyDay'=>'required_if:taskType,daily'];
	    $validation= Validator::make($input,$rules);
	    if($validation->fails()){
	      return back()->withErrors($validation,'edit')->withInput()->with('taskserror','edit_row');
	    }
	    $students=$input['students'];
	    $options=$input['options'];
	    $status=$input['status'];

    	foreach($students as $student){
    		if($student!=''){
	    		$check=Dailytasks::where('serialNo',$input['editId'])->where('students',$student)->first();
	    		if(count($check)==1){
	    			$update=Dailytasks::find($check->id);
	    			$update->tasktype=$input['taskType'];
	    			$update->groupName=$input['groupName'];
	    			$update->taskName=$input['taskName'];
	    			$update->startDate=date('Y-m-d',strtotime($input['startDate']));
	    			$update->endDate=date('Y-m-d',strtotime($input['endDate']));
	    			$update->status='active';
	    			if($input['taskType']=='daily'){
				    	$update->day=implode(',',$input['dailyDay']);
				    }elseif($input['taskType']=='weekly'){
				    	$update->day=$input['weeklyDay'];
				    }elseif($input['taskType']=='monthly'){
				    	$update->day=$input['monthlyDay'];
				    }
	    			$update->save();
	    		}elseif(count($check)==0){
	    			$insert=new Dailytasks();
	    			$insert->tasktype=$input['taskType'];
			    	$insert->serialNo=$input['editId'];
				    $insert->groupName=$input['groupName'];
				    $insert->taskName=$input['taskName'];
				    $insert->startDate=date('Y-m-d',strtotime($input['startDate']));
				    $insert->endDate=date('Y-m-d',strtotime($input['endDate']));
				    $insert->students=$student;
				    $insert->status='active';
				    $insert->createdBy=Auth::user()->id;
				    if($input['taskType']=='daily'){
				    	$insert->day=implode(',',$input['dailyDay']);
				    }elseif($input['taskType']=='weekly'){
				    	$insert->day=$input['weeklyDay'];
				    }elseif($input['taskType']=='monthly'){
				    	$insert->day=$input['monthlyDay'];
				    }
				    $insert->save();
	    		}
	    	}
	    }
	    Dailytasks::whereNotIn('students',$students)->where('serialNo',$input['editId'])->update(['status'=>'active']);
	    Dailytasksmeta::where('serialNo',$input['editId'])->delete();
	    Dailytasksstatus::where('serialNo',$input['editId'])->delete();
	    foreach($options as $option){
	    	$insertMeta=new Dailytasksmeta();
	    	$insertMeta->serialNo=$input['editId'];
	    	$insertMeta->optionName=$option;
	    	$insertMeta->save();
	    }

	    $colors=$input['color'];
	    $i=0;
	    foreach($status as $sta){
	    	$insertStatus=new Dailytasksstatus();
	    	$insertStatus->serialNo=$input['editId'];
	    	$insertStatus->name=$sta;
	    	$insertStatus->color=$colors[$i];
	    	$insertStatus->save();
	    	$i++;
	    }

	    return Redirect::to('admin/daily/tasks/get')->with('editsuccess','Task updated successfully.');
	}


	public function addtaskstatus(Request $req){
	    $input=$req->all();
	   	$status=$input['status'];
	   	$colors=['#ff0000','#3FBF3F','#EDEA2A'];
	   	Dailytasksstatus::where('id','!=',0)->delete();
	   	$i=0;
    	foreach($status as $sta){
	    	$insert=new Dailytasksstatus();
	    	$insert->name=$sta;
	    	$insert->color=$colors[$i];
		    $insert->save();
		    $i++;
	    }
	    
	    return Redirect::to('admin/settings/get')->with('statussuccess','Status added successfully.');
	}

	public function deletedailytaskspost(Request $req){
		$input=$req->all();
	    $ids=json_decode($input['ids']);
	    $delete=Dailytasks::whereIn('serialNo',$ids)->update(['status'=>'deleted']);
	    return Response::json(['status'=>'success']);
	}

	public function closetaskpost(Request $req){
		$input=$req->all();
		$endDate=date('Y-m-d',strtotime($input['endDate']));
		$update=Dailytasks::where('serialNo',$input['serialNo'])->update(['status'=>'closed','endDate'=>$endDate]);
		return Response::json(['status'=>'success']);
	}


	public function getdailytaskspost(Request $req){
	    $id= $req->input('editId');
	    $record= Dailytasks::where('serialNo',$id)->first();
	    $group='';
	    $task='';
	    $students=[];
	    $options='';
	    $status='';
	    $startDate='';
	    $endDate='';
	    $type='';
	    $day='';
	    if(count($record)==1){
	    	$group=$record->groupName;
	    	$task=$record->taskName;
	    	$startDate=date('d-m-Y',strtotime($record->startDate));
	    	$endDate=date('d-m-Y',strtotime($record->endDate));
	    	$type=$record->tasktype;
	    	if($type=='daily'){
	    		$day=explode(',',$record->day);
	    	}else{
	    		$day=$record->day;
	    	}
	    }

	    $stuRecords=Dailytasks::where('serialNo',$id)->lists('students');
	    foreach($stuRecords as $stu){
	    	array_push($students,$stu);
	    }

	    $optionRecords=Dailytasksmeta::where('serialNo',$id)->get();
	    $i=0;
	    foreach($optionRecords as $optionRec){
	    	$options.='<div class="form-group cloneTask">';
	    	if($i==0){
	    		$options.='<label for="Options" class="col-sm-2 control-label">Options *</label>';
	    	}else{
	    		$options.='<label for="" class="col-sm-2 control-label"></label>';
	    	}
            $options.='<div class="col-sm-8">
                  		<input class="form-control" name="options[]" type="text" value="'.$optionRec->optionName.'">
                 		</div>
                 		<a href="javascript:void(0)" class="addOption" data-div="edit_row"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                 		<a href="javascript:void(0)" class="removeOption" data-div="edit_row" style="display:none;"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                		</div>';
               $i++;
	    }



	    $statusRecords=Dailytasksstatus::where('serialNo',$id)->get();
	    $i=0;
	    foreach($statusRecords as $statusRec){
	    	$status.='<div class="form-group cloneStatus">';
	    	if($i==0){
	    		$status.='<label for="status" class="col-sm-2 control-label">Status *</label>';
	    	}else{
	    		$status.='<label for="" class="col-sm-2 control-label"></label>';
	    	}
	    	$color=$statusRec->color;
	    	$green='';
	    	$yellow='';
	    	$red='';
	    	$blue='';
	    	if($color=='#00ff00'){
	    		$green='selected="selected"';
	    	}elseif($color=='#ffff00'){
	    		$yellow='selected="selected"';				
	    	}elseif($color=='#ff0000'){
				$red='selected="selected"';
	    	}elseif($color=='#5acbff'){
				$blue='selected="selected"';
	    	}

            $status.='<div class="col-sm-6">
                  		<input class="form-control taskStatus" name="status[]" type="text" value="'.$statusRec->name.'">
                 		</div>

                 		<div class="col-sm-2">
                  			<select class="form-control statusColor" name="color[]">
                  				<option value="">Color</option>
                  				<option value="#00ff00" '.$green.'>Green</option>
                  				<option value="#ffff00" '.$yellow.'>Yellow</option>
                  				<option value="#ff0000" '.$red.'>Red</option>
                  				<option value="#5acbff" '.$blue.'>Blue</option>
                  			</select>
                 		</div>
                 		<a href="javascript:void(0)" class="addStatus" data-div="edit_row"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                 		<a href="javascript:void(0)" class="removeStatus" data-div="edit_row" style="display:none;"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                		</div>';
               $i++;
	    }

	    return Response::json(['result'=>'success','group'=>$group,'task'=>$task,'students'=>$students,'options'=>$options,'startDate'=>$startDate,'status'=>$status,'type'=>$type,'endDate'=>$endDate,'day'=>$day]);
	}

	public function taskstatusreport(Request $req){
	    $input=$req->all();
		$html='';
		$groupRecord=Dailytasks::where('serialNo',$input['group'])->first();
	    $students=Dailytasks::where('serialNo',$input['group'])->lists('students');
		$options=Dailytasksmeta::where('serialNo',$input['group'])->lists('optionName','id');
		$totalStatus=Dailytasksstatus::where('serialNo',$input['group'])->get();
		$toDate='';
		$fromDate='';
		$type=$input['type'];
		if($input['toDate']!=''){
			$toDate=date('Y-m-d',strtotime($input['toDate']));
		}

		if($input['fromDate']!=''){
			$fromDate=date('Y-m-d',strtotime($input['fromDate']));
		}

		$statusHtml='';
		foreach($totalStatus as $totalSta){
			$statusHtml.=$totalSta->name.': <span class="label" style="background-color:'.$totalSta->color.'">&nbsp;&nbsp;&nbsp;</span> &nbsp;&nbsp;';
		}
		$i=0;
		if(count($students)>0){
			if($groupRecord->status=='closed'){
				$endDate=$groupRecord->endDate;
				if($toDate!=''){
					if($toDate<=$endDate && $toDate<=date('Y-m-d')){
						$endDate=$toDate;
					}elseif($toDate<=date('Y-m-d')){
						$endDate=date('Y-m-d');
					}
				}
			}else{
				$endDate=date('Y-m-d');
				if($toDate!=''){
					if($toDate<=date('Y-m-d')){
						$endDate=$toDate;
					}
				}
			}

			$startDate=$groupRecord->startDate;
			if($fromDate!=''){
				if($fromDate>=$startDate){
					$startDate=$fromDate;
				}
			}else{
				if($type=='daily'){
					$startDate=date('Y-m-d',strtotime('-6 day',strtotime($endDate)));
				}
			}

			while($endDate>=$startDate){
				$dateStatus='no';
				$day=$groupRecord->day;
				if($type=='daily'){
					$day=explode(',',$day);
					$dateDay=date('N',strtotime($endDate));
					if(in_array($dateDay,$day)){
						$dateStatus='yes';
					}
				}elseif($type=='weekly'){
					$dateDay=date('N',strtotime($endDate));
					if($day==$dateDay){
						if($toDate=='' && $fromDate=='' && $i<7){
							$dateStatus='yes';
						}elseif($toDate!='' || $fromDate!=''){
							$dateStatus='yes';
						}
					}
				}elseif($type=='monthly'){
					$dateDay=date('d',strtotime($endDate));
					if($day==$dateDay){
						if($toDate=='' && $fromDate=='' && $i<7){
							$dateStatus='yes';
						}elseif($toDate!='' || $fromDate!=''){
							$dateStatus='yes';
						}
					}
				}
				if($dateStatus=='yes'){
					$strtotime=strtotime($endDate);
					$class='';
					$html.='<div class="panel panel-default panel-collapse">
					<div class="panel-heading" role="tab" id="heading'.$strtotime.'">
						<a data-toggle="collapse" data-parent="#accordion" href="#course'.$strtotime.'" aria-expanded="true" aria-controls="collapse'.$strtotime.'" class="">
							<h4 class="panel-title">
								<i class="fa fa-file"></i>&nbsp;'; 

								if($type=='daily'){
									$html.=date("F d, Y",$strtotime).' | '.date("l",$strtotime);
								}elseif($type=='weekly'){
									$html.=date("F d, Y",$strtotime);
								}elseif($type=='monthly'){
									$html.=date("F",$strtotime);
								}

							$html.='</h4>
						</a>
					</div>
					<div id="course'.$strtotime.'" class="panel-collapse collapse '.$class.'" role="tabpanel" aria-labelledby="heading'.$strtotime.'" aria-expanded="true">
						<table class="table table-striped">
							<thead>
								<tr>
									<td>Student</td>';
									foreach($options as $option){
										$html.='<td>'.$option.'</td>';
									}

									$html.='</tr>
								</thead>
								<tbody>';
									foreach($students as $student){
										$updateStatus='';
										if(Auth::user()->type=='student' && $student==Auth::user()->userLink && $groupRecord->status=='active'){
											$updateStatus='updateStatus';
										}
										$studentName=Students::getstudentname($student);
										$html.='<tr>
										<td>'.$studentName.'</td>';
										foreach($options as $optionKey=>$option){
											$status=Dailytasksresult::where('serialNo',$input['group'])->where('studentId',$student)->where('optionId',$optionKey)->where('statusDate',$endDate)->first();

											if(count($status)==1){
												$statusRecord=Dailytasksstatus::find($status->statusId);
												if(count($statusRecord)==1){
													$color=$statusRecord->color;
												}else{
													$color='';
												}
												if($updateStatus==''){
													$html.='<td><span class="label" style="background-color:'.$color.'">&nbsp;&nbsp;&nbsp;</span></td>';
												}else{
													$html.='<td><a href="javascript:void(0)" class="label updateStatus" data-group="'.$input["group"].'" data-option="'.$optionKey.'" data-time="'.strtotime($endDate).'" style="background-color:'.$color.'">&nbsp;&nbsp;&nbsp;</a></td>';
												}

											}else{
												$getOption=Dailytasksstatus::where('serialNo',$input['group'])->first();
												$color='';
												if(count($getOption)==1){
													$color=$getOption->color;
												}
												if($updateStatus==''){
													$html.='<td><span class="label" style="background-color:'.$color.'">&nbsp;&nbsp;&nbsp;</span></td>';
												}else{
													$html.='<td><a href="javascript:void(0)" class="label updateStatus" data-group="'.$input["group"].'" data-option="'.$optionKey.'" data-time="'.strtotime($endDate).'" style="background-color:'.$color.'">&nbsp;&nbsp;&nbsp;</a></td>';
												}

											}
										}
										$html.='</tr>';
									}

									$html.='</tbody>
								</table>
							</div>
						</div>';
					$i++;
				}
				$endDate=date('Y-m-d',strtotime('-1 day',strtotime($endDate)));
			}
		}

		if($html==''){
			$html.='<div class="kode-alert kode-alert-icon alert6-light">
            <i class="fa fa-lock"></i>
            <a href="javascript:void(0)" class="closed">×</a>
            No data available.
          </div>';
		}

		return Response::json(['status'=>'success','html'=>$html,'groupName'=>$groupRecord->groupName." - Student Task Status",'statusHtml'=>$statusHtml]);
	}

	public function taskstatustrackerreport(Request $req){
        $input=$req['data'];
		$tasktype = $input['selecttask'];
		$html='';
		$trackerdataId = $input['taskname'];
		$groupRecord=Dailytaskstracker::where('id',$input['taskname'])->where('tasktype', $tasktype)->first();
		if(!$groupRecord){
			return Response::json(['status'=>'failed', 'msg'=>'records not found for selected date']);
		}


		$taskType = $input['selecttask'];
		$selectedDate = [];
		$currentDate = date('Y-m-d');
		$phpDays = [1=>'Monday', 2=>'Tuesday', 3=>'Wednesday', 4=>'Thursday', 5=>'Friday', 6=>'Saturday', 7=>'Sunday'];
		if($taskType == 'daily'){
			$i = 0;
			$day = $groupRecord->day;
			$selectedDays = [];
			if($day != ''){
				$selectedDays = explode(',', $day);
			}
			while($i < 7){
				$da = date('Y-m-d', strtotime('-'.$i.' day', strtotime($currentDate)));
				$day = date('N', strtotime($da));
				if($groupRecord->startDate <= $da && $groupRecord->endDate >= $da && in_array($day, $selectedDays)){
					array_push($selectedDate, $da);
				} 
				$i++;
			}
		}else if($taskType == 'weekly'){
			$day = $groupRecord->day;
			$phpDay = $phpDays[$day];

			//First Day
			if(date('N') == $day){
				$lastDate = date('Y-m-d');
			}else{
				$lastDate = date('Y-m-d',strtotime('last '.$phpDay));
			}
			if($groupRecord->startDate <= $lastDate && $groupRecord->endDate >= $lastDate){
				array_push($selectedDate, $lastDate);
			}

			
			 

			//Second Day
			$lastDate = date('Y-m-d',strtotime('-7 day', strtotime($lastDate)));
			if($groupRecord->startDate <= $lastDate && $groupRecord->endDate >= $lastDate){
				array_push($selectedDate, $lastDate);
			}

			//Third Day
			$lastDate = date('Y-m-d',strtotime('-7 day', strtotime($lastDate)));
			if($groupRecord->startDate <= $lastDate && $groupRecord->endDate >= $lastDate){
				array_push($selectedDate, $lastDate);
			}
		}else if($taskType == 'monthly'){

			$day = $groupRecord->day;
			$currentDay = date('j');
			$currentMonth = date('n');
			$currentYear = date('Y');

			$lastDate = '';

			if($currentDay < $day){
				if($currentMonth == 1){
					$currentMonth = 12;
					$currentYear--;
				}else{
					$currentMonth--;
				}
			}

			//First Day
			$lastDate = date('Y-m-d', strtotime($currentYear."-".$currentMonth."-".$day));
			if($groupRecord->startDate <= $lastDate && $groupRecord->endDate >= $lastDate){
				array_push($selectedDate, $lastDate);
			} 

			//Second Day
			if($currentMonth == 1){
				$currentMonth = 12;
				$currentYear--;
			}else{
				$currentMonth--;
			}
			$lastDate = date('Y-m-d', strtotime($currentYear."-".$currentMonth."-".$day));
			if($groupRecord->startDate <= $lastDate && $groupRecord->endDate >= $lastDate){
				array_push($selectedDate, $lastDate);
			}

			//Third Day
			if($currentMonth == 1){
				$currentMonth = 12;
				$currentYear--;
			}else{
				$currentMonth--;
			}
			$lastDate = date('Y-m-d', strtotime($currentYear."-".$currentMonth."-".$day));
			if($groupRecord->startDate <= $lastDate && $groupRecord->endDate >= $lastDate){
				array_push($selectedDate, $lastDate);
			}
		}




		$student = Dailytasksstudent::where('trackerId',$input['taskname'])->lists('studentId');
		//$studentalternative = Dailytasksstudent::where('trackerId',$input['taskname'])->whereIn('studentId',$student)->lists('alternative_name');
		// $students=Dailytaskstracker::where('serialNo',$input['taskname'])->lists('students');
		$options=Dailytasksmetatracker::where('trackerId',$input['taskname'])->lists('optionName','id');
		$totalStatus=Dailytasksstatustracker::where('trackerId',$input['taskname'])->get();
		$trackerData = Dailytasksstatustracker::with('getTracker','getStudent','getOption')->where('trackerId',$input['taskname'])->groupBy('trackerId')->get();
		
		$studentId = '';
		$studentdetail = Students::where('code', Auth::user()->user_id)->where('status', 'active')->first();
		if($studentdetail){
			$studentId = $studentdetail->id;
		}

		// $updatestatus = 'yes';
		// $statuserror = '';
		// if($tasktype == 'daily'){
		// 	$day = date('N', strtotime($taskDate));
		// 	$days = $groupRecord->day;
		// 	$selectedDays = [];
		// 	if($days != ''){
		// 		$selectedDays = explode(',', $days);
		// 	}
		// 	if(!in_array($day, $selectedDays)){
		// 		$updatestatus = 'no';
		// 		$statuserror = 'Login On Correct Date And Update';
		// 	}
		// }elseif($tasktype == 'weekly'){
		// 	$day = date('N', strtotime($taskDate));
		// 	if($day != $groupRecord->day){
		// 		$updatestatus = 'no';
		// 		$statuserror = 'Weekly TrackerUpdated On '.$this->weekdays[$groupRecord->day];
		// 	}
		// }elseif($tasktype == 'monthly'){
		// 	$day = date('j', strtotime($taskDate));
		// 	if($day != $groupRecord->day){
		// 		$updatestatus = 'no';
		// 		$statuserror =  'Weekly TrackerUpdated On '.date('l',strtotime($groupRecord->day));
		// 	}
		// }

		// if($updatestatus == 'no'){
		// 	$studentId = '';
		// }

		$statuserror = '';
		if(count($selectedDate) == 0){
			$statuserror = 'No records available';
		}

		$taskDetails = [];
		$selectedDateArray = [];
		foreach($selectedDate as $sedate){
			$array = [];
			$array['dateFormat'] = date('d-M-Y', strtotime($sedate));
			$array['date'] = $sedate;
			foreach($student as $stu){
				$studentalternative = Dailytasksstudent::where('trackerId',$input['taskname'])->where('studentId',$stu)->first();
				$studentadata = '';
				if($studentalternative){
					$studentadata = $studentalternative->alternative_name;
				}
				foreach($options as $opkey=>$opval){
					$check = Studenttracker::where('taskId', $input['taskname'])->where('taskDate', $sedate)->where('studentId', $stu)->where('optionId', $opkey)->first();
					$val = '';
					if($check){
						$val = $check->value;
					}else{
						$masterdata = Dailytasksstatustracker::where('trackerId', $input['taskname'])->where('studentId', $stu)->where('optionId', $opkey)->first();
						if($masterdata){
							$val = $masterdata->value;
						}
					}
					$array['result'][$stu]['name'] = Students::getstudentname($stu);
					$array['result'][$stu][$opkey] = $val;
					$array['result'][$stu]['changed'][$opkey] = 'no';
					$array['result'][$stu]['alternative'] =  $studentadata;

					$array['result'][$stu]['bgcolor'][$opkey] = 'white';
					$array['result'][$stu]['textcolor'][$opkey] = 'red';

					if($check){
						$percentage = 0;
						$masterRecord = Dailytasksstatustracker::where('trackerId', $input['taskname'])->where('studentId', $stu)->where('optionId', $opkey)->first();
						if($masterRecord){
							$masterVal = $masterRecord->value;
							$actualVal = $check->value;
							if($masterVal > 0){
								$percentage = ($actualVal/$masterVal)*100;
							}
							$trackerTypeRecord = Dailytasksmetatracker::find($opkey);
							if($trackerTypeRecord){
								 $re = Option::where('id',$trackerTypeRecord->option_type)->first();
	                                if($re){
	                                    $type = $re->type;
									if($type == 'alpha'){
									$array['result'][$stu]['bgcolor'][$opkey] = 'white';
									$array['result'][$stu]['textcolor'][$opkey] = 'red';
									}else{
									$color = Trackerpercentage::getcolor($input['taskname'], $type, $percentage);
									$array['result'][$stu]['bgcolor'][$opkey] = $color;
									$array['result'][$stu]['textcolor'][$opkey] = 'white';
									}

								}
							}
						}
					}
				}
			}
			$selectedDateArray[$sedate] = $array;
		}
		$taskDetails = $selectedDateArray;
		return Response::json(['status'=>'success','totalStatus'=> $totalStatus,'trackerData'=>$trackerData, 'taskDetails'=>$taskDetails, 'options'=>$options, 'loginstudentId'=>$studentId, 'statuserror'=>$statuserror, 'selectedDate'=>$selectedDate ]);
	}

	public function taskstatustrackerreportdata(Request $req){
        $input=$req['data'];
		$tasktype = $input['selecttask'];
		$html='';
		$trackerdataId = $input['taskname'];
		$groupRecord=Dailytaskstracker::where('id',$input['taskname'])->where('tasktype', $tasktype)->first();
		if(!$groupRecord){
			return Response::json(['status'=>'failed', 'msg'=>'records not found for selected date']);
		}


		$taskType = $input['selecttask'];
		$selectedDate = [];
		$currentDate = date('Y-m-d');
		$phpDays = [1=>'Monday', 2=>'Tuesday', 3=>'Wednesday', 4=>'Thursday', 5=>'Friday', 6=>'Saturday', 7=>'Sunday'];
		if($taskType == 'daily'){
			$i = 0;
			$day = $groupRecord->day;
			$selectedDays = [];
			if($day != ''){
				$selectedDays = explode(',', $day);
			}
			while($i < 7){
				$da = date('Y-m-d', strtotime('-'.$i.' day', strtotime($currentDate)));
				$day = date('N', strtotime($da));
				if($groupRecord->startDate <= $da && $groupRecord->endDate >= $da && in_array($day, $selectedDays)){
					array_push($selectedDate, $da);
				} 
				$i++;
			}
		}else if($taskType == 'weekly'){
			$day = $groupRecord->day;
			$phpDay = $phpDays[$day];

			//First Day
			if(date('N') == $day){
				$lastDate = date('Y-m-d');
			}else{
				$lastDate = date('Y-m-d',strtotime('last '.$phpDay));
			}
			if($groupRecord->startDate <= $lastDate && $groupRecord->endDate >= $lastDate){
				array_push($selectedDate, $lastDate);
			}

			
			 

			//Second Day
			$lastDate = date('Y-m-d',strtotime('-7 day', strtotime($lastDate)));
			if($groupRecord->startDate <= $lastDate && $groupRecord->endDate >= $lastDate){
				array_push($selectedDate, $lastDate);
			}

			//Third Day
			$lastDate = date('Y-m-d',strtotime('-7 day', strtotime($lastDate)));
			if($groupRecord->startDate <= $lastDate && $groupRecord->endDate >= $lastDate){
				array_push($selectedDate, $lastDate);
			}
		}else if($taskType == 'monthly'){

			$day = $groupRecord->day;
			$currentDay = date('j');
			$currentMonth = date('n');
			$currentYear = date('Y');

			$lastDate = '';

			if($currentDay < $day){
				if($currentMonth == 1){
					$currentMonth = 12;
					$currentYear--;
				}else{
					$currentMonth--;
				}
			}

			//First Day
			$lastDate = date('Y-m-d', strtotime($currentYear."-".$currentMonth."-".$day));
			if($groupRecord->startDate <= $lastDate && $groupRecord->endDate >= $lastDate){
				array_push($selectedDate, $lastDate);
			} 

			//Second Day
			if($currentMonth == 1){
				$currentMonth = 12;
				$currentYear--;
			}else{
				$currentMonth--;
			}
			$lastDate = date('Y-m-d', strtotime($currentYear."-".$currentMonth."-".$day));
			if($groupRecord->startDate <= $lastDate && $groupRecord->endDate >= $lastDate){
				array_push($selectedDate, $lastDate);
			}

			//Third Day
			if($currentMonth == 1){
				$currentMonth = 12;
				$currentYear--;
			}else{
				$currentMonth--;
			}
			$lastDate = date('Y-m-d', strtotime($currentYear."-".$currentMonth."-".$day));
			if($groupRecord->startDate <= $lastDate && $groupRecord->endDate >= $lastDate){
				array_push($selectedDate, $lastDate);
			}
		}




		$student = Dailytasksstudent::where('trackerId',$input['taskname'])->get();
		//$studentalternative = Dailytasksstudent::where('trackerId',$input['taskname'])->whereIn('studentId',$student)->lists('alternative_name');
		// $students=Dailytaskstracker::where('serialNo',$input['taskname'])->lists('students');
		$options=Dailytasksmetatracker::where('trackerId',$input['taskname'])->orderBy('id', 'ASC')->lists('optionName','id');
		$totalStatus=Dailytasksstatustracker::where('trackerId',$input['taskname'])->get();
		$trackerData = Dailytasksstatustracker::with('getTracker','getStudent','getOption')->where('trackerId',$input['taskname'])->groupBy('trackerId')->get();
		
		$studentId = '';
		$studentdetail = Students::where('code', Auth::user()->user_id)->where('status', 'active')->first();
		if($studentdetail){
			$studentId = $studentdetail->id;
		}

		// $updatestatus = 'yes';
		// $statuserror = '';
		// if($tasktype == 'daily'){
		// 	$day = date('N', strtotime($taskDate));
		// 	$days = $groupRecord->day;
		// 	$selectedDays = [];
		// 	if($days != ''){
		// 		$selectedDays = explode(',', $days);
		// 	}
		// 	if(!in_array($day, $selectedDays)){
		// 		$updatestatus = 'no';
		// 		$statuserror = 'Login On Correct Date And Update';
		// 	}
		// }elseif($tasktype == 'weekly'){
		// 	$day = date('N', strtotime($taskDate));
		// 	if($day != $groupRecord->day){
		// 		$updatestatus = 'no';
		// 		$statuserror = 'Weekly TrackerUpdated On '.$this->weekdays[$groupRecord->day];
		// 	}
		// }elseif($tasktype == 'monthly'){
		// 	$day = date('j', strtotime($taskDate));
		// 	if($day != $groupRecord->day){
		// 		$updatestatus = 'no';
		// 		$statuserror =  'Weekly TrackerUpdated On '.date('l',strtotime($groupRecord->day));
		// 	}
		// }

		// if($updatestatus == 'no'){
		// 	$studentId = '';
		// }

		$statuserror = '';
		if(count($selectedDate) == 0){
			$statuserror = 'No records available';
		}

		$taskDetails = [];
		$selectedDateArray = [];
		foreach($selectedDate as $sedate){
			$array = [];
			//$k = 0;
			foreach($student as $stu){
				$k = $stu->id;
				$array[$k]['studentId'] = $stu->studentId;
				$array[$k]['name'] = Students::getstudentname($stu->studentId);
				$array[$k]['alternativename'] = $stu->alternative_name;
				$array[$k]['type'] = $stu->type;
				
				foreach($options as $opkey=>$opval){
					//Find Value

				 	$check = Studenttracker::where('taskId', $input['taskname'])->where('taskDate', $sedate)->where('studentId', $stu->studentId)->where('optionId', $opkey)->where('type',$stu->type)->where('alternativeId',$stu->id)->first();
					$val = '';
					if($check){
						$val = $check->value;
					}else{
						 $masterdata = Dailytasksstatustracker::where('trackerId', $input['taskname'])->where('studentId', $stu->studentId)->where('optionId', $opkey)->where('alternativeId',$stu->id)->first();
						if($masterdata){
							$val = $masterdata->value;
						}
					}
					$array[$k]['options'][$opkey]['changed'] = 'no';
					$array[$k]['options'][$opkey]['opt'] = $val;
					$array[$k]['options'][$opkey]['alternativeId'] = $stu->id;
					$array[$k]['options'][$opkey]['bgcolor'] = 'white';
					$array[$k]['options'][$opkey]['textcolor'] = 'red';

					if($check){
						$percentage = 0;
						$masterRecord = Dailytasksstatustracker::where('trackerId', $input['taskname'])->where('studentId', $stu->studentId)->where('optionId', $opkey)->where('alternativeId',$stu->id)->first();
						if($masterRecord){
							$masterVal = $masterRecord->value;
							$actualVal = $check->value;
							if($masterVal > 0){
								$percentage = ($actualVal/$masterVal)*100;
							}
							$se = Option::where('id',$stu->type)->first();
							$se->type;
							if($se->type == 'alpha'){
								$array[$k]['options'][$opkey]['bgcolor'] = 'white';
								$array[$k]['options'][$opkey]['textcolor'] = 'red';
							}else{
								$color = Trackerpercentage::getcolor($input['taskname'], $se->type, $percentage);
								$array[$k]['options'][$opkey]['bgcolor'] = $color;
								$array[$k]['options'][$opkey]['textcolor'] = 'white';
							}
						}
					}
				}
				$k++;
			}
			$selectedDateArray[$sedate]['dateFormat'] = date('d-M-Y', strtotime($sedate));
			$selectedDateArray[$sedate]['date'] = $sedate;
			$selectedDateArray[$sedate]['results'] = $array;
		}
		$taskDetails = $selectedDateArray;

		return Response::json(['status'=>'success','totalStatus'=> $totalStatus,'trackerData'=>$trackerData, 'taskDetails'=>$taskDetails, 'options'=>$options, 'loginstudentId'=>$studentId, 'statuserror'=>$statuserror, 'selectedDate'=>$selectedDate ]);
	}

	public function taskstatustrackerreportcolour(Request $req){
        $input=$req['data'];
		$html='';
		$groupRecord=Dailytaskstracker::where('id',$input['taskname'])->first();
		$student = Dailytasksstudent::where('trackerId',$input['taskname'])->lists('studentId');
		// $students=Dailytaskstracker::where('serialNo',$input['taskname'])->lists('students');
		$options=Dailytasksmetatracker::where('trackerId',$input['taskname'])->lists('optionName','id');

		$optionDetails=Dailytasksmetatracker::where('trackerId',$input['taskname'])->select('optionName','id', 'option_type')->get();

		$totalStatus=Dailytasksstatustracker::where('trackerId',$input['taskname'])->get();
		$trackerData = Dailytasksstatustracker::with('getTracker','getStudent','getOption')->where('trackerId',$input['taskname'])->groupBy('trackerId')->get();
		$taskDate='';
		if($input['startDate']!=''){
			$taskDate=date('Y-m-d',strtotime($input['startDate']));
		}
		$studentId = '';
		$studentdetail = Students::where('code', Auth::user()->user_id)->where('status', 'active')->first();
		if($studentdetail){
			$studentId = $studentdetail->id;
		}



		$taskDetails = [];
		$array = [];
		$array['date'] = date('d-M-Y', strtotime($taskDate));
		foreach($student as $stu){
			foreach($optionDetails as $opval){
				$check = Studenttracker::where('taskId', $input['taskname'])->where('taskDate', $taskDate)->where('studentId', $stu)->where('optionId', $opval->id)->first();
				$val = '';
				if($check){
					$val = $check->value;
				}else{
					$masterdata = Dailytasksstatustracker::where('trackerId', $input['taskname'])->where('studentId', $stu)->where('optionId', $opval->id)->first();
					if($masterdata){
						$val = $masterdata->value;
					}
				}
				$array['result'][$stu]['name'] = Students::getstudentname($stu);
				$array['result'][$stu][$opval->id] = $val;

				if($opval->option_type == 2){
					$color = Trackerpercentage::getcolor($input['taskname'], 'cost', $val);
					$array['result'][$stu]['colours'][$opval->id] = $color;
					
				}elseif($opval->option_type == 1){
					$color = Trackerpercentage::getcolor($input['taskname'], 'revenue', $val);
					$array['result'][$stu]['colours'][$opval->id] = $color;
				}
			}
		}
		array_push($taskDetails, $array);

		return Response::json(['status'=>'success','totalStatuscolour'=> $totalStatus,'trackerDatacolour'=>$trackerData, 'taskDetailscolour'=>$taskDetails, 'optionscolour'=>$options, 'loginstudentIdcolour'=>$studentId ]);
	}


	public function studenttrackerreport(Request $req){
        $input=$req['data'];

		$html='';
		$student = Students::where('code', Auth::user()->user_id)->where('status', 'active')->first();
		if($student){
			$taskId = $input['taskname'];
			$startDate = date('Y-m-d', strtotime($input['startDate']));
        	$endDate = date('Y-m-d', strtotime($input['endDate']));
        	$options = $input['option'];
        	
        	$i = 0;
        	$results = [];
        	$results1 = [];
        	while($startDate <= $endDate){
        		$sdate = strtotime($startDate);
        		foreach($options as $optionId){
        			$optionDetails= Dailytasksmetatracker::find($optionId);
		        	$optionName = '';
		        	if($optionDetails){
		        		$optionName = $optionDetails->optionName;
		        	}

		        	$masterdata = Dailytasksstatustracker::where('trackerId', $taskId)->where('studentId', $student->id)->where('optionId', $optionId)->first();
	        		$master = 0;
					if($masterdata){
						$master = $masterdata->value;
					}

					$record = Studenttracker::where('taskId', $taskId)->where('taskDate', $startDate)->where('studentId', $student->id)->where('optionId', $optionId)->first();
					$actual = 0;
					if($record){
						$actual = $record->value;
					}else{
						$actual = $master;
					}

					$percentage = 0;
					if($master > 0){
						$percentage = ($actual/$master)*100; 
					}
					$color = 'label-red';
					if($percentage > 80 && $percentage <= 100){
						$color = 'label-yellow';
					}elseif($percentage > 100){
						$color = 'label-green';
					}

					$results[$i]['date'] = date('d-M-Y', strtotime($startDate));
					$results[$i]['option'] = $optionName;
					$results[$i]['standard'] = $master;
					$results[$i]['actual'] = $actual;
					$results[$i]['variance'] = $master - $actual;
					$results[$i]['percentage'] = round($percentage,2);
					$results[$i]['color'] = $color;

					$d = $sdate;

					$s = [];
					$s['date'] = date('d-M-Y', strtotime($startDate));
					$s['option'] = $optionName;
					$s['standard'] = $master;
					$s['actual'] = $actual;
					$s['variance'] = $master - $actual;
					$s['percentage'] = round($percentage,2);
					$s['color'] = $color;

					if(!isset($results1[$d])){
						$results1[$d][0] = $s;
					}else{
						$results1[$d][count($results1[$d])] = $s;
					}

					$i++;
        		}
        		//arraypush
				$startDate = date('Y-m-d', strtotime('+1 day', strtotime($startDate)));
        	}
			return Response::json(['status'=>'success', 'results'=>$results, 'title'=>$student->fullname." - Tracker Details",'results1'=>$results1]);
		}
		return Response::json(['status'=>'failed', 'message'=>'Please login as a student']);
	}


	public function studentcoursesget(){
		$students=Students::where('status','active')->lists('fullname','id');
		$courses=Courses::where('status','active')->lists('name','id');
		return view('studentCourseReport')->with('students',$students)->with('courses',$courses);
	}


	public function studentcoursespost(Request $req){
		$input=$req->all();
		$records=GroupMember::where('status','active');
		if($input['students']!=''){
			$records=$records->where('studentid',$input['students']);
		}

		if($input['course']!=''){
			$records=$records->where('courseid',$input['course']);
		}

		$records=$records->get();

		$result=[];
		$i=0;
		$dateFormat=Options::getvalue('dateFormat');
		if(count($records)>0){
			foreach($records as $record){
				$courseStatus=CourseComplete::where('group_course_id',$record->group_course_id)->where('student_id',$record->studentid)->first();
				if(count($courseStatus)==1){
					$status='Completed';
					$completedOn=date($dateFormat,$courseStatus->time);
				}else{
					$status='Pending';
					$completedOn='';
				}
				$result[$i]['sno']=$i+1;
				$result[$i]['group']=Group::getgroupname($record->groupid);
				$result[$i]['course']=Courses::getcoursename($record->courseid);
				$result[$i]['student']= Students::getstudentname($record->studentid);
				$result[$i]['status']=$status;
				$result[$i]['completedOn']=$completedOn;
				$i++;
			}

		}
		return Response::json(['result'=>$result,'count'=>count($result)]);
	}

	public function staffgroupsget(){
		$staffs=Staff::where('status','active')->lists('fullname','id');
		return view('staffGroupReport')->with('staffs',$staffs);
	}


	public function staffgroupspost(Request $req){
		$input=$req->all();
		$records=Group::where('status','active');
		if($input['staff']!=''){
			$staffRecord=User::where('userLink',$input['staff'])->where('type','staff')->first();
			if(count($staffRecord)==1){
				$records=$records->where('group_admin',$staffRecord->id);
			}
		}

		$records=$records->get();

		$result=[];
		$i=0;
		$dateFormat=Options::getvalue('dateFormat');
		if(count($records)>0){
			foreach($records as $record){
				$totalCourses=GroupCourse::where('group_id',$record->id)->where('status','active')->count();
				$staffName='';
				$staffDetails=User::find($record->group_admin);
				if(count($staffDetails)==1){
					$staffName=$staffDetails->full_name;
				}
				$result[$i]['sno']=$i+1;
				$result[$i]['name']=$record->group_name;
				$result[$i]['staff']=$staffName;
				$result[$i]['description']=$record->group_short_description;
				$result[$i]['courses']= $totalCourses;
				$i++;
			}

		}
		return Response::json(['result'=>$result,'count'=>count($result)]);
	}


	public function staffcoursesget(){
		$staffs=Staff::where('status','active')->lists('fullname','id');
		$courses=Courses::where('status','active')->lists('name','id');
		return view('staffCourseReport')->with('staffs',$staffs)->with('courses',$courses);
	}


	public function staffcoursespost(Request $req){
		$input=$req->all();
		$records=GroupCourse::where('status','active');
		if($input['staff']!=''){
			$staffRecord=User::where('userLink',$input['staff'])->where('type','staff')->first();
			if(count($staffRecord)==1){
				$records=$records->where('admin',$staffRecord->id);
			}
		}

		if($input['course']!=''){
			$records=$records->where('course_id',$input['course']);
		}

		$records=$records->get();

		$result=[];
		$i=0;
		$dateFormat=Options::getvalue('dateFormat');
		if(count($records)>0){
			foreach($records as $record){
				$totalStudents=GroupMember::where('group_course_id',$record->id)->where('status','active')->count();
				$startDate='';
				$endDate='';
				if($record->start_date!=''){
					$startDate=date($dateFormat,$record->start_date);
				}

				if($record->end_date!=''){
					$endDate=date($dateFormat,$record->end_date);
				}

				$staffName='';
				$staffDetails=User::find($record->admin);
				if(count($staffDetails)==1){
					$staffName=$staffDetails->full_name;
				}
				$result[$i]['sno']=$i+1;
				$result[$i]['group']=Group::getgroupname($record->group_id);
				$result[$i]['staff']=$staffName;
				$result[$i]['course']=Courses::getcoursename($record->course_id);
				$result[$i]['students']= $totalStudents;
				$result[$i]['startDate']=$startDate;
				$result[$i]['endDate']=$endDate;
				$i++;
			}

		}
		return Response::json(['result'=>$result,'count'=>count($result)]);
	}



	public function completedcoursesget(){
		$groups=Group::where('status','active')->lists('group_name','id');
		return view('completedCoursesReport')->with('groups',$groups);
	}


	public function completedcoursespost(Request $req){
		$input=$req->all();
		$records=GroupCourse::where('status','active');

		if($input['group']!=''){
			$records=$records->where('group_id',$input['group']);
		}
		$records=$records->get();

		$result=[];
		$i=0;
		$dateFormat=Options::getvalue('dateFormat');
		if(count($records)>0){
			foreach($records as $record){
				$totalStudents=GroupMember::where('group_course_id',$record->id)->where('status','!=','deleted')->where('status','!=','rejected')->count();
				$completedStudents=CourseComplete::where('group_course_id',$record->id)->count();
				if($totalStudents==$completedStudents && $totalStudents>0){
					$startDate='';
					$endDate='';
					if($record->start_date!=''){
						$startDate=date($dateFormat,$record->start_date);
					}

					if($record->end_date!=''){
						$endDate=date($dateFormat,$record->end_date);
					}
					$result[$i]['sno']=$i+1;
					$result[$i]['group']=Group::getgroupname($record->group_id);
					$result[$i]['course']=Courses::getcoursename($record->course_id);
					$result[$i]['students']= $totalStudents;
					$result[$i]['startDate']=$startDate;
					$result[$i]['endDate']=$endDate;
					$i++;
				}
			}
		}
		return Response::json(['result'=>$result,'count'=>count($result)]);
	}



	public function pendingcoursesget(){
		$groups=Group::where('status','active')->lists('group_name','id');
		return view('pendingCoursesReport')->with('groups',$groups);
	}


	public function pendingcoursespost(Request $req){
		$input=$req->all();
		$records=GroupCourse::where('status','active');

		if($input['group']!=''){
			$records=$records->where('group_id',$input['group']);
		}
		$records=$records->get();

		$result=[];
		$i=0;
		$dateFormat=Options::getvalue('dateFormat');
		if(count($records)>0){
			foreach($records as $record){
				$totalStudents=GroupMember::where('group_course_id',$record->id)->where('status','active')->count();
				$completedStudents=CourseComplete::where('group_course_id',$record->id)->count();

				if($completedStudents<$totalStudents && $totalStudents>0){
					$startDate='';
					$endDate='';
					if($record->start_date!=''){
						$startDate=date($dateFormat,$record->start_date);
					}

					if($record->end_date!=''){
						$endDate=date($dateFormat,$record->end_date);
					}
					$result[$i]['sno']=$i+1;
					$result[$i]['group']=Group::getgroupname($record->group_id);
					$result[$i]['course']=Courses::getcoursename($record->course_id);
					$result[$i]['students']= $totalStudents;
					$result[$i]['startDate']=$startDate;
					$result[$i]['endDate']=$endDate;
					$i++;
				}
			}
		}
		return Response::json(['result'=>$result,'count'=>count($result)]);
	}

	public function mastersget(){
		$classes=Classname::where('status','active')->lists('class_name','id');
		return view('mastersReport')->with('classes',$classes);
	}

	public function masterspost(Request $req){
		ini_set('memory_limit','1600M');
		$input=$req->all();
		$result=[];
		$records=DB::table('courses')->where('courses.status','=','active');
		if($input['classes']!=''){
			$records=$records->where('courses.class_id','=',$input['classes']);

			if($input['subject']!=''){
				$records=$records->where('courses.subject','=',$input['subject']);

				if($input['categories']!=''){
					$records=$records->where('courses.category','=',$input['categories']);
				}
			}
		}
		$records=$records->leftJoin('class_name', 'class_name.id', '=', 'courses.class_id');
		$records=$records->leftJoin('subjects', 'subjects.id', '=', 'courses.subject');
		$records=$records->leftJoin('categories', 'categories.id', '=', 'courses.category');
		$records=$records->select('courses.name as course','class_name.class_name as class','subjects.name as subject','categories.category_name as category');
		$records=$records->get();
		return $records;
		//return Response::json(['result'=>$records,'count'=>count($records)]);
	}


	public function overduecoursesget(){
		$groups=Group::where('status','active')->lists('group_name','id');
		return view('overdueCoursesReport')->with('groups',$groups);
	}


	public function overduecoursespost(Request $req){
		$input=$req->all();
		$result=[];
		$records=GroupCourse::where('status','active')->where('end_date','!=',0);
		if($input['group']!=''){
			$records=$records->where('group_id',$input['group']);
		}
		$records=$records->get();
		$i=0;
		$dateFormat=Options::getvalue('dateFormat');
		if($input['type']=='course'){
			if(count($records)>0){
				foreach($records as $record){
					$totalStudents=GroupMember::where('group_course_id',$record->id)->where('status','active')->count();
					$completedStudents=CourseComplete::where('group_course_id',$record->id)->count();

					if($completedStudents==$totalStudents){
						$startDate='';
						$endDate='';
						if($record->start_date!=''){
							$startDate=date($dateFormat,$record->start_date);
						}

						if($record->end_date!=''){
							$endDate=date($dateFormat,$record->end_date);
						}
						$result[$i]['sno']=$i+1;
						$result[$i]['group']=Group::getgroupname($record->group_id);
						$result[$i]['course']=Courses::getcoursename($record->course_id);
						$result[$i]['students']= $totalStudents;
						$result[$i]['startDate']=$startDate;
						$result[$i]['endDate']=$endDate;
						$i++;
					}
				}
			}
		}else{
			if(count($records)>0){
				$i=0;
				foreach($records as $record){
					$totalStudents=GroupMember::where('group_course_id',$record->id)->where('status','active')->get();
					foreach($totalStudents as $student){
						$check=CourseComplete::where('group_course_id',$record->id)->where('student_id',$student->studentid)->first();
						$overdue='no';
						$status='Pending';
						if(count($check)==1 && $check->time>$record->end_date){
							$overdue='yes';
							$status='Completed';
						}else if($record->end_date<time()){
							$overdue='yes';
						}

						if($overdue=='yes'){
							$result[$i]['sno']=$i+1;
							$result[$i]['group']=Group::getgroupname($record->group_id);
							$result[$i]['course']=Courses::getcoursename($record->course_id);
							$result[$i]['students']= Students::getstudentname($student->studentid);
							$result[$i]['invitedDate']=date($dateFormat,$student->added_on);
							$result[$i]['status']=$status;
							$result[$i]['overdueDate']=date($dateFormat,$record->end_date);
							$i++;
						}
					}
				}
			}
		}
		return Response::json(['result'=>$result,'count'=>count($result)]);
	}


	public function studentdailytasksget(){
		$groups=Dailytasks::where('status','active')->where('students',Auth::user()->userLink)->get();
		return view('StudentDailyTasks')->with(['groups'=>$groups]);
	}


	public function getdailygroupoptions(Request $req){
		$input=$req->all();
		$options=Dailytasksmeta::where('serialNo',$input['group'])->lists('optionName','id');
		$status=Dailytasksstatus::where('serialNo',$input['group'])->lists('name','id');
		$html='';
		if(count($status)>0){
			$html.=' <label for="status" class="form-label">Status *</label>';
			foreach($status as $key=>$sta){
				$html.=' &nbsp;<input name="status" type="radio" value="'.$key.'" id="status">&nbsp;'.$sta.'&nbsp;&nbsp;&nbsp;';
			}
		}
		
		return Response::json(['options'=>$options,'status'=>$html]);
	}

	public function getdailytaskstatuspost(Request $req){
		$input=$req->all();
		$currentStatus='';
		if($input['group']!='' && $input['statusDate']!='' && $input['option']!=''){
			$statusDate=date('Y-m-d',strtotime($input['statusDate']));
			$statusRecord=Dailytasksresult::where('statusDate',$statusDate)->where('optionId',$input['option'])->where('studentId',Auth::user()->userLink)->where('serialNo',$input['group'])->first();
			if(count($statusRecord)==1){
				$currentStatus=$statusRecord->statusId;
			}else{
				$status=Dailytasksstatus::where('serialNo',$input['group'])->first();
				if(count($status)==1){
					$currentStatus=$status->id;
				}
			}
		}

		return Response::json(['currentStatus'=>$currentStatus]);
	}


	public function dailytaskupdatepost(Request $req){
		$input=$req->all();
		$rules=['dailyGroup'=>'required','option'=>'required','statusDate'=>'required'];
	    $validation= Validator::make($input,$rules);
	    if($validation->fails()){
	      return back()->withErrors($validation,'add')->withInput()->with('taskserror','add_row');
	    }
	    $statusDate=date('Y-m-d',strtotime($input['statusDate']));
	    $statusRecord=Dailytasksresult::where('statusDate',$statusDate)->where('optionId',$input['option'])->where('studentId',Auth::user()->userLink)->where('serialNo',$input['dailyGroup'])->first();

	    if(count($statusRecord)==1){
	    	$update=Dailytasksresult::find($statusRecord->id);
	    	$update->statusId=$input['status'];
	    	$update->save();
	    }else{
	    	$insert=new Dailytasksresult();
		    $insert->serialNo=$input['dailyGroup'];
		    $insert->studentId=Auth::user()->userLink;
		    $insert->optionId=$input['option'];
		    $insert->statusDate=$statusDate;
		    $insert->statusId=$input['status'];
		    $insert->save();
	    }
	    return back()->with('success','Daily task updated.')->with('taskserror','add_row');
	}


	public function studentcoursetaskget(){
		$groups=GroupMember::where('status','active')->where('studentid',Auth::user()->userLink)->groupBy('groupid')->lists('groupid');
		$groupDetails=[];
		foreach($groups as $group){
			$name=Group::getgroupname($group);
			$groupDetails[$group]=$name;
		}
		return view('studentCourseTasks')->with(['groups'=>$groupDetails]);
	}

	public function studentgroupcourseget(Request $req){
		$input=$req->all();
		$courses=GroupMember::where('groupid',$input['group'])->where('studentid',Auth::user()->userLink)->where('status','active')
		->lists('courseid');
		$courseDetails=[];
		foreach($courses as $course){
			$name=Courses::getcoursename($course);
			$courseDetails[$course]=$name;
		}
		return Response::json(['courses'=>$courseDetails]);
	}


	public function getstudentcoursetask(Request $req){
		$input=$req->all();
		$html='';
		$groupId=$input['group'];
		$courseId=$input['course'];
		$dateFormat=Options::getvalue('dateFormat');
		$tasks=GroupPost::where('post_type','task')->where('group_id',$groupId)->where('course_id',$courseId)->get();
		$taskCount=count($tasks);
        $i=0;
        if($taskCount>0){
        	foreach($tasks as $task){
        		$userName=User::find($task->author)->full_name;
	            $comments=GroupComment::where('postid',$task->id)->get();
	            $class='';
	            if($i==0){
	                $class='in';
	            }
	            $i++;
	            $record=TaskComplete::where('student_id',Auth::user()->userLink)->where('post_id',$task->id)->first();
              	$status='Pending';
              	$completedDate='';
              	if(count($record)==1){
                	$status="Completed";
                	$completedDate=date('d M Y, H:i A',$record->time);
              	}
              	$comments=GroupComment::where('postid',$task->id)->get();


	            $html.='<div class="panel panel-default panel-collapse">
                <div class="panel-heading" role="tab" id="heading'.$task->id.'">
                <a data-toggle="collapse" data-parent="#accordion" href="#course'.$task->id.'" aria-expanded="true" aria-controls="collapse'.$task->id.'" class="">
                  <h4 class="panel-title">
                    <i class="fa fa-file"></i>&nbsp; 
                      '.$task->short_description.'
                  </h4>
                  </a>
                </div>
                <div id="course'.$task->id.'" class="panel-collapse collapse '.$class.'" role="tabpanel" aria-labelledby="heading'.$task->id.'" aria-expanded="true">
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-md-3">
                      <p class="course_info"><i class="fa fa-calendar"></i><b>Due Date:</b>'.date($dateFormat,strtotime($task->dueDate)).'</p>
                      </div>
                      <div class="col-md-3">
                      <p class="course_info"><i class="fa fa-calendar"></i><b>Posted On:</b> '.date($dateFormat,$task->time).'</p>
                      </div>
                      <div class="col-md-3">
                      <p class="course_info"><i class="fa fa-calendar"></i><b>Status:</b> '.$status.'</p>
                      </div>';
                      if($completedDate==''){
                      	$html.='<div class="col-md-3">
                      <p class="course_info"><i class="fa fa-calendar"></i><b>Marked as Completed:</b></p>
                      </div>';	
                      }else{
                      	$html.='<div class="col-md-3">
                      <p class="course_info"><i class="fa fa-calendar"></i><b>Completed Date:</b>'.$completedDate.'</p>
                      </div>';
                      }
                      
                    $html.='</div>
                    '.$task->text.' 

                    <h4 class="commentTitle'.$task->id.'"><b>Comments&nbsp;('.count($comments).')</b></h4>
                  <ul class="mailbox-inbox">';
                    foreach($comments as $comment){
                    	$userName=User::find($comment->commenter)->full_name;
                    	$html.='<li>
                        <a href="javascript:void(0)" class="item clearfix">
                          <img src="'.User::getprofileimage($comment->commenter).'" alt="'.$userName.'" class="img">
                          <span class="from">'.$userName.'</span>
                          '.$comment->comment.'
                          <span class="date">'.date('d M Y, H:i A',$comment->time).'</span>
                        </a>
                      </li>';
                    }
                      
                      $html.='<li>
                        <a href="javascript:void(0)" class="item clearfix">
                          <img src="'.User::getprofileimage(Auth::user()->id).'" alt="'.Auth::user()->full_name.'" class="img">
                          <span class="from">'.Auth::user()->full_name.'</span>
                          <br/>
                          <p><input type="text" class="form-control comment'.$task->id.'" placeholder="Post your comment..."></p>
                          <input type="button" class="btn btn-default saveComment" id="'.$task->id.'" data-panel="task" value="Submit">
                        </a>
                      </li>
                      
                  </ul>

                  </div>
                </div>
              </div>';
        	}
        }else{
        	$html.='<div class="kode-alert kode-alert-icon alert6-light">
	        <i class="fa fa-lock"></i>
	        <a href="javascript:void(0)" class="closed">×</a>
	        No task details available.
	      </div>';
        }
        return Response::json(['html'=>$html]);
          
	}


	public function addstudenttaskcommentpost(Request $req){
		$input=$req->all();
		$insert=new GroupComment();
		$insert->postid=$input['postId'];
		$insert->commenter=Auth::user()->id;
		$insert->comment=$input['message'];
		$insert->time=time();
		$insert->save();
		$userName=User::find($insert->commenter)->full_name;

		$count=GroupComment::where('postid',$insert->postid)->count();

		$commentTitle='<b>Comments&nbsp;('.$count.')</b>';
		$html='<li>
                <a href="javascript:void(0)" class="item clearfix">
                  <img src="'.User::getprofileimage($insert->commenter).'" alt="'.$userName.'" class="img">
                  <span class="from">'.$userName.'</span>
                  '.$insert->comment.'
                  <span class="date">'.date('d M Y, H:i A',$insert->time).'</span>
                </a>
              </li>';
		return Response::json(['status'=>'success','html'=>$html,'commentTitle'=>$commentTitle]);
	}


	public function getdailytaskdetails(Request $req){
		return $input=$req->all();
		$completedDetails=CourseComplete::where('group_course_id',$input['course'])->where('student_id',$input['student'])->first();
		if(count($completedDetails)==1){
			$status='completed';
			$completedDate=date('d-m-Y',$completedDetails->time);
		}else{
			$status='pending';
			$completedDate='';
		}

		$groupName='';
		$courseName='';
		$groupCourse=GroupCourse::find($input['course']);
		if(count($groupCourse)==1){
			$groupName=Group::getgroupname($groupCourse->group_id);
			$courseName=Courses::getcoursename($groupCourse->course_id);
		}
		return Response::json(['courseName'=>$courseName,'groupName'=>$groupName,'completedDate'=>$completedDate,'status'=>$status]);
	}

	public function getdailytaskdetailsget(Request $req){
		$input=$req->all();

		$groupName = Dailytasks::getgroupname($input['group']);
		$optionName = Dailytasksmeta::getoptionname($input['option']);
		$taskTime = date('Y-m-d', $input['time']);
		$optionDetails = Dailytasksmeta::find($input['option']);
		$serialNo = '';
		if($optionDetails){
			$serialNo = $optionDetails->serialNo;
		}
		$result = Dailytasksresult::where('statusDate', $taskTime)->where('serialNo', $serialNo)->where('studentId', Auth::user()->userLink)->where('optionId', $input['option'])->first();
		$currentStatus = '';
		if($result){
			$currentStatus = $result->statusId;
		}
		$taskStatus = '';
		$status = Dailytasksstatus::where('serialNo', $serialNo)->get();
		foreach($status  as $st){
			$taskStatus .= '<input name="taskStatus" type="radio" value="'.$st->id.'" id="taskStatus">&nbsp;'.$st->name.'&nbsp;&nbsp;&nbsp;';
		}
		return Response::json(['optionName'=>$optionName,'groupName'=>$groupName,'taskTime'=>$taskTime,'html'=>$taskStatus, 'currentStatus'=>$currentStatus]);
	}


	public function updatestudenttaskstatus(Request $req){
		$input=$req->all();
	    $statusDate=date('Y-m-d',$input['time']);
	    $statusRecord=Dailytasksresult::where('statusDate',$statusDate)->where('optionId',$input['option'])->where('studentId',Auth::user()->userLink)->where('serialNo',$input['group'])->first();

	    if(count($statusRecord)==1){
	    	$update=Dailytasksresult::find($statusRecord->id);
	    	$update->statusId=$input['status'];
	    	$update->save();
	    }else{
	    	$insert=new Dailytasksresult();
		    $insert->serialNo=$input['group'];
		    $insert->studentId=Auth::user()->userLink;
		    $insert->optionId=$input['option'];
		    $insert->statusDate=$statusDate;
		    $insert->statusId=$input['status'];
		    $insert->save();
	    }
	    $statusRecord=Dailytasksstatus::find($input['status']);
	    $color='';
	    if(count($statusRecord)==1){
	    	$color=$statusRecord->color;
	    }


	    $completedby = User::where('userLink',Auth::user()->userLink)->first()->full_name;
        $groupinfo = Dailytasks::where('serialNo',$input['group'])->first();
        $groupname = $groupinfo->groupName;
        $userinfo = User::find($groupinfo->createdBy);
        if($userinfo && $userinfo->deviceToken != ''){
            $payload = (object) array('type' => 'dailytaskcomplete');
            $platform = ($userinfo->platform == 'android') ? 1 : 0;
            $data = array('platform' => $platform, 
                          'token' => $userinfo->deviceToken,
                          'msg'=> $completedby.' has updated a daily task in `'.$groupname.'`',
                          'payload' => $payload);

            // use key 'http' even if you send the request to https://...
            $options = array(
                'http' => array(
                    'header'  => "Content-Type: application/x-www-form-urlencoded\r\n" .
                                 "X-PUSHBOTS-APPID: ".env('PUSHBOTS_ID')."\r\n" .
                                 "X-PUSHBOTS-SECRET: ".env('PUSHBOTS_SECRET')."\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data),
                ),
            );
            $context  = stream_context_create($options);
            file_get_contents(env('PUSH_URL'), false, $context);
        }
	    return Response::json(['status'=>'success','color'=>$color]);
	}


	//Student Courses

	public function studentassigncourseget($id=null,$panel='course',$course=''){
		$countryBased=Options::getvalue('countryBased');
	   	$memberGroups=GroupMember::where('status','active')->where('studentid',Auth::user()->userLink)->groupBy('groupid')->lists('groupid');
	   	$studentCountry=Students::getstudentcountry(Auth::user()->userLink);
	   	$groups=Group::whereIn('id',$memberGroups);
	   	// if($countryBased=='yes'){
	   	// 	$groups=$groups->where('countryId',$studentCountry);
	   	// }
	   	$groups=$groups->get();
	   	$reqId=$id;
	   	$detail=[];
	   	if($id==null && count($memberGroups)>0){
	   		$reqId=$memberGroups[0];
	   	}
		if($reqId!=''){
	   		$detail=Group::find($reqId);
	   	}
	    return view('studentCourses')->with('groups',$groups)->with('groupId',$reqId)->with('panel',$panel)->with('detail',$detail)->with('courseId',$course);
	}


	public function getcountrystudents(Request $req){
		$input=$req->all();
		$students=Students::where('countryId',$input['country'])->where('status','active')->lists('fullname','id');
		return Response::json(['students'=>$students]);
	}


	public function studentcoursecompletepost(Request $req){
		$input=$req->all();
		$insert=new CourseComplete();
		$insert->group_course_id=$input['groupCourseId'];
		$insert->student_id=Auth::user()->userLink;
		$insert->time=time();
		$insert->save();


		$course = Groupcourse::find($insert->group_course_id);
        $course->increment('completed');
        $studentname = Students::find($insert->student_id)->fullname;
        $userinfo = User::find($course->admin);
        if($userinfo->deviceToken != ''){
            $payload = (object) array('type' => 'coursecomplete');
            $platform = ($userinfo->platform == 'android') ? 1 : 0;
            $data = array('platform' => $platform, 
                          'token' => $userinfo->deviceToken,
                          'msg'=> $studentname.' has completed a course `'.$course->course_name.'`',
                          'payload' => $payload);
            // use key 'http' even if you send the request to https://...
            $options = array(
                'http' => array(
                    'header'  => "Content-Type: application/x-www-form-urlencoded\r\n" .
                                 "X-PUSHBOTS-APPID: ".env('PUSHBOTS_ID')."\r\n" .
                                 "X-PUSHBOTS-SECRET: ".env('PUSHBOTS_SECRET')."\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data),
                ),
            );
            $context  = stream_context_create($options);
            file_get_contents(env('PUSH_URL'), false, $context);
        }
		return Response::json(['status'=>'success']);
	}

	public function studenttaskcompletepost(Request $req){
		$input=$req->all();
		$insert=new TaskComplete();
		$insert->post_id=$input['postId'];
		$insert->student_id=Auth::user()->userLink;
		$insert->time=time();
		$insert->save();
		return Response::json(['status'=>'success']);
	}



	public function groupcoursestatusget(){
		$groups=[];
		if(Auth::user()->type=='staff'){
			$groups=Group::where('status','active')->where('group_admin',Auth::user()->id)->lists('group_name','id');
		}elseif(Auth::user()->type=='student'){
			$groupIds=GroupMember::where('status','!=','deleted')->where('studentid',Auth::user()->userLink)->groupBy('groupid')->lists('groupid');
			foreach($groupIds as $groupId){
				$groupDetail=Group::find($groupId);
				if(count($groupDetail)==1){
					$groups[$groupId]=$groupDetail->group_name;
				}
			}
		}
		return view('groupCoursesStatus')->with(['groups'=>$groups]);
	}


	public function groupcoursestatusreport(Request $req){
		$group=$req->input('group');
		$groupName=Group::getgroupname($group);
		$html='';
		$courses=[];
		if(Auth::user()->type=='staff'){
			$courses=GroupCourse::where('status','active')->where('group_id',$group)->get();
		}elseif(Auth::user()->type=='student'){
			$courseIds=GroupMember::where('status','!=','deleted')->where('groupid',$group)->groupBy('group_course_id')->lists('group_course_id');
			$courses=GroupCourse::whereIn('id',$courseIds)->get();
		}
		$i=1;
		$dateFormat=Options::getvalue('dateFormat');
		if(count($courses)>0){
			foreach($courses as $course){
				$strtotime=time()+$i;
				$i++;
				$courseName=Courses::getcoursename($course->course_id);
				$html.='<div class="panel panel-default panel-collapse">
				<div class="panel-heading" role="tab" id="heading'.$strtotime.'">
					<a data-toggle="collapse" data-parent="#accordion" href="#course'.$strtotime.'" aria-expanded="true" aria-controls="collapse'.$strtotime.'" class="">
						<h4 class="panel-title">
							<i class="fa fa-file"></i>&nbsp; 
							'.$courseName.'
						</h4>
					</a>
				</div>
				<div id="course'.$strtotime.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'.$strtotime.'" aria-expanded="true">
					<table class="table table-striped">
						<thead>
							<tr>
								<td>Student</td>
								<td>Status</td>
							</tr>
						</thead>
						<tbody>';
							$students=GroupMember::where('group_course_id',$course->id)->where('status','!=','deleted')->get();
							foreach($students as $student){
								$updateStatus='';
								if(Auth::user()->type=='student' && $student->studentid==Auth::user()->userLink){
									$updateStatus='updateStatus';
								}
								$studentColor='#ff0000';
								$completedDate='';
								$courseComplete=CourseComplete::where('group_course_id',$course->id)->where('student_id',$student->studentid)->first();
								if(count($courseComplete)==1){
									$studentColor='#00ff00';
									$completedDate=date($dateFormat,strtotime($courseComplete->time));
								}
								$studentName=Students::getstudentname($student->studentid);
								$html.='<tr>
								<td>'.$studentName.'</td>';
								if($student->studentid==Auth::user()->userLink && Auth::user()->type=='student'){
									$html.='<td><a href="javascript:void(0)" class="label updateStatus" data-course="'.$course->id.'" data-student="'.$student->studentid.'" style="background-color:'.$studentColor.'">&nbsp;&nbsp;&nbsp;</a></td>';
								}else{
									$html.='<td><span class="label" style="background-color:'.$studentColor.'">&nbsp;&nbsp;&nbsp;</span></td>';
								}


							$html.='</tr>';
						}

						$html.='</tbody>
					</table>
				</div>
			</div>';
			}
		}

		if($html==''){
			$html.='<div class="kode-alert kode-alert-icon alert6-light">
            <i class="fa fa-lock"></i>
            <a href="javascript:void(0)" class="closed">×</a>
            No courses available.
          </div>';
		}
		return Response::json(['html'=>$html,'groupName'=>$groupName]);
	}


	public function updatestudentcoursesstatus(Request $req){
		$input=$req->all();
		$delete=CourseComplete::where('group_course_id',$input['course'])->where('student_id',$input['student'])->delete();
		$color='#ff0000';
		if($input['status']=='completed'){
			$update=new CourseComplete();
			$update->group_course_id=$input['course'];
			$update->student_id=$input['student'];
			$update->time=strtotime($input['completedDate']);
			$update->save();
			$color='#00ff00';
		}
	    return Response::json(['status'=>'success','color'=>$color]);
	}


	public function getsubjectsget(){

		$subjects=DB::table('subjects')
		            ->join('class_name', 'class_name.id', '=', 'subjects.classId')
		            ->select('subjects.id','subjects.code','subjects.name', 'class_name.class_name as class')
		            ->where('subjects.status','=','active')
		            ->get();
		return $subjects;
	}

	public function getcategoriesget(){
		$categories=DB::table('categories')
		            ->join('class_name', 'class_name.id', '=', 'categories.parent_class')
		            ->join('subjects', 'subjects.id', '=', 'categories.subject')
		            ->select('categories.id','categories.code','categories.category_name as name','subjects.name as subject', 'class_name.class_name as class')
		            ->where('categories.status','=','active')
		            ->get();
		return $categories;
	}

	public function getcoursesget(){
		ini_set('max_execution_time', 3000000);
		$courses=DB::table('courses')
	            ->leftJoin('class_name', 'class_name.id', '=', 'courses.class_id')
	            ->leftJoin('subjects', 'subjects.id', '=', 'courses.subject')
	            ->leftJoin('categories', 'categories.id', '=', 'courses.category')
	            ->leftJoin('sub_categories', 'sub_categories.id', '=', 'courses.category')
	            ->select('courses.id','courses.code','courses.name','class_name.class_name as class','subjects.name as subject','categories.category_name as category','sub_categories.name as subcategory')
	            ->where('courses.status','=','active')->take('100000')
	            ->get();
		return $courses;
	}


	public function getstaffsget(){
		$staff=DB::table('staff')
		            ->leftJoin('country', 'country.id', '=', 'staff.countryId')
		            ->select('staff.id','staff.code','staff.fullname as name','staff.gender','staff.dob','country.name as country','staff.email')
		            ->where('staff.status','=','active')
		            ->get();
		return $staff;
	}

	public function getstudentsget(){
		$students=DB::table('students')
		            ->leftJoin('country', 'country.id', '=', 'students.countryId')
		            ->select('students.id','students.code','students.fullname as name','students.gender','students.dob','country.name as country','students.email')
		            ->where('students.status','=','active')
		            ->get();
		return $students;
	}


	public function getgrouptaskdetails(Request $req){
		$taskId=$req->input('taskId');
		$task=GroupPost::find($taskId);
		$taskMeta=GroupPostMeta::where('postid',$taskId)->first();
		$shortDescription='';
		$message='';
		$dueDate='';
		$link='';
		if(count($task)==1){
			$shortDescription=$task->short_description;
			$message=$task->text;
			$dueDate=date('d-m-Y',strtotime($task->dueDate));
			if(count($taskMeta)==1 && $taskMeta->video_url!=''){
				$link=$taskMeta->video_url;
			}
		}

		return Response::json(['shortDescription'=>$shortDescription,'message'=>$message,'dueDate'=>$dueDate,'link'=>$link]);
	}


	public function editassigntaskpost(Request $req){
		$input=$req->all();
	    $rules=['shortDescription'=>'required|max:50','course'=>'required','message'=>'required','dueDate'=>'required','youtubeLink'=>'url'];
	    $validation= Validator::make($input,$rules);
	    if($validation->fails()){
	      return Redirect::to('admin/assign/course/get/'.$input['groupId'].'/'.'task/'.$input['course'])->withErrors($validation,'edit')->withInput()->with('classerror','edit_row_task');
	    }
	    $insert=GroupPost::find($input['editTaskId']);
	    $insert->text=$input['message'];
	    $insert->dueDate=date('Y-m-d',strtotime($input['dueDate']));
	    $insert->short_description=$input['shortDescription'];
	    $insert->save();

	    $metaDetails=GroupPostMeta::where('postid',$insert->id)->first();
	    if(count($metaDetails)==1){
		    $insertMeta=GroupPostMeta::find($metaDetails->id);
		    $insertMeta->video_url=$input['youtubeLink'];
		    $insertMeta->due_date=strtotime($input['dueDate']);
		    $insertMeta->save();
		}
	    return Redirect::to('admin/assign/course/get/'.$input['groupId'].'/'.'task/'.$input['course'])->with('taskSuccess','Task details updated successfully');
	}

	public function userprivilege(){
		$users=User::where('status','active')->where('type','staff')->lists('full_name','id');
		return view('userPrivilege')->with('users',$users);
	}


	public function getuserprivilege(Request $req){
		$user=$req->input('user');
		$pages=Pages::all();
		$html='';

		foreach($pages as $page){
			$viewStatus='';
			$addStatus='';
			$editStatus='';
			$deleteStatus='';


			$name=$page->pageName;
			if($name=='class'){
				$name=Options::getvalue('lable1');
			}elseif($name=='subject'){
				$name=Options::getvalue('lable2');
			}


			if(Privilege::getprivilegestatus($page->id,$user,'viewStatus')=='yes'){
				$viewStatus='checked="checked"';
			}

			if(Privilege::getprivilegestatus($page->id,$user,'addStatus')=='yes'){
				$addStatus='checked="checked"';
			}

			if(Privilege::getprivilegestatus($page->id,$user,'editStatus')=='yes'){
				$editStatus='checked="checked"';
			}

			if(Privilege::getprivilegestatus($page->id,$user,'deleteStatus')=='yes'){
				$deleteStatus='checked="checked"';
			}
			$html.='<tr class="pageClass" data-page="'.$page->id.'">
                <td>'.$name.'</td>
                <td><input class="viewClass pageCheckbox" id="view'.$page->id.'" name="view" type="checkbox" value="yes" '.$viewStatus.'></td>
                <td><input class="addClass pageCheckbox" id="add'.$page->id.'" name="add" type="checkbox" value="yes" '.$addStatus.'></td>
                <td><input class="editClass pageCheckbox" id="edit'.$page->id.'" name="edit" type="checkbox" value="yes" '.$editStatus.'></td>
                <td><input class="deleteClass pageCheckbox" id="delete'.$page->id.'" name="delete" type="checkbox" value="yes" '.$deleteStatus.'></td>
              </tr>';
		}

		return Response::json(['html'=>$html]);
	}

	public function saveuserprivilege(Request $req){
		$user=$req->input('user');
		$details=$req->input('details');
		$details=json_decode($details);

		foreach($details as $detail){
			$record=Privilege::where('pageId',$detail->page)->where('userId',$user)->first();

			$viewStatus=0;
			$addStatus=0;
			$editStatus=0;
			$deleteStatus=0;

			if($detail->view=='yes'){ $viewStatus=1; }
			if($detail->add=='yes'){ $addStatus=1; }
			if($detail->edit=='yes'){ $editStatus=1; }
			if($detail->delete=='yes'){ $deleteStatus=1; }

			if(count($record)==1){
				$update=Privilege::find($record->id);
				$update->viewStatus=$viewStatus;
				$update->addStatus=$addStatus;
				$update->editStatus=$editStatus;
				$update->deleteStatus=$deleteStatus;
				$update->save();
			}else{
				$insert= new Privilege();
				$insert->pageId=$detail->page;
				$insert->userId=$user;
				$insert->viewStatus=$viewStatus;
				$insert->addStatus=$addStatus;
				$insert->editStatus=$editStatus;
				$insert->deleteStatus=$deleteStatus;
				$insert->save();
			}
		}
		return Response::json(['success']);
	}

	public function trackerviewAdd(Request $req){
		$input =  $req->data;
		$days =  $input['days'];
		if(isset($input['weekly'])){
			if($input['weekly'] != ''){
			$weekly = $input['weekly'];
			$weeklydays = $weekly['days'];
			}
		}
		if(isset($input['monthly'])){
			if($input['monthly'] != ''){
			$monthly = $input['monthly'];
			$monthlydays = $monthly['days'];
			}
		}
		$weeekDays = [];
		foreach ($days as $value) {
			if (isset($value['selected'])) {
				$data = $value['dayNum'];
				array_push($weeekDays, $data);

			}
			
		}
		 $week = '';
		 if(count($weeekDays) > 0){
		 	$dailydays = implode(",",$weeekDays);
		 }
		 $dailydays;
		 $students = $input['selectstudent'];
	     $option =  $input['optionsList'];
	     $status = $input['studentList'];
	     $op = $option[0]['options'];
	   	 $costdetails = $input['cost'];
	     $revenuedetails = $input['revenue'];


		

	
			        $task = new Dailytaskstracker();
			        $task->groupName = $input['groupname'];
			        $task->taskName = $input['taskname'];
			        $task->tasktype = $input['selecttask'];
			        $task->startDate=date('Y-m-d',strtotime($input['startdate']));
					$task->endDate=date('Y-m-d',strtotime($input['enddate']));
					$task->type = 'x';
					$task->status='active';
					$task->createdBy=Auth::user()->id;
					if($input['selecttask'] == "monthly"){
						$task->day = $monthlydays;
					}elseif ($input['selecttask'] == "weekly") {
						// $weekly = $input['weekly'];
						// $weeklydays = $weekly['days'];
					$task->day = $weeklydays;
					}
					else{

						$task->day =$dailydays;
					}
					$task->save();
					$trackerId = $task->id;

					$optionstoredIds = [];
					foreach($option as $options){
						if($options != '' ){
					        $data = new Dailytasksmetatracker();
						    $data->trackerId = $trackerId;
						    $data->optionName = $options['options'];
						    $data->option_type = $options['list'];
						   $data->save();
						   $optionstoredIds[$options['options']] = $data->id;
						}
					}
					foreach ($costdetails as $cost) {
						if($cost != ''){
							$costdata = new Trackerpercentage();
							$costdata->tracker_id = $trackerId;
							$costdata->start_value = $cost['start'];
							$costdata->end_value = $cost['end'];
							$costdata->colour = $cost['colour'];
							$costdata->tracker_type = 'cost';
							$costdata->save();
						}
						
					}

					foreach ($revenuedetails as $revenue) {
						if($revenue != ''){
							$revenuedata = new Trackerpercentage();
							$revenuedata->tracker_id = $trackerId;
							$revenuedata->start_value = $revenue['start'];
							$revenuedata->end_value = $revenue['end'];
							$revenuedata->colour = $revenue['colour'];
							$revenuedata->tracker_type = 'revenue';
							$revenuedata->save();
						}
						
					}


					foreach($students as $student){
						if($student != '' ){
					        $data = new Dailytasksstudent();
						    $data->trackerId = $trackerId;
						    $data->studentId = $student;
						    foreach($status as $st){
						    	if($student == $st['id']){
						    	$alternativenames = $st['alternative'];
						   	 }
						    }
						    $data->alternative_name = $alternativenames;
							$data->save();

							foreach($option as $op){
								$optionId = $op['options']; // first
								$value = '';
								foreach($status as $st){
									if($student == $st['id']){
										$value = $st[$optionId];
									}
								}
								$ins = new Dailytasksstatustracker();
								$ins->trackerId = $trackerId;
								$ins->studentId = $student;
								$ins->optionId = $optionstoredIds[$optionId];
								$ins->value = $value;
								$ins->save();
							}


						}
					}
					
			
			return response()->json(['success'=>'true']);
	}
	public function trackerviewAddmultiple(Request $req){

		$input =  $req->data;
		$multiplealise = $input['adminstudent'];
		$days =  $input['days'];
		if(isset($input['weekly'])){
			if($input['weekly'] != ''){
			$weekly = $input['weekly'];
			$weeklydays = $weekly['days'];
			}
		}
		if(isset($input['monthly'])){
			if($input['monthly'] != ''){
			$monthly = $input['monthly'];
			$monthlydays = $monthly['days'];
			}
		}
		$weeekDays = [];
		foreach ($days as $value) {
			if (isset($value['selected'])) {
				$data = $value['dayNum'];
				array_push($weeekDays, $data);

			}
			
		}
		 $week = '';
		 if(count($weeekDays) > 0){
		 	$dailydays = implode(",",$weeekDays);
		 }
		 $dailydays;
		 $students = $input['selectstudent'];
	     $option =  $input['optionsList'];
	     $status = $input['studentList'];
	     $op = $option[0]['options'];
	   	 $costdetails = $input['cost'];
	     $revenuedetails = $input['revenue'];


		

	
			        $task = new Dailytaskstracker();
			        $task->groupName = $input['groupname'];
			        $task->taskName = $input['taskname'];
			        $task->tasktype = $input['selecttask'];
			        $task->startDate=date('Y-m-d',strtotime($input['startdate']));
					$task->endDate=date('Y-m-d',strtotime($input['enddate']));
					$task->type = 'y';
					$task->status='active';
					$task->createdBy=Auth::user()->id;
					if($input['selecttask'] == "monthly"){
						$task->day = $monthlydays;
					}elseif ($input['selecttask'] == "weekly") {
						// $weekly = $input['weekly'];
						// $weeklydays = $weekly['days'];
					$task->day = $weeklydays;
					}
					else{

						$task->day =$dailydays;
					}
					$task->save();
					$trackerId = $task->id;

					$optionstoredIds = [];
					foreach($option as $options){
						if($options != '' ){
					        $data = new Dailytasksmetatracker();
						    $data->trackerId = $trackerId;
						    $data->optionName = $options['options'];
						    $data->option_type = $options['list'];
						   $data->save();
						   $optionstoredIds[$options['options']] = $data->id;
						}
					}
					foreach ($costdetails as $cost) {
						if($cost != ''){
							$costdata = new Trackerpercentage();
							$costdata->tracker_id = $trackerId;
							$costdata->start_value = $cost['start'];
							$costdata->end_value = $cost['end'];
							$costdata->colour = $cost['colour'];
							$costdata->tracker_type = 'cost';
							$costdata->save();
						}
						
					}

					foreach ($revenuedetails as $revenue) {
						if($revenue != ''){
							$revenuedata = new Trackerpercentage();
							$revenuedata->tracker_id = $trackerId;
							$revenuedata->start_value = $revenue['start'];
							$revenuedata->end_value = $revenue['end'];
							$revenuedata->colour = $revenue['colour'];
							$revenuedata->tracker_type = 'revenue';
							$revenuedata->save();
						}
						
					}

					foreach($students as $student){
					    foreach($multiplealise as $st){
					    	$data = new Dailytasksstudent();
					    	$data->trackerId = $trackerId;
					    	$data->studentId = $student;
					    	$alternativenames = $st['sname'];
					    	$alternativeoption = $st['list'];
					    	$data->alternative_name = $alternativenames;
					    	$data->type = $alternativeoption;
					    	$data->save();
					    }
					}

					foreach ($students as $student) {
						foreach($option as $opt){
							 $name = $opt['options'];
                            $optionId = $optionstoredIds[$name];

                                foreach($multiplealise as $st){
                                $record = Dailytasksstudent::where('trackerId', $trackerId)->where('studentId', $student)->where('alternative_name', $st['sname'])->first();
                                if($record){
                                    $value = $st[$name];
                                    $ins = new Dailytasksstatustracker();
                                    $ins->trackerId = $trackerId;
                                    $ins->studentId = $student;
                                    $ins->alternativeId = $record->id;
                                    $ins->optionId = $optionId;
                                    $ins->value = $value;
                                    $ins->save();
                                }
                            }
						}
					}
					
			
			return response()->json(['success'=>'true']);

	}

	public function trackerlist(){
		$data = Dailytaskstracker::with('getstudentdata')->get();
		$input = Dailytasksstudent::groupby('trackerId')->get();

		$arr = [];
		foreach($input as $inputs){
			$stlist = Dailytasksstudent::where('trackerId',$inputs->trackerId)->pluck('studentId');
			$a = Students::whereIn('id', $stlist)->pluck('fullName');
			array_push($arr, $a);
			
		}
		
		return view('tracker.list')->with(['records'=>$data])->with('data',$arr);
	}

	public function taskedit($id){
		$students=Students::where('status','active');
		$students=$students->lists('fullname','id');
		$templates=Dailytasks::where('template','yes')->where('createdBy', Auth::id())->groupBy('serialNo')->lists('groupName','serialNo');
		$data = Dailytaskstracker::with('getoption')->with('getstudentdata')->with('getstatus')->where('id',$id)->first();
		return view('tracker.edit')->with('data',$data)->with('student',$students)->with('templates',$templates);

	}

	public function color(){
		return view ('tracker.master.color');
	}
	
	public function option(){
		return view ('tracker.master.option');
	}

	public function addColorValue(Request $request){
		$input = $request->all();
		$colors = $request['data']['colorList'];
		foreach ($colors as $col) {
			$new = new Color();
			$new->key = $col['color_key'] ;
			$new->value = $col['color_value'] ;
			$new->save();
		}

		return response()->json(['status'=>true , 'data'=>$new]);
		
	}
	public function optiontypeadd(){
		return view ('option.add');
	}

	public function optiontypelist(){
		$query = Option::get()->all();
		return view ('option.index',compact('query'));
	}

	public function optiontypestatus(Request $req){
		$input = $req->all();
        $query = Option::find($input["id"])->first();
        $current = $query->status == "active" ?  "inactive" : "active";
        $query->status = $current;
        $query->save();
        return response()->json(["success"=>true, "status"=>$current]);
	}

	public function optiontypeedit($id){

		$query = Option::where('id',$id)->first();

		return view('option.edit',compact('query'));

	}

	public function optiontypedelete($id){
		$query = Option::where('id',$id)->delete();
		return redirect()->back();
	}
	public function optiontypeupdate(Request $req){
		 $input = $req->all();
		 $input = $input['data'];
		 $query = Option::where('id',$input['id'])->update(['type' => $input['type'],'value' => $input['value']]);
		 return response()->json(["success"=>true, "status"=>$query]);
	}

	public function optiontypeadddata(Request $req){
	  $input = $req->all();
		 $input = $input['data'];
		 $query = new  Option();
		 $query->value = $input['value'];
		 $query->type = $input['type'];
		 $query->save();
		 return response()->json(['success'=>true]);

	}

}
