<?php

namespace havennow\Support\Utils;

use havennow\Contracts\Support\Utils\Breadcrumb as BreadcrumbContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Illuminate\View\Factory as View;

class Breadcrumb implements BreadcrumbContract
{
    /**
     * Full path of crumbs.
     *
     * @var Collection
     */
    protected $path;

    /**
     * Breadcrumb constructor.
     */
    public function __construct()
    {
        $this->path = new Collection();
    }

    /**
     * Returns path collection.
     *
     * @return Collection
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Adds a crumb to the path.
     *
     * @param string $title
     * @param string|null $url
     * @return static
     */
    public function addCrumb($title, $url = null)
    {
        $this->path->push($this->createCrumb($title, $url));

        return $this;
    }

    /**
     * Renders the crumbs in the configured view.
     *
     * @return string
     */
    public function renderCrumbs()
    {
        $view = app()->make(View::class);
        $partial = config('ferrl.breadcrumb');

        $path = $this->path;
        $last = $this->path->last();

        return $view->make($partial, compact('path', 'last'))->render();
    }

    /**
     * Creates a new crumb.
     *
     * @param string $title
     * @param string|null $url
     * @return Fluent
     */
    protected function createCrumb($title, $url = null)
    {
        $crumb = new Fluent();
        $crumb->title = $title;
        $crumb->url = $url;

        return $crumb;
    }
}
