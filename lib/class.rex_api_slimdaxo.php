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
				$this->post('/token', function (Request $request, Response $response) {
					$data_req = $request->getParsedBody();
					$hash_b64 = filter_var($data_req['hash'], FILTER_SANITIZE_STRING);
					$hash_str = base64_decode($hash_b64);
					$hash_arr = json_decode($hash_str, true);

					if( is_array($hash_arr) && count($hash_arr) > 0 && slimdaxo::testUser($hash_arr) ) {
						$now    = new DateTime();
						$future = new DateTime("now +2 hours");
						$server = $request->getServerParams();
						// $jti    = base64_encode(openssl_random_pseudo_bytes(64));
						$jti    = rex_addon::get('slimdaxo')->getConfig('slimdaxo_secretKey');

						$payload = [
							"iat" => $now->getTimeStamp(),
							"exp" => $future->getTimeStamp(),
							"jti" => $jti,
							"sub" => rex::getServer()
						];

						$secret           = self::$jwt_secretKey;
						$token            = JWT::encode($payload, $secret, "HS256");
						$data["token"]    = $token;
						$data["expires"]  = $future->getTimeStamp();
						if( $hash_arr['typ'] == 'backend' ) {
							$data["hash"] = $hash_b64;
						}

						return $response->withStatus(201)
						->withHeader("Content-Type", "application/json")
						->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
					} else {
						return $response->withStatus(401);
					}
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
