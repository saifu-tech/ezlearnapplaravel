<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Hash;
use Auth;
use JWTAuth;
use Response;
use Redirect;
use DB;
use Mail;
use Log;

use App\Config;
use App\Appsetting;
use App\Apppreference;
use App\Options;
use App\Option;
use App\User;
use App\Group;
use App\GroupMember;
use App\GroupPost;
use App\GroupPostMeta;
use App\GroupComment;
use App\Students;
use App\Staff;
use App\Dailytaskstracker;
use App\Classname;
use App\Category;
use App\Subcategory;
use App\Course;
use App\Groupcourse;
use App\GroupMessage;
use App\CourseComplete;
use App\Subjects;
use App\Discussion;
use App\Library;

use App\TaskComplete;
use App\Tasktype;

use App\Dailytasks;
use App\Dailytasksmeta;
use App\Dailytasksstatus;
use App\Dailytasksresult;
use App\Dailytasksmetatracker;
use App\Dailytasksstatustracker;
use App\Studenttracker;
use App\Dailytasksstudent;
use App\Trackerpercentage;


class ApiController extends Controller
{

     public $weekdays;

    public function __construct() {
        $this->weekdays = ['','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
    }

    public function registerdevice(Request $input){
            header('Access-Control-Allow-Origin: *');
            $userid = $input['userid'];
            $token = $input['token'];
            $type = $input['type'];
            $update = User::find($userid);
            $update->deviceToken = $token;
            $update->platform = strtolower($type);
            $update->save();
            return $update;
    }

    // public function login(Request $input){
    //     //Log::info($input['email']);
    //     header('Access-Control-Allow-Origin: *');
    //     $credentials['email'] =  $input['email'];
    //     $credentials['password'] =  $input['password'];
    //     $logincheck = JWTAuth::attempt($credentials);
        
    //     if($logincheck){
    //         $userinfo = User::find(JWTAuth::user()->id);
    //         return Response()->json(['status'=>'success','token'=>$logincheck,'userinfo'=>$userinfo]);
    //     }
    //     else{
    //      return Response()->json(['status'=>'error']);
    //     }
    //     // if(Auth::attempt(['email'=>$input['email'],'password'=>$input['password'],'status'=>'active'])){
    //     //     return Auth::user();
    //     // } else{
    //     //     return 'error';
    //     // }
    // }


    public function login(Request $input){

      
        $token = JWTAuth::attempt(['email'=>$input['email'],'password'=>$input['password']]);

        if($token){
          $checkAuth =  User::where('email',$input['email'])->first();
            return response()->json(['success'=>true, 'data'=>$checkAuth,'token'=>$token]);
        }else{
            return response()->json(['success'=>false]);
        }
    }



    public function logindata(Request $input){
     
        return $input->all();
        header('Access-Control-Allow-Origin: *');
        if(Auth::attempt(['email'=>$input['email'],'password'=>$input['password'],'status'=>'active'])){
            return Auth::user();
        } else{
            return 'error';
        }
    }

    public function signup(Request $input){
          
        $name = $input['name'];
        $email = $input['email'];
        $password = $input['password'];
        $activation_code = md5($name.time());
        $type = $input['type'];

        $hashedPass = Hash::make($password);

        $count=Staff::count()+1001;
        $code='SF'.$count;            
        $userid = strtolower(explode(' ',$name)[0]);

        $dup = User::where('email', $email)->first();

        if($dup){
           return response()->json(['status'=>'email']);
        } else{
            DB::transaction(function() use($input, $type, $name, $email, $hashedPass, $activation_code, $userid, $code){

                if($type == 'staff'){
                    $staff = new Staff();
                    $staff->code = $code;
                    $staff->fullname = $name;
                    $staff->email = $email;
                    $staff->status = 'active';
                    $staff->save();

                    $new = new User();
                    $new->full_name = $name;
                    $new->user_id = $code;
                    $new->email = $input['email'];
                    $new->password = $hashedPass;
                    $new->status = 'active';
                    $new->type = 'staff';
                    $new->userLink = $staff->id;
                    $new->activation_code = $activation_code;
                    $new->save();

                    for($i=1;$i<=3;$i++){
                        $setting = new Appsetting();
                        $setting->userid = $new->id;
                        $setting->preference = $i;
                        $setting->value = 1;
                        $setting->save();
                    }
                } else{
                    $std = new Students();

                    $count=Students::count()+1001;
                    $code='ST'.$count;

                    $std->code = $code;
                    $std->fullname = $name;
                    $std->email = $email;
                    $std->gender = '';
                    $std->status = 'active';
                    $std->save();

                    $user = new User();
                    $user->full_name = $name;
                    $user->user_id = $code;
                    $user->email = $email;
                    $user->status = 'active';            
                    $user->activation_code = $activation_code;    
                    $user->userLink = $std->id;        
                    $user->type = 'student';
                    $user->password = $hashedPass;
                    $user->save();
                }


            });

            if($type == 'staff'){
                // Mail::send('emails.activation', ['name'=>$name,'code'=>$activation_code], function ($m) use($email, $name){
                //     $m->from('info@ezlearnapp.com', 'Ezgroups');
                //     $m->to($email, '')->subject('Activation email from Ezgroups');
                // });
            } else{
                // Mail::send('emails.studentactivation', ['name'=>$name,'code'=>$activation_code,'acceptance'=>'true','email'=>$email,'password'=>$password], function ($m) use($email, $name){
                //     $m->from('info@ezlearnapp.com', 'Ezgroups');
                //     $subject = 'Activation email from Ezgroups';
                //     $m->to($email, '')->subject($subject);
                // });
            }

            return response()->json(['status'=>'success']);
        }
        
    }

    public function savename(Request $input){
        header('Access-Control-Allow-Origin: *');
        $name = $input['name'];
        $userid = $input['userid'];
        DB::transaction(function() use($name, $userid){
            $user = User::find($userid);
            $user->full_name = $name;
            $user->save();

            $std = Students::where('id',$user->userLink)->update(['fullname'=>$name]);
        });
        return 'success';
    }

    public function activate($code){
        DB::transaction(function() use($code){
            $user = User::where('activation_code',$code)->first();
            if(count($user) > 0){
                $user->status = 'active';
                $user->activation_code = '';
                $user->save();
            }

            $staff = $user->userLink;
            $staff = Staff::find($staff);
            $staff->status = 'active';
            $staff->save();
        });
        return 'success';
    }

    public function studentactivate($code){
        DB::transaction(function() use($code){
            $user = User::where('activation_code',$code)->first();
            if(count($user) > 0){
                $user->status = 'active';
                $user->activation_code = '';
                $user->save();
            }

            $student = $user->userLink;
            $student = Students::find($student);
            $student->status = 'active';
            $student->save();
        });
        return 'success';
    }

    public function mygroups(Request $input){
        header('Access-Control-Allow-Origin: *');
        $s = '1';
        $studentid = User::where('userLink',$s)->first()->userLink;
        $groups = GroupMember::where('studentid',$studentid)->groupBy('groupid')->where('groupid','!=','')->where('status','active')->get();
        $list = [];
        foreach($groups as $group){
            $gid = $group->groupid;
            $gr = Group::where('id',$gid)->where('status','active')->first();
            if($gr){
                array_push($list,$gr);
            }
        }
        return $list;
    }

    public function joingroup(Request $input){
        header('Access-Control-Allow-Origin: *');
        $student = $input['studentid'];
        $studentname = Students::find($student)->fullname;
        $groupcode = $input['groupcode'];

        $info = Group::where('code',$groupcode)->first();
        if($info != null){
            $check = GroupMember::where('groupid', $info->id)->where('studentid',$student)->first();
            if($check != null){
                return Response::json(['status'=>'duplicate']);
            }
            $gid = $info->id;
            $admin = $info->group_admin;

            $new = new GroupMember();
            $new->group_course_id = '';
            $new->courseid = '';
            $new->groupid = $gid;
            $new->studentid = $student;
            $new->added_by = $admin;
            $status = 'active';
            $new->status = $status;
            $new->added_on = time();
            $new->save();

            /* Push notifications */
            $userinfo = User::where('id',$admin)->first();
            if($userinfo->deviceToken != ''){
                $notificationMessage = $studentname.' has joined your group: '.$info->group_name;
                $payload = (object) array('type' => 'joinedgroup', 'groupid' => $gid);
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
            
            $studentid = User::where('userLink',$student)->first()->userLink;
            $groups = GroupMember::where('studentid',$studentid)->groupBy('groupid')->where('groupid','!=','')->where('status','active')->get();
            $list = [];
            foreach($groups as $group){
                $gid = $group->groupid;
                $gr = Group::find($gid);
                array_push($list,$gr);
            }

            return Response::json(['status'=>'success','list'=>$list]);
        } else{
            return Response::json(['status'=>'error']);
        }
    }

    public function mycourses(Request $input){
        header('Access-Control-Allow-Origin: *');
        $studentid = $input['studentid'];

        $courses = DB::table('group_members as gm')
                ->join('group_course as gc','gm.group_course_id','=','gc.id')
                ->where('gm.studentid',$studentid)
                ->where('gm.groupid',$input['groupid'])
                ->where('gm.status','active')
                ->select('gc.*')
                ->get();      
        return $courses;
    }

    public function staffcourses(Request $input){
        header('Access-Control-Allow-Origin: *');
        $groupname = Group::find($input['groupid'])->group_name;
        $courses = Groupcourse::where('group_id',$input['groupid'])->where('admin',$input['staffid'])->where('status','active')->get();
        $userlist = [];
        foreach($courses as $course){
            $course->memberCount = GroupMember::where('group_course_id',$course->id)->where('studentid','!=',0)->count();
        }

        $users = GroupMember::where('added_by',$input['staffid'])->where('studentid','!=',0)->where('groupid',$input['groupid'])->groupBy('studentid')->pluck('studentid');

        foreach($users as $u){
            $member = User::where('userLink',$u)->where('type','student')->first();
            $name = ($member->full_name == '') ? Students::getstudentemail($u) : $member->full_name;
            array_push($userlist, ['name'=>$name,'id'=>$u]);
        }

        return Response::json(['courses'=>$courses,'users'=>$userlist,'groupname'=>$groupname]);
    }

    public function fetchposts(Request $input){
        header('Access-Control-Allow-Origin: *');
        $courseid = Groupcourse::find($input['courseid'])->course_id;
        $posts = DB::table('group_posts as gp')
                 ->join('users as u', 'gp.author','=','u.id')
                 ->select('gp.*','u.full_name as authorname','u.profile_picture')
                 ->where('gp.course_id',$courseid)                 
                 ->where('gp.post_type','text')
                 ->orderBy('gp.id','DESC')
                 ->get();

        $postarray = [];

        foreach($posts as $post){
            $post->comments = DB::table('group_comments as gc')
                              ->join('users as u','gc.commenter','=','u.id')
                              ->select('gc.*','u.profile_picture','u.full_name')
                              ->where('gc.postid',$post->id)->orderBy('gc.id','DESC')->take(10)->get();
            array_push($postarray, $post);
        }

        $status = CourseComplete::where('group_course_id',$input['courseid'])->where('student_id',$input['studentid'])->get();
        $status = (count($status) > 0) ? 'completed' : 'pending';
        $video = Groupcourse::where('id',$input['courseid'])->first()->video_url;
        return Response::json(['posts'=>$postarray,'status'=>$status,'video'=>$video]);
    }

    public function completecourse(Request $input){
        header('Access-Control-Allow-Origin: *');
        $new = new CourseComplete();
        $new->group_course_id = $input['courseid'];
        $new->student_id = $input['studentid'];
        $new->time = time();
        if($new->save()){
            $course = Groupcourse::find($new->group_course_id);
            $course->increment('completed');

            $pushPreference = Appsetting::where('userid',$course->admin)->where('preference',2)->first();
            $flag = 0;

            if(count($pushPreference) == 0){
                $flag = 1;
            }

            if(count($pushPreference) == 1 && $pushPreference->value == 1){
                $flag = 1; 
            }

            if($flag){
                $studentname = Students::find($input['studentid']);
                $userinfo = User::find($course->admin);
                if($userinfo && $userinfo->deviceToken != ''){
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
                    // $context  = stream_context_create($options);
                    // file_get_contents(env('PUSH_URL'), false, $context);
                }
            }

            return 'success';
        }
    }
    public function incompletecourse(Request $input){
        header('Access-Control-Allow-Origin: *');
        $new = CourseComplete::where('group_course_id',$input['courseid'])->where('student_id',$input['studentid'])->delete();
        $course = Groupcourse::find($input['courseid']);
        $course->decrement('completed');

        $pushPreference = Appsetting::where('userid',$course->admin)->where('preference',2)->first();
        $flag = 0;

        if(count($pushPreference) == 0){
            $flag = 1;
        }

        if(count($pushPreference) == 1 && $pushPreference->value == 1){
            $flag = 1; 
        }

        if($flag){
            $studentname = Students::find($input['studentid'])->fullname;
            $userinfo = User::find($course->admin);
            if($userinfo->deviceToken != ''){
                $payload = (object) array('type' => 'courseincomplete');
                $platform = ($userinfo->platform == 'android') ? 1 : 0;
                $data = array('platform' => $platform, 
                              'token' => $userinfo->deviceToken,
                              'msg'=> $studentname.' has an incomplete course `'.$course->course_name.'`',
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
        return 'success';
    }

    public function docomment(Request $input){
        header('Access-Control-Allow-Origin: *');
        $postid = $input['postid'];
        $comment = $input['comment'];
        $studentid = $input['studentid'];

        $new = new GroupComment();
        $new->postid = $postid;
        $new->commenter = $studentid;
        $new->comment = $comment;
        $new->time = time();
        if($new->save()){
            GroupPost::find($postid)->increment('comment_count');
            $uinfo = User::find($studentid);
            $new->profile_picture = $uinfo->profile_picture;
            $new->full_name = $uinfo->full_name;
            return Response::json(['status'=>'success','info'=>$new]);
        }
    }

    public function mytasks(Request $input){
        header('Access-Control-Allow-Origin: *');
        $courseid = $input['courseid'];
        $posts = DB::table('group_posts as gp')
                 ->join('group_post_meta as gpm','gp.id','=','gpm.postid')
                 ->where('gp.course_id',$courseid)
                 ->where('gp.post_type','task')
                 ->select('gp.*','gpm.video_url','gpm.due_date')
                 ->get();
        $tasks = [];

        foreach($posts as $post){
            $meta = TaskComplete::where('student_id',$input['studentid'])->where('post_id',$post->id)->get();
            $post->completed = count($meta) > 0 ? true : false;
            array_push($tasks,$post);
        }
        return $tasks;
    }

    public function updatetaskstatus(Request $input){
        header('Access-Control-Allow-Origin: *');
        $status = $input['status'];
        if($status == 'false'){
            TaskComplete::where('post_id',$input['postid'])->where('student_id',$input['studentid'])->delete();
            return 'pending';
        } else{
            $new = new TaskComplete();
            $new->student_id= $input['studentid'];
            $new->post_id = $input['postid'];
            $new->course_id = $input['courseid'];
            $new->time = time();
            if($new->save()){
                return 'completed';
            }
        }
    }

    public function createdailytask(Request $input){
        header('Access-Control-Allow-Origin: *');
        $students = json_decode($input['students']);
        $options = json_decode($input['options']);
        $status = json_decode($input['status']);
        $record = Dailytasks::orderBy('serialNo','DESC')->first();
        $serialNo = Dailytasks::getserialno();

        DB::transaction(function() use($input, $students, $options, $record, $serialNo, $status){
            if(count($students) > 0){
                    $insert = new Dailytasks();
                    $insert->code = $input['code'];
                    $insert->serialNo = $serialNo;
                    $insert->groupName = $input['groupname'];
                    $insert->taskName = $input['taskname'];
                    $insert->startDate = date('Y-m-d',strtotime($input['startdate']));
                    $insert->endDate = date('Y-m-d',strtotime($input['enddate']));
                    $insert->tasktype = strtolower($input['type']);

                    if($insert->tasktype == 'daily'){
                        $days = json_decode($input['days']);
                        $days = implode(',',$days);
                        $insert->day = $days;
                    } else{
                        $insert->day = $input['day'];
                    }
                    $insert->students = '';
                    $insert->status = 'active';
                    $insert->createdBy = $input['staffid'];
                    $insert->save();


                    foreach($students as $student){
                        $userinfo = User::where('userLink',$student->id)->first();

                            $insert = new Dailytasks();
                            $insert->serialNo = $serialNo;
                            $insert->groupName = $input['groupname'];
                            $insert->taskName = $input['taskname'];
                            $insert->startDate = date('Y-m-d',strtotime($input['startdate']));
                            $insert->endDate = date('Y-m-d',strtotime($input['enddate']));
                            $insert->tasktype = strtolower($input['type']);

                            if($insert->tasktype == 'daily'){
                                $days = json_decode($input['days']);
                                $days = implode(',',$days);
                                $insert->day = $days;
                            } else{
                                $insert->day = $input['day'];
                            }
                            $insert->students = $student->id;
                            $insert->status = 'active';
                            $insert->createdBy = $input['staffid'];
                            $insert->save();

                            /* Push notifications */
                            if($userinfo != null && $userinfo->deviceToken != ''){
                                $payload = (object) array('type' => 'dailytask');
                                $platform = ($userinfo->platform == 'android') ? 1 : 0;
                                $data = array('platform' => $platform, 
                                              'token' => $userinfo->deviceToken,
                                              'msg'=> 'A daily task has been assigned to you',
                                              'payload' => $payload);

                                // use key 'http' even if you send the request to https://...
                                $pushOptions = array(
                                    'http' => array(
                                        'header'  => "Content-Type: application/x-www-form-urlencoded\r\n" .
                                                     "X-PUSHBOTS-APPID: ".env('PUSHBOTS_ID')."\r\n" .
                                                     "X-PUSHBOTS-SECRET: ".env('PUSHBOTS_SECRET')."\r\n",
                                        'method'  => 'POST',
                                        'content' => http_build_query($data),
                                    ),
                                );
                                $context  = stream_context_create($pushOptions);
                                file_get_contents(env('PUSH_URL'), false, $context);
                            }
                            /* End push notifications*/
                    }

            } else{
                $insert = new Dailytasks();
                    $insert->serialNo = $serialNo;
                    $insert->code = $input['code'];
                    $insert->groupName = $input['groupname'];
                    $insert->taskName = $input['taskname'];
                    $insert->startDate = date('Y-m-d',strtotime($input['startdate']));
                    $insert->endDate = date('Y-m-d',strtotime($input['enddate']));
                    $insert->tasktype = strtolower($input['type']);

                    if($insert->tasktype == 'daily'){
                        $days = json_decode($input['days']);
                        $days = implode(',',$days);
                        $insert->day = $days;
                    } else{
                        $insert->day = $input['day'];
                    }
                    $insert->students = '';
                    $insert->status = 'active';
                    $insert->createdBy = $input['staffid'];
                    $insert->save();
            }

            
            foreach($options as $option){
                $insertMeta = new Dailytasksmeta();
                $insertMeta->serialNo = $serialNo;
                $insertMeta->optionName = $option;
                $insertMeta->save();
            }
            
            $i=0;
            foreach($status as $sta){
                $insertStatus = new Dailytasksstatus();
                $insertStatus->serialNo=$serialNo;
                $insertStatus->name=$sta->name;
                $insertStatus->color=$sta->color;
                $insertStatus->save();
                $i++;
            }

        });

        $task = Dailytasks::where('serialNo',$serialNo)
                ->groupBy('serialNo')
                ->get();
                
        return Response::json(['task'=>$task[0],'status'=>'success']);
    }

    public function getdailytasks(Request $input){
        header('Access-Control-Allow-Origin: *');
        $studentid = $input['studentid'];
        $s = '11';
        
        $date = date('Y-m-d');
        $list = Dailytasks::where('students',$s)->where('startDate','<=',$date)->where('template','no')->where('status','active')->get();
        return $list;
    }

    public function getgroupinfo(Request $input){
        header('Access-Control-Allow-Origin: *');
        $today = date('Y-m-d');        
        $days = [];

        $group = Dailytasks::where('serialNo',$input['sno'])->where('status','active')->first();

        $type = $group->tasktype;
        if($type == 'daily'){
            $daylist = explode(',',$group->day);
            $i = 0; $j = 0;
            while($i < 7){
                $date = date('Y-m-d', strtotime('-'.$j.' day', strtotime($today)));
                    $x = date('N', strtotime($date));
                    if(in_array($x, $daylist)){
                        $day = date('l', strtotime($date));
                        array_push($days,['date'=>$date,'day'=>$day,'header'=>[],'students'=>[]]);
                        $i++;
                    }
                $j++;
            }
        }

        if($type == 'weekly'){
            $flag = 0;
            for($j=0;$j<42;$j++){
                $date = date('Y-m-d', strtotime('-'.$j.' day', strtotime($today)));
                if($date >= $group->startDate && $date <= $group->endDate){
                    $day = date('N', strtotime('-'.$j.' day', strtotime($today)));
                    if($day == $group->day){
                        $day = date('l', strtotime('-'.$j.' day', strtotime($today)));
                        array_push($days,['date'=>$date,'day'=>$day,'header'=>[],'students'=>[]]);
                        $flag++;
                    }
                    if($flag == 6) break;
                }
            }
        }

        if($type == 'monthly'){
            $targetDate = date('Y-m-'.$group->day);
            for($k=0;$k<=7;$k++){

                $timestamp = strtotime ('-'.$k.' month',strtotime ($targetDate));
                $date  =  date("Y-m-d",$timestamp);

                if($date >= $group->startDate && $date <= $group->endDate){                    
                    $day = date('l', strtotime($date));
                    array_push($days,['date'=>$date,'day'=>$day,'header'=>[],'students'=>[]]);                    
                }
            }
        }

        $taskname = $group->taskName;
        $legend = Dailytasksstatus::orderBy('name')->where('serialNo',$input['sno'])->get();
        return Response::json(['days'=>$days,'taskname'=>$taskname,'legend'=>$legend]);
    }

    public function fetchtaskstatbydate(Request $input){
        header('Access-Control-Allow-Origin: *');
        $sno = $input['serialno'];
        $date = $input['date'];

        $students = Dailytasks::where('serialNo',$sno)->where('status','active')->where('students','!=','')->select('students')->get();
        $options = Dailytasksmeta::where('serialNo',$sno)->get();

        $defaultstatus = Dailytasksstatus::where('serialNo',$sno)->first();

        $list = [];

        foreach($students as $std){ 
            $sinfo = [];
            $rec = Students::find($std->students);
            $name = 'N/A';
            if($rec){
                $name = ($rec->fullname == '') ? $rec->email : $rec->fullname;
            }
            array_push($sinfo, $name);
            foreach($options as $opt){              

                $status = Dailytasksresult::where('serialNo',$sno)
                          ->where('studentId',$std->students)
                          ->where('statusDate',$date)
                          ->where('optionId', $opt->id)
                          ->get();
                
                if(count($status) > 0){
                    $color = Dailytasksstatus::find($status[0]->statusId)->color;
                    $uid = $status[0]->statusId;
                } else{
                    $color = $defaultstatus->color;
                    $uid = $defaultstatus->id;
                }
                array_push($sinfo, ['color'=>$color,'oid'=>$opt->id,'uid'=>$uid]);
            }
            array_push($list,['studentid'=>$std->students,'studentdata'=>$sinfo, 'date'=>$date]);
        }
        return Response::json(['header'=>$options, 'list'=>$list]);

    }

    public function fetchcoursestat(Request $input){
        header('Access-Control-Allow-Origin: *');
        $courseid = $input['courseid'];

        $students = DB::table('group_members as gm')->where('group_course_id',$courseid)
                    ->join('students as s','gm.studentid','=','s.id')
                    ->select('s.id','s.fullname','gm.group_course_id as courseid')
                    ->get();

        $list = [];

        foreach($students as $std){
            $check = CourseComplete::where('group_course_id',$std->courseid)->where('student_id',$std->id)->count();
            $status = ($check > 0) ? '#0F0' : '#F00';
            $std->status = $status;
            array_push($list,$std);
        }

        return $list;

    }

    public function assigncourse(Request $input){
        header('Access-Control-Allow-Origin: *');    

        $time = time();
            
        $update = Groupcourse::find($input['course']);
        $update->status = 'active';
        $update->group_id = $input['groupid'];
        $update->acceptance_mandatory = ($input['acceptance'] == 'true') ? 'no' : 'yes';
        $update->save();


        $students = Group::find($input['groupid'])->students;
        if($students != ''){
            $students = explode(',',$students);
        }
        else{
            $students = [];
        }
        if(count($students) > 0){
            foreach($students as $student){
                $new = new GroupMember();
                $new->group_course_id = $update->id;
                $new->courseid = $update->course_id;
                $new->groupid = $input['groupid'];
                $new->studentid = $student;
                $new->added_by = $input['admin'];
                $status = ($update->acceptance_mandatory == 'yes') ? 'inactive' : 'active';
                $new->status = $status;
                $new->added_on = $time;
                $new->save();

                /* Push notifications */
                $userinfo = User::where('userLink',$new->studentid)->first();
                if($userinfo->deviceToken != ''){
                    $notificationMessage = ($update->acceptance_mandatory == 'yes') ? 'You have been invited to join a course' : 'A new course has been assigned to you';
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

        return Response::json(['status'=>'success','info'=>$update]);

    }

    public function staffgetdailytasks(Request $input){
        header('Access-Control-Allow-Origin: *');
        $staffid = $input['staffid'];
        $date = date('Y-m-d');
        $list = Dailytasks::where('createdBy',$staffid)
                //->where('startDate','<=',$date)
                ->where('status','active')
                ->where('template','no')
                ->groupBy('serialNo')
                ->get();
        $students = GroupMember::where('added_by',$input['staffid'])->where('studentid','!=',0)->groupBy('studentid')->pluck('studentid');
        $studentlist = Students::orderBy('fullname')->select('id','fullname')->whereIn('id',$students)->where('status','active')->get();
        return Response::json(['list'=>$list,'students'=>$studentlist,'colors'=>['#ff0000','#00ff00','#ffff00','#5acbff']]);
    }

    public function staffgetdailytasktemplates(Request $input){
        header('Access-Control-Allow-Origin: *');
        $staff = $input['staffid'];
        $list = Dailytasks::where('template','yes')->where('status','active')->where('createdBy',$staff)->groupBy('serialNo')->get();
        if(count($list) > 0){
            foreach($list as $l){
                $l->meta = Dailytasksmeta::where('serialNo',$list[0]->serialNo)->select('optionName')->get();
                $l->status = Dailytasksstatus::where('serialNo',$list[0]->serialNo)->select('name','color')->get();
            }
        }
        return Response::json(['list'=>$list]);
    }

    public function staffinvitetotracker(Request $input){
        header('Access-Control-Allow-Origin: *');

        $staff = $input['userid'];
        $serialno = $input['sno'];
        $emailList = json_decode($input['list']);

        foreach($emailList as $e){

            $email = $e->email;
            $name = '';
            $gender = '';
            $acceptance = 'true';
            $password = 'password';
            $hashedpassword = Hash::make($password);
            $userid = '';
            $activation_code = md5(str_random(5).time());

            $uinfo = User::where('email',$email)->get();
            $count = count($uinfo);

            
            DB::transaction(function() use($count,$uinfo,$input, $staff, $name, $email, $gender, $acceptance, $password, $hashedpassword, $activation_code, $userid, $serialno){

                if($count == 0){                       
                    $std = new Students();

                    $count=Students::count()+1001;
                    $code='ST'.$count;

                    $std->code = $code;
                    $std->fullname = $name;
                    $std->email = $email;
                    $std->gender = $gender;
                    $std->status = ($acceptance == 'true') ? 'inactive' : 'active';
                    $std->save();

                    $user = new User();
                    $user->full_name = $name;
                    $user->user_id = $userid;
                    $user->email = $email;
                    $user->status = ($acceptance == 'true') ? 'inactive' : 'active';            
                    $user->activation_code = $activation_code;    
                    $user->userLink = $std->id;        
                    $user->type = 'student';
                    $user->password = $hashedpassword;
                    $user->save();

                    $task = Dailytasks::where('serialNo',$serialno)->limit(1)->orderBy('id','DESC')->get();
                    $dt = $task[0];

                    $add = new Dailytasks();
                    $add->serialNo = $dt->serialNo;
                    $add->groupName = $dt->groupName;
                    $add->taskName = $dt->taskName;
                    $add->students = $std->id;
                    $add->tasktype = $dt->tasktype;
                    $add->startDate = $dt->startDate;
                    $add->endDate = $dt->endDate;
                    $add->day = $dt->day;
                    $add->template = $dt->template;
                    $add->status = $dt->status;
                    $add->createdBy = $dt->createdBy;
                    $add->save();
                } else{
                    if($uinfo[0]->type == 'student'){
                        $check = Dailytasks::where('serialNo',$serialno)->where('students',$uinfo[0]->userLink)->count();
                        if($check == 0){
                            $task = Dailytasks::where('serialNo',$serialno)->limit(1)->orderBy('id','DESC')->get();
                            $dt = $task[0];

                            $add = new Dailytasks();
                            $add->serialNo = $dt->serialNo;
                            $add->groupName = $dt->groupName;
                            $add->taskName = $dt->taskName;
                            $add->students = $uinfo[0]->userLink;
                            $add->tasktype = $dt->tasktype;
                            $add->startDate = $dt->startDate;
                            $add->endDate = $dt->endDate;
                            $add->day = $dt->day;
                            $add->template = $dt->template;
                            $add->status = $dt->status;
                            $add->createdBy = $dt->createdBy;
                            $add->save();
                        }
                    }
                }
                
            });
            
            if($count == 0){
                // Mail::send('emails.studentactivation', ['name'=>$email,'code'=>$activation_code,'acceptance'=>$acceptance,'email'=>$email,'password'=>$password], function ($m) use($email, $name, $acceptance){
                //     $m->from('info@ezlearnapp.com', 'Ezgroups');
                //     if($acceptance == 'true'){
                //         $subject = 'Activation email from Ezgroups';
                //     } else{
                //         $subject = 'Welcome email from Ezgroups';
                //     }
                //     $m->to($email, '')->subject($subject);
                // });
            }
        }

        return 'success';

    }

    public function stafffetchtrackermembers(Request $input){
        header('Access-Control-Allow-Origin: *');

        $sno = $input['sno'];
        $members = Dailytasks::where('serialNo',$sno)->where('students','!=','')->pluck('students');
        $list = [];

        foreach($members as $m){
            $name = Students::getstudentname($m);
            if($name == ''){
                $name = Students::getstudentemail($m);
            }
            array_push($list,['name'=>$name,'id'=>$m]);
        }

        return $list;
    }

    public function staffremovememberfromtracker(Request $input){
        header('Access-Control-Allow-Origin: *');

        $member = $input['memberid'];
        $sno = $input['sno'];

        DB::transaction(function() use($member, $sno){
            Dailytasks::where('serialNo',$sno)->where('students',$member)->delete();
            Dailytasksresult::where('serialNo',$sno)->where('studentId',$member)->delete();
        });

        return 'success';
    }

    public function staffdeletetracker(Request $input){
        header('Access-Control-Allow-Origin: *');

        $sno = $input['serialno'];

        DB::transaction(function() use($sno){
            Dailytasks::where('serialNo',$sno)->where('students','!=','')->delete();
            Dailytasks::where('serialNo',$sno)->where('students','')->update(['status'=>'deleted']);
            Dailytasksresult::where('serialNo',$sno)->delete();
            Dailytasksstatus::where('serialNo',$sno)->delete();
            Dailytasksmeta::where('serialNo',$sno)->delete();
        });

        return 'success';
    }

    public function studentjointracker(Request $input){
        header('Access-Control-Allow-Origin: *');
        $studentid = $input['studentid'];
        $trackercode = $input['trackercode'];

        $tracker = Dailytasks::where('code', $trackercode)->first();

        if($tracker != null){
            $check = Dailytasks::where('serialNo', $tracker->serialNo)->where('students',$studentid)->first();

            if($check != null){
                return Response::json(['status'=>'duplicate']);
            }
            $insert = new Dailytasks();
            $insert->serialNo = $tracker->serialNo;
            $insert->groupName = $tracker->groupName;
            $insert->taskName = $tracker->taskName;
            $insert->startDate = $tracker->startDate;
            $insert->endDate = $tracker->endDate;

            $insert->tasktype = $tracker->tasktype;
            $insert->day = $tracker->day;
            $insert->students = $studentid;
            $insert->status = 'active';
            $insert->createdBy = $tracker->createdBy;
            $insert->save();

            /* Push notifications */
            $userinfo = User::where('id',$tracker->createdBy)->first();
            $student = Students::getstudentname($studentid);
            if($userinfo->deviceToken != ''){
                $notificationMessage = $student.' has joined your tracker: '.$insert->groupName;
                $payload = (object) array('type' => 'joinedtracker', 'trackerid' => $tracker->id);
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

            return Response::json(['status'=>'success', 'tracker'=>$tracker]);
        } else{
            return Response::json(['status'=>'error']);
        }
    }

    public function getdailytaskoptions(Request $input){
        header('Access-Control-Allow-Origin: *');
        $list = Dailytasksstatus::orderBy('name')->where('serialNo',$input['sno'])->get();
        $check = Dailytasksresult::where('serialNo',$input['sno'])
                 ->where('studentId',$input['studentid'])
                 ->where('optionId',$input['oid'])
                 ->get();
        if(count($check) > 0){
            $uid = $check[0]->statusId;
            $list[0]->userStatusId = $uid;
        } else{
            $uid = '';
        }
        $startDate = Dailytasks::where('serialNo',$input['sno'])->first()->startDate;
        return Response::json(['list'=>$list,'uid'=>$uid, 'startdate'=>$startDate]);
    }

    public function fetchdailytaskstat(Request $input){
        header('Access-Control-Allow-Origin: *');
        $sno = $input['sno'];
        $date = $input['date'];

        $statuslist = [];

        $defaultstate = Dailytasksstatus::first()->id;

        $students = Dailytasks::where('serialNo',$sno)->where('status','active')->get();
        foreach($students as $std){
            $status = Dailytasksresult::where('serialNo',$sno)->where('studentId',$std->students)->get();
            if(count($status) > 0){
                $name = Students::find($std->students)->fullname;
                array_push($statuslist, ['name'=>$name, 'status'=>$status[0]->statusId, 'statusname'=>'']);
            }
        }

        return $statuslist;
    }

    public function updatedailytaskstatus(Request $input){
        header('Access-Control-Allow-Origin: *');
        $check = Dailytasksresult::where('serialNo',$input['sno'])
                 ->where('studentId',$input['studentid'])
                 ->where('optionId',$input['oid'])
                 ->where('statusDate',$input['updatedate'])
                 ->get();
        $date = $input['updatedate'];
        if(count($check) > 0){
            $update = Dailytasksresult::find($check[0]->id);
            $update->statusId = $input['uid'];
            $update->statusDate = $date;
            $update->save();
            $color = Dailytasksstatus::find($input['uid'])->color;
        } else{
            $update = new Dailytasksresult();
            $update->serialNo = $input['sno'];
            $update->studentId = $input['studentid'];
            $update->optionId = $input['oid'];
            $update->statusId = $input['uid'];
            $update->statusDate = $date;
            $update->save();

            $color = Dailytasksstatus::find($input['uid'])->color;
        } 

        $groupinfo = Dailytasks::where('serialNo',$input['sno'])->first();
        $pushPreference = Appsetting::where('userid',$groupinfo->createdBy)->where('preference',1)->first();
        $flag = 0;

        if(count($pushPreference) == 0){
            $flag = 1;
        }

        if(count($pushPreference) == 1 && $pushPreference->value == 1){
            $flag = 1; 
        }

        // if($flag){
        //     $completedby = User::where('userLink',$input['studentid'])->first()->full_name;
        //     $groupname = $groupinfo->groupName;
        //     $userinfo = User::find($groupinfo->createdBy);
        //     if($userinfo && $userinfo->deviceToken != ''){
        //         $payload = (object) array('type' => 'dailytaskcomplete');
        //         $platform = ($userinfo->platform == 'android') ? 1 : 0;
        //         $data = array('platform' => $platform, 
        //                       'token' => $userinfo->deviceToken,
        //                       'msg'=> $completedby.' has updated a tracker in `'.$groupname.'`',
        //                       'payload' => $payload);

        //         // use key 'http' even if you send the request to https://...
        //         $options = array(
        //             'http' => array(
        //                 'header'  => "Content-Type: application/x-www-form-urlencoded\r\n" .
        //                              "X-PUSHBOTS-APPID: ".env('PUSHBOTS_ID')."\r\n" .
        //                              "X-PUSHBOTS-SECRET: ".env('PUSHBOTS_SECRET')."\r\n",
        //                 'method'  => 'POST',
        //                 'content' => http_build_query($data),
        //             ),
        //         );

        //         $context  = stream_context_create($options);
        //         file_get_contents(env('PUSH_URL'), false, $context);
        //     }
        // }
        
        return Response::json(['status'=>'success','color'=>$color]);
    }

    public function dopost(Request $input){
        header('Access-Control-Allow-Origin: *');
        $post = new GroupPost();
        $post->post_type = 'text';
        $post->text = $input['text'];
        $post->author = $input['studentid'];
        $post->group_id = Groupcourse::where('id',$input['courseid'])->first()->group_id;
        $post->course_id = Groupcourse::find($input['courseid'])->course_id;
        $post->time = time();
        if($post->save()){
            $user = User::find($input['studentid']);
            $post->authorname = $user->full_name;
            $post->profile_picture = $user->profile_picture;
            return Response::json(['status'=>'success','postinfo'=>$post]);
        }
    }

    public function getdashboard(Request $input){
        header('Access-Control-Allow-Origin: *');
        $studentid = $input['studentid'];
        $invites = DB::table('group_members as gm')
                   ->join('groups as g','gm.groupid','=','g.id')
                   ->join('group_course as gc','gm.group_course_id','=','gc.id')
                   ->where('gm.studentid',$studentid)
                   ->where('gm.status','inactive')
                   ->select('gm.*','g.group_name','gc.course_name')
                   ->get();

        $list = DB::table('group_members as gm')
                ->join('group_course as gc','gm.group_course_id','=','gc.id')
                ->join('groups as g','gc.group_id','=','g.id')
                ->where('gm.status','active')
                ->where('gm.studentid',$studentid)
                ->select('gm.groupid','gm.studentid','gm.group_course_id as courseid','g.group_name','gc.course_name')
                ->get();

        $alternates = Options::where('key','admin_alternate')->pluck('value');
        $adminalternate = $alternates[0];
        $alternates = Options::where('key','student_alternate')->pluck('value');
        $studentalternate = $alternates[0];

        $pendinglist = [];

        $totalcourses = GroupMember::where('studentid',$studentid)->where('status','active')->count();
        $completedcourses = CourseComplete::where('student_id',$studentid)->count();

        $completedPercent = ($totalcourses == 0) ? 0 : ceil(($completedcourses/$totalcourses) * 100);

        foreach($list as $item){
            $check = CourseComplete::where('student_id',$item->studentid)->where('group_course_id',$item->courseid)->count();
            if($check == 0){
                array_push($pendinglist,$item);
            }
        }

        $dailytask = Dailytasks::where('students',$studentid)->where('template','no')->lists('serialNo');
        
        $count = 0;

        foreach($dailytask as $dt){
            $check = Dailytasksresult::where('serialNo',$dt)->where('studentId',$studentid)->where('statusDate',date('Y-m-d'))->count();
            if($check == 0){
                $count += 1;
            }
        }

        return Response::json(['invites'=>$invites,'pendinglist'=>$pendinglist,'dailytask'=>$count,'completepercent'=>$completedPercent,'totalcourse'=>$totalcourses,'completedcourses'=>$completedcourses,'admin_alternate'=>$adminalternate,'student_alternate'=>$studentalternate]);
    }

    public function fetchinvitations(Request $input){
        header('Access-Control-Allow-Origin: *');
        $studentid = $input['studentid'];
        $invites = DB::table('group_members as gm')
                   ->join('groups as g','gm.groupid','=','g.id')
                   ->join('group_course as gc','gm.group_course_id','=','gc.id')
                   ->where('gm.studentid',$studentid)
                   ->where('gm.status','inactive')
                   ->select('gm.*','g.group_name','gc.course_name')
                   ->get();
        return $invites;
    }

    public function sendmessage(Request $input){
        header('Access-Control-Allow-Origin: *');
        $new = new Discussion();
        $new->groupId = $input['groupid'];
        $new->userId = $input['sender'];
        $new->message = $input['text'];
        $new->time = time();
        $new->date = date('Y-m-d');
        $new->save();

        $message = Discussion::find($new->id);
        $message->author = '';

        if($input['type'] == 'student'){
            $admin = Group::find($input['groupid'])->group_admin;
            $pushPreference = Appsetting::where('userid',$admin)->where('preference',3)->first();
            $flag = 0;

            if(count($pushPreference) == 0){
                $flag = 1;
            }

            if(count($pushPreference) == 1 && $pushPreference->value == 1){
                $flag = 1; 
            }
            if($flag){
                $userinfo = User::find($admin);
                if($userinfo->deviceToken != ''){
                    $payload = (object) array('type' => 'discussion', 'groupid'=>$input['groupid']);
                    $platform = ($userinfo->platform == 'android') ? 1 : 0;
                    $data = array('platform' => $platform, 
                                  'token' => $userinfo->deviceToken,
                                  'msg'=> 'New Message: '.substr($input['text'],0,30).'...',
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
        }



        $me = User::find($input['sender'])->userLink;
        $students = GroupMember::where('groupid',$input['groupid'])->where('status','active')->where('studentid','!=',0)->groupBy('studentid')->pluck('studentid');

        foreach($students as $std){
            if($std != '' and $std != $me){
                /* Push notifications */
                $userinfo = User::where('userLink',$std)->first();
                if($userinfo->deviceToken != ''){
                    $payload = (object) array('type' => 'discussion', 'groupid'=>$input['groupid']);
                    $platform = ($userinfo->platform == 'android') ? 1 : 0;
                    $data = array('platform' => $platform, 
                                  'token' => $userinfo->deviceToken,
                                  'msg'=> 'New Message: '.substr($input['text'],0,30).'...',
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

        return Response::json(['message'=>$message]);
    }

    public function fetchsettings(Request $input){
        header('Access-Control-Allow-Origin: *');
        $userid = $input['userid'];
        $pref = Apppreference::get();
        foreach($pref as $p){
            $value = Appsetting::where('userid',$userid)->where('preference',$p->id)->get();
            if(count($value) == 0){
                $value = 0;
            } else{
                $value = ($value[0]->value == 0) ? false : true;
            }

            $p->value = $value;
        }

        return $pref;
    }

    public function savesettings(Request $input){
        header('Access-Control-Allow-Origin: *');
        $settings = json_decode($input['settings']);
        $userid = $input['userid'];
        DB::transaction(function() use($userid, $settings){
            Appsetting::where('userid',$userid)->delete();
            foreach($settings as $set){
                $new = new Appsetting();
                $new->userid = $userid;
                $new->preference = $set->id;
                $new->value = $set->value;
                $new->save();
            }
        });
        return 'success';
    }

    public function changepassword(Request $input){
        header('Access-Control-Allow-Origin: *');
        $userid = $input['userid'];
        $password = $input['password'];
        $hashedPassword = Hash::make($password);
        $user = User::find($userid);
        $user->password = $hashedPassword;
        $user->save();
        return 'success';
    }

    public function savelibraryitem(Request $input){
        header('Access-Control-Allow-Origin: *');

        $new = new Library();
        $new->title = $input['title'];
        $new->reference = $input['reference'];
        $new->description = $input['description'];
        $new->classes = $input['classid'];
        $new->subject = $input['subjectid'];
        $new->category = $input['category'];
        $new->subCategory = $input['subcategory'];
        $new->created_by = $input['userid'];
        $new->save();

        return 'success';
    }


    public function searchlibrary(Request $input){
        header('Access-Control-Allow-Origin: *');

        $data = Library::where('title','like','%'.$input['searchkey'].'%')->where('title','!=','')->select('title','reference','description','classes','subject','category','subCategory')->get();

        foreach($data as $rc){
            $rc->classes = Classname::find($rc->classes)->class_name;
            if(is_numeric($rc->subject) && $rc->subject != 0){
                $rc->subject = Subject::find($rc->subject)->name;
            } else{
                $rc->subject = null;
            }
            if(is_numeric($rc->category) && $rc->category != 0){
                $rc->category = Category::find($rc->category)->category_name;
            } else{
                $rc->category = null;
            }
            if(is_numeric($rc->subCategory) && $rc->subCategory != 0){
                $rc->subCategory = Subcategory::find($rc->subCategory)->name;
            } else{
                $rc->subCategory = null;
            }
        }
        return $data;
    }

    public function fetchdiscussions(Request $input){
        header('Access-Control-Allow-Origin: *');
        $groupid = $input['groupid'];
        $groupname = Group::find($groupid)->group_name;

        $dates = Discussion::groupBy('date')->where('groupId',$groupid)->select('date')->get();

        if(count($dates) == 0){
            $dates = [];
            array_push($dates,['date'=>date('Y-m-d'),'messages'=>[]]);
        } else{
            foreach($dates as $dt){
                $messages = Discussion::where('groupId',$groupid)->where('date',$dt->date)->get();
                foreach($messages as $msg){
                    $author = '';
                    if($msg->userId != $input['me']){
                        $author = User::find($msg->userId)->full_name;
                    }
                    $msg->author = $author;
                }
                $dt->messages = $messages;
            }            
        }

        return Response::json(['dates'=>$dates,'groupname'=>$groupname]);
    }

    public function acceptgroupinvite(Request $input){
        header('Access-Control-Allow-Origin: *');
        $inviteid = $input['inviteid'];
        $update = GroupMember::find($inviteid);
        $update->status = 'active';
        if($update->save()){
            Group::find($update->groupid)->increment('member_count');
            return 'success';
        }
    }

    public function declinegroupinvite(Request $input){
        header('Access-Control-Allow-Origin: *');
        $inviteid = $input['inviteid'];
        $update = GroupMember::find($inviteid);
        $update->status = 'rejected';
        if($update->save()){
            return 'success';
        }
    }

// Staff methods

    public function dashboarditems(Request $input){
        header('Access-Control-Allow-Origin: *');
        $staffid = $input['staffid'];
        $groups = Group::where('group_admin',$staffid)->where('status','active')->lists('id');         
        $courses = Groupcourse::where('admin',$staffid)->where('status','active')->whereIn('group_id',$groups)->count();
        $invites = GroupMember::where('added_by',$staffid)->where('status','inactive')->count();

        $alternates = Options::where('key','admin_alternate')->pluck('value');
        $adminalternate = $alternates[0];
        $alternates = Options::where('key','student_alternate')->pluck('value');
        $studentalternate = $alternates[0];

        return Response::json(['groups'=>count($groups),'courses'=>$courses,'invites'=>$invites,'admin_alternate'=>$adminalternate,'student_alternate'=>$studentalternate]);
     }

     public function createstudent(Request $input){
        header('Access-Control-Allow-Origin: *');

        $staff = $input['staffid'];
        $email = $input['email'];
        $name = $input['name'];
        $gender = $input['gender'];
        $acceptance = $input['acceptance'];

        $password = 'password';
        $hashedpassword = Hash::make($password);
        $userid = explode(' ',$name)[0];
        $activation_code = ($acceptance == 'true') ? md5($userid.time()) : '';

        $count = User::where('email',$email)->count();
        if($count > 0){
            return 'duplicate';
        }

        DB::transaction(function() use($input, $staff, $name, $email, $gender, $acceptance, $password, $hashedpassword, $activation_code, $userid){
            $std = new Students();

            $count=Students::count()+1001;
            $code='ST'.$count;

            $std->code = $code;
            $std->fullname = $name;
            $std->email = $email;
            $std->gender = $gender;
            $std->status = ($acceptance == 'true') ? 'inactive' : 'active';
            $std->save();

            $user = new User();
            $user->full_name = $name;
            $user->user_id = $userid;
            $user->email = $email;
            $user->status = ($acceptance == 'true') ? 'inactive' : 'active';            
            $user->activation_code = $activation_code;    
            $user->userLink = $std->id;        
            $user->type = 'student';
            $user->password = $hashedpassword;
            $user->save();

            $add = new GroupMember();
            $add->studentid = $std->id;
            $add->added_by = $staff;
            $add->added_on = time();
            $add->save();
        });

        // Mail::send('emails.studentactivation', ['name'=>$name,'code'=>$activation_code,'acceptance'=>$acceptance,'email'=>$email,'password'=>$password], function ($m) use($email, $name, $acceptance){
        //     $m->from('info@ezlearnapp.com', 'Ezgroups');
        //     if($acceptance == 'true'){
        //         $subject = 'Activation email from Ezgroups';
        //     } else{
        //         $subject = 'Welcome email from Ezgroups';
        //     }
        //     $m->to($email, '')->subject($subject);
        // });

        return 'success';
     }

    public function createstaffgroup(Request $input){
        header('Access-Control-Allow-Origin: *');

        DB::transaction(function() use($input, &$insert){

            $insert = new Group();

            $students = json_decode($input['students']);
            if(count($students)>0){
                $insert->students=implode(',',$students);
            }
            
            $insert->code=$input['groupCode'];
            $insert->group_name=$input['groupName'];
            $insert->group_name_slug=str_slug($input['groupName'],'_');
            $insert->group_short_description=$input['shortDescription'];
            $insert->group_long_description=$input['longDescription'];
            $insert->group_admin=$input['staffid'];
            $insert->acceptance_mandatory= ($input['acceptance'] == 'true') ? 'no' : 'yes';
            $insert->status='active';
            $insert->save();


            foreach($students as $std){
                $new = new GroupMember();
                $new->group_course_id = 0;
                $new->courseid = 0;
                $new->groupid = $insert->id;
                $new->studentid = $std;
                $new->added_by = $insert->group_admin;
                $new->status = 'active';
                $new->added_on = time();
                $new->save();
            }

        });
        return Response::json(['status'=>'success','groupinfo'=>Group::find($insert->id)]);
    }

    public function staffeditgroupinfo(Request $input){
        header('Access-Control-Allow-Origin: *');
        $groupid = $input['groupid'];
        $group = Group::find($groupid);
        $group->code = $input['groupcode'];
        $group->group_name=$input['groupname'];
        $group->group_name_slug=str_slug($input['groupname'],'_');
        $group->group_short_description=$input['shortdescription'];
        $group->group_long_description=$input['longdescription'];
        $group->acceptance_mandatory= ($input['acceptance'] == 'true') ? 'no' : 'yes';
        $group->save();

        return 'success';
    }

    public function deletestaffgroup(Request $input){
        header('Access-Control-Allow-Origin: *');
        $groupid = $input['groupid'];

        DB::transaction(function() use($groupid){
            $gp = Group::find($groupid);
            $gp->status = 'deleted';
            $gp->save();
        });

        return 'success';
    }

    public function staffgroups(Request $input){
        header('Access-Control-Allow-Origin: *');
        $groups = Group::where('group_admin',$input['staffid'])->where('status','active')->get();
        $students = GroupMember::where('added_by',$input['staffid'])->where('studentid','!=',0)->groupBy('studentid')->pluck('studentid');
        $studentlist = Students::orderBy('fullname')->select('id','fullname')->whereIn('id',$students)->where('status','active')->get();
        return Response::json(['groups'=>$groups, 'students'=>$studentlist]);
    }

    public function staffgetgroupinfo(Request $input){
        header('Access-Control-Allow-Origin: *');
        $groupid = $input['groupid'];
        $info = Group::find($groupid);
        return Response::json(['groupcode'=>$info->code,'groupname'=>$info->group_name,'shortdescription'=>$info->group_short_description,'longdescription'=>$info->group_long_description,'acceptance'=>$info->acceptance_mandatory]);
    }

    public function staffgetnextgroupid(Request $input){
        header('Access-Control-Allow-Origin: *');
        $groupid = Group::autogeneratecode();
        return $groupid;
    }

    public function fetchcourselist(Request $input){
        header('Access-Control-Allow-Origin: *');
        $courses = Groupcourse::where('group_id',$input['groupid'])->select('id','course_name')->get();
        return $courses;
    }

    public function fetchcourselistforinvite(Request $input){
        header('Access-Control-Allow-Origin: *');
        $courses = Groupcourse::where('admin',$input['admin'])->where('status','inactive')->select('id','course_name')->get();
        return $courses;
    }

    public function fetchcoursestudents(Request $input){
        header('Access-Control-Allow-Origin: *');
        $members = DB::table('group_members as gm')
                   ->join('users as u','gm.studentid','=','u.userLink')  
                   ->select('u.userLink as studentid','u.full_name as fullname')
                   ->where('group_course_id',$input['courseid'])
                   ->get();
        return $members;
    }

    public function fetchcoursemembers(Request $input){
        header('Access-Control-Allow-Origin: *');
        $members = DB::table('group_members as gm')
                   ->join('users as u','gm.studentid','=','u.userLink')  
                   ->select('u.userLink as studentid','u.full_name as fullname','u.email')
                   ->where('gm.group_course_id',$input['courseid'])
                   ->where('u.type','student')
                   ->get();
        $list = [];
        foreach($members as $std){
            $info = $std;
            $status = CourseComplete::where('group_course_id',$input['courseid'])->where('student_id',$std->studentid)->count();
            $info->completionstatus = ($status > 0) ? 'completed' : 'pending';
            array_push($list,$info);
        }
        return $list;
    }

    public function fetchcoursemembersforinvite(Request $input){
        header('Access-Control-Allow-Origin: *');
        $existing = GroupMember::where('group_course_id',$input['courseid'])->where('studentid','!=',0)->lists('studentid');
        $students = Students::whereNotIn('id',$existing)->where('status','active')->select('id','fullname', DB::raw('false as status'))->get();
        return $students;
    }

    public function invitetocourse(Request $input){
        header('Access-Control-Allow-Origin: *');

        $staffid = $input['userid'];
        $groupid = $input['groupid'];
        $courseid = $input['courseid'];

        $list = [];
        $emails = json_decode($input['list']);
        $i = 1;
        foreach($emails as $e){
            $email = $e;
            if($email != ''){
                $userid = User::where('email',$email)->get();
                if(count($userid) > 0){
                    $type = $userid[0]->type;
                    if($type == 'student'){
                        $userlink = $userid[0]->userLink;
                        $check = GroupMember::where('studentid',$userlink)->where('groupid',$input['groupid'])->where('courseid',$input['courseid'])->get();
                        if(count($check) == 0){
                            array_push($list, $userlink);
                        }
                    }
                } else{
                    $staff = User::find($staffid)->full_name;
                    // Mail::send('emails.invite', ['staff'=>$staff], function ($m) use($email, $staff){
                    //     $m->from('info@ezlearnapp.com', 'Ezgroups');
                    //     $m->to($email, '')->subject($staff.' has invited you to join Ezgroups');
                    // });
                }
            }
            $i++;
        }
        $courseoriginalid = Groupcourse::find($courseid)->course_id;
        $time = time();
        foreach($list as $student){
            $new = new GroupMember();
            $new->group_course_id = $courseid;
            $new->courseid = $courseoriginalid;
            $new->groupid = $groupid;
            $new->studentid = $student;
            $new->added_by = $staffid;
            $new->status = 'inactive';
            $new->added_on = $time;
            $new->save();

            /* Push notifications */
            $userinfo = User::where('userLink',$new->studentid)->first();
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
                    )
                );
                $context  = stream_context_create($options);
                $check = file_get_contents(env('PUSH_URL'), false, $context);

            }
            /* End push notifications*/
        } // End for
        return 'success';
    }

    public function invitetogroup(Request $input){
        header('Access-Control-Allow-Origin: *');

        $staffid = $input['userid'];
        $groupid = $input['groupid'];

        $emailList = [];
        $emails = json_decode($input['list']);
        $i = 1;

        foreach($emails as $e){
            if($e->email != ''){
                $email = $e->email;
                $name = '';
                $gender = '';
                $acceptance = 'true';
                $password = 'password';
                $hashedpassword = Hash::make($password);
                $userid = '';
                $activation_code = md5(str_random(5).time());
                $groupid = $input['groupid'];

                $uinfo = User::where('email',$email)->get();
                $count = count($uinfo);

                DB::transaction(function() use($uinfo, $count, $input, $groupid, $staffid, $name, $email, $gender, $acceptance, $password, $hashedpassword, $activation_code, $userid){

                    if($count == 0){
                        $std = new Students();

                        $count=Students::count()+1001;
                        $code='ST'.$count;

                        $std->code = $code;
                        $std->fullname = $name;
                        $std->email = $email;
                        $std->gender = $gender;
                        $std->status = 'inactive';
                        $std->save();

                        $user = new User();
                        $user->full_name = $name;
                        $user->user_id = $userid;
                        $user->email = $email;
                        $user->status = 'inactive';            
                        $user->activation_code = $activation_code;    
                        $user->userLink = $std->id;        
                        $user->type = 'student';
                        $user->password = $hashedpassword;
                        $user->save();

                        $add = new GroupMember();
                        $add->studentid = $std->id;
                        $add->groupid = $groupid;
                        $add->added_by = $staffid;
                        $add->added_on = time();
                        $add->save();

                        $name = $std->fullname;
                    } else{
                        if($uinfo[0]->type == 'student'){
                            $check = GroupMember::where('studentid',$uinfo[0]->userLink)->where('groupid',$groupid)->count();

                            if($check == 0){
                                $add = new GroupMember();
                                $add->studentid = $uinfo[0]->userLink;
                                $add->groupid = $groupid;
                                $add->added_by = $staffid;
                                $add->added_on = time();
                                $add->save();

                                $name = Students::getstudentname($add->studentid);
                            }
                        }
                    }
                });

                if($count == 0){
                    // Mail::send('emails.studentactivation', ['name'=>$name,'code'=>$activation_code,'acceptance'=>$acceptance,'email'=>$email,'password'=>$password], function ($m) use($email, $name, $acceptance){
                    //     $m->from('info@ezlearnapp.com', 'Ezgroups');
                    //     if($acceptance == true){
                    //         $subject = 'Activation email from Ezgroups';
                    //     } else{
                    //         $subject = 'Welcome email from Ezgroups';
                    //     }
                    //     $m->to($email, '')->subject($subject);
                    // });
                }
            }
        }

        $users = GroupMember::where('added_by',$staffid)->where('studentid','!=',0)->where('groupid',$groupid)->groupBy('studentid')->pluck('studentid');
        $userlist = [];
        foreach($users as $u){
            $member = User::where('userLink',$u)->where('type','student')->first();
            $name = ($member->full_name == '') ? Students::getstudentemail($u) : $member->full_name;
            array_push($userlist, ['name'=>$name,'id'=>$u]);
        }

        return Response::json(['status'=>'success','users'=>$userlist]);
    }

    public function staffdeletememberfromgroup(Request $input){
        header('Access-Control-Allow-Origin: *');

        $user = $input['userid'];
        $group = $input['groupid'];

        $uid = User::where('userLink',$user)->first()->id;

        DB::transaction(function() use($group,$user, $uid){
            GroupMember::where('groupid',$group)->where('studentid',$user)->delete();
            Discussion::where('groupId',$group)->where('userId',$user)->delete();
            GroupPost::where('group_id',$group)->where('author',$user)->delete();
            CourseComplete::where('student_id',$user)->delete();

            $posts = GroupPost::where('group_id',$group)->pluck('id');

            
                GroupComment::whereIn('postid',$posts)->where('commenter',$uid)->delete();
            
        });

        return 'success';
    }

    public function staffdeletecoursefromgroup(Request $input){
        header('Access-Control-Allow-Origin: *');

        $courseid = $input['courseid'];

        DB::transaction(function() use($courseid){
            GroupPostMeta::where('courseid',$courseid)->delete();
            GroupPost::where('course_id',$courseid)->delete();
            Groupcourse::where('id',$courseid)->delete();
        });

        return 'success';
    }

    public function stafffetchposts(Request $input){
        header('Access-Control-Allow-Origin: *');
        $courseid = Groupcourse::find($input['courseid'])->course_id;
        $posts = DB::table('group_posts as gp')
                 ->join('users as u', 'gp.author','=','u.id')
                 ->select('gp.*','u.full_name as authorname','u.profile_picture')
                 ->where('gp.course_id',$courseid)
                 ->where('gp.post_type','text')
                 ->orderBy('gp.id','DESC')
                 ->get();

        $postarray = [];

        foreach($posts as $post){
            $post->comments = DB::table('group_comments as gc')
                              ->join('users as u','gc.commenter','=','u.id')
                              ->select('gc.*','u.profile_picture','u.full_name')
                              ->where('gc.postid',$post->id)->orderBy('gc.id','DESC')->take(10)->get();
            array_push($postarray, $post);
        }

        $video = Groupcourse::where('id',$input['courseid'])->first()->video_url;
        return Response::json(['posts'=>$postarray,'video'=>$video]);

    }

    public function studenttasklist(Request $input){
        header('Access-Control-Allow-Origin: *');

        $course = Groupcourse::find($input['courseid']);
        $video = $course->video_url;
        $coursename = $course->course_name;

        $posts = DB::table('group_posts')
                 ->where('course_id',$course->course_id)
                 ->where('post_type','task')
                 ->orderBy('id','DESC')
                 ->get();

        $list = [];
        foreach($posts as $post){
            $post->dueDate = strtotime($post->dueDate);
            array_push($list,$post);
        }

        $coursestatus = CourseComplete::where('group_course_id', $course->course_id)->where('student_id',$input['studentid'])->count();
        $status = ($coursestatus == 1) ? 'completed' : 'pending';

        

        return Response::json(['tasks'=>$list,'video'=>$video, 'status'=>$status, 'coursename'=>$coursename]);
    }

    public function stafftasklist(Request $input){
        header('Access-Control-Allow-Origin: *');
        $course = Groupcourse::find($input['courseid']);
        $video = $course->video_url;
        $coursename = $course->course_name;

        $courseid = $input['courseid'];
        $posts = DB::table('group_posts as gp')
                 ->join('users as u', 'gp.author','=','u.id')
                 ->select('gp.id','gp.short_description','gp.dueDate','gp.time')
                 ->where('gp.course_id',$course->course_id)
                 ->where('gp.post_type','task')
                 ->orderBy('gp.id','DESC')
                 ->get();

        $list = [];
        foreach($posts as $post){
            $post->dueDate = strtotime($post->dueDate);
            array_push($list,$post);
        }

        
        return Response::json(['tasks'=>$list,'video'=>$video, 'coursename'=>$coursename]);
    }

    public function fetchtaskinfo(Request $input){
        header('Access-Control-Allow-Origin: *');

        $posts = DB::table('group_posts as gp')
                 ->join('users as u', 'gp.author','=','u.id')
                 ->select('gp.*','u.full_name as authorname','u.profile_picture')
                 ->where('gp.id',$input['postid'])
                 ->get();

        $postarray = [];

        foreach($posts as $post){
            $post->comments = DB::table('group_comments as gc')
                              ->join('users as u','gc.commenter','=','u.id')
                              ->select('gc.*','u.profile_picture','u.full_name')
                              ->where('gc.postid',$post->id)->orderBy('gc.id','DESC')->get();
            array_push($postarray, $post);
        }

        $postlist = [];

        foreach($postarray as $pl){
            if($pl->post_type == 'task'){
                $temp = GroupPostMeta::where('postid',$pl->id)->first();
                $pl->due_date = $temp->due_date;
                $pl->video_url = $temp->video_url;
            }
            array_push($postlist,$pl);
        }
        return $postlist;
    }

    public function fetchstudenttaskinfo(Request $input){
        header('Access-Control-Allow-Origin: *');

        $posts = DB::table('group_posts as gp')
                 ->join('users as u', 'gp.author','=','u.id')
                 ->select('gp.*','u.full_name as authorname','u.profile_picture')
                 ->where('gp.id',$input['postid'])
                 ->get();

        $postarray = [];

        foreach($posts as $post){
            $post->comments = DB::table('group_comments as gc')
                              ->join('users as u','gc.commenter','=','u.id')
                              ->select('gc.*','u.profile_picture','u.full_name')
                              ->where('gc.postid',$post->id)->orderBy('gc.id','DESC')->get();
            array_push($postarray, $post);
        }

        $postlist = [];
        foreach($postarray as $pl){
            if($pl->post_type == 'task'){
                $temp = GroupPostMeta::where('postid',$pl->id)->first();
                $pl->due_date = $temp->due_date;
                $pl->video_url = $temp->video_url;
            }
            array_push($postlist,$pl);
        }

        $status = TaskComplete::where('student_id',$input['studentid'])->where('post_id',$input['postid'])->get();
        $status = (count($status) > 0) ? 'completed' : 'pending';
        $postlist['status'] = $status;
        return $postlist;
    }

    public function fetchtaskstat(Request $input){
        header('Access-Control-Allow-Origin: *');
        $post = $input['postid'];
        $courseid = $input['courseid'];

        $coursemembers = DB::table('group_members as gm')
                         ->join('users as u','gm.studentid','=','u.userLink')
                         ->select('u.userLink','u.full_name','u.email')
                         ->where('gm.group_course_id',$courseid)
                         ->where('u.type','student')
                         ->get();

        $list = [];
        foreach($coursemembers as $member){
            $status = TaskComplete::where('course_id',$courseid)->where('post_id',$post)->where('student_id',$member->userLink)->get();
            $status = (count($status) > 0) ? 'completed' : 'pending';
            $title = GroupPost::find($post)->short_description;
            $member->status = $status;
            $member->title = $title;
            array_push($list,$member);
        }

        return $list;
    }

    public function staffposttask(Request $input){
        header('Access-Control-Allow-Origin: *');
        $time = time();
        DB::transaction(function() use($input, &$post, $time){

            $course = Groupcourse::find($input['courseid']);

            $post = new GroupPost();
            $post->post_type = 'task';
            $post->text = $input['text'];
            $post->author = $input['staffid'];
            $post->group_id = Groupcourse::where('id',$input['courseid'])->first()->group_id;
            $post->course_id = $course->course_id;
            $post->dueDate=date('Y-m-d',strtotime($input['duedate']));
            $post->short_description=$input['title'];
            $post->time = $time;
            $post->save();

            $user = User::find($input['staffid']);
            $post->authorname = $user->full_name;
            $post->profile_picture = $user->profile_picture;
            $post->video_url = $input['videourl'];

            $postmeta = new GroupPostMeta();
            $postmeta->courseid=$input['courseid'];
            $postmeta->postid=$post->id;
            $postmeta->video_url=$input['videourl'];
            $postmeta->due_date=date('Y-m-d',strtotime($input['duedate']));
            $postmeta->save();
        });

        $info = ['short_description'=>$post->short_description, 'dueDate'=>strtotime($input['duedate']), 'time'=>$time];

        return Response::json(['status'=>'success','postinfo'=>$info]);
    }


// Master methods

    public function masternewcourselist(Request $input){
        header('Access-Control-Allow-Origin: *');
        $courses = Groupcourse::where('admin',$input['staffid'])->where('status','inactive')->get();
        return $courses;
    }

    public function mastersubjectlist(Request $input){
        header('Access-Control-Allow-Origin: *');
        $list = Subject::where('classId',$input['classid'])->select('id','name')->get();
        return $list;
    }

    public function mastercategorylist(Request $input){
        header('Access-Control-Allow-Origin: *');
        $count = Course::count()+1001;
        $coursecode = 'CU'.$count;
        $list = Category::where('parent_class',$input['classid'])->where('subject',$input['subject'])->select('id','category_name')->get();
        return Response::json(['list'=>$list,'coursecode'=>$coursecode]);
    }

    public function mastersubcategorylist(Request $input){
        header('Access-Control-Allow-Origin: *');
        $list = Subcategory::where('parent',$input['category'])->select('id','name')->get();
        return $list;
    }

    public function mastercourselist(Request $input){
        header('Access-Control-Allow-Origin: *');
        $list = Course::where('class_id',$input['classid'])->where('subject',$input['subject'])
                ->where('category',$input['category'])->where('subcategory',$input['subcategory'])
                ->select('id','name')
                ->get();
        return $list;
    }

    public function masterinvitelist(Request $input){
        header('Access-Control-Allow-Origin: *');
        $staffid = $input['staffid'];
        $list = GroupMember::where('added_by',$staffid)->where('studentid','!=',0)->where('status','inactive')->get();

        foreach($list as $l){
            $l->group_name = Group::getgroupname($l->groupid);
            $l->course_name = Course::getcoursename($l->courseid);
            $l->student_name = Students::find($l->studentid)->fullname;
        }

        return $list;
    }

    public function masterlibraryitems(Request $input){
        header('Access-Control-Allow-Origin: *');
        $label1 = Options::where('key','label1')->first();
        $label2 = Options::where('key','label2')->first();
        $label1list = Classname::select('id','class_name')->where('status','active')->orderBy('class_name')->get();
        $recent = Library::where('title','!=','')->select('title','reference','description','classes','subject','category','subCategory')->orderBy('id','DESC')->take(10)->get();

        foreach($recent as $rc){
            $rc->classes = Classname::find($rc->classes)->class_name;
            if(is_numeric($rc->subject) && $rc->subject != 0){
                $rc->subject = Subjects::find($rc->subject)->name;
            } else{
                $rc->subject = null;
            }

            if(is_numeric($rc->category) && $rc->category != 0){
                $rc->category = Category::find($rc->category)->category_name;
            } else{
                $rc->category = null;
            }

            if(is_numeric($rc->subCategory) && $rc->subCategory != 0){
                $rc->subCategory = Subcategory::find($rc->subCategory)->name;
            } else{
                $rc->subCategory = null;
            }
        }

        return Response::json(['label1'=>$label1->value,'label2'=>$label2->value,'label1list'=>$label1list,'recentitems'=>$recent]);
    }

    public function masterfetchcoursecode(Request $input){
        header('Access-Control-Allow-Origin: *');
        $count = Course::count()+1001;
        $code = 'CU'.$count;
        return $code;
    }

    public function mastercreateclass(Request $input){
        header('Access-Control-Allow-Origin: *');
        $insert = new Classname();
        $insert->code = Classname::autogeneratecode();
        $insert->class_name = $input['classname'];
        $insert->status = 'active';
        $insert->save();

        return Response::json(['class_name'=>$insert->class_name,'id'=>$insert->id]);
    }

    public function mastercreatesubject(Request $input){
        header('Access-Control-Allow-Origin: *');
        
        $insert=new Subjects();
        $insert->classId = $input['classid'];
        $insert->code = Subject::autogeneratecode();
        $insert->name = $input['subjectname'];
        $insert->status = 'active';
        $insert->save();

        return Response::json(['name'=>$insert->name,'id'=>$insert->id]);
    }

    public function mastercreatecategory(Request $input){
        header('Access-Control-Allow-Origin: *');
        $insert=new Category();
        $insert->code = Category::autogeneratecode();
        $insert->category_name = $input['category'];
        $insert->parent_class = $input['classid'];
        $insert->subject = $input['subjectid'];
        $insert->created_by = $input['staffid'];
        $insert->status = 'active';
        $insert->description = $input['description'];
        $insert->save();

        return Response::json(['category_name'=>$insert->category_name,'id'=>$insert->id]);
    }

    public function mastercreatesubcategory(Request $input){
        header('Access-Control-Allow-Origin: *');
        $insert=new Subcategory();
        $insert->code = Subcategory::autogeneratecode();
        $insert->classes = $input['classid'];
        $insert->subject = $input['subjectid'];
        $insert->parent = $input['category'];
        $insert->name = $input['subcategory'];
        $insert->created_by = $input['staffid'];
        $insert->status = 'active';
        $insert->description = $input['description'];
        $insert->save();

        return Response::json(['name'=>$insert->name,'id'=>$insert->id]);
    }

    public function mastercreatecourse(Request $input){
        header('Access-Control-Allow-Origin: *');
        DB::transaction(function() use($input){
            $insert = new Course();
            $insert->code=$input['coursecode'];
            $insert->class_id=$input['classid'];
            $insert->subject=$input['subjectid'];
            $insert->category=$input['category'];
            $insert->subcategory = $input['subcategory'];
            $insert->name = $input['coursename'];
            $insert->description = $input['coursedescription'];
            $insert->status = "active";
            $insert->created_by = $input['staffid'];
            $insert->save();

            $new = new Groupcourse();
            $new->code = str_random(8);
            $new->group_id = 0;
            $new->subject_id = $insert->subject;
            $new->course_id = $insert->id;
            $new->admin = $insert->created_by;
            $new->course_name = $insert->name;
            $new->category_id = $insert->category;
            $new->subcategory_id = $insert->subcategory;
            $new->description = '';
            $new->acceptance_mandatory = 'no';
            $new->status = 'inactive';

            $start = date('Y-m-d',strtotime($input['startdate']));
            $new->start_date = strtotime($start);

            $end = date('Y-m-d',strtotime($input['enddate']));
            $new->end_date = strtotime($end);

            $new->video_url = $input['youtube'];

            $new->save();
        });
        return 'success';
    }


    public function gettaskname(Request $req){
        $input = $req['type'];
        if($input != ''){
            $query = Dailytaskstracker::where('tasktype', $input)->select('taskName','id')->get();
            return Response::json(['status'=>'success','data'=>$query]);
        }
        else{
            return Response::json(['status'=>'wrong']);
        }
    }

    public function gettaskname_for_students(Request $req){
        $input = $req['type'];
        $code = $req['code'];
        if($input != '' && $code != ''){
            $test = Dailytasksstudent::with('getstudenttask')->where('studentId',$code)->get();
            $i = 0 ;
            foreach ($test as $key ) {
                $type_dy[$i] = $key->getstudenttask[0]['id'];
                $i++;
            }

            $query = Dailytaskstracker::where('tasktype', $input)->whereIn('id',$type_dy)->select('taskName','id')->get();

            if (count($query)>0) {
                return Response::json(['status'=>true,'data'=>$query]);
            }
            else{
                return Response::json(['status'=>false ,'message'=>'Data not available']);
            }
        }
        else{

            return Response::json(['status'=>'wrong']);
        }
    }

    public function optionName(Request $req){
        $option = $req['option'];
        if($option != ''){
          $data = Dailytasksmetatracker::where('trackerId', $option)->select('id','optionName')->get();
            return Response::json(['status'=>'success','data'=>$data]);
        }
        else{
            return Response::json(['status'=>'wrong']);
        }
    }

    // public function studenttrackerreport(Request $req){
    //     $input = $req['report'];

    //     $html='';
    //     $code = 'ST1001';
    //     // Auth::user()->user_id
    //     $student = Students::where('code', $code)->where('status', 'active')->first();
    //     if($student){
    //         $taskId = $input['taskName'];
    //         $startDate = date('Y-m-d', strtotime($input['startDate']));
    //         $endDate = date('Y-m-d', strtotime($input['endDate']));
    //         $options = $input['taskOption'];
            
    //         $i = 0;
    //         $results = [];
    //         while($startDate <= $endDate){
    //             foreach($options as $optionId){
    //                 $optionDetails= Dailytasksmetatracker::find($optionId);
    //                 $optionName = '';
    //                 if($optionDetails){
    //                     $optionName = $optionDetails->optionName;
    //                 }

    //                 $masterdata = Dailytasksstatustracker::where('trackerId', $taskId)->where('studentId', $student->id)->where('optionId', $optionId)->first();
    //                 $master = 0;
    //                 if($masterdata){
    //                     $master = $masterdata->value;
    //                 }

    //                 $record = Studenttracker::where('taskId', $taskId)->where('taskDate', $startDate)->where('studentId', $student->id)->where('optionId', $optionId)->first();
    //                 $actual = 0;
    //                 if($record){
    //                     $actual = $record->value;
    //                 }else{
    //                     $actual = $master;
    //                 }

    //                 $percentage = 0;
    //                 if($master > 0){
    //                     $percentage = ($actual/$master)*100; 
    //                 }
    //                 $color = 'label-red';
    //                 if($percentage > 80 && $percentage <= 100){
    //                     $color = 'label-yellow';
    //                 }elseif($percentage > 100){
    //                     $color = 'label-green';
    //                 }

    //                 $results[$i]['date'] = date('d-M-Y', strtotime($startDate));
    //                 $results[$i]['option'] = $optionName;
    //                 $results[$i]['standard'] = $master;
    //                 $results[$i]['actual'] = $actual;
    //                 $results[$i]['variance'] = $master - $actual;
    //                 $results[$i]['percentage'] = round($percentage,2);
    //                 $results[$i]['color'] = $color;
    //                 $i++;
    //             }
    //             $startDate = date('Y-m-d', strtotime('+1 day', strtotime($startDate)));
    //         }
    //         return Response::json(['status'=>'success', 'results'=>$results, 'title'=>$student->fullname." - Tracker Details"]);
    //     }
    //     return Response::json(['status'=>'failed', 'message'=>'Please login as a student']);
    // }

    public function studenttrackerreport(Request $req){
        $input=$req['report'];
        $stud_id = $req['stud_code'];
        $stud_code = $req['stud_id'];
        // $code = 'ST1001';
        // Auth::user()->user_id
        $student = Students::where('code', $stud_code)->where('status', 'active')->first();
        if($student){
            $taskId = $input['taskName'];
            $startDate = date('Y-m-d', strtotime($input['startDate']));
            $endDate = date('Y-m-d', strtotime($input['endDate']));
            $options = $input['taskOption'];
            $start_date_in_word = date('F j, Y', strtotime($startDate));
            $end_date_in_word = date('F j, Y', strtotime($endDate)); 
            $i = 0;
            $results = [];
            $results1 = [];
            while($startDate <= $endDate){
                $sdate = $startDate;
                $s = [];
                $k = 0;
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
                    $s['date'] = date('d-M-Y', strtotime($startDate));
                    $s['date1'] = date('F j, Y', strtotime($startDate));
                    $s['list'][$k]['date'] = date('d-M-Y', strtotime($startDate));
                    $s['list'][$k]['option'] = $optionName;
                    $s['list'][$k]['standard'] = $master;
                    $s['list'][$k]['actual'] = $actual;
                    $s['list'][$k]['variance'] = $master - $actual;
                    $s['list'][$k]['percentage'] = round($percentage,2);
                    $s['list'][$k]['color'] = $color;

                    // if(!isset($results1[$d])){
                    //     $results1[$d][0] = $s;
                    // }else{
                    //     $results1[$d][count($results1[$d])] = $s;
                    // }

                    $i++;
                    $k++;
                }
                array_push($results1, $s);
                $startDate = date('Y-m-d', strtotime('+1 day', strtotime($startDate)));
            }
            return Response::json(['status'=>'success', 'results'=>$results, 'title'=>$student->fullname." - Project Details",'results1'=>$results1, 'StartDateInWords'=>$start_date_in_word ,'EndDateInWords'=>$end_date_in_word]);
        }
        return Response::json(['status'=>'failed', 'message'=>'Please login as a student']);
    }

    public function getstudent(Request $req){
        $new = Students::where('status','active')->select('fullname','id')->get();
        $options = Option::select('id','value')->get();
        return response()->json(['data' => $new,'option'=>$options]);
    }

    public function get_student_alias(Request $req){
        $trackerId = $req['data'];
        $data_arr = [];
        $sample_arr = [];
        $i = 0;
        $new = Students::where('status','active')->select('fullname','id')->get();
        $options = Option::select('id','value')->get();
        $stu_alias = Dailytasksstudent::with('getstudent')->where('trackerId',$req['data'])->get();
        $alias = Dailytasksstudent::where('trackerId',$req['data'])->select('studentId','alternative_name')->get();
        // foreach ($alias as $key ) {
        //     $sample_arr['data'] = $stu_alias->getstudent;
        //     $sample_arr['alternative_name'] = $key->alternative_name;
        //     $sample_arr['studentId'] = $key->studentId;
        // }
        // array_push($data_arr, $sample_arr);
        // return $data_arr;

        return response()->json(['data' => $new,'option'=>$options,'name_alias'=>$stu_alias]);
    }
    
    public function admintrackersave(Request $input){
        $datas =  $input['data'];
        $datas['groupname'];
        $userId =  $datas['staffdataId'];
         $days =  $datas['days'];
         if(isset($datas['weekly'])){
            if($datas['weekly'] != ''){
            $weeklydays = $datas['weekly'];
           
            }
        }
        if(isset($datas['monthly'])){
            if($datas['monthly'] != ''){
            $monthlydays = $datas['monthly'];
           
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
         //$namesArray = $datas['temparray'];
         $students = $datas['selectstudent'];
         $option =  $datas['optionsList'];
         $status = $datas['studentList'];
         $op = $option[0]['taskName'];
         $costdetails = $datas['cost'];
         $revenuedetails = $datas['revenue'];

    
                    $task = new Dailytaskstracker();
                    $task->groupName = $datas['groupname'];
                    $task->taskName = $datas['taskname'];
                    $task->tasktype = $datas['selecttask'];
                    $task->startDate=date('Y-m-d',strtotime($datas['startdate']));
                    $task->endDate=date('Y-m-d',strtotime($datas['enddate']));
                    $task->status='active';
                    $task->type = 'x';
                    $task->createdBy = $userId;
                    if($datas['selecttask'] == "monthly"){
                        $task->day = $monthlydays;
                    }elseif ($datas['selecttask'] == "weekly") {
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
                            $data->optionName = $options['taskName'];
                            $data->option_type = $options['lists'];
                           $data->save();
                           $optionstoredIds[$options['taskName']] = $data->id;
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
                           ///return $option;
                            foreach($option as $op){
                                $optionId = $op['taskName']; // first
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
    public function admintrackersavedata(Request $input){
        $datas =  $input['data'];
        $optionlistdatas = $datas['newoptionsList'];
        //$datas['optionsList'];
        $datas['groupname'];
        $userId =  $datas['staffdataId'];
         $days =  $datas['days'];
         if(isset($datas['weekly'])){
            if($datas['weekly'] != ''){
            $weeklydays = $datas['weekly'];
           
            }
        }
        if(isset($datas['monthly'])){
            if($datas['monthly'] != ''){
            $monthlydays = $datas['monthly'];
           
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
         //$namesArray = $datas['temparray'];
         $students = $datas['selectstudent'];
         $option =  $datas['optionsList'];
         $status = $datas['studentList'];
         $op = $option[0]['taskName'];
         $costdetails = $datas['cost'];
         $revenuedetails = $datas['revenue'];

    
                    $task = new Dailytaskstracker();
                    $task->groupName = $datas['groupname'];
                    $task->taskName = $datas['taskname'];
                    $task->tasktype = $datas['selecttask'];
                    $task->startDate=date('Y-m-d',strtotime($datas['startdate']));
                    $task->endDate=date('Y-m-d',strtotime($datas['enddate']));
                    $task->status='active';
                    $task->type = 'y';
                    $task->createdBy = $userId;
                    if($datas['selecttask'] == "monthly"){
                        $task->day = $monthlydays;
                    }elseif ($datas['selecttask'] == "weekly") {
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
                    foreach($optionlistdatas as $options){
                        if($options != '' ){
                            $data = new Dailytasksmetatracker();
                            $data->trackerId = $trackerId;
                            $data->optionName = $options['options'];
                            $data->option_type = '0';
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
                        foreach($option as $opt){
                            $data = new Dailytasksstudent();
                            $data->trackerId = $trackerId;
                            $data->studentId = $student;
                            $data->alternative_name = $opt['taskName'];
                            $data->type =$opt['lists'];
                            $data->save();
                        }
                    }

                    foreach($students as $student){
                        foreach($optionlistdatas as $optdates){
                            $name = $optdates['options'];
                            $optionId = $optionstoredIds[$name];

                            foreach($option as $opt){
                                $record = Dailytasksstudent::where('trackerId', $trackerId)->where('studentId', $student)->where('alternative_name', $opt['taskName'])->first();
                                if($record){
                                    $value = $opt[$name];
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

    public function logout(Request $req){
        $query =  Auth::logout();
        return response()->json(['success']);
    }

    // public function studenttrackerreportAdmin(Request $request){
    //     $req = $request['report'];
    //     $startDate = date('Y-m-d', strtotime($req['startDate']));
    //     $endDate = date('Y-m-d', strtotime($req['endDate']));
    //     $taskName = $req['taskName'];
    //     $student = Students::get();
    //     $i = 0;
    //     $date = [];
    //     foreach ($student as $s) {
    //         while ($startDate <= $endDate) {
    //             $option = Dailytasksstatustracker::where('studentId',$s->id)->pluck('trackerId');
    //             return $option;
    //         }
    //     }

    //     // if($req['taskName']){
    //     //     $i = 0;
    //     //     $results = [];
    //     //     while ($startDate <= $endDate) {
    //     //         $student = Studenttracker::where('taskId',$taskName)->get();
    //     //         foreach ($student as $stu) {
    //     //             $option = Dailytasksstatustracker::where('trackerId',$taskName)->where('studentId',$stu['studentId'])->first();
    //     //             foreach($option as $optionId){
    //     //                 $optionDetails= Dailytasksmetatracker::find($optionId);
    //     //                 $optionName = '';
    //     //                 if($optionDetails){
    //     //                     $optionName = $optionDetails->optionName;
    //     //                 }

    //     //                 $masterdata = Dailytasksstatustracker::where('trackerId', $taskName)->where('studentId', $stu['studentId'])->where('optionId', $optionId)->first();
    //     //                 $master = 0;

    //     //                 if($masterdata){
    //     //                     $master = $masterdata->value;
    //     //                 }

    //     //                 $record = Studenttracker::where('taskId', $taskName)->where('taskDate', $startDate)->where('studentId',$stu['studentId'])->where('optionId', $optionId)->first();

    //     //                 if($record){
    //     //                     $actual = $record->value;
    //     //                 }else{
    //     //                     $actual = $master;
    //     //                 }

    //     //                 $percentage = 0;
    //     //                 if($master > 0){
    //     //                     $percentage = ($actual/$master)*100; 
    //     //                 }

    //     //                 $results[$i]['option'] = $optionName;
    //     //                 $results[$i]['standard'] = $master;
    //     //                 $results[$i]['actual'] = $actual;
    //     //                 $results[$i]['variance'] = $master - $actual;
    //     //                 $results[$i]['percentage'] = round($percentage,2);

    //     //                 $i++;
    //     //             }
    //     //         }
    //     //         $startDate = date('Y-m-d', strtotime('+1 day', strtotime($startDate)));                
    //     //     }

    //     //     return response()->json(['status'=>'success','data'=>$results]);       
    //     // }else{
    //     //     return response()->json(['status'=>'Error']);   
    //     // }
        
    // }

    public function studenttrackerreportAdmin(Request $req){
        $input=$req['report'];

        $html='';
        $code = 'ST1001';
        // Auth::user()->user_id
        $student = Students::where('status', 'active')->select('code','id')->get();
        if($student){
            $taskId = $input['taskName'];
            $startDate = date('Y-m-d', strtotime($input['startDate']));
            $endDate = date('Y-m-d', strtotime($input['endDate']));
            //$options = $input['taskOption'];
            $options = Dailytasksmetatracker::where('trackerId',$input['taskName'])->pluck('id','option_type')->toArray();
            $i = 0;
            $results = [];
            $studentlist = [];
            $sl = 0;
            $results1 = [];
            foreach($student as $stu){
                while($startDate <= $endDate){
                    $sdate = $startDate;
                    $s = [];
                    $k = 0;
                    foreach($options as $optionId){
                        $optionDetails= Dailytasksmetatracker::find($optionId);
                        $optionName = '';
                        if($optionDetails){
                            $optionName = $optionDetails->optionName;
                            $optionType = $optionDetails->option_type;
                        }

                        $masterdata = Dailytasksstatustracker::where('trackerId', $taskId)->where('studentId', $stu->id)->where('optionId', $optionId)->first();
                        $master = 0;
                        if($masterdata){
                            $master = $masterdata->value;
                        }

                        $record = Studenttracker::where('taskId', $taskId)->where('taskDate', $startDate)->where('studentId', $stu->id)->where('optionId', $optionId)->first();
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



                        $color = '';

                        
                        switch ($optionType == 1) {
                            case $percentage > 60 && $percentage < 70:
                                 $color = 'label-red';
                                break;

                            case $percentage > 70 && $percentage > 95:
                                $color = 'label-yellow';
                                break;
                            
                            case $percentage > 95:
                                $color = 'label-green';
                                break;
                        }

                        switch ($optionType == 2) {
                            case $percentage > 60 && $percentage < 70:
                                 $color = 'label-green';
                                break;

                            case $percentage > 70 && $percentage > 95:
                                $color = 'label-yellow';
                                break;
                            
                            case $percentage > 95:
                                $color = 'label-red';
                                break;
                        }
                        

                        // if($optionType == 1) {
                        //     if($percentage > 60 && $percentage < 70){
                        //         $color = 'label-red';
                        //     }elseif($percentage > 70 && $percentage > 95){
                        //         $color = 'label-yellow';
                        //     }elseif ($percentage > 95) {
                        //        $color = 'label-green';
                        //     }

                        // }elseif ($optionType == 2) {
                        //     if($percentage > 60 && $percentage < 70){
                        //         $color = 'label-green';
                        //     }elseif($percentage > 70 && $percentage > 95){
                        //         $color = 'label-yellow';
                        //     }elseif ($percentage > 95) {
                        //        $color = 'label-red';
                        //     }
                        // }
                        

                        $d = $sdate;
                        $s['date'] = date('d-M-Y', strtotime($startDate));
                        $s['list'][$k]['date'] = date('d-M-Y', strtotime($startDate));
                        $s['list'][$k]['option'] = $optionName;
                        $s['list'][$k]['option_type'] = $optionType;
                        $s['list'][$k]['standard'] = $master;
                        $s['list'][$k]['actual'] = $actual;
                        $s['list'][$k]['variance'] = $master - $actual;
                        $s['list'][$k]['percentage'] = round($percentage,2);
                        $s['list'][$k]['color'] = $color;

                        // if(!isset($results1[$d])){
                        //     $results1[$d][0] = $s;
                        // }else{
                        //     $results1[$d][count($results1[$d])] = $s;
                        // }

                        $i++;
                        $k++;

                    }
                    array_push($results1, $s);
                    $startDate = date('Y-m-d', strtotime('+1 day', strtotime($startDate)));
                }
                $studentlist[$sl]['studentId'] = $stu->id;
                $studentlist[$sl]['studentCode'] = $stu->code;
                $studentlist[$sl]['studentName'] = Students::getstudentname($stu->id);
                $studentlist[$sl]['records'] = $results1;
                $sl++;
            }//end student foreach
            return Response::json(['status'=>'success', 'results'=>$results,'results1'=>$results1,'studentlist'=>$studentlist]);
        }
        return Response::json(['status'=>'failed', 'message'=>'Please login as a student']);
    }

    public function getDate(Request $req){
        $in = $req['date'];
        $startDate = date('Y-m-d', strtotime($in['startDate']));
        $endDate = date('Y-m-d', strtotime($in['endDate']));
        $i = 0;
        $date = [];
        while ($startDate <= $endDate) {
                    echo "$startDate\n";
                    $startDate = date ("Y-m-d", strtotime("+1 day", strtotime($startDate)));
                    $date[$i]['date'] = $startDate;
                    $i++;
        }

        return response()->json(['status'=>'success','date'=>$date]);
    }
    
    public function gettask(Request $req){
        $input = $req['data'];
        $stu = Students::get();
        if($input != ''){
            $query = Dailytaskstracker::where('tasktype', $input)->select('taskName','id')->get();
            return Response::json(['status'=>'success','data'=>$query]);
        }
        else{
            return Response::json(['status'=>'wrong','data'=>$stu]);
        }
    }

    public function gettaskdata(Request $req){
        $datas = $req['data'];
       // $tasktype = $input['selecttask'];
       // $tudentid = $input['userdataId'];
        $code = $datas['userdataId'];
        $input = $datas['selecttask'];
          
       
        if($input != '' && $code != ''){
            $test = Dailytasksstudent::with('getstudenttask')->where('studentId',$code)->get();
            $i = 0 ;
            foreach ($test as $key ) {
                $type_dy[$i] = $key->getstudenttask[0]['id'];
                $i++;
            }

            $query = Dailytaskstracker::where('tasktype', $input)->where('type','x')->whereIn('id',$type_dy)->select('taskName','id')->get();

            if (count($query)>0) {
                return Response::json(['status'=>true,'data'=>$query]);
            }
            else{
                return Response::json(['status'=>false ,'message'=>'Data not available']);
            }
        }
        else{

            return Response::json(['status'=>'wrong']);
        }
    }

    public function gettaskdatayaxis(Request $req){
        $datas = $req['data'];
       // $tasktype = $input['selecttask'];
       // $tudentid = $input['userdataId'];
        $code = $datas['userdataId'];
        $input = $datas['selecttask'];
          
       
        if($input != '' && $code != ''){
            $test = Dailytasksstudent::with('getstudenttask')->where('studentId',$code)->get();
            $i = 0 ;
            foreach ($test as $key ) {
                $type_dy[$i] = $key->getstudenttask[0]['id'];
                $i++;
            }

            $query = Dailytaskstracker::where('tasktype', $input)->where('type','y')->whereIn('id',$type_dy)->select('taskName','id')->get();

            if (count($query)>0) {
                return Response::json(['status'=>true,'data'=>$query]);
            }
            else{
                return Response::json(['status'=>false ,'message'=>'Data not available']);
            }
        }
        else{

            return Response::json(['status'=>'wrong']);
        }
    }
    
    

    public function tasksavedata(Request $req){
        $input=$req['data'];
        $studentCode = $input['studentdataid'];
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
        $studentdetail = Students::where('code', $studentCode)->where('status', 'active')->first();
        if($studentdetail){
            $studentId = $studentdetail->id;
        }

        // $updatestatus = 'yes';
        // $statuserror = '';
        // if($tasktype == 'daily'){
        //  $day = date('N', strtotime($taskDate));
        //  $days = $groupRecord->day;
        //  $selectedDays = [];
        //  if($days != ''){
        //      $selectedDays = explode(',', $days);
        //  }
        //  if(!in_array($day, $selectedDays)){
        //      $updatestatus = 'no';
        //      $statuserror = 'Login On Correct Date And Update';
        //  }
        // }elseif($tasktype == 'weekly'){
        //  $day = date('N', strtotime($taskDate));
        //  if($day != $groupRecord->day){
        //      $updatestatus = 'no';
        //      $statuserror = 'Weekly TrackerUpdated On '.$this->weekdays[$groupRecord->day];
        //  }
        // }elseif($tasktype == 'monthly'){
        //  $day = date('j', strtotime($taskDate));
        //  if($day != $groupRecord->day){
        //      $updatestatus = 'no';
        //      $statuserror =  'Weekly TrackerUpdated On '.date('l',strtotime($groupRecord->day));
        //  }
        // }

        // if($updatestatus == 'no'){
        //  $studentId = '';
        // }

        $statuserror = '';
        if(sizeof($selectedDate) == 0){
            $statuserror = 'No records available';
        }

        $taskDetails = [];
        $selectedDateArray = [];
        foreach($selectedDate as $sedate){
            $array = [];
            $array['dateFormat'] = date('d-M-Y', strtotime($sedate));
            $tempwidth = round(sizeof($student)*50);
            $array['width'] =  $tempwidth.'px';
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
                      
                    $ran = ['badge-primary','badge-success','badge-info','badge-warning','badge-danger','badge-purple','badge-pink','badge-orange','badge-brown','badge-teal','badge-inverse'];
                    $randomElement = $ran[array_rand($ran, 1)];

                    $array['result'][$stu]['name'] = Students::getstudentname($stu);
                    $array['result'][$stu][$opkey] = $val;
                     $array['result'][$stu]['color'] = $randomElement;
                    $array['result'][$stu]['changed'][$opkey] = 'no';
                    $array['result'][$stu]['alternative'] =  $studentadata;

                    $array['result'][$stu]['bgcolor'][$opkey] = '#efefef';
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
                                $re = DB::table('option')->where('id', $trackerTypeRecord->option_type)->first();
                                if($re){
                                    $type = $re->type;
                                    if($type == 'alpha'){
                                        $array['result'][$stu]['bgcolor'][$opkey] = '#efefef';
                                        $array['result'][$stu]['textcolor'][$opkey] = 'red';
                                    }else{
                                        $color = Trackerpercentage::getcolor($input['taskname'], $type, $percentage);
                                        $array['result'][$stu]['bgcolor'][$opkey] = $color;
                                        $array['result'][$stu]['textcolor'][$opkey] = '#efefef';
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

    public function tasksavedatamultiple(Request $req){
        $input=$req['data'];
        $studentCode = $input['studentdataid'];
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
        $studentdetail = Students::where('code',$studentCode)->where('status', 'active')->first();
        if($studentdetail){
            $studentId = $studentdetail->id;
        }

        // $updatestatus = 'yes';
        // $statuserror = '';
        // if($tasktype == 'daily'){
        //  $day = date('N', strtotime($taskDate));
        //  $days = $groupRecord->day;
        //  $selectedDays = [];
        //  if($days != ''){
        //      $selectedDays = explode(',', $days);
        //  }
        //  if(!in_array($day, $selectedDays)){
        //      $updatestatus = 'no';
        //      $statuserror = 'Login On Correct Date And Update';
        //  }
        // }elseif($tasktype == 'weekly'){
        //  $day = date('N', strtotime($taskDate));
        //  if($day != $groupRecord->day){
        //      $updatestatus = 'no';
        //      $statuserror = 'Weekly TrackerUpdated On '.$this->weekdays[$groupRecord->day];
        //  }
        // }elseif($tasktype == 'monthly'){
        //  $day = date('j', strtotime($taskDate));
        //  if($day != $groupRecord->day){
        //      $updatestatus = 'no';
        //      $statuserror =  'Weekly TrackerUpdated On '.date('l',strtotime($groupRecord->day));
        //  }
        // }

        // if($updatestatus == 'no'){
        //  $studentId = '';
        // }

        $statuserror = '';
        if(count($selectedDate) == 0){
            $statuserror = 'No records available';
        }

        $taskDetails = [];
        $selectedDateArray = [];
        foreach($selectedDate as $sedate){
            $array = [];
            $k = 0;
            $studentsnames = [];
            foreach($student as $stu){
                $Studentsnames[] = Students::getstudentname($stu->studentId);
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
                $selectedDateArray[$sedate]['studentslist'] = array_values(array_unique($Studentsnames));
            }
            $selectedDateArray[$sedate]['dateFormat'] = date('d-M-Y', strtotime($sedate));
            $selectedDateArray[$sedate]['date'] = $sedate;

            $selectedDateArray[$sedate]['results'] = $array;
        }
        $taskDetails = $selectedDateArray;

        return Response::json(['status'=>'success','totalStatus'=> $totalStatus,'trackerData'=>$trackerData, 'taskDetails'=>$taskDetails, 'options'=>$options, 'loginstudentId'=>$studentId, 'statuserror'=>$statuserror, 'selectedDate'=>$selectedDate ]);
    }

    public function adminreportcon_view(Request $req){
        $input=$req['report'];

        $html='';
        $code = 'ST1001';
        $type = Dailytaskstracker::where('id',$input['taskName'])->select('tasktype')->get();

        if(isset($input['studentName']) && count($input['studentName']) > 0){
            $student = Students::where('status', 'active')->whereIn('id', $input['studentName'])->select('code','id', 'fullname')->get();
        }else{
            $student = Students::where('status', 'active')->select('code','id', 'fullname')->get();
        }

        
        $j = 0;
        $alias = [];
        $student_alias_arr = [];

        if ($student) {
            foreach ($student as $stu) {
                $student_alias_name = Dailytasksstudent::where('trackerId',$input['taskName'])->where('studentId',$stu->id)->select('alternative_name','id','studentId')->first();
                $alias[$j] = $student_alias_name;
                $j++;
            }
        }
        
        array_push($student_alias_arr, $alias);
        $student_alias =  $student_alias_arr[0];

        if($student_alias){
            $taskId = $input['taskName'];
            $startDate = date('Y-m-d', strtotime($input['startDate']));
            $endDate = date('Y-m-d', strtotime($input['endDate']));
            $start_date_in_word = date('F j, Y', strtotime($startDate));
            $end_date_in_word = date('F j, Y', strtotime($endDate));
            $options = $input['taskOption'];
            
            $i = 0;
            $results = [];
            while($startDate <= $endDate){
                foreach($student_alias as $stu){
                    $sdate = date('F j, Y', strtotime($startDate));
                    foreach($options as $optionId){
                        $optionDetails= Dailytasksmetatracker::find($optionId);
                        $optionName = '';
                        if($optionDetails){
                            $optionName = $optionDetails->optionName;
                            $optionType = $optionDetails->option_type;
                        }

                        $masterdata = Dailytasksstatustracker::where('trackerId', $taskId)->where('studentId', $stu['studentId'])->where('optionId', $optionId)->first();
                        $master = 0;
                        if($masterdata){
                            $master = $masterdata->value;
                        }

                        $record = Studenttracker::where('taskId', $taskId)->where('taskDate', $startDate)->where('studentId', $stu->studentId)->where('optionId', $optionId)->first();

                        $actual = 0;
                        if($record){
                            $actual = $record->value;
                        }else{
                            $actual = $master;
                        }

                        $percentage = 0;
                        if($master > 0){
                            $percentage = round(($actual/$master)*100); 
                        }

                        $color = '';



                        $student_name = Students::where('id',$stu->studentId)->select('fullname')->first();

                        
                        // switch ($optionType == 1) {
                        //     case $percentage <= 70:
                        //         $color = 'red';
                        //     break;

                        //     case $percentage > 70 && $percentage <= 95:
                        //         $color = 'yellow';
                        //     break;
                            
                        //     case $percentage > 95:
                        //         $color = 'green';
                        //     break;
                        // }

                        // switch ($optionType == 2) {
                        //     case $percentage <= 70:
                        //          $color = 'green';
                        //     break;

                        //     case $percentage > 70 && $percentage <= 95:
                        //         $color = 'yellow';
                        //     break;
                            
                        //     case $percentage > 95:
                        //         $color = 'red';
                        //     break;
                        // }

                        if($optionType == 2){
                            $color = Trackerpercentage::getcolor($input['taskName'], 'cost', $master);
                            $results[$sdate][$i]['colours'] = $color;
                            $results[$sdate][$i]['colours_border'] = '2px solid'.$color;
                            
                        }elseif($optionType == 1){
                            $color = Trackerpercentage::getcolor($input['taskName'], 'revenue', $master);
                            $results[$sdate][$i]['colours'] = $color;
                            $results[$sdate][$i]['colours_border'] = '2px solid'.$color;
                        }

                        $results[$sdate][$i]['stu'] = $stu->alternative_name;
                        $results[$sdate][$i]['stu_name'] = $student_name['fullname'];
                        $results[$sdate][$i]['date'] = date('j, F ', strtotime($startDate));
                        $results[$sdate][$i]['option'] = $optionName;
                        $results[$sdate][$i]['optionType'] = $optionType;
                        $results[$sdate][$i]['percentage'] = $percentage;
                        $results[$sdate][$i]['std'] = $master;
                        $results[$sdate][$i]['act'] = $actual;
                        $results[$sdate][$i]['var'] = $master - $actual;
                        $i++;
                    }
                }
                $startDate = date('Y-m-d', strtotime('+1 day', strtotime($startDate)));
                $i = 0;
            }
            return Response::json(['status'=>'success', 'results'=>$results, 'start_date_in_word'=>$start_date_in_word, 'end_date_in_word'=>$end_date_in_word, "TaskType"=>$type]);
        }
        return Response::json(['status'=>'failed', 'message'=>'Please login as a student']);
    }

    // public function studentupdate(Request $req){
        // $input = $req->all();
        // $input = $input['data'];
        // $taskDetails = $input['taskdetails'];
        // $taskId = $input['taskname'];
        // $options=Dailytasksmetatracker::where('trackerId',$input['taskname'])->lists('id');
        // $student = Dailytasksstudent::where('trackerId',$input['taskname'])->lists('studentId');

        // foreach($taskDetails as $task){
        //     $date = date('Y-m-d',strtotime($task['date']));
        //     $result = $task['result'];
        //     foreach($result as $key=>$val){
        //         foreach($val as $k=>$v){
        //             if($k != 'name'){
        //                 $check = Studenttracker::where('taskId', $taskId)->where('taskDate', $date)->where('studentId', $key)->where('optionId', $k)->first();
        //                 if(count($check) == 1){
        //                     $insert = Studenttracker::find($check->id);
        //                 }else{
        //                     $insert = new Studenttracker();
        //                     $insert->taskId = $taskId;
        //                     $insert->taskDate = $date;
        //                     $insert->studentId = $key;
        //                     $insert->optionId = $k;
        //                 }
        //                 $insert->value = $v;
        //                 $insert->save();
        //             }
        //         }
        //     }
        // }
        // return Response::json(['status'=>'success']);
    //     $input = $req->all();
    //     $input = $input['data'];
    //     $taskDetails = $input['taskdetails'];
    //     $taskId = $input['taskname'];
    //     $options=Dailytasksmetatracker::where('trackerId',$input['taskname'])->select('id', 'option_type')->get();
    //     $student = Dailytasksstudent::where('trackerId',$input['taskname'])->lists('studentId');
    //     $trackerType = [];
    //     foreach($options as $opt){
    //         $type = 'alpha';
    //         if($opt->option_type == 1){
    //             $type = 'revenue';
    //         }else if($opt->option_type == 2){
    //             $type = 'cost';
    //         }
    //         $trackerType[$opt->id] = $type;
    //     }

    //     foreach($taskDetails as $task){
    //         $date = date('Y-m-d',strtotime($task['date']));
    //         $result = $task['result'];
    //         foreach($result as $key=>$val){
    //             foreach($val as $k=>$v){
    //                 if($k != 'name' && $k != 'textcolor' && $k != 'bgcolor' && $k != 'changed' && $k != 'alternative'){
    //                     $changedStatus = $val['changed'][$k];
    //                     if($changedStatus == 'yes'){
    //                         $check = Studenttracker::where('taskId', $taskId)->where('taskDate', $date)->where('studentId', $key)->where('optionId', $k)->first();
    //                         if(count($check) == 1){
    //                             $insert = Studenttracker::find($check->id);
    //                         }else{
    //                             $insert = new Studenttracker();
    //                             $insert->taskId = $taskId;
    //                             $insert->taskDate = $date;
    //                             $insert->studentId = $key;
    //                             $insert->optionId = $k;
    //                         }
    //                         $insert->value = $v;
    //                         $insert->save();


    //                         //change bgcolor & text color
    //                         $percentage = 0;
    //                         $masterRecord = DB::table('dailytasksstatustracker')->where('trackerId', $taskId)->where('studentId', $key)->where('optionId', $k)->first();
    //                         if($masterRecord){
    //                             $masterVal = $masterRecord->value;
    //                             $actualVal = $v;
    //                             if($masterVal > 0){
    //                                 $percentage = ($actualVal/$masterVal)*100;
    //                             }
    //                             if(isset($trackerType[$k])){
    //                                 $color = Trackerpercentage::getcolor($taskId, $trackerType[$k], $percentage);
    //                                 $val['bgcolor'][$k] = $color;
    //                                 $val['textcolor'][$k] = '#efefef';
    //                                 $result[$key] = $val;
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }
    //     $taskDetails[0]['result'] = $result;
    //     return Response::json(['status'=>'success', 'taskDetails'=>$taskDetails]);

    // }

    public function studentupdate(Request $req){
        $input = $req->all();
        $input = $input['data'];
        $taskDetails = $input['taskdetails'];
        $taskId = $input['taskname'];
        $options=Dailytasksmetatracker::where('trackerId',$input['taskname'])->select('id', 'option_type')->get();
        $student = Dailytasksstudent::where('trackerId',$input['taskname'])->lists('studentId');
        $trackerType = [];
        foreach($options as $opt){
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
                    if($k != 'name' && $k != 'textcolor' && $k != 'bgcolor' && $k != 'changed' && $k != 'alternative' && $k != 'color'){
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
                                    $val['bgcolor'][$k] = '#efefef';
                                    $val['textcolor'][$k] = 'red';
                                    $result[$key] = $val;
                                    }else{
                                    $color = Trackerpercentage::getcolor($taskId, $trackerType[$k], $percentage);
                                    $val['bgcolor'][$k] = $color;
                                    $val['textcolor'][$k] = '#efefef';
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
    public function studentupdatedata(Request $req){
        $input = $req->all();
        $input = $input['data'];
        $taskDetails = $input['taskdetails'];
        $taskId = $input['taskname'];
        $options=Dailytasksmetatracker::where('trackerId',$input['taskname'])->select('id', 'option_type')->get();
        $student = Dailytasksstudent::where('trackerId',$input['taskname'])->lists('studentId');
        $colourvalue = Dailytasksstudent::where('trackerId',$input['taskname'])->get();
        $trackerType = [];
        foreach($colourvalue as $cv){
            $se = Option::where('id',$cv->type)->first();
            $type = $se->type;
            $type;
            $trackerType[$cv->id] = $type;
        }

        foreach($taskDetails as $sedate=>$task){
            //return $sedate;
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
                            $val['studentId'];
                            $masterRecord = Dailytasksstatustracker::where('trackerId', $taskId)->where('studentId', $val['studentId'])->where('optionId', $k)->where('alternativeId',$v['alternativeId'])->first();
                            if($masterRecord){
                                $masterVal = $masterRecord->value;
                                $actualVal = $v['opt'];
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


    public function getTasktype(){
        $type = Tasktype::select('id','type')->get();
        return $type;
        return response()->json(['type'=>$type]);
    }




}

