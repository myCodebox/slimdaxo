<?php


	require '/redaxo/src/addons/slimdaxo/vendor/autoload.php';

	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;
	use \Firebase\JWT\JWT;



	class rex_api_slimdaxo extends rex_api_function
	{


		// open the frontend
		protected $published = true;


		// init
		public function execute()
		{
			$msg = '';
			$msg = $this->addSlim();
			$res = new rex_api_result(true, $msg);
			return $res;
		}


		// add slim frajmework
		public function addSlim()
		{
			$app = new \Slim\App;
			$app->group('/slimdaxo', function () {

				$app->post('/auth', function (Request $request, Response $response) {

				});

				$this->map(['GET', 'POST'], '/link1', function (Request $request, Response $response) {
				    $response->getBody()->write("Link 1");
				    return $response;
				});
				$this->map(['GET', 'POST', 'PUT'], '/link2', function (Request $request, Response $response) {
					if($request->isPut()) {
				    	$data = ['text'=>'LINK 2 PUT'];
					} else {
						$data = ['text'=>'LINK 2'];
					}
				    $response = $response->withJson($data);
				    return $response;
				});

			});
			$app->run();
			exit;
		}

	}
