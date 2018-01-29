<?php
namespace Lelesys\Common\FlowProject\ViewHelpers;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
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