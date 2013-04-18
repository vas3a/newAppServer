<?php

namespace Wimp\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Wimp\AppBundle\Entity\VideoModel;
use \StdClass;

class VideoController extends Controller
{

	public function indexAction()
	{
		// $this->generateRows();die;
		$vr = $this->getDoctrine()->getRepository('WimpAppBundle:VideoModel');
		$videos = $vr->loadFirstVideos();
		return $this->videoPage($videos);
	}

	public function viewAction($slug)
	{
		$slug = urlencode($slug);
		$vr = $this->getDoctrine()->getRepository('WimpAppBundle:VideoModel');
		$videos = $vr->getVideosForSlug($slug);

		return $this->videoPage($videos);
	}

	private function videoPage($videos)
	{
		$serializer = $this->get('jms_serializer');
		$videos = $serializer->serialize($videos, 'json');
	
		return $this->render(
			'WimpAppBundle:Default:index.html.twig',
			array(
				'videos'=>json_encode($videos)
			)
		);
	}

	public function getVideosAction($id, Request $request)
	{
		$reversed = $request->query->get('reversed') === 'true';

		$vr = $this->getDoctrine()->getRepository('WimpAppBundle:VideoModel');
		$videos = $vr->getNextVideos($id, $reversed);
		
		return $this->doJSONResponse($videos);
	}

	public function searchVideosAction($searchWord)
	{
		$searchWord = str_replace(' ', '%', urldecode($searchWord));
		$vr = $this->getDoctrine()->getRepository('WimpAppBundle:VideoModel');
		$videos = $vr->getVideosBySearchWord($searchWord);

		return $this->doJSONResponse($videos);
	}

	public function randomizeVideosAction()
	{
		$vr = $this->getDoctrine()->getRepository('WimpAppBundle:VideoModel');
		$maxResults = $vr->getMaxResults();
		$videos = $vr->getVideosRandomized( end($maxResults[0]) );

		return $this->doJSONResponse($videos);
	}

	private function doJSONResponse($data = array()){
		$serializer = $this->get('jms_serializer');
		$data = $serializer->serialize($data, 'json');

		return new Response( $data, 200, array('content-type' => 'application/json') );
	}


	/** ________________________________________________________________________________ */

	protected function generateRows()
	{
		// for($i = 0; $i < 144; $i ++){
		// 	$video = new VideoModel;
		// 	$video
		// 		->setTitle($this->titles[$i])
		// 		->setSecondTitle('Test for the second title')
		// 		->setSlug(urlencode(str_replace(' ', '-', $this->titles[$i])))
		// 		->setThumbnailPath('/bundles/wimpapp/css/images/video-thumbnail.png')
		// 		->setVideoPath('/bundles/wimpapp/videos/video_SD.mp4');
		// 	$em = $this->getDoctrine()->getManager();
		// 	$em->persist($video);
		// }

		$videoDirectory = __DIR__.'/../Resources/public/videos';
		$videos = $this->getDirectoryList($videoDirectory);
		foreach ($videos as $videoName) {
			$video = new VideoModel;
			$video
				->setTitle($videoName)
				->setSecondTitle('Test for the second title')
				->setSlug(urlencode(str_replace(' ', '-', $videoName)))
				->setThumbnailPath('/bundles/wimpapp/css/images/video-thumbnail.png')
				->setVideoPath('/bundles/wimpapp/videos/'.$videoName);

			$em = $this->getDoctrine()->getManager();
			$em->persist($video);
		}

		$em->flush();
	}

	function getDirectoryList ($directory) 
	{
		// create an array to hold directory list
		$results = array();

		// create a handler for the directory
		$handler = opendir($directory);

		// open directory and walk through the filenames
		while ($file = readdir($handler)) {

		  // if file isn't this directory or its parent, add it to the results
		  if ($file != "." && $file != "..") {
		    $results[] = $file;
		  }

		}

		// tidy up: close the handler
		closedir($handler);

		// done!
		return $results;
	}

	private $titles = array(
		'When you\'re bored at the beach...',
		'How we found the giant squid.',
		'Cat hugs are the best.',
		'Speed flying from the Mont Blanc in the French Alps.',
		'This kid has soul.Apr 4 - Best moments compilation.',
		'Rethinking the golf cart.',
		'Awesome soccer save.',
		'Yorkie puppy plays patty cake.',
		'Justin Bieber\'s "Beauty and a Beat" in the Baroque style.Apr 3 - Some cats like to go fast.',
		'Joseph Gordon-Levitt on Jeopardy in 1997.',
		'This artist uses coffee cups as his canvas.',
		'Awesome dance performance by Quick Crew.',
		'Triple concerto from a faucet, water pipes and a fiddle.Apr 2 - The fastest way to put a swimming cap on.',
		'Crazy engineering.',
		'Very impressive pack leader.',
		'Saxophone battle in NYC subway.',
		'Sea lion bops to the music.Apr 1 - Peanut butter German Shepherd time.',
		'Best reaction possible to a daughter\'s pregnancy.',
		'Crows are incredible.',
		'Soil liquefaction in Japan.',
		'91-year-old woman follows her dreams and sings on national television.Mar 31 - Best NBA pass ever?',
		'This is a South Korean seesaw.',
		'Octopus Houdini.',
		'Richard Feynman\'s way of safe cracking.',
		'A creative music video by Diane Birch.Mar 30 - Italian Greyhound dog waits for his dinner.',
		'Awesome pool skills.',
		'26-year-old\'s curiosity saves the Apollo 12 launch.',
		'RC helicopter films Niagara Falls, Ontario.',
		'A rapping flight attendant on Southwest Airlines.Mar 29 - Two guys in their 90s race in the 100m dash.',
		'Call of Duty baby edition.',
		'Little girl plays with 14 German Shepherds.',
		'Impressive turntable skills by DJ Angelo. ',
		'Stunning timelapse of Earth from the ISS.Mar 28 - Shapeshifting is allowed in basketball?',
		'Old man easily lifts spinning heavy disk over head.',
		'Connecting European cities.',
		'Mama and baby panda wrestle playfully.Mar 27 - This video is surprisingly relaxing.',
		'Joe the courageous bunny.',
		'This man has great soccer skills.',
		'Laurel and Hardy dance to the Rolling Stones.',
		'Kid solves three Rubik\'s Cubes while juggling them.Mar 26 - Standing jump world record.',
		'You may never look at a ukulele the same way again by Jake Shimabukuro.',
		'Canadian news reporters...',
		'A dog is reunited with her owner after two years and hundreds of miles.',
		'Creativity, your brain, and the aha moment by Eric Kandel.Mar 25 - Tree golfer.',
		'Girl rocks a Hendrix song on a Korean instrument called the gayageum.',
		'Cat walks the dog home.',
		'How the very first neuroscience lecture feels.',
		'Making clay pottery with a potter\'s wheel.Mar 24 - A clever dancing airplane.',
		'Dramatic Japanese rice cake making.',
		'Mambo dogs.',
		'This little girl explains autism creatively.',
		'Two kids play the Beatles\'"Let It Be" on the cello and violin.Mar 23 - Woman accurately describes hail storm.',
		'The most well-trained cats ever?',
		'Interactive LED floor.',
		'Pump action Oreo separator.',
		'Ants create a lifeboat in the Amazon Jungle.Mar 22 - Best coin ever spent.',
		'Ninja cat slides down pole like a pro.',
		'Chef complains about his kitchen equipment.',
		'Ever wonder how directors decide to film something?',
		'Illuminating photography: From camera obscura to camera phone.Mar 21 - Unloading a truck Taiwan style.',
		'Guy won\'t give his girlfriend any ice cream.',
		'Culture shock for Amazon chief\'s son who left rainforest for New York.',
		'"Dueling Banjos" solo on a double necked guitar by Mark Kroos.',
		'Nadal and Stiller play against Del Potro and a little girl.Mar 20 - Helping out a friend.',
		'Animation in the 1930s.',
		'15 cool rat tricks.',
		'Graphene has extreme thermal conductivity.',
		'Man plays "Raindrops" on a hammered dulcimer.Mar 19 - Kathy Lee topples untoppleable mug.',
		'The future of glass technologies.',
		'Teaching a puppy how to catch.',
		'A magic trick for a homeless man.',
		'Nine-year-old discusses the meaning of life and the universe.Mar 18 - Video of a man exposed to a total vacuum.',
		'The most out of control umpires of all time.',
		'26-year-old woman hears for the first time.',
		'Urban wingsuit flying in Rio de Janeiro.',
		'Dog feeds orphaned lamb with bottle.Mar 17 - Tire ski jump.',
		'A guerilla gardener in South Central LA.',
		'Magic clerk on The Tonight Show.',
		'Precious pug puppies in a tub.',
		'Andrew Bird and Yo-Yo Ma improvise a melody after meeting each other.Mar 16 - Penguins being penguins.',
		'A guy screams "mashed potatoes" at different golf games.',
		'Possibly the best "Skyfall" cover yet by Our Last Night.',
		'Sculpting the hand by Philippe Faraut.',
		'This logging truck navigates a flooded road like a boss.Mar 15 - A cyclist meets a thirsty koala.',
		'Man jumps over a Lamborghini Murcielago.',
		'Snowmobile dam jump.',
		'Using vegetables to play Massive Attack\'s "Teardrop" by j.viewz.',
		'Your brain is more than a bag of chemicals.Mar 14 - You might not expect this voice from this guy.',
		'The most amazing beaver experience.',
		'Amazing one-handed pickup.',
		'Kid jumps into a puddle.',
		'We live in a cosmic shooting gallery by Neil deGrasse Tyson.Mar 13 - Paper is not dead.',
		'A friendly reminder to never overinflate your basketball.',
		'Teaching your boss to dance...',
		'A midnight encounter with a sea lion pup.',
		'How Mendel\'s pea plants helped us understand genetics.Mar 12 - A simple way to not get mugged...',
		'This thing is like the opposite of a stove.',
		'Never underestimate the power of a plucky little pony.',
		'Billy Joel and a Vanderbilt student perform impromptu duet of "New York State of Mind".',
		'When collaboration kills creativity.Mar 11 - Meanwhile in Bruges...',
		'How to green the world\'s deserts and reverse climate change.',
		'Child gives an encouraging message to a boy waiting for a kidney.',
		'Little dog goes shopping on two legs.',
		'DeAndre Jordan\'s monster alley-oop over Brandon Knight.Mar 10 - The story of \'Keep Calm and Carry On\'.',
		'Spying on polar bears.',
		'An impromptu piano act on Johnny Carson.',
		'Backyard track jump transfer...',
		'Wearable gesture control from Thalmic Labs.Mar 9 - A new concrete tent that can be erected quickly.',
		'We live in the future.',
		'This is what it\'s like being aircrew on a KC-130J.',
		'A family of pugs go sledding...',
		'Rock legends perform "While My Guitar Gently Weeps".Mar 8 - Holland dairy cows released to pasture after a long winter.',
		'Lamborghini Veneno revealed.',
		'The very rare quadruple kick.',
		'Brass band multitasker.',
		'The making of John Mayer\'s "Born and Raised" artwork.Mar 7 - Quick snow clean...',
		'How to fold a fitted sheet.',
		'Lion, tiger, and bear all live together.',
		'Junk mail in action.',
		'Stevie Wonder\'s "I Wish" acapella cover by Yeo Inhyeok.Mar 6 - The greatest pass in automotive history.',
		'A random ball pit and two complete strangers.',
		'The happiest elephant in the world.',
		'Building a school in the cloud.',
		'Gollum sings "Mad World" by Tears for Fears.Mar 5 - Flower girl does the most hilarious thing...',
		'Grandpa, were you a hero in the war?',
		'That\'s not a motocross bike mate...',
		'A lamb who\'s just a few hours old.',
		'Really mesmerizing: Black letter calligraphy by Seb Lester.Mar 4 - Six-year-old b-girl destroys the dance floor.',
		'A master of balance.',
		'Fiery looping rain on the Sun.',
		'How a fly flies.',
		'Three-year-old lipsyncs to Korn.Mar 3 - Will 3D printing change the world?',
		'Harry Potter in 99 seconds.',
		'Breakdancing kids.',
		'Motocross rider doesn\'t let paralysis stop him.',
		'Sacred Earth timelapse by Sean F. White.Mar 2 - Just mesmerizing: One brick at a time.',
		'Computer program reveals invisible motion in video.',
		'This is what happens when you switch from classical piano to electronic music.',
		'The most entertaining three minutes of rugby.',
		'This pup can howl.Mar 1 - Customer service in Japan... wait for it.',
		'Ultimate paintball duel with two Audis.',
		'Man and a wombat... together at last.',
		'iGlide dubstep dancing.',
		'How big is the Universe?'
	);
}
