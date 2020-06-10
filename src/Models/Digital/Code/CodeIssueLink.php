<?php

namespace Boravel\Models\Digital\Code;

use Boravel\Models\Model;

class CodeIssueLink extends Model
{
    protected $organizationPerspective = false;

    protected $table = 'code_issue_links';      

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'code_language_id',
        'status',
    ];
}