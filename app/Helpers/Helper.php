<?php

use App\Models\Branch;
use Illuminate\Support\Facades\Session;

function currentBranch()
{
    return Branch::find(Session::get('branch'));
}
