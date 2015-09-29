<?php

namespace CodeProject\Validators;


use Prettus\Validator\LaravelValidator;

class ProjectMemberValidator extends LaravelValidator
{
    protected $rules = [
        'member_id' => 'required|integer'
    ];
}