<?php
// Define default timezone.
date_default_timezone_set('Europe/Amsterdam');

use Jacwright\RestServer\RestException;

class APIController
{
	/**
	 * @url GET /$key/users/$limit
	 * @param string $key , string $limit
	 * @return null|array
	 * @throws 401
	 */
	public function listUsers($key, $limit)
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: access");
		header("Access-Control-Allow-Methods: GET");
		header("Access-Control-Allow-Credentials: true");
		header("Content-Type: application/json");

		if ($this->authUser($key) == true && $this->authExpiredCheck($key) == false) {
			$connection = DatabaseService::getInstance()->getConnection();
			$queryString = "SELECT `id`, `firstname`, `lastname`, `email`, `last_login` FROM user ORDER BY id DESC LIMIT ?";
			$preparedQuery = $connection->prepare($queryString);
			$preparedQuery->bind_param("i", $limit);
			$preparedQuery->execute();
			$queryResult = $preparedQuery->get_result();

			if ($queryResult->num_rows > 0) {
				// Update the amount of API calls the user has made.
				$this->updateAPICalls($key);

				// Make the array to put data into.
				$users = array();
				while ($row = $queryResult->fetch_assoc()) {
					$users[] = $row;
				}
				return $users;
			} else {
				throw new RestException(400, "Bad request");
			}
		} else {
			throw new RestException(401, "Unauthorized");
		}
	}

	public function authUser($key)
	{
		$connection = DatabaseService::getInstance()->getConnection();
		$queryString = "SELECT `api-key`.active, `api-key`.value FROM `api-key` WHERE `value` = ? AND `active` = 1;";
		$preparedQuery = $connection->prepare($queryString);
		$preparedQuery->bind_param("s", $key);
		$preparedQuery->execute();
		$queryResult = $preparedQuery->get_result();

		if ($queryResult->num_rows > 0) {
			// Update the amount of API calls the user has made.
			$this->updateAPICalls($key);
			return true;
		} else {
			new RestException(401, "Unauthorized");
			return false;
		}
	}

	public function updateAPICalls($key)
	{
		$connection = DatabaseService::getInstance()->getConnection();
		$queryString = "UPDATE `api-key` SET `used` = used + 1 WHERE `api-key`.`value` = ?;";
		$preparedQuery = $connection->prepare($queryString);
		$preparedQuery->bind_param("s", $key);
		$preparedQuery->execute();

		if ($connection->errno === 1) {
			new RestException(400, "Bad request");
		}
	}

	public function authExpiredCheck($key)
	{
		$connection = DatabaseService::getInstance()->getConnection();
		$queryString = "SELECT id, apikey, expire_date FROM `api-authenticate` WHERE `apikey` = ? ORDER BY id DESC;";
		$preparedQuery = $connection->prepare($queryString);
		$preparedQuery->bind_param("s", $key);
		$preparedQuery->execute();
		$queryResult = $preparedQuery->get_result();

		if ($queryResult->num_rows > 0) {
			while ($row = $queryResult->fetch_assoc()) {
				// Expire date from database.
				$expiry_date = $row['expire_date'];

				// get row id
				$rowID = $row['id'];

				// Current date.
				$currentDate = date("Y-m-d H:i:s");

				if ($expiry_date < $currentDate) {

					// If the API has expired then set authenticated to 0
					$queryString = "DELETE FROM `api-authenticate` WHERE id = ?;";
					//$queryString = "UPDATE `api-authenticate` SET `authenticated` = 0 WHERE `apikey` = ?;";
					$preparedQuery = $connection->prepare($queryString);
					$preparedQuery->bind_param("s", $rowID);
					$preparedQuery->execute();

					return true;
				} else {

					// If the API has not expired then set authenticated to 1
					$queryString = "UPDATE `api-authenticate` SET `authenticated` = 1 WHERE `apikey` = ?;";
					$preparedQuery = $connection->prepare($queryString);
					$preparedQuery->bind_param("s", $key);
					$preparedQuery->execute();

					return false;
				}
			}
		} else {
			new RestException(401, "Unauthorized");
			return true;
		}
	}

	/**
	 * Fetch information about a specific user.
	 * @url GET $key/user/profile/$userid
	 * @param string $key , string $userid
	 * @return null|array
	 * @throws 404
	 */
	public function getUserInfo($key, $userid)
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: access");
		header("Access-Control-Allow-Methods: GET");
		header("Access-Control-Allow-Credentials: true");
		header("Content-Type: application/json");

		if ($this->authUser($key) == true && $this->authExpiredCheck($key) == false) {
			$connection = DatabaseService::getInstance()->getConnection();
			$queryString = "SELECT * FROM profiles WHERE user_id = ? LIMIT 1";
			$preparedQuery = $connection->prepare($queryString);
			$preparedQuery->bind_param("s", $userid);
			$preparedQuery->execute();
			$queryResult = $preparedQuery->get_result();
			$userInfo = $queryResult->fetch_assoc();
			$this->updateAPICalls($key);

			return $userInfo;
		} else {
			throw new RestException(401, "Unauthorized");
		}
	}

	// Get user email with the api key.

	/**
	 * @url GET /$key/user/posts/$userid
	 * @param string $key , string $userid
	 * @return null|array
	 * @throws 401
	 */
	public function getUserPosts($key, $userid)
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: access");
		header("Access-Control-Allow-Methods: GET");
		header("Access-Control-Allow-Credentials: true");
		header("Content-Type: application/json");

		if ($this->authUser($key) == true && $this->authExpiredCheck($key) == false) {
			$connection = DatabaseService::getInstance()->getConnection();
			$queryString = "SELECT * FROM post WHERE user_id = ? ORDER BY id DESC";
			$preparedQuery = $connection->prepare($queryString);
			$preparedQuery->bind_param("s", $userid);
			$preparedQuery->execute();
			$queryResult = $preparedQuery->get_result();

			if ($queryResult->num_rows > 0) {
				// Update the amount of API calls the user has made.
				$this->updateAPICalls($key);

				// Make the array to put data into.
				$posts = array();
				while ($row = $queryResult->fetch_assoc()) {
					$posts[] = $row;
				}
				return $posts;
			} else {
				throw new RestException(400, "Bad request");
			}
		} else {
			throw new RestException(401, "Unauthorized");
		}
	}
	
	/**
	 * Fetch all endpoints.
	 * @url GET /
	 * @throws 404
	 */
	public function getAllEndpoints()
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: access");
		header("Access-Control-Allow-Methods: GET");
		header("Access-Control-Allow-Credentials: true");
		header("Content-Type: application/json");

		$datetime = new DateTime(null, new DateTimeZone('Europe/Amsterdam'));
		$unixtime = $datetime->getTimestamp();

		$ar = array(
			array(
				"issuer" => "https://www.oryx.network/",
				"issue_date" => $unixtime,
			),
			array(
				"supported_methods" => "GET, POST, PUT, DELETE, PATCH",
				"max_calls_per_minute" => 50,
			),
			"authorization_endpoint" => "https://oryx.network/api/v1/{APIKEY}",
			"fetch_all_users" => "https://www.oryx.network/api/v1/{APIKEY}/users/{LIMIT}",
			"fetch_user_profile" => "https://www.oryx.network/api/v1/{APIKEY}/user/profile/{USERID}",
		);
		echo json_encode($ar, JSON_FORCE_OBJECT);
	}

	// Update the total amount of api calls for user.

	/**
	 * Authenticate user
	 * @url POST /$key/$email
	 * @return null|array
	 * @throws 401
	 */
	public function authenticate($key, $email)
	{
		if ($this->authUser($key) == true && $this->alreadyAuth($key) == false) {
			// Get the POST api key.
			$apiKey = $key;

			if ($this->getEmail($key) == $email) {


				// Get current datetime.
				$currentDate = date("Y-m-d H:i:s");

				// Change the time to add +3 hours to authenticated
				$changeTime = strtotime($currentDate) + 10800; // Add 3 hours till expire
				$expireDate = date("Y-m-d H:i:s", $changeTime); // Back to string

				// Define variable to authenticate user.
				$authenticated = 1;

				// Define variable for result
				$result = null;

				if ($this->alreadyAuth($key) == true) {
					throw new RestException(401, "Unauthorized");
				} else {
					$connection = DatabaseService::getInstance()->getConnection();
					$queryString = "INSERT INTO `api-authenticate` (`id`, `apikey`, `authenticated`, `auth_date`, `expire_date`) VALUES (NULL, ?, ?, ?, ?)";
					$preparedQuery = $connection->prepare($queryString);
					$preparedQuery->bind_param("siss", $apiKey, $authenticated, $currentDate, $expireDate);
					$preparedQuery->execute();

					if ($connection->errno === 0) {
						$result = ['email' => $this->getEmail($key), 'apikey' => $apiKey, 'authenticated' => $authenticated, 'auth_date' => $currentDate, 'expire_date' => $expireDate];
					}
					return $result;
				}
			} else {
				throw new RestException(401, "Unauthorized");
			}
		} else {
			throw new RestException(401, "Unauthorized");
		}
	}

	// Check if the expire date of the authentication session has expired.

	public function alreadyAuth($key)
	{
		$connection = DatabaseService::getInstance()->getConnection();
		$queryString = "SELECT apikey,authenticated FROM `api-authenticate` WHERE `apikey` = ?;";
		$preparedQuery = $connection->prepare($queryString);
		$preparedQuery->bind_param("s", $key);
		$preparedQuery->execute();
		$queryResult = $preparedQuery->get_result();

		if ($queryResult->num_rows == 0) {
			return false;
		} else {
			return true;
		}
	}

	// Check if the API key already is authenticated.

	public function getEmail($key)
	{
		$connection = DatabaseService::getInstance()->getConnection();
		$queryString = "SELECT email FROM `api-key` WHERE `value` = ?";
		$preparedQuery = $connection->prepare($queryString);
		$preparedQuery->bind_param("s", $key);
		$preparedQuery->execute();
		$queryResult = $preparedQuery->get_result();
		$row = $queryResult->fetch_assoc();

		if ($queryResult->num_rows > 0) {
			// Update the amount of API calls the user has made.
			return $row['email'];
		} else {
			new RestException(401, "Unauthorized");
			return false;
		}
	}

	/**
	 * Remove an article from the database.
	 * @url DELETE /articles/$id
	 * @param null $id
	 * @return bool
	 */
	public function removeArticle($id = null)
	{
		$result = false;
		$connection = DatabaseService::getInstance()->getConnection();
		$queryString = "DELETE FROM articles WHERE `id` = ?";
		$preparedQuery = $connection->prepare($queryString);
		$preparedQuery->bind_param("i", $id);
		$preparedQuery->execute();
		if ($connection->errno === 0) {
			$result = true;
		}
		return $result;
	}


	// Public function to check if the user is Authenticated.

	/**
	 * Update an article with data
	 * @url PUT /articles/$id
	 * @param null $id
	 * @return array|bool
	 */
	public function updateArticle($id = null, $data)
	{
		$result = false;

		// First fetch the corresponding article (test if it's there in the first place)
		$connection = DatabaseService::getInstance()->getConnection();
		$queryString = "SELECT `id`, `name`, `author`, `text` FROM articles WHERE id=? LIMIT 1";
		$preparedQuery = $connection->prepare($queryString);
		$preparedQuery->bind_param("i", $id);
		$preparedQuery->execute();
		$queryResult = $preparedQuery->get_result();
		$article = $queryResult->fetch_assoc();

		// If we've got the article and there is no error thrown, we can update eacht field
		if ($connection->errno === 0 && isset($article)) {

			// See if the field is sent, else we leave the original in place
			$name = isset($data->name) ? $data->name : $article['name'];
			$author = isset($data->author) ? $data->author : $article['author'];
			$text = isset($data->text) ? $data->text : $article['text'];

			// Prepare query to just update all the fields.
			$queryString = "UPDATE articles SET `name` = ?, `author` = ?, `text` = ? WHERE `id` = ?";
			$preparedQuery = $connection->prepare($queryString);
			$preparedQuery->bind_param("sssi", $name, $author, $text, $id);
			$preparedQuery->execute();

			if ($connection->errno === 0) {
				// Simulate fetched article with updated PUT data
				$article['name'] = $name;
				$article['author'] = $author;
				$article['text'] = $text;
				return $article;
			}
		}

		return $result;

	}


}


