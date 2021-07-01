<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AiAnalysisLog extends Model
{
    protected $table = 'ai_analysis_log';
    public $timestamps = false;
    protected $fillable = ['image_path', 'success', 'message', 'class', 'confidence', 'request_timestamp', 'response_timestamp'];
}
