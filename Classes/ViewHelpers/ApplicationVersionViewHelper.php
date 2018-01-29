<?php
namespace Lelesys\Common\FlowProject\ViewHelpers;

use Neos\Flow\Annotations as Flow;
use Neos\FluidAdaptor\Core\ViewHelper\AbstractViewHelper;
use Lelesys\Common\FlowProject\Traits\ApplicationVersionTrait;

/**
 * Class ApplicationVersionViewHelper
 */
class ApplicationVersionViewHelper extends AbstractViewHelper
{

    use ApplicationVersionTrait;

    /**
     * Returns version number stored in the cache
     *
     * @return string
     */
    public function render()
    {
        return $this->getApplicationVersion();
    }
}