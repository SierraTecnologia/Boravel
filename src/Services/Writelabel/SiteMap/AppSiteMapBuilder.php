<?php

namespace Boravel\Services\SiteMap;

use SiObject\Manipule\Managers\Photo\ARPhotoManager;
use SiObject\Manipule\Managers\Tag\ARTagManager;
use App\Models\Post;
use App\Models\Tag;
use Boravel\Services\SiteMap\Contracts\SiteMapBuilder as SiteMapBuilder;
use Illuminate\Support\Collection;
use SiObject\Mount\SiteMap\Contracts\Builder;
use SiObject\Mount\SiteMap\Item;
use function SiUtils\Helper\url_frontend;
use function SiUtils\Helper\url_frontend_photo;
use function SiUtils\Helper\url_frontend_tag;

/**
 * Class AppSiteMapBuilder.
 *
 * @package Boravel\Services\SiteMap
 */
class AppSiteMapBuilder implements SiteMapBuilder
{
    /**
     * @var Builder
     */
    private $siteMapBuilder;

    /**
     * @var ARPhotoManager
     */
    private $photoManager;

    /**
     * @var ARTagManager
     */
    private $tagManager;

    /**
     * AppSiteMapBuilder constructor.
     *
     * @param Builder $siteMapBuilder
     * @param ARPhotoManager $photoManager
     * @param ARTagManager $tagManager
     */
    public function __construct(Builder $siteMapBuilder, ARPhotoManager $photoManager, ARTagManager $tagManager)
    {
        $this->siteMapBuilder = $siteMapBuilder;
        $this->photoManager = $photoManager;
        $this->tagManager = $tagManager;
    }

    /**
     * @inheritdoc
     */
    public function build(): Builder
    {
        $items = collect();

        $items->push(
            (new Item)
                ->setLocation(url_frontend())
                ->setChangeFrequency('weekly')
                ->setPriority('1')
        );

        $items->push(
            (new Item)
                ->setLocation(url_frontend('/contact-me'))
                ->setChangeFrequency('monthly')
                ->setPriority('0.2')
        );

        $items->push(
            (new Item)
                ->setLocation(url_frontend('/subscription'))
                ->setChangeFrequency('monthly')
                ->setPriority('0.2')
        );

        (new Post)
            ->newQuery()
            ->whereIsPublished()
            ->chunk(50, function (Collection $posts) use ($items) {
                $posts->each(function (Post $post) use ($items) {
                    $items->push(
                        (new Item)
                            ->setLocation(url_frontend_photo($post->id))
                            ->setLastModified($post->updated_at->toAtomString())
                            ->setChangeFrequency('weekly')
                            ->setPriority('0.7')
                    );
                });
            });

        (new Tag)
            ->newQuery()
            ->defaultSelect()
            ->orderByPopularity()
            ->chunk(50, function (Collection $tags) use ($items) {
                $tags->each(function (Tag $tag) use ($items) {
                    $items->push(
                        (new Item)
                            ->setLocation(url_frontend_tag($tag->value))
                            ->setChangeFrequency('weekly')
                            ->setPriority('0.4')
                    );
                });
            });

        $this->siteMapBuilder->setItems($items->toArray());

        return $this->siteMapBuilder;
    }
}
