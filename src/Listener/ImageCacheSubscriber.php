<?php
namespace  App\Listener;

use App\Entity\Photos;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Doctrine\Common\EventSubscriber;

class ImageCacheSubscriber implements EventSubscriber
{

    private $cache;

    private$uploader;

    public function __construct(CacheManager $cache,UploaderHelper $uploader)
    {
        $this->cache = $cache;
        $this->uploader = $uploader;
    }

    public function getSubscribedEvents()
    {
        return[
            'preRemove',
            'preUpdate'
        ];
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Photos)
        {
            return;
        }

        $this->cache->remove($this->uploader->asset($entity,'imageFile'));
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Photos)
        {
            return;
        }
        if ($entity->getImageFile() instanceof UploadedFile)
        {
            $this->cache->remove($this->uploader->asset($entity,'imageFile'));
        }
    }
}