<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
        "name", "email", "motivation",
        "linkedin_url", "github_url", "english", "salary"
    ];
}
