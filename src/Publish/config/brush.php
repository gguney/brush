<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Size Properties
    |--------------------------------------------------------------------------
    | 
    | Size properties to change your image's size.
    | 
    */
    'do_resize' => true,
    'size_ratio' => 0.5,

    /*
    |--------------------------------------------------------------------------
    | Watermark Properties
    |--------------------------------------------------------------------------
    | 
    | Watermark properties to add watermark to your image.
    | 
    */
    'put_watermark' => true,
    'watermark_path' => public_path('images/watermark.png'),
    //'alpha' => 0.8,

    /*
    |--------------------------------------------------------------------------
    | Quality Properties
    |--------------------------------------------------------------------------
    | 
    | Quality properties to change your file size.
    | 
    */
    'change_quality' => true,
    'quality' => 20,

];