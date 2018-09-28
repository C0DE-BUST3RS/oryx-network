<?php

use Jacwright\RestServer\RestException;

class APIController
{

	/**
	 * @url GET /$key/users/$limit
	 * @param string $key, id $limit
	 * @return null|array
	 * @throws 401
	 */
	public function listUsers($key, $limit)
	{
		if ($this->authUser($key) == true) {
				$connection = DatabaseService::getInstance()->getConnection();
				$queryString = "SELECT `id`, `firstname`, `lastname`, `email`, `last_login` FROM user ORDER BY id DESC LIMIT $limit";
				$queryResult = $connection->query($queryString);

				if ($queryResult->num_rows > 0) {

					$users = array();
					while ($row = $queryResult->fetch_assoc()) {
						$users[] = $row;
					}

				return $users;
			}

		} else {
			throw new RestException(401,"Unauthorized");
		}

	}

	public function authUser($key)
	{
		$connection = DatabaseService::getInstance()->getConnection();
		$queryString = "SELECT `api-key`.active, `api-key`.value FROM `api-key` WHERE `value` = '$key' AND `active` = 1;";

		$queryResult = $connection->query($queryString);

		if ($queryResult->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Fetches a specific article from its id
	 * @url GET /articles/$id
	 * @param int $id
	 * @return null|array
	 */
	public function getArticle($id)
	{
		$connection = DatabaseService::getInstance()->getConnection();
		$queryString = "SELECT `id`, `name`, `author`, `text` FROM articles WHERE id=? LIMIT 1";
		$preparedQuery = $connection->prepare($queryString);
		$preparedQuery->bind_param("i", $id);
		$preparedQuery->execute();
		$queryResult = $preparedQuery->get_result();
		$article = $queryResult->fetch_assoc();


		return $article;
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


