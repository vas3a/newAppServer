<?php
namespace Wimp\AppBundle\Entity;

use Doctrine\Common\EventSubscriber,
	Doctrine\ORM\Event\LifecycleEventArgs,
	Doctrine\ORM\Events;

use Wimp\AppBundle\Entity\VideoModel;

class VideoListener implements EventSubscriber
{
	public function getSubscribedEvents()
	{
		return array(
			Events::postLoad,
		);
	}
	
	public function postLoad(LifecycleEventArgs $args)
	{
		$entity = $args->getEntity();
		$entityManager = $args->getEntityManager();

		// perhaps you only want to act on some "Product" entity
		if ($entity instanceof VideoModel) {
			$entity->setTitle('test');
		}
	}
}