<?php
namespace Lelesys\Common\FlowProject\Aspect;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\AOP\JoinPointInterface;
use Neos\Flow\Http\Uri;
use Lelesys\Common\FlowProject\Traits\ApplicationVersionTrait;
use Neos\Utility\ObjectAccess;

/**
 * Class ResourceUriAspect
 *
 * @Flow\Scope("singleton")
 * @Flow\Aspect
 */
class ResourceUriAspect
{
    use ApplicationVersionTrait;

    /**
     * @Flow\InjectConfiguration("resourceUri.matchingRegex")
     * @var string
     */
    protected $uriMatchingRegex;

    /**
     * @Flow\InjectConfiguration("resourceUri.enabledPackages")
     * @var array
     */
    protected $enabledPackages;


    /**
     * Returns version number stored in the cache
     *
     * @Flow\Around("method(Neos\FluidAdaptor\ViewHelpers\Uri\ResourceViewHelper->render())")
     * @param JoinPointInterface $joinPoint
     * @return string
     */
    public function addApplicationVersionToResourceUri(JoinPointInterface $joinPoint)
    {
        $result = $joinPoint->getAdviceChain()->proceed($joinPoint);
        // not touching persistent resource uris
        if ($joinPoint->getMethodArgument('resource') !== null) {
            return $result;
        }
        $packageKey = $joinPoint->getMethodArgument('package');
        if ($packageKey === null) {
            $path = $joinPoint->getMethodArgument('path');
            if (strpos($path, 'resource://') === 0) {
                $packageUri = new Uri($path);
                $packageKey = $packageUri->getHost();
            } else {
                $controllerContext = ObjectAccess::getProperty($joinPoint->getProxy(), 'controllerContext', true);
                $packageKey = $controllerContext->getRequest()->getControllerPackageKey();
            }
        }
        if (! in_array($packageKey, $this->enabledPackages)) {
            return $result;
        }
        if (! preg_match($this->uriMatchingRegex, $result)) {
            return $result;
        }

        $uri = new Uri($result);
        if (strlen($uri->getQuery()) === 0) {
            $result .= '?v=' . $this->getApplicationVersion();
        } else {
            $result .= '&v=' . $this->getApplicationVersion();
        }
        return $result;
    }
}
