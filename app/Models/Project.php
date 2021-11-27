<?php

namespace App\Models;

use \DateTimeInterface;
use App\Support\HasAdvancedFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Project extends Model implements HasMedia
{
    use HasAdvancedFilter;
    use SoftDeletes;
    use InteractsWithMedia;
    use HasFactory;

    public $table = 'projects';

    protected $appends = [
        'photo',
        'galery',
    ];

    protected $dates = [
        'start_date',
        'due_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $orderable = [
        'id',
        'name',
        'owner',
        'whatsapp',
        'start_date',
        'due_date',
    ];

    protected $filterable = [
        'id',
        'name',
        'owner',
        'whatsapp',
        'start_date',
        'due_date',
    ];

    protected $fillable = [
        'name',
        'owner',
        'address',
        'whatsapp',
        'start_date',
        'due_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $thumbnailWidth  = 50;
        $thumbnailHeight = 50;

        $thumbnailPreviewWidth  = 120;
        $thumbnailPreviewHeight = 120;

        $this->addMediaConversion('thumbnail')
            ->width($thumbnailWidth)
            ->height($thumbnailHeight)
            ->fit('crop', $thumbnailWidth, $thumbnailHeight);
        $this->addMediaConversion('preview_thumbnail')
            ->width($thumbnailPreviewWidth)
            ->height($thumbnailPreviewHeight)
            ->fit('crop', $thumbnailPreviewWidth, $thumbnailPreviewHeight);
    }

    public function getStartDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('project.date_format')) : null;
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = $value ? Carbon::createFromFormat(config('project.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDueDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('project.date_format')) : null;
    }

    public function setDueDateAttribute($value)
    {
        $this->attributes['due_date'] = $value ? Carbon::createFromFormat(config('project.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getPhotoAttribute()
    {
        return $this->getMedia('project_photo')->map(function ($item) {
            $media = $item->toArray();
            $media['url'] = $item->getUrl();
            $media['thumbnail'] = $item->getUrl('thumbnail');
            $media['preview_thumbnail'] = $item->getUrl('preview_thumbnail');

            return $media;
        });
    }

    public function getGaleryAttribute()
    {
        return $this->getMedia('project_galery')->map(function ($item) {
            $media = $item->toArray();
            $media['url'] = $item->getUrl();
            $media['thumbnail'] = $item->getUrl('thumbnail');
            $media['preview_thumbnail'] = $item->getUrl('preview_thumbnail');

            return $media;
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
