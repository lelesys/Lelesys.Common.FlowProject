<?php
namespace Lelesys\Common\FlowProject\Traits;

use TYPO3\Flow\Annotations as Flow;

/**
 * Trait ApplicationVersionTrait
 */
trait ApplicationVersionTrait
{

    /**
     * @Flow\Inject
     * @var \TYPO3\Flow\Cache\CacheManager
     */
    protected $_cacheManager;

    /**
     * @var integer
     */
    protected $_version = null;

    /**
     * Returns version number stored in the cache
     *
     * @return string
     */
    public function getApplicationVersion()
    {
        $generalCache = $this->_cacheManager->getCache('Lelesys_Common_FlowProject_General');
        if ($this->_version === null) {
            if ($generalCache->has('applicationVersion')) {
                $this->_version = $generalCache->get('applicationVersion');
            } else {
                $this->_version = (string)time();
                $generalCache->set('applicationVersion', $this->_version, [], 0);
            }
        }
        return $this->_version;
    }
}