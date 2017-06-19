<?php


	require '/redaxo/src/addons/slimdaxo/vendor/autoload.php';

	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;
	use \Firebase\JWT\JWT;



	class rex_api_slimdaxo extends rex_api_function
	{


		// open the frontend
		protected $published = true;

		// CONFIG Data
		protected $jwt_secretKey 	= null;


		// init
		public function execute()
		{
			$this->setConfig(); // set the config from redaxo

			$msg = '';
			$msg = $this->addSlim();
			$res = new rex_api_result(true, $msg);
			return $res;
		}


		// add slim frajmework
		public function addSlim()
		{
			$app = new \Slim\App;

			$app->add(new \Slim\Middleware\JwtAuthentication([
				"path" 			=> "/slimdaxo",
				"passthrough" 	=> "/slimdaxo/token",
				"secret" 		=> "supersecretkeyyoushouldnotcommittogithub"
			]));


			$app->group('/slimdaxo', function () {
				$this->map(['GET','POST'], '/token', function (Request $request, Response $response) {
					$now 	= new DateTime();
					$future = new DateTime("now +2 hours");
					$server = $request->getServerParams();
					$jti 	= base64_encode(openssl_random_pseudo_bytes(64));

					$payload = [
						"iat" => $now->getTimeStamp(),
						"exp" => $future->getTimeStamp(),
						"jti" => $jti,
						"sub" => rex::getServer()
					];

					$secret 			= 'supersecretkeyyoushouldnotcommittogithub';
					$token 				= JWT::encode($payload, $secret, "HS256");
					$data["token"] 		= $token;
					$data["expires"] 	= $future->getTimeStamp();

					return $response->withStatus(201)
						->withHeader("Content-Type", "application/json")
						->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
				});
			});

			// $app->group('/slimdaxo', function () {
			//
			// 	$app->post('/token', function (Request $request, Response $response) {
			//
			// 	});
			//
			// 	$this->map(['GET', 'POST'], '/link1', function (Request $request, Response $response) {
			// 	    $response->getBody()->write("Link 1");
			// 	    return $response;
			// 	});
			// 	$this->map(['GET', 'POST', 'PUT'], '/link2', function (Request $request, Response $response) {
			// 		if($request->isPut()) {
			// 	    	$data = ['text'=>'LINK 2 PUT'];
			// 		} else {
			// 			$data = ['text'=>'LINK 2'];
			// 		}
			// 	    $response = $response->withJson($data);
			// 	    return $response;
			// 	});
			//
			// });
			$app->run();

			exit;
		}


		private function setConfig() {
			$addon = rex_addon::get('slimdaxo');
			$this->jwt_secretKey 	= $addon->getConfig('slimdaxo_secretKey');
		}


	}
