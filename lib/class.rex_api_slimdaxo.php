<?php


	require_once rex_path::addon('slimdaxo', 'vendor/autoload.php');

	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;
	use \Firebase\JWT\JWT;



	class rex_api_slimdaxo extends rex_api_function
	{


		// open the frontend
		protected $published = true;

		// CONFIG Data
		protected static $jwt_secretKey = null;


		// init
		public function execute()
		{
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
				"secret" 		=> self::$jwt_secretKey
			]));


			$app->group('/slimdaxo', function () {
				$this->map(['GET','POST'], '/token', function (Request $request, Response $response) {

					$hash_b64	= rex_request('hash', 'string');
					$json_str 	= base64_decode($hash_b64);
					$json_arr 	= json_decode($json_str, true);

					$now 	= new DateTime();
					$future = new DateTime("now +2 hours");
					$server = $request->getServerParams();
					// $jti 	= base64_encode(openssl_random_pseudo_bytes(64));
					$jti 	= rex_addon::get('slimdaxo')->getConfig('slimdaxo_secretKey');

					$payload = [
						"iat" => $now->getTimeStamp(),
						"exp" => $future->getTimeStamp(),
						"jti" => $jti,
						"sub" => rex::getServer()
					];

					$secret 			= self::$jwt_secretKey;
					$token 				= JWT::encode($payload, $secret, "HS256");
					$data["token"] 		= $token;
					$data["expires"] 	= $future->getTimeStamp();

					return $response->withStatus(201)
						->withHeader("Content-Type", "application/json")
						->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
				});
			});


			$app->run();
			exit;
		}


		private static function setConfig() {
			$addon = rex_addon::get('slimdaxo');
			self::$jwt_secretKey = $addon->getConfig('slimdaxo_secretKey');
		}


	}
