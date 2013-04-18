<?php

namespace Wimp\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use \StdClass;

class DefaultController extends Controller
{
	public function indexAction()
	{
		$videos = $this->getVideos(1);
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

	public function getVideosAction($id, Request $request)
	{
		$reversed = $request->query->get('reversed') === 'true';

		$videos = $this->getVideos($id, $reversed);
		
		return $this->doJSONResponse($videos);
	}

	private function getVideos($id, $reversed = false)
	{
		if(!$reversed){
			$min = max(1, $id-30);
			$max = $id+30;
		}else{
			$min = max(1, $id-30);
			$max = $id;
		}

		$videos = array();
		for($i = $min; $i < $max; $i++)
			if($i)
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

	public function searchVideosAction($searchWord)
	{
		$videos = array();
		for($i = 1; $i < rand(1, 15); $i++){
			$videos[] = (object) array(
				'id' => $i,
				'title' => 'First line of the Title For The '.$i.'th Video',
				'subtitle' => '( video author & extra credits )',
				'slug' => 'video-'.$i,
				'thumbImg' => '/bundles/wimpapp/css/images/video-thumbnail.png',
				'videoPath' => '/bundles/wimpapp/css/images/player.jpg',
				'videoURL' => '/bundles/wimpapp/videos/video_SD.mp4'
			);
		}
		// print_r(count($videos));die;
		return $this->doJSONResponse($videos);
	}

	private function doJSONResponse($data = array()){
		return new Response( 
			json_encode($data),
			200, 
			array('content-type' => 'application/json') 
		);
	}
}
