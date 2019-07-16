<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Teacher;
use DB;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
        $userId = Auth::id(); //current user
        $teachers = DB::table('teachers')
                    ->select(
                    'teachers.id as teacher_id',
                    'teachers.name as teacher_name',
                    'teachers.email as teacher_email',
                    'ratings.id as rating_id',
                    'rate','language','num_lession','notes'
                    )
                    ->leftJoin('ratings', 'ratings.teacher_id', '=', 'teachers.id')
                    ->get();
        return view('home', [ 'teachers' => $teachers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function formSubmit(Request $request)
    {
        
        $userId = Auth::id();
        $teacherId =  $request->input('teacherId');
        $rating = $request->input('rating');
        $note = $request->input('note');
        $language = $request->input('language');
        $lessonCount = $request->input('lessonCount');


        $data = array('user_id' => $userId, 'teacher_id' => $teacherId, 'rate' => $rating, 'language' => $language, 'num_lession' => $lessonCount , 'notes' => $note );
        $insert = DB::table('ratings')->insertGetId($data);

        $data['rating_id'] = $insert;
        return response()->json([$data]);
    }

    
    public function formSubmitUpdate(Request $request)
    {
        $userId = Auth::id();
        $teacherId =  $request->input('teacherId');
        $rating = $request->input('rating');
        $note = $request->input('note');
        $language = $request->input('language');
        $lessonCount = $request->input('lessonCount');
        $ratingID = $request->input('ratingID');

        $data = array('user_id' => $userId, 'teacher_id' => $teacherId, 'rate' => $rating, 'language' => $language, 'num_lession' => $lessonCount , 'notes' => $note );
        DB::table('ratings')
        ->where('id', $ratingID)
        ->update($data );
        return response()->json([$data]);
    }
}
