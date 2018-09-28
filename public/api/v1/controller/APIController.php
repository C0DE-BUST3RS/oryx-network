<?php

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

		if ($this->authUser($key) == true) {
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


	// Check if the users API key is authenticated and active.

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

		if ($this->authUser($key) == true) {
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
			throw new RestException(404, "Not Found");
		}
	}

	// Update the total amount of calls made by user.

	/**
	 * Fetch all endpoints.
	 * @url GET /
	 * @return null|array
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

	/**
	 * Post a new article
	 * @url POST /articles
	 * @return null|array
	 */
	public function addArticle($data)
	{
		$name = $data->name;
		$author = $data->author;
		$text = $data->text;
		$result = null;

		$connection = DatabaseService::getInstance()->getConnection();
		$queryString = "INSERT INTO articles (`name`, `author`, `text`) VALUES (?, ?, ?)";
		$preparedQuery = $connection->prepare($queryString);
		$preparedQuery->bind_param("sss", $name, $author, $text);
		$preparedQuery->execute();

		// We want to know what the generated id is to be able to return it.
		$id = $connection->insert_id;

		if ($connection->errno === 0) {
			$result = ['id' => $id, 'name' => $name, 'author' => $author, 'text' => $text];
		}
		return $result;
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


