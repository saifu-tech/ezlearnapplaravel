<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use DB;

use App\Group;
use App\Course;
use App\CourseComplete;
use App\Groupcourse;
use App\GroupPost;
use App\GroupComment;
use App\Staff;
use App\Option;

class CourseController extends Controller
{
    public function coursePage($groupid){
        $access = Course::hasAccess($groupid);
        if(!$access){
            return '<h1>Access prohibited</h1>';
        }
        $groupname = Group::getgroupname($groupid);
        $courses = Groupcourse::getGroupCourses($groupid);
        $student = Option::getvalue('student_alternate');
        return view('admin.groups.courses')->with('groupname',$groupname)->with('groupid',$groupid)->with('courses',$courses)->with('student_alternate',$student);
    }

    public function getAllTasks(Request $input){
        $groupid = $input['groupid'];
        $courseid = $input['courseid'];
        $tasks = GroupPost::getAllTasks($groupid, $courseid);

        return $tasks;
    }

    public function createTask(Request $input){
        $params = json_decode($input['params']);
        $create = GroupPost::createTask((array) $params);

        return response()->json(['status'=>'success', 'info'=>$create]);
    }

    public function getTaskInfo(Request $input){
        $taskid = $input['taskid'];
        $info = Course::getTaskInfo($taskid);
        return $info;
    }

    public function doComment(Request $input){
        $postid = $input['postid'];
        $comment = $input['comment'];
        $info = GroupComment::doComment($postid, $comment);
        return response()->json(['status'=>'success','info'=>$info]);
    }

    public function deleteComment(Request $input){
        $commentid = $input['commentid'];
        $delete = GroupComment::deleteComment($commentid);
        if($delete){
            return 'success';
        }
    }

    public function getCourseMembers(Request $input){
        $courseid = $input['courseid'];
        $groupid = $input['groupid'];
        $staffid = Auth::user()->id;
        $members =  Group::getMembers($staffid,$groupid);
        $courseMembers = GroupCourse::getMembers($courseid,$staffid);
        $completionStatus = CourseComplete::getStatus($courseid);
        $list = [];
        array_push($list,['members'=>$members, 'courseMembers'=>$courseMembers,'completionStatus'=>$completionStatus]);

        return $list;
    }

    public function saveMembers(Request $input){
        $staffid = Auth::user()->id;
        $groupid = $input['groupid'];
        $courseid = $input['courseid'];

        $members = json_decode($input['members']);

        DB::transaction(function() use($members,$staffid,$groupid,$courseid){
                
            $delete = GroupCourse::deleteGroupMembers($staffid,$groupid,$courseid);

            $save = GroupCourse::saveCourseMembers($members,$groupid,$courseid,$staffid);
                    
        });

        

        return 'success';
    }
}
