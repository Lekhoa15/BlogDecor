<?php

namespace App\Jobs;

use App\Http\Requests\TagRequest;
use App\Models\Tag;
use App\Services\SaveImageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateTag implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public static function fromRequest(TagRequest $request): self
    {
        return new static([
            'name' => $request->name(),
            'image' => $request->image(),
            'description' => $request->description(),
        ]);
    }

    /**
     * Execute the job.
     *
     * @return Tag|null
     */
    public function handle(): ?Tag
    {
        try {
            $tag = Tag::create([
                'name' => $this->data['name'],
                'description' => $this->data['description'],
            ]);

            if ($this->data['image']) {
                SaveImageService::UploadImage($this->data['image'], $tag, Tag::TABLE);
            }

            return $tag;
        } catch (\Exception $e) {
            // Log any errors if necessary
            return null;
        }
    }
}


