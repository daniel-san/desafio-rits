<?php

namespace App\Http\Controllers;

use App\Candidate;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CandidateController extends Controller
{

    public function __construct() {
        $this->middleware('auth', ['except' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|string|email',
            'motivation' => 'nullable',
            'linkedinUrl' => 'required',
            'githubUrl' => 'required',
            'english' => [
                'required',
                Rule::in(['starter', 'intermediate', 'advanced'])
            ],
            'salary' => 'required|numeric',
            'resume' => 'required|mimes:pdf,doc'
        ]);

        $candidate = new Candidate();
        $candidate->name = $request->name;
        $candidate->email = $request->email;
        $candidate->motivation = $request->motivation;
        $candidate->linkedin_url = $request->linkedinUrl;
        $candidate->github_url = $request->githubUrl;
        $candidate->english = $request->english;
        $candidate->salary = $request->salary;

        $resume_path = $request->file('resume')->store('public/resumes');
        $resume_path = str_replace('public/resumes/','', $resume_path);

        $candidate->resume = $resume_path;

        $candidate->save();

        return redirect('/')->with('success', "Seus dados foram recebidos com sucesso");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function show(Candidate $candidate)
    {
        return view('candidates.show')->with('candidate', $candidate);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function edit(Candidate $candidate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Candidate $candidate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Candidate $candidate)
    {
        //
    }
}
