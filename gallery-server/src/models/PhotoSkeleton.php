<?php

class PhotoSkeleton
{
    public  $id;
    public  $user_id;
    public  $title;
    public  $description;
    public  $tags;
    public  $image_path;
    public  $created_at;

    public function __construct(
        int $id = 0,
        int $user_id = 0,
        $title = "",
        $description = "",
        $tags = "",
        $image_path = "",
        $created_at = ""
    ) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->title = $title;
        $this->description = $description;
        $this->tags = $tags;
        $this->image_path = $image_path;
        $this->created_at = $created_at;
    }
}
