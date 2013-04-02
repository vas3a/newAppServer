<?php

namespace Wimp\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \StdClass;

class DefaultController extends Controller
{
	public function indexAction()
	{
		$videos = $this->getVideos();
		return $this->videoPage($videos);
	}

	public function viewAction($slug)
	{
		$id = $this->getVideoId($slug);
		$videos = $this->getVideos($id);
		return $this->videoPage($videos);
	}

	private function videoPage($videos)
	{
		return $this->render(
			'WimpAppBundle:Default:index.html.twig',
			array(
				'videos'=>json_encode($videos)
			)
		);
	}

	private function getVideoId($slug)
	{
		$slug = explode('-', $slug);
		return $slug[1];
	}

	private function getVideos($id = 0)
	{
		$min = max(0, $id-30);
		$max = $id+30;

		$videos = array();
		for($i = $min; $i < $max; $i++)
			$videos[] = (object) array(
				'id' => $i,
				'title' => 'First line of the Title For The '.$i.'th Video',
				'subtitle' => '( video author & extra credits )',
				'slug' => 'video-'.$i,
				'thumbImg' => '/bundles/wimpapp/css/images/video-thumbnail.png',
				'videoPath' => '/bundles/wimpapp/css/images/player.jpg',
				'videoURL' => '/bundles/wimpapp/videos/video_SD.mp4'
			);
		return $videos;
	}
}
