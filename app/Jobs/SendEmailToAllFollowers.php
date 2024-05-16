<?php

namespace App\Jobs;

use App\Mail\SendEmail;
use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailToAllFollowers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $document;
    public $content;
    /**
     * Create a new job instance.
     */
    public function __construct(Document $document,$content)
    {
        $this->content = $content;
        $this->document = $document;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $category = $this->document->category;
        $followers = $category->followers;
        foreach ($followers as $follower) {
            Mail::to($follower->user->email)->queue(new SendEmail($this->content));
        }
    }
}
