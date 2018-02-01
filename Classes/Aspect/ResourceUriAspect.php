<?php
namespace Lelesys\Common\FlowProject\Aspect;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\AOP\JoinPointInterface;
use Neos\Flow\Http\Uri;
use Lelesys\Common\FlowProject\Traits\ApplicationVersionTrait;

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
     * @Flow\Around("method(Neos\Flow\ResourceManagement\ResourceManager->getPublicPackageResourceUri())")
     * @param JoinPointInterface $joinPoint
     * @return string
     */
    public function addApplicationVersionToResourceUri(JoinPointInterface $joinPoint)
    {
        $result = $joinPoint->getAdviceChain()->proceed($joinPoint);

        $packageKey = $joinPoint->getMethodArgument('packageKey');

        if (! (isset($this->enabledPackages[$packageKey]) && $this->enabledPackages[$packageKey] === true)) {
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
