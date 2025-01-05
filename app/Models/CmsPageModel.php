<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsPageModel extends Model
{
    use HasFactory;

    protected $table = 'cms_pages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'html_code',
        'style_code',
        'js_code',
        'slug',
        'menu',
        'order_by',
        'active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * The rules for validation.
     *
     * @return array
     */
    public static function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'html_code' => 'required|string',
            'style_code' => 'nullable|string',
            'js_code' => 'nullable|string',
            'slug' => 'required|string|max:255',
            'menu' => 'required|string|max:255',
            'order_by' => 'required|integer',
            'active' => 'required|boolean',
        ];
    }
}
