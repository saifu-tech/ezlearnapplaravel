<?php


Route::get('activate/{code}','ApiController@activate');
Route::get('studentactivate/{code}','ApiController@studentactivate');
Route::get('us','TestController@us');

Route::group(['prefix'=>'api','middleware' => 'prerequest'], function(){
    header('Access-Control-Allow-Origin: *');
    header( 'Access-Control-Allow-Headers: Authorization, Content-Type' );
    Route::get('registerdevice','ApiController@registerdevice');
    Route::post('login','ApiController@login');
    Route::post('signup','ApiController@signup');
    Route::get('savename','ApiController@savename');
    Route::get('getdashboard', 'ApiController@getdashboard');
    Route::get('mygroups','ApiController@mygroups');
    Route::get('mycourses','ApiController@mycourses');
    Route::get('fetchposts','ApiController@fetchposts');
    Route::get('completecourse','ApiController@completecourse');
    Route::get('incompletecourse','ApiController@incompletecourse');
    Route::get('docomment','ApiController@docomment');
    Route::get('student/tasklist', 'ApiController@studenttasklist');
    Route::get('student/fetchtaskinfo', 'ApiController@fetchstudenttaskinfo');
    Route::get('updatetaskstatus','ApiController@updatetaskstatus');
    Route::get('dopost', 'ApiController@dopost');
    Route::get('acceptgroupinvite', 'ApiController@acceptgroupinvite');
    Route::get('declinegroupinvite', 'ApiController@declinegroupinvite');

    Route::get('getdailytasks','ApiController@getdailytasks');
    Route::get('getgroupinfo','ApiController@getgroupinfo');

    Route::get('getdailytaskoptions','ApiController@getdailytaskoptions');
    Route::get('updatedailytaskstatus','ApiController@updatedailytaskstatus');
    Route::get('fetchdailytaskstat','ApiController@fetchdailytaskstat');
    Route::get('fetchtaskstatbydate','ApiController@fetchtaskstatbydate');
    Route::get('fetchcoursestat','ApiController@fetchcoursestat');
    Route::get('fetchinvitations','ApiController@fetchinvitations');

    Route::get('fetchdiscussions', 'ApiController@fetchdiscussions');
    Route::get('sendmessage', 'ApiController@sendmessage');

    Route::get('fetchsettings', 'ApiController@fetchsettings');
    Route::get('savesettings', 'ApiController@savesettings');
    Route::get('changepassword', 'ApiController@changepassword');

    Route::get('savelibraryitem', 'ApiController@savelibraryitem');
    Route::get('searchlibrary', 'ApiController@searchlibrary');

    //MY API admin/tracker/taskname
    Route::post('getTaskname','ApiController@gettaskname');
    Route::post('getTaskname_for_students','ApiController@gettaskname_for_students');
    Route::post('getTaskoption','ApiController@optionName');
    Route::post('getReport','ApiController@studenttrackerreport');
    Route::post('getReportAdmin','ApiController@studenttrackerreportAdmin');
    Route::post('getDate','ApiController@getDate');
    Route::post('getReportcon_view','ApiController@adminreportcon_view');


    
    Route::get('getstudent','ApiController@getstudent');
    Route::get('getTasktype','ApiController@getTasktype');
    
    Route::post('get_student_alias' , 'ApiController@get_student_alias');
     Route::post('logout','ApiController@logout');
     Route::post('gettask','ApiController@gettask');
     Route::post('gettaskdata','ApiController@gettaskdata');
     Route::post('gettaskdatayaxis','ApiController@gettaskdatayaxis');
     Route::post('admintrackersave','ApiController@admintrackersave');
     Route::Post('admintrackersavedata','ApiController@admintrackersavedata');
   
    
    Route::post('tasksavedata','ApiController@tasksavedata');
    Route::post('tasksavedatamultiple','ApiController@tasksavedatamultiple');
    Route::post('studentupdate','ApiController@studentupdate');
    Route::post('studentupdatedata','ApiController@studentupdatedata');





    ///added
     //Route::post('logindata','ApiController@logindata');

    // Staff
    Route::get('staff/dashboarditems', 'ApiController@dashboarditems');
    Route::get('staff/createstudent', 'ApiController@createstudent');
    Route::get('staff/createstaffgroup', 'ApiController@createstaffgroup');
    Route::get('staff/editstaffgroup', 'ApiController@staffeditgroupinfo');
    Route::get('staff/deletestaffgroup', 'ApiController@deletestaffgroup');
    Route::get('staff/mygroups', 'ApiController@staffgroups');
    Route::get('staff/getgroupinfo', 'ApiController@staffgetgroupinfo');
    Route::get('staffcourses','ApiController@staffcourses');
    Route::get('staff/getnextgroupid', 'ApiController@staffgetnextgroupid');
    Route::get('staff/fetchcourselist', 'ApiController@fetchcourselist');
    Route::get('staff/fetchcoursestudents', 'ApiController@fetchcoursestudents');
    Route::get('staff/fetchcoursemembers', 'ApiController@fetchcoursemembers');
    Route::get('staff/fetchcoursemembersforinvite', 'ApiController@fetchcoursemembersforinvite');
    Route::get('staff/invitetocourse', 'ApiController@invitetocourse');
    Route::get('staff/invitetogroup', 'ApiController@invitetogroup');
    Route::get('staff/deletememberfromgroup', 'ApiController@staffdeletememberfromgroup');
    Route::get('staff/deletecoursefromgroup', 'ApiController@staffdeletecoursefromgroup');
    Route::get('staff/fetchposts', 'ApiController@stafffetchposts');
    Route::get('staff/tasklist', 'ApiController@stafftasklist');
    Route::get('staff/posttask', 'ApiController@staffposttask');
    Route::get('staff/fetchtaskinfo', 'ApiController@fetchtaskinfo');
    Route::get('staff/fetchtaskstat', 'ApiController@fetchtaskstat');
    Route::get('staff/assigncourse', 'ApiController@assigncourse');
    Route::get('staff/createdailytask', 'ApiController@createdailytask');
    Route::get('staff/getdailytasks', 'ApiController@staffgetdailytasks');
    Route::get('staff/getdailytasktemplates', 'ApiController@staffgetdailytasktemplates');
    Route::get('staff/invitetotracker', 'ApiController@staffinvitetotracker');
    Route::get('staff/fetchtrackermembers', 'ApiController@stafffetchtrackermembers');
    Route::get('staff/removememberfromtracker', 'ApiController@staffremovememberfromtracker');
    Route::get('staff/deletetracker', 'ApiController@staffdeletetracker');

    // Master
    Route::get('master/newcourselist', 'ApiController@masternewcourselist');
    Route::get('master/fetchsubjectlist', 'ApiController@mastersubjectlist');
    Route::get('master/fetchcategorylist', 'ApiController@mastercategorylist');
    Route::get('master/fetchsubcategorylist', 'ApiController@mastersubcategorylist');
    Route::get('master/fetchcourselist', 'ApiController@mastercourselist');
    Route::get('master/fetchcourselistforinvite', 'ApiController@fetchcourselistforinvite');
    Route::get('master/fetchcourseinvites', 'ApiController@masterinvitelist');
    Route::get('master/libraryitems', 'ApiController@masterlibraryitems');
    Route::get('master/fetchcoursecode', 'ApiController@masterfetchcoursecode');
    Route::get('master/createclass', 'ApiController@mastercreateclass');
    Route::get('master/createsubject', 'ApiController@mastercreatesubject');
    Route::get('master/createcategory', 'ApiController@mastercreatecategory');
    Route::get('master/createsubcategory', 'ApiController@mastercreatesubcategory');
    Route::get('master/createcourse', 'ApiController@mastercreatecourse');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

// use App\Task;
// use App\Mytask;
// use Illuminate\Http\Request;


Route::group(['middleware' => ['web']], function () {
    Route::get('admin/login','TestController@hello');
    Route::post('admin/login','TestController@loginpost');
    


    Route::group(['middleware'=>'auth'], function(){

        Route::get('/update','TestController@update');

        Route::get('/','TestController@indexget');
        Route::get('admin','TestController@indexget');
        Route::get('logout','TestController@logout');

        

        Route::get('admin/changepassword','TestController@changepasswordget');
        Route::post('admin/changepassword','TestController@changepasswordpost');

        //tracker 
        Route::get('admin/tracker','TestController@trackerview');
        Route::get('admin/tracker/list','TestController@trackerlist');
        Route::post('admin/tracker/add','TestController@trackerviewAdd');
        Route::post('admin/tracker/addmultiple','TestController@trackerviewAddmultiple');

        //option type 

        Route::get('admin/optiontypeadd','TestController@optiontypeadd');
        Route::post('admin/optiontypeadddata','TestController@optiontypeadddata');
        Route::get('admin/optiontypelist','TestController@optiontypelist');
        Route::post('admin/optiontypestatus','TestController@optiontypestatus');
        Route::get('admin/optiontypeedit/{id}','TestController@optiontypeedit');
        Route::get('admin/optiontypedelete/{id}','TestController@optiontypedelete');
        Route::post('admin/optiontypeupdate','TestController@optiontypeupdate');

        Route::get('admin/tracker/daily/get','TestController@dailytasksstatustrackerget');
        Route::get('admin/tracker/daily/getdata','TestController@dailytasksstatustrackergetdata');
        Route::get('admin/tracker/daily/report/get','TestController@dailyTaskReportGet');
        Route::post('admin/tracker/report/post','TestController@taskstatustrackerreport');
        Route::post('admin/tracker/reportcolour/post','TestController@taskstatustrackerreportcolour');
        Route::get('/admin/tracker/edit/{id}','TestController@taskedit');
        Route::post('admin/tracker/report/save/post','TestController@taskTrackerSaveData');
        Route::post('admin/tracker/student/report/post','TestController@studenttrackerreport');
        Route::post('admin/tracker/taskname','TestController@gettaskname');
        Route::post('admin/tracker/tasknames','TestController@gettasknames');
        Route::post('admin/tracker/optionName','TestController@optionName');
        Route::get('admin/tracker/color','TestController@color');
        Route::post('/admin/tracker/addColorValue','TestController@addColorValue');
        Route::get('admin/tracker/option','TestController@option');
        Route::post('/admin/tracker/studentpercentange','TestController@studentpercentange');
        Route::post('admin/tracker/report/postdata','TestController@taskstatustrackerreportdata');
        Route::post('admin/tracker/report/save/postdata','TestController@taskTrackerSavepostdata');




        //Classes
        Route::get('admin/masters/classes/get','TestController@classesget');
        Route::post('admin/masters/classes/add/post','TestController@addclassespost');
        Route::post('admin/masters/classes/edit/post','TestController@editclassespost');
        Route::post('admin/masters/classes/delete/post','TestController@deleteclassespost');
        Route::post('admin/masters/classes/details/post','TestController@getclassespost');

         //Country
        Route::get('admin/masters/country/get','TestController@countryget');
        Route::post('admin/masters/country/add/post','TestController@addcountrypost');
        Route::post('admin/masters/country/edit/post','TestController@editcountrypost');
        Route::post('admin/masters/country/delete/post','TestController@deletecountrypost');
        Route::post('admin/masters/country/details/post','TestController@getcountrypost');

        //Subjects
        Route::get('admin/masters/subjects/get','TestController@subjectsget');
        Route::post('admin/masters/subjects/add/post','TestController@addsubjectspost');
        Route::post('admin/masters/subjects/edit/post','TestController@editsubjectspost');
        Route::post('admin/masters/subjects/delete/post','TestController@deletesubjectspost');
        Route::post('admin/masters/subjects/details/post','TestController@getsubjectspost');

        Route::get('getsubjects','TestController@getsubjectsget');
        Route::get('getcategories','TestController@getcategoriesget');
        Route::post('getcourses','TestController@getcoursesget');
        Route::get('getstaffs','TestController@getstaffsget');
        Route::get('getstudents','TestController@getstudentsget');

        //Category
        Route::get('admin/masters/category/get','TestController@categoryget');
        Route::post('admin/masters/category/add/post','TestController@addcategorypost');
        Route::post('admin/masters/category/edit/post','TestController@editcategorypost');
        Route::post('admin/masters/category/delete/post','TestController@deletecategorypost');
        Route::post('admin/masters/category/details/post','TestController@getcategorypost');

        //Courses
        Route::get("admin/masters/courses/get","TestController@coursesget");
        Route::post("admin/masters/courses/add/post","TestController@addcoursespost");
        Route::post("admin/masters/courses/details/post","TestController@getcoursespost");
        Route::post("admin/masters/courses/edit/post","TestController@editcoursespost");
        Route::post("admin/masters/courses/delete/post","TestController@deletecoursespost");

        //Staff
        Route::get("admin/staff/get","TestController@staffget");
        Route::post("admin/staff/add/post","TestController@addstaffpost");
        Route::post("admin/staff/details/post","TestController@getstaffpost");
        Route::post("admin/staff/edit/post","TestController@editstaffpost");
        Route::post("admin/staff/delete/post","TestController@deletestaffpost");

        //Student
        Route::get("admin/student/get","TestController@studentget");
        Route::post("admin/student/add/post","TestController@addstudentpost");
        Route::post("admin/student/details/post","TestController@getstudentpost");
        Route::post("admin/student/edit/post","TestController@editstudentpost");
        Route::post("admin/student/delete/post","TestController@deletestudentpost");

        //Groups
        Route::get('admin/groups/get','TestController@groupsget');
        Route::post('admin/groups/add/post','TestController@addgroupspost');
        Route::post('admin/groups/edit/post','TestController@editgroupspost');
        Route::post('admin/groups/delete/post','TestController@deletegroupspost');
        Route::post('admin/groups/details/post','TestController@getgroupspost');

        //Users
        Route::get('admin/users/get','TestController@usersget');
        Route::post('admin/users/delete/post','TestController@deleteuserspost');

        //Library
        Route::get('admin/library/get','TestController@libraryget');
        Route::post('admin/library/add/post','TestController@addlibrarypost');
        Route::post('admin/library/delete/post','TestController@deletelibrarypost');

        //Settings
        Route::get('admin/settings/get','TestController@settingsget');
        Route::post('admin/settings/add/post','TestController@addsettingspost');

        //Assign Course
        Route::get('admin/assign/course/get/{id?}/{panel?}/{course?}','TestController@assigncourseget');
        Route::post('admin/assign/courses/add/post','TestController@addassigncoursepost');
        Route::post('admin/assign/members/add/post','TestController@addassignmemberspost');
        Route::post('admin/assign/task/add/post','TestController@addassigntaskpost');
        Route::post('admin/assign/discussion/add/post','TestController@addassigndiscussionpost');
        Route::post('admin/assign/task/add/comment/post','TestController@addtaskcommentpost');
        Route::post('admin/assign/vote/add/post','TestController@addassignvotepost');
        Route::post('admin/assign/members/remove/post','TestController@removestudentfromcourse');
        Route::post('admin/assign/task/details','TestController@getgrouptaskdetails');
        Route::post('admin/assign/task/edit/post','TestController@editassigntaskpost');

        //Import Excel Sheet
        Route::get('admin/import/category/get','TestController@importcategoryget');
        Route::post('admin/import/category/add/post','TestController@importcategorypost');
        Route::get('admin/import/courses/get','TestController@importcoursesget');
        Route::post('admin/import/courses/add/post','TestController@importcoursespost');

        //Daily Tasks
        Route::get('admin/daily/tasks/get','TestController@dailytasksget');
        Route::post('admin/daily/tasks/add/post','TestController@adddailytaskspost');
        Route::post('admin/daily/tasks/edit/post','TestController@editdailytaskspost');
        Route::post("admin/daily/tasks/details/post","TestController@getdailytaskspost");
        Route::post("admin/daily/tasks/delete/post","TestController@deletedailytaskspost");
        Route::post('admin/daily/tasks/close/post','TestController@closetaskpost');

        Route::post('admin/daily/tasks/template/details','TestController@gettemplatedetails');


        //Daily Tasks Status
        Route::get('admin/daily/tasks/status/get','TestController@dailytasksstatusget');
        Route::post('admin/settings/status/add/post','TestController@addtaskstatus');
        Route::post('admin/daily/tasks/status/report/post','TestController@taskstatusreport');

        Route::post('admin/task/groups','TestController@gettaskgroups');

        Route::post('admin/student/daily/group/option/get','TestController@getdailygroupoptions');
        Route::post('admin/student/daily/task/status/get','TestController@getdailytaskstatuspost');

        Route::post('admin/student/daily/task/update/post','TestController@dailytaskupdatepost');

        Route::get('admin/student/courses/task/get','TestController@studentcoursetaskget');
        Route::post('admin/student/group/course/get','TestController@studentgroupcourseget');

        Route::post('admin/student/group/course/task/get','TestController@getstudentcoursetask');
        Route::post('admin/student/task/add/comment/post','TestController@addstudenttaskcommentpost');
        Route::post('admin/student/task/update/details/post','TestController@getdailytaskdetails');
        Route::post('admin/student/task/update/details/get','TestController@getdailytaskdetailsget');
        Route::post('admin/student/tasks/update/status/post','TestController@updatestudenttaskstatus');


        //Courses Status
        Route::get('admin/group/courses/status/get','TestController@groupcoursestatusget');
        Route::post('admin/group/courses/status/report/post','TestController@groupcoursestatusreport');
        Route::post('admin/student/courses/update/status/post','TestController@updatestudentcoursesstatus');

        //staff privilege
        Route::get('admin/user/privilege/get','TestController@userprivilege');
        Route::post('admin/user/privilege/post','TestController@getuserprivilege');
        Route::post('admin/user/privilege/save/post','TestController@saveuserprivilege');



        //Common
        Route::post('admin/class/subjects/get','TestController@getclasssubjects');
        Route::post('admin/class/category/get','TestController@getclasscategory');
        Route::post('admin/category/subcategory/get','TestController@getcategorysub');
        Route::post('admin/subcategory/courses/get','TestController@getsubcategorycourses');
        Route::post('admin/course/tasks/get','TestController@getcoursetasks');
        Route::post('admin/course/discussion/get','TestController@getcoursediscussion');
        Route::post('admin/subcategory/courses/all/get','TestController@getsubcategoryallcourses');

        //Report
        Route::get('admin/reports/courses/assigned/student/get','TestController@studentcoursesget');
        Route::post('admin/reports/courses/assigned/student/post','TestController@studentcoursespost');

        Route::get('admin/reports/staff/groups/get','TestController@staffgroupsget');
        Route::post('admin/reports/staff/groups/post','TestController@staffgroupspost');

        Route::get('admin/reports/staff/courses/get','TestController@staffcoursesget');
        Route::post('admin/reports/staff/courses/post','TestController@staffcoursespost');

        Route::get('admin/reports/completed/courses/get','TestController@completedcoursesget');
        Route::post('admin/reports/completed/courses/post','TestController@completedcoursespost');

        Route::get('admin/reports/pending/courses/get','TestController@pendingcoursesget');
        Route::post('admin/reports/pending/courses/post','TestController@pendingcoursespost');

        Route::get('admin/reports/overdue/courses/get','TestController@overduecoursesget');
        Route::post('admin/reports/overdue/courses/post','TestController@overduecoursespost');

        Route::get('admin/reports/masters/get','TestController@mastersget');
        Route::post('admin/reports/masters/post','TestController@masterspost');


        //Student Daily Tasks
        Route::get('admin/student/daily/tasks/get','TestController@studentdailytasksget');

        Route::post('admin/country/students/post','TestController@getcountrystudents');



        //Assign Course
        Route::get('admin/student/assign/course/get/{id?}/{panel?}/{course?}','TestController@studentassigncourseget');
        Route::post('admin/student/group/course/complete/post','TestController@studentcoursecompletepost');
        Route::post('admin/student/group/task/complete/post','TestController@studenttaskcompletepost');



    });

});


HTML::macro('display_error', function($errors)
    {
        $result='<div class="alert alert-danger">
                <p><ul>'.implode('', $errors->all('<li>:message</li>')).'</ul></p></div>';  
        return $result;
    });

    //Success Message display function

    HTML::macro('display_success', function($success)
    {
        $result='<div class="kode-alert kode-alert-icon alert3-light successMessage">
            <i class="fa fa-check"></i>
            <a href="javascript:void(0)" class="closed">×</a>'.Session::get($success).'</div>';
        return $result;
    });

    HTML::macro('activeStyleState', function($url)
    {
        return Request::is($url) ? 'yes' : 'no';
    });

    //active main link
    HTML::macro('activeState', function($url){ 
        return Request::is($url) ? 'active' : '';
    });

    //active ul div
    HTML::macro('ulState', function($url){ 
        return Request::is($url) ? 'display:block' : '';
    });
    //This function used for display current submenu in sidebar

    HTML::macro('clever_sublink', function($route, $text,$attr='_self') {
    if( Request::path() == $route ) {
        $active = "class = 'current'";
    }
    else {
        $active = "";
    }
    return '<li ' . $active . '>' . link_to($route, $text,array('target'=>$attr)) . '</li>';
    });

